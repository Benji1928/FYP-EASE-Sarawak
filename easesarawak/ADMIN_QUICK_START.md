# Admin Portal - Quick Start Guide

## What Has Been Created

✅ **7 Admin Controllers** with full CRUD operations:
1. `BaseAdminController.php` - Authentication & base functionality
2. `AdminDashboard.php` - Main dashboard with statistics
3. `AdminUsers.php` - User management
4. `AdminPartners.php` - Partner management with performance tracking
5. `AdminLocations.php` - Location & storage management
6. `AdminPromo.php` - Promo code management
7. `AdminOrders.php` - Order management & tracking
8. `AdminAnalytics.php` - Revenue, customer & operations analytics

✅ **Enhanced Routes** in `app/Config/Routes.php`
- 40+ new admin routes organized by module
- RESTful URL structure
- Route groups for better organization

## What You Need to Create

### 1. Models (app/Models/)

Create 5 model files with the code provided in `ADMIN_SETUP_GUIDE.md`:

```bash
app/Models/
├── UserModel.php
├── PartnerModel.php
├── LocationModel.php
├── PromoModel.php
└── OrderModel.php
```

**Quick Command** (copy from ADMIN_SETUP_GUIDE.md):
Each model is already written - just copy-paste from the guide.

### 2. Views (app/Views/admin/)

Create view files for each module:

```
app/Views/admin/
├── layout/
│   ├── header.php           # Admin header with navigation
│   └── footer.php           # Admin footer
├── dashboard.php            # Main dashboard
├── users/
│   ├── index.php           # List users
│   └── view.php            # View user details
├── partners/
│   ├── index.php           # List partners
│   ├── create.php          # Create partner form
│   ├── edit.php            # Edit partner form
│   └── performance.php     # Partner analytics
├── locations/
│   ├── index.php           # List locations
│   ├── create.php          # Create location form
│   ├── edit.php            # Edit location form
│   └── storage.php         # Storage status
├── promo/
│   ├── index.php           # List promo codes
│   ├── create.php          # Create promo form
│   └── edit.php            # Edit promo form
├── orders/
│   ├── index.php           # List orders
│   └── view.php            # View order details
└── analytics/
    ├── revenue.php         # Revenue analytics
    ├── customers.php       # Customer analytics
    ├── operations.php      # Operations analytics
    └── external_data.php   # External data dashboard
```

## Admin Features Overview

### Dashboard (`/admin/dashboard`)
Shows 6 key metrics:
- Total Users
- Orders Today
- Revenue This Month
- Pending Deliveries
- Active Partners
- Storage Occupancy Rate

Plus:
- Recent orders table
- 7-day revenue chart

### Users (`/admin/users`)
- List all users with pagination
- View individual user details
- See user's order history
- View user's reviews
- Search by name, email, type, nationality

### Partners (`/admin/partners`)
- Full CRUD operations
- Track commission rates
- Monitor contract periods
- View partner performance metrics
- See partner-generated orders

### Locations (`/admin/locations`)
- Manage storage locations
- Track capacity and occupancy
- View items in storage
- Monitor location status

### Promo Codes (`/admin/promo`)
- Create promotional campaigns
- Set usage limits
- Track redemptions
- Manage active/inactive status
- Flat or percentage discounts

### Orders (`/admin/orders`)
- View all orders with filters
- Detailed order information
- Update order status
- Track delivery status
- View luggage items
- Storage tracking info

### Analytics
Four comprehensive dashboards:

1. **Revenue Analytics** (`/admin/analytics/revenue`)
   - Daily revenue trends
   - Revenue by channel (direct/partner)
   - Revenue by service type
   - Commission tracking

2. **Customer Analytics** (`/admin/analytics/customers`)
   - Customer lifetime value
   - Segmentation analysis
   - Acquisition trends
   - Top customers

3. **Operations Analytics** (`/admin/analytics/operations`)
   - Daily operations summary
   - Delivery performance
   - On-time delivery rate
   - Storage occupancy

4. **External Data** (`/admin/analytics/external-data`)
   - Tourist arrival statistics
   - Upcoming local events
   - Hotel occupancy trends

## Role-Based Access

The system includes 5 admin roles:
- **Superadmin**: Full access
- **Admin**: Standard admin access
- **Driver**: Delivery management
- **Storage_Handler**: Storage operations
- **Customer_Service**: Customer support

## Testing the Admin Portal

1. **Run migrations**:
   ```bash
   php spark migrate
   ```

2. **Seed the database**:
   ```bash
   php spark db:seed Database_seeder
   ```

3. **Login credentials** (from Admins_seeder):
   - **Admin**: admin@easesarawak.com / admin123
   - **Superadmin**: superadmin@easesarawak.com / superadmin123
   - **Driver**: driver1@easesarawak.com / driver123
   - **Handler**: handler1@easesarawak.com / handler123

4. **Access the dashboard**:
   ```
   http://localhost/easesarawak/admin/dashboard
   ```

## Key Controller Methods

### BaseAdminController
- `hasRole($role)` - Check user permissions
- `jsonResponse($data, $status)` - Return JSON
- `successMessage($msg, $redirect)` - Success flash message
- `errorMessage($msg, $redirect)` - Error flash message

### Common Patterns

**List items with pagination:**
```php
$data = [
    'title' => 'List Items',
    'items' => $this->model->paginate(20),
    'pager' => $this->model->pager,
];
```

**Create/Update with validation:**
```php
$validation->setRules([...]);
if (!$validation->withRequest($this->request)->run()) {
    return redirect()->back()->withInput()->with('errors', $validation->getErrors());
}
```

**Join queries:**
```php
$data = $db->table('Orders o')
    ->select('o.*, u.first_name, u.last_name')
    ->join('Users u', 'u.user_id = o.user_id')
    ->get()
    ->getResult();
```

## Database Views Available

The controllers use these pre-created views:
- `daily_operations_summary` - Daily ops metrics
- `customer_lifetime_value` - CLV analysis
- `monthly_revenue_analysis` - Monthly revenue

## Next Implementation Steps

1. **Create Models** (15 minutes)
   - Copy from ADMIN_SETUP_GUIDE.md
   - Place in app/Models/

2. **Create Basic Views** (1-2 hours)
   - Start with dashboard.php
   - Create layout/header.php and layout/footer.php
   - Add Bootstrap/Tailwind CSS
   - Create index.php for each module

3. **Test CRUD Operations** (30 minutes)
   - Test creating partners
   - Test editing locations
   - Test creating promo codes

4. **Add Styling** (1-2 hours)
   - Admin theme/template
   - Charts for analytics
   - Tables for data display
   - Forms for CRUD operations

5. **Add Export Features** (optional)
   - CSV/Excel export for reports
   - PDF generation for invoices

## Tips

- Use existing `Admin` controller views as reference
- Leverage Bootstrap/Tailwind for quick UI
- Use DataTables for sortable/searchable tables
- Add Chart.js for analytics visualizations
- Implement AJAX for smoother UX

## Support Resources

- CodeIgniter 4 Documentation: https://codeigniter.com/user_guide/
- Bootstrap 5: https://getbootstrap.com/
- Chart.js: https://www.chartjs.org/
- DataTables: https://datatables.net/

Your admin portal is now structurally complete with all controllers and routes configured!
