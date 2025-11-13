# Database Seeders

This directory contains database seeder files for the EASE Sarawak Luggage Services application.

## Available Seeders

### Core Seeders
- **AdminsSeeder.php** - Seeds admin/staff accounts
- **UsersSeeder.php** - Seeds sample user/customer accounts
- **LocationsSeeder.php** - Seeds storage locations and hubs
- **PartnersSeeder.php** - Seeds partner businesses
- **PromoSeeder.php** - Seeds promotional codes
- **VehiclesSeeder.php** - Seeds delivery vehicles

### External Data Seeders
- **TouristArrivalsDataSeeder.php** - Seeds tourist arrival statistics
- **LocalEventsSeeder.php** - Seeds local events data

### Master Seeder
- **DatabaseSeeder.php** - Runs all seeders in the correct order

## Usage

### Seed All Tables (Recommended)
```bash
php spark db:seed DatabaseSeeder
```

### Seed Individual Tables
```bash
php spark db:seed AdminsSeeder
php spark db:seed UsersSeeder
php spark db:seed LocationsSeeder
php spark db:seed PartnersSeeder
php spark db:seed PromoSeeder
php spark db:seed VehiclesSeeder
php spark db:seed TouristArrivalsDataSeeder
php spark db:seed LocalEventsSeeder
```

## Seeding Order

The seeders must be run in the following order due to foreign key dependencies:

1. AdminsSeeder (required by PromoSeeder)
2. UsersSeeder
3. LocationsSeeder
4. PartnersSeeder
5. PromoSeeder (depends on Admins)
6. VehiclesSeeder
7. TouristArrivalsDataSeeder
8. LocalEventsSeeder

## Default Credentials

### Admin Accounts
- **Admin User**
  - Email: admin@easesarawak.com
  - Password: admin123
  - Role: Admin

- **Super Admin**
  - Email: superadmin@easesarawak.com
  - Password: superadmin123
  - Role: Superadmin

- **Driver**
  - Email: driver1@easesarawak.com
  - Password: driver123
  - Role: Driver

- **Storage Handler**
  - Email: handler1@easesarawak.com
  - Password: handler123
  - Role: Storage_Handler

### Sample Users
- john.doe@example.com
- jane.smith@example.com
- ahmad.hassan@example.com
- maria.garcia@example.com

## Notes

- All passwords are hashed using PHP's `password_hash()` function
- Sample data is based on the seed data from database.sql
- Additional seeders for Orders, Payments, Reviews, etc. can be created as needed
- Make sure to run migrations before seeding: `php spark migrate`
