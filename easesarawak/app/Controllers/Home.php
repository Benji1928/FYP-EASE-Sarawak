<?php

namespace App\Controllers;

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
        // Set response header for JSON
        $this->response->setContentType('application/json');

        try {
            // Get raw POST data
            $rawData = $this->request->getBody();
            $jsonData = json_decode($rawData, true);
            
            // Log the incoming data for debugging
            log_message('info', 'Received order data: ' . $rawData);
            
            if (!$jsonData) {
                return $this->response->setJSON(['success' => false, 'message' => 'Invalid JSON data received']);
            }
            
            // Validate required fields
            $requiredFields = ['first_name', 'last_name', 'id_num', 'email', 'phone', 'social', 'social_num', 'service_type', 'order_details_json'];
            $missingFields = [];
            
            foreach ($requiredFields as $field) {
                if (!isset($jsonData[$field]) || empty($jsonData[$field])) {
                    $missingFields[] = $field;
                }
            }
            
            if (!empty($missingFields)) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Missing required fields: ' . implode(', ', $missingFields)
                ]);
            }

            // Load database
            $db = \Config\Database::connect();
            
            // Prepare data for insertion - keeping id_num as string
            $orderData = [
                'service_type' => trim($jsonData['service_type']),
                'first_name' => trim($jsonData['first_name']),
                'last_name' => trim($jsonData['last_name']),
                'id_num' => trim($jsonData['id_num']), // Keep as string - no conversion
                'email' => trim($jsonData['email']),
                'phone' => (int)$jsonData['phone'], // Convert to int as per your table
                'social' => $this->getSocialTypeId($jsonData['social']), // Convert to int ID
                'social_num' => (int)$jsonData['social_num'], // Convert to int as per your table
                'upload' => '', // Empty string for now since file upload is optional
                'special' => null, // NULL for now
                'special_note' => null, // NULL for now
                'order_details_json' => $jsonData['order_details_json'],
                'promo_code' => '', // Empty string for now
                'status' => 0, // Default status (0 = pending)
                'amount' => 0, // Will calculate later
                'payment_method' => '', // Empty for now since we're not processing payment
                'is_deleted' => 0, // Default not deleted
                'created_date' => date('Y-m-d H:i:s'),
                'modified_date' => null
            ];

            // Log the data being inserted
            log_message('info', 'Inserting order data into order table');
            log_message('info', 'Data: ' . json_encode($orderData));

            // Insert into order table
            $builder = $db->table('order');
            $result = $builder->insert($orderData);

            if ($result) {
                $orderId = $db->insertID();
                log_message('info', 'Order saved successfully with ID: ' . $orderId);
                
                return $this->response->setJSON([
                    'success' => true, 
                    'message' => 'Order saved successfully',
                    'order_id' => $orderId
                ]);
            } else {
                $error = $db->error();
                log_message('error', 'Database insert failed: ' . json_encode($error));
                
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Failed to save order to database: ' . $error['message']
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Exception in saveOrder: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Server error: ' . $e->getMessage()
            ]);
        }
    }

    // Helper function to convert social platform names to IDs
    private function getSocialTypeId($socialType)
    {
        $socialTypes = [
            'whatsapp' => 1,
            'wechat' => 2,
            'line' => 3
        ];
        
        return isset($socialTypes[$socialType]) ? $socialTypes[$socialType] : 1; // Default to WhatsApp
    }
}
