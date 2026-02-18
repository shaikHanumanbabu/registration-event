# 🎯 Registration Management System

A complete Laravel 8.1 application for managing customer registrations with family member tracking, payment processing, and QR code generation.

![Laravel](https://img.shields.io/badge/Laravel-8.1-red)
![PHP](https://img.shields.io/badge/PHP-7.3%2B-blue)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.1-purple)
![MySQL](https://img.shields.io/badge/MySQL-5.7%2B-orange)

---

## ✨ Features

🔹 **Auto-generated Customer Numbers** (Format: CUST2026XXXX)  
🔹 **Dynamic Form Fields** - Show/hide based on customer type & family inclusion  
🔹 **Payment Integration** - PhonePe, GPay, Others with receipt upload  
🔹 **QR Code Generation** - Automatic QR code for each registration  
🔹 **Complete CRUD** - Create, Read, Update, Delete operations  
🔹 **Responsive UI** - Bootstrap 5 with modern gradient design  
🔹 **File Management** - Secure storage for receipts and QR codes  
🔹 **Pagination** - Easy browsing of multiple registrations  

---

## 🚀 Quick Start

### 1. Install Dependencies
```bash
composer install
```

### 2. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Configure Database (.env)
```env
DB_DATABASE=registration_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Import Database
```bash
mysql -u root -p < database.sql
```

### 5. Setup Storage
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### 6. Start Server
```bash
php artisan serve
```

Visit: **http://localhost:8000**

---

## 📂 File Structure

```
├── app/
│   ├── Http/Controllers/
│   │   └── RegistrationController.php
│   └── Models/
│       └── Registration.php
├── database/
│   └── migrations/
│       └── create_registrations_table.php
├── resources/views/registrations/
│   ├── create.blade.php   (Registration Form)
│   ├── index.blade.php    (List All)
│   ├── edit.blade.php     (Edit Form)
│   └── show.blade.php     (View Details)
├── routes/
│   └── web.php
├── database.sql           (Ready-to-import DB)
└── INSTALLATION_GUIDE.md  (Complete guide)
```

---

## 🎨 Screenshots Flow

### 1. Registration Form
- Customer Type selection (New/Existing)
- Family members option (Yes/No)
- Dynamic fields for adults/children count
- Payment QR code display
- Receipt upload
- All fields with validation

### 2. Registration List
- Paginated table view
- Customer number, type, amount
- QR code thumbnails
- Edit/Delete actions
- Quick view modal

### 3. Edit Registration
- Pre-filled form with existing data
- Update any field
- Replace payment receipt
- Customer number preserved

### 4. View Details
- Complete registration information
- Display QR code
- Show payment receipt
- Formatted data presentation

---

## 🔑 Key Components

### Model - Registration.php
```php
✓ Auto-generates customer numbers
✓ Eloquent ORM queries
✓ Mass assignment protection
✓ Type casting for amounts
✓ Boot method for auto-generation
```

### Controller - RegistrationController.php
```php
✓ index()   - List all with pagination
✓ create()  - Show registration form
✓ store()   - Save new registration + QR
✓ show()    - Display single record
✓ edit()    - Show edit form
✓ update()  - Update existing record
✓ destroy() - Delete record + files
```

### Views - Blade Templates
```php
✓ Bootstrap 5 responsive design
✓ Form validation display
✓ Dynamic JavaScript for fields
✓ Modal for QR code display
✓ Success/error messages
```

---

## 🗄️ Database

**Table:** `registrations`

| Column | Type | Description |
|--------|------|-------------|
| id | bigint | Auto-increment ID |
| customer_no | varchar | Unique (CUST2026XXXX) |
| customer_type | enum | new / existing |
| family_included | enum | yes / no |
| adults_count | int | Nullable |
| child_count | int | Nullable |
| name | varchar | Required |
| email | varchar | Required |
| phone | varchar | Required |
| address | text | Required |
| state | varchar | Required |
| notes | text | Nullable |
| total_amount | decimal | Required |
| payment_type | varchar | phonepe/gpay/others |
| payment_receipt | varchar | File path (nullable) |
| qr_code | varchar | QR path (nullable) |
| created_at | timestamp | Auto |
| updated_at | timestamp | Auto |

---

## 🌐 Routes

| HTTP Method | URI | Action |
|-------------|-----|--------|
| GET | `/` | Redirect to registration form |
| GET | `/registrations` | List all registrations |
| GET | `/registrations/create` | Registration form |
| POST | `/registrations` | Store new registration |
| GET | `/registrations/{id}` | View details |
| GET | `/registrations/{id}/edit` | Edit form |
| PUT | `/registrations/{id}` | Update registration |
| DELETE | `/registrations/{id}` | Delete registration |

---

## ⚙️ Configuration

### Customize Customer Number Format
**File:** `app/Models/Registration.php`
```php
public static function generateCustomerNumber()
{
    $prefix = 'CUST';        // Change this
    $year = date('Y');       // Or use custom format
    // Current: CUST20260001
}
```

### Change Pagination
**File:** `app/Http/Controllers/RegistrationController.php`
```php
$registrations = Registration::orderBy('created_at', 'desc')
    ->paginate(10);  // Change to 20, 50, etc.
```

### Adjust QR Code Size
**File:** `app/Http/Controllers/RegistrationController.php`
```php
$qrCode = QrCode::format('png')
    ->size(300)  // Change size (200, 400, etc.)
    ->generate($qrData);
```

---

## 🎯 Dynamic Form Logic

### Scenario 1: Family = Yes, Type = Existing
✅ **Shows:** Adults Count, Child Count fields

### Scenario 2: Family = No, Type = New
❌ **Hides:** Adults Count, Child Count fields

### Scenario 3: Family = Yes (Any Type)
✅ **Shows:** Adults Count, Child Count fields

### Scenario 4: Family = No, Type = Existing
❌ **Hides:** Adults Count, Child Count fields

**Implementation:** JavaScript in `create.blade.php` and `edit.blade.php`

---

## 📦 Dependencies

### Required Packages
```json
{
    "laravel/framework": "^8.75",
    "simplesoftwareio/simple-qrcode": "^4.2"
}
```

### Frontend Libraries (CDN)
- Bootstrap 5.1.3
- Font Awesome 6.0
- Vanilla JavaScript

---

## 🔒 Security Features

✅ CSRF Protection (Laravel built-in)  
✅ SQL Injection Prevention (Eloquent ORM)  
✅ File Upload Validation (2MB max, JPEG/PNG only)  
✅ Server-side Form Validation  
✅ Secure File Storage (storage/app/public/)  
✅ Input Sanitization  

---

## 🐛 Common Issues & Solutions

### Issue: QR Code not showing
```bash
composer require simplesoftwareio/simple-qrcode
php artisan config:clear
php artisan storage:link
```

### Issue: Images 404 error
```bash
php artisan storage:link
chmod -R 775 storage
```

### Issue: Form not submitting
- Check .env database credentials
- Verify migrations are run
- Clear cache: `php artisan cache:clear`

---

## 📱 API Ready Structure

The controller uses Eloquent ORM, making it easy to convert to API:

```php
// For API response, just return JSON
public function index()
{
    return response()->json(
        Registration::paginate(10)
    );
}
```

---

## 🎓 Learning Resources

- [Laravel 8.x Docs](https://laravel.com/docs/8.x)
- [Bootstrap 5 Docs](https://getbootstrap.com/docs/5.1)
- [QrCode Package](https://github.com/SimpleSoftwareIO/simple-qrcode)
- [Eloquent ORM](https://laravel.com/docs/8.x/eloquent)

---

## 📄 Files Included

✅ `Registration.php` - Eloquent Model  
✅ `RegistrationController.php` - Main Controller  
✅ `create_registrations_table.php` - Migration  
✅ `web.php` - Routes  
✅ `create.blade.php` - Registration Form  
✅ `index.blade.php` - List View  
✅ `edit.blade.php` - Edit Form  
✅ `show.blade.php` - Details View  
✅ `database.sql` - Ready Database  
✅ `composer.json` - Dependencies  
✅ `.env.example` - Environment Config  
✅ `INSTALLATION_GUIDE.md` - Complete Guide  

---

## 🎉 You're Ready!

1. Follow the Quick Start steps above
2. Access http://localhost:8000
3. Create your first registration
4. Explore all CRUD operations

For detailed instructions, see **INSTALLATION_GUIDE.md**

---

## 💡 Tips

- Add your payment QR image to `public/images/payment-qr.png`
- Customize colors in blade files (search for `#667eea` and `#764ba2`)
- Database comes with 2 sample records
- All forms have client + server validation
- Files are stored in `storage/app/public/`

---

## 🤝 Contributing

Feel free to:
- Report bugs
- Suggest features
- Submit pull requests
- Share improvements

---

## 📞 Need Help?

Check the `INSTALLATION_GUIDE.md` for:
- Step-by-step installation
- Troubleshooting
- Configuration options
- Database schema details
- Advanced customization

---

**Built with ❤️ using Laravel 8.1**

Happy Coding! 🚀
