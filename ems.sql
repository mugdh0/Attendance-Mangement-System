-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jan 31, 2019 at 02:04 PM
-- Server version: 10.1.36-MariaDB
-- PHP Version: 7.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ems`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_heads`
--

CREATE TABLE `account_heads` (
  `id` int(10) UNSIGNED NOT NULL,
  `head_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL,
  `name` varchar(191) DEFAULT NULL,
  `email` varchar(191) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `name`, `email`, `message`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'superadmin@gmail.com', 'Update own profile.', '2019-01-31 10:46:09', '2019-01-31 10:46:09'),
(2, 'Super Admin', 'superadmin@gmail.com', 'Add new department info', '2019-01-31 11:12:39', '2019-01-31 11:12:39'),
(3, 'Super Admin', 'superadmin@gmail.com', 'Add new user.', '2019-01-31 11:22:20', '2019-01-31 11:22:20'),
(4, 'Super Admin', 'superadmin@gmail.com', 'Add new user.', '2019-01-31 11:29:59', '2019-01-31 11:29:59'),
(5, 'Super Admin', 'superadmin@gmail.com', 'Update own profile.', '2019-01-31 11:32:53', '2019-01-31 11:32:53'),
(6, 'Dewan Meadown', 'superadmin@gmail.com', 'Update User Info', '2019-01-31 11:49:36', '2019-01-31 11:49:36'),
(7, 'Dewan Meadown', 'superadmin@gmail.com', 'Update User Info', '2019-01-31 11:56:03', '2019-01-31 11:56:03'),
(8, 'Dewan Meadown', 'superadmin@gmail.com', 'Update own profile.', '2019-01-31 12:28:12', '2019-01-31 12:28:12'),
(9, 'Dewan Meadown', 'uperadmin@gmail.com', 'Update own profile.', '2019-01-31 12:30:53', '2019-01-31 12:30:53'),
(10, 'Zahid Hasan Shaikat', 'zahidhassanshaikot@gmail.com', 'Update own profile.', '2019-01-31 12:37:07', '2019-01-31 12:37:07'),
(11, 'Zahid Hasan Shaikat', 'zahidhassanshaikot@gmail.com', 'Update own profile.', '2019-01-31 12:37:46', '2019-01-31 12:37:46'),
(12, 'Dewan Meadown', 'superadmin@gmail.com', 'Update own profile.', '2019-01-31 12:39:48', '2019-01-31 12:39:48'),
(13, 'Dewan Meadown', 'superadmin@gmail.com', 'Update own profile.', '2019-01-31 13:01:33', '2019-01-31 13:01:33'),
(14, 'Dewan Meadown', 'superadmin@gmail.com', 'Update User Info', '2019-01-31 13:02:44', '2019-01-31 13:02:44'),
(15, 'Dewan Meadown', 'superadmin@gmail.com', 'Update User Info', '2019-01-31 13:03:55', '2019-01-31 13:03:55'),
(16, 'Dewan Meadown', 'superadmin@gmail.com', 'Update User Info', '2019-01-31 13:04:17', '2019-01-31 13:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs_emp`
--

CREATE TABLE `activity_logs_emp` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `change_by` varchar(100) DEFAULT NULL,
  `message` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activity_logs_emp`
--

INSERT INTO `activity_logs_emp` (`id`, `user_id`, `change_by`, `message`, `created_at`, `updated_at`) VALUES
(1, 1, 'Me', 'Profile update.', '2019-01-31 10:46:09', '2019-01-31 10:46:09'),
(2, 1, 'Me', 'Profile update.', '2019-01-31 11:32:53', '2019-01-31 11:32:53'),
(3, 2, 'Super Admin', 'profile update.', '2019-01-31 11:49:36', '2019-01-31 11:49:36'),
(4, 2, 'Super Admin', 'profile update.', '2019-01-31 11:56:03', '2019-01-31 11:56:03'),
(5, 1, 'Me', 'Profile update.', '2019-01-31 12:28:12', '2019-01-31 12:28:12'),
(6, 1, 'Me', 'Profile update.', '2019-01-31 12:30:53', '2019-01-31 12:30:53'),
(7, 2, 'Me', 'Profile update.', '2019-01-31 12:37:07', '2019-01-31 12:37:07'),
(8, 2, 'Me', 'Profile update.', '2019-01-31 12:37:46', '2019-01-31 12:37:46'),
(9, 1, 'Me', 'Profile update.', '2019-01-31 12:39:48', '2019-01-31 12:39:48'),
(10, 1, 'Me', 'Profile update.', '2019-01-31 13:01:33', '2019-01-31 13:01:33'),
(11, 3, 'Super Admin', 'profile update.', '2019-01-31 13:02:44', '2019-01-31 13:02:44'),
(12, 3, 'Super Admin', 'profile update.', '2019-01-31 13:03:55', '2019-01-31 13:03:55'),
(13, 2, 'Super Admin', 'profile update.', '2019-01-31 13:04:17', '2019-01-31 13:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `app_setting`
--

CREATE TABLE `app_setting` (
  `id` int(11) NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `address` varchar(100) DEFAULT NULL,
  `logo` text,
  `payslip_note` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `app_setting`
--

INSERT INTO `app_setting` (`id`, `company_name`, `address`, `logo`, `payslip_note`, `created_at`, `updated_at`) VALUES
(1, 'bhit1', 'Dhanmondi-32', 'images/20190130161612logo5.png', 'go to accounts', '2019-01-30 07:48:35', '2019-01-30 19:34:30');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `dept_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept_head` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `dept_name`, `dept_head`, `short_description`, `created_at`, `updated_at`) VALUES
(1, 'Web Development', 'Shaon', NULL, '2019-01-31 11:12:39', '2019-01-31 11:12:39');

-- --------------------------------------------------------

--
-- Table structure for table `draft_msg`
--

CREATE TABLE `draft_msg` (
  `id` int(11) NOT NULL,
  `msg_sender` varchar(191) NOT NULL,
  `msg_receiver` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `cc` varchar(191) DEFAULT NULL,
  `msg` longtext NOT NULL,
  `starred` tinytext,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `emp_leave`
--

CREATE TABLE `emp_leave` (
  `id` int(11) NOT NULL,
  `paid_leave_amount` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `emp_leave`
--

INSERT INTO `emp_leave` (`id`, `paid_leave_amount`, `created_at`, `updated_at`) VALUES
(1, 16, '2019-01-14 18:00:00', '2019-01-22 14:18:29');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

CREATE TABLE `expenses` (
  `id` int(10) UNSIGNED NOT NULL,
  `accHead` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `holiday_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inbox`
--

CREATE TABLE `inbox` (
  `id` int(11) NOT NULL,
  `msg_sender` varchar(200) NOT NULL,
  `msg_receiver` varchar(191) NOT NULL,
  `subject` varchar(191) DEFAULT NULL,
  `cc` varchar(191) DEFAULT NULL,
  `msg` longtext,
  `starred` tinyint(4) DEFAULT NULL,
  `notification_status` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `incomes`
--

CREATE TABLE `incomes` (
  `id` int(10) UNSIGNED NOT NULL,
  `accHead` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `amount` double(8,2) NOT NULL,
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `emp_db_id` int(11) NOT NULL,
  `leave_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `day` int(11) DEFAULT NULL,
  `reason` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_10_17_083520_entrust_setup_tables', 1),
(4, '2018_12_13_053343_create_leave_requests_table', 2),
(5, '2018_12_14_113212_create_holidays_table', 3),
(6, '2018_12_14_142531_create_departments_table', 4),
(7, '2018_12_17_111148_create_incomes_table', 5),
(8, '2018_12_17_151906_create_account_heads_table', 6),
(9, '2018_12_18_105415_create_expenses_table', 7),
(10, '2018_12_18_123938_create_salaries_table', 8),
(11, '2018_12_18_124821_create_salary_histories_table', 9),
(12, '2018_12_18_125412_create_payslips_table', 10);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payslips`
--

CREATE TABLE `payslips` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_name` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_id` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `employee_role` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employee_dept` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_image` text COLLATE utf8mb4_unicode_ci,
  `basic_salary` double(8,2) DEFAULT NULL,
  `house_rent_allowance` double(8,2) DEFAULT NULL,
  `bonus` double(8,2) DEFAULT NULL,
  `conveyance` double(8,2) DEFAULT NULL,
  `other_allowance` double(8,2) DEFAULT NULL,
  `TDS` double(8,2) DEFAULT NULL,
  `provident_fund` double(8,2) DEFAULT NULL,
  `c_bank_loan` double(8,2) DEFAULT NULL,
  `other_deductions` double(8,2) DEFAULT NULL,
  `notification_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `confirmation_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_status` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Unpaid',
  `pay_date` date DEFAULT NULL,
  `emp_comment` text COLLATE utf8mb4_unicode_ci,
  `emp_performance` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE `permission_role` (
  `permission_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'Super Admin', 'Access All', NULL, NULL),
(2, 'Admin', 'Admin', 'Admin Role', NULL, NULL),
(3, 'Employee', 'Employee', 'Employee Role', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE `role_user` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `role_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 3),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `salaries`
--

CREATE TABLE `salaries` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` bigint(20) NOT NULL,
  `basic_salary` double(8,2) NOT NULL,
  `house_rent_allowance` double(8,2) DEFAULT NULL,
  `bonus` double(8,2) DEFAULT NULL,
  `conveyance` double(8,2) DEFAULT NULL,
  `other_allowance` double(8,2) DEFAULT NULL,
  `TDS` double(8,2) DEFAULT NULL,
  `provident_fund` double(8,2) DEFAULT NULL,
  `c_bank_loan` double(8,2) DEFAULT NULL,
  `other_deductions` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salary_histories`
--

CREATE TABLE `salary_histories` (
  `id` int(10) UNSIGNED NOT NULL,
  `employee_id` int(11) NOT NULL,
  `current_basic_sallary` double(8,2) DEFAULT NULL,
  `previous_basic_sallary` double(8,2) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone_no` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `emp_id` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `join_date` date DEFAULT NULL,
  `role` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dept_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `job_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gender` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `blood_group` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `branch` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bank_ac` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `facebook_link` text COLLATE utf8mb4_unicode_ci,
  `twitter_link` text COLLATE utf8mb4_unicode_ci,
  `linkedin_link` text COLLATE utf8mb4_unicode_ci,
  `git_link` text COLLATE utf8mb4_unicode_ci,
  `profile_photo` text COLLATE utf8mb4_unicode_ci,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  `created_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_by` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_payslip_send` date DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone_no`, `emp_id`, `join_date`, `role`, `dept_name`, `job_status`, `gender`, `date_of_birth`, `blood_group`, `bank_name`, `branch`, `bank_ac`, `facebook_link`, `twitter_link`, `linkedin_link`, `git_link`, `profile_photo`, `active`, `created_by`, `updated_by`, `last_payslip_send`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Dewan Meadown', 'superadmin@gmail.com', '01714533215', 'zzz', NULL, 'CEO', NULL, NULL, 'Male', '1993-12-25', 'B+', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'images/20190131173249ProfilePic8.jpg', 1, NULL, NULL, NULL, NULL, '$2y$10$RreM9vsaPdXTu/sBj4ZwYetQ58kFoN4bRdN/jo6UvHGKtb5qOUiwa', NULL, '2019-01-31 10:41:04', '2019-01-31 13:01:33'),
(2, 'Zahid Hasan Shaikat', 'zahidhassanshaikot@gmail.com', '01985986986', 'BHIT-E1803', '2018-09-01', 'Web Developer', 'Web Development', 'Permanent', 'Male', '1996-05-17', 'B+', 'DBBL', 'Pranthopath', '255 151 38795', 'https://www.facebook.com/zahidhassanshaikot', NULL, 'https://bd.linkedin.com/in/zahidhassanshaikot', 'https://github.com/zahidhassanshaikot', 'images/20190131172216ProfilePic9.jpg', 1, 'Super Admin', 'Dewan Meadown', NULL, NULL, '$2y$10$zNeqdUokn9IZS0CuDCP.WO0yGSBh0w00szFeNFzpI1MooQq1kGZJ.', '4fPSnw1SAVr78wBMqbnYgt0hCc0R9h0wh992HRvZ43PL36jSJyyA4MnWdtlS', '2019-01-31 11:22:19', '2019-01-31 13:04:17'),
(3, 'Shadiqur Rahaman', 'shadiqurshaon.office@gmail.com', '01737030457', 'BHIT-E1804', '2018-12-01', 'Web Developer', 'Web Development', 'Provision Period', 'Male', '1992-01-20', 'B+', 'Duch-bangla bank ltd', 'Adabor,mohammadpur', '258.151.64603', NULL, NULL, NULL, NULL, NULL, 1, 'Super Admin', 'Dewan Meadown', NULL, NULL, '$2y$10$y3bGz.W0JQCMXEyrhEw.Yu5h/5JCcmXUPcPMfKE9C48HlIVmwBmf.', NULL, '2019-01-31 11:29:59', '2019-01-31 13:03:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_heads`
--
ALTER TABLE `account_heads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `activity_logs_emp`
--
ALTER TABLE `activity_logs_emp`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `app_setting`
--
ALTER TABLE `app_setting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `draft_msg`
--
ALTER TABLE `draft_msg`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emp_leave`
--
ALTER TABLE `emp_leave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inbox`
--
ALTER TABLE `inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payslips`
--
ALTER TABLE `payslips`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `salaries`
--
ALTER TABLE `salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `salary_histories`
--
ALTER TABLE `salary_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_heads`
--
ALTER TABLE `account_heads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `activity_logs_emp`
--
ALTER TABLE `activity_logs_emp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `app_setting`
--
ALTER TABLE `app_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `draft_msg`
--
ALTER TABLE `draft_msg`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emp_leave`
--
ALTER TABLE `emp_leave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expenses`
--
ALTER TABLE `expenses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inbox`
--
ALTER TABLE `inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `incomes`
--
ALTER TABLE `incomes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `payslips`
--
ALTER TABLE `payslips`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `salaries`
--
ALTER TABLE `salaries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salary_histories`
--
ALTER TABLE `salary_histories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_user`
--
ALTER TABLE `role_user`
  ADD CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
