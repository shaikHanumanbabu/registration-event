# Registration System - Laravel 8.1
## Complete Installation Guide

### 📋 System Requirements
- PHP >= 7.3 or 8.0
- MySQL 5.7+ or MariaDB
- Composer
- Apache/Nginx web server
- Node.js & NPM (optional, for frontend assets)

---

## 🚀 Installation Steps

### Step 1: Install Laravel Project
```bash
# If starting fresh, install Laravel 8.x
composer create-project --prefer-dist laravel/laravel:^8.0 registration-system
cd registration-system
```

### Step 2: Setup Database

#### Option A: Using SQL File (Quick Setup)
```bash
# Import the database.sql file into MySQL
mysql -u root -p < database.sql
```

#### Option B: Manual Setup
```bash
# Create database
mysql -u root -p
CREATE DATABASE registration_db;
exit;
```

### Step 3: Configure Environment
```bash
# Copy environment file
cp .env.example .env

# Edit .env file and update these values:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=registration_db
DB_USERNAME=root
DB_PASSWORD=your_password

# Generate application key
php artisan key:generate
```

### Step 4: Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install QR Code package
composer require simplesoftwareio/simple-qrcode
```

### Step 5: Setup File Structure

Copy the provided files to these locations:

**Migration:**
```
database/migrations/2024_01_01_000001_create_registrations_table.php
```

**Model:**
```
app/Models/Registration.php
```

**Controller:**
```
app/Http/Controllers/RegistrationController.php
```

**Routes:**
```
routes/web.php
```

**Views:**
```
resources/views/registrations/create.blade.php
resources/views/registrations/index.blade.php
resources/views/registrations/edit.blade.php
resources/views/registrations/show.blade.php
```

### Step 6: Run Migrations
```bash
# Run database migrations
php artisan migrate

# Or if database.sql already imported, just verify
php artisan migrate:status
```

### Step 7: Setup Storage
```bash
# Create symbolic link for storage
php artisan storage:link

# Set proper permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Step 8: Configure QR Code Package

Add to `config/app.php`:

```php
'providers' => [
    // Other providers...
    SimpleSoftwareIO\QrCode\QrCodeServiceProvider::class,
],

'aliases' => [
    // Other aliases...
    'QrCode' => SimpleSoftwareIO\QrCode\Facades\QrCode::class,
],
```

Or run:
```bash
php artisan vendor:publish --provider="SimpleSoftwareIO\QrCode\QrCodeServiceProvider"
```

### Step 9: Add Payment QR Code (Optional)
```bash
# Create directory
mkdir -p public/images

# Add your payment QR code image
# Place your PhonePe/GPay QR code as: public/images/payment-qr.png
```

Update in `create.blade.php` (line ~210):
```html
<img src="{{ asset('images/payment-qr.png') }}" width="200">
```

### Step 10: Start Development Server
```bash
# Start Laravel server
php artisan serve

# Access application at:
# http://localhost:8000
```

---

## 📁 Project Structure

```
registration-system/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── RegistrationController.php
│   └── Models/
│       └── Registration.php
├── database/
│   └── migrations/
│       └── 2024_01_01_000001_create_registrations_table.php
├── public/
│   ├── images/
│   │   └── payment-qr.png (your payment QR)
│   └── storage/ (symlink)
├── resources/
│   └── views/
│       └── registrations/
│           ├── create.blade.php
│           ├── index.blade.php
│           ├── edit.blade.php
│           └── show.blade.php
├── routes/
│   └── web.php
├── storage/
│   └── app/
│       └── public/
│           ├── payment_receipts/
│           └── qr_codes/
├── .env
├── composer.json
└── database.sql
```

---

## 🎯 Features Implemented

✅ **Customer Management**
- Auto-generated customer numbers (CUST2026XXXX format)
- Customer type: New/Existing
- Family member inclusion tracking

✅ **Dynamic Form**
- Conditional fields based on customer type and family inclusion
- Bootstrap 5 responsive design
- Real-time form validation

✅ **Payment Processing**
- Multiple payment types (PhonePe, GPay, Others)
- Payment receipt upload
- Payment QR code display

✅ **QR Code Generation**
- Automatic QR code generation for each registration
- Contains: Registration ID, Customer No, Name, Email, Amount
- Stored in `storage/app/public/qr_codes/`

✅ **Admin Panel**
- View all registrations (paginated)
- Search and filter capabilities
- Edit registration details
- Delete registrations
- View detailed registration info

✅ **File Management**
- Payment receipt storage
- QR code storage
- Auto-cleanup on deletion

---

## 🔧 Configuration

### Customer Number Format
Edit `app/Models/Registration.php`:

