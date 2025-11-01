<?php

namespace App\Controllers;
use App\Models\OrderModel;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home');
    }

    public function about(): string
    {
        return view('about');
    }

    public function policy(): string
    {
        return view('policy');
    }

    public function tnc(): string
    {
        return view('tnc');
    }
    
    public function booking(): string
    {
        return view('booking');
    }
    
    public function bookingdetail(): string
    {
        return view('bookingdetail');
    }
    
    public function bookingcustomerdetail(): string
    {
        return view('bookingcustomerdetail');
    }
    
    public function bookingConfirmation(): string
    {
        $data = [
            'order_id' => $this->request->getGet('order_id')
        ];
        
        return view('booking_confirmation', $data);
    }
    
    public function saveOrder()
    {
        // Add CORS headers for debugging
        $this->response->setHeader('Access-Control-Allow-Origin', '*');
        $this->response->setHeader('Access-Control-Allow-Methods', 'POST, GET, OPTIONS');
        $this->response->setHeader('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With');
        
        log_message('info', 'saveOrder method called');
        
        // Load the OrderModel and process the entire order
        $orderModel = new \App\Models\OrderModel();
        $result = $orderModel->processAndSaveOrder($this->request);
        
        // Return the result directly from the model
        return $this->response->setJSON($result);
    }
    
    public function checkPromoCode()
    {
        $this->response->setContentType('application/json');
        
        try {
            $rawInput = $this->request->getBody();
            $jsonData = json_decode($rawInput, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                return $this->response->setJSON([
                    'success' => false,
                    'valid' => false,
                    'message' => 'Invalid request data'
                ]);
            }
            
            $promoCode = trim($jsonData['promo_code'] ?? '');
            
            if (empty($promoCode)) {
                return $this->response->setJSON([
                    'success' => false,
                    'valid' => false,
                    'message' => 'Please enter a promo code'
                ]);
            }
            
            // Use raw MySQLi connection (same as your working databases)
            $mysqli = new \mysqli('localhost', 'root', '', 'easesarawak', 3306);
            
            if ($mysqli->connect_error) {
                log_message('error', 'MySQLi connection failed: ' . $mysqli->connect_error);
                return $this->response->setJSON([
                    'success' => false,
                    'valid' => false,
                    'message' => 'Database connection failed'
                ]);
            }
            
            // Prepare and execute query
            $stmt = $mysqli->prepare("SELECT * FROM promo_code WHERE code = ? AND is_deleted = 0");
            $stmt->bind_param("s", $promoCode);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 0) {
                $stmt->close();
                $mysqli->close();
                return $this->response->setJSON([
                    'success' => true,
                    'valid' => false,
                    'message' => 'Invalid promo code'
                ]);
            }
            
            $promoData = $result->fetch_assoc();
            $currentDateTime = date('Y-m-d H:i:s');
            
            // Check if promo code is active
            if ($promoData['validation_date'] > $currentDateTime) {
                $stmt->close();
                $mysqli->close();
                return $this->response->setJSON([
                    'success' => true,
                    'valid' => false,
                    'message' => 'This promo code is not yet active'
                ]);
            }
            
            // Check if promo code is not expired
            if ($promoData['expired_date'] < $currentDateTime) {
                $stmt->close();
                $mysqli->close();
                return $this->response->setJSON([
                    'success' => true,
                    'valid' => false,
                    'message' => 'This promo code has expired'
                ]);
            }
            
            // Promo code is valid
            $stmt->close();
            $mysqli->close();
            
            return $this->response->setJSON([
                'success' => true,
                'valid' => true,
                'discount' => isset($promoData['discount_percentage']) ? $promoData['discount_percentage'] : 20,
                'message' => 'Promo code applied successfully!'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Exception in checkPromoCode: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'valid' => false,
                'message' => 'Server error occurred'
            ]);
        }
    }
}