# Admin Portal Setup Guide

This guide explains how to set up and use the enhanced admin portal for the EASE Sarawak Luggage Services application.

## Overview

The admin portal provides comprehensive management tools for:
- **Dashboard**: Overview of key metrics and statistics
- **Users**: Customer management and analytics
- **Partners**: Partner relationship management
- **Locations**: Storage location and capacity management
- **Promo Codes**: Promotional campaign management
- **Orders**: Order tracking and fulfillment
- **Analytics**: Revenue, customer, and operational analytics
- **External Data**: Tourist arrivals, events, and market data

## File Structure

```
app/
├── Controllers/
│   ├── BaseAdminController.php          # Base controller with authentication
│   ├── AdminDashboard.php               # Main dashboard
│   ├── AdminUsers.php                   # User management
│   ├── AdminPartners.php                # Partner management
│   ├── AdminLocations.php               # Location management
│   ├── AdminPromo.php                   # Promo code management
│   ├── AdminOrders.php                  # Order management
│   └── AdminAnalytics.php               # Analytics and reports
├── Models/
│   ├── UserModel.php                    # User data model
│   ├── PartnerModel.php                 # Partner data model
│   ├── LocationModel.php                # Location data model
│   ├── PromoModel.php                   # Promo code data model
│   └── OrderModel.php                   # Order data model
└── Views/
    └── admin/
        ├── layout/                      # Shared layouts
        ├── dashboard.php                # Dashboard view
        ├── users/                       # User views
        ├── partners/                    # Partner views
        ├── locations/                   # Location views
        ├── promo/                       # Promo code views
        ├── orders/                      # Order views
        └── analytics/                   # Analytics views
```

## Routes

All admin routes are prefixed with `/admin/`:

### Dashboard
- `GET /admin/dashboard` - Main dashboard

### Users
- `GET /admin/users` - List all users
- `GET /admin/users/view/{id}` - View user details
- `GET /admin/users/search` - Search users

### Partners
- `GET /admin/partners` - List all partners
- `GET /admin/partners/create` - Create partner form
- `POST /admin/partners/store` - Store new partner
- `GET /admin/partners/edit/{id}` - Edit partner form
- `POST /admin/partners/update/{id}` - Update partner
- `GET /admin/partners/delete/{id}` - Delete partner (Superadmin only)
- `GET /admin/partners/performance/{id}` - View partner performance

### Locations
- `GET /admin/locations` - List all locations
- `GET /admin/locations/create` - Create location form
- `POST /admin/locations/store` - Store new location
- `GET /admin/locations/edit/{id}` - Edit location form
- `POST /admin/locations/update/{id}` - Update location
- `GET /admin/locations/delete/{id}` - Delete location (Superadmin only)
- `GET /admin/locations/storage/{id}` - View storage status

### Promo Codes
- `GET /admin/promo` - List all promo codes
- `GET /admin/promo/create` - Create promo form
- `POST /admin/promo/store` - Store new promo
- `GET /admin/promo/edit/{code}` - Edit promo form
- `POST /admin/promo/update/{code}` - Update promo
- `GET /admin/promo/delete/{code}` - Delete promo (Superadmin only)

### Orders
- `GET /admin/orders` - List all orders
- `GET /admin/orders/view/{id}` - View order details
- `POST /admin/orders/update-status/{id}` - Update order status

### Analytics
- `GET /admin/analytics/revenue` - Revenue analytics
- `GET /admin/analytics/customers` - Customer analytics
- `GET /admin/analytics/operations` - Operations analytics
- `GET /admin/analytics/external-data` - External data dashboard

## Authentication & Authorization

### Session Variables
The admin portal uses the following session variables:
- `isAdminLoggedIn` - Boolean indicating if user is authenticated
- `admin_id` - Staff ID of logged-in admin
- `admin_role` - Role of logged-in admin
- `admin_name` - Name of logged-in admin

### Roles
The system supports 5 admin roles with different permissions:
1. **Superadmin** - Full access to all features
2. **Admin** - Standard admin access
3. **Driver** - Delivery management
4. **Storage_Handler** - Storage operations
5. **Customer_Service** - Customer support

### Role-Based Access
Use the `hasRole()` method in controllers:
```php
if (!$this->hasRole('Superadmin')) {
    return $this->errorMessage('Unauthorized action', 'admin/dashboard');
}
```

## Creating Models

You need to create the following models in `app/Models/`:

### UserModel.php
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'Users';
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

### PartnerModel.php
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class PartnerModel extends Model
{
    protected $table = 'Partners';
    protected $primaryKey = 'partner_id';
    protected $allowedFields = [
        'name', 'commission_rate', 'type', 'contact_person', 'contact_email',
        'contact_phone', 'payment_terms', 'contract_start_date', 'contract_end_date',
        'is_active', 'address'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
    protected $updatedField = 'updated_date';
}
```

### LocationModel.php
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class LocationModel extends Model
{
    protected $table = 'Locations';
    protected $primaryKey = 'location_id';
    protected $allowedFields = [
        'name', 'category', 'address', 'total_capacity',
        'current_occupancy', 'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
}
```

### PromoModel.php
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class PromoModel extends Model
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

### OrderModel.php
```php
<?php
namespace App\Models;
use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table = 'Orders';
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
}
```

## Dashboard Widgets

The dashboard displays:
1. **Total Users** - Count of registered users
2. **Orders Today** - Today's order count
3. **Revenue This Month** - Current month revenue
4. **Pending Deliveries** - Active delivery count
5. **Active Partners** - Partner count
6. **Storage Occupancy** - Capacity utilization percentage
7. **Recent Orders** - Latest 10 orders
8. **Revenue Chart** - Last 7 days revenue trend

## Analytics Features

### Revenue Analytics
- Daily revenue breakdown
- Revenue by channel (direct, partner)
- Revenue by service type
- Commission tracking
- Customizable date ranges

### Customer Analytics
- Customer lifetime value (CLV)
- Customer segmentation by type
- Acquisition source tracking
- Top customers report
- Customer growth trends

### Operations Analytics
- Daily operations summary
- Delivery performance metrics
- On-time delivery rate
- Storage occupancy tracking
- Staff performance

### External Data
- Tourist arrival statistics
- Upcoming local events
- Hotel occupancy trends
- Market insights

## Next Steps

1. Create the model files in `app/Models/`
2. Create view files in `app/Views/admin/`
3. Add CSS/JS assets for admin interface
4. Set up authentication in Login controller
5. Test all CRUD operations
6. Configure role-based permissions

## Security Considerations

- All admin routes require authentication via `BaseAdminController`
- Sensitive operations (delete) require Superadmin role
- Input validation on all forms
- CSRF protection enabled
- SQL injection prevention via query builder
- Session management with secure cookies

## Support

For questions or issues, please refer to the main project documentation or contact the development team.
