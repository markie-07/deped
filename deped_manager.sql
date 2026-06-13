-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 13, 2026 at 10:10 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `deped_manager`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

CREATE TABLE `audit_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `model_type` varchar(255) DEFAULT NULL,
  `model_id` bigint(20) UNSIGNED DEFAULT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `model_type`, `model_id`, `details`, `ip_address`, `user_agent`, `created_at`, `updated_at`) VALUES
(1, 1, 'Bulk processed 1 records', NULL, NULL, 'New Batch ID: 2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 02:36:42', '2026-04-15 02:36:42'),
(2, 1, 'Bulk processed 1 records', NULL, NULL, 'New Batch ID: 4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 02:39:42', '2026-04-15 02:39:42'),
(3, 2, 'Bulk processed 1 records', NULL, NULL, 'New Batch ID: 6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 03:36:46', '2026-04-15 03:36:46'),
(4, 3, 'Bulk processed 1 records', NULL, NULL, 'New Batch ID: 8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 03:40:13', '2026-04-15 03:40:13'),
(5, 3, 'Created leave record', 'LeaveRecord', 5, 'Employee: mark, Type: FL', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 03:41:32', '2026-04-15 03:41:32'),
(6, 3, 'Bulk processed 1 records', NULL, NULL, 'New Batch ID: 10', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-15 03:41:35', '2026-04-15 03:41:35');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `forwarded` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `type_of_leave` varchar(255) DEFAULT NULL,
  `inclusive_dates` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `date_of_action` date DEFAULT NULL,
  `deduction_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `incharge` varchar(255) DEFAULT NULL,
  `assigned` varchar(255) DEFAULT 'national'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `user_id`, `name`, `forwarded`, `position`, `school`, `type_of_leave`, `inclusive_dates`, `remarks`, `date_of_action`, `deduction_remarks`, `created_at`, `updated_at`, `incharge`, `assigned`) VALUES
(1, 3, 'mark', 'Sdo', 'ada lll', 'sfhs', 'FL', '1/1/26', 'With Pay', '2026-04-15', NULL, '2026-04-15 03:41:32', '2026-04-15 03:41:32', 'Mark Pisngot', 'national');

-- --------------------------------------------------------

--
-- Table structure for table `face_recognition_logs`
--

CREATE TABLE `face_recognition_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `distance` decimal(10,6) NOT NULL,
  `confidence` decimal(5,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `attempt_image` text DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `ip_address` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
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
-- Table structure for table `forwardeds`
--

CREATE TABLE `forwardeds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `type_of_leave` varchar(255) DEFAULT NULL,
  `inclusive_dates` varchar(255) DEFAULT NULL,
  `date_of_action` date DEFAULT NULL,
  `deduction_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `forwardeds`
--

INSERT INTO `forwardeds` (`id`, `name`, `employee_name`, `position`, `school`, `type_of_leave`, `inclusive_dates`, `date_of_action`, `deduction_remarks`, `created_at`, `updated_at`) VALUES
(1, 'Sdo', 'mark', 'ada lll', 'sfhs', 'FL', '1/1/26', '2026-04-15', NULL, '2026-04-15 03:41:32', '2026-04-15 03:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_records`
--

CREATE TABLE `leave_records` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `forwarded` varchar(255) DEFAULT NULL,
  `position` varchar(255) NOT NULL,
  `school` varchar(255) NOT NULL,
  `type_of_leave` varchar(255) NOT NULL,
  `inclusive_dates` varchar(255) NOT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `date_of_action` date DEFAULT NULL,
  `deduction_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `incharge` varchar(255) DEFAULT NULL,
  `is_processed` tinyint(1) NOT NULL DEFAULT 0,
  `processed_at` timestamp NULL DEFAULT NULL,
  `batch_id` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `assigned` varchar(255) DEFAULT 'national'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_records`
--

INSERT INTO `leave_records` (`id`, `user_id`, `name`, `forwarded`, `position`, `school`, `type_of_leave`, `inclusive_dates`, `remarks`, `date_of_action`, `deduction_remarks`, `created_at`, `updated_at`, `incharge`, `is_processed`, `processed_at`, `batch_id`, `assigned`) VALUES
(1, 1, 'Pisngot, Mark J.', NULL, 'ADA lll', 'SDO-Caloocan City', 'VL', '1/1/26', 'With Pay', '2026-04-15', NULL, '2026-04-15 02:36:19', '2026-04-15 02:36:42', 'Mark James', 1, '2026-04-15 02:36:42', 2, 'national'),
(2, 1, 'Cabales, Edmalyn', NULL, 'ADA lll', 'SDO-Caloocan City', 'VL', '1/1/26', 'With Pay', '2026-04-15', NULL, '2026-04-15 02:39:03', '2026-04-15 02:39:42', 'Mark James', 1, '2026-04-15 02:39:42', 4, 'city'),
(3, 2, 'Pisngot, Mark J.', NULL, 'ADA lll', 'SDO-Caloocan City', 'VL', '1/1/26', 'Without Pay', '2026-04-15', '1', '2026-04-15 03:35:08', '2026-04-15 03:36:46', 'Edmalyn', 1, '2026-04-15 03:36:46', 6, 'national'),
(4, 3, 'Pisngot, Mark J.', NULL, 'ADA lll', 'SDO-Caloocan City', 'VL', '1', 'With Pay', '2026-04-15', NULL, '2026-04-15 03:40:03', '2026-04-15 03:40:13', 'Mark', 1, '2026-04-15 03:40:13', 8, 'national'),
(5, 3, 'mark', 'Sdo', 'ada lll', 'sfhs', 'FL', '1/1/26', 'With Pay', '2026-04-15', NULL, '2026-04-15 03:41:32', '2026-04-15 03:41:35', 'Mark Pisngot', 1, '2026-04-15 03:41:35', 10, 'National');

-- --------------------------------------------------------

--
-- Table structure for table `leave_types`
--

