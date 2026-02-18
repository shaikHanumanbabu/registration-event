# Quick Reference - Registration System

## 🚀 Quick Commands

### Installation
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan serve
```

### Database
```bash
# Import SQL file
mysql -u root -p < database.sql

# Run migrations
php artisan migrate

# Fresh migration
php artisan migrate:fresh

# Rollback
php artisan migrate:rollback
```

### Cache Clear
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 📂 File Locations

| File | Location |
|------|----------|
| Model | `app/Models/Registration.php` |
| Controller | `app/Http/Controllers/RegistrationController.php` |
| Migration | `database/migrations/xxxx_create_registrations_table.php` |
| Routes | `routes/web.php` |
| Create Form | `resources/views/registrations/create.blade.php` |
| List View | `resources/views/registrations/index.blade.php` |
| Edit Form | `resources/views/registrations/edit.blade.php` |
| Details View | `resources/views/registrations/show.blade.php` |
| Database SQL | `database.sql` |
| Payment Receipts | `storage/app/public/payment_receipts/` |
| QR Codes | `storage/app/public/qr_codes/` |
| Payment QR | `public/images/payment-qr.png` |

---

## 🗄️ Database Quick Reference

### Table: registrations
```sql
-- Get all registrations
SELECT * FROM registrations ORDER BY created_at DESC;

-- Get new customers only
SELECT * FROM registrations WHERE customer_type = 'new';

-- Get registrations with family
SELECT * FROM registrations WHERE family_included = 'yes';

-- Get total amount by payment type
SELECT payment_type, SUM(total_amount) as total 
FROM registrations 
GROUP BY payment_type;

