-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 27, 2024 at 11:58 AM
-- Server version: 10.11.9-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u257200899_kohisar`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Brand One', NULL, 1, '2024-10-04 06:41:36', '2024-10-04 06:41:36'),
(2, 'Brand Two', NULL, 1, '2024-10-04 06:41:36', '2024-10-04 06:41:36'),
(3, 'Brand Three', NULL, 1, '2024-10-04 06:41:36', '2024-10-04 06:41:36'),
(4, 'Brand Four', NULL, 0, '2024-10-04 06:41:36', '2024-10-04 06:41:36'),
(5, 'test', NULL, 1, '2024-10-04 06:51:32', '2024-10-04 06:51:32'),
(6, 'tes3', NULL, 1, '2024-10-04 06:52:59', '2024-10-04 06:53:54'),
(7, 'as', '1728028454.jpg', 1, '2024-10-04 06:54:03', '2024-10-04 06:54:14');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Breeder Feed', NULL, 1, '2024-10-04 06:41:37', '2024-10-04 06:41:37'),
(2, 'Broiler Feed', NULL, 1, '2024-10-04 06:41:37', '2024-10-04 06:41:37'),
(3, 'Dairy Feed', NULL, 1, '2024-10-04 06:41:37', '2024-10-04 06:41:37'),
(4, 'Layer Feed', NULL, 1, '2024-10-04 06:41:37', '2024-10-28 06:24:29');

-- --------------------------------------------------------

--
-- Table structure for table `chart_of_accounts`
--

CREATE TABLE `chart_of_accounts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `level` int(11) NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `type` enum('asset','liability','equity','revenue','expense') NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `is_lock` tinyint(1) NOT NULL DEFAULT 1,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chart_of_accounts`
--

INSERT INTO `chart_of_accounts` (`id`, `name`, `description`, `level`, `parent_id`, `type`, `category`, `is_lock`, `is_active`, `created_at`, `updated_at`) VALUES
(100000, 'Assets', NULL, 1, NULL, 'asset', NULL, 1, 1, NULL, NULL),
(110000, 'Current Assets', NULL, 2, 100000, 'asset', NULL, 1, 1, NULL, NULL),
(111000, 'Cash', NULL, 3, 110000, 'asset', NULL, 1, 1, NULL, NULL),
(111100, 'Cash in Hand', NULL, 4, 111000, 'asset', 'cash', 1, 1, NULL, NULL),
(111200, 'Petty Cash', NULL, 4, 111000, 'asset', 'cash', 1, 1, NULL, NULL),
(112000, 'Accounts Receivable', NULL, 3, 110000, 'asset', NULL, 1, 1, NULL, NULL),
(112100, 'A/R - Customers', NULL, 4, 112000, 'asset', NULL, 1, 1, NULL, '2024-11-20 06:37:26'),
(113000, 'Inventory', NULL, 3, 110000, 'asset', NULL, 1, 1, NULL, NULL),
(113001, 'Raw Material', NULL, 4, 113000, 'asset', NULL, 1, 1, '2024-11-20 06:44:53', '2024-11-20 06:44:53'),
(113002, 'Finished Goods', NULL, 4, 113000, 'asset', NULL, 1, 1, '2024-11-20 06:45:16', '2024-11-20 06:45:16'),
(114000, 'Bank', NULL, 3, 110000, 'asset', NULL, 1, 1, NULL, NULL),
(114001, 'Meezan', NULL, 4, 114000, 'asset', 'bank', 1, 1, '2024-11-15 06:42:20', '2024-11-15 06:42:20'),
(114002, 'Allied', NULL, 4, 114000, 'asset', 'card', 1, 1, '2024-11-15 06:42:26', '2024-11-15 06:42:26'),
(120000, 'Fixed Assets', NULL, 2, 100000, 'asset', NULL, 1, 1, NULL, NULL),
(130000, 'Other Assets', NULL, 2, 100000, 'asset', NULL, 1, 1, NULL, NULL),
(200000, 'Liabilities', NULL, 1, NULL, 'liability', NULL, 1, 1, NULL, NULL),
(210000, 'Current Liabilities', NULL, 2, 200000, 'liability', NULL, 1, 1, NULL, NULL),
(211000, 'Accounts Payable', NULL, 3, 210000, 'liability', NULL, 1, 1, NULL, NULL),
(211100, 'A/P - Suppliers', NULL, 4, 211000, 'liability', NULL, 1, 1, NULL, '2024-11-20 06:37:34'),
(211101, 'GST Payable', NULL, 4, 211000, 'liability', NULL, 1, 1, '2024-11-23 10:30:10', '2024-11-23 10:30:10'),
(211102, 'Withholding Payable', NULL, 4, 211000, 'liability', NULL, 1, 1, '2024-11-23 10:30:25', '2024-11-23 10:35:55'),
(211103, 'Commission Payable', NULL, 4, 211000, 'liability', NULL, 1, 1, '2024-11-23 10:34:56', '2024-11-23 10:34:56'),
(212000, 'Short-term Loans', NULL, 3, 210000, 'liability', NULL, 1, 1, NULL, NULL),
(220000, 'Long-term Liabilities', NULL, 2, 200000, 'liability', NULL, 1, 1, NULL, NULL),
(221000, 'Long-term Loans', NULL, 3, 220000, 'liability', NULL, 1, 1, NULL, NULL),
(300000, 'Equity', NULL, 1, NULL, 'equity', NULL, 1, 1, NULL, NULL),
(310000, 'Owner\'s Equity', NULL, 2, 300000, 'equity', NULL, 1, 1, NULL, NULL),
(311000, 'Opening Accounts', NULL, 3, 310000, 'equity', NULL, 1, 1, '2024-11-27 05:06:50', '2024-11-27 05:06:50'),
(311001, 'Supplier Opening Balance', NULL, 4, 311000, 'equity', NULL, 1, 1, '2024-11-27 05:07:21', '2024-11-27 05:07:21'),
(311002, 'Customer Opeing Balance', NULL, 4, 311000, 'equity', NULL, 1, 1, '2024-11-27 05:07:37', '2024-11-27 05:07:37'),
(320000, 'Retained Earnings', NULL, 2, 300000, 'equity', NULL, 1, 1, NULL, NULL),
(400000, 'Revenue', NULL, 1, NULL, 'revenue', NULL, 1, 1, NULL, NULL),
(410000, 'Sales Revenue', NULL, 2, 400000, 'revenue', NULL, 1, 1, NULL, NULL),
(411000, 'Product Sales', NULL, 3, 410000, 'revenue', NULL, 1, 1, '2024-11-19 05:51:44', '2024-11-23 11:05:46'),
(411001, 'Finished Goods', NULL, 4, 411000, 'revenue', NULL, 1, 1, '2024-11-19 05:51:50', '2024-11-23 11:06:05'),
(420000, 'Service Revenue', NULL, 2, 400000, 'revenue', NULL, 1, 1, NULL, NULL),
(430000, 'Other Revenue', NULL, 2, 400000, 'revenue', NULL, 1, 1, NULL, NULL),
(500000, 'Expenses', NULL, 1, NULL, 'expense', NULL, 1, 1, NULL, NULL),
(510000, 'Cost of Goods Sold (COGS)', NULL, 2, 500000, 'expense', NULL, 1, 1, NULL, NULL),
(511000, 'Shipping Charges', NULL, 3, 510000, 'expense', NULL, 1, 1, '2024-11-18 05:29:49', '2024-11-18 05:29:49'),
(511001, 'Shipping', NULL, 4, 511000, 'expense', NULL, 1, 1, '2024-11-20 06:38:25', '2024-11-20 06:38:25'),
(512000, 'Taxes', NULL, 3, 510000, 'expense', NULL, 1, 1, '2024-11-20 06:33:30', '2024-11-20 06:33:30'),
(520000, 'Operating Expenses', NULL, 2, 500000, 'expense', NULL, 1, 1, NULL, NULL),
(530000, 'Other Expenses', NULL, 2, 500000, 'expense', NULL, 1, 1, NULL, NULL),
(531000, 'Commissions', NULL, 3, 530000, 'expense', NULL, 1, 1, '2024-11-20 06:39:57', '2024-11-20 06:39:57'),
(531001, 'Sales Commission', NULL, 4, 531000, 'expense', NULL, 1, 1, '2024-11-20 06:41:40', '2024-11-20 06:41:40');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `contact_person`, `mobile_no`, `image`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Customer 1', 'John Doe', '1234567890', NULL, 1, NULL, NULL),
(2, 'Customer 2', 'Jane Smith', '0987654321', NULL, 1, NULL, NULL),
(3, 'Customer 3', 'David Brown', '1122334455', NULL, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `expense_no` varchar(255) NOT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'supplier',
  `chart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'account used to pay the expense',
  `description` longtext DEFAULT NULL,
  `amount_exclusive_tax` decimal(15,2) DEFAULT NULL,
  `tax_percentage` decimal(5,2) DEFAULT NULL,
  `calculated_tax_amount` decimal(15,2) DEFAULT NULL,
  `amount_inclusive_tax` decimal(15,2) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `creator_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `expense_details`
--

CREATE TABLE `expense_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expense_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `expense_no` varchar(255) DEFAULT NULL,
  `chart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `amount_exclusive_tax` decimal(15,2) DEFAULT NULL,
  `tax_percentage` decimal(5,2) DEFAULT NULL,
  `calculated_tax_amount` decimal(15,2) DEFAULT NULL,
  `amount_inclusive_tax` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_master_id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `invoice_no` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_weight` decimal(15,2) DEFAULT NULL,
  `gross_weight` decimal(15,2) DEFAULT NULL,
  `cut_percentage` decimal(15,2) DEFAULT NULL,
  `cut_value` decimal(15,2) DEFAULT NULL,
  `after_cut_total_weight` decimal(15,2) DEFAULT NULL,
  `total_quantity` decimal(15,2) DEFAULT NULL,
  `per_package_weight` decimal(15,2) DEFAULT NULL,
  `total_package_weight` decimal(15,2) DEFAULT NULL,
  `net_weight` decimal(15,2) DEFAULT NULL,
  `is_surplus` int(11) DEFAULT 0,
  `per_unit_price` decimal(15,2) DEFAULT NULL,
  `per_unit_price_old_value` decimal(15,2) DEFAULT NULL,
  `per_unit_price_new_value` decimal(15,2) DEFAULT NULL,
  `total_price` decimal(15,2) DEFAULT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_value` decimal(15,2) DEFAULT NULL,
  `discount_amount` decimal(15,2) DEFAULT NULL,
  `after_discount_total_price` decimal(15,2) DEFAULT NULL,
  `tax_rate` decimal(15,2) DEFAULT NULL,
  `tax_value` decimal(15,2) DEFAULT NULL,
  `grand_total` decimal(15,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_master`
--

CREATE TABLE `invoice_master` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `invoice_no` varchar(255) NOT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `batch_no` varchar(255) DEFAULT NULL,
  `vehicle_no` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `recipe_id` bigint(20) UNSIGNED DEFAULT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL,
  `saleman_id` bigint(20) UNSIGNED DEFAULT NULL,
  `party_warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_total` decimal(14,2) DEFAULT NULL,
  `total` decimal(14,2) DEFAULT NULL,
  `production_material_tons` decimal(14,4) DEFAULT NULL,
  `sub_total` decimal(14,2) DEFAULT NULL,
  `discount_type` varchar(255) DEFAULT NULL,
  `discount_value` decimal(14,2) DEFAULT NULL,
  `discount_amount` decimal(14,2) DEFAULT NULL,
  `tax_type` varchar(255) DEFAULT NULL,
  `tax_rate` decimal(15,2) DEFAULT NULL COMMENT 'GST or VAT',
  `tax_amount` decimal(15,2) DEFAULT NULL,
  `wth_tax_rate` decimal(15,2) DEFAULT NULL COMMENT 'Withholdong Tax',
  `wth_tax_amount` decimal(15,2) DEFAULT NULL,
  `commission_rate` decimal(15,2) DEFAULT NULL,
  `commission_amount` decimal(15,2) DEFAULT NULL,
  `shipping_type` varchar(255) DEFAULT NULL,
  `shipping` decimal(15,2) DEFAULT NULL,
  `grand_total` decimal(14,2) DEFAULT NULL,
  `production_qty` decimal(15,2) DEFAULT NULL COMMENT 'in kgs',
  `output_qty` decimal(15,2) DEFAULT NULL COMMENT 'in kgs',
  `surplus_qty` decimal(15,2) DEFAULT NULL COMMENT 'in kgs',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `is_lock` char(2) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `sell_price` decimal(20,2) DEFAULT NULL,
  `purchase_price` decimal(20,2) DEFAULT NULL,
  `stock_alert_qty` decimal(20,2) DEFAULT NULL,
  `unit_weight` decimal(20,2) DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `tax_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `sell_cart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `purchase_cart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `code`, `name`, `type`, `sell_price`, `purchase_price`, `stock_alert_qty`, `unit_weight`, `category_id`, `brand_id`, `unit_id`, `tax_id`, `warehouse_id`, `sell_cart_of_account_id`, `purchase_cart_of_account_id`, `is_active`, `created_at`, `updated_at`) VALUES
(3, '1', 'Maize', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, '3', 'Rice Bran', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, '4', 'Rice Polish 2', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, '5', 'Rice Polish', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, '6', 'Wheat Bran', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, '7', 'CG 60 %', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, '8', 'CG 30 %', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, '9', 'PBM', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, '10', 'Fish Meal', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, '11', 'MBM', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, '12', 'Canola Meal', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, '13', 'Rapeseed Meal', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, '14', 'Soybean Meal - Low KOH', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, '15', 'Soybean Meal - HP', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, '16', 'Seasame Cake', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, '17', 'Sunflower Meal', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, '18', 'Guar Meal', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, '19', 'Palm Kernel Cake', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, '20', 'Molasses', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, '21', 'Rapeseed Cake', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, '22', 'Powder Chips', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, '23', 'DCP Local', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, '24', 'DCP China', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, '25', 'Chicken Oil', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, '26', 'Vegetable Oil', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, '27', 'Wanda Bags (20 Kg)', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, '28', 'Wanda Bags', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, '29', 'Feed Bags', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, '30', 'Lysine Sulfate', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, '31', 'Methionine', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, '32', 'Arginine', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, '33', 'Iso-Leucine', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, '34', 'Valine', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, '35', 'Tryptophan', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, '36', 'Threonine', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, '37', 'Salt', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, '38', 'Soda', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, '39', 'Urea', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, '40', 'Betaine', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, '41', 'Magnesium Sulfate', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, '42', 'Choline', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, '43', 'Mineral Premix', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, '44', 'Vitamin Premix', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, '45', 'Total Mineral Premix', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, '46', 'Total Vitamin Premix', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, '47', 'ECO Trace', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, '48', 'Technospore', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, '49', 'Diclazuril', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, '50', 'Maduramycin', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, '51', 'Coximix - DS', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, '52', 'Lincomycin', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, '53', 'Enramycin', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, '54', 'UMAVILA', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, '55', 'XAP', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, '56', 'Novatech', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, '57', 'Protech', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, '58', 'Microtech', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, '59', 'Yeast', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, '60', 'Ronozyme ProAct', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, '61', 'Dairy Premix', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, '62', 'Lipidol Prime', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, '63', 'Shell Boost', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, '64', 'Toxin Binder', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, '65', 'Kamix', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, '66', 'Fatelac 84', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, '67', 'Oxytet', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, '68', 'Furazolidon', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, '69', 'Acid Buff', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, '70', 'Farmatan BCO', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, '71', 'Copper Sulfate', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, '72', 'Ferrous Sulfate', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, '73', 'Manganese Sulfate', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, '74', 'Zinc Sulfate', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(77, '75', 'Iodine', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(78, '76', 'Selenium', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(79, '77', 'Organic Selenium', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(80, '78', 'Vitamin A', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(81, '79', 'Vitamin D3', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(82, '80', 'Vitamin K3', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(83, '81', 'Vitamin E', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(84, '82', 'Vitamin B1 Thiamine', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(85, '83', 'Vitamin B2 Riboflavin', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(86, '84', 'Vitamin B3 Niacin', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(87, '85', 'Vitamin B5 Cal D Pan', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(88, '86', 'Vitamin B6 Pyridoxin', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(89, '87', 'Vitamin B7 Biotin', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(90, '88', 'Vitamin B9 Folic acid', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(91, '89', 'Vitamin B12 0.1%', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(92, '90', 'Vitamin B12 1%', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(93, '91', 'Antioxidant', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(94, '92', 'Kemvet', 'Raw', 0.00, 0.00, 1.00, NULL, 1, 1, 1, 1, 1, NULL, NULL, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(95, '93', '16', 'Good', NULL, NULL, NULL, 50.00, 1, NULL, 1, 1, NULL, NULL, NULL, 1, '2024-11-06 13:09:32', '2024-11-06 14:10:37'),
(96, '94', '17', 'Good', NULL, NULL, NULL, 50.00, 1, NULL, 1, 1, NULL, NULL, NULL, 1, '2024-11-06 13:10:22', '2024-11-06 14:10:46'),
(97, '95', '18', 'Good', NULL, NULL, NULL, 49.00, 1, NULL, 1, 1, NULL, NULL, NULL, 1, '2024-11-06 13:17:02', '2024-11-06 14:10:54'),
(102, '98', 'KD-M (25 kg)', 'Good', NULL, NULL, NULL, 25.00, 3, NULL, 1, 1, NULL, NULL, NULL, 1, '2024-11-06 16:16:59', '2024-11-06 16:16:59'),
(103, '99', 'KD-M (37 kg)', 'Good', NULL, NULL, NULL, 37.00, 3, NULL, 1, 1, NULL, NULL, NULL, 1, '2024-11-06 16:18:11', '2024-11-06 16:18:11'),
(104, '100', 'OH - 14A', 'Good', NULL, NULL, NULL, 50.00, 2, NULL, 1, 1, NULL, NULL, NULL, 1, '2024-11-06 16:20:04', '2024-11-06 16:20:04'),
(105, '101', 'EC - 14 A', 'Good', NULL, NULL, NULL, 50.00, 2, NULL, 1, 1, NULL, NULL, NULL, 1, '2024-11-06 16:20:50', '2024-11-06 16:20:50'),
(106, '106', 'asdasd', 'Raw', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-11-27 15:54:21', '2024-11-27 15:54:21'),
(107, '107', 'asdasd', 'Raw', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2024-11-27 15:54:36', '2024-11-27 15:54:36');

-- --------------------------------------------------------

--
-- Table structure for table `journals`
--

CREATE TABLE `journals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date DEFAULT NULL,
  `voucher_no` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `chart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Used when a client is both a customer and supplier. Represents the party entity.',
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `voucher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `invoice_master_id` bigint(20) UNSIGNED DEFAULT NULL,
  `production_id` bigint(20) DEFAULT NULL,
  `expense_id` bigint(20) UNSIGNED DEFAULT NULL,
  `debit` decimal(20,2) DEFAULT NULL,
  `credit` decimal(20,2) DEFAULT NULL,
  `trace` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL,
  `uuid` char(36) DEFAULT NULL,
  `collection_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `mime_type` varchar(255) DEFAULT NULL,
  `disk` varchar(255) NOT NULL,
  `conversions_disk` varchar(255) DEFAULT NULL,
  `size` bigint(20) UNSIGNED NOT NULL,
  `manipulations` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`manipulations`)),
  `custom_properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`custom_properties`)),
  `generated_conversions` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`generated_conversions`)),
  `responsive_images` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`responsive_images`)),
  `order_column` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_09_17_143232_create_customers_table', 1),
(6, '2024_10_04_113017_create_brands_table', 1),
(7, '2024_10_04_113109_create_categories_table', 1),
(8, '2024_10_04_130906_create_media_table', 2),
(17, '2024_10_04_132415_create_taxes_table', 3),
(18, '2024_10_04_132450_create_warehouses_table', 3),
(19, '2024_10_04_132519_create_units_table', 3),
(21, '2024_10_04_132612_create_variations_table', 4),
(22, '2024_10_04_145211_create_suppliers_table', 4),
(55, '2024_10_08_112110_create_prodcuts_table', 5),
(56, '2024_10_09_150731_create_items_table', 5),
(89, '2024_10_04_150554_create_parties_table', 6),
(91, '2024_10_23_135132_create_receipe_recipe_detail_table', 6),
(92, '2024_10_31_150317_create_party_warehouses_table', 6),
(95, '2024_11_07_115358_create_voucher_types_table', 7),
(102, '2024_11_02_105133_create_chart_of_accounts_table', 9),
(105, '2024_10_14_115800_create_invoice_master_detail_table', 10),
(106, '2024_11_04_104730_create_expenses_expense_details_table', 10),
(107, '2024_11_13_095414_create_vouchers_voucher_details_table', 10),
(108, '2024_11_13_121006_create_journals_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `parties`
--

CREATE TABLE `parties` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `party_type` varchar(255) DEFAULT NULL,
  `business_name` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `prefix` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `alternate_number` varchar(255) DEFAULT NULL,
  `landline` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tax_number` varchar(255) DEFAULT NULL,
  `opening_balance` decimal(22,4) DEFAULT 0.0000,
  `pay_term_type` enum('days','months') DEFAULT NULL,
  `credit_limit` decimal(22,4) DEFAULT NULL,
  `address_line_1` text DEFAULT NULL,
  `address_line_2` text DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `shipping_address` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `parties`
--

INSERT INTO `parties` (`id`, `type`, `party_type`, `business_name`, `name`, `prefix`, `first_name`, `middle_name`, `last_name`, `mobile`, `alternate_number`, `landline`, `email`, `tax_number`, `opening_balance`, `pay_term_type`, `credit_limit`, `address_line_1`, `address_line_2`, `city`, `state`, `country`, `zip_code`, `shipping_address`, `is_active`, `is_default`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'business', 'supplier', 'G N Food Rice polish', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'business', 'supplier', 'Khurrm Shahzad Rice Polish/ Nakoo', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'business', 'supplier', 'Akhter Hussain Wood Supplier', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'business', 'supplier', 'Al-Rehman Trader', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'business', 'supplier', 'Mudassir Trader', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'business', 'supplier', 'Poultry Men', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'business', 'supplier', 'Rehmet Protine', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'business', 'supplier', 'Roshin Marble Chips', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'business', 'supplier', 'Shamshad Coomission Shop nakoo& polish (Sajid) 3200', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'business', 'supplier', 'Akbri Store', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'business', 'supplier', 'Asia Protine', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'business', 'supplier', 'Ishfaq Ahmed Maez Dealer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'business', 'supplier', 'M.Ejaz Maez dealer Haripur', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'business', 'supplier', 'Kosar Oil Mills', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'business', 'supplier', 'Haji Ghaffar Ali Maez Dealer', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'business', 'supplier', 'Asia Protine (PBM)', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'business', 'supplier', 'RUB Associates', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'business', 'supplier', 'Zia Ur Rehman nakoo/Polish Gujranwala', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'business', 'supplier', 'Ali Trader Nakoo & Polish Gujranwala', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'business', 'supplier', 'Dawood Khan Maez Dealaer swat', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'business', 'supplier', 'Rehmat Protine', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'business', 'supplier', 'Iffco Pakistan ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'business', 'supplier', 'Asif Qarish ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'business', 'supplier', 'Mirza Imran ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'business', 'customer', NULL, '   ', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '2024-11-27 14:28:39'),
(26, 'business', 'customer', 'Grand Chiks Farm A', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'business', 'customer', 'Dr Asif Shair Mardan', '   ', NULL, NULL, NULL, NULL, '3094000467', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, 0, '0000-00-00 00:00:00', '2024-11-08 10:33:23'),
(28, 'business', 'supplier', 'Opening Balance', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0.0000, 'days', 0.0000, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 0, NULL, '2024-11-27 15:21:37', '2024-11-27 15:21:37');

-- --------------------------------------------------------

--
-- Table structure for table `party_warehouses`
--

CREATE TABLE `party_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `party_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `party_warehouses`
--

INSERT INTO `party_warehouses` (`id`, `party_id`, `name`, `location`, `city`, `created_at`, `updated_at`) VALUES
(2, 25, 'Warehouse 1', 'karachi', 'karachi', '2024-11-06 14:21:46', '2024-11-06 14:21:46');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prodcuts`
--

CREATE TABLE `prodcuts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `total_quantity` decimal(15,4) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` bigint(20) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recipe_detail`
--

CREATE TABLE `recipe_detail` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `recipe_id` bigint(20) UNSIGNED NOT NULL,
  `item_id` bigint(20) UNSIGNED NOT NULL,
  `unit_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` decimal(15,4) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `rate` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `name`, `rate`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Tax Free', 0.00, 1, '2024-10-04 09:10:26', '2024-10-04 09:10:26'),
(2, 'GST', 18.00, 1, '2024-10-04 09:10:26', '2024-10-04 09:10:26');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `base_unit` char(50) DEFAULT NULL,
  `child_unit` char(50) DEFAULT NULL,
  `base_unit_value` decimal(10,2) UNSIGNED DEFAULT NULL,
  `operator` char(1) DEFAULT NULL,
  `child_unit_value` decimal(10,2) UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `base_unit`, `child_unit`, `base_unit_value`, `operator`, `child_unit_value`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'KG', 'g', 1.00, '*', 1000.00, 1, '2024-10-04 09:10:26', '2024-10-04 09:10:26'),
(2, 'L', 'ml', 1.00, '*', 1000.00, 1, '2024-10-04 09:10:26', '2024-10-04 09:10:26'),
(3, 'Dozen', 'pc', 12.00, '*', 1.00, 0, '2024-10-04 09:10:26', '2024-10-04 09:10:26'),
(10, 'Mann (50KG)', 'KG', 50.00, '*', 1.00, 1, '2024-10-15 05:57:49', '2024-10-15 05:57:49');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `mobile_no` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `hint` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` varchar(255) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile_no`, `email`, `type`, `email_verified_at`, `password`, `hint`, `image`, `is_active`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '033309874587', 'demo@extbooks.com', 'admin', NULL, '$2y$10$8ZS3Fcdhsuh69e6YzuHJEejN9tmpYgKUsGza6OyYUJ19GtrvfMqau', '123456', NULL, '1', NULL, NULL, NULL),
(2, 'Afzal', '030052546', '030052546', 'saleman', NULL, '$2y$10$p/sOxN5pPxOPg7x07RyV9ePaqMnKMZxNGKDnthKKbMHV/Xk3h11S6', '12345678', NULL, '1', NULL, '2024-10-30 06:05:13', '2024-10-30 06:08:29'),
(3, 'Umar', '123456', 'saleman@extbooks.com', 'saleman', NULL, '$2y$10$koq.bikfs1Ua6QRY7KSrgObVpWnDGnCkwVGoXJzjg3iJLhB.chSTS', '12345678', NULL, '1', NULL, '2024-10-30 06:08:17', '2024-11-25 11:41:56');

-- --------------------------------------------------------

--
-- Table structure for table `variations`
--

CREATE TABLE `variations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`values`)),
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `variations`
--

INSERT INTO `variations` (`id`, `name`, `values`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Color', '[\"Red\",\"Blue\",\"Green\"]', 1, '2024-10-09 11:43:08', '2024-10-09 11:43:08'),
(2, 'Size', '[\"Small\",\"Medium\",\"Large\"]', 1, '2024-10-09 11:43:08', '2024-10-09 11:43:08');

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_no` varchar(255) NOT NULL,
  `date` date DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `chart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `total_amount` decimal(20,2) DEFAULT NULL,
  `attachment` varchar(255) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_details`
--

CREATE TABLE `voucher_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `voucher_id` bigint(20) UNSIGNED DEFAULT NULL,
  `date` date DEFAULT NULL,
  `voucher_no` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `chart_of_account_id` bigint(20) UNSIGNED DEFAULT NULL,
  `party_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Used when a client is both a customer and supplier. Represents the party entity.',
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `supplier_id` bigint(20) UNSIGNED DEFAULT NULL,
  `narration` text DEFAULT NULL,
  `reference_no` varchar(255) DEFAULT NULL,
  `debit` decimal(20,2) DEFAULT NULL,
  `credit` decimal(20,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `voucher_types`
--

CREATE TABLE `voucher_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `voucher_types`
--

INSERT INTO `voucher_types` (`id`, `code`, `name`, `created_at`, `updated_at`) VALUES
(1, 'BP', 'Bank Payment', NULL, NULL),
(2, 'BR', 'Bank Receipt', NULL, NULL),
(3, 'CP', 'Cash Payment', NULL, NULL),
(4, 'CR', 'Cash Receipt', NULL, NULL),
(5, 'JV', 'Journal Voucher', NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_finished_goods_stock_report`
-- (See below for the actual view)
--
CREATE TABLE `v_finished_goods_stock_report` (
`id` bigint(20) unsigned
,`name` varchar(255)
,`code` varchar(255)
,`unit_weight` decimal(20,2)
,`qty_in` decimal(37,2)
,`qty_out` decimal(37,2)
,`balance` decimal(38,2)
,`category_id` bigint(20) unsigned
,`category_name` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_item_stock_report`
-- (See below for the actual view)
--
CREATE TABLE `v_item_stock_report` (
`item_id` bigint(20) unsigned
,`qty_in` decimal(37,2)
,`qty_out` decimal(37,2)
,`balance` decimal(38,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_raw_material_stock_report`
-- (See below for the actual view)
--
CREATE TABLE `v_raw_material_stock_report` (
`name` varchar(255)
,`item_id` bigint(20) unsigned
,`qty_in` decimal(37,2)
,`qty_out` decimal(37,2)
,`balance` decimal(38,2)
,`base_unit` char(50)
,`unit_id` bigint(20) unsigned
,`purchase_unit_price` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_recipe_detail_stock`
-- (See below for the actual view)
--
CREATE TABLE `v_recipe_detail_stock` (
`name` varchar(255)
,`recipe_id` bigint(20) unsigned
,`item_id` bigint(20) unsigned
,`qty_in` decimal(37,2)
,`qty_out` decimal(37,2)
,`balance` decimal(38,2)
,`base_unit` char(50)
,`unit_id` bigint(20) unsigned
,`quantity` decimal(15,4)
,`purchase_unit_price` decimal(15,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `warehouses`
--

CREATE TABLE `warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `name`, `phone`, `email`, `address`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Main Warehouse', '123-456-7890', 'mainwarehouse@example.com', '123 Main St, Cityville, Country', 1, '2024-10-04 09:10:26', '2024-10-04 09:10:26'),
(2, 'Secondary Warehouse', '098-765-4321', 'secondarywarehouse@example.com', '456 Secondary St, Townsville, Country', 1, '2024-10-04 09:10:26', '2024-10-04 09:10:26'),
(3, 'Overseas Warehouse', '555-123-4567', 'overseaswarehouse@example.com', '789 Overseas Rd, Metropolis, Country', 1, '2024-10-04 09:10:26', '2024-10-04 09:10:26'),
(4, 'Backup Warehouse', '555-987-6543', 'backupwarehouse@example.com', '101 Backup Lane, Hamlet, Country', 0, '2024-10-04 09:10:26', '2024-10-04 09:10:26');

-- --------------------------------------------------------

--
-- Structure for view `v_finished_goods_stock_report`
--
DROP TABLE IF EXISTS `v_finished_goods_stock_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u257200899_kohisar`@`127.0.0.1` SQL SECURITY DEFINER VIEW `v_finished_goods_stock_report`  AS SELECT `items`.`id` AS `id`, `items`.`name` AS `name`, `items`.`code` AS `code`, `items`.`unit_weight` AS `unit_weight`, sum(if(`invoice_detail`.`type` = 'output',`invoice_detail`.`total_quantity`,0)) AS `qty_in`, sum(if(`invoice_detail`.`type` = 'invoice',`invoice_detail`.`total_quantity`,0)) AS `qty_out`, sum(if(`invoice_detail`.`type` = 'output',`invoice_detail`.`total_quantity`,0)) - sum(if(`invoice_detail`.`type` = 'invoice',`invoice_detail`.`total_quantity`,0)) AS `balance`, `items`.`category_id` AS `category_id`, `categories`.`name` AS `category_name` FROM ((`items` left join `invoice_detail` on(`invoice_detail`.`item_id` = `items`.`id`)) join `categories` on(`items`.`category_id` = `categories`.`id`)) WHERE `items`.`type` = 'Good' GROUP BY `items`.`id`, `items`.`name`, `items`.`code`, `items`.`unit_weight`, `items`.`category_id`, `categories`.`name` ;

-- --------------------------------------------------------

--
-- Structure for view `v_item_stock_report`
--
DROP TABLE IF EXISTS `v_item_stock_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u257200899_kohisar`@`127.0.0.1` SQL SECURITY DEFINER VIEW `v_item_stock_report`  AS SELECT `invoice_detail`.`item_id` AS `item_id`, sum(if(`invoice_detail`.`type` = 'receipt',`invoice_detail`.`net_weight`,0)) AS `qty_in`, sum(if(`invoice_detail`.`type` = 'production',`invoice_detail`.`net_weight`,0)) AS `qty_out`, sum(if(`invoice_detail`.`type` = 'receipt',`invoice_detail`.`net_weight`,0)) - sum(if(`invoice_detail`.`type` = 'production',`invoice_detail`.`net_weight`,0)) AS `balance` FROM `invoice_detail` GROUP BY `invoice_detail`.`item_id` ;

-- --------------------------------------------------------

--
-- Structure for view `v_raw_material_stock_report`
--
DROP TABLE IF EXISTS `v_raw_material_stock_report`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u257200899_kohisar`@`127.0.0.1` SQL SECURITY DEFINER VIEW `v_raw_material_stock_report`  AS SELECT `items`.`name` AS `name`, `items`.`id` AS `item_id`, ifnull(`v_item_stock_report`.`qty_in`,0) AS `qty_in`, ifnull(`v_item_stock_report`.`qty_out`,0) AS `qty_out`, ifnull(`v_item_stock_report`.`balance`,0) AS `balance`, `units`.`base_unit` AS `base_unit`, `items`.`unit_id` AS `unit_id`, (select `invoice_detail`.`per_unit_price` from `invoice_detail` where `invoice_detail`.`type` = 'receipt' and `invoice_detail`.`item_id` = `items`.`id` order by `invoice_detail`.`date` desc limit 1) AS `purchase_unit_price` FROM ((`items` left join `v_item_stock_report` on(`items`.`id` = `v_item_stock_report`.`item_id`)) join `units` on(`units`.`id` = `items`.`unit_id`)) ;

-- --------------------------------------------------------

--
-- Structure for view `v_recipe_detail_stock`
--
DROP TABLE IF EXISTS `v_recipe_detail_stock`;

CREATE ALGORITHM=UNDEFINED DEFINER=`u257200899_kohisar`@`127.0.0.1` SQL SECURITY DEFINER VIEW `v_recipe_detail_stock`  AS SELECT `items`.`name` AS `name`, `recipe_detail`.`recipe_id` AS `recipe_id`, `recipe_detail`.`item_id` AS `item_id`, ifnull(`v_item_stock_report`.`qty_in`,0) AS `qty_in`, ifnull(`v_item_stock_report`.`qty_out`,0) AS `qty_out`, ifnull(`v_item_stock_report`.`balance`,0) AS `balance`, `units`.`base_unit` AS `base_unit`, `recipe_detail`.`unit_id` AS `unit_id`, `recipe_detail`.`quantity` AS `quantity`, (select `invoice_detail`.`per_unit_price` from `invoice_detail` where `invoice_detail`.`type` = 'receipt' and `invoice_detail`.`item_id` = `recipe_detail`.`item_id` order by `invoice_detail`.`date` desc limit 1) AS `purchase_unit_price` FROM (((`recipe_detail` join `items` on(`items`.`id` = `recipe_detail`.`item_id`)) left join `v_item_stock_report` on(`recipe_detail`.`item_id` = `v_item_stock_report`.`item_id`)) join `units` on(`units`.`id` = `recipe_detail`.`unit_id`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chart_of_accounts_parent_id_foreign` (`parent_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `expenses_expense_no_unique` (`expense_no`);

--
-- Indexes for table `expense_details`
--
ALTER TABLE `expense_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `expense_details_expense_id_foreign` (`expense_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `invoice_detail_invoice_master_id_foreign` (`invoice_master_id`);

--
-- Indexes for table `invoice_master`
--
ALTER TABLE `invoice_master`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_master_invoice_no_unique` (`invoice_no`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journals`
--
ALTER TABLE `journals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `journals_voucher_id_foreign` (`voucher_id`),
  ADD KEY `journals_expense_id_foreign` (`expense_id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `media_uuid_unique` (`uuid`),
  ADD KEY `media_model_type_model_id_index` (`model_type`,`model_id`),
  ADD KEY `media_order_column_index` (`order_column`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parties_type_index` (`type`);

--
-- Indexes for table `party_warehouses`
--
ALTER TABLE `party_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `party_warehouses_party_id_foreign` (`party_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `prodcuts`
--
ALTER TABLE `prodcuts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recipe_detail`
--
ALTER TABLE `recipe_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recipe_detail_recipe_id_foreign` (`recipe_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `variations`
--
ALTER TABLE `variations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vouchers_voucher_no_unique` (`voucher_no`);

--
-- Indexes for table `voucher_details`
--
ALTER TABLE `voucher_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `voucher_details_voucher_id_foreign` (`voucher_id`);

--
-- Indexes for table `voucher_types`
--
ALTER TABLE `voucher_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `warehouses`
--
ALTER TABLE `warehouses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=531002;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `expense_details`
--
ALTER TABLE `expense_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `invoice_master`
--
ALTER TABLE `invoice_master`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `journals`
--
ALTER TABLE `journals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=109;

--
-- AUTO_INCREMENT for table `parties`
--
ALTER TABLE `parties`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `party_warehouses`
--
ALTER TABLE `party_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `prodcuts`
--
ALTER TABLE `prodcuts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recipe_detail`
--
ALTER TABLE `recipe_detail`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `variations`
--
ALTER TABLE `variations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vouchers`
--
ALTER TABLE `vouchers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_details`
--
ALTER TABLE `voucher_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `voucher_types`
--
ALTER TABLE `voucher_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `warehouses`
--
ALTER TABLE `warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chart_of_accounts`
--
ALTER TABLE `chart_of_accounts`
  ADD CONSTRAINT `chart_of_accounts_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `chart_of_accounts` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `expense_details`
--
ALTER TABLE `expense_details`
  ADD CONSTRAINT `expense_details_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD CONSTRAINT `invoice_detail_invoice_master_id_foreign` FOREIGN KEY (`invoice_master_id`) REFERENCES `invoice_master` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `journals`
--
ALTER TABLE `journals`
  ADD CONSTRAINT `journals_expense_id_foreign` FOREIGN KEY (`expense_id`) REFERENCES `expenses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journals_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `party_warehouses`
--
ALTER TABLE `party_warehouses`
  ADD CONSTRAINT `party_warehouses_party_id_foreign` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recipe_detail`
--
ALTER TABLE `recipe_detail`
  ADD CONSTRAINT `recipe_detail_recipe_id_foreign` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `voucher_details`
--
ALTER TABLE `voucher_details`
  ADD CONSTRAINT `voucher_details_voucher_id_foreign` FOREIGN KEY (`voucher_id`) REFERENCES `vouchers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