```php
public static function generateCustomerNumber()
{
    $prefix = 'CUST';  // Change prefix here
    $year = date('Y');
    // Format: CUST2026XXXX
}
```

### Pagination
Edit `app/Http/Controllers/RegistrationController.php`:

```php
$registrations = Registration::orderBy('created_at', 'desc')
    ->paginate(10);  // Change items per page
```

### QR Code Size
Edit `app/Http/Controllers/RegistrationController.php`:

```php
$qrCode = QrCode::format('png')
    ->size(300)  // Change QR size
    ->generate($qrData);
```

---

## 🗄️ Database Schema

**Table: registrations**

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Primary key |
| customer_no | varchar | Unique customer number |
| customer_type | enum | 'new' or 'existing' |
| family_included | enum | 'yes' or 'no' |
| adults_count | int | Number of adults (nullable) |
| child_count | int | Number of children (nullable) |
| name | varchar | Full name |
| email | varchar | Email address |
| phone | varchar | Phone number |
| address | text | Complete address |
| state | varchar | State name |
| notes | text | Additional notes (nullable) |
| total_amount | decimal(10,2) | Payment amount |
| payment_type | varchar | Payment method |
| payment_receipt | varchar | Receipt file path (nullable) |
| qr_code | varchar | QR code file path (nullable) |
| created_at | timestamp | Creation timestamp |
| updated_at | timestamp | Update timestamp |

---

## 🌐 Routes

| Method | URI | Action | Description |
|--------|-----|--------|-------------|
| GET | / | Redirect to create | Homepage redirect |
| GET | /registrations | index | List all registrations |
| GET | /registrations/create | create | Show registration form |
| POST | /registrations | store | Save new registration |
| GET | /registrations/{id} | show | View registration details |
| GET | /registrations/{id}/edit | edit | Edit registration form |
| PUT | /registrations/{id} | update | Update registration |
| DELETE | /registrations/{id} | destroy | Delete registration |

---

## 📝 Usage Examples

### Create New Registration
1. Navigate to: `http://localhost:8000/registrations/create`
2. Fill in the form
3. Upload payment receipt
4. Submit
5. Auto-redirects to list page with success message

### View All Registrations
1. Navigate to: `http://localhost:8000/registrations`
2. View paginated list
3. Click QR code thumbnail to view full size
4. Use Edit/Delete buttons

### Edit Registration
1. Click "Edit" button on any registration
2. Modify fields
3. Optionally upload new receipt
4. Save changes

---

## 🐛 Troubleshooting

### Issue: QR Code Not Generating
**Solution:**
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:clear
php artisan cache:clear
```

### Issue: Images Not Displaying
**Solution:**
```bash
php artisan storage:link
chmod -R 775 storage
```

### Issue: Migration Errors
**Solution:**
```bash
php artisan migrate:fresh
# Or import database.sql directly
```

### Issue: Class Not Found
**Solution:**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

---

## 🔐 Security Notes

1. **File Upload Validation:**
   - Max 2MB file size
   - Only JPEG/PNG allowed
   - Files stored securely in storage/

2. **Form Validation:**
   - Server-side validation in controller
   - Required field checking
   - Email format validation

3. **SQL Injection Protection:**
   - Using Eloquent ORM
   - Parameterized queries

4. **CSRF Protection:**
   - Laravel's built-in CSRF protection
   - @csrf token in all forms

---

## 📦 Required Composer Packages

```json
{
    "require": {
        "php": "^7.3|^8.0",
        "laravel/framework": "^8.75",
        "simplesoftwareio/simple-qrcode": "^4.2"
    }
}
```

---

## 🎨 Frontend Technologies

- **Bootstrap 5.1.3** - Responsive UI framework
- **Font Awesome 6.0** - Icons
- **Vanilla JavaScript** - Dynamic form behavior
- **CSS3** - Custom styling with gradients

---

## 📞 Support

For issues or questions:
1. Check Laravel 8.x documentation: https://laravel.com/docs/8.x
2. QR Code package: https://github.com/SimpleSoftwareIO/simple-qrcode
3. Bootstrap docs: https://getbootstrap.com/docs/5.1

---

## 📄 License

This project is open-source and available under the MIT License.

---

## ✅ Checklist

- [ ] PHP 7.3+ installed
- [ ] Composer installed
- [ ] MySQL database created
- [ ] .env file configured
- [ ] Dependencies installed via composer
- [ ] Migrations run successfully
- [ ] Storage link created
- [ ] QR Code package installed
- [ ] Payment QR image added
- [ ] Server running on port 8000

---

**🎉 You're all set! Start creating registrations!**
