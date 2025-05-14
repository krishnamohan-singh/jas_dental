-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 12, 2024 at 11:15 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `docrib`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `username`, `email_verified_at`, `image`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'admin@site.com', 'admin', NULL, '6624ee96387ea1713696406.png', '$2y$12$nABVuRYGy4jPuV2llN48We0S1HVOgLGYPcJYAMg86h6/DobRMhIZS', 'J5IfgFVzpGQ9FLISwJdHkC18m3Wgm8B7ArWSUyyqCCE5JaLLd1nYmDn1fL8S', NULL, '2024-08-11 08:49:23');

-- --------------------------------------------------------

--
-- Table structure for table `admin_notifications`
--

CREATE TABLE `admin_notifications` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` int UNSIGNED NOT NULL DEFAULT '0',
  `user_id` int UNSIGNED NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `click_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_password_resets`
--

CREATE TABLE `admin_password_resets` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` int NOT NULL,
  `added_doctor_id` int DEFAULT '0',
  `added_assistant_id` int DEFAULT '0',
  `added_staff_id` int DEFAULT '0',
  `added_admin_id` tinyint(1) NOT NULL DEFAULT '0',
  `site` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` int NOT NULL,
  `disease` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `booking_date` date NOT NULL,
  `time_serial` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_status` tinyint(1) NOT NULL COMMENT '0⇾CASH_PAYMENT,\\r\\n1⇾PAID_PAYMENT,\\r\\n2⇾PENDING_PAYMENT',
  `trx` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `try` int NOT NULL DEFAULT '0',
  `is_complete` int NOT NULL DEFAULT '0',
  `is_delete` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1->YES, 0->NO',
  `delete_by_doctor` int DEFAULT '0',
  `delete_by_assistant` int DEFAULT '0',
  `delete_by_staff` int DEFAULT '0',
  `delete_by_admin` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assistants`
--

CREATE TABLE `assistants` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'contains full address',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT '1: Active, 2: Inactive',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assistant_doctor_tracks`
--

CREATE TABLE `assistant_doctor_tracks` (
  `id` bigint UNSIGNED NOT NULL,
  `assistant_id` int UNSIGNED NOT NULL,
  `doctor_id` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assistant_logins`
--

CREATE TABLE `assistant_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `assistant_id` int NOT NULL,
  `assistant_ip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assistant_password_resets`
--

CREATE TABLE `assistant_password_resets` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deposits`
--

CREATE TABLE `deposits` (
  `id` bigint UNSIGNED NOT NULL,
  `appointment_id` int UNSIGNED NOT NULL DEFAULT '0',
  `doctor_id` int UNSIGNED NOT NULL,
  `method_code` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `method_currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `final_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `detail` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `btc_amount` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `btc_wallet` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_try` int NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>success, 2=>pending, 3=>cancel',
  `from_api` tinyint(1) NOT NULL DEFAULT '0',
  `admin_feedback` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `success_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `failed_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_cron` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `device_tokens`
--

CREATE TABLE `device_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int UNSIGNED NOT NULL DEFAULT '0',
  `doctor_id` int NOT NULL,
  `staff_id` int NOT NULL DEFAULT '0',
  `assistant_id` int NOT NULL DEFAULT '0',
  `is_app` tinyint(1) NOT NULL DEFAULT '0',
  `token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'contains full address',
  `balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qualification` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `speciality` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `about` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `slot_type` tinyint UNSIGNED DEFAULT NULL COMMENT '1: Serial, 2:Time',
  `serial_or_slot` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `start_time` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `end_time` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `serial_day` int UNSIGNED NOT NULL DEFAULT '0',
  `max_serial` int UNSIGNED NOT NULL DEFAULT '0',
  `duration` int UNSIGNED NOT NULL DEFAULT '0',
  `fees` int UNSIGNED NOT NULL,
  `department_id` int UNSIGNED NOT NULL,
  `location_id` int UNSIGNED NOT NULL,
  `featured` tinyint UNSIGNED NOT NULL DEFAULT '0' COMMENT 'YES⇾1, NO⇾0',
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1' COMMENT ' 1: active, Inactive: 0\r\n',
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_logins`
--

CREATE TABLE `doctor_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` int NOT NULL,
  `doctor_ip` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `doctor_password_resets`
--

CREATE TABLE `doctor_password_resets` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education`
--

CREATE TABLE `education` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` int NOT NULL,
  `institution` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discipline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `experiences`
--

CREATE TABLE `experiences` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` int NOT NULL,
  `institution` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `discipline` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `period` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `extensions`
--

CREATE TABLE `extensions` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `script` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'object',
  `support` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'help section',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `extensions`
--

INSERT INTO `extensions` (`id`, `act`, `name`, `description`, `image`, `script`, `shortcode`, `support`, `status`, `created_at`, `updated_at`) VALUES
(1, 'tawk-chat', 'Tawk.to', 'Key location is shown bellow', 'tawky_big.png', '<script>\r\n                        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n                        (function(){\r\n                        var s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\n                        s1.async=true;\r\n                        s1.src=\"https://embed.tawk.to/{{app_key}}\";\r\n                        s1.charset=\"UTF-8\";\r\n                        s1.setAttribute(\"crossorigin\",\"*\");\r\n                        s0.parentNode.insertBefore(s1,s0);\r\n                        })();\r\n                    </script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"------\"}}', 'twak.png', 0, '2019-10-18 23:16:05', '2022-03-22 05:22:24'),
(2, 'google-recaptcha2', 'Google Recaptcha 2', 'Key location is shown bellow', 'recaptcha3.png', '\n<script src=\"https://www.google.com/recaptcha/api.js\"></script>\n<div class=\"g-recaptcha\" data-sitekey=\"{{site_key}}\" data-callback=\"verifyCaptcha\"></div>\n<div id=\"g-recaptcha-error\"></div>', '{\"site_key\":{\"title\":\"Site Key\",\"value\":\"6LdPC88fAAAAADQlUf_DV6Hrvgm-pZuLJFSLDOWV\"},\"secret_key\":{\"title\":\"Secret Key\",\"value\":\"6LdPC88fAAAAAG5SVaRYDnV2NpCrptLg2XLYKRKB\"}}', 'recaptcha.png', 0, '2019-10-18 23:16:05', '2024-08-11 04:56:43'),
(3, 'custom-captcha', 'Custom Captcha', 'Just put any random string', 'customcaptcha.png', NULL, '{\"random_key\":{\"title\":\"Random String\",\"value\":\"SecureString\"}}', 'na', 0, '2019-10-18 23:16:05', '2023-01-23 11:21:30'),
(4, 'google-analytics', 'Google Analytics', 'Key location is shown bellow', 'google_analytics.png', '<script async src=\"https://www.googletagmanager.com/gtag/js?id={{measurement_id}}\"></script>\n                <script>\n                  window.dataLayer = window.dataLayer || [];\n                  function gtag(){dataLayer.push(arguments);}\n                  gtag(\"js\", new Date());\n                \n                  gtag(\"config\", \"{{measurement_id}}\");\n                </script>', '{\"measurement_id\":{\"title\":\"Measurement ID\",\"value\":\"------\"}}', 'ganalytics.png', 0, NULL, '2023-01-09 09:48:37'),
(5, 'fb-comment', 'Facebook Comment ', 'Key location is shown bellow', 'Facebook.png', '<div id=\"fb-root\"></div><script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v4.0&appId={{app_key}}&autoLogAppEvents=1\"></script>', '{\"app_key\":{\"title\":\"App Key\",\"value\":\"----\"}}', 'fb_com.PNG', 0, NULL, '2023-02-19 03:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `forms`
--

CREATE TABLE `forms` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `form_data` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint UNSIGNED NOT NULL,
  `data_keys` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `data_values` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tempname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0' COMMENT 'Blog view count',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `frontends`
--

INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `views`, `created_at`, `updated_at`) VALUES
(1, 'seo.data', '{\"seo_image\":\"1\",\"keywords\":[\"admin\",\"doctor\",\"dental\",\"oncology\",\"health\",\"docrib\",\"cardiology\",\"gyneology\"],\"description\":\"DOCRIB is the best place to find your preferable specialist and doctors. So feel free to contact us and get the best experience.\",\"social_title\":\"Docrib - Doctor Appointment System\",\"social_description\":\"DOCRIB delivers, enables, and empowers care services that span every state in a person\'s health journey -from wellness and prevention to acute care to complex healthcare needs. Our site uses proprietary health signals and personalized interactions to drive better health outcomes across the full continuum of care.\",\"image\":\"66b87ea353bee1723367075.png\"}', NULL, 'basic', '', 0, '2020-07-04 23:42:52', '2024-08-11 03:04:36'),
(24, 'about.content', '{\"has_image\":\"1\",\"heading\":\"Latest News\",\"sub_heading\":\"Register New Account\",\"description\":\"fdg sdfgsdf g ggg\",\"about_icon\":\"<i class=\\\"las la-address-card\\\"><\\/i>\",\"background_image\":\"60951a84abd141620384388.png\",\"about_image\":\"5f9914e907ace1603867881.jpg\"}', NULL, 'basic', NULL, 0, '2020-10-28 00:51:20', '2021-05-07 10:16:28'),
(25, 'blog.content', '{\"heading\":\"Latest News\",\"subheading\":\"You will get all the latest news and health tips on our website. Keep an eye on our Latest News to be in touch.\"}', NULL, 'basic', NULL, 0, '2020-10-28 00:51:34', '2023-01-09 06:07:35'),
(26, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Three Ways to Address Burnout in Healthcare\",\"category\":\"Neurologist\",\"description_nic\":\"<p style=\\\"margin-bottom:1rem;\\\">Careers in medical practice management can be tough, but there are exceptional leaders who can master it all. Learn the key qualities you need for success.<\\/p><div class=\\\"ad-box\\\" style=\\\"text-align:center;\\\"><\\/div><div class=\\\"block-content mt-3\\\"><div><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">There is a significant opportunity in the U.S. for business-minded professionals to have a rewarding career in healthcare as practice managers.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">As in any profession, there are average managers who do an adequate job. And then there are the superstars-the managers who care deeply, work fervently, and deliver results time and time again.<\\/p><\\/div><div><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">So what sets these managers apart from others? What is the \\u201csecret sauce\\u201d to getting ahead as a practice manager? Let\\u2019s talk about five qualities superstar managers possess.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\"><br \\/><\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">\\u201cNever burn bridges,\\u201d says Cornelius, \\u201cbecause strong and healthy relationships are vital to success.\\u201d Learning to communicate, listen, and understand others will carry you extraordinarily far in your career.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\"><font face=\\\"sans-serif\\\">About the Author<\\/font><\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">Amy Boyer, MBA, is a consultant with\\u00a0<a href=\\\"https:\\/\\/www.karenzupko.com\\/\\\">Karen Zupko &amp; Associates, Inc.\\u00a0<\\/a>She has 15 years of experience working with physicians in private practice, hospital-based practice, and academic settings. Boyer specializes in practice operations, revenue cycle, and the use of technology to improve productivity. She frequently advises residents and young surgeons about employment agreements, compensation, and practice start-up issues.<\\/p><\\/div><\\/div>\",\"blog_image\":\"63bbd3d9b9c9f1673253849.jpg\"}', NULL, 'basic', 'three-ways-to-address-burnout-in-healthcare', 9, '2020-10-28 00:57:19', '2024-08-12 04:55:33'),
(27, 'contact_us.content', '{\"heading\":\"Stay Connect With Us\",\"subheading\":\"Please join the discussion and be connect with us.\",\"latitude\":\"23.80677638807498\",\"longitude\":\"90.36343624948555\"}', NULL, 'basic', '', 0, '2020-10-28 00:59:19', '2024-08-12 01:50:25'),
(28, 'counter.content', '{\"heading\":\"Latest News\",\"sub_heading\":\"Register New Account\"}', NULL, 'basic', NULL, 0, '2020-10-28 01:04:02', '2020-10-28 01:04:02'),
(31, 'social_icon.element', '{\"title\":\"Pinterest\",\"social_icon\":\"<i class=\\\"fab fa-pinterest\\\"><\\/i>\",\"url\":\"https:\\/\\/www.pinterest.com\\/\"}', NULL, 'basic', NULL, 0, '2020-11-12 04:07:30', '2023-01-08 09:27:00'),
(33, 'feature.content', '{\"heading\":\"Meet with our feature doctors\",\"subheading\":\"Meet with leading medical professionals represented across each medical specialty.\"}', NULL, 'basic', NULL, 0, '2021-01-03 23:40:54', '2023-01-09 04:18:30'),
(34, 'feature.element', '{\"title\":\"asdf\",\"description\":\"asdf\",\"feature_icon\":\"asdf\"}', NULL, 'basic', NULL, 0, '2021-01-03 23:41:02', '2021-01-03 23:41:02'),
(35, 'service.element', '{\"trx_type\":\"withdraw\",\"service_icon\":\"<i class=\\\"las la-highlighter\\\"><\\/i>\",\"title\":\"asdfasdf\",\"description\":\"asdfasdfasdfasdf\"}', NULL, 'basic', NULL, 0, '2021-03-06 01:12:10', '2021-03-06 01:12:10'),
(36, 'service.content', '{\"trx_type\":\"deposit\",\"heading\":\"asdf fffff\",\"subheading\":\"555\"}', NULL, 'basic', NULL, 0, '2021-03-06 01:27:34', '2022-03-30 08:07:06'),
(39, 'banner.content', '{\"heading\":\"Latest News\",\"sub_heading\":\"Lorem ipsum dolor sit, amet consectetur adipisicing elit. Esse voluptatum eaque earum quos quia? Id aspernatur ratione, voluptas nulla rerum laudantium neque ipsam eaque\"}', NULL, 'basic', NULL, 0, '2021-05-02 06:09:30', '2021-05-02 06:09:30'),
(41, 'cookie.data', '{\"short_desc\":\"We may use cookies or any other tracking technologies when you visit our website, including any other media form, mobile website, or mobile application related or connected to help customize the Site and improve your experience.\",\"description\":\"<div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">How do we protect your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">All provided delicate\\/credit data is sent through Stripe.<br>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won\'t be put away on our workers.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">Do we disclose any information to outside parties?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We don\'t sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">Children\'s Online Privacy Protection Act Compliance<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We are consistent with the prerequisites of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">Changes to our Privacy Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">How long we retain your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">At the point when you register for our site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">What we don\\u2019t do with your data<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We don\'t and will never share, unveil, sell, or in any case give your information to different organizations for the promoting of their items or administrations.<\\/p><\\/div>\",\"status\":1}', NULL, 'basic', NULL, 0, '2020-07-04 23:42:52', '2022-09-22 07:29:55'),
(42, 'policy_pages.element', '{\"title\":\"Privacy Policy\",\"details\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How do we protect your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">All provided delicate\\/credit data is sent through Stripe.<br \\/>After an exchange, your private data (credit cards, social security numbers, financials, and so on) won\'t be put away on our workers.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Do we disclose any information to outside parties?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t sell, exchange, or in any case move to outside gatherings by and by recognizable data. This does exclude confided in outsiders who help us in working our site, leading our business, or adjusting you, since those gatherings consent to keep this data private. We may likewise deliver your data when we accept discharge is suitable to follow the law, implement our site strategies, or ensure our own or others\' rights, property, or wellbeing.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Children\'s Online Privacy Protection Act Compliance<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We are consistent with the prerequisites of COPPA (Children\'s Online Privacy Protection Act), we don\'t gather any data from anybody under 13 years old. Our site, items, and administrations are completely coordinated to individuals who are in any event 13 years of age or more established.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Changes to our Privacy Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">If we decide to change our privacy policy, we will post those changes on this page.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">How long we retain your information?<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">At the point when you register for our site, we cycle and keep your information we have about you however long you don\'t erase the record or withdraw yourself (subject to laws and guidelines).<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">What we don\\u2019t do with your data<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t and will never share, unveil, sell, or in any case give your information to different organizations for the promoting of their items or administrations.<\\/p><\\/div>\"}', NULL, 'basic', 'privacy-policy', 0, '2021-06-09 08:50:42', '2021-06-09 08:50:42'),
(43, 'policy_pages.element', '{\"title\":\"Terms of Service\",\"details\":\"<div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We claim all authority to dismiss, end, or handicap any help with or without cause per administrator discretion. This is a Complete independent facilitating, on the off chance that you misuse our ticket or Livechat or emotionally supportive network by submitting solicitations or protests we will impair your record. The solitary time you should reach us about the seaward facilitating is if there is an issue with the worker. We have not many substance limitations and everything is as per laws and guidelines. Try not to join on the off chance that you intend to do anything contrary to the guidelines, we do check these things and we will know, don\'t burn through our own and your time by joining on the off chance that you figure you will have the option to sneak by us and break the terms.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><ul class=\\\"font-18\\\" style=\\\"padding-left:15px;list-style-type:disc;font-size:18px;\\\"><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Configuration requests - If you have a fully managed dedicated server with us then we offer custom PHP\\/MySQL configurations, firewalls for dedicated IPs, DNS, and httpd configurations.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Software requests - Cpanel Extension Installation will be granted as long as it does not interfere with the security, stability, and performance of other users on the server.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Emergency Support - We do not provide emergency support \\/ Phone Support \\/ LiveChat Support. Support may take some hours sometimes.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Webmaster help - We do not offer any support for webmaster related issues and difficulty including coding, &amp; installs, Error solving. if there is an issue where a library or configuration of the server then we can help you if it\'s possible from our end.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Backups - We keep backups but we are not responsible for data loss, you are fully responsible for all backups.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">We Don\'t support any child porn or such material.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No spam-related sites or material, such as email lists, mass mail programs, and scripts, etc.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No harassing material that may cause people to retaliate against you.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No phishing pages.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">You may not run any exploitation script from the server. reason can be terminated immediately.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">If Anyone attempting to hack or exploit the server by using your script or hosting, we will terminate your account to keep safe other users.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Malicious Botnets are strictly forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Spam, mass mailing, or email marketing in any way are strictly forbidden here.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Malicious hacking materials, trojans, viruses, &amp; malicious bots running or for download are forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Resource and cronjob abuse is forbidden and will result in suspension or termination.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Php\\/CGI proxies are strictly forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">CGI-IRC is strictly forbidden.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">No fake or disposal mailers, mass mailing, mail bombers, SMS bombers, etc.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">NO CREDIT OR REFUND will be granted for interruptions of service, due to User Agreement violations.<\\/li><\\/ul><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Terms &amp; Conditions for Users<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">Before getting to this site, you are consenting to be limited by these site Terms and Conditions of Use, every single appropriate law, and guidelines, and concur that you are answerable for consistency with any material neighborhood laws. If you disagree with any of these terms, you are restricted from utilizing or getting to this site.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Support<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">Whenever you have downloaded our item, you may get in touch with us for help through email and we will give a valiant effort to determine your issue. We will attempt to answer using the Email for more modest bug fixes, after which we will refresh the center bundle. Content help is offered to confirmed clients by Tickets as it were. Backing demands made by email and Livechat.<\\/p><p class=\\\"my-3 font-18 font-weight-bold\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">On the off chance that your help requires extra adjustment of the System, at that point, you have two alternatives:<\\/p><ul class=\\\"font-18\\\" style=\\\"padding-left:15px;list-style-type:disc;font-size:18px;\\\"><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Hang tight for additional update discharge.<\\/li><li style=\\\"margin-top:0px;margin-right:0px;margin-left:0px;\\\">Or on the other hand, enlist a specialist (We offer customization for extra charges).<\\/li><\\/ul><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Ownership<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">You may not guarantee scholarly or selective possession of any of our items, altered or unmodified. All items are property, we created them. Our items are given \\\"with no guarantees\\\" without guarantee of any sort, either communicated or suggested. On no occasion will our juridical individual be subject to any harms including, however not restricted to, immediate, roundabout, extraordinary, accidental, or significant harms or different misfortunes emerging out of the utilization of or powerlessness to utilize our items.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Warranty<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We don\'t offer any guarantee or assurance of these Services in any way. When our Services have been modified we can\'t ensure they will work with all outsider plugins, modules, or internet browsers. Program similarity ought to be tried against the show formats on the demo worker. If you don\'t mind guarantee that the programs you use will work with the component, as we can not ensure that our systems will work with all program mixes.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Unauthorized\\/Illegal Usage<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">You may not utilize our things for any illicit or unapproved reason or may you, in the utilization of the stage, disregard any laws in your locale (counting yet not restricted to copyright laws) just as the laws of your nation and International law. Specifically, it is disallowed to utilize the things on our foundation for pages that advance: brutality, illegal intimidation, hard sexual entertainment, bigotry, obscenity content or warez programming joins.<br \\/><br \\/>You can\'t imitate, copy, duplicate, sell, exchange or adventure any of our segment, utilization of the offered on our things, or admittance to the administration without the express composed consent by us or item proprietor.<br \\/><br \\/>Our Members are liable for all substance posted on the discussion and demo and movement that happens under your record.<br \\/><br \\/>We hold the chance of hindering your participation account quickly if we will think about a particularly not allowed conduct.<br \\/><br \\/>If you make a record on our site, you are liable for keeping up the security of your record, and you are completely answerable for all exercises that happen under the record and some other activities taken regarding the record. You should quickly inform us, of any unapproved employments of your record or some other penetrates of security.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Fiverr, Seoclerks Sellers Or Affiliates<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We do NOT ensure full SEO campaign conveyance within 24 hours. We make no assurance for conveyance time by any means. We give our best assessment to orders during the putting in of requests, anyway, these are gauges. We won\'t be considered liable for loss of assets, negative surveys or you being prohibited for late conveyance. If you are selling on a site that requires time touchy outcomes, utilize Our SEO Services at your own risk.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Payment\\/Refund Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">No refund or cash back will be made. After a deposit has been finished, it is extremely unlikely to invert it. You should utilize your equilibrium on requests our administrations, Hosting, SEO campaign. You concur that once you complete a deposit, you won\'t document a debate or a chargeback against us in any way, shape, or form.<br \\/><br \\/>If you document a debate or chargeback against us after a deposit, we claim all authority to end every single future request, prohibit you from our site. False action, for example, utilizing unapproved or taken charge cards will prompt the end of your record. There are no special cases.<\\/p><\\/div><div class=\\\"mb-5\\\" style=\\\"color:rgb(111,111,111);font-family:Nunito, sans-serif;margin-bottom:3rem;\\\"><h3 class=\\\"mb-3\\\" style=\\\"font-weight:600;line-height:1.3;font-size:24px;font-family:Exo, sans-serif;color:rgb(54,54,54);\\\">Free Balance \\/ Coupon Policy<\\/h3><p class=\\\"font-18\\\" style=\\\"margin-right:0px;margin-left:0px;font-size:18px;\\\">We offer numerous approaches to get FREE Balance, Coupons and Deposit offers yet we generally reserve the privilege to audit it and deduct it from your record offset with any explanation we may it is a sort of misuse. If we choose to deduct a few or all of free Balance from your record balance, and your record balance becomes negative, at that point the record will naturally be suspended. If your record is suspended because of a negative Balance you can request to make a custom payment to settle your equilibrium to actuate your record.<\\/p><\\/div>\"}', NULL, 'basic', 'terms-of-service', 0, '2021-06-09 08:51:18', '2021-06-09 08:51:18'),
(45, 'banner.element', '{\"has_image\":[\"1\"],\"heading\":\"Nothing is more important than wellness\",\"subheading\":\"Good health is the most precious thing to us! and that\'s why we are here to give you the best treatment with the help of the best doctors.\",\"image\":\"63ba9939291731673173305.jpg\"}', NULL, 'basic', NULL, 0, '2023-01-08 07:51:45', '2023-01-08 07:51:45'),
(46, 'banner.element', '{\"has_image\":\"1\",\"heading\":\"World class care right where you need it\",\"subheading\":\"Yes! you are in the right place, We deliver a world-class health service with the help of world-class doctors.\",\"image\":\"63ba99937926b1673173395.jpg\"}', NULL, 'basic', NULL, 0, '2023-01-08 07:53:15', '2023-01-08 07:53:15'),
(47, 'banner.element', '{\"has_image\":\"1\",\"heading\":\"Where there is healing there is hope\",\"subheading\":\"Experience the best health service with this site! Our doctors are well expert and give you the best service.\",\"image\":\"63ba99b3650ef1673173427.jpg\"}', NULL, 'basic', NULL, 0, '2023-01-08 07:53:47', '2023-01-22 08:22:01'),
(48, 'breadcrumb.content', '{\"has_image\":\"1\",\"image\":\"63ba9c1e5a3021673174046.jpg\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:04:06', '2023-01-08 08:04:06'),
(49, 'sector.content', '{\"heading\":\"Why patients choose us ?\",\"subheading\":\"Docrib is a globally recognized market leader in healthcare, with leading medical professionals represented across each medical specialty. Docrib delivers, enables, and empowers care services that span every state in a person\'s health journey -from wellness and prevention to acute care to complex healthcare needs. Our site uses proprietary health signals and personalized interactions to drive better health outcomes across the full continuum of care.\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:05:47', '2023-01-08 08:14:35'),
(50, 'doctor.content', '{\"heading\":\"Our expert doctors\",\"subheading\":\"Docrib is a globally recognized market leader in healthcare, with leading medical professionals represented across each medical specialty.\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:06:30', '2023-01-08 08:15:25'),
(51, 'search.content', '{\"has_image\":\"1\",\"heading\":\"Search doctor, Make an appointment\",\"subheading\":\"Discover the best doctors, clinics, and hospitals in the city nearest to you.\",\"image\":\"63ba9cdd04a751673174237.jpg\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:07:17', '2023-01-08 08:14:16'),
(52, 'testimonial.content', '{\"heading\":\"What people say about us\",\"subheading\":\"Docrib is globally recognized for the specialist and doctors. Take a look at what People Say About Us.\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:09:24', '2023-01-09 05:50:32'),
(53, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"John Bulger\",\"designation\":\"Geisinger Health Plan\",\"quote\":\"Working with Teladoc Health helps us to educate our providers and our nurses in understanding cues to identify patients and helps us run algorithms\",\"image\":\"63ba9f16b0a7e1673174806.png\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:16:46', '2023-01-08 08:16:46'),
(54, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Jemisn Hulux\",\"designation\":\"Health New England\",\"quote\":\"Making quality healthcare available to all of our community members without interruption is our #1 priority, and virtual care continues to make this possible.\",\"image\":\"63ba9f3008e7c1673174832.png\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:17:12', '2023-01-08 08:17:12'),
(55, 'testimonial.element', '{\"has_image\":\"1\",\"name\":\"Wax Polin\",\"designation\":\"American Heart Association\",\"quote\":\"People have become dependent on this virtual benefit. We have had so much positive feedback that we know we will always have this option available.\",\"image\":\"63ba9f4ee397e1673174862.png\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:17:42', '2023-01-08 08:17:42'),
(56, 'partner.element', '{\"has_image\":\"1\",\"name\":\"Crowa Hair Salon\",\"url\":\"https:\\/\\/www.youtube.com\\/\",\"image\":\"63baa11f2fc9a1673175327.png\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:25:27', '2023-01-08 08:25:27'),
(57, 'partner.element', '{\"has_image\":\"1\",\"name\":\"Iconic Means Wear\",\"url\":\"https:\\/\\/www.iconicmeanswear.com\\/\",\"image\":\"63baa13b336f71673175355.png\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:25:55', '2023-01-08 08:25:55'),
(58, 'partner.element', '{\"has_image\":\"1\",\"name\":\"Natural Directive Way\",\"url\":\"https:\\/\\/www.natural.com\\/\",\"image\":\"63baa15bc4dcb1673175387.png\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:26:27', '2023-01-08 08:26:27'),
(59, 'partner.element', '{\"has_image\":\"1\",\"name\":\"Urban City  Holding\",\"url\":\"https:\\/\\/www.urbancity.com\\/\",\"image\":\"63baa176eb5a01673175414.png\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:26:54', '2023-01-08 08:26:54'),
(60, 'partner.element', '{\"has_image\":\"1\",\"name\":\"The Metro Studio\",\"url\":\"https:\\/\\/www.metrostudio..com\\/\",\"image\":\"63baa1931c5d61673175443.png\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:27:23', '2023-01-08 08:27:23'),
(61, 'footer.content', '{\"has_image\":\"1\",\"emergency_contact\":\"+12345-678-9\",\"emergency_email\":\"info@domain.com\",\"footer_details\":\"DOCRIB is the best place to find your preferable specialist and doctors. So feel free to contact us and get the best experience.\",\"emergency_contact_image\":\"63baa6223fe2e1673176610.png\",\"emergency_email_image\":\"63baa622417af1673176610.png\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:46:50', '2023-01-08 08:46:50'),
(62, 'subscribe.content', '{\"heading\":\"Subscribe Newsletter\",\"subheading\":\"Once you subscribe to our newsletter, we will send our promo offers and news to your email.\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:47:38', '2023-02-11 10:03:18'),
(63, 'contact_us.element', '{\"title\":\"Mobile Number\",\"contact_icon\":\"<i class=\\\"fas fa-headphones\\\"><\\/i>\",\"content\":\"+88-123456789\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:50:00', '2023-01-08 08:50:00'),
(64, 'contact_us.element', '{\"title\":\"E-mail\",\"contact_icon\":\"<i class=\\\"far fa-envelope-open\\\"><\\/i>\",\"content\":\"demo@demo.com\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:50:36', '2023-01-08 08:50:36'),
(65, 'contact_us.element', '{\"title\":\"Address\",\"contact_icon\":\"<i class=\\\"fas fa-map-marked-alt\\\"><\\/i>\",\"content\":\"123 New Street, Melbourne , Australia 54214\"}', NULL, 'basic', NULL, 0, '2023-01-08 08:51:05', '2023-01-08 08:51:25'),
(66, 'social_icon.element', '{\"title\":\"Facebook\",\"social_icon\":\"<i class=\\\"fab fa-facebook\\\"><\\/i>\",\"url\":\"https:\\/\\/www.facebook.com\\/\"}', NULL, 'basic', NULL, 0, '2023-01-08 09:25:27', '2023-01-08 09:25:27'),
(67, 'social_icon.element', '{\"title\":\"Twitter\",\"social_icon\":\"<i class=\\\"fab fa-twitter-square\\\"><\\/i>\",\"url\":\"https:\\/\\/www.twitter.com\\/\"}', NULL, 'basic', NULL, 0, '2023-01-08 09:25:42', '2023-01-08 09:25:42'),
(68, 'social_icon.element', '{\"title\":\"Linkedin\",\"social_icon\":\"<i class=\\\"fab fa-linkedin\\\"><\\/i>\",\"url\":\"https:\\/\\/www.linkedin.com\\/\"}', NULL, 'basic', NULL, 0, '2023-01-08 09:26:13', '2023-01-08 09:26:13'),
(69, 'social_icon.element', '{\"title\":\"Youtube\",\"social_icon\":\"<i class=\\\"fab fa-youtube\\\"><\\/i>\",\"url\":\"https:\\/\\/www.youtube.com\\/\"}', NULL, 'basic', NULL, 0, '2023-01-08 09:26:34', '2023-01-08 09:26:34'),
(70, 'faq.content', '{\"heading\":\"Frequently Asked Questions\",\"subheading\":\"What People Asked From Us? We answer some of your Frequently Asked Questions regarding our platform. If you have a query that is not answered here, Please feel free to contact us.\"}', NULL, 'basic', NULL, 0, '2023-01-09 05:57:49', '2023-01-09 05:57:49'),
(71, 'faq.element', '{\"question\":\"The phone line is busy, is there something I can do about it?\",\"answer\":\"We try to give our best service to our patients and it can get very busy from time to time. Please try again a few minutes later or look at the solutions below.\"}', NULL, 'basic', NULL, 0, '2023-01-09 05:58:06', '2023-01-09 06:01:50'),
(72, 'faq.element', '{\"question\":\"Do you have after hours care?\",\"answer\":\"If you are having a life threatening emergency, call 911. If you call after clinic hours, the answering service will receive your call. They will take your name, phone number and nature of your call. The answering service will page the on-call physician who will call you back within 15 minutes.\"}', NULL, 'basic', NULL, 0, '2023-01-09 05:58:24', '2023-01-09 06:02:06'),
(73, 'faq.element', '{\"question\":\"If I call with a question for the nurse or doctor, when can I expect a call back?\",\"answer\":\"Our physicians and nurses are with patients throughout the day, so it is usually not possible for them to immediately answer phone calls. We will return your call as soon as possible. To help us get back to you quickly leave us your full name, date of birth, reason for the call and current phone number.\"}', NULL, 'basic', NULL, 0, '2023-01-09 05:58:33', '2023-01-09 06:02:43'),
(74, 'faq.element', '{\"question\":\"Do I have to re-register if I have services at multiple locations?\",\"answer\":\"No, we have Electronic Healthcare Records (EHR) for our patients. This system will allow your information to be available at all of our clinic locations, further improving efficiency and quality of the healthcare you receive.\"}', NULL, 'basic', NULL, 0, '2023-01-09 05:58:43', '2023-01-09 06:02:56'),
(75, 'faq.element', '{\"question\":\"Will you bill my insurance?\",\"answer\":\"Yes. As a service to our patients, primary insurance is billed. We have recently enhanced our system to accommodate automatic billing of secondary insurance. Please be sure to keep us informed of your insurance coverage.\"}', NULL, 'basic', NULL, 0, '2023-01-09 05:58:58', '2023-01-09 06:03:13'),
(76, 'faq.element', '{\"question\":\"What if I can\'t make my appointment and I need to reschedule?\",\"answer\":\"Please call your physician\\u2019s office as soon as you realize you will not be able to keep your appointment. We prefer all cancellations be made at least 24 hours prior to your scheduled appointment time. This will allow us to give another patient the opportunity to be seen.\"}', NULL, 'basic', NULL, 0, '2023-01-09 05:59:20', '2023-01-09 06:03:35'),
(77, 'faq.element', '{\"question\":\"How do I get my blood pressure checked?\",\"answer\":\"Blood pressure checks are provided complimentary at each of our locations. Call the clinic nearest you for details.\"}', NULL, 'basic', NULL, 0, '2023-01-09 05:59:35', '2023-01-09 06:03:50'),
(78, 'faq.element', '{\"question\":\"What information will the Patient Services Representative need to schedule an appointment?\",\"answer\":\"Appointment please have the following patient information ready: Patient\\u2019s full name (including middle initial) Date of birth Current address and phone number Current insurance information Physician\\u2019s name who you wish to schedule appointment with Purpose of the appointment* *It is important to let the scheduler know about all of the concerns you would like addressed during your appointment so we can schedule the appropriate amount of time to care for your needs.\"}', NULL, 'basic', NULL, 0, '2023-01-09 05:59:55', '2023-01-09 06:04:05'),
(79, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"How to become a superstar practice manager\",\"category\":\"General Knowledge\",\"description_nic\":\"<div class=\\\"inscreen-wrapper\\\"><div><div class=\\\"video-detail\\\" style=\\\"max-width:100%;margin-bottom:0px;\\\"><p style=\\\"margin-bottom:1rem;\\\">Careers in medical practice management can be tough, but there are exceptional leaders who can master it all. Learn the key qualities you need for success.<\\/p><div class=\\\"ad-box\\\" style=\\\"text-align:center;\\\"><\\/div><div class=\\\"block-content mt-3\\\"><div><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">There is a significant opportunity in the U.S. for business-minded professionals to have a rewarding career in healthcare as practice managers.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">As in any profession, there are average managers who do an adequate job. And then there are the superstars-the managers who care deeply, work fervently, and deliver results time and time agai<\\/p><\\/div><div><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">So what sets these managers apart from others? What is the \\u201csecret sauce\\u201d to getting ahead as a practice manager? Let\\u2019s talk about five qualities superstar managers possess.<\\/p><div class=\\\"mt-3 mb-4\\\"><div class=\\\"carousel slide\\\"><ol class=\\\"carousel-indicators\\\" style=\\\"margin-right:120.9px;margin-bottom:1rem;margin-left:120.9px;\\\"><li class=\\\"active\\\" style=\\\"width:20px;height:20px;\\\"><\\/li><li style=\\\"width:20px;height:20px;\\\"><\\/li><li style=\\\"width:20px;height:20px;\\\"><\\/li><li style=\\\"width:20px;height:20px;\\\"><\\/li><li style=\\\"width:20px;height:20px;\\\"><\\/li><li style=\\\"width:20px;height:20px;\\\"><\\/li><\\/ol><a class=\\\"carousel-control-prev\\\" href=\\\"https:\\/\\/www.physicianspractice.com\\/view\\/displaying-empathy-and-enthusiasm-in-your-medical-practice#\\\" style=\\\"width:120.9px;\\\"><span class=\\\"carousel-control-prev-icon\\\" style=\\\"width:30.225px;height:416px;\\\"><br \\/><\\/span><span class=\\\"sr-only\\\">Previous<\\/span><\\/a><a class=\\\"carousel-control-next\\\" href=\\\"https:\\/\\/www.physicianspractice.com\\/view\\/displaying-empathy-and-enthusiasm-in-your-medical-practice#\\\" style=\\\"width:120.9px;\\\"><span class=\\\"carousel-control-next-icon\\\" style=\\\"width:30.225px;height:416px;\\\"><\\/span><span class=\\\"sr-only\\\">Next<\\/span><\\/a><\\/div><\\/div><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">\\u201cNever burn bridges,\\u201d says Cornelius, \\u201cbecause strong and healthy relationships are vital to success.\\u201d Learning to communicate, listen, and understand others will carry you extraordinarily far in your career.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\"><font face=\\\"sans-serif\\\">About the Author<\\/font><\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\"><font face=\\\"sans-serif\\\">Amy Boyer, MBA, is a consultant with\\u00a0<\\/font><a href=\\\"https:\\/\\/www.karenzupko.com\\/\\\">Karen Zupko &amp; Associates, Inc.\\u00a0<\\/a>She has 15 years of experience working with physicians in private practice, hospital-based practice, and academic settings. Boyer specializes in practice operations, revenue cycle, and the use of technology to improve productivity. She frequently advises residents and young surgeons about employment agreements, compensation, and practice start-up issues.<\\/p><\\/div><div class=\\\"clearfix\\\"><\\/div><\\/div><div class=\\\"clearfix\\\" style=\\\"min-height:1px;\\\"><\\/div><\\/div><\\/div><\\/div><hr class=\\\"article-seperater mb-5 mt-3\\\" style=\\\"height:2px;margin-bottom:45px;\\\" \\/><div class=\\\"inscreen-wrapper\\\"><div><div class=\\\"video-detail\\\" style=\\\"max-width:100%;margin-bottom:0px;\\\"><h1 class=\\\"page-title\\\" style=\\\"margin-bottom:0.5rem;line-height:1.2;\\\">Displaying Empathy and Enthusiasm in Your Medical Practice<\\/h1><div class=\\\"mb-3 doc-group-container\\\"><div class=\\\"left-wrap\\\"><div>March 18, 2021<\\/div><div class=\\\"mb-3\\\"><a class=\\\"author-details-link-0\\\" href=\\\"https:\\/\\/www.physicianspractice.com\\/authors\\/authors\\/audrey-christie-mclaughlin-rn-0\\\">Audrey Mclaughlin, RN<\\/a>\\u00a0,\\u00a0<a class=\\\"author-details-link-1\\\" href=\\\"https:\\/\\/www.physicianspractice.com\\/authors\\/logan-lutton\\\">Logan Lutton<\\/a><div><\\/div><\\/div><p style=\\\"margin-bottom:1rem;\\\"><\\/p><\\/div><div><\\/div><\\/div><p style=\\\"margin-bottom:1rem;\\\"><font face=\\\"sans-serif\\\">Empathy and enthusiasm. Both should be present at your medical practice to boost patient and staff satisfaction.<\\/font><\\/p><div class=\\\"ad-box\\\" style=\\\"text-align:center;\\\"><\\/div><div class=\\\"block-content mt-3\\\"><div><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">Empathy and enthusiasm\\u2014these two words are major forces when converting your office from medical practice to a place well-known for its outstanding service and staff, as well as taking great medical care of their patients. After all, taking care of patients is more than diagnosing, treating, and prescribing, but should be a well-rounded, customer-centered activity.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">A quick vocabulary review: Empathy is demonstrating an understanding of someone else\'s situation or feelings because you have been in a similar situation yourself. This is not to say that you have to personally be an overworked dad stuck in traffic and late for his appointment, only to get there and realize he doesn\'t have his wallet. But it means you can demonstrate a sincere understanding because you experienced in your past having not felt well, tired, stressed, and topped it all off with being a little late or forgetting your purse\\/wallet, or in some way can relate to his issue.<\\/p><div><br \\/><\\/div><\\/div><div class=\\\"contextual-native-ad\\\" style=\\\"color:rgb(55,58,60);font-family:\'Segoe UI\', \'Source Sans Pro\', Calibri, Candara, Arial, sans-serif;font-size:15px;\\\"><div class=\\\"ADFluid\\\" style=\\\"text-align:center;\\\"><div class=\\\"adunitContainer\\\"><div class=\\\"adBox\\\"><\\/div><\\/div><\\/div><\\/div><\\/div><\\/div><\\/div><\\/div>\",\"blog_image\":\"63bbd40a2216f1673253898.jpg\"}', NULL, 'basic', 'how-to-become-a-superstar-practice-manager', 27, '2023-01-09 06:14:58', '2024-08-10 05:32:27');
INSERT INTO `frontends` (`id`, `data_keys`, `data_values`, `seo_content`, `tempname`, `slug`, `views`, `created_at`, `updated_at`) VALUES
(80, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Displaying Empathy and Enthusiasm in Your Medical Practice\",\"category\":\"Healthcare system\",\"description_nic\":\"<p style=\\\"margin-bottom:1rem;\\\">Empathy and enthusiasm. Both should be present at your medical practice to boost patient and staff satisfaction.<\\/p><div class=\\\"ad-box\\\" style=\\\"text-align:center;\\\"><\\/div><div class=\\\"block-content mt-3\\\"><div><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">Empathy and enthusiasm\\u2014these two words are major forces when converting your office from medical practice to a place well-known for its outstanding service and staff, as well as taking great medical care of their patients. After all, taking care of patients is more than diagnosing, treating, and prescribing, but should be a well-rounded, customer-centered activity.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">A quick vocabulary review: Empathy is demonstrating an understanding of someone else\'s situation or feelings because you have been in a similar situation yourself. This is not to say that you have to personally be an overworked dad stuck in traffic and late for his appointment, only to get there and realize he doesn\'t have his wallet. But it means you can demonstrate a sincere understanding because you experienced in your past having not felt well, tired, stressed, and topped it all off with being a little late or forgetting your purse\\/wallet, or in some way can relate to his issue.<\\/p><\\/div><div><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">It is important to practice these in a medical practice because almost everyone there is facing something, even if it is as simple as a runny nose. If your staff and practitioners take the empathetic approach with the patients, it can put a patient at ease immediately. This is especially important when working to diffuse situations with an angry patient, or a patient that feels like he has been treated unfairly.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">You can show empathy with your face and tone of your voice. If it is not sincere it will only escalate a situation. Using phrases sincerely such as:<\\/p><ul style=\\\"margin-bottom:1rem;line-height:1.6;margin-left:2rem;\\\"><li>\\u201cThat is awful; let me see how I can help.\\u201d<\\/li><li>\\u201cI understand your frustration.\\\"<\\/li><li>\\\"I would be upset if that happened to me.\\\"<\\/li><\\/ul><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">It bears repeating to make sure you are sincere - otherwise, your empathy will not be effective.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">Enthusiasm is equally if not more important than empathy. Enthusiasm of your staff and practitioners to be at your medical practice is one of the key factors that can make or break the energy in the clinic environment.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">Enthusiasm can be palpable when you walk into the waiting room. Think about it for a minute (empathetically): Would you want to spend time (sometimes a significant amount of time) in an environment, especially when you are not 100 percent, where people are dreary and listless? It is as important for your patients as it is for your co-workers to be enthusiastic about your work, and more importantly be enthusiastic about your patients choosing you for their healthcare needs. If you sell ancillary products or services in your office, enthusiasm can mean the difference between making the sale and just capturing an office visit.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">The great thing about enthusiasm is that it\\u00a0<font face=\\\"sans-serif\\\">can<\\/font>\\u00a0be faked! And if you fake it long if enough, it becomes genuine. Patients instantly have a positive reaction to employees that are enthusiastic.<\\/p><p style=\\\"margin-bottom:1rem;line-height:1.6;\\\">Here are some quick ways to show enthusiasm (which is even more important if you are a leader in the clinic):<\\/p><\\/div><\\/div>\",\"blog_image\":\"63bbd43eb75a11673253950.png\"}', NULL, 'basic', 'displaying-empathy-and-enthusiasm-in-your-medical-practice', 3, '2023-01-09 06:15:50', '2024-08-12 04:55:29'),
(81, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"How to break an addiction to sugar\",\"category\":\"General Knowledge\",\"description_nic\":\"<p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">The white stuff. Stop what you\\u2019re thinking, I am talking about sugar.\\u00a0<a href=\\\"https:\\/\\/bjsm.bmj.com\\/content\\/52\\/14\\/910\\\">The British Journal of Sports Medicine published a review in 2017<\\/a>\\u00a0which implied that sugar might be as addictive as drugs like cocaine. So what are the similarities in addiction symptoms? Well, if you find yourself in a cycle of bingeing, craving and feelings of withdrawal (think headaches and flu-like symptoms \\u2013 but more on that later), then it sounds like you, like many others, have a problem. Even worse if you\\u2019re blissfully unaware of the impact that sugar plays on yours and your children\\u2019s health.<br \\/><br \\/>It\\u2019s easy to have that biscuit during a tea break at work and a chocolate bar in the afternoon as a pick-me-up, which, for me, had escalated since Christmas. I have a very good awareness of what I\\u00a0should\\u00a0be eating: organic meat or fish, minimal fruit (I\\u2019ll get to fructose shortly), plenty of vegetables (especially green), avocados, eggs, nuts and seeds. Sounds simple doesn\\u2019t it? But when push comes to shove, it\\u2019s difficult to give up everything else, especially my sweet tooth and my craving for chocolate. There we go, I completed the first step in admitting that I had a problem.<\\/font><\\/p><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">What was my plan?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">I had tried previously to overcome my addiction to sugar, but having a few squares of dark chocolate can ultimately end up with the whole bar consumed in one sitting. So, this time around I decided to go for one month \\u2013 at least \\u2013 without any sugar at all. This includes hidden sugar found in sauce bottles \\u2013 that\\u2019s right, always check your labels. You\\u2019ll be surprised as to what\\u2019s in your tomato ketchup or low fat yoghurt pot. In fact, my general rule of thumb for the next 30 days was to eat anything that comes without a label, to cook with real food and avoid substances such as food additives, preservatives, dyes and artificial sweeteners. Food does not have to be so complicated, just plain and simple.<\\/font><\\/p><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">What does sugar do to the body?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">The two most common sugars that we tend to talk about are glucose and fructose, which both metabolise in different ways. Fructose is found in fruit, honey and high fructose corn syrup (HCFCS). Corn syrup is added to foods such as sweets, salad dressing, juices, fizzy drinks, and bread. There are some natural fruits that contain higher levels of fructose than others, which is why I chose to focus on eating as many veggies as possible and limiting my fruit intake to berries. Of course, fruit has vitamins, minerals and fibre compared to a biscuit but the serving size and choice of fruit makes all the difference. Indulging in three or four cups of watermelon is almost the equivalent of drinking a can of soda. Everything in moderation.<br \\/><br \\/>Fructose is metabolised in the liver whereas glucose is used up by the cells in the body and used as energy directly. Large quantities of glucose circulates to every cell in the body to disperse the load, yet large quantities of fructose goes straight to, and puts pressure, on the liver. The repercussions mean that fructose is not being used as energy so we eat more of it because we feel as though we are not getting enough \\u2013 a vicious cycle. The liver also panics when we eat fructose and stores it as fat. There is also an excess of insulin produced, which leads to insulin resistance, type 2 diabetes and a whole other range of metabolic diseases. Fructose also fails to turn off our appetite hormones leptin and ghrelin. And thanks to appetite and hormone havoc: sugar can make us gain weight. Enough reason for me to think about my health long term and give it up!<\\/font><\\/p><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">So, what happened when I went cold turkey?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">After the first day, my cravings for something sweet were really strong. In fact, in the first week I felt really hungry or just like I \\u201cneeded\\u201d something. I filled up on foods containing (good) fats and protein. I found myself snacking on a whole cup of raw coconut, plenty of almonds and boiled eggs. As time went on, this excessive hunger disappeared but in that first week I was ravenous. I also had really intense muscle aches. I had a pain that radiated from my lower back, down my side and all the way down my leg. At one point my colleague and I were Googling my symptoms and questioning whether I had sciatica! Surely this wasn\\u2019t part of the withdrawal but was it a coincidence that it appeared only a few days into my detox journey? The pain lasted for about four days on and off. I also had constant headaches for over a week and of course, mood swings!<\\/font><\\/p><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">But was it worth it?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">Absolutely! It\\u2019s true that you will come out on the other side and thankfully, I did. It was on day 20 that I really noticed the changes:<br \\/><\\/font><\\/p><ul style=\\\"margin-bottom:26px;\\\"><li style=\\\"line-height:26px;margin-left:21px;\\\"><font face=\\\"trebuchet ms\\\">I started naturally waking up at 6am, way before my alarm.<\\/font><\\/li><li style=\\\"line-height:26px;margin-left:21px;\\\"><font face=\\\"trebuchet ms\\\">All body aches have completely disappeared.<\\/font><\\/li><li style=\\\"line-height:26px;margin-left:21px;\\\"><font face=\\\"trebuchet ms\\\">All face and belly bloat has gone.<\\/font><\\/li><li style=\\\"line-height:26px;margin-left:21px;\\\"><font face=\\\"trebuchet ms\\\">If there are days when I am running on lack of sleep, I still have energy.<\\/font><\\/li><li style=\\\"line-height:26px;margin-left:21px;\\\"><font face=\\\"trebuchet ms\\\">There\\u2019s no afternoon slump.<\\/font><\\/li><li style=\\\"line-height:26px;margin-left:21px;\\\"><font face=\\\"trebuchet ms\\\">My skin is also clear, brighter and it looks less dark under the eyes.<\\/font><\\/li><\\/ul><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">I have not weighed myself as this was not the reason for this journey, but I definitely feel a little smaller. Most importantly, I no longer crave chocolate \\u2013 which is huge! And because I am eating natural whole foods, my body can eat as much as it wants and knows when to stop.<\\/font><\\/p><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">If anyone is going to start this journey, the thought of going cold turkey can be off-putting and I recommend taking a few weeks to ease yourself into it. Always consult with your GP if you are going to make any dietary changes.<\\/font><\\/p>\",\"blog_image\":\"63bbd47d4b9e01673254013.jpg\"}', NULL, 'basic', 'how-to-break-an-addiction-to-sugar', 11, '2023-01-09 06:16:53', '2024-08-10 04:48:05'),
(82, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Free offers  e-Consultation to Doctors who need it to care for their patients.\",\"category\":\"Healthcare system\",\"description_nic\":\"<h3 style=\\\"margin-top:27px;margin-bottom:17px;line-height:30px;\\\"><font face=\\\"trebuchet ms\\\">Solidarity to help decongest the healthcare system<\\/font><\\/h3><ul style=\\\"margin-bottom:26px;\\\"><li style=\\\"line-height:26px;margin-left:21px;\\\"><font face=\\\"trebuchet ms\\\">In the last week, calls from doctors requesting information and activation of our e-Consultation services for use with private patients has multiplied by 30.<\\/font><\\/li><li style=\\\"line-height:26px;margin-left:21px;\\\"><font face=\\\"trebuchet ms\\\">To ensure as much as possible that patients are not affected by the effects of COVID-19 on access to healthcare, Top Doctors is offering the e-Consultation service free of charge to doctors, even if they are not already a member of the platform.<\\/font><\\/li><li style=\\\"line-height:26px;margin-left:21px;\\\"><font face=\\\"trebuchet ms\\\">A. Porciani: \\u201cIn this type of setting, where cybercrime can pose a risk, it is important that the tools for instant communication with patients complies with national and international regulations on encryption and preservation of medical data\\u201d<\\/font><\\/li><\\/ul><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\"><b>London, United Kingdom, 19<\\/b><span style=\\\"line-height:0;vertical-align:baseline;\\\">th<\\/span>\\u00a0March 2020.\\u00a0\\u2013 Top Doctors, a leading company in providing technological services for the private medical sector, such as e-Consultation, announces today that it will contribute to helping the healthcare system by making available to all medical professionals, both its network of members as well as anyone else who needs it throughout the United Kingdom territory, its e-Consultation services for doctors at no cost, which will be assumed by the company. The company has made this decision to assist the difficult situation that both the healthcare sector and patients are experiencing who, to help reduce the congestion of hospitals and medical centres, are postponing their health check-ups and appointments.<\\/font><\\/p><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">Following the announcement of this measure amongst the platform\\u2019s current members, the company has experienced an increase in the number of requests from medical professionals getting in touch to find out more about the e-Consultation service and to activate the tool so that they can attend to their patients.\\u00a0\\u201cIn just the last three days we have received the same number of requests that we would normally receive in one month,\\u201d\\u00a0explains Alberto Porciani.\\u00a0\\u201cPrivate healthcare has made itself available to the needs that currently prevail in the healthcare system following the current coronavirus pandemic. But despite the pandemic, doctors still have to serve their regular patients. Less urgent appointments are being cancelled, by both doctors and the patients themselves, but there are certain cases that cannot wait for diagnosis, follow-up or treatment.\\u201d<\\/font><\\/p><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">That is why the demand for Top Doctors\\u2019 e-Consultation services has multiplied by 30 in recent weeks. According to the data available, the same is happening in Italy and Spain, which are two of the eight countries in which Top Doctors is also present.<\\/font><\\/p><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">Therefore, Top Doctors announces today that any medical professional in the private healthcare sector who needs e-Consultation services as an alternative to their face-to-face appointments will be able to use them without having to pay the service cost for the next two months. This expense will be assumed by the company. These e-Consultation services include a chat and video conferencing system, as well as an online appointment system which is available 24\\/7 for 365 days per year. Doctors will be free to choose the price they set for the e-Consultation appointments for patients. As Top Doctors offers the e-Consultation service free of charge for medical professionals to help the medical community, so too might doctors offer their services charitably to patients, or at a lower cost during this pressing time.<\\/font><\\/p><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">Furthermore,\\u00a0\\u201cwe are working to contact all major insurance companies in the United Kingdom so that doctors can provide Top Doctors e-Consultation services for their insured patients too,\\u201d\\u00a0added A. Porciani. The company does not rule out extending this free period if the current crisis continues. Top Doctors is currently the only company that offers e-Consultation services for all medical specialties.<\\/font><\\/p><h3 style=\\\"margin-top:27px;margin-bottom:17px;line-height:30px;\\\"><font face=\\\"trebuchet ms\\\">How doctors or insurers can get in touch:<\\/font><\\/h3><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">Interested doctors and insurers can contact Top Doctors at\\u00a0<a href=\\\"mailto:econsultation@topdoctors.co.uk\\\">econsultation@topdoctors.co.uk<\\/a>\\u00a0or by calling 07375559158 or 02071133495.<\\/font><\\/p>\",\"blog_image\":\"63bbd53d924661673254205.jpg\"}', NULL, 'basic', 'free-offers--e-consultation-to-doctors-who-need-it-to-care-for-their-patients', 31, '2023-01-09 06:17:33', '2024-08-11 06:22:56'),
(83, 'blog.element', '{\"has_image\":[\"1\"],\"title\":\"Ask a Top Neurologist: Dr Hadi Manji\",\"category\":\"Neurologist\",\"description_nic\":\"<p style=\\\"line-height:26px;margin-bottom:26px;\\\"><b><font face=\\\"trebuchet ms\\\">A\\u00a0neurologist\\u00a0is a specialist who analyses and treats injuries and diseases of the nervous system. Divided into two parts, the\\u00a0central\\u00a0and\\u00a0peripheral nervous system,<\\/font><\\/b><font face=\\\"trebuchet ms\\\"><b> each part of the system is crucial in how information is communicated throughout the body. This includes the brain, spinal cord, muscles and organs. It sounds complex, right? But the nervous system is like an intricate puzzle that a neurologist works to solve.<\\/b><br \\/><br \\/>At\\u00a0<a href=\\\"https:\\/\\/www.topdoctors.co.uk\\/\\\">Top Doctors<\\/a>\\u00a0we like to learn more about our specialists on a personal level, so we sat down with one of London\\u2019s leading neurologists Dr Hadi Manji for an insight into what life as a doctor is really like in the UK\\u2019s capital city.<br \\/><br \\/>Here, Dr Manji kindly shares the inspiration behind him choosing his specialist field and how he juggles his time between consulting across the city, being Chief Author and Editor of the Oxford Handbook of Neurology, and the medical school that he has been involved in developing in Mozambique.<\\/font><\\/p><div class=\\\"wp-block-image\\\" style=\\\"max-width:100%;margin-bottom:1em;margin-left:0px;margin-right:0px;\\\"><img src=\\\"https:\\/\\/www.topdoctors.co.uk\\/blog\\/wp-content\\/uploads\\/2019\\/11\\/Mr_Hadi_Manji.png\\\" alt=\\\"\\\" class=\\\"wp-image-3455 td-animation-stack-type0-2\\\" style=\\\"border:0px;margin-bottom:0px;width:500px;\\\" \\/><\\/div><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">What inspired you to become a doctor and to further choose neurology as your specialty?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">Neurology as my specialist field suits my personality. It is the most clinical of specialties where history and examination are the keys. I recently gave my inaugural lecture as President of the Neurosciences Section of the\\u00a0<b>Royal Society of Medicine<\\/b>\\u00a0entitled \\u2018Long Live the Art of Clinical Neurology\\u2019.<br \\/><br \\/>In the lecture, I outline why history and, to a lesser extent, the examination are crucial to the doctor-patient interaction and not just making a diagnosis. I am not dextrous with my hands so surgery was out. I initially trained as a GP in Edinburgh but did not find it satisfying hence the change to medicine and then neurology.<\\/font><\\/p><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">You practice privately in four locations across central London \\u2013 how do you divide your time around appointments and other responsibilities? Is it tricky?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">I have a joint appointment at\\u00a0<b>The National Hospital for Neurology<\\/b>\\u00a0in London, which is regarded as the centre for neurology in the UK and \\u2013 some would say \\u2013 the world. So, as a senior consultant after 22 years, it is still a great place to work.<br \\/><br \\/>My other appointment is at Ipswich Hospital where I was house office and also the Senior House Officer and so I have an affiliation to the hospital. At one stage I was the only permanent consultant there. We now have four consultants and so I feel that I have developed the neurology services there.<\\/font><\\/p><img src=\\\"https:\\/\\/www.topdoctors.co.uk\\/blog\\/wp-content\\/uploads\\/2019\\/11\\/Training.jpg\\\" alt=\\\"\\\" class=\\\"wp-image-3450 td-animation-stack-type0-2\\\" style=\\\"border:0px;margin-bottom:0px;\\\" \\/><font face=\\\"trebuchet ms\\\">Dr Manji training doctors at the medical school in Beira, Mozambique.<\\/font><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">Can you tell us about the medical school that you have been involved in developing in Beira, Mozambique? How did this come about?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">I first became involved with the Roman Catholic Medical School in Beira, Mozambique in 2000. I helped set up the neurology teaching and also encouraged consultant colleagues and registrars to get involved. It is working well but unfortunately, the medical school and especially the hospital were severely damaged by a hurricane six months ago. We are now trying to raise funds to make repairs.<\\/font><\\/p><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">Which of these experiences have you enjoyed the most, being President of Neurosciences at the RSM or as Chief Author and Editor of the Oxford Handbook of Neurology?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">I enjoy clinical work primarily and have also developed a good reputation amongst my colleagues. The Oxford Handbook has sold 20,000 copies and I am now in the process of writing the third edition.<br \\/><br \\/>This is important for me as it means I HAVE to keep up-to-date in neurology, which is advancing at a breath-taking pace. In the last 12 months, for example, we can now treat genetic neurological conditions such as\\u00a0<a href=\\\"https:\\/\\/www.nhs.uk\\/conditions\\/spinal-muscular-atrophy-sma\\/\\\">spinal muscular atrophy<\\/a>\\u00a0and\\u00a0<a href=\\\"https:\\/\\/www.nhs.uk\\/conditions\\/amyloidosis\\/\\\">familial amyloid neuropathy<\\/a>. This would have been unthinkable when I first started neurology. These are exciting times for neurologists.<\\/font><\\/p><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">Being appointed President of the Neurosciences Section of the RSM is a great honour and it is fun organising six meetings for the next 12 months, which will include meetings on HIV neurology (one of my specialist interests) and also teaching and developing neurosciences in resource-poor countries. I am also enjoying finding out more of the workings of the RSM.<\\/font><\\/p><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">What does the future hold? What else would you like to achieve during your already impressive career?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">The future? Who knows? I am, at present, in Barbados giving lectures and teaching, so it would be good to be doing more of that. I do the same in Kenya.<\\/font><\\/p><h2 style=\\\"margin-top:30px;margin-bottom:20px;line-height:38px;\\\"><font face=\\\"trebuchet ms\\\">If you had not chosen to become a doctor, what do you think you would be doing now professionally?<\\/font><\\/h2><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">A musician! Specifically, a drummer and I would preferably takeover from Charlie Watts of the Rolling Stones. Seriously \\u2013 a teacher, probably in history, which I greatly enjoyed at secondary school.<\\/font><\\/p><p style=\\\"line-height:26px;margin-bottom:26px;\\\"><font face=\\\"trebuchet ms\\\">Dr Hadi Manji practices at the Queen\\u2019s Square Private Consulting Rooms in Queen\\u2019s Square, The Physician\\u2019s Clinic in Marylebone, The Clementine Churchill Hospital in Harrow and at the Nuffield Health Ipswich Hospital. He specialises in neurological disorders including\\u00a0<a href=\\\"https:\\/\\/www.topdoctors.co.uk\\/medical-articles\\/how-does-a-neurologist-diagnose-different-types-of-headache\\\">headache<\\/a>,\\u00a0dizziness,\\u00a0memory disorder,\\u00a0Parkinson\\u2019s disease\\u00a0and infectious neurological disorders such as\\u00a0HIV. If you would like to book a consultation with Dr Manji you can do so\\u00a0<a href=\\\"https:\\/\\/www.topdoctors.co.uk\\/doctor\\/hadi-manji\\\">here<\\/a>.<\\/font><\\/p>\",\"blog_image\":\"63bbd4d1dfd771673254097.jpg\"}', NULL, 'basic', 'ask-a-top-neurologist:-dr-hadi-manji', 2, '2023-01-09 06:18:17', '2024-08-10 04:48:13'),
(84, 'department.content', '{\"heading\":\"Accelerate brand growth with Reviews and Loyalty\",\"subheading\":\"We will utilize your money providing a source of high income while minimizing any possibility of risk in a very secure way.\"}', NULL, 'basic', NULL, 0, '2023-01-14 10:55:18', '2023-01-14 10:55:18'),
(85, 'maintenance.data', '{\"description\":\"<div class=\\\"mb-5\\\" style=\\\"color: rgb(111, 111, 111); font-family: Nunito, sans-serif; margin-bottom: 3rem !important;\\\"><h3 class=\\\"mb-3\\\" style=\\\"text-align: center; font-weight: 600; line-height: 1.3; font-size: 24px; font-family: Exo, sans-serif; color: rgb(54, 54, 54);\\\">What information do we collect?<\\/h3><p class=\\\"font-18\\\" style=\\\"text-align: center; margin-right: 0px; margin-left: 0px; font-size: 18px !important;\\\">We gather data from you when you register on our site, submit a request, buy any services, react to an overview, or round out a structure. At the point when requesting any assistance or enrolling on our site, as suitable, you might be approached to enter your: name, email address, or telephone number. You may, nonetheless, visit our site anonymously.<\\/p><\\/div>\",\"image\":\"6603c203472ad1711522307.png\"}', NULL, 'basic', NULL, 0, '2020-07-04 23:42:52', '2024-06-09 08:51:39'),
(86, 'register_disable.content', '{\"has_image\":\"1\",\"heading\":\"Registration Currently Disabled\",\"subheading\":\"Registration process is temporarily unavailable. We apologize for any inconvenience and assure you that we\'re working diligently to restore it promptly.\",\"button_name\":\"Go To Home\",\"button_url\":\"#\",\"image\":\"665c6f5cec9e31717333852.png\"}', NULL, 'basic', '', 0, '2024-06-02 07:10:52', '2024-06-02 07:10:53');

-- --------------------------------------------------------

--
-- Table structure for table `gateways`
--

CREATE TABLE `gateways` (
  `id` bigint UNSIGNED NOT NULL,
  `form_id` int UNSIGNED NOT NULL DEFAULT '0',
  `code` int DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'NULL',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=>enable, 2=>disable',
  `gateway_parameters` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `supported_currencies` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `crypto` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: fiat currency, 1: crypto currency',
  `extra` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gateways`
--

INSERT INTO `gateways` (`id`, `form_id`, `code`, `name`, `alias`, `image`, `status`, `gateway_parameters`, `supported_currencies`, `crypto`, `extra`, `description`, `created_at`, `updated_at`) VALUES
(1, 0, 101, 'Paypal', 'Paypal', '663a38d7b455d1715091671.png', 1, '{\"paypal_email\":{\"title\":\"PayPal Email\",\"global\":true,\"value\":\"sb-owud61543012@business.example.com\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:04:38'),
(2, 0, 102, 'Perfect Money', 'PerfectMoney', '663a3920e30a31715091744.png', 1, '{\"passphrase\":{\"title\":\"ALTERNATE PASSPHRASE\",\"global\":true,\"value\":\"hR26aw02Q1eEeUPSIfuwNypXX\"},\"wallet_id\":{\"title\":\"PM Wallet\",\"global\":false,\"value\":\"\"}}', '{\"USD\":\"$\",\"EUR\":\"\\u20ac\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:35:33'),
(3, 0, 103, 'Stripe Hosted', 'Stripe', '663a39861cb9d1715091846.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:48:36'),
(4, 0, 104, 'Skrill', 'Skrill', '663a39494c4a91715091785.png', 1, '{\"pay_to_email\":{\"title\":\"Skrill Email\",\"global\":true,\"value\":\"merchant@skrill.com\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"---\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JOD\":\"JOD\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"KWD\":\"KWD\",\"MAD\":\"MAD\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"OMR\":\"OMR\",\"PLN\":\"PLN\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"SAR\":\"SAR\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TND\":\"TND\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\",\"COP\":\"COP\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 01:30:16'),
(5, 0, 105, 'PayTM', 'Paytm', '663a390f601191715091727.png', 1, '{\"MID\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"DIY12386817555501617\"},\"merchant_key\":{\"title\":\"Merchant Key\",\"global\":true,\"value\":\"bKMfNxPPf_QdZppa\"},\"WEBSITE\":{\"title\":\"Paytm Website\",\"global\":true,\"value\":\"DIYtestingweb\"},\"INDUSTRY_TYPE_ID\":{\"title\":\"Industry Type\",\"global\":true,\"value\":\"Retail\"},\"CHANNEL_ID\":{\"title\":\"CHANNEL ID\",\"global\":true,\"value\":\"WEB\"},\"transaction_url\":{\"title\":\"Transaction URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/oltp-web\\/processTransaction\"},\"transaction_status_url\":{\"title\":\"Transaction STATUS URL\",\"global\":true,\"value\":\"https:\\/\\/pguat.paytm.com\\/paytmchecksum\\/paytmCallback.jsp\"}}', '{\"AUD\":\"AUD\",\"ARS\":\"ARS\",\"BDT\":\"BDT\",\"BRL\":\"BRL\",\"BGN\":\"BGN\",\"CAD\":\"CAD\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"HRK\":\"HRK\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EGP\":\"EGP\",\"EUR\":\"EUR\",\"GEL\":\"GEL\",\"GHS\":\"GHS\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"KES\":\"KES\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"MAD\":\"MAD\",\"NPR\":\"NPR\",\"NZD\":\"NZD\",\"NGN\":\"NGN\",\"NOK\":\"NOK\",\"PKR\":\"PKR\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"ZAR\":\"ZAR\",\"KRW\":\"KRW\",\"LKR\":\"LKR\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"UGX\":\"UGX\",\"UAH\":\"UAH\",\"AED\":\"AED\",\"GBP\":\"GBP\",\"USD\":\"USD\",\"VND\":\"VND\",\"XOF\":\"XOF\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 03:00:44'),
(6, 0, 106, 'Payeer', 'Payeer', '663a38c9e2e931715091657.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"866989763\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"7575\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"RUB\":\"RUB\"}', 0, '{\"status\":{\"title\": \"Status URL\",\"value\":\"ipn.Payeer\"}}', NULL, '2019-09-14 13:14:22', '2022-08-28 10:11:14'),
(7, 0, 107, 'PayStack', 'Paystack', '663a38fc814e91715091708.png', 1, '{\"public_key\":{\"title\":\"Public key\",\"global\":true,\"value\":\"pk_test_cd330608eb47970889bca397ced55c1dd5ad3783\"},\"secret_key\":{\"title\":\"Secret key\",\"global\":true,\"value\":\"sk_test_8a0b1f199362d7acc9c390bff72c4e81f74e2ac3\"}}', '{\"USD\":\"USD\",\"NGN\":\"NGN\"}', 0, '{\"callback\":{\"title\": \"Callback URL\",\"value\":\"ipn.Paystack\"},\"webhook\":{\"title\": \"Webhook URL\",\"value\":\"ipn.Paystack\"}}\r\n', NULL, '2019-09-14 13:14:22', '2021-05-21 01:49:51'),
(9, 0, 109, 'Flutterwave', 'Flutterwave', '663a36c2c34d61715091138.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"----------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"-----------------------\"},\"encryption_key\":{\"title\":\"Encryption Key\",\"global\":true,\"value\":\"------------------\"}}', '{\"BIF\":\"BIF\",\"CAD\":\"CAD\",\"CDF\":\"CDF\",\"CVE\":\"CVE\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"GHS\":\"GHS\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"KES\":\"KES\",\"LRD\":\"LRD\",\"MWK\":\"MWK\",\"MZN\":\"MZN\",\"NGN\":\"NGN\",\"RWF\":\"RWF\",\"SLL\":\"SLL\",\"STD\":\"STD\",\"TZS\":\"TZS\",\"UGX\":\"UGX\",\"USD\":\"USD\",\"XAF\":\"XAF\",\"XOF\":\"XOF\",\"ZMK\":\"ZMK\",\"ZMW\":\"ZMW\",\"ZWD\":\"ZWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-06-05 11:37:45'),
(10, 0, 110, 'RazorPay', 'Razorpay', '663a393a527831715091770.png', 1, '{\"key_id\":{\"title\":\"Key Id\",\"global\":true,\"value\":\"rzp_test_kiOtejPbRZU90E\"},\"key_secret\":{\"title\":\"Key Secret \",\"global\":true,\"value\":\"osRDebzEqbsE1kbyQJ4y0re7\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:51:32'),
(11, 0, 111, 'Stripe Storefront', 'StripeJs', '663a3995417171715091861.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 00:53:10'),
(12, 0, 112, 'Instamojo', 'Instamojo', '663a384d54a111715091533.png', 1, '{\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_2241633c3bc44a3de84a3b33969\"},\"auth_token\":{\"title\":\"Auth Token\",\"global\":true,\"value\":\"test_279f083f7bebefd35217feef22d\"},\"salt\":{\"title\":\"Salt\",\"global\":true,\"value\":\"19d38908eeff4f58b2ddda2c6d86ca25\"}}', '{\"INR\":\"INR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:56:20'),
(13, 0, 501, 'Blockchain', 'Blockchain', '663a35efd0c311715090927.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"55529946-05ca-48ff-8710-f279d86b1cc5\"},\"xpub_code\":{\"title\":\"XPUB CODE\",\"global\":true,\"value\":\"xpub6CKQ3xxWyBoFAF83izZCSFUorptEU9AF8TezhtWeMU5oefjX3sFSBw62Lr9iHXPkXmDQJJiHZeTRtD9Vzt8grAYRhvbz4nEvBu3QKELVzFK\"}}', '{\"BTC\":\"BTC\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2022-03-21 07:41:56'),
(15, 0, 503, 'CoinPayments', 'Coinpayments', '663a36a8d8e1d1715091112.png', 1, '{\"public_key\":{\"title\":\"Public Key\",\"global\":true,\"value\":\"---------------\"},\"private_key\":{\"title\":\"Private Key\",\"global\":true,\"value\":\"------------\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"93a1e014c4ad60a7980b4a7239673cb4\"}}', '{\"BTC\":\"Bitcoin\",\"BTC.LN\":\"Bitcoin (Lightning Network)\",\"LTC\":\"Litecoin\",\"CPS\":\"CPS Coin\",\"VLX\":\"Velas\",\"APL\":\"Apollo\",\"AYA\":\"Aryacoin\",\"BAD\":\"Badcoin\",\"BCD\":\"Bitcoin Diamond\",\"BCH\":\"Bitcoin Cash\",\"BCN\":\"Bytecoin\",\"BEAM\":\"BEAM\",\"BITB\":\"Bean Cash\",\"BLK\":\"BlackCoin\",\"BSV\":\"Bitcoin SV\",\"BTAD\":\"Bitcoin Adult\",\"BTG\":\"Bitcoin Gold\",\"BTT\":\"BitTorrent\",\"CLOAK\":\"CloakCoin\",\"CLUB\":\"ClubCoin\",\"CRW\":\"Crown\",\"CRYP\":\"CrypticCoin\",\"CRYT\":\"CryTrExCoin\",\"CURE\":\"CureCoin\",\"DASH\":\"DASH\",\"DCR\":\"Decred\",\"DEV\":\"DeviantCoin\",\"DGB\":\"DigiByte\",\"DOGE\":\"Dogecoin\",\"EBST\":\"eBoost\",\"EOS\":\"EOS\",\"ETC\":\"Ether Classic\",\"ETH\":\"Ethereum\",\"ETN\":\"Electroneum\",\"EUNO\":\"EUNO\",\"EXP\":\"EXP\",\"Expanse\":\"Expanse\",\"FLASH\":\"FLASH\",\"GAME\":\"GameCredits\",\"GLC\":\"Goldcoin\",\"GRS\":\"Groestlcoin\",\"KMD\":\"Komodo\",\"LOKI\":\"LOKI\",\"LSK\":\"LSK\",\"MAID\":\"MaidSafeCoin\",\"MUE\":\"MonetaryUnit\",\"NAV\":\"NAV Coin\",\"NEO\":\"NEO\",\"NMC\":\"Namecoin\",\"NVST\":\"NVO Token\",\"NXT\":\"NXT\",\"OMNI\":\"OMNI\",\"PINK\":\"PinkCoin\",\"PIVX\":\"PIVX\",\"POT\":\"PotCoin\",\"PPC\":\"Peercoin\",\"PROC\":\"ProCurrency\",\"PURA\":\"PURA\",\"QTUM\":\"QTUM\",\"RES\":\"Resistance\",\"RVN\":\"Ravencoin\",\"RVR\":\"RevolutionVR\",\"SBD\":\"Steem Dollars\",\"SMART\":\"SmartCash\",\"SOXAX\":\"SOXAX\",\"STEEM\":\"STEEM\",\"STRAT\":\"STRAT\",\"SYS\":\"Syscoin\",\"TPAY\":\"TokenPay\",\"TRIGGERS\":\"Triggers\",\"TRX\":\" TRON\",\"UBQ\":\"Ubiq\",\"UNIT\":\"UniversalCurrency\",\"USDT\":\"Tether USD (Omni Layer)\",\"USDT.BEP20\":\"Tether USD (BSC Chain)\",\"USDT.ERC20\":\"Tether USD (ERC20)\",\"USDT.TRC20\":\"Tether USD (Tron/TRC20)\",\"VTC\":\"Vertcoin\",\"WAVES\":\"Waves\",\"XCP\":\"Counterparty\",\"XEM\":\"NEM\",\"XMR\":\"Monero\",\"XSN\":\"Stakenet\",\"XSR\":\"SucreCoin\",\"XVG\":\"VERGE\",\"XZC\":\"ZCoin\",\"ZEC\":\"ZCash\",\"ZEN\":\"Horizen\"}', 1, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:07:14'),
(16, 0, 504, 'CoinPayments Fiat', 'CoinpaymentsFiat', '663a36b7b841a1715091127.png', 1, '{\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"6515561\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:07:44'),
(17, 0, 505, 'Coingate', 'Coingate', '663a368e753381715091086.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"6354mwVCEw5kHzRJ6thbGo-N\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2022-03-30 09:24:57'),
(18, 0, 506, 'Coinbase Commerce', 'CoinbaseCommerce', '663a367e46ae51715091070.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"c47cd7df-d8e8-424b-a20a\"},\"secret\":{\"title\":\"Webhook Shared Secret\",\"global\":true,\"value\":\"55871878-2c32-4f64-ab66\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\",\"JPY\":\"JPY\",\"GBP\":\"GBP\",\"AUD\":\"AUD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CNY\":\"CNY\",\"SEK\":\"SEK\",\"NZD\":\"NZD\",\"MXN\":\"MXN\",\"SGD\":\"SGD\",\"HKD\":\"HKD\",\"NOK\":\"NOK\",\"KRW\":\"KRW\",\"TRY\":\"TRY\",\"RUB\":\"RUB\",\"INR\":\"INR\",\"BRL\":\"BRL\",\"ZAR\":\"ZAR\",\"AED\":\"AED\",\"AFN\":\"AFN\",\"ALL\":\"ALL\",\"AMD\":\"AMD\",\"ANG\":\"ANG\",\"AOA\":\"AOA\",\"ARS\":\"ARS\",\"AWG\":\"AWG\",\"AZN\":\"AZN\",\"BAM\":\"BAM\",\"BBD\":\"BBD\",\"BDT\":\"BDT\",\"BGN\":\"BGN\",\"BHD\":\"BHD\",\"BIF\":\"BIF\",\"BMD\":\"BMD\",\"BND\":\"BND\",\"BOB\":\"BOB\",\"BSD\":\"BSD\",\"BTN\":\"BTN\",\"BWP\":\"BWP\",\"BYN\":\"BYN\",\"BZD\":\"BZD\",\"CDF\":\"CDF\",\"CLF\":\"CLF\",\"CLP\":\"CLP\",\"COP\":\"COP\",\"CRC\":\"CRC\",\"CUC\":\"CUC\",\"CUP\":\"CUP\",\"CVE\":\"CVE\",\"CZK\":\"CZK\",\"DJF\":\"DJF\",\"DKK\":\"DKK\",\"DOP\":\"DOP\",\"DZD\":\"DZD\",\"EGP\":\"EGP\",\"ERN\":\"ERN\",\"ETB\":\"ETB\",\"FJD\":\"FJD\",\"FKP\":\"FKP\",\"GEL\":\"GEL\",\"GGP\":\"GGP\",\"GHS\":\"GHS\",\"GIP\":\"GIP\",\"GMD\":\"GMD\",\"GNF\":\"GNF\",\"GTQ\":\"GTQ\",\"GYD\":\"GYD\",\"HNL\":\"HNL\",\"HRK\":\"HRK\",\"HTG\":\"HTG\",\"HUF\":\"HUF\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"IMP\":\"IMP\",\"IQD\":\"IQD\",\"IRR\":\"IRR\",\"ISK\":\"ISK\",\"JEP\":\"JEP\",\"JMD\":\"JMD\",\"JOD\":\"JOD\",\"KES\":\"KES\",\"KGS\":\"KGS\",\"KHR\":\"KHR\",\"KMF\":\"KMF\",\"KPW\":\"KPW\",\"KWD\":\"KWD\",\"KYD\":\"KYD\",\"KZT\":\"KZT\",\"LAK\":\"LAK\",\"LBP\":\"LBP\",\"LKR\":\"LKR\",\"LRD\":\"LRD\",\"LSL\":\"LSL\",\"LYD\":\"LYD\",\"MAD\":\"MAD\",\"MDL\":\"MDL\",\"MGA\":\"MGA\",\"MKD\":\"MKD\",\"MMK\":\"MMK\",\"MNT\":\"MNT\",\"MOP\":\"MOP\",\"MRO\":\"MRO\",\"MUR\":\"MUR\",\"MVR\":\"MVR\",\"MWK\":\"MWK\",\"MYR\":\"MYR\",\"MZN\":\"MZN\",\"NAD\":\"NAD\",\"NGN\":\"NGN\",\"NIO\":\"NIO\",\"NPR\":\"NPR\",\"OMR\":\"OMR\",\"PAB\":\"PAB\",\"PEN\":\"PEN\",\"PGK\":\"PGK\",\"PHP\":\"PHP\",\"PKR\":\"PKR\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"QAR\":\"QAR\",\"RON\":\"RON\",\"RSD\":\"RSD\",\"RWF\":\"RWF\",\"SAR\":\"SAR\",\"SBD\":\"SBD\",\"SCR\":\"SCR\",\"SDG\":\"SDG\",\"SHP\":\"SHP\",\"SLL\":\"SLL\",\"SOS\":\"SOS\",\"SRD\":\"SRD\",\"SSP\":\"SSP\",\"STD\":\"STD\",\"SVC\":\"SVC\",\"SYP\":\"SYP\",\"SZL\":\"SZL\",\"THB\":\"THB\",\"TJS\":\"TJS\",\"TMT\":\"TMT\",\"TND\":\"TND\",\"TOP\":\"TOP\",\"TTD\":\"TTD\",\"TWD\":\"TWD\",\"TZS\":\"TZS\",\"UAH\":\"UAH\",\"UGX\":\"UGX\",\"UYU\":\"UYU\",\"UZS\":\"UZS\",\"VEF\":\"VEF\",\"VND\":\"VND\",\"VUV\":\"VUV\",\"WST\":\"WST\",\"XAF\":\"XAF\",\"XAG\":\"XAG\",\"XAU\":\"XAU\",\"XCD\":\"XCD\",\"XDR\":\"XDR\",\"XOF\":\"XOF\",\"XPD\":\"XPD\",\"XPF\":\"XPF\",\"XPT\":\"XPT\",\"YER\":\"YER\",\"ZMW\":\"ZMW\",\"ZWL\":\"ZWL\"}\r\n\r\n', 0, '{\"endpoint\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.CoinbaseCommerce\"}}', NULL, '2019-09-14 13:14:22', '2021-05-21 02:02:47'),
(24, 0, 113, 'Paypal Express', 'PaypalSdk', '663a38ed101a61715091693.png', 1, '{\"clientId\":{\"title\":\"Paypal Client ID\",\"global\":true,\"value\":\"Ae0-tixtSV7DvLwIh3Bmu7JvHrjh5EfGdXr_cEklKAVjjezRZ747BxKILiBdzlKKyp-W8W_T7CKH1Ken\"},\"clientSecret\":{\"title\":\"Client Secret\",\"global\":true,\"value\":\"EOhbvHZgFNO21soQJT1L9Q00M3rK6PIEsdiTgXRBt2gtGtxwRer5JvKnVUGNU5oE63fFnjnYY7hq3HBA\"}}', '{\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"HKD\":\"HKD\",\"HUF\":\"HUF\",\"INR\":\"INR\",\"ILS\":\"ILS\",\"JPY\":\"JPY\",\"MYR\":\"MYR\",\"MXN\":\"MXN\",\"TWD\":\"TWD\",\"NZD\":\"NZD\",\"NOK\":\"NOK\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"GBP\":\"GBP\",\"RUB\":\"RUB\",\"SGD\":\"SGD\",\"SEK\":\"SEK\",\"CHF\":\"CHF\",\"THB\":\"THB\",\"USD\":\"$\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-20 23:01:08'),
(25, 0, 114, 'Stripe Checkout', 'StripeV3', '663a39afb519f1715091887.png', 1, '{\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"sk_test_51I6GGiCGv1sRiQlEi5v1or9eR0HVbuzdMd2rW4n3DxC8UKfz66R4X6n4yYkzvI2LeAIuRU9H99ZpY7XCNFC9xMs500vBjZGkKG\"},\"publishable_key\":{\"title\":\"PUBLISHABLE KEY\",\"global\":true,\"value\":\"pk_test_51I6GGiCGv1sRiQlEOisPKrjBqQqqcFsw8mXNaZ2H2baN6R01NulFS7dKFji1NRRxuchoUTEDdB7ujKcyKYSVc0z500eth7otOM\"},\"end_point\":{\"title\":\"End Point Secret\",\"global\":true,\"value\":\"whsec_lUmit1gtxwKTveLnSe88xCSDdnPOt8g5\"}}', '{\"USD\":\"USD\",\"AUD\":\"AUD\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"SGD\":\"SGD\"}', 0, '{\"webhook\":{\"title\": \"Webhook Endpoint\",\"value\":\"ipn.StripeV3\"}}', NULL, '2019-09-14 13:14:22', '2021-05-21 00:58:38'),
(27, 0, 115, 'Mollie', 'Mollie', '663a387ec69371715091582.png', 1, '{\"mollie_email\":{\"title\":\"Mollie Email \",\"global\":true,\"value\":\"vi@gmail.com\"},\"api_key\":{\"title\":\"API KEY\",\"global\":true,\"value\":\"test_cucfwKTWfft9s337qsVfn5CC4vNkrn\"}}', '{\"AED\":\"AED\",\"AUD\":\"AUD\",\"BGN\":\"BGN\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CZK\":\"CZK\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"HRK\":\"HRK\",\"HUF\":\"HUF\",\"ILS\":\"ILS\",\"ISK\":\"ISK\",\"JPY\":\"JPY\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"RON\":\"RON\",\"RUB\":\"RUB\",\"SEK\":\"SEK\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, '2019-09-14 13:14:22', '2021-05-21 02:44:45'),
(30, 0, 116, 'Cashmaal', 'Cashmaal', '663a361b16bd11715090971.png', 1, '{\"web_id\":{\"title\":\"Web Id\",\"global\":true,\"value\":\"3748\"},\"ipn_key\":{\"title\":\"IPN Key\",\"global\":true,\"value\":\"546254628759524554647987\"}}', '{\"PKR\":\"PKR\",\"USD\":\"USD\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.Cashmaal\"}}', NULL, NULL, '2021-06-22 08:05:04'),
(36, 0, 119, 'Mercado Pago', 'MercadoPago', '663a386c714a91715091564.png', 1, '{\"access_token\":{\"title\":\"Access Token\",\"global\":true,\"value\":\"APP_USR-7924565816849832-082312-21941521997fab717db925cf1ea2c190-1071840315\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2022-09-14 07:41:14'),
(37, 0, 120, 'Authorize.net', 'Authorize', '663a35b9ca5991715090873.png', 1, '{\"login_id\":{\"title\":\"Login ID\",\"global\":true,\"value\":\"59e4P9DBcZv\"},\"transaction_key\":{\"title\":\"Transaction Key\",\"global\":true,\"value\":\"47x47TJyLw2E7DbR\"}}', '{\"USD\":\"USD\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"NOK\":\"NOK\",\"PLN\":\"PLN\",\"SEK\":\"SEK\",\"AUD\":\"AUD\",\"NZD\":\"NZD\"}', 0, NULL, NULL, NULL, '2022-08-28 09:33:06'),
(46, 0, 121, 'NMI', 'NMI', '663a3897754cf1715091607.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"2F822Rw39fx762MaV7Yy86jXGTC7sCDy\"}}', '{\"AED\":\"AED\",\"ARS\":\"ARS\",\"AUD\":\"AUD\",\"BOB\":\"BOB\",\"BRL\":\"BRL\",\"CAD\":\"CAD\",\"CHF\":\"CHF\",\"CLP\":\"CLP\",\"CNY\":\"CNY\",\"COP\":\"COP\",\"DKK\":\"DKK\",\"EUR\":\"EUR\",\"GBP\":\"GBP\",\"HKD\":\"HKD\",\"IDR\":\"IDR\",\"ILS\":\"ILS\",\"INR\":\"INR\",\"JPY\":\"JPY\",\"KRW\":\"KRW\",\"MXN\":\"MXN\",\"MYR\":\"MYR\",\"NOK\":\"NOK\",\"NZD\":\"NZD\",\"PEN\":\"PEN\",\"PHP\":\"PHP\",\"PLN\":\"PLN\",\"PYG\":\"PYG\",\"RUB\":\"RUB\",\"SEC\":\"SEC\",\"SGD\":\"SGD\",\"THB\":\"THB\",\"TRY\":\"TRY\",\"TWD\":\"TWD\",\"USD\":\"USD\",\"ZAR\":\"ZAR\"}', 0, NULL, NULL, NULL, '2022-08-28 10:32:31'),
(51, 0, 122, 'BTCPay', 'BTCPay', '663a35cd25a8d1715090893.png', 1, '{\"store_id\":{\"title\":\"Store Id\",\"global\":true,\"value\":\"-------\"},\"api_key\":{\"title\":\"Api Key\",\"global\":true,\"value\":\"------\"},\"server_name\":{\"title\":\"Server Name\",\"global\":true,\"value\":\"https:\\/\\/yourbtcpaserver.lndyn.com\"},\"secret_code\":{\"title\":\"Secret Code\",\"global\":true,\"value\":\"----------\"}}', '{\"BTC\":\"Bitcoin\",\"LTC\":\"Litecoin\"}', 0, '{\"webhook\":{\"title\": \"IPN URL\",\"value\":\"ipn.BTCPay\"}}', NULL, '2023-02-28 06:24:25', '2022-08-28 10:32:31'),
(52, 0, 123, 'Now payments hosted', 'NowPaymentsHosted', '663a38b8d57a81715091640.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"-------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------\"}}', '{\"BTG\":\"BTG\",\"ETH\":\"ETH\",\"XMR\":\"XMR\",\"ZEC\":\"ZEC\",\"XVG\":\"XVG\",\"ADA\":\"ADA\",\"LTC\":\"LTC\",\"BCH\":\"BCH\",\"QTUM\":\"QTUM\",\"DASH\":\"DASH\",\"XLM\":\"XLM\",\"XRP\":\"XRP\",\"XEM\":\"XEM\",\"DGB\":\"DGB\",\"LSK\":\"LSK\",\"DOGE\":\"DOGE\",\"TRX\":\"TRX\",\"KMD\":\"KMD\",\"REP\":\"REP\",\"BAT\":\"BAT\",\"ARK\":\"ARK\",\"WAVES\":\"WAVES\",\"BNB\":\"BNB\",\"XZC\":\"XZC\",\"NANO\":\"NANO\",\"TUSD\":\"TUSD\",\"VET\":\"VET\",\"ZEN\":\"ZEN\",\"GRS\":\"GRS\",\"FUN\":\"FUN\",\"NEO\":\"NEO\",\"GAS\":\"GAS\",\"PAX\":\"PAX\",\"USDC\":\"USDC\",\"ONT\":\"ONT\",\"XTZ\":\"XTZ\",\"LINK\":\"LINK\",\"RVN\":\"RVN\",\"BNBMAINNET\":\"BNBMAINNET\",\"ZIL\":\"ZIL\",\"BCD\":\"BCD\",\"USDT\":\"USDT\",\"USDTERC20\":\"USDTERC20\",\"CRO\":\"CRO\",\"DAI\":\"DAI\",\"HT\":\"HT\",\"WABI\":\"WABI\",\"BUSD\":\"BUSD\",\"ALGO\":\"ALGO\",\"USDTTRC20\":\"USDTTRC20\",\"GT\":\"GT\",\"STPT\":\"STPT\",\"AVA\":\"AVA\",\"SXP\":\"SXP\",\"UNI\":\"UNI\",\"OKB\":\"OKB\",\"BTC\":\"BTC\"}', 0, '', NULL, '2023-02-28 06:24:25', '2022-08-28 10:32:31'),
(53, 0, 509, 'Now payments checkout', 'NowPaymentsCheckout', '663a38a59d2541715091621.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"-------------------\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"--------------\"}}', '{\"USD\":\"USD\",\"EUR\":\"EUR\"}', 0, '', NULL, '2023-02-28 06:24:25', '2022-08-28 10:32:31'),
(54, 0, 510, 'Binance', 'Binance', '663a35db4fd621715090907.png', 1, '{\"api_key\":{\"title\":\"API Key\",\"global\":true,\"value\":\"tsu3tjiq0oqfbtmlbevoeraxhfbp3brejnm9txhjxcp4to29ujvakvfl1ibsn3ja\"},\"secret_key\":{\"title\":\"Secret Key\",\"global\":true,\"value\":\"jzngq4t04ltw8d4iqpi7admfl8tvnpehxnmi34id1zvfaenbwwvsvw7llw3zdko8\"},\"merchant_id\":{\"title\":\"Merchant ID\",\"global\":true,\"value\":\"231129033\"}}', '{\"BTC\":\"Bitcoin\",\"USD\":\"USD\",\"BNB\":\"BNB\"}', 1, '{\"cron\":{\"title\": \"Cron Job URL\",\"value\":\"ipn.Binance\"}}', NULL, NULL, '2023-02-14 05:08:04'),
(55, 0, 124, 'SslCommerz', 'SslCommerz', '663a397a70c571715091834.png', 1, '{\"store_id\": {\"title\": \"Store ID\",\"global\": true,\"value\": \"---------\"},\"store_password\": {\"title\": \"Store Password\",\"global\": true,\"value\": \"----------\"}}', '{\"BDT\":\"BDT\",\"USD\":\"USD\",\"EUR\":\"EUR\",\"SGD\":\"SGD\",\"INR\":\"INR\",\"MYR\":\"MYR\"}', 0, NULL, NULL, NULL, '2023-05-06 07:43:01'),
(56, 0, 125, 'Aamarpay', 'Aamarpay', '663a34d5d1dfc1715090645.png', 1, '{\"store_id\": {\"title\": \"Store ID\",\"global\": true,\"value\": \"---------\"},\"signature_key\": {\"title\": \"Signature Key\",\"global\": true,\"value\": \"----------\"}}', '{\"BDT\":\"BDT\"}', 0, NULL, NULL, NULL, '2023-05-06 07:43:01');

-- --------------------------------------------------------

--
-- Table structure for table `gateway_currencies`
--

CREATE TABLE `gateway_currencies` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `symbol` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `method_code` int DEFAULT NULL,
  `gateway_alias` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `min_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `max_amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `percent_charge` decimal(5,2) NOT NULL DEFAULT '0.00',
  `fixed_charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `rate` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `gateway_parameter` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint UNSIGNED NOT NULL,
  `site_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cur_text` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency text',
  `cur_sym` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'currency symbol',
  `email_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_from_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_template` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_from` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_template` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `base_color` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT 'email configuration',
  `sms_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `firebase_config` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `global_shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `online_payment` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Online_apyment_active->1, Inactive->0',
  `multi_language` tinyint(1) NOT NULL DEFAULT '1',
  `en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'email notification, 0 - dont send, 1 - send',
  `sn` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'sms notification, 0 - dont send, 1 - send',
  `pn` tinyint(1) NOT NULL DEFAULT '1',
  `force_ssl` tinyint(1) NOT NULL DEFAULT '0',
  `maintenance_mode` tinyint(1) NOT NULL DEFAULT '0',
  `active_template` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `system_customized` tinyint(1) NOT NULL DEFAULT '0',
  `paginate_number` int NOT NULL DEFAULT '0',
  `available_version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `currency_format` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1=>Both\r\n2=>Text Only\r\n3=>Symbol Only',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `site_name`, `cur_text`, `cur_sym`, `email_from`, `email_from_name`, `email_template`, `sms_template`, `sms_from`, `push_title`, `push_template`, `base_color`, `country_code`, `mail_config`, `sms_config`, `firebase_config`, `global_shortcodes`, `online_payment`, `multi_language`, `en`, `sn`, `pn`, `force_ssl`, `maintenance_mode`, `active_template`, `system_customized`, `paginate_number`, `available_version`, `currency_format`, `created_at`, `updated_at`) VALUES
(1, 'Docrib', 'USD', '$', 'info@viserlab.com', 'viserlab', '<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n  <!--[if !mso]><!-->\r\n  <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\r\n  <!--<![endif]-->\r\n  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">\r\n  <title></title>\r\n  <style type=\"text/css\">\r\n.ReadMsgBody { width: 100%; background-color: #ffffff; }\r\n.ExternalClass { width: 100%; background-color: #ffffff; }\r\n.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div { line-height: 100%; }\r\nhtml { width: 100%; }\r\nbody { -webkit-text-size-adjust: none; -ms-text-size-adjust: none; margin: 0; padding: 0; }\r\ntable { border-spacing: 0; table-layout: fixed; margin: 0 auto;border-collapse: collapse; }\r\ntable table table { table-layout: auto; }\r\n.yshortcuts a { border-bottom: none !important; }\r\nimg:hover { opacity: 0.9 !important; }\r\na { color: #0087ff; text-decoration: none; }\r\n.textbutton a { font-family: \'open sans\', arial, sans-serif !important;}\r\n.btn-link a { color:#FFFFFF !important;}\r\n\r\n@media only screen and (max-width: 480px) {\r\nbody { width: auto !important; }\r\n*[class=\"table-inner\"] { width: 90% !important; text-align: center !important; }\r\n*[class=\"table-full\"] { width: 100% !important; text-align: center !important; }\r\n/* image */\r\nimg[class=\"img1\"] { width: 100% !important; height: auto !important; }\r\n}\r\n</style>\r\n\r\n\r\n\r\n  <table bgcolor=\"#414a51\" width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tbody><tr>\r\n      <td height=\"50\"></td>\r\n    </tr>\r\n    <tr>\r\n      <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n        <table align=\"center\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\r\n          <tbody><tr>\r\n            <td align=\"center\" width=\"600\">\r\n              <!--header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#0087ff\" style=\"border-top-left-radius:6px; border-top-right-radius:6px;text-align:center;vertical-align:top;font-size:0;\" align=\"center\">\r\n                    <table width=\"90%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#FFFFFF; font-size:16px; font-weight: bold;\">This is a System Generated Email</td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n              <!--end header-->\r\n              <table class=\"table-inner\" width=\"95%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                <tbody><tr>\r\n                  <td bgcolor=\"#FFFFFF\" align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"35\"></td>\r\n                      </tr>\r\n                      <!--logo-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"vertical-align:top;font-size:0;\">\r\n                          <a href=\"#\">\r\n                            <img style=\"display:block; line-height:0px; font-size:0px; border:0px;\" src=\"https://i.imgur.com/Z1qtvtV.png\" alt=\"img\">\r\n                          </a>\r\n                        </td>\r\n                      </tr>\r\n                      <!--end logo-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n                      <!--headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"font-family: \'Open Sans\', Arial, sans-serif; font-size: 22px;color:#414a51;font-weight: bold;\">Hello {{fullname}} ({{username}})</td>\r\n                      </tr>\r\n                      <!--end headline-->\r\n                      <tr>\r\n                        <td align=\"center\" style=\"text-align:center;vertical-align:top;font-size:0;\">\r\n                          <table width=\"40\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                            <tbody><tr>\r\n                              <td height=\"20\" style=\" border-bottom:3px solid #0087ff;\"></td>\r\n                            </tr>\r\n                          </tbody></table>\r\n                        </td>\r\n                      </tr>\r\n                      <tr>\r\n                        <td height=\"20\"></td>\r\n                      </tr>\r\n                      <!--content-->\r\n                      <tr>\r\n                        <td align=\"left\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#7f8c8d; font-size:16px; line-height: 28px;\">{{message}}</td>\r\n                      </tr>\r\n                      <!--end content-->\r\n                      <tr>\r\n                        <td height=\"40\"></td>\r\n                      </tr>\r\n              \r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n                <tr>\r\n                  <td height=\"45\" align=\"center\" bgcolor=\"#f4f4f4\" style=\"border-bottom-left-radius:6px;border-bottom-right-radius:6px;\">\r\n                    <table align=\"center\" width=\"90%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n                      <tbody><tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                      <!--preference-->\r\n                      <tr>\r\n                        <td class=\"preference-link\" align=\"center\" style=\"font-family: \'Open sans\', Arial, sans-serif; color:#95a5a6; font-size:14px;\">\r\n                          © 2024 <a href=\"#\">{{site_name}}</a>&nbsp;. All Rights Reserved. \r\n                        </td>\r\n                      </tr>\r\n                      <!--end preference-->\r\n                      <tr>\r\n                        <td height=\"10\"></td>\r\n                      </tr>\r\n                    </tbody></table>\r\n                  </td>\r\n                </tr>\r\n              </tbody></table>\r\n            </td>\r\n          </tr>\r\n        </tbody></table>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td height=\"60\"></td>\r\n    </tr>\r\n  </tbody></table>', 'hi {{fullname}} ({{username}}), {{message}}', 'ViserAdmin', NULL, NULL, 'FF8787', '+880', '{\"name\":\"php\"}', '{\"name\":\"nexmo\",\"clickatell\":{\"api_key\":\"----------------\"},\"infobip\":{\"username\":\"------------8888888\",\"password\":\"-----------------\"},\"message_bird\":{\"api_key\":\"-------------------\"},\"nexmo\":{\"api_key\":\"----------------------\",\"api_secret\":\"----------------------\"},\"sms_broadcast\":{\"username\":\"----------------------\",\"password\":\"-----------------------------\"},\"twilio\":{\"account_sid\":\"-----------------------\",\"auth_token\":\"---------------------------\",\"from\":\"----------------------\"},\"text_magic\":{\"username\":\"-----------------------\",\"apiv2_key\":\"-------------------------------\"},\"custom\":{\"method\":\"get\",\"url\":\"https:\\/\\/hostname\\/demo-api-v1\",\"headers\":{\"name\":[\"api_key\"],\"value\":[\"test_api 555\"]},\"body\":{\"name\":[\"from_number\"],\"value\":[\"5657545757\"]}}}', '{\"apiKey\":\"AIzaSyBZM46BExdqBKafQ0eoON6eWKBFXZQdAJk\",\"authDomain\":\"push-5f0b1.firebaseapp.com\",\"projectId\":\"push-5f0b1\",\"storageBucket\":\"push-5f0b1.appspot.com\",\"messagingSenderId\":\"686517081317\",\"appId\":\"1:686517081317:web:e307b7a49995751c32b00c\",\"measurementId\":\"G-T0YE3RHJE6\"}', '{\n    \"site_name\":\"Name of your site\",\n    \"site_currency\":\"Currency of your site\",\n    \"currency_symbol\":\"Symbol of currency\"\n}', 1, 1, 1, 1, 1, 0, 0, 'basic', 0, 20, '0', 1, NULL, '2024-08-11 04:43:58');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_default` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: not default language, 1: default language',
  `image` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `code`, `is_default`, `image`, `created_at`, `updated_at`) VALUES
(1, 'English', 'en', 1, '66b9e9c6576591723460038.png', '2020-07-06 03:47:55', '2024-08-12 04:53:59');

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `assistant_id` int UNSIGNED NOT NULL DEFAULT '0',
  `doctor_id` int NOT NULL DEFAULT '0',
  `staff_id` int NOT NULL DEFAULT '0',
  `sender` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_to` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `notification_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_templates`
--

CREATE TABLE `notification_templates` (
  `id` bigint UNSIGNED NOT NULL,
  `act` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sms_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `push_body` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `shortcodes` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `email_status` tinyint(1) NOT NULL DEFAULT '1',
  `email_sent_from_name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_sent_from_address` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sms_status` tinyint(1) NOT NULL DEFAULT '1',
  `sms_sent_from` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `push_status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notification_templates`
--

INSERT INTO `notification_templates` (`id`, `act`, `name`, `subject`, `push_title`, `email_body`, `sms_body`, `push_body`, `shortcodes`, `email_status`, `email_sent_from_name`, `email_sent_from_address`, `sms_status`, `sms_sent_from`, `push_status`, `created_at`, `updated_at`) VALUES
(1, 'DEPOSIT_COMPLETE', 'Deposit - Automated - Successful', 'Deposit Completed Successfully', NULL, '<div>Your deposit of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>has been completed Successfully.<span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#000000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Received : {{method_amount}} {{method_currency}}<br></div><div>Paid via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit successfully by {{method_name}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-03 02:25:43'),
(2, 'DEPOSIT_APPROVE', 'Deposit - Manual - Approved', 'Your Deposit is Approved', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>is Approved .<span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Amount : {{amount}} {{site_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\"><span style=\"font-weight: bolder;\"><br></span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"5\">Your current Balance is&nbsp;<span style=\"font-weight: bolder;\">{{post_balance}} {{site_currency}}</span></font></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div>', 'Admin Approve Your {{amount}} {{site_currency}} payment request by {{method_name}} transaction : {{trx}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"post_balance\":\"Balance of the user after this transaction\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-03 02:26:07'),
(3, 'DEPOSIT_REJECT', 'Deposit - Manual - Rejected', 'Your Deposit Request is Rejected', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}} has been rejected</span>.<span style=\"font-weight: bolder;\"><br></span></div><div><br></div><div><br></div><div style=\"font-family: Montserrat, sans-serif;\">Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div style=\"font-family: Montserrat, sans-serif;\">Received : {{method_amount}} {{method_currency}}<br></div><div style=\"font-family: Montserrat, sans-serif;\">Paid via :&nbsp; {{method_name}}</div><div style=\"font-family: Montserrat, sans-serif;\">Charge: {{charge}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">Transaction Number was : {{trx}}</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\">if you have any queries, feel free to contact us.<br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><br><br></div><span style=\"color: rgb(33, 37, 41); font-family: Montserrat, sans-serif;\">{{rejection_message}}</span><br>', 'Admin Rejected Your {{amount}} {{site_currency}} payment request by {{method_name}}\r\n\r\n{{rejection_message}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\",\"rejection_message\":\"Rejection message by the admin\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-05 03:45:27'),
(4, 'DEPOSIT_REQUEST', 'Deposit - Manual - Requested', 'Deposit Request Submitted Successfully', NULL, '<div>Your deposit request of&nbsp;<span style=\"font-weight: bolder;\">{{amount}} {{site_currency}}</span>&nbsp;is via&nbsp;&nbsp;<span style=\"font-weight: bolder;\">{{method_name}}&nbsp;</span>submitted successfully<span style=\"font-weight: bolder;\">&nbsp;.<br></span></div><div><span style=\"font-weight: bolder;\"><br></span></div><div><span style=\"font-weight: bolder;\">Details of your Deposit :<br></span></div><div><br></div><div>Amount : {{amount}} {{site_currency}}</div><div>Charge:&nbsp;<font color=\"#FF0000\">{{charge}} {{site_currency}}</font></div><div><br></div><div>Conversion Rate : 1 {{site_currency}} = {{rate}} {{method_currency}}</div><div>Payable : {{method_amount}} {{method_currency}}<br></div><div>Pay via :&nbsp; {{method_name}}</div><div><br></div><div>Transaction Number : {{trx}}</div><div><br></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', '{{amount}} {{site_currency}} Deposit requested by {{method_name}}. Charge: {{charge}} . Trx: {{trx}}', NULL, '{\"trx\":\"Transaction number for the deposit\",\"amount\":\"Amount inserted by the user\",\"charge\":\"Gateway charge set by the admin\",\"rate\":\"Conversion rate between base currency and method currency\",\"method_name\":\"Name of the deposit method\",\"method_currency\":\"Currency of the deposit method\",\"method_amount\":\"Amount after conversion between base currency and method currency\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-03 02:29:19'),
(5, 'PASS_RESET_CODE', 'Password - Reset - Code', 'Password Reset', NULL, '<div style=\"font-family: Montserrat, sans-serif;\">We have received a request to reset the password for your account on&nbsp;<span style=\"font-weight: bolder;\">{{time}} .<br></span></div><div style=\"font-family: Montserrat, sans-serif;\">Requested From IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>.</div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><br style=\"font-family: Montserrat, sans-serif;\"><div style=\"font-family: Montserrat, sans-serif;\"><div>Your account recovery code is:&nbsp;&nbsp;&nbsp;<font size=\"6\"><span style=\"font-weight: bolder;\">{{code}}</span></font></div><div><br></div></div><div style=\"font-family: Montserrat, sans-serif;\"><br></div><div style=\"font-family: Montserrat, sans-serif;\"><font size=\"4\" color=\"#CC0000\">If you do not wish to reset your password, please disregard this message.&nbsp;</font><br></div><div><font size=\"4\" color=\"#CC0000\"><br></font></div>', 'Your account recovery code is: {{code}}', NULL, '{\"code\":\"Verification code for password reset\",\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, NULL, NULL, 0, NULL, 0, '2021-11-03 12:00:00', '2022-03-20 20:47:05'),
(6, 'PASS_RESET_DONE', 'Password - Reset - Confirmation', 'You have reset your password', NULL, '<p style=\"font-family: Montserrat, sans-serif;\">You have successfully reset your password.</p><p style=\"font-family: Montserrat, sans-serif;\">You changed from&nbsp; IP:&nbsp;<span style=\"font-weight: bolder;\">{{ip}}</span>&nbsp;using&nbsp;<span style=\"font-weight: bolder;\">{{browser}}</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{operating_system}}&nbsp;</span>&nbsp;on&nbsp;<span style=\"font-weight: bolder;\">{{time}}</span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><br></span></p><p style=\"font-family: Montserrat, sans-serif;\"><span style=\"font-weight: bolder;\"><font color=\"#ff0000\">If you did not change that, please contact us as soon as possible.</font></span></p>', 'Your password has been changed successfully', NULL, '{\"ip\":\"IP address of the user\",\"browser\":\"Browser of the user\",\"operating_system\":\"Operating system of the user\",\"time\":\"Time of the request\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-04-05 03:46:35'),
(7, 'ADMIN_SUPPORT_REPLY', 'Support - Reply', 'Reply Support Ticket', NULL, '<div><p><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\">A member from our support team has replied to the following ticket:</span></span></p><p><span style=\"font-weight: bolder;\"><span data-mce-style=\"font-size: 11pt;\" style=\"font-size: 11pt;\"><span style=\"font-weight: bolder;\"><br></span></span></span></p><p><span style=\"font-weight: bolder;\">[Ticket#{{ticket_id}}] {{ticket_subject}}<br><br>Click here to reply:&nbsp; {{link}}</span></p><p>----------------------------------------------</p><p>Here is the reply :<br></p><p>{{reply}}<br></p></div><div><br style=\"font-family: Montserrat, sans-serif;\"></div>', 'Your Ticket#{{ticket_id}} :  {{ticket_subject}} has been replied.', NULL, '{\"ticket_id\":\"ID of the support ticket\",\"ticket_subject\":\"Subject  of the support ticket\",\"reply\":\"Reply made by the admin\",\"link\":\"URL to view the support ticket\"}', 1, NULL, NULL, 1, NULL, 0, '2021-11-03 12:00:00', '2022-03-20 20:47:51'),
(8, 'DEFAULT', 'Default Template', '{{subject}}', '{{subject}}', '{{message}}', '{{message}}', '{{message}}', '{\"subject\":\"Subject\",\"message\":\"Message\"}', 1, NULL, NULL, 1, NULL, 1, '2019-09-14 13:14:22', '2024-08-01 03:33:20'),
(9, 'PEOPLE_CREDENTIAL', 'Sent Credential', 'You Are Added successfully', NULL, '<div>Mr {{name}} welcome to {{site_name}}</div>\r\n<div>Your username: {{username}} & Your password: {{password}}</div>\r\n<div>Now, You can update your all credential, login via {{guard}}.</div> <br> <div>Thank you for being with us.</div>', '<div>Mr {{name}} welcome to {{site_name}}</div>\r\n<div>Your username: {{username}} & Your password: {{password}}</div>\r\n<div>Now, You can update your all credential, login via {{guard}}.</div> <br> <div>Thank you for being with us.</div>', NULL, '{\"name\":\"full Name\",\"username\":\"Access his/her guard username\",\"password\":\"Access his/her guard password\"}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(10, 'APPOINTMENT_CONFIRMATION', 'Appointment Confirmation', 'Appointment Confirmation', NULL, 'We have received an appointment request for the date of {{booking_date}} and Serial/time/Slot:{{time_serial}} with Dr. {{doctor_name}}. Your request is confirmed. You have to pay {{doctor_fees}} after completing the appointment. Please be present there at due time.\r\n Thanks for being with us.', 'We have received an appointment request for the date of {{booking_date}} and Serial/time/Slot:{{time_serial}} with Dr. {{doctor_name}}. Your request is confirmed. You have to pay {{doctor_fees}} after completing the appointment. Please be present there at due time.\r\n Thanks for being with us.', NULL, '{\"booking_date\":\"Booking date for appointment\",\"time_serial\":\"Serial no or Time\",\"doctor_name\":\"Appointment doctor name\",\"doctor_fees\":\"Doctor Fees\"}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL),
(11, 'APPOINTMENT_REJECTION', 'Appointment Rejection', 'Appointment Rejection', NULL, 'We have rejected your appointment request for the date of {{booking_date}} and time {{time_serial}} with Dr. {{doctor_name}}. We are suggested to try another schedule.Thanks for being with us.', 'We have rejected your appointment request for the date of {{booking_date}} and time {{time_serial}} with Dr. {{doctor_name}}. We are suggested to try another schedule.Thanks for being with us.', NULL, '{\"booking_date\":\"Booking date for appointment\",\"time_serial\":\"Serial no or Time\",\"doctor_name\":\"Appointment doctor name\"}', 1, NULL, NULL, 1, NULL, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tempname` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'template name',
  `secs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `seo_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `name`, `slug`, `tempname`, `secs`, `seo_content`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 'HOME', '/', 'templates.basic.', '[\"department\",\"doctor\",\"search\",\"feature\",\"testimonial\",\"faq\",\"partner\",\"blog\"]', NULL, 1, '2020-07-11 06:23:58', '2024-08-12 01:59:09'),
(4, 'Blog', 'blog', 'templates.basic.', NULL, '{\"image\":\"66b7580f054e31723291663.png\",\"description\":\"Dolor eum deleniti d\",\"social_title\":\"Aliquam adipisci cum\",\"social_description\":\"Reprehenderit volupt\",\"keywords\":[\"asd\",\"ret\",\"gh\",\"sdf\"]}', 1, '2020-10-22 01:14:43', '2024-08-10 06:07:43'),
(5, 'Contact', 'contact', 'templates.basic.', NULL, '{\"image\":\"66b75719362a81723291417.png\",\"description\":\"Accusamus sit fugiat\",\"social_title\":\"Quo reiciendis adipi\",\"social_description\":\"Eos eius repudiandae\",\"keywords\":[\"Doloremerter\",\"ghj\",\"tytr\",\"gfh\"]}', 1, '2020-10-22 01:14:53', '2024-08-10 06:03:37'),
(19, 'Doctor', 'doctors/all', 'templates.basic.', NULL, '{\"image\":\"66b7660acf2541723295242.png\",\"description\":\"Ullamco dolore eos o\",\"social_title\":\"Eum ipsum culpa exer\",\"social_description\":\"Harum impedit eaque\",\"keywords\":[\"Iuredfgdfg\",\"ert\",\"ret\",\"jgf\"]}', 1, '2020-10-22 01:14:53', '2024-08-10 07:07:22');

-- --------------------------------------------------------

--
-- Table structure for table `social_icons`
--

CREATE TABLE `social_icons` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` int NOT NULL,
  `title` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `social_icons`
--

INSERT INTO `social_icons` (`id`, `doctor_id`, `title`, `icon`, `url`, `created_at`, `updated_at`) VALUES
(1, 9, 'Facebook', '<i class=\"lab la-facebook-f\"></i>', 'https://www.facebook.com/', '2024-07-31 03:09:03', '2024-07-31 03:09:03'),
(2, 9, 'Instagram', '<i class=\"fab fa-instagram\"></i>', 'https://www.instagram.com/accounts/login/', '2024-07-31 03:09:35', '2024-07-31 03:09:35'),
(3, 9, 'Youtube', '<i class=\"lab la-youtube\"></i>', 'https://www.youtube.com/', '2024-07-31 03:10:05', '2024-07-31 03:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mobile` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0: inactive, 1: active',
  `remember_token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_logins`
--

CREATE TABLE `staff_logins` (
  `id` bigint UNSIGNED NOT NULL,
  `staff_id` int NOT NULL,
  `staff_ip` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `browser` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `os` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `longitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country_code` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff_password_resets`
--

CREATE TABLE `staff_password_resets` (
  `id` int UNSIGNED NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `id` bigint UNSIGNED NOT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_attachments`
--

CREATE TABLE `support_attachments` (
  `id` bigint UNSIGNED NOT NULL,
  `support_message_id` int UNSIGNED NOT NULL DEFAULT '0',
  `attachment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_messages`
--

CREATE TABLE `support_messages` (
  `id` bigint UNSIGNED NOT NULL,
  `support_ticket_id` int UNSIGNED NOT NULL DEFAULT '0',
  `admin_id` int UNSIGNED NOT NULL DEFAULT '0',
  `message` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_tickets`
--

CREATE TABLE `support_tickets` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` int DEFAULT '0',
  `name` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0: Open, 1: Answered, 2: Replied, 3: Closed',
  `priority` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1 = Low, 2 = medium, 3 = heigh',
  `last_reply` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint UNSIGNED NOT NULL,
  `doctor_id` int UNSIGNED NOT NULL DEFAULT '0',
  `amount` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `charge` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `post_balance` decimal(28,8) NOT NULL DEFAULT '0.00000000',
  `trx_type` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `trx` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remark` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `update_logs`
--

CREATE TABLE `update_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `version` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `update_log` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `update_logs`
--

INSERT INTO `update_logs` (`id`, `version`, `update_log`, `created_at`, `updated_at`) VALUES
(1, '3.0', '[\r\n\"[ADD] Push Notification\",\r\n\"[ADD] Binance Payment Gateway\",\r\n\"[ADD] Aamarpay Payment Gateway\",\r\n\"[ADD] SslCommerz Payment Gateway\",\r\n\"[ADD] Slug Management for Blogs\",\r\n\"[ADD] SEO Content Management for Blog\",\r\n\"[ADD] Slug Management for Policy Pages\",\r\n\"[ADD] SEO Content Management for Policy Pages\",\r\n\"[ADD] Input type number, url, date, and time in the Form Generator\",\r\n\"[ADD] Configurable Input Filed Width in the Form Generator\",\r\n\"[ADD] Configurable Hints/Instructions for Input Fields in the Form Generator\",\r\n\"[ADD] Sorting Option for Input Fields in the Form Generator\",\r\n\"[ADD] Controllable Login System with Google, Facebook, Linkedin\",\r\n\"[ADD] Automatic System Update\",\r\n\"[ADD] Image on Deposit And Withdraw Method\",\r\n\"[ADD] Configurable Number of Items Per Page for Pagination\",\r\n\"[ADD] Configurable Currency Display Format\",\r\n\"[ADD] Resend Code Countdown on Verification Pages\",\r\n\"[UPDATE] Admin Dashboard Widget Design\",\r\n\"[UPDATE] Notification Sending Process\",\r\n\"[UPDATE] User Experience of the Admin Sidebar\",\r\n\"[UPDATE] Improved Menu Searching Functionality on the Admin Panel\",\r\n\"[UPDATE] User Experience of the Select Fields of the Admin Panel\",\r\n\"[UPDATE] Centralized Settings System\",\r\n\"[UPDATE] Form Generator UI on the Admin Panel\",\r\n\"[UPDATE] Google Analytics Script\",\r\n\"[UPDATE] Notification Toaster UI\",\r\n\"[UPDATE] Support Ticket Attachment Upload UI\",\r\n\"[UPDATE] Notification Template Content Configuration\",\r\n\"[UPDATE] Configurable Email From Name and Address for Each Template\",\r\n\"[UPDATE] Configurable SMS From for Each Template\",\r\n\"[UPDATE] Overall User Interface of the Admin Panel\",\r\n\"[PATCH] Laravel 11\",\r\n\"[PATCH] PHP 8.3\",\r\n\"[PATCH] Latest System Patch\",\r\n\"[PATCH] Latest Security Patch\"\r\n]', '2024-08-12 08:27:48', '2024-08-12 08:27:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`,`username`);

--
-- Indexes for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assistants`
--
ALTER TABLE `assistants`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assistants_username_unique` (`username`),
  ADD UNIQUE KEY `assistants_email_unique` (`email`);

--
-- Indexes for table `assistant_doctor_tracks`
--
ALTER TABLE `assistant_doctor_tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assistant_logins`
--
ALTER TABLE `assistant_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assistant_password_resets`
--
ALTER TABLE `assistant_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assistant_password_resets_email_index` (`email`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `deposits`
--
ALTER TABLE `deposits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `device_tokens`
--
ALTER TABLE `device_tokens`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `doctors_username_unique` (`username`),
  ADD UNIQUE KEY `doctors_email_unique` (`email`);

--
-- Indexes for table `doctor_logins`
--
ALTER TABLE `doctor_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctor_password_resets`
--
ALTER TABLE `doctor_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doctor_password_resets_email_index` (`email`);

--
-- Indexes for table `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `experiences`
--
ALTER TABLE `experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `extensions`
--
ALTER TABLE `extensions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `forms`
--
ALTER TABLE `forms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gateways`
--
ALTER TABLE `gateways`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_templates`
--
ALTER TABLE `notification_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `social_icons`
--
ALTER TABLE `social_icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_logins`
--
ALTER TABLE `staff_logins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_password_resets`
--
ALTER TABLE `staff_password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `staff_password_resets_email_index` (`email`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_attachments`
--
ALTER TABLE `support_attachments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_tickets`
--
ALTER TABLE `support_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_logs`
--
ALTER TABLE `update_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `admin_notifications`
--
ALTER TABLE `admin_notifications`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_password_resets`
--
ALTER TABLE `admin_password_resets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assistants`
--
ALTER TABLE `assistants`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assistant_doctor_tracks`
--
ALTER TABLE `assistant_doctor_tracks`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assistant_logins`
--
ALTER TABLE `assistant_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assistant_password_resets`
--
ALTER TABLE `assistant_password_resets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deposits`
--
ALTER TABLE `deposits`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `device_tokens`
--
ALTER TABLE `device_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_logins`
--
ALTER TABLE `doctor_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `doctor_password_resets`
--
ALTER TABLE `doctor_password_resets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `education`
--
ALTER TABLE `education`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `experiences`
--
ALTER TABLE `experiences`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `extensions`
--
ALTER TABLE `extensions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `forms`
--
ALTER TABLE `forms`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `gateways`
--
ALTER TABLE `gateways`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `gateway_currencies`
--
ALTER TABLE `gateway_currencies`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_templates`
--
ALTER TABLE `notification_templates`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `social_icons`
--
ALTER TABLE `social_icons`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_logins`
--
ALTER TABLE `staff_logins`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staff_password_resets`
--
ALTER TABLE `staff_password_resets`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_attachments`
--
ALTER TABLE `support_attachments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_tickets`
--
ALTER TABLE `support_tickets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `update_logs`
--
ALTER TABLE `update_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
