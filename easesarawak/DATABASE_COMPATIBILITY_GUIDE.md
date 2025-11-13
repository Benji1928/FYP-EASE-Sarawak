# Database Migration Compatibility Guide

## Overview
This guide explains the differences between the old and new database schemas and how to ensure compatibility across your project.

## Key Differences

### Table Name Changes
| Old Table Name | New Table Name | Notes |
|---------------|---------------|-------|
| `order` | `Orders` | PascalCase naming |
| `user` | `Users` | PascalCase naming |
| `promo_code` | `Promo` | Simplified name |

### Schema Changes

#### Users Table
**Old Schema:**
- `username` (VARCHAR)
- `password` (VARCHAR)
- `role` (INT or VARCHAR)
- `is_deleted` (TINYINT)

**New Schema:**
- `first_name` (VARCHAR)
- `last_name` (VARCHAR)
- `email` (VARCHAR, unique)
- `phone` (VARCHAR)
- `nationality` (VARCHAR)
- `customer_type` (ENUM: 'tourist', 'local', 'business')
- `password` (VARCHAR) - for admin users only
- NO `is_deleted` field (needs to be added for compatibility)

#### Orders Table
**Old Schema:**
- `order_id` (INT)
- `amount` (DECIMAL)
- `status` (INT: 0=Pending, 1=In Progress, 2=Completed)
- `first_name`, `last_name`, `email`, `phone` (denormalized)
- `is_deleted` (TINYINT)
- `comment` (TEXT)
- `modified_by`, `modified_date`

**New Schema:**
- `order_id` (INT)
- `user_id` (INT, foreign key)
- `service_type` (ENUM: 'Delivery', 'Storage', 'Storage_Delivery', 'Transfer')
- `order_details_json` (LONGTEXT) - contains all order details
- `payment_id` (INT)
- `promo_code` (VARCHAR)
- `total_amount` (DECIMAL)
- `status` (ENUM: 'Pending', 'Confirmed', 'In_Progress', 'Completed', 'Cancelled')
- NO `is_deleted`, `comment`, `modified_by` fields

#### Promo Table
**Old Schema:**
- `promo_code` table with fields:
  - `code` (VARCHAR)
  - `discount_percentage` (DECIMAL)
  - `validation_date` (DATETIME)
  - `expired_date` (DATETIME)
  - `is_deleted` (TINYINT)

**New Schema:**
- `Promo` table with fields:
  - `promo_code` (VARCHAR, primary key)
  - `discount_type` (ENUM: 'percentage', 'fixed')
  - `discount_value` (DECIMAL)
  - `start_date` (DATETIME)
  - `end_date` (DATETIME)
  - `usage_limit` (INT)
  - `times_used` (INT)
  - `is_active` (BOOLEAN)

## Required Updates

### 1. Add Missing Fields to Migrations

Add `is_deleted` field to Users and Orders tables for backward compatibility:

```php
// In create_users migration
'is_deleted' => [
    'type' => 'TINYINT',
    'constraint' => 1,
    'default' => 0,
],

// In create_orders migration
'is_deleted' => [
    'type' => 'TINYINT',
    'constraint' => 1,
    'default' => 0,
],
'comment' => [
    'type' => 'TEXT',
    'null' => true,
],
```

### 2. Update Controllers

#### Admin.php
- Replace `table('order')` with `table('Orders')`
- Update field references:
  - `amount` → `total_amount`
  - Status values: INT (0,1,2) → ENUM ('Pending','Confirmed','In_Progress','Completed')

#### Home.php
- Replace `promo_code` table with `Promo`
- Update field names:
  - `code` → `promo_code` (as column to search)
  - `validation_date` → `start_date`
  - `expired_date` → `end_date`
  - `is_deleted` → `is_active` (inverted logic: `is_active = 1` instead of `is_deleted = 0`)

#### Login.php
- Already uses User_model correctly
- May need to add `username` field or use email for login

### 3. Update Models

#### User_model.php
Add support for soft deletes:
```php
protected $useSoftDeletes = true;
protected $deletedField = 'is_deleted';
```

#### Order_model.php
Update to handle new schema while maintaining compatibility:
```php
protected $allowedFields = [
    'user_id', 'service_type', 'order_details_json',
    'payment_id', 'promo_code', 'total_amount', 'status',
    'is_deleted', 'comment'
];
```

### 4. Data Migration Script

If you have existing data, create a migration script to:
1. Copy user data from old `user` table to new `Users` table
2. Copy order data, mapping old fields to new structure
3. Convert promo codes from old format to new

## Testing Checklist

- [ ] Login functionality works with new Users table
- [ ] Orders display correctly in admin dashboard
- [ ] Revenue calculations use `total_amount` field
- [ ] Promo code validation works with new Promo table
- [ ] Soft delete functionality works for users and orders
- [ ] All existing views render correctly with new field names

## Migration Commands

```bash
# Reset database (WARNING: Deletes all data)
php spark migrate:rollback
php spark migrate

# Seed with sample data
php spark db:seed Database_seeder

# Check migration status
php spark migrate:status
```

## Notes

- The new schema uses ENUM types extensively for better data validation
- JSON storage (`order_details_json`) replaces denormalized fields
- Soft deletes should be implemented consistently across all tables
- PascalCase table names align with CodeIgniter 4 conventions
