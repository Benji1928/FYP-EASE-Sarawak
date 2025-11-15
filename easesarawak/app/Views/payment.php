<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EASE SARAWAK | Payment</title>
    <link rel="icon" type="image/png" href="assets/images/cropped-Ease_PNG_File-09.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/footer_style.css">
    <link rel="stylesheet" href="assets/css/payment_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <script src="https://js.stripe.com/v3/"></script>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <img src="assets/images/Ease_PNG_File-01.png" alt="EASE Logo">
        </div>
        <div class="menu">
            <div class="dropdown">
                <a>Menu <i class="bi bi-chevron-down"></i></a>
                <div class="dropdown-content">
                    <a href="#">Our Services</a>
                    <a href="#">How It Works</a>
                    <a href="#">Why Us</a>
                    <a href="#">About Us</a>
                    <a href="#">Contact Us</a>
                </div>
            </div>
            <a href="#" class="btn">Book Now</a>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1>TRAVEL SMART WITH EASE</h1>
            <p>Whether you need secure storage or prompt delivery, we provide reliable and convenient solutions to ensure your journey is as smooth as possible.</p>
        </div>
    </section>


        <!-- Payment Section -->
        <div class="payment-section">
            <!-- Payment Form -->
            <div class="payment-form">
                <h2 class="section-title">Payment Information</h2>
                
                <div class="form-group">
                    <label for="cardName">Name on Card</label>
                    <input type="text" id="cardName" class="form-control" placeholder="John Doe">
                </div>
                
        <div class="form-group">
            <label>Card Number</label>
            <div id="card-number-element" class="form-control" style="padding: 10px 12px;"></div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Expiry Date</label>
                <div id="card-expiry-element" class="form-control" style="padding: 10px 12px;"></div>
            </div>
            <div class="form-group">
                <label>CVV</label>
                <div id="card-cvc-element" class="form-control" style="padding: 10px 12px;"></div>
            </div>
        </div>

        <div id="card-errors" style="color: red; margin-top: 8px; font-size: 0.9rem;"></div>

                
                <div class="form-group">
                    <label>Payment Method</label>
                    <div class="payment-methods">
                        <div class="payment-method">
                            <i class="bi bi-credit-card"></i>
                            <div>Credit Card</div>
                        </div>
                    </div>
                </div>
                
                <button class="btn-primary">Complete Payment</button>
            </div>
            
            <!-- Payment Summary -->
            <div class="payment-summary">
                <h2 class="section-title">Order Summary</h2>
                
                <div class="summary-item">
                    <span>In-Town Delivery</span>
                    <span>RM 25.00</span>
                </div>
                
                <div class="summary-item">
                    <span>Storage Fee (2 days)</span>
                    <span>RM 40.00</span>
                </div>
                
                <div class="summary-item">
                    <span>Service Tax</span>
                    <span>RM 5.00</span>
                </div>
                
                <div class="summary-total">
                    <span>Total</span>
                    <span>RM 70.00</span>
                </div>
                
                <div style="margin-top: 2rem;">
                    <h3 style="margin-bottom: 1rem;">Need Help?</h3>
                    <p>Contact our customer service:</p>
                    <p><i class="bi bi-telephone"></i> +60 12-345 6789</p>
                    <p><i class="bi bi-envelope"></i> easesarawak.com</p>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Payment method selection
        document.querySelectorAll('.payment-method').forEach(method => {
            method.addEventListener('click', function() {
                document.querySelectorAll('.payment-method').forEach(m => {
                    m.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>

<script>
  // Highlight selected payment method
  document.querySelectorAll('.payment-method').forEach(method => {
    method.addEventListener('click', function () {
      document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // 从 .env 读取 Stripe 公钥
  const STRIPE_PUBLISHABLE_KEY = "<?= esc(env('STRIPE_PUBLISHABLE_KEY')) ?>";
  const stripe = Stripe(STRIPE_PUBLISHABLE_KEY);
  const elements = stripe.elements();

  // 创建三个分拆的 Elements：卡号 / 有效期 / CVC
  const cardNumberElement = elements.create('cardNumber', { hidePostalCode: true });
  cardNumberElement.mount('#card-number-element');

  const cardExpiryElement = elements.create('cardExpiry');
  cardExpiryElement.mount('#card-expiry-element');

  const cardCvcElement = elements.create('cardCvc');
  cardCvcElement.mount('#card-cvc-element');

  // 显示错误信息
  const errorDiv = document.getElementById('card-errors');
  [cardNumberElement, cardExpiryElement, cardCvcElement].forEach(el => {
    el.on('change', function (event) {
      if (event.error) {
        errorDiv.textContent = event.error.message;
      } else {
        errorDiv.textContent = '';
      }
    });
  });

  // 点击 Complete Payment 按钮
  document.querySelector('.btn-primary').addEventListener('click', async function (e) {
    e.preventDefault();

    const cardName = document.getElementById('cardName').value.trim();
    if (!cardName) {
      alert('Please enter the name on card.');
      return;
    }

    const amountCents = 7000; // 这里先写死 RM70，你之后可以换成动态金额

    try {
      // 1️⃣ 先让你的服务器创建 PaymentIntent
      const intentRes = await fetch("<?= site_url('card-payment/intent') ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          amount: amountCents,
          currency: "myr",
          metadata: {
            card_name: cardName
          }
        })
      });

    if (!intentRes.ok) {
        const text = await intentRes.text();
        console.error('createIntent error', intentRes.status, text);
        alert(
            'Server error when creating payment.\n\n' +
            'Status: ' + intentRes.status + '\n' +
            text.slice(0, 300)   // 截前 300 字，通常就能看到具体错误
        );
        return;
    }


      const intentData = await intentRes.json();
      const clientSecret = intentData.client_secret;

      // 2️⃣ 在当前页面用 Stripe 完成扣款（使用 cardNumberElement）
      const { paymentIntent, error } = await stripe.confirmCardPayment(clientSecret, {
        payment_method: {
          card: cardNumberElement,          // 只需要传 cardNumber 元素
          billing_details: { name: cardName }
        }
      });

      if (error) {
        console.error(error);
        alert(error.message || 'Payment failed.');
        return;
      }

      if (paymentIntent.status !== 'succeeded') {
        alert('Payment status: ' + paymentIntent.status);
        return;
      }

      // 3️⃣ 扣款成功后，告诉你的服务器把 6 个字段写进数据库
      const storeRes = await fetch("<?= site_url('card-payment/store') ?>", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ payment_intent_id: paymentIntent.id })
      });

    if (!storeRes.ok) {
        const text = await storeRes.text();
        console.error('store error', storeRes.status, text);

    alert(
        'Payment succeeded, but failed to store in database.\n\n' +
        'Status: ' + storeRes.status + '\n' +
        text.slice(0, 400)   // 把后端返回的 JSON / 错误信息前 400 字显示出来
    );
    return;
      }

      alert('Payment processed successfully!');
      // 回到 bookingcustomerdetail
      window.location.href = '<?= base_url('bookingcustomerdetail') ?>';

    } catch (err) {
      console.error(err);
      alert(err.message || "Network error");
    }
  });
</script>


    <?= $this->include('footer/footer') ?>
</body>

</html>
