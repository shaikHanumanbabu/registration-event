#!/bin/bash

# Registration System - Automated Setup Script
# Laravel 8.1 Application

echo "=================================="
echo "Registration System Setup"
echo "Laravel 8.1"
echo "=================================="
echo ""

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Check if running in Laravel directory
if [ ! -f "artisan" ]; then
    echo -e "${RED}Error: Not in Laravel root directory${NC}"
    echo "Please run this script from your Laravel project root"
    exit 1
fi

echo -e "${YELLOW}Step 1: Checking PHP version...${NC}"
php -v
if [ $? -ne 0 ]; then
    echo -e "${RED}PHP is not installed or not in PATH${NC}"
    exit 1
fi
echo -e "${GREEN}✓ PHP is installed${NC}"
echo ""

echo -e "${YELLOW}Step 2: Checking Composer...${NC}"
composer --version
if [ $? -ne 0 ]; then
    echo -e "${RED}Composer is not installed or not in PATH${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Composer is installed${NC}"
echo ""

echo -e "${YELLOW}Step 3: Installing Composer dependencies...${NC}"
composer install
if [ $? -ne 0 ]; then
    echo -e "${RED}Failed to install composer dependencies${NC}"
    exit 1
fi
echo -e "${GREEN}✓ Dependencies installed${NC}"
echo ""

echo -e "${YELLOW}Step 4: Installing QR Code package...${NC}"
composer require simplesoftwareio/simple-qrcode
echo -e "${GREEN}✓ QR Code package installed${NC}"
echo ""

echo -e "${YELLOW}Step 5: Setting up environment file...${NC}"
if [ ! -f ".env" ]; then
    cp .env.example .env
    echo -e "${GREEN}✓ .env file created${NC}"
else
    echo -e "${YELLOW}! .env file already exists, skipping${NC}"
fi
echo ""

echo -e "${YELLOW}Step 6: Generating application key...${NC}"
php artisan key:generate
echo -e "${GREEN}✓ Application key generated${NC}"
echo ""

echo -e "${YELLOW}Step 7: Creating storage directories...${NC}"
mkdir -p storage/app/public/payment_receipts
mkdir -p storage/app/public/qr_codes
mkdir -p public/images
echo -e "${GREEN}✓ Storage directories created${NC}"
echo ""

echo -e "${YELLOW}Step 8: Creating storage link...${NC}"
php artisan storage:link
echo -e "${GREEN}✓ Storage link created${NC}"
echo ""

echo -e "${YELLOW}Step 9: Setting permissions...${NC}"
chmod -R 775 storage
chmod -R 775 bootstrap/cache
echo -e "${GREEN}✓ Permissions set${NC}"
echo ""

echo -e "${YELLOW}Step 10: Database setup${NC}"
echo "Please configure your database in .env file:"
echo ""
echo "DB_CONNECTION=mysql"
echo "DB_HOST=127.0.0.1"
echo "DB_PORT=3306"
echo "DB_DATABASE=registration_db"
echo "DB_USERNAME=root"
echo "DB_PASSWORD=your_password"
echo ""
read -p "Have you configured the database? (y/n) " -n 1 -r
echo ""
if [[ $REPLY =~ ^[Yy]$ ]]; then
    echo -e "${YELLOW}Running migrations...${NC}"
    php artisan migrate
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✓ Database migrated successfully${NC}"
    else
        echo -e "${RED}! Migration failed. You can import database.sql manually${NC}"
    fi
else
    echo -e "${YELLOW}! Skipping migration. Import database.sql manually${NC}"
fi
echo ""

echo -e "${YELLOW}Step 11: Clearing caches...${NC}"
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
echo -e "${GREEN}✓ Caches cleared${NC}"
echo ""

echo ""
echo "=================================="
echo -e "${GREEN}Setup Complete!${NC}"
echo "=================================="
echo ""
echo "Next steps:"
echo "1. Configure database credentials in .env"
echo "2. Import database.sql if migrations failed"
echo "3. Add payment QR image to public/images/payment-qr.png"
echo "4. Run: php artisan serve"
echo "5. Visit: http://localhost:8000"
echo ""
echo "For detailed instructions, see INSTALLATION_GUIDE.md"
echo ""
echo -e "${GREEN}Happy Coding! 🚀${NC}"
