<?php

namespace App\Controllers;
use App\Models\OrderModel;

class Home extends BaseController
{
    public function index(): string
    {
        $db = \Config\Database::connect();
        $services = $db->table('service_management')->get()->getResultArray();

        // Set default prices in case table is empty
        $prices = [
            'storage' => 18,
            'delivery' => 24,
        ];
        foreach ($services as $service) {
            if (strtolower($service['service_type']) === 'storage') {
                $prices['storage'] = $service['base_price'];
            } elseif (strtolower($service['service_type']) === 'delivery') {
                $prices['delivery'] = $service['base_price'];
            }
        }

        return view('home', ['prices' => $prices]);
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

    public function payment(): string
    {
        return view('payment');
    }

    public function intowndelivery(): string 
    {
        return view('intowndelivery');
    }
}
