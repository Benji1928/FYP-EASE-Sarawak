<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Travel_documents_seeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'order_id'       => 1,
                'doc_type'       => 'Passport',
                'file_name'      => 'john_doe_passport.pdf',
                'file_path'      => '/uploads/documents/john_doe_passport.pdf',
                'uploaded_date'  => date('Y-m-d H:i:s'),
                'verified'       => 1,
                'notes'          => 'Verified and valid',
            ],
            [
                'order_id'       => 2,
                'doc_type'       => 'Visa',
                'file_name'      => 'jane_smith_visa.pdf',
                'file_path'      => '/uploads/documents/jane_smith_visa.pdf',
                'uploaded_date'  => date('Y-m-d H:i:s'),
                'verified'       => 0,
                'notes'          => 'Pending verification',
            ],
            [
                'order_id'       => 3,
                'doc_type'       => 'Ticket',
                'file_name'      => 'ahmad_ticket.pdf',
                'file_path'      => '/uploads/documents/ahmad_ticket.pdf',
                'uploaded_date'  => date('Y-m-d H:i:s'),
                'verified'       => 1,
                'notes'          => 'Flight ticket verified',
            ],
            [
                'order_id'       => 4,
                'doc_type'       => 'Insurance',
                'file_name'      => 'maria_insurance.pdf',
                'file_path'      => '/uploads/documents/maria_insurance.pdf',
                'uploaded_date'  => date('Y-m-d H:i:s'),
                'verified'       => 1,
                'notes'          => 'Insurance coverage confirmed',
            ],
        ];

        $this->db->table('Travel_Documents')->insertBatch($data);
    }
}
