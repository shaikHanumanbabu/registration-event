-- Registration System Database
-- Compatible with MySQL 5.7+ and MariaDB
-- Laravel 8.1 Application

-- Create Database
CREATE DATABASE IF NOT EXISTS `registration_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `registration_db`;

-- Drop table if exists
DROP TABLE IF EXISTS `registrations`;

-- Create registrations table
CREATE TABLE `registrations` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_type` enum('new','existing') COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_included` enum('yes','no') COLLATE utf8mb4_unicode_ci NOT NULL,
  `adults_count` int(11) DEFAULT NULL,
  `child_count` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `payment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_receipt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qr_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `registrations_customer_no_unique` (`customer_no`),
  KEY `idx_customer_type` (`customer_type`),
  KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data
INSERT INTO `registrations` (`id`, `customer_no`, `customer_type`, `family_included`, `adults_count`, `child_count`, `name`, `email`, `phone`, `address`, `state`, `notes`, `total_amount`, `payment_type`, `payment_receipt`, `qr_code`, `created_at`, `updated_at`) VALUES
(1, 'CUST20260001', 'new', 'yes', 2, 1, 'Rajesh Kumar', 'rajesh.kumar@email.com', '+91 9876543210', '123 MG Road, Bangalore', 'Karnataka', 'First registration - family package', 5000.00, 'phonepe', NULL, NULL, NOW(), NOW()),
(2, 'CUST20260002', 'existing', 'no', NULL, NULL, 'Priya Sharma', 'priya.sharma@email.com', '+91 9876543211', '456 Park Street, Mumbai', 'Maharashtra', NULL, 2500.00, 'gpay', NULL, NULL, NOW(), NOW());

-- Create migrations table for Laravel
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2024_01_01_000001_create_registrations_table', 1);

-- Success message
SELECT 'Database setup completed successfully!' as Status;
