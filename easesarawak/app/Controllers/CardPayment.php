<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaymentModel;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class CardPayment extends BaseController
{
    protected $payments;

    public function __construct()
    {
        $this->payments = new PaymentModel();
    }

    protected function initStripe(): void
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
    }

    /**
     * POST /card-payment/intent
     * Body: { amount: 7000, currency: "myr", metadata: {...} }
     * 作用：创建 PaymentIntent，返回 client_secret
     */
    public function createIntent()
    {
        $body = $this->request->getJSON(true) ?? $this->request->getPost();
        $amount = intval($body['amount'] ?? 0);    // sen / cents

        if ($amount <= 0) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON(['error' => 'Invalid amount']);
        }

        $currency = strtolower($body['currency'] ?? 'myr');
        $metadata = $body['metadata'] ?? [];

        $this->initStripe();

        try {
            $pi = PaymentIntent::create([
                'amount'   => $amount,
                'currency' => $currency,
                'automatic_payment_methods' => ['enabled' => true],
                'metadata' => $metadata,
            ]);

            return $this->response->setJSON([
                'client_secret' => $pi->client_secret,
                'payment_intent_id' => $pi->id,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Stripe createIntent error: {msg}', ['msg' => $e->getMessage()]);
            return $this->response
                ->setStatusCode(500)
                ->setJSON(['error' => 'Unable to create payment intent.']);
        }
    }

    /**
     * POST /card-payment/store
     * Body: { payment_intent_id: "pi_xxx" }
     *  Stripe take PaymentIntent field，write in payments database
     */
   public function store()
{
    //  payment_intent_id take from payment
    $body = $this->request->getJSON(true) ?? [];
    $piId = $body['payment_intent_id'] ?? null;

    if (!$piId) {
        return $this->response
            ->setStatusCode(422)
            ->setJSON(['error' => 'Missing payment_intent_id']);
    }

    // 初始化 Stripe
    $this->initStripe();

    try {
        // 从 Stripe 再查一次 PaymentIntent，拿到金额、货币、状态、charge id
        $pi = PaymentIntent::retrieve($piId);

        // 取 charge id（有些场景 latest_charge 是字符串，有些是对象）
        $chargeId = null;
        if (!empty($pi->latest_charge)) {
            $chargeId = is_string($pi->latest_charge)
                ? $pi->latest_charge
                : ($pi->latest_charge->id ?? null);
        }

        // 要插入到 payments 表的 6 个字段
        $data = [
            'stripe_payment_id' => $chargeId,                                    // ch_...
            'payment_intent_id' => $pi->id,                                      // pi_...
            'amount_cents'      => $pi->amount_received ?? $pi->amount ?? 0,
            'currency'          => $pi->currency ?? 'myr',
            'status'            => $pi->status ?? 'unknown',
        ];

        // 使用 insert() 明确做“新增”
        if (! $this->payments->insert($data)) {
            // 如果 Model 验证失败或者 DB 插入失败，这里会返回错误数组
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'error'   => 'DB insert failed',
                    'details' => $this->payments->errors(),
                ]);
        }

        return $this->response->setJSON(['ok' => true]);

    } catch (\Throwable $e) {
        // 把真实错误写日志，同时返回给前端
        log_message('error', 'Stripe store error: {msg}', ['msg' => $e->getMessage()]);

        return $this->response
            ->setStatusCode(500)
            ->setJSON(['error' => $e->getMessage()]);
        }
    }
}