-- Count registrations by type
SELECT customer_type, COUNT(*) as count 
FROM registrations 
GROUP BY customer_type;
```

---

## 🔧 Common Customizations

### Change Customer Number Format
**File:** `app/Models/Registration.php` (Line ~36)
```php
public static function generateCustomerNumber()
{
    $prefix = 'CUST';  // Change this
    $year = date('Y');
    // Current format: CUST20260001
}
```

### Change Items Per Page
**File:** `app/Http/Controllers/RegistrationController.php` (Line ~18)
```php
->paginate(10);  // Change to 20, 50, etc.
```

### Change QR Code Size
**File:** `app/Http/Controllers/RegistrationController.php` (Line ~58)
```php
->size(300)  // Change to 200, 400, etc.
```

### Change Payment Options
**File:** Both `create.blade.php` and `edit.blade.php`
```html
<option value="phonepe">PhonePe</option>
<option value="gpay">GPay</option>
<option value="paytm">Paytm</option>  <!-- Add new -->
<option value="others">Others</option>
```

---

## 🎨 UI Customization

### Change Gradient Colors
**Files:** All blade templates
```css
/* Find and replace: */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* With your colors: */
background: linear-gradient(135deg, #your-color-1 0%, #your-color-2 100%);
```

### Change Primary Color
```css
.btn-submit {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
```

---

## 🌐 URLs

| Page | URL |
|------|-----|
| Home | `http://localhost:8000/` |
| New Registration | `http://localhost:8000/registrations/create` |
| All Registrations | `http://localhost:8000/registrations` |
| View Details | `http://localhost:8000/registrations/{id}` |
| Edit | `http://localhost:8000/registrations/{id}/edit` |

---

## 🔍 Eloquent Queries

### In Controller or Tinker
```php
// Get all registrations
$all = Registration::all();

// Get with pagination
$paginated = Registration::paginate(10);

// Find by ID
$reg = Registration::find(1);

// Find by customer number
$reg = Registration::where('customer_no', 'CUST20260001')->first();

// Get new customers
$new = Registration::where('customer_type', 'new')->get();

// Get with family
$family = Registration::where('family_included', 'yes')->get();

// Search by name
$search = Registration::where('name', 'LIKE', '%John%')->get();

// Get recent registrations
$recent = Registration::latest()->take(10)->get();

// Count total registrations
$count = Registration::count();

// Sum of total amounts
$total = Registration::sum('total_amount');

// Create new registration
$reg = Registration::create([
    'customer_type' => 'new',
    'family_included' => 'no',
    'name' => 'John Doe',
    'email' => 'john@example.com',
    // ... other fields
]);

// Update registration
$reg = Registration::find(1);
$reg->update(['name' => 'New Name']);

// Delete registration
$reg = Registration::find(1);
$reg->delete();
```

---

## 🐛 Troubleshooting Quick Fixes

### Issue: Class not found
```bash
composer dump-autoload
php artisan config:clear
```

### Issue: Storage link not working
```bash
php artisan storage:link
chmod -R 775 storage
```

### Issue: QR Code not generating
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:clear
```

### Issue: Images 404
```bash
php artisan storage:link
```

### Issue: Database connection failed
```bash
# Check .env file
# Verify MySQL is running
# Test connection: mysql -u root -p
```

### Issue: Migration already ran
```bash
php artisan migrate:fresh  # Warning: Deletes all data
# Or import database.sql
```

---

## 📊 Form Validation Rules

**File:** `app/Http/Controllers/RegistrationController.php`
```php
$validated = $request->validate([
    'customer_type' => 'required|in:new,existing',
    'family_included' => 'required|in:yes,no',
    'adults_count' => 'nullable|integer|min:0',
    'child_count' => 'nullable|integer|min:0',
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'required|string|max:20',
    'address' => 'required|string',
    'state' => 'required|string|max:100',
    'notes' => 'nullable|string',
    'total_amount' => 'required|numeric|min:0',
    'payment_type' => 'required|in:phonepe,gpay,others',
    'payment_receipt' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
]);
```

---

## 🔑 Environment Variables

**File:** `.env`
```env
# Application
APP_NAME="Registration System"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=registration_db
DB_USERNAME=root
DB_PASSWORD=

# File Storage
FILESYSTEM_DRIVER=local
```

---

## 📝 Testing with Tinker

```bash
php artisan tinker
```

```php
// Create a test registration
$reg = new App\Models\Registration;
$reg->customer_type = 'new';
$reg->family_included = 'yes';
$reg->adults_count = 2;
$reg->child_count = 1;
$reg->name = 'Test User';
$reg->email = 'test@example.com';
$reg->phone = '1234567890';
$reg->address = 'Test Address';
$reg->state = 'Test State';
$reg->total_amount = 5000;
$reg->payment_type = 'phonepe';
$reg->save();

// Get all registrations
App\Models\Registration::all();

// Get latest
App\Models\Registration::latest()->first();
```

---

## 🎯 Dynamic Form Logic Summary

| Customer Type | Family Included | Show Adults/Child Count? |
|---------------|-----------------|--------------------------|
| New | Yes | ✅ Yes |
| New | No | ❌ No |
| Existing | Yes | ✅ Yes (Required) |
| Existing | No | ❌ No |

**JavaScript Location:** Bottom of `create.blade.php` and `edit.blade.php`

---

## 📦 Package Info

```json
{
    "simplesoftwareio/simple-qrcode": "^4.2"
}
```

### Installation
```bash
composer require simplesoftwareio/simple-qrcode
```

### Usage
```php
use SimpleSoftwareIO\QrCode\Facades\QrCode;

QrCode::format('png')->size(300)->generate('QR Content');
```

---

## 💾 Backup Commands

```bash
# Backup database
mysqldump -u root -p registration_db > backup_$(date +%Y%m%d).sql

# Backup uploaded files
tar -czf storage_backup_$(date +%Y%m%d).tar.gz storage/app/public/
```

---

## 🚀 Deployment Checklist

- [ ] Set `APP_ENV=production` in .env
- [ ] Set `APP_DEBUG=false` in .env
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set proper file permissions (755 for directories, 644 for files)
- [ ] Configure web server (Apache/Nginx)
- [ ] Setup SSL certificate
- [ ] Configure database credentials
- [ ] Test storage link
- [ ] Setup backup cron jobs

---

**Last Updated:** 2026
**Laravel Version:** 8.1
**PHP Version:** 7.3+
