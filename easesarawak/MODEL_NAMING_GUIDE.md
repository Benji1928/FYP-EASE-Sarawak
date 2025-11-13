# Model Naming Convention - Important Information

## The Difference

Your project has **TWO different naming conventions** because you have **TWO different database schemas**:

### 1. Old/Existing Schema (lowercase table names)
- Tables: `user`, `order`, `promo` (lowercase)
- Models: `User_model.php`, `Order_model.php` (underscore, lowercase class names)
- Used by: Existing `Admin` controller

### 2. New/Enhanced Schema (PascalCase table names)
- Tables: `Users`, `Orders`, `Promo`, `Partners`, `Locations` (PascalCase from database.sql)
- Models: Should be `User_model.php`, `Order_model.php` etc. (underscore files, but pointing to new tables)
- Used by: New admin controllers (`AdminUsers`, `AdminPartners`, etc.)

## Current Situation

### Existing Models (OLD schema):
```
app/Models/User_model.php      → points to table 'user' (old)
app/Models/Order_model.php     → points to table 'order' (old)
app/Models/Partner_model.php   → points to table 'Partners' (new) ✓
app/Models/Location_model.php  → points to table 'Locations' (new) ✓
app/Models/Promo_model.php     → MISSING (needs to be created)
```

### What You Have:
- ✅ `Partner_model.php` - correctly points to `Partners` table
- ✅ `Location_model.php` - correctly points to `Locations` table
- ❌ `User_model.php` - points to old `user` table (not `Users`)
- ❌ `Order_model.php` - points to old `order` table (not `Orders`)
- ❌ `Promo_model.php` - **MISSING** (needs creation)

## Solution Options

### Option 1: Update Existing Models (Recommended if migrating)
Update the existing models to point to the new table names:

**Update User_model.php:**
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class User_model extends Model
{
    protected $table = 'Users';  // Changed from 'user'
    protected $primaryKey = 'user_id';
    protected $allowedFields = [
        'first_name', 'last_name', 'email', 'phone', 'social', 'social_num',
        'nationality', 'customer_type', 'customer_segment', 'source_of_booking',
        'how_heard_about_us', 'total_bookings', 'lifetime_value',
        'customer_acquisition_cost', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
    protected $updatedField = 'updated_date';
}
```

**Update Order_model.php:**
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class Order_model extends Model
{
    protected $table = 'Orders';  // Changed from 'order'
    protected $primaryKey = 'order_id';
    protected $allowedFields = [
        'user_id', 'special', 'special_note', 'service_type', 'order_details_json',
        'dropoff_time', 'pickup_time', 'requested_delivery_time',
        'pickup_location_id', 'dropoff_location_id', 'pickup_location_type',
        'dropoff_location_type', 'order_status', 'promo_code', 'is_cancelled',
        'cancellation_reason', 'cancellation_time', 'base_price', 'insurance_fee',
        'delivery_fee', 'discount_amount', 'total_amount', 'number_of_bags',
        'has_oversized_bags', 'has_special_items', 'booking_channel',
        'booking_source', 'modified_by', 'payment_id', 'partner_id'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
    protected $updatedField = 'updated_date';

    // Keep existing method if needed
    public function getOrderWithUserById($order_id)
    {
        return $this->db->table('Orders o')
            ->select('o.*, u.first_name, u.last_name, a.staff_name AS modified_by_name')
            ->join('Users u', 'u.user_id = o.user_id')
            ->join('Admins a', 'a.staff_id = o.modified_by', 'left')
            ->where('o.order_id', $order_id)
            ->get()
            ->getRowArray();
    }
}
```

**Create Promo_model.php:**
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class Promo_model extends Model
{
    protected $table = 'Promo';
    protected $primaryKey = 'promo_code';
    protected $allowedFields = [
        'promo_code', 'discount_type', 'discount_value', 'start_date',
        'end_date', 'usage_limit', 'times_used', 'is_active', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
}
```

### Option 2: Keep Both (If keeping old system)
Create NEW model files for the new schema:

```
app/Models/
├── User_model.php           # OLD - points to 'user' table
├── Users_model.php          # NEW - points to 'Users' table
├── Order_model.php          # OLD - points to 'order' table
├── Orders_model.php         # NEW - points to 'Orders' table
└── Promo_model.php          # NEW - points to 'Promo' table
```

Then update admin controllers to use the new models:
```php
$this->userModel = new \App\Models\Users_model();  // Note the 's'
$this->orderModel = new \App\Models\Orders_model(); // Note the 's'
```

## Recommended Approach

**If you're migrating to the new database schema:**
1. Backup your old models
2. Update existing models to point to new tables (Option 1)
3. Create the missing `Promo_model.php`
4. Test all functionality
5. Run the new migrations and seeders

**If you need to maintain both systems:**
1. Keep old models as-is
2. Create new model files with different names (Option 2)
3. Update admin controller references

## Quick Create: Promo_model.php

Since this is missing, create it now:

**File: app/Models/Promo_model.php**
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class Promo_model extends Model
{
    protected $table = 'Promo';
    protected $primaryKey = 'promo_code';
    protected $allowedFields = [
        'promo_code', 'discount_type', 'discount_value', 'start_date',
        'end_date', 'usage_limit', 'times_used', 'is_active', 'created_by'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
}
```

## Testing

After updating/creating models, test:
```bash
# Run migrations
php spark migrate

# Seed data
php spark db:seed Database_seeder

# Test accessing a route
# Visit: http://localhost/easesarawak/admin/partners
```

## Summary

**Key Point**: The new admin controllers expect models that point to the **new PascalCase tables** (`Users`, `Orders`, `Partners`, etc.) from your `database.sql` file. Your existing models point to **old lowercase tables** (`user`, `order`).

You need to either:
- Update existing models to point to new tables, OR
- Create separate model files for the new schema

I recommend **Option 1** (update existing) if you're migrating to the new enhanced database schema.