CREATE TABLE `leave_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `inclusive_dates` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `date_of_action` date DEFAULT NULL,
  `deduction_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned` varchar(255) DEFAULT 'national'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `leave_types`
--

INSERT INTO `leave_types` (`id`, `name`, `employee_name`, `position`, `school`, `inclusive_dates`, `remarks`, `date_of_action`, `deduction_remarks`, `created_at`, `updated_at`, `assigned`) VALUES
(1, 'FL', 'mark', 'ada lll', 'sfhs', '1/1/26', 'With Pay', '2026-04-15', NULL, '2026-04-15 03:41:32', '2026-04-15 03:41:32', 'national');

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
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_18_024323_create_leave_records_table', 1),
(5, '2026_02_18_080007_create_schools_table', 1),
(6, '2026_02_18_080008_create_leave_types_table', 1),
(7, '2026_02_18_080008_create_positions_table', 1),
(8, '2026_02_18_080009_create_remarks_table', 1),
(9, '2026_02_18_083001_update_directory_tables_add_full_record_info', 1),
(10, '2026_02_21_121746_create_employees_table', 1),
(11, '2026_02_21_141619_add_incharge_to_leave_records_and_employees_tables', 1),
(12, '2026_02_22_102903_add_department_to_leave_records_and_employees_table', 1),
(13, '2026_02_22_102951_create_departments_table', 1),
(14, '2026_02_24_054019_add_is_processed_to_leave_records_table', 1),
(15, '2026_02_24_055522_add_batch_id_to_leave_records_table', 1),
(16, '2026_02_25_005116_rename_department_to_forwarded', 1),
(17, '2026_03_02_060713_add_is_active_to_users_table', 1),
(18, '2026_03_02_061929_add_profile_fields_to_users_table', 1),
(19, '2026_03_03_070000_add_role_to_users_table', 1),
(20, '2026_03_03_080406_add_user_id_to_leave_records_table', 1),
(21, '2026_03_03_080710_add_user_id_to_employees_table', 1),
(22, '2026_03_03_084350_add_processed_at_to_leave_records_table', 1),
(23, '2026_03_04_024406_add_cover_image_to_users_table', 1),
(24, '2026_03_04_034256_add_image_offsets_to_users_table', 1),
(25, '2026_03_04_074146_create_audit_logs_table', 1),
(26, '2026_03_10_065627_add_is_approved_to_users_table', 1),
(27, '2026_03_22_092000_add_face_descriptor_to_users_table', 1),
(28, '2026_03_22_175638_create_face_recognition_logs_table', 1),
(29, '2026_04_02_144212_add_attempt_image_to_face_recognition_logs_table', 1),
(30, '2026_04_02_150155_add_attempt_image_to_face_recognition_logs', 1),
(31, '2026_04_02_151500_add_attempt_image_to_face_recognition_logs_table', 1),
(32, '2026_04_02_160500_revert_attempt_image_to_text', 1),
(33, '2026_04_02_161408_change_attempt_image_to_text_in_face_logs', 1),
(34, '2026_04_02_161500_convert_image_to_url', 1),
(35, '2026_04_02_192344_add_assigned_to_users_table', 1),
(36, '2026_04_02_192924_add_assigned_to_directory_tables', 1),
(37, '2026_04_06_010000_add_face_lockout_to_users_table', 1),
(38, '2026_04_06_113840_add_email_hash_to_users_table', 1),
(39, '2026_04_06_145000_drop_username_from_users_table', 1),
(40, '2026_04_08_130818_drop_name_from_users_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `type_of_leave` varchar(255) DEFAULT NULL,
  `inclusive_dates` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `date_of_action` date DEFAULT NULL,
  `deduction_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned` varchar(255) DEFAULT 'national'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `positions`
--

INSERT INTO `positions` (`id`, `name`, `employee_name`, `school`, `type_of_leave`, `inclusive_dates`, `remarks`, `date_of_action`, `deduction_remarks`, `created_at`, `updated_at`, `assigned`) VALUES
(1, 'ada lll', 'mark', 'sfhs', 'FL', '1/1/26', 'With Pay', '2026-04-15', NULL, '2026-04-15 03:41:32', '2026-04-15 03:41:32', 'national');

-- --------------------------------------------------------

--
-- Table structure for table `remarks`
--

CREATE TABLE `remarks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `school` varchar(255) DEFAULT NULL,
  `type_of_leave` varchar(255) DEFAULT NULL,
  `inclusive_dates` varchar(255) DEFAULT NULL,
  `date_of_action` date DEFAULT NULL,
  `deduction_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned` varchar(255) DEFAULT 'national'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `remarks`
--

INSERT INTO `remarks` (`id`, `name`, `employee_name`, `position`, `school`, `type_of_leave`, `inclusive_dates`, `date_of_action`, `deduction_remarks`, `created_at`, `updated_at`, `assigned`) VALUES
(1, 'With Pay', 'mark', 'ada lll', 'sfhs', 'FL', '1/1/26', '2026-04-15', NULL, '2026-04-15 03:41:32', '2026-04-15 03:41:32', 'national');

-- --------------------------------------------------------

--
-- Table structure for table `schools`
--

CREATE TABLE `schools` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `type_of_leave` varchar(255) DEFAULT NULL,
  `inclusive_dates` varchar(255) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `date_of_action` date DEFAULT NULL,
  `deduction_remarks` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `assigned` varchar(255) DEFAULT 'national'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schools`
--

INSERT INTO `schools` (`id`, `name`, `type`, `employee_name`, `position`, `type_of_leave`, `inclusive_dates`, `remarks`, `date_of_action`, `deduction_remarks`, `created_at`, `updated_at`, `assigned`) VALUES
(1, 'sfhs', 'Other', 'mark', 'ada lll', 'FL', '1/1/26', 'With Pay', '2026-04-15', NULL, '2026-04-15 03:41:32', '2026-04-15 03:41:32', 'national');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('H3QUoDVZuQRKwFuFKye7ekz97iWgwIpKLSjPxiHa', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRjl4QnV6RUF4ZGd6NTV5WkZkdGl6UDlvR24xbzhkdHNkU0NRdEFtSCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MTk6Imh0dHBzOi8vZGVwZWQubG9jYWwiO3M6NToicm91dGUiO3M6NToibG9naW4iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1780800880),
('KMOFNTowvkMzCHDJLCg8QlpfBTC0OJzZFSO9hx1C', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiUUZ2aHJqZDJZaXdGcTdIeDVXMFFNNUhINTJiOEViVjRucmpjOW1NQyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDk6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sZWF2ZS1yZWNvcmRzL2Ryb3Bkb3duLWRhdGEiO3M6NToicm91dGUiO047fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6OToib3RwX2VtYWlsIjtzOjI1OiJtYXJramFtZXNwMTE3NzBAZ21haWwuY29tIjtzOjEzOiJvdHBfdXNlcl9uYW1lIjtzOjI2OiJNYXJrIEphbWVzIEdhYnJpZWwgUGlzbmdvdCI7czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjEzOiJhdXRoZW50aWNhdGVkIjtiOjE7czo3OiJ1c2VyX2lkIjtpOjE7fQ==', 1781338104),
('YssBMykVtUUNOYSjwxH96U6AnVBX1jz7lGBY4UsT', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiWkhFOHNuOFRrc0paMXA5NUFlcmdRZjRFbld1enNQTFlNWEZZU005cCI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hcGkvbGVhdmUtcmVjb3Jkcy8zIjtzOjU6InJvdXRlIjtOO31zOjk6Im90cF9lbWFpbCI7czoyNToibWFya2phbWVzcDExNzcwQGdtYWlsLmNvbSI7czoxMzoib3RwX3VzZXJfbmFtZSI7czoyNjoiTWFyayBKYW1lcyBHYWJyaWVsIFBpc25nb3QiO3M6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czoxMzoiYXV0aGVudGljYXRlZCI7YjoxO3M6NzoidXNlcl9pZCI7aToxO30=', 1776224596);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `suffix` varchar(255) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `profile_offset_x` double NOT NULL DEFAULT 0,
  `profile_offset_y` double NOT NULL DEFAULT 0,
  `profile_zoom` double NOT NULL DEFAULT 1,
  `cover_image` varchar(255) DEFAULT NULL,
  `cover_offset_x` double NOT NULL DEFAULT 50,
  `cover_offset_y` double NOT NULL DEFAULT 50,
  `cover_zoom` double NOT NULL DEFAULT 1,
  `face_descriptor` text DEFAULT NULL,
  `face_attempts` int(11) NOT NULL DEFAULT 0,
  `face_locked_until` timestamp NULL DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_hash` varchar(255) DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_approved` tinyint(1) NOT NULL DEFAULT 1,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `assigned` varchar(255) DEFAULT 'national',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `last_name`, `first_name`, `middle_name`, `suffix`, `position`, `profile_image`, `profile_offset_x`, `profile_offset_y`, `profile_zoom`, `cover_image`, `cover_offset_x`, `cover_offset_y`, `cover_zoom`, `face_descriptor`, `face_attempts`, `face_locked_until`, `email`, `email_hash`, `email_verified_at`, `password`, `is_active`, `is_approved`, `role`, `assigned`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Pisngot', 'Mark James', 'Gabriel', NULL, 'ADMIN', NULL, 0, 0, 1, NULL, 50, 50, 1, NULL, 0, NULL, 'eyJpdiI6IkNNTUJXWTZibGhIbHQ2dTUrWTBRWlE9PSIsInZhbHVlIjoiQ3RQZWhBR1lHYUo3SEU5NXBWMzN0TkQzLzlFcjRrWHhvK1VlK2syaHJGYz0iLCJtYWMiOiJjZTEzMjE5OTIyNDcyYTM5ZTM0M2NjNzQ4M2JiMjJhYThkMjFkOTMzMWI3ZDU2NmFhMzg5ZDYxMzNmZmJlMzZiIiwidGFnIjoiIn0=', 'c4ce7b59473c19738ef1b79dff7f6a2062033d6d7164df557647d05b35948bd4', '2026-04-15 02:04:09', '$2y$12$34AI2QJQzJsV7QVTvcHlPOCzlFXoZq3nBev/T9ZYUAfJH31vOg/26', 1, 1, 'admin', 'National', NULL, '2026-04-15 02:04:09', '2026-04-15 02:10:53'),
(2, 'Cabales', 'Edmalyn', NULL, NULL, NULL, NULL, 0, 0, 1, NULL, 50, 50, 1, NULL, 0, NULL, 'eyJpdiI6ImFDN1dwSnE5cXJnZ2pUdkxSYVBocXc9PSIsInZhbHVlIjoicFN2bU5oeFVNMzgrZ3dNbEMrQy90aHUvbFZUbUhOaGdrRDZCWC9RbTJLYz0iLCJtYWMiOiIzMDQ5ZTMzN2FiNDI3NjAyZGM1OWUyODRjZGVkYjE3MTYwMmZkNWI0ZmIxNjEwNTg5NGFkN2ExNGI3NjY3MjFjIiwidGFnIjoiIn0=', '5fd62b83b1c3755e2c45b449da9e2aaae4244598b8f30e2b222724303cb2dc18', NULL, '$2y$12$coDp78UireJxSFuiJKZCVeWqBSWzZ6WdRcKFu7e/ZBKuAI8pqlkFi', 1, 1, 'user', 'National', NULL, '2026-04-15 03:30:49', '2026-04-15 03:30:49'),
(3, 'Pisngot', 'Mark', NULL, NULL, NULL, NULL, 0, 0, 1, NULL, 50, 50, 1, NULL, 0, NULL, 'eyJpdiI6IkdQOEQ3cGx4Y09pcENqWi9ZUUlucVE9PSIsInZhbHVlIjoiejJwTHl3ZDZySWRmVE03WWdqT2xSVzBYUWRIWU5IUVNWdWxrYUNjN1h6cz0iLCJtYWMiOiI3ODA1YTVjMDFiNzYwMDAwMjVkNTMyNGY3NTkwNjM0Mjg3NGY2OTI4ZTQ2MDhlMjIwYTk0YWVhMjhlMWI4MDA2IiwidGFnIjoiIn0=', 'c6d15a8618268c7da6334dfcad20de308e2615d1b30469ded1bb39f45f94ef4a', NULL, '$2y$12$/tAmzV3xILHikq8g8U1fReM8XkAa23LUTWHabYC3IOzN7puI4HUgK', 1, 1, 'user', 'National', NULL, '2026-04-15 03:33:24', '2026-04-15 03:33:24');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `audit_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_user_id_foreign` (`user_id`);

--
-- Indexes for table `face_recognition_logs`
--
ALTER TABLE `face_recognition_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `face_recognition_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forwardeds`
--
ALTER TABLE `forwardeds`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `departments_name_unique` (`name`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_records`
--
ALTER TABLE `leave_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `leave_records_user_id_foreign` (`user_id`);

--
-- Indexes for table `leave_types`
--
ALTER TABLE `leave_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `leave_types_name_unique` (`name`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `positions_name_unique` (`name`);

--
-- Indexes for table `remarks`
--
ALTER TABLE `remarks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `remarks_name_unique` (`name`);

--
-- Indexes for table `schools`
--
ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `schools_name_unique` (`name`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_email_hash_index` (`email_hash`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_logs`
--
ALTER TABLE `audit_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `face_recognition_logs`
--
ALTER TABLE `face_recognition_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forwardeds`
--
ALTER TABLE `forwardeds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_records`
--
ALTER TABLE `leave_records`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `leave_types`
--
ALTER TABLE `leave_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `remarks`
--
ALTER TABLE `remarks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schools`
--
ALTER TABLE `schools`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_logs`
--
ALTER TABLE `audit_logs`
  ADD CONSTRAINT `audit_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `face_recognition_logs`
--
ALTER TABLE `face_recognition_logs`
  ADD CONSTRAINT `face_recognition_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `leave_records`
--
ALTER TABLE `leave_records`
  ADD CONSTRAINT `leave_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
