<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Database_seeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks to allow truncating
        $this->db->disableForeignKeyChecks();

        // Truncate tables in reverse order (respecting foreign keys)
        $this->db->table('Reviews')->truncate();
        $this->db->table('Delivery')->truncate();
        $this->db->table('LuggageItems')->truncate();
        $this->db->table('Travel_Documents')->truncate();
        $this->db->table('Orders')->truncate();
        $this->db->table('Payments')->truncate();
        $this->db->table('Promo')->truncate();
        $this->db->table('Partners')->truncate();
        $this->db->table('Locations')->truncate();
        $this->db->table('Users')->truncate();
        $this->db->table('Admins')->truncate();
        $this->db->table('Tourist_Arrivals_Data')->truncate();
        $this->db->table('Local_Events')->truncate();

        // Re-enable foreign key checks
        $this->db->enableForeignKeyChecks();

        // Run seeders
        $this->call('Admins_seeder');
        $this->call('Users_seeder');
        $this->call('Locations_seeder');
        $this->call('Partners_seeder');

        $this->call('Promo_seeder');

        $this->call('Tourist_arrivals_data_seeder');
        $this->call('Local_events_seeder');

        $this->call('Payments_seeder');

        $this->call('Orders_seeder');

        $this->call('Travel_documents_seeder');
        $this->call('Luggage_items_seeder');
        $this->call('Delivery_seeder');
        $this->call('Reviews_seeder');
    }
}
