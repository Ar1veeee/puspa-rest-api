-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 12, 2026 at 09:26 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `puspa_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_phone` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_birth_date` date DEFAULT NULL,
  `profile_picture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `user_id`, `admin_name`, `admin_phone`, `admin_birth_date`, `profile_picture`, `created_at`, `updated_at`) VALUES
('01kg7kfnaz9evpa3f792ytcsg1', '01kg7kfnasqyygb0n3g878wnvz', 'Annisa Koirul', 'eyJpdiI6InhJRGxoREtjUFNnT0U2TGwyZWRROXc9PSIsInZhbHVlIjoiVFJTak5xeTdQUkxBTUtOaDFoU05pUT09IiwibWFjIjoiYTMwOTRmNzNlMjJmMmIzMWNhNWYzNzlkYmRkOThhMTM5YzAzZjRkNWU2MTkxYjYyODdkOWVkYjYzMWYzM2UxMSIsInRhZyI6IiJ9', '1996-01-30', NULL, '2026-01-30 14:04:03', '2026-01-30 14:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `assessments`
--

CREATE TABLE `assessments` (
  `id` bigint UNSIGNED NOT NULL,
  `observation_id` bigint UNSIGNED NOT NULL,
  `child_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','scheduled','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `scheduled_date` datetime DEFAULT NULL,
  `parent_status` enum('pending','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `report_file` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `report_uploaded_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessments`
--

INSERT INTO `assessments` (`id`, `observation_id`, `child_id`, `status`, `scheduled_date`, `parent_status`, `report_file`, `report_uploaded_at`, `created_at`, `updated_at`) VALUES
(1, 1, '01kg7kqwbcrx19k3vnmd76x1mt', 'scheduled', '2026-02-20 11:01:00', 'pending', NULL, NULL, '2026-01-30 14:09:58', '2026-01-30 14:10:46'),
(2, 2, '01kg7pmt7jmprrbd5ds2mvtzrk', 'scheduled', '2026-02-07 00:01:00', 'pending', NULL, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_answers`
--

CREATE TABLE `assessment_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `assessment_detail_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `type` enum('umum_parent','fisio_parent','okupasi_parent','paedagog_parent','wicara_parent','fisio_assessor','okupasi_assessor','paedagog_assessor','wicara_assessor') COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_value` longtext COLLATE utf8mb4_unicode_ci,
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_details`
--

CREATE TABLE `assessment_details` (
  `id` bigint UNSIGNED NOT NULL,
  `assessment_id` bigint UNSIGNED NOT NULL,
  `type` enum('umum','fisio','okupasi','wicara','paedagog') COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` char(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `therapist_id` char(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `completed_at` timestamp NULL DEFAULT NULL,
  `parent_completed_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_details`
--

INSERT INTO `assessment_details` (`id`, `assessment_id`, `type`, `admin_id`, `therapist_id`, `completed_at`, `parent_completed_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'umum', '01kg7kfnaz9evpa3f792ytcsg1', NULL, NULL, NULL, '2026-01-30 14:09:58', '2026-01-30 14:10:46'),
(2, 1, 'fisio', '01kg7kfnaz9evpa3f792ytcsg1', NULL, NULL, NULL, '2026-01-30 14:09:58', '2026-01-30 14:10:46'),
(3, 1, 'okupasi', '01kg7kfnaz9evpa3f792ytcsg1', NULL, NULL, NULL, '2026-01-30 14:09:58', '2026-01-30 14:10:46'),
(4, 1, 'wicara', '01kg7kfnaz9evpa3f792ytcsg1', NULL, NULL, NULL, '2026-01-30 14:09:58', '2026-01-30 14:10:46'),
(5, 1, 'paedagog', '01kg7kfnaz9evpa3f792ytcsg1', NULL, NULL, NULL, '2026-01-30 14:09:58', '2026-01-30 14:10:46'),
(6, 2, 'umum', '01kg7kfnaz9evpa3f792ytcsg1', NULL, NULL, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:42'),
(7, 2, 'okupasi', '01kg7kfnaz9evpa3f792ytcsg1', NULL, NULL, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:42'),
(8, 2, 'wicara', '01kg7kfnaz9evpa3f792ytcsg1', NULL, NULL, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:42');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_questions`
--

CREATE TABLE `assessment_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `group_id` bigint UNSIGNED DEFAULT NULL,
  `assessment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `question_number` int NOT NULL DEFAULT '0',
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer_options` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `extra_schema` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ;

--
-- Dumping data for table `assessment_questions`
--

INSERT INTO `assessment_questions` (`id`, `group_id`, `assessment_type`, `section`, `question_code`, `question_number`, `question_text`, `answer_type`, `answer_options`, `extra_schema`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_temperament_alertness', 101, 'State & Temperamen — Kesiapan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(2, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_temperament_cooperative', 102, 'State & Temperamen — Kooperatif', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(3, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_temperament_shyness', 103, 'State & Temperamen — Pemalu (Shyness)', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(4, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_temperament_easily_offended', 104, 'State & Temperamen — Mudah Tersinggung', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(5, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_temperament_happiness', 105, 'State & Temperamen — Happiness', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(6, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_temperament_physically_fit', 106, 'State & Temperamen — Physically Fit', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(7, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_behavior_active', 201, 'Perilaku — Aktif/Normal', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(8, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_behavior_aggressive', 202, 'Perilaku — Agresif/Melawan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(9, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_behavior_tantrum', 203, 'Perilaku — Temper Tantrum', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(10, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_behavior_self_aware', 204, 'Perilaku — Mengasingkan Diri', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(11, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_behavior_impulsive', 205, 'Perilaku — Impulsif', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(12, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_identity_nickname', 301, 'Identitas — Nama Panggilan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(13, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_identity_full_name', 302, 'Identitas — Nama Lengkap', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(14, 1, 'okupasi', 'bodily_self_sense', 'OT_bodily_self_sense_identity_age', 303, 'Identitas — Usia', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(15, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_right_left_shoe_wear', 101, 'Diskriminasi kanan/kiri — Memakai sepatu / sandal', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(16, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_right_left_identify_left_right', 102, 'Diskriminasi kanan/kiri — Identifikasi kanan/kiri', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(17, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_spatial_position_up_down', 201, 'Posisi dalam ruang — Atas-bawah', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(18, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_spatial_position_out_in', 202, 'Posisi dalam ruang — Luar-dalam', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(19, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_spatial_position_front_back', 203, 'Posisi dalam ruang — Depan-belakang', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(20, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_spatial_position_middle_side', 204, 'Posisi dalam ruang — Tengah', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(21, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_spatial_position_edge_side', 205, 'Posisi dalam ruang — Pinggir', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(22, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_gross_motor_walk_forward', 301, 'Motorik Kasar — Berjalan ke depan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(23, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_gross_motor_walk_backward', 302, 'Motorik Kasar — Berjalan ke belakang', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(24, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_gross_motor_walk_sideways', 303, 'Motorik Kasar — Berjalan menyamping', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(25, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_gross_motor_tiptoe', 304, 'Motorik Kasar — Meniti', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(26, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_gross_motor_running', 305, 'Motorik Kasar — Berlari', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(27, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_gross_motor_stand_one_foot', 306, 'Motorik Kasar — Berdiri satu kaki', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(28, 2, 'okupasi', 'balance_coordination', 'OT_balance_coordination_gross_motor_jump_one_foot', 307, 'Motorik Kasar — Melompat satu kaki', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(29, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_attention_follow_commands', 101, 'Konsentrasi & Atensi — Mengikuti perintah', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(30, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_attention_two_commands', 102, 'Konsentrasi & Atensi — 2 perintah', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(31, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_attention_three_commands', 103, 'Konsentrasi & Atensi — 3 perintah', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(32, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_attention_four_commands', 104, 'Konsentrasi & Atensi — 4 perintah', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(33, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_attention_visual_search', 105, 'Konsentrasi & Atensi — Mencari kelonggaran gambar', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(34, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_problem_solving_puzzle', 201, 'Problem Solving — Puzzle matching 4,8,12', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(35, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_problem_solving_story_question', 202, 'Problem Solving — Soal cerita', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(36, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_size_comprehension_big_small', 301, 'Pemahaman ukuran — Besar/kecil', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(37, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_size_comprehension_tall_short', 302, 'Pemahaman ukuran — Tinggi/rendah', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(38, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_size_comprehension_many_few', 303, 'Pemahaman ukuran — Banyak/sedikit', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(39, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_size_comprehension_long_short', 304, 'Pemahaman ukuran — Panjang/pendek', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(40, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_number_recognition_count_forward', 401, 'Pengenalan angka — Menghitung maju', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(41, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_number_recognition_count_backward', 402, 'Pengenalan angka — Menghitung mundur', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(42, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_number_recognition_symbol', 403, 'Pengenalan angka — Pengenalan simbol', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(43, 3, 'okupasi', 'concentration_problem_solving', 'OT_concentration_problem_solving_number_recognition_concept', 404, 'Pengenalan angka — Pengenalan konsep', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(44, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_letter_recognition_show_letter', 101, 'Pengenalan huruf — Menunjukan huruf', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(45, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_letter_recognition_reading', 102, 'Pengenalan huruf — Membaca', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(46, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_letter_recognition_writing', 103, 'Pengenalan huruf — Menulis', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(47, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_letter_recognition_write_name_form', 104, 'Pengenalan huruf — Menulis nama di blangko', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(48, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_letter_recognition_write_alphabet', 105, 'Pengenalan huruf — Menuli abjad dengan urut', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(49, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_color_comprehension_pointing', 201, 'Pemahaman warna — Menunjuk', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(50, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_color_comprehension_differentiating', 202, 'Pemahaman warna — Membedakan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(51, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_body_awareness_face_parts', 301, 'Body awareness — Menyebutkan bagian wajah', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(52, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_body_awareness_body_parts', 302, 'Body awareness — Anggota tubuh', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(53, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_time_orientation_day_night', 401, 'Orientasi waktu — Siang / malam', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(54, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_time_orientation_know_day', 402, 'Orientasi waktu — Mengetahui hari', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(55, 4, 'okupasi', 'concepts_orientation', 'OT_concepts_orientation_time_orientation_date_month_year', 403, 'Orientasi waktu — Tanggal / bulan / tahun', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(56, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_bilateral_skill_stringing_beads', 101, 'Bilateral skill — Meronce manik-manik', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(57, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_bilateral_skill_flipping_pages', 102, 'Bilateral skill — Membalik halaman buku', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(58, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_bilateral_skill_sewing', 103, 'Bilateral skill — Menjahit', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(59, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_cutting_no_line', 201, 'Menggunting — Tanpa pola', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(60, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_cutting_straight_line', 202, 'Menggunting — Garis lurus', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(61, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_cutting_zigzag_line', 203, 'Menggunting — Zig-zag', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(62, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_cutting_wave_line', 204, 'Menggunting — Ombak', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(63, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_cutting_box_shape', 205, 'Menggunting — Kotak', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(64, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_memory_recall_objects', 301, 'Memori — Mengingat 3–5 objek', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(65, 5, 'okupasi', 'motoric_planning', 'OT_motoric_planning_memory_singing', 302, 'Memori — Menyanyi', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(66, 6, 'okupasi', 'final_report', 'OT_final_report_NOTES', 1, 'Catatan', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(67, 6, 'okupasi', 'final_report', 'OT_final_report_ASSESSMENT_RESULT', 2, 'Hasil Assessment', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(68, 6, 'okupasi', 'final_report', 'OT_final_report_RECOMMENDATION', 3, 'Rekomendasi Terapi', 'checkbox', '\"[\\\"paedagog\\\",\\\"okupasi\\\",\\\"wicara\\\",\\\"fisio\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(69, 7, 'paedagog', 'reading', 'PDG_READING_1', 1, 'Anak mampu mengenal huruf', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(70, 7, 'paedagog', 'reading', 'PDG_READING_2', 2, 'Anak mampu mengenal simbol huruf', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(71, 7, 'paedagog', 'reading', 'PDG_READING_3', 3, 'Anak mampu menyebutkan huruf A-Z secara berurutan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(72, 7, 'paedagog', 'reading', 'PDG_READING_4', 4, 'Anak mampu mengucapkan huruf yang tepat dan benar', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(73, 7, 'paedagog', 'reading', 'PDG_READING_5', 5, 'Anak mampu membaca bunyi vokal (a,i,u,e,o)', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(74, 7, 'paedagog', 'reading', 'PDG_READING_6', 6, 'Anak mampu membaca bunyi konsonan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(75, 7, 'paedagog', 'reading', 'PDG_READING_7', 7, 'Anak mampu membaca kata yang diminta', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(76, 7, 'paedagog', 'reading', 'PDG_READING_8', 8, 'Anak mampu membaca kalimat', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(77, 7, 'paedagog', 'reading', 'PDG_READING_9', 9, 'Anak mampu membaca sepintas/cepat', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(78, 7, 'paedagog', 'reading', 'PDG_READING_10', 10, 'Anak mampu membaca isi bacaan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(79, 8, 'paedagog', 'writing', 'PDG_WRITING_1', 1, 'Anak mampu memegang alat tulis', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(80, 8, 'paedagog', 'writing', 'PDG_WRITING_2', 2, 'Anak mampu menulis garis lurus keatas kebawah', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(81, 8, 'paedagog', 'writing', 'PDG_WRITING_3', 3, 'Anak mampu menulis garis lurus kekanan kekiri', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(82, 8, 'paedagog', 'writing', 'PDG_WRITING_4', 4, 'Anak mampu menulis garis melingkar', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(83, 8, 'paedagog', 'writing', 'PDG_WRITING_5', 5, 'Anak mampu menulis huruf dengan lurus', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(84, 8, 'paedagog', 'writing', 'PDG_WRITING_6', 6, 'Anak mampu menyalin huruf', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(85, 8, 'paedagog', 'writing', 'PDG_WRITING_7', 7, 'Anak mampu menulis namanya sendiri', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(86, 8, 'paedagog', 'writing', 'PDG_WRITING_8', 8, 'Anak mampu mengenal dan menulis kata atau kalimat yang diminta', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(87, 8, 'paedagog', 'writing', 'PDG_WRITING_9', 9, 'Anak mampu mengenal dan menulis huruf besar atau huruf kecil alfabet', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(88, 8, 'paedagog', 'writing', 'PDG_WRITING_10', 10, 'Anak mampu membedakan huruf dengan kesamaan bentuk (b,d,p,q atau m,n,w)', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(89, 8, 'paedagog', 'writing', 'PDG_WRITING_11', 11, 'Anak mampu membuat kalimat sederhana', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(90, 8, 'paedagog', 'writing', 'PDG_WRITING_12', 12, 'Anak mampu menulis cerita berdasarkan gambar', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(91, 9, 'paedagog', 'counting', 'PDG_COUNTING_1', 1, 'Anak mampu mengenal bentuk angka 1-10 dengan urut', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(92, 9, 'paedagog', 'counting', 'PDG_COUNTING_2', 2, 'Anak mampu menghitung benda konkret (1-50)', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(93, 9, 'paedagog', 'counting', 'PDG_COUNTING_3', 3, 'Anak mampu memahami perbandingan banyak sedikit angka', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(94, 9, 'paedagog', 'counting', 'PDG_COUNTING_4', 4, 'Anak mampu mengenal tanda operasi hitung bilangan (+,-,x,:)', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(95, 9, 'paedagog', 'counting', 'PDG_COUNTING_5', 5, 'Anak mampu mengoperasikan penjumlahan dan pengurangan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(96, 9, 'paedagog', 'counting', 'PDG_COUNTING_6', 6, 'Anak mampu mengoperasikan perkalian dan pembagian', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(97, 9, 'paedagog', 'counting', 'PDG_COUNTING_7', 7, 'Anak mampu mengoperasikan alat bantu hitung', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(98, 10, 'paedagog', 'readiness', 'PDG_READINESS_1', 1, 'Anak mampu mengikuti instruksi (konsentrasi)', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(99, 10, 'paedagog', 'readiness', 'PDG_READINESS_2', 2, 'Anak mampu duduk dalam waktu yang ditentukan untuk mengikuti instruksi guru', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(100, 10, 'paedagog', 'readiness', 'PDG_READINESS_3', 3, 'Anak bergerak aktif tidak dapat duduk tenang', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(101, 10, 'paedagog', 'readiness', 'PDG_READINESS_4', 4, 'Anak menunjukkan inisiasi (tidak pasif) dalam belajar', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(102, 10, 'paedagog', 'readiness', 'PDG_READINESS_5', 5, 'Anak bersikap kooperatif', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(103, 10, 'paedagog', 'readiness', 'PDG_READINESS_6', 6, 'Anak menunjukkan sikap antusias (mood) dalam belajar', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(104, 10, 'paedagog', 'readiness', 'PDG_READINESS_7', 7, 'Anak mampu menyelesaikan tugas sampai tuntas', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(105, 11, 'paedagog', 'general', 'PDG_GENERAL_1', 1, 'Anak mengetahui identitas diri', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(106, 11, 'paedagog', 'general', 'PDG_GENERAL_2', 2, 'Anak menunjukkan anggota tubuh', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(107, 11, 'paedagog', 'general', 'PDG_GENERAL_3', 3, 'Anak memiliki pemahaman perbedaan rasa pada indera pengecapan', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(108, 11, 'paedagog', 'general', 'PDG_GENERAL_4', 4, 'Anak mampu mengidentifikasikan warna', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(109, 11, 'paedagog', 'general', 'PDG_GENERAL_5', 5, 'Anak mampu memahami besar kecil, berat ringan, luas sempit', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(110, 11, 'paedagog', 'general', 'PDG_GENERAL_6', 6, 'Anak mampu memahami orientasi waktu (pagi, siang, malam, jam, hari, bulan, tahun)', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(111, 11, 'paedagog', 'general', 'PDG_GENERAL_7', 7, 'Anak mampu mengekspresikan wajah (emosi)', 'score_with_note', '\"[0,1,2,3]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"score\\\",\\\"label\\\":\\\"Penilaian\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(112, 11, 'paedagog', 'general', 'PDG_GENERAL_8', 8, 'Kesimpulan Assessment', 'text', NULL, NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(113, 12, 'wicara_oral', 'face_eval', 'WO_FACE_EVAL_1', 1, 'Kesimetrisan', 'select_with_note', '\"[\\\"normal\\\",\\\"turun pada sebelah kanan\\\",\\\"turun pada sebelah kiri\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(114, 12, 'wicara_oral', 'face_eval', 'WO_FACE_EVAL_2', 2, 'Gerakan abnormal', 'select_with_note', '\"[\\\"none\\\",\\\"menyeringai\\\",\\\"kedutan\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(115, 12, 'wicara_oral', 'face_eval', 'WO_FACE_EVAL_3', 3, 'Pernapasan mulut', 'select_with_note', '\"[\\\"ya\\\",\\\"tidak\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(116, 12, 'wicara_oral', 'face_eval', 'WO_FACE_EVAL_4', 4, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(117, 13, 'wicara_oral', 'jaw_eval', 'WO_JAW_EVAL_1', 1, 'Range of motion', 'select_with_note', '\"[\\\"normal\\\",\\\"kurang\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(118, 13, 'wicara_oral', 'jaw_eval', 'WO_JAW_EVAL_2', 2, 'Kesimetrisan', 'select_with_note', '\"[\\\"normal\\\",\\\"miring ke kanan\\\",\\\"miring ke kiri\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(119, 13, 'wicara_oral', 'jaw_eval', 'WO_JAW_EVAL_3', 3, 'Movement', 'select_with_note', '\"[\\\"normal\\\",\\\"tersentak-sentak\\\",\\\"groping\\\",\\\"lambat\\\",\\\"tidak simetris\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(120, 13, 'wicara_oral', 'jaw_eval', 'WO_JAW_EVAL_4', 4, 'TMJ noises', 'select_with_note', '\"[\\\"absent\\\",\\\"kertak gigi\\\",\\\"bermunculan\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(121, 13, 'wicara_oral', 'jaw_eval', 'WO_JAW_EVAL_5', 5, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(122, 14, 'wicara_oral', 'dental_eval', 'WO_DENTAL_EVAL_1', 1, 'Oklusi geraham', 'select_with_note', '\"[\\\"normal\\\",\\\"neutrocclusion (Class I)\\\",\\\"distroclusion (Class II)\\\",\\\"mesioclusion (Class III)\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(123, 14, 'wicara_oral', 'dental_eval', 'WO_DENTAL_EVAL_2', 2, 'Oklusi taring', 'select_with_note', '\"[\\\"normal\\\",\\\"overbite\\\",\\\"underbite\\\",\\\"crossbite\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(124, 14, 'wicara_oral', 'dental_eval', 'WO_DENTAL_EVAL_3', 3, 'Gigi', 'select_with_note', '\"[\\\"semua ada\\\",\\\"gigi palsu\\\",\\\"gigi yang hilang (spesifik)\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04');
INSERT INTO `assessment_questions` (`id`, `group_id`, `assessment_type`, `section`, `question_code`, `question_number`, `question_text`, `answer_type`, `answer_options`, `extra_schema`, `is_active`, `created_at`, `updated_at`) VALUES
(125, 14, 'wicara_oral', 'dental_eval', 'WO_DENTAL_EVAL_4', 4, 'Susunan gigi', 'select_with_note', '\"[\\\"normal\\\",\\\"bertumpuk\\\",\\\"beruang\\\",\\\"tidak beraturan\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(126, 14, 'wicara_oral', 'dental_eval', 'WO_DENTAL_EVAL_5', 5, 'Kebersihan', 'select_with_note', '\"[\\\"bersih\\\",\\\"kotor\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(127, 14, 'wicara_oral', 'dental_eval', 'WO_DENTAL_EVAL_6', 6, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(128, 15, 'wicara_oral', 'lip_eval', 'WO_LIP_EVAL_1', 1, 'Range of motion (memonyongkan bibir)', 'select_with_note', '\"[\\\"normal\\\",\\\"kurang\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(129, 15, 'wicara_oral', 'lip_eval', 'WO_LIP_EVAL_2', 2, 'Kesimetrisan (memonyongkan bibir)', 'select_with_note', '\"[\\\"normal\\\",\\\"turun pada kedua sisi\\\",\\\"turun pada sebelah kanan\\\",\\\"turun pada sebelah kiri\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(130, 15, 'wicara_oral', 'lip_eval', 'WO_LIP_EVAL_3', 3, 'Kekuatan (melawan tongue spatel)', 'select_with_note', '\"[\\\"normal\\\",\\\"lemah\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(131, 15, 'wicara_oral', 'lip_eval', 'WO_LIP_EVAL_4', 4, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(132, 15, 'wicara_oral', 'lip_eval', 'WO_LIP_EVAL_5', 5, 'Range of motion', 'select_with_note', '\"[\\\"normal\\\",\\\"kurang\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(133, 15, 'wicara_oral', 'lip_eval', 'WO_LIP_EVAL_6', 6, 'Kesimetrisan', 'select_with_note', '\"[\\\"normal\\\",\\\"turun pada kedua sisi\\\",\\\"turun pada sebelah kanan\\\",\\\"turun pada sebelah kiri\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(134, 15, 'wicara_oral', 'lip_eval', 'WO_LIP_EVAL_7', 7, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(135, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_1', 1, 'Warna lidah', 'select_with_note', '\"[\\\"normal\\\",\\\"abnormal (spesifik)\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(136, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_2', 2, 'Gerakan abnormal', 'select_with_note', '\"[\\\"tidak ada\\\",\\\"tersentak-sentak\\\",\\\"kedutan\\\",\\\"menggeliat\\\",\\\"faskulasi\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(137, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_3', 3, 'Size', 'select_with_note', '\"[\\\"normal\\\",\\\"kecil\\\",\\\"besar\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(138, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_4', 4, 'Frenum', 'select_with_note', '\"[\\\"normal\\\",\\\"pendek\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(139, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_5', 5, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(140, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_6', 6, 'Kesimetrisan', 'select_with_note', '\"[\\\"normal\\\",\\\"miring ke kanan\\\",\\\"miring ke kiri\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(141, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_7', 7, 'Range of motion', 'select_with_note', '\"[\\\"normal\\\",\\\"kurang\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(142, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_8', 8, 'Kecepatan', 'select_with_note', '\"[\\\"normal\\\",\\\"lambat\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(143, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_9', 9, 'Kekuatan (melawan tongue spatel)', 'select_with_note', '\"[\\\"normal\\\",\\\"lemah\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(144, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_10', 10, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(145, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_11', 11, 'Kesimetrisan', 'select_with_note', '\"[\\\"normal\\\",\\\"miring ke kanan\\\",\\\"miring ke kiri\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(146, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_12', 12, 'Range of motion', 'select_with_note', '\"[\\\"normal\\\",\\\"kurang\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(147, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_13', 13, 'Kecepatan', 'select_with_note', '\"[\\\"normal\\\",\\\"lambat\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(148, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_14', 14, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(149, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_15', 15, 'Range of motion', 'select_with_note', '\"[\\\"normal\\\",\\\"kurang\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(150, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_16', 16, 'Kecepatan', 'select_with_note', '\"[\\\"normal\\\",\\\"lemah\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(151, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_17', 17, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(152, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_18', 18, 'Range of motion', 'select_with_note', '\"[\\\"normal\\\",\\\"kurang\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(153, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_19', 19, 'Kecepatan', 'select_with_note', '\"[\\\"normal\\\",\\\"lemah\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(154, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_20', 20, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(155, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_21', 21, 'Gerakan', 'select_with_note', '\"[\\\"normal\\\",\\\"lambat\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(156, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_22', 22, 'Range of motion', 'select_with_note', '\"[\\\"normal\\\",\\\"kurang\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(157, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_23', 23, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(158, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_24', 24, 'Gerakan', 'select_with_note', '\"[\\\"normal\\\",\\\"lambat\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(159, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_25', 25, 'Range of motion', 'select_with_note', '\"[\\\"normal\\\",\\\"kurang\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(160, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_26', 26, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(161, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_27', 27, 'Pergerakan', 'select_with_note', '\"[\\\"normal\\\",\\\"lemah\\\",\\\"menurun bertahap\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(162, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_28', 28, 'Range of motion', 'select_with_note', '\"[\\\"normal\\\",\\\"berkurang pada sisi kiri\\\",\\\"berkurang pada sisi kanan\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(163, 16, 'wicara_oral', 'tongue_eval', 'WO_TONGUE_EVAL_29', 29, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(164, 17, 'wicara_oral', 'pharynx_eval', 'WO_PHARYNX_EVAL_1', 1, 'Warna', 'select_with_note', '\"[\\\"normal\\\",\\\"abnormal\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(165, 17, 'wicara_oral', 'pharynx_eval', 'WO_PHARYNX_EVAL_2', 2, 'Tonsil', 'select_with_note', '\"[\\\"tidak ada\\\",\\\"normal\\\",\\\"membesar\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(166, 17, 'wicara_oral', 'pharynx_eval', 'WO_PHARYNX_EVAL_3', 3, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(167, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_1', 1, 'Warna', 'select_with_note', '\"[\\\"normal\\\",\\\"abnormal\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(168, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_2', 2, 'Rugae', 'select_with_note', '\"[\\\"ada\\\",\\\"tidak ada\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(169, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_3', 3, 'Tinggi langit-langit', 'select_with_note', '\"[\\\"normal\\\",\\\"tinggi\\\",\\\"rendah\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(170, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_4', 4, 'Lebar langit-langit', 'select_with_note', '\"[\\\"normal\\\",\\\"sempit\\\",\\\"lebar\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(171, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_5', 5, 'Growths', 'select_with_note', '\"[\\\"ada\\\",\\\"tidak ada\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(172, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_6', 6, 'Fistula', 'select_with_note', '\"[\\\"ada\\\",\\\"tidak ada\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(173, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_7', 7, 'Kesimetrisan saat istirahat', 'select_with_note', '\"[\\\"normal\\\",\\\"kanan lebih rendah\\\",\\\"kiri lebih rendah\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(174, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_8', 8, 'Tinggi langit-langit lunak', 'select_with_note', '\"[\\\"normal\\\",\\\"tidak ada\\\",\\\"hiperensitif\\\",\\\"hiposensitif\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(175, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_9', 9, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(176, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_10', 10, 'Kesimetrisan gerakan', 'select_with_note', '\"[\\\"normal\\\",\\\"miring ke kanan\\\",\\\"miring ke kiri\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(177, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_11', 11, 'Gerakan posterior', 'select_with_note', '\"[\\\"ada\\\",\\\"tidak ada\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(178, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_12', 12, 'Uvula', 'select_with_note', '\"[\\\"normal\\\",\\\"bifid\\\",\\\"miring ke kanan\\\",\\\"miring ke kiri\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(179, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_13', 13, 'Nasalisasi', 'select_with_note', '\"[\\\"tidak ada\\\",\\\"hipernasal\\\"]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(180, 18, 'wicara_oral', 'palate_eval', 'WO_PALATE_EVAL_14', 14, 'Lain-lain', 'select_with_note', '\"[]\"', '\"{\\\"columns\\\":[{\\\"key\\\":\\\"value\\\",\\\"label\\\":\\\"Pilihan\\\",\\\"type\\\":\\\"select\\\"},{\\\"key\\\":\\\"note\\\",\\\"label\\\":\\\"Keterangan\\\",\\\"type\\\":\\\"text\\\"}]}\"', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(181, 19, 'wicara_bahasa', 'usia_0_6', 'WB_usia_0_6_1', 1, 'Mengulangi suara yang sama', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(182, 19, 'wicara_bahasa', 'usia_0_6', 'WB_usia_0_6_2', 2, 'Sering kali membuat suara \"koo\" dan \"gurgles\", serta suara-suara menyenangkan', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(183, 19, 'wicara_bahasa', 'usia_0_6', 'WB_usia_0_6_3', 3, 'Menggunakan tangisan yang berbeda-beda untuk mengutarakan kebutuhan yang berbeda-beda', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(184, 19, 'wicara_bahasa', 'usia_0_6', 'WB_usia_0_6_4', 4, 'Tersenyum bila diajak berbicara', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(185, 19, 'wicara_bahasa', 'usia_0_6', 'WB_usia_0_6_5', 5, 'Mengenali suara manusia', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(186, 19, 'wicara_bahasa', 'usia_0_6', 'WB_usia_0_6_6', 6, 'Melokasikan suara dengan cara menoleh', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(187, 19, 'wicara_bahasa', 'usia_0_6', 'WB_usia_0_6_7', 7, 'Mendengarkan pembicaraan', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(188, 19, 'wicara_bahasa', 'usia_0_6', 'WB_usia_0_6_8', 8, 'Menggunakan konsonan /p/, /b/, /m/ ketika mengoceh', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(189, 19, 'wicara_bahasa', 'usia_0_6', 'WB_usia_0_6_9', 9, 'Menggunakan suara atau isyarat (gesture) untuk memberitahu keinginan', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(190, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_1', 1, 'Mengerti arti tidak panas dan panas', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(191, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_2', 2, 'Dapat memberi respon untuk permintaan yang sederhana', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(192, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_3', 3, 'Mengerti dan memberi respon pada namanya sendiri', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(193, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_4', 4, 'Mendengarkan dan meniru beberapa suara', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(194, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_5', 5, 'Mengenali kata untuk benda sehari-hari (misalnya susu, sepatu, cangkir, dll)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(195, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_6', 6, 'Mengoceh dengan menggunakan suara panjang dan pendek', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(196, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_7', 7, 'Menggunakan intonasi seperti lagu ketika mengoceh', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(197, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_8', 8, 'Menggunakan bermacam-macam suara ketika mengoceh', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(198, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_9', 9, 'Menirukan beberapa suara bicara orang dewasa dan intonasinya', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(199, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_10', 10, 'Menggunakan suara bicara selain tangisan untuk mendapatkan perhatian', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(200, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_11', 11, 'Mendengarkan ketika diajak berbicara', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(201, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_12', 12, 'Menggunakan suara yang mendekati suara yang didengar', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(202, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_13', 13, 'Mulai merubah ocehan ke bahasa bulan (jargon)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(203, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_14', 14, 'Mulai menggunakan bicara dengan tujuan', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(204, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_15', 15, 'Hanya menggunakan kata benda', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(205, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_16', 16, 'Memiliki pengucapan (ekspresif) kosa kata 1-3 kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(206, 20, 'wicara_bahasa', 'usia_7_12', 'WB_usia_7_12_17', 17, 'Mengerti perintah sederhana', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(207, 21, 'wicara_bahasa', 'usia_13_18', 'WB_usia_13_18_1', 1, 'Menggunakan intonasi yang mengikuti pola bicara orang dewasa', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(208, 21, 'wicara_bahasa', 'usia_13_18', 'WB_usia_13_18_2', 2, 'Menggunakan echolalia dan bahasa bulan (jargon)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(209, 21, 'wicara_bahasa', 'usia_13_18', 'WB_usia_13_18_3', 3, 'Tidak mengucapkan beberapa konsonan depan dan hampir seluruh konsonan akhir', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(210, 21, 'wicara_bahasa', 'usia_13_18', 'WB_usia_13_18_4', 4, 'Bicara hampir keseluruhannya tidak dapat dimengerti', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(211, 21, 'wicara_bahasa', 'usia_13_18', 'WB_usia_13_18_5', 5, 'Mengikuti perintah sederhana', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(212, 21, 'wicara_bahasa', 'usia_13_18', 'WB_usia_13_18_6', 6, 'Mengenali 1-3 bagian tubuh', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(213, 21, 'wicara_bahasa', 'usia_13_18', 'WB_usia_13_18_7', 7, 'Memiliki pengucapan (ekspresif) kosa kata 3-20 kata / lebih (kebanyakan kata benda)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(214, 21, 'wicara_bahasa', 'usia_13_18', 'WB_usia_13_18_8', 8, 'Memadukan vokalisasi dan isyarat', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(215, 21, 'wicara_bahasa', 'usia_13_18', 'WB_usia_13_18_9', 9, 'Membuat permintaan untuk hal-hal yang lebih diinginkan', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(216, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_1', 1, 'Lebih sering menggunakan kata daripada bahasa bulan (jargon)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(217, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_2', 2, 'Memiliki pengucapan (ekspresif) kosa kata 50-100 kata / lebih', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(218, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_3', 3, 'Memiliki pemahaman (reseptif) kosa kata 300 kata / lebih', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(219, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_4', 4, 'Mulai memadu kata benda dan kata kerja', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(220, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_5', 5, 'Mulai menggunakan kata ganti orang', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(221, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_6', 6, 'Kendala suara masih belum stabil', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(222, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_7', 7, 'Menggunakan intonasi yang benar ketika bertanya', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(223, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_8', 8, 'Bicara 25-50% dapat dimengerti orang lain', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(224, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_9', 9, 'Menjawab pertanyaan \'ini apa?\'', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(225, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_10', 10, 'Senang mendengarkan cerita', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(226, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_11', 11, 'Mengenali 5 bagian tubuh', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(227, 22, 'wicara_bahasa', 'usia_19_24', 'WB_usia_19_24_12', 12, 'Secara benar dapat menamakan beberapa benda sehari-hari', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(228, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_1', 1, 'Bicara 50-75% dapat dipahami orang lain', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(229, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_2', 2, 'Mengerti satu dan semua', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(230, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_3', 3, 'Mengucapkan keinginan untuk ke kamar mandi (sebelum, sedang, atau setelah kejadian)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(231, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_4', 4, 'Meminta benda dengan menamakannya', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(232, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_5', 5, 'Menunjuk kepada gambar di dalam buku bila diminta', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(233, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_6', 6, 'Mengenali beberapa bagian tubuh', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(234, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_7', 7, 'Mengenali perintah sederhana dan menjawab pertanyaan sederhana', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(235, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_8', 8, 'Senang mendengarkan cerita pendek, lagu dan sajak', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(236, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_9', 9, 'Menanyakan 1-2 kata pertanyaan', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(237, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_10', 10, 'Menggunakan 3-4 kata frase', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(238, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_11', 11, 'Menggunakan preposisi', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(239, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_12', 12, 'Menggunakan kata yang sama dalam konteks', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(240, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_13', 13, 'Menggunakan kata echolalia bila kesulitan berbicara', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(241, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_14', 14, 'Memiliki pengucapan (ekspresif) kosa kata 50-250 kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(242, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_15', 15, 'Memiliki pemahaman (reseptif) kosa kata 500-900 kata atau lebih', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(243, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_16', 16, 'Memperlihatkan kesalahan dalam pemakaian tata bahasa', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(244, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_17', 17, 'Mengerti hampir keseluruhannya yang dikatakan kepadanya', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(245, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_18', 18, 'Sering mengulang,terutama pemulaan \'saya\'/nama dan suku kata pertama', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(246, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_19', 19, 'Berbicara dengan suara yang keras', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(247, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_20', 20, 'Nada suara mulai meninggi', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(248, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_21', 21, 'Menunggu huruf hidup dengan baik', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(249, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_22', 22, 'Secara konsisten menggunakan konsonan awal (walaupun beberapa masih tidak dapat diucapkan dengan baik)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(250, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_23', 23, 'Sering menghilangkan konsonan tengah', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(251, 23, 'wicara_bahasa', 'usia_2_3', 'WB_usia_2_3_24', 24, 'Sering menghilangkan atau mengganti konsonan akhir', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(252, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_1', 1, 'Mengerti fungsi dari benda', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(253, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_2', 2, 'Mengerti perbedaan arti kata (besar-kecil, di atas-di dalam, berhenti-jalan)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(254, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_3', 3, 'Mengikuti perintah 2-3 bagian', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(255, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_4', 4, 'Bertanya dan menjawab pertanyaan sederhana (siapa, apa, di mana, kenapa)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(256, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_5', 5, 'Sering bertanya dan meminta jawaban yang terperinci', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(257, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_6', 6, 'Menggunakan analogi sederhana', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(258, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_7', 7, 'Menggunakan bahasa untuk mengekspresikan emosi', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(259, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_8', 8, 'Menggunakan 4-5 kata dalam kalimat', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(260, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_9', 9, 'Mengulang kalimat 6-13 suku kata secara benar', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(261, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_10', 10, 'Mengenali benda dengan nama', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(262, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_11', 11, 'Memanipulasi orang dewasa dan teman sebaya', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(263, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_12', 12, 'Kadang-kadang echolalia masih digunakan', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(264, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_13', 13, 'Lebih sering menggunakan kata benda dan kata kerja', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(265, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_14', 14, 'Sadar akan waktu yang telah lalu dan yang akan datang', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(266, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_15', 15, 'Memiliki pengucapan (ekspresif) kosa kata 800-1500 kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(267, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_16', 16, 'Memiliki pengucapan (reseptif) kosa kata 1200-2000 kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(268, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_17', 17, 'Kadang kala mengulang nama, terbata bata, kesulitan mengatur napas, dan meringis', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(269, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_18', 18, 'Berbisik', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(270, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_19', 19, 'Berbicara 80% dapat dipahami', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(271, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_20', 20, 'Walaupun masih banyak kesalahan, tata bahasa sudah membaik', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(272, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_21', 21, 'Dapat menceritakan dua kejadian secara urut', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(273, 24, 'wicara_bahasa', 'usia_3_4', 'WB_usia_3_4_22', 22, 'Dapat bercakap-cakap lebih lama', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(274, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_1', 1, 'Mengerti konsep jumlah sampai dengan 3', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(275, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_2', 2, 'Mengerti spatial konsep', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(276, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_3', 3, 'Mengenali 1-3 warna', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(277, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_4', 4, 'Memiliki pemahaman (reseptif) kosa kata 2800 kata atau lebih', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(278, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_5', 5, 'Menghitung sampai 10 secara rote', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(279, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_6', 6, 'Mendengarkan cerita pendek', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(280, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_7', 7, 'Menjawab pertanyaan tentang fungsi', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(281, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_8', 8, 'Menggunakan tata bahasa dalam kalimat yang benar', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(282, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_9', 9, 'Memiliki pemahaman (ekspresif) kosa kata 900-2000 kata atau lebih', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(283, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_10', 10, 'Menggunakan kalimat dengan 4-8 kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(284, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_11', 11, 'Menjawab pertanyaan 2 bagian', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(285, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_12', 12, 'Menanyakan arti kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(286, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_13', 13, 'Senang akan sajak,ritme dan suku kata tak berarti', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(287, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_14', 14, 'Menggunakan konsonan dengan 30% ketepatan', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(288, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_15', 15, 'Bicara biasanya dapat dimengerti oleh orang lain', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(289, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_16', 16, 'Dapat bercerita tentang pengalaman disekolah, dirumah teman, dll', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(290, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_17', 17, 'Dapat menceritakan kembali cerita panjang', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(291, 25, 'wicara_bahasa', 'usia_4_5', 'WB_usia_4_5_18', 18, 'Memperhatikan bila diceritakan dan menjawab pertanyaan sederhana tentang cerita tersebut', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(292, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_1', 1, 'Menamakan 6 warna dasar dan 3 bentuk dasar', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(293, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_2', 2, 'Mengikuti perintah yang diberikan dalam kelompok', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(294, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_3', 3, 'Mengikuti perintah 3 bagian', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(295, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_4', 4, 'Menanyakan pertanyaan \'bagaimana?\'', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(296, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_5', 5, 'Menjawab secara verbal pertanyaan \'hai\' dan \'apa kabar\'', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(297, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_6', 6, 'Menggunakan kata untuk sesuatu yang telah berlalu dan akan datang', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(298, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_7', 7, 'Menggunakan kata penghubung', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(299, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_8', 8, 'Memiliki pengucapan (ekspresif) kosa kata sekitar 13.000 kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(300, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_9', 9, 'Menamakan lawan kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(301, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_10', 10, 'Secara urut menamakan nama hari', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(302, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_11', 11, 'Menghitung sampai 30 secara mengurutkan (rote)', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(303, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_12', 12, 'Kosa kata meningkat terus', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(304, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_13', 13, 'Panjang kata dalam kalimat menurun hingga 4-6 kata dalam kalimat', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(305, 26, 'wicara_bahasa', 'usia_5_6', 'WB_usia_5_6_14', 14, 'Terkadang mengembalikan suara-suara', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(306, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_1', 1, 'Menamakan beberapa huruf,angka dan mata uang', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(307, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_2', 2, 'Mengurutkan angka dan dapat mengucapkan abjad', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(308, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_3', 3, 'Mengerti kanan dan kiri', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(309, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_4', 4, 'Menggunakan makin banyak lagi kata-kata yang lebih kompleks untuk menjelaskan sesuatu dan mampu mengadakan percakapan', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(310, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_5', 5, 'Memiliki pemahaman kosa kata kurang lebih 20.000 kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(311, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_6', 6, 'Menggunakan panjang kalimat sampai dengan 6 kata', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(312, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_7', 7, 'Mengerti hampir keseluruhan konsep tentang waktu', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(313, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_8', 8, 'Dapat menghitung sampai dengan 100 secara rote', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(314, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_9', 9, 'Menggunakan hampir seluruh aturan untuk perubahan kata dengan benar', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05');
INSERT INTO `assessment_questions` (`id`, `group_id`, `assessment_type`, `section`, `question_code`, `question_number`, `question_text`, `answer_type`, `answer_options`, `extra_schema`, `is_active`, `created_at`, `updated_at`) VALUES
(315, 27, 'wicara_bahasa', 'usia_6_7', 'WB_usia_6_7_10', 10, 'Menggunakan kalimat pasif dengan benar', 'boolean', '\"[\\\"yes\\\",\\\"no\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(316, 28, 'fisio', 'pemeriksaan_umum', 'FS_pemeriksaan_umum_1', 1, 'Cara Datang', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(317, 28, 'fisio', 'pemeriksaan_umum', 'FS_pemeriksaan_umum_2', 2, 'Kesadaran', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(318, 28, 'fisio', 'pemeriksaan_umum', 'FS_pemeriksaan_umum_3', 3, 'Kooperatif / Tidak Kooperatif', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(319, 28, 'fisio', 'pemeriksaan_umum', 'FS_pemeriksaan_umum_4', 4, 'Tensi', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(320, 28, 'fisio', 'pemeriksaan_umum', 'FS_pemeriksaan_umum_5', 5, 'Nadi', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(321, 28, 'fisio', 'pemeriksaan_umum', 'FS_pemeriksaan_umum_6', 6, 'RR', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(322, 28, 'fisio', 'pemeriksaan_umum', 'FS_pemeriksaan_umum_7', 7, 'Status Gizi', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(323, 28, 'fisio', 'pemeriksaan_umum', 'FS_pemeriksaan_umum_8', 8, 'Suhu', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(324, 28, 'fisio', 'pemeriksaan_umum', 'FS_pemeriksaan_umum_9', 9, 'Lingkar Kepala', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(325, 29, 'fisio', 'anamnesis_sistem', 'FS_anamnesis_sistem_1', 1, 'Kepala & Leher', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(326, 29, 'fisio', 'anamnesis_sistem', 'FS_anamnesis_sistem_2', 2, 'Kardiovaskuler', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(327, 29, 'fisio', 'anamnesis_sistem', 'FS_anamnesis_sistem_3', 3, 'Respirasi', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(328, 29, 'fisio', 'anamnesis_sistem', 'FS_anamnesis_sistem_4', 4, 'Gastrointestinalis', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(329, 29, 'fisio', 'anamnesis_sistem', 'FS_anamnesis_sistem_5', 5, 'Urogenital', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(330, 29, 'fisio', 'anamnesis_sistem', 'FS_anamnesis_sistem_6', 6, 'Muskuloskeletal', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(331, 29, 'fisio', 'anamnesis_sistem', 'FS_anamnesis_sistem_7', 7, 'Nervorum', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(332, 29, 'fisio', 'anamnesis_sistem', 'FS_anamnesis_sistem_8', 8, 'Sensoris', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(333, 29, 'fisio', 'anamnesis_sistem', 'FS_anamnesis_sistem_9', 9, 'Motorik (Kasar, Halus)', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(334, 30, 'fisio', 'pemeriksaan_sensoris', 'FS_pemeriksaan_sensoris_1', 1, 'Penglihatan (Visual)', 'checkbox', '\"[\\\"Hypersensitif\\\",\\\"Hyposensitif\\\",\\\"Seeking\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(335, 30, 'fisio', 'pemeriksaan_sensoris', 'FS_pemeriksaan_sensoris_2', 2, 'Pendengaran (Auditory)', 'checkbox', '\"[\\\"Hypersensitif\\\",\\\"Hyposensitif\\\",\\\"Seeking\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(336, 30, 'fisio', 'pemeriksaan_sensoris', 'FS_pemeriksaan_sensoris_3', 3, 'Penciuman (Olfactory)', 'checkbox', '\"[\\\"Hypersensitif\\\",\\\"Hyposensitif\\\",\\\"Seeking\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(337, 30, 'fisio', 'pemeriksaan_sensoris', 'FS_pemeriksaan_sensoris_4', 4, 'Pengecapan (Gustatory)', 'checkbox', '\"[\\\"Hypersensitif\\\",\\\"Hyposensitif\\\",\\\"Seeking\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(338, 30, 'fisio', 'pemeriksaan_sensoris', 'FS_pemeriksaan_sensoris_5', 5, 'Peraba / Kulit (Tactile)', 'checkbox', '\"[\\\"Hypersensitif\\\",\\\"Hyposensitif\\\",\\\"Seeking\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(339, 30, 'fisio', 'pemeriksaan_sensoris', 'FS_pemeriksaan_sensoris_6', 6, 'Otot dan Sendi (Proprioseptive)', 'checkbox', '\"[\\\"Hypersensitif\\\",\\\"Hyposensitif\\\",\\\"Seeking\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(340, 30, 'fisio', 'pemeriksaan_sensoris', 'FS_pemeriksaan_sensoris_7', 7, 'Keseimbangan (Vestibular)', 'checkbox', '\"[\\\"Hypersensitif\\\",\\\"Hyposensitif\\\",\\\"Seeking\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(341, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_1', 1, 'Moro', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(342, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_2', 2, 'Galant', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(343, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_3', 3, 'STNR', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(344, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_4', 4, 'Rooting', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(345, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_5', 5, 'Plantar Graps', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(346, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_6', 6, 'Babinsky', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(347, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_7', 7, 'Blinking', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(348, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_8', 8, 'ATNR', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(349, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_9', 9, 'Sucking', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(350, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_10', 10, 'Palmar Graps', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(351, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_11', 11, 'Fleksor Withdrawl', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(352, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_12', 12, 'Righting', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(353, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_13', 13, 'Automatic Gait Reflek', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(354, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_14', 14, 'Landau', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(355, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_15', 15, 'Parachute', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(356, 31, 'fisio', 'pemeriksaan_refleks_primitif', 'FS_pemeriksaan_refleks_primitif_16', 16, 'Protective Refleks', 'radio_with_text', '\"[\\\"Primitif\\\",\\\"Fungsional\\\",\\\"Patologis\\\",\\\"Integrasi\\\",\\\"Belum Sinkron\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"Keterangan \\\\\\/ catatan tambahan...\\\",\\\"text_required\\\":false}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(357, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_telentang_head', 1, 'Head', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(358, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_telentang_shoulder', 2, 'Shoulder', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(359, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_telentang_elbow', 3, 'Elbow', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(360, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_telentang_wrist', 4, 'Wrist', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(361, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_telentang_finger', 5, 'Finger', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(362, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_telentang_trunk', 6, 'Trunk', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(363, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_telentang_hip', 7, 'Hip', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(364, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_telentang_knee', 8, 'Knee', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(365, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_telentang_ankle', 9, 'Ankle', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(366, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_rolling_handling', 1, 'Handling pada', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(367, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_rolling_via', 2, 'Berguling via', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(368, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_rolling_trunk', 3, 'Rotasi trunk', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(369, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_prone_headlifting', 1, 'Head lifting', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(370, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_prone_headcontrol', 2, 'Head control', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(371, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_prone_forearm', 3, 'Forearm support', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(372, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_prone_hand', 4, 'Hand support', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(373, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_prone_hip', 5, 'Hip', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(374, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_prone_knee', 6, 'Knee', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(375, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_prone_ankle', 7, 'Ankle', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(376, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_sitting_headlifting', 1, 'Head lifting', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(377, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_sitting_headcontrol', 2, 'Head control', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(378, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_sitting_headsupport', 3, 'Head support', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(379, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_sitting_trunk', 4, 'Trunk control', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(380, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_sitting_balance', 5, 'Sitting balance', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(381, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_sitting_protective', 6, 'Protective reaction', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(382, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_sitting_posisi', 7, 'Posisi duduk', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(383, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_sitting_weight', 8, 'Weight bearing', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(384, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_standing_headlifting', 1, 'Head lifting', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(385, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_standing_headcontrol', 2, 'Head control', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(386, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_standing_trunk', 3, 'Trunk control', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(387, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_standing_hip', 4, 'Hip', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(388, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_standing_knee', 5, 'Knee', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(389, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_standing_ankle', 6, 'Ankle', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(390, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_standing_tumpuan', 7, 'Tumpuan', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(391, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_standing_postural', 8, 'Postural', 'radio_with_text', '\"[\\\"Good posture\\\",\\\"Bad posture\\\"]\"', '\"{\\\"text_placeholder\\\":\\\"keterangan\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(392, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_walk_pola', 1, 'Pola jalan', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(393, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_walk_balance', 2, 'Keseimbangan', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(394, 32, 'fisio', 'gross_motor_pola_gerak', 'FS_gross_motor_pola_gerak_gm_walk_knee', 3, 'Tipe lutut', 'radio', '\"[\\\"Genu valgum (x)\\\",\\\"Genu varum (o)\\\",\\\"Genu recuvartum (hiperekstensi lutut)\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(395, 33, 'fisio', 'test_joint_laxity', 'FS_test_joint_laxity_1', 1, 'Elbow', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(396, 33, 'fisio', 'test_joint_laxity', 'FS_test_joint_laxity_2', 2, 'Wrist', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(397, 33, 'fisio', 'test_joint_laxity', 'FS_test_joint_laxity_3', 3, 'Hip', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(398, 33, 'fisio', 'test_joint_laxity', 'FS_test_joint_laxity_4', 4, 'Knee', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(399, 33, 'fisio', 'test_joint_laxity', 'FS_test_joint_laxity_5', 5, 'Ankle', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(400, 34, 'fisio', 'pemeriksaan_spastisitas', 'FS_pemeriksaan_spastisitas_1', 1, 'Kepala & Leher', 'radio', '\"[\\\"0\\\",\\\"1\\\",\\\"2\\\",\\\"3\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(401, 34, 'fisio', 'pemeriksaan_spastisitas', 'FS_pemeriksaan_spastisitas_2', 2, 'Trunk (Leher, Punggung, Pinggang)', 'radio', '\"[\\\"0\\\",\\\"1\\\",\\\"2\\\",\\\"3\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(402, 34, 'fisio', 'pemeriksaan_spastisitas', 'FS_pemeriksaan_spastisitas_3', 3, 'AGA Dex', 'radio', '\"[\\\"0\\\",\\\"1\\\",\\\"2\\\",\\\"3\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(403, 34, 'fisio', 'pemeriksaan_spastisitas', 'FS_pemeriksaan_spastisitas_4', 4, 'AGA Sin', 'radio', '\"[\\\"0\\\",\\\"1\\\",\\\"2\\\",\\\"3\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(404, 34, 'fisio', 'pemeriksaan_spastisitas', 'FS_pemeriksaan_spastisitas_5', 5, 'AGB Dex', 'radio', '\"[\\\"0\\\",\\\"1\\\",\\\"2\\\",\\\"3\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(405, 34, 'fisio', 'pemeriksaan_spastisitas', 'FS_pemeriksaan_spastisitas_6', 6, 'AGB Sin', 'radio', '\"[\\\"0\\\",\\\"1\\\",\\\"2\\\",\\\"3\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(406, 35, 'fisio', 'pemeriksaan_kekuatan_otot', 'FS_pemeriksaan_kekuatan_otot_1', 1, 'Trunk (Leher, Punggung, Pinggang)', 'radio', '\"[\\\"X\\\",\\\"O\\\",\\\"T\\\",\\\"R\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(407, 35, 'fisio', 'pemeriksaan_kekuatan_otot', 'FS_pemeriksaan_kekuatan_otot_2', 2, 'AGA Dex', 'radio', '\"[\\\"X\\\",\\\"O\\\",\\\"T\\\",\\\"R\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(408, 35, 'fisio', 'pemeriksaan_kekuatan_otot', 'FS_pemeriksaan_kekuatan_otot_3', 3, 'AGA Sin', 'radio', '\"[\\\"X\\\",\\\"O\\\",\\\"T\\\",\\\"R\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(409, 35, 'fisio', 'pemeriksaan_kekuatan_otot', 'FS_pemeriksaan_kekuatan_otot_4', 4, 'AGB Dex', 'radio', '\"[\\\"X\\\",\\\"O\\\",\\\"T\\\",\\\"R\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(410, 35, 'fisio', 'pemeriksaan_kekuatan_otot', 'FS_pemeriksaan_kekuatan_otot_5', 5, 'AGB Sin', 'radio', '\"[\\\"X\\\",\\\"O\\\",\\\"T\\\",\\\"R\\\"]\"', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(411, 36, 'fisio', 'palpasi_otot', 'FS_palpasi_otot_palpasi_hypertonus', 1, 'Hypertonus (spactic / rigid)', 'multi_segment', NULL, '\"{\\\"answer_format\\\":{\\\"AGA\\\":[\\\"D\\\",\\\"S\\\"],\\\"AGB\\\":[\\\"D\\\",\\\"S\\\"],\\\"Perut\\\":[\\\"value\\\"]},\\\"segment_labels\\\":{\\\"AGA\\\":\\\"Anggota Gerak Atas\\\",\\\"AGB\\\":\\\"Anggota Gerak Bawah\\\",\\\"Perut\\\":\\\"Perut\\\"},\\\"option_labels\\\":{\\\"D\\\":\\\"Dextra (Kanan)\\\",\\\"S\\\":\\\"Sinister (Kiri)\\\",\\\"value\\\":\\\"Nilai\\\"}}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(412, 36, 'fisio', 'palpasi_otot', 'FS_palpasi_otot_palpasi_hypotonus', 2, 'Hypotonus', 'multi_segment', NULL, '\"{\\\"answer_format\\\":{\\\"AGA\\\":[\\\"D\\\",\\\"S\\\"],\\\"AGB\\\":[\\\"D\\\",\\\"S\\\"],\\\"Perut\\\":[\\\"value\\\"]},\\\"segment_labels\\\":{\\\"AGA\\\":\\\"Anggota Gerak Atas\\\",\\\"AGB\\\":\\\"Anggota Gerak Bawah\\\",\\\"Perut\\\":\\\"Perut\\\"},\\\"option_labels\\\":{\\\"D\\\":\\\"Dextra (Kanan)\\\",\\\"S\\\":\\\"Sinister (Kiri)\\\",\\\"value\\\":\\\"Nilai\\\"}}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(413, 36, 'fisio', 'palpasi_otot', 'FS_palpasi_otot_palpasi_fluktuatif', 3, 'Fluktuatif', 'multi_segment', NULL, '\"{\\\"answer_format\\\":{\\\"AGA\\\":[\\\"D\\\",\\\"S\\\"],\\\"AGB\\\":[\\\"D\\\",\\\"S\\\"],\\\"Perut\\\":[\\\"value\\\"]},\\\"segment_labels\\\":{\\\"AGA\\\":\\\"Anggota Gerak Atas\\\",\\\"AGB\\\":\\\"Anggota Gerak Bawah\\\",\\\"Perut\\\":\\\"Perut\\\"},\\\"option_labels\\\":{\\\"D\\\":\\\"Dextra (Kanan)\\\",\\\"S\\\":\\\"Sinister (Kiri)\\\",\\\"value\\\":\\\"Nilai\\\"}}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(414, 36, 'fisio', 'palpasi_otot', 'FS_palpasi_otot_palpasi_normal', 4, 'Normal', 'multi_segment', NULL, '\"{\\\"answer_format\\\":{\\\"AGA\\\":[\\\"D\\\",\\\"S\\\"],\\\"AGB\\\":[\\\"D\\\",\\\"S\\\"],\\\"Perut\\\":[\\\"value\\\"]},\\\"segment_labels\\\":{\\\"AGA\\\":\\\"Anggota Gerak Atas\\\",\\\"AGB\\\":\\\"Anggota Gerak Bawah\\\",\\\"Perut\\\":\\\"Perut\\\"},\\\"option_labels\\\":{\\\"D\\\":\\\"Dextra (Kanan)\\\",\\\"S\\\":\\\"Sinister (Kiri)\\\",\\\"value\\\":\\\"Nilai\\\"}}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(415, 37, 'fisio', 'jenis_spastisitas', 'FS_jenis_spastisitas_1', 1, 'Hemiplegia', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(416, 37, 'fisio', 'jenis_spastisitas', 'FS_jenis_spastisitas_2', 2, 'Diplegia', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(417, 37, 'fisio', 'jenis_spastisitas', 'FS_jenis_spastisitas_3', 3, 'Quadriplegia', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(418, 37, 'fisio', 'jenis_spastisitas', 'FS_jenis_spastisitas_4', 4, 'Monoplegia', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(419, 37, 'fisio', 'jenis_spastisitas', 'FS_jenis_spastisitas_5', 5, 'Triplegia', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(420, 38, 'fisio', 'test_fungsi_bermain', 'FS_test_fungsi_bermain_1', 1, 'Jenis Permainan', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(421, 38, 'fisio', 'test_fungsi_bermain', 'FS_test_fungsi_bermain_2', 2, 'Mengikuti Objek', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(422, 38, 'fisio', 'test_fungsi_bermain', 'FS_test_fungsi_bermain_3', 3, 'Mengikuti Sumber Suara', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(423, 38, 'fisio', 'test_fungsi_bermain', 'FS_test_fungsi_bermain_4', 4, 'Meraih Objek', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(424, 38, 'fisio', 'test_fungsi_bermain', 'FS_test_fungsi_bermain_5', 5, 'Menggenggam', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(425, 38, 'fisio', 'test_fungsi_bermain', 'FS_test_fungsi_bermain_6', 6, 'Membedakan Warna', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(426, 38, 'fisio', 'test_fungsi_bermain', 'FS_test_fungsi_bermain_7', 7, 'Atensi Fokus', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(427, 39, 'fisio', 'diagnosa_fisioterapi', 'FS_diagnosa_fisioterapi_impairment_keluhan', 1, 'A. Impairment (Keluhan)', 'textarea', NULL, '\"{\\\"placeholder\\\":\\\"Deskripsi keluhan dan impairment yang dialami pasien\\\",\\\"rows\\\":4}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(428, 39, 'fisio', 'diagnosa_fisioterapi', 'FS_diagnosa_fisioterapi_functional_limitation', 2, 'B. Functional Limitation (Batasan)', 'textarea', NULL, '\"{\\\"placeholder\\\":\\\"Batasan fungsional yang dialami pasien dalam aktivitas sehari-hari\\\",\\\"rows\\\":4}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(429, 39, 'fisio', 'diagnosa_fisioterapi', 'FS_diagnosa_fisioterapi_participant_restriction', 3, 'C. Participant Restriction (Restriksi)', 'textarea', NULL, '\"{\\\"placeholder\\\":\\\"Restriksi partisipasi pasien dalam lingkungan sosial dan aktivitas\\\",\\\"rows\\\":4}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(430, 40, 'parent_general', 'riwayat_psikososial', 'DG-RIWAYAT_PSIKOSOSIAL-1', 1, 'Ananda anak ke berapa?', 'number', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(431, 40, 'parent_general', 'riwayat_psikososial', 'DG-RIWAYAT_PSIKOSOSIAL-2', 2, 'Saudara (Nama dan Usia):', 'multi', NULL, '\"{\\\"fields\\\":[\\\"Nama\\\",\\\"Usia\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(432, 40, 'parent_general', 'riwayat_psikososial', 'DG-RIWAYAT_PSIKOSOSIAL-3', 3, 'Orang-orang yang tinggal serumah dengan anak:', 'text', NULL, '\"{\\\"placeholder\\\":\\\"Ayah, Ibu\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(433, 40, 'parent_general', 'riwayat_psikososial', 'DG-RIWAYAT_PSIKOSOSIAL-4', 4, 'Status pernikahan orang tua terkini:', 'select', '\"[\\\"Menikah\\\",\\\"Cerai Hidup\\\",\\\"Cerai Mati\\\"]\"', '\"{\\\"options\\\":[\\\"Menikah\\\",\\\"Cerai Hidup\\\",\\\"Cerai Mati\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(434, 40, 'parent_general', 'riwayat_psikososial', 'DG-RIWAYAT_PSIKOSOSIAL-5', 5, 'Bahasa sehari-hari:', 'text', NULL, '\"{\\\"placeholder\\\":\\\"Indonesia\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(435, 41, 'parent_general', 'riwayat_kehamilan', 'DG-RIWAYAT_KEHAMILAN-1', 1, 'Kehamilan diinginkan dan direncanakan', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(436, 41, 'parent_general', 'riwayat_kehamilan', 'DG-RIWAYAT_KEHAMILAN-2', 2, 'Kontrol rutin ke dokter atau bidan', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(437, 41, 'parent_general', 'riwayat_kehamilan', 'DG-RIWAYAT_KEHAMILAN-3', 3, 'Usia ibu pada saat hamil', 'number', NULL, '\"{\\\"suffix\\\":\\\"Tahun\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(438, 41, 'parent_general', 'riwayat_kehamilan', 'DG-RIWAYAT_KEHAMILAN-4', 4, 'HB saat hamil', 'number', NULL, '\"{\\\"suffix\\\":\\\"g\\\\\\/dL\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(439, 41, 'parent_general', 'riwayat_kehamilan', 'DG-RIWAYAT_KEHAMILAN-5', 5, 'Lama kehamilan', 'number', NULL, '\"{\\\"suffix\\\":\\\"Bulan\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(440, 41, 'parent_general', 'riwayat_kehamilan', 'DG-RIWAYAT_KEHAMILAN-6', 6, 'Riwayat jatuh / pendarahan', 'text', NULL, '\"{\\\"placeholder\\\":\\\"Berikan alasan!\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(441, 41, 'parent_general', 'riwayat_kehamilan', 'DG-RIWAYAT_KEHAMILAN-7', 7, 'Apakah mengonsumsi obat-obatan tertentu?', 'text', NULL, '\"{\\\"placeholder\\\":\\\"Berikan Alasan!\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(442, 41, 'parent_general', 'riwayat_kehamilan', 'DG-RIWAYAT_KEHAMILAN-8', 8, 'Komplikasi lainnya selama kehamilan', 'textarea', NULL, '\"{\\\"placeholder\\\":\\\"Keterangan!\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(443, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-1', 1, 'Lahir persalinan normal / operasi caesar / vakum', 'radio', '\"[\\\"Normal\\\",\\\"Operasi Caesar\\\",\\\"Vakum\\\"]\"', '\"{\\\"options\\\":[\\\"Normal\\\",\\\"Operasi Caesar\\\",\\\"Vakum\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(444, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-2', 2, 'Jika lahir normal posisi lahir kepala dulu / kaki dulu / pantat dulu', 'radio', '\"[\\\"Kepala dulu\\\",\\\"Kaki dulu\\\",\\\"Pantat dulu\\\"]\"', '\"{\\\"options\\\":[\\\"Kepala dulu\\\",\\\"Kaki dulu\\\",\\\"Pantat dulu\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(445, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-3', 3, 'Alasan lahir dengan persalinan operasi caesar / vakum', 'textarea', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":443,\\\"operator\\\":\\\"!=\\\",\\\"value\\\":\\\"Normal\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(446, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-4', 4, 'Lahir langsung menangis?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(447, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-5', 5, 'Saat lahir ada riwayat bayi biru / kuning / kejang?', 'checkbox', '\"[\\\"Biru\\\",\\\"Kuning\\\",\\\"Kejang\\\"]\"', '\"{\\\"options\\\":[\\\"Biru\\\",\\\"Kuning\\\",\\\"Kejang\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(448, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-6', 6, 'Jika Ya, berikan informasi berapa lama anak mengalaminya', 'number', NULL, '\"{\\\"suffix\\\":\\\"Hari\\\",\\\"conditional_rules\\\":[{\\\"when\\\":447,\\\"operator\\\":\\\"not_empty\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(449, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-7', 7, 'Pernah masuk inkubator?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(450, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-8', 8, 'Jika Ya, berikan informasi berapa lama masuk inkubator', 'number', NULL, '\"{\\\"suffix\\\":\\\"Hari\\\",\\\"conditional_rules\\\":[{\\\"when\\\":449,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(451, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-9', 9, 'Berat Anak (kg)', 'number', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(452, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-10', 10, 'Panjang Anak (cm)', 'number', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(453, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-11', 11, 'Lingkar Kepala (cm)', 'number', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(454, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-12', 12, 'Komplikasi lainnya ketika kelahiran', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(455, 42, 'parent_general', 'riwayat_kelahiran', 'DG-RIWAYAT_KELAHIRAN-13', 13, 'Apakah ibu menderita sindrom depresi pasca melahirkan?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(456, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-1', 1, 'Anak mengalami biru / kuning / kejang?', 'checkbox', '\"[\\\"Biru\\\",\\\"Kuning\\\",\\\"Kejang\\\"]\"', '\"{\\\"options\\\":[\\\"Biru\\\",\\\"Kuning\\\",\\\"Kejang\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(457, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-2', 2, 'Berapa lama mengalaminya?', 'number', NULL, '\"{\\\"suffix\\\":\\\"Hari\\\",\\\"conditional_rules\\\":[{\\\"when\\\":456,\\\"operator\\\":\\\"not_empty\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(458, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-3', 3, 'Saat usia berapa?', 'number', NULL, '\"{\\\"suffix\\\":\\\"Tahun\\\",\\\"conditional_rules\\\":[{\\\"when\\\":456,\\\"operator\\\":\\\"not_empty\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(459, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-4', 4, 'Anak pernah jatuh / tidak', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(460, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-5', 5, 'Bagian tubuh yang terbentur?', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":459,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(461, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-6', 6, 'Saat usia berapa?', 'number', NULL, '\"{\\\"suffix\\\":\\\"Tahun\\\",\\\"conditional_rules\\\":[{\\\"when\\\":459,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(462, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-7', 7, 'Komplikasi lainnya setelah kelahiran', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(463, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-8', 8, 'Pada bagian ini, diisi dengan usia anak saat mampu melakukannya:', 'table', NULL, '\"{\\\"rows\\\":[\\\"Angkat kepala\\\",\\\"Tengkurap\\\",\\\"Berguling\\\",\\\"Duduk mandiri\\\",\\\"Merangkak\\\",\\\"Merambat\\\",\\\"Berdiri mandiri\\\",\\\"Berjalan mandiri\\\"],\\\"columns\\\":[\\\"usia\\\"],\\\"suffix\\\":\\\"Bulan\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(464, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-9', 9, 'Bagaimana riwayat imunisasi anak?', 'radio_with_text', '\"[\\\"Lengkap\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Lengkap\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(465, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-10', 10, 'Jika tidak lengkap, sebutkan imunisasi apa yang kurang', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":464,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Tidak\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(466, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-11', 11, 'Apakah anak mendapat ASI eksklusif?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(467, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-12', 12, 'Jika Ya, sampai usia berapa anak minum ASI', 'number', NULL, '\"{\\\"suffix\\\":\\\"Tahun\\\",\\\"conditional_rules\\\":[{\\\"when\\\":466,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(468, 43, 'parent_general', 'riwayat_setelah_kelahiran', 'DG-RIWAYAT_SETELAH_KELAHIRAN-13', 13, 'Sejak usia berapa anak makan nasi tim / nasi biasa', 'number', NULL, '\"{\\\"suffix\\\":\\\"Tahun\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(469, 44, 'parent_general', 'riwayat_kesehatan', 'DG-RIWAYAT_KESEHATAN-1', 1, 'Berikan perkiraan usia anak pernah menderita penyakit berikut:', 'table', NULL, '\"{\\\"columns\\\":[\\\"penyakit\\\",\\\"tahun\\\"],\\\"rows\\\":[\\\"Alergi\\\",\\\"Demam\\\",\\\"Infeksi Telinga\\\",\\\"Sakit Kepala\\\",\\\"Mastoiditis\\\",\\\"Sinusitis\\\",\\\"Asma\\\",\\\"Kejang\\\",\\\"Encephalitis\\\",\\\"Demam Tinggi\\\",\\\"Meningitis\\\",\\\"Tonsilitis\\\",\\\"Cacar Air\\\",\\\"Pusing\\\",\\\"Campak \\\\\\/ Rubella\\\",\\\"Influensa\\\",\\\"Radang Paru\\\",\\\"Dll.\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(470, 44, 'parent_general', 'riwayat_kesehatan', 'DG-RIWAYAT_KESEHATAN-2', 2, 'Apakah dalam anggota keluarga memiliki riwayat penyakit yang sama dengan anak? Mohon ceritakan detailnya.', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(471, 44, 'parent_general', 'riwayat_kesehatan', 'DG-RIWAYAT_KESEHATAN-3', 3, 'Apakah dalam anggota keluarga memiliki riwayat gangguan tertentu? seperti stress, depresi, skizofrenia, dll.', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(472, 44, 'parent_general', 'riwayat_kesehatan', 'DG-RIWAYAT_KESEHATAN-4', 4, 'Pernahkah anak melakukan pembedahan? Jika iya, apa jenisnya dan kapan (contohnya tonsillectomy, adenoidectomy, dll)', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(473, 44, 'parent_general', 'riwayat_kesehatan', 'DG-RIWAYAT_KESEHATAN-5', 5, 'Apakah anak memiliki riwayat penyakit khusus?', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(474, 44, 'parent_general', 'riwayat_kesehatan', 'DG-RIWAYAT_KESEHATAN-6', 6, 'Apakah anak menjalani pengobatan lain? Jika iya, sebutkan.', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(475, 44, 'parent_general', 'riwayat_kesehatan', 'DG-RIWAYAT_KESEHATAN-7', 7, 'Apakah ada reaksi negatif dari pengobatan tersebut? Jika iya, identifikasi.', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(476, 44, 'parent_general', 'riwayat_kesehatan', 'DG-RIWAYAT_KESEHATAN-8', 8, 'Ceritakan riwayat penyakit yang pernah dialami atau rawat inap yang pernah dilakukan.', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(477, 45, 'parent_general', 'riwayat_pendidikan', 'DG-RIWAYAT_PENDIDIKAN-1', 1, 'Apakah anak anda bersekolah?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(478, 45, 'parent_general', 'riwayat_pendidikan', 'DG-RIWAYAT_PENDIDIKAN-2', 2, 'Dimana sekolahnya?', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":477,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(479, 45, 'parent_general', 'riwayat_pendidikan', 'DG-RIWAYAT_PENDIDIKAN-3', 3, 'Kelas berapa?', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":477,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(480, 45, 'parent_general', 'riwayat_pendidikan', 'DG-RIWAYAT_PENDIDIKAN-4', 4, 'Apakah anak anda pernah tidak bersekolah untuk jangka waktu tertentu?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(481, 45, 'parent_general', 'riwayat_pendidikan', 'DG-RIWAYAT_PENDIDIKAN-5', 5, 'Jika pernah tidak bersekolah, berapa lama dan apa alasan tidak bersekolah?', 'textarea', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":480,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(482, 45, 'parent_general', 'riwayat_pendidikan', 'DG-RIWAYAT_PENDIDIKAN-6', 6, 'Gambarkan mengenai pencapaian akademis dan performa sosialisasinya:', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(483, 45, 'parent_general', 'riwayat_pendidikan', 'DG-RIWAYAT_PENDIDIKAN-7', 7, 'Apakah anak menerima perlakuan khusus? Jika iya, jelaskan:', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(484, 45, 'parent_general', 'riwayat_pendidikan', 'DG-RIWAYAT_PENDIDIKAN-8', 8, 'Apakah anak anda mengikuti Program Pendukung Pembelajaran?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(485, 45, 'parent_general', 'riwayat_pendidikan', 'DG-RIWAYAT_PENDIDIKAN-9', 9, 'Jika ya, berikan gambaran tentang tujuan, durasi, frekuensi, di kelas / luar kelas, individual / group, dilaksanakan oleh:', 'textarea', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":477,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(486, 46, 'parent_okupasi', 'general_auditory_language', 'g_1', 1, 'Terlihat terlalu sensitif terhadap suara?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(487, 46, 'parent_okupasi', 'general_auditory_language', 'g_2', 2, 'Tidak dapat mengikuti instruksi sederhana?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(488, 46, 'parent_okupasi', 'general_auditory_language', 'g_3', 3, 'Bingung oleh kata-kata berbunyi sama?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(489, 46, 'parent_okupasi', 'general_auditory_language', 'g_4', 4, 'Hanya menggunakan bahasa tubuh untuk memperjelas ucapan?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(490, 46, 'parent_okupasi', 'general_auditory_language', 'g_5', 5, 'Suka menyanyi?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(491, 46, 'parent_okupasi', 'general_auditory_language', 'g_6', 6, 'Mengalami kesulitan dengan bunyi perkataan?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(492, 46, 'parent_okupasi', 'general_auditory_language', 'g_7', 7, 'Kelihatan menyimak tetapi tidak mengerti?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(493, 46, 'parent_okupasi', 'general_auditory_language', 'g_8', 8, 'Ragu-ragu untuk berbicara?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(494, 46, 'parent_okupasi', 'general_auditory_language', 'g_9', 9, 'Mengerti bahasa tubuh dan ekspresi wajah orang lain?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(495, 47, 'parent_okupasi', 'gustatory_olfactory', 'go_1', 1, 'Bertingkah seakan-akan semua makanan rasanya sama?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(496, 47, 'parent_okupasi', 'gustatory_olfactory', 'go_2', 2, 'Mengunyah benda-benda bukan makanan?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(497, 47, 'parent_okupasi', 'gustatory_olfactory', 'go_3', 3, 'Memiliki selera yang tidak biasa kepada makanan tertentu?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(498, 47, 'parent_okupasi', 'gustatory_olfactory', 'go_4', 4, 'Tidak menyukai makanan bertekstur tertentu?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(499, 47, 'parent_okupasi', 'gustatory_olfactory', 'go_5', 5, 'Mengeksplorasi dengan penciuman?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(500, 47, 'parent_okupasi', 'gustatory_olfactory', 'go_6', 6, 'Dapat membedakan bau?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(501, 47, 'parent_okupasi', 'gustatory_olfactory', 'go_7', 7, 'Bereaksi negatif terhadap bau?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(502, 47, 'parent_okupasi', 'gustatory_olfactory', 'go_8', 8, 'Tidak mempedulikan bau-bau yang tidak menyenangkan?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(503, 48, 'parent_okupasi', 'visual', 'v_1', 1, 'Tampak lebih senang gelap?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(504, 48, 'parent_okupasi', 'visual', 'v_2', 2, 'Memungut gambar-gambar / objek dan memperhatikannya dengan detail dan teliti?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(505, 48, 'parent_okupasi', 'visual', 'v_3', 3, 'Menjadi senang ketika ada bermacam-macam objek yang bisa dilihat?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(506, 48, 'parent_okupasi', 'visual', 'v_4', 4, 'Sering berputar?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(507, 48, 'parent_okupasi', 'visual', 'v_5', 5, 'Memakai kacamata?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(508, 48, 'parent_okupasi', 'visual', 'v_6', 6, 'Mengalami kesulitan mengikuti objek yang digulirkan kepadanya?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(509, 48, 'parent_okupasi', 'visual', 'v_7', 7, 'Mengalami kesulitan kontak mata dengan orang lain?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(510, 48, 'parent_okupasi', 'visual', 'v_8', 8, 'Berpaling dari satu sisi ke sisi lain untuk melihat sesuatu?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(511, 48, 'parent_okupasi', 'visual', 'v_9', 9, 'Cenderung menjangkau terlalu jauh ketika bermain, makan, dll', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(512, 49, 'parent_okupasi', 'tactile', 't_1', 1, 'Tidak mau bermain dengan barang \'kotor\' (cat, lumpur, pasta, pasir, dll)?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(513, 49, 'parent_okupasi', 'tactile', 't_2', 2, 'Tidak suka ketika wajah dilap / diseka?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(514, 49, 'parent_okupasi', 'tactile', 't_3', 3, 'Kelihatan terganggu dengan tekstur kain tertentu?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(515, 49, 'parent_okupasi', 'tactile', 't_4', 4, 'Tidak suka disentuh?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(516, 49, 'parent_okupasi', 'tactile', 't_5', 5, 'Tidak suka disentuh secara tiba-tiba?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(517, 49, 'parent_okupasi', 'tactile', 't_6', 6, 'Tidak suka dipeluk?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(518, 49, 'parent_okupasi', 'tactile', 't_7', 7, 'Lebih suka menyentuh daripada disentuh?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(519, 49, 'parent_okupasi', 'tactile', 't_8', 8, 'Menghindari menggunakan tangan untuk jangka waktu tertentu?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(520, 49, 'parent_okupasi', 'tactile', 't_9', 9, 'Cenderung membenturkan kepala dengan sengaja dulu / sekarang?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(521, 49, 'parent_okupasi', 'tactile', 't_10', 10, 'Mencubit, menggigit, atau menyakiti diri sendiri / atau orang lain?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(522, 49, 'parent_okupasi', 'tactile', 't_11', 11, 'Memeriksa barang dengan memasukkannya ke dalam mulut?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(523, 49, 'parent_okupasi', 'tactile', 't_12', 12, 'Cenderung untuk merasa sakit lebih dari orang lain?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(524, 49, 'parent_okupasi', 'tactile', 't_13', 13, 'Secara berkala membentur atau mendorong anak lain?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(525, 49, 'parent_okupasi', 'tactile', 't_14', 14, 'Tidak suka dikeramas?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(526, 49, 'parent_okupasi', 'tactile', 't_15', 15, 'Tidak suka dipotong kuku?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(527, 50, 'parent_okupasi', 'proprioseptif', 'p_1', 1, 'Memegang tangan nya dalam posisi aneh?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05');
INSERT INTO `assessment_questions` (`id`, `group_id`, `assessment_type`, `section`, `question_code`, `question_number`, `question_text`, `answer_type`, `answer_options`, `extra_schema`, `is_active`, `created_at`, `updated_at`) VALUES
(528, 50, 'parent_okupasi', 'proprioseptif', 'p_2', 2, 'Memegangi tubuhnya dalam posisi aneh?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(529, 50, 'parent_okupasi', 'proprioseptif', 'p_3', 3, 'Memiliki kemampuan baik untuk menirukan hal-hal kecil?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(530, 50, 'parent_okupasi', 'proprioseptif', 'p_4', 4, 'Melakukan gerakan-gerakan cepat dan mengejutkan?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(531, 50, 'parent_okupasi', 'proprioseptif', 'p_5', 5, 'Kesulitan berpindah dari satu posisi ke posisi lain?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(532, 51, 'parent_okupasi', 'vestibular', 'vest_1', 1, 'Berayun saat duduk?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(533, 51, 'parent_okupasi', 'vestibular', 'vest_2', 2, 'Banyak melompat?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(534, 51, 'parent_okupasi', 'vestibular', 'vest_3', 3, 'Senang dilempar ke udara?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(535, 51, 'parent_okupasi', 'vestibular', 'vest_4', 4, 'Memiliki keseimbangan yang baik?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(536, 51, 'parent_okupasi', 'vestibular', 'vest_5', 5, 'Kelihatan takut terhadap ruang (misal: naik dan turun tangga, memasukki ruangan kecil tertutup)?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(537, 51, 'parent_okupasi', 'vestibular', 'vest_6', 6, 'Suka naik komidi putar?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(538, 51, 'parent_okupasi', 'vestibular', 'vest_7', 7, 'Berputar-putar lebih dari anak lain?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(539, 51, 'parent_okupasi', 'vestibular', 'vest_8', 8, 'Mabuk kendaraan?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(540, 51, 'parent_okupasi', 'vestibular', 'vest_9', 9, 'Senang diayun sekarang / ketika bayi?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(541, 51, 'parent_okupasi', 'vestibular', 'vest_10', 10, 'Tidak takut bergerak/jatuh?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(542, 51, 'parent_okupasi', 'vestibular', 'vest_11', 11, 'Menjadi gelisah saat perjalanan panjang dengan mobil?', 'radio3', '[\"Ya\",\"Tidak\",\"Kadang-kadang\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(543, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_1', 1, 'Terganggu oleh sentuhan fisik dengan orang lain?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(544, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_2', 2, 'Sangat tidak suka dipotong kukunya?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(545, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_3', 3, 'Kelihatan takut dalam permainan keseimbangan dan memanjat?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(546, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_4', 4, 'Berlebihan pada permainan berputar & berayun?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(547, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_5', 5, 'Pasif saat berada dirumah?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(548, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_6', 6, 'Sangat suka dipeluk dan dibelai?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(549, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_7', 7, 'Memasukkan jari-jari / mainan ke mulut?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(550, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_8', 8, 'Tidak suka tekstur makanan tertentu?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(551, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_9', 9, 'Terganggu karena suara-sara ribut?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(552, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_10', 10, 'Sangat suka menyentuh barang?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(553, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_11', 11, 'Terganggu oleh tekstur tertentu?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(554, 52, 'parent_okupasi', 'body_perception_reaction', 'bpr_12', 12, 'Memiliki ketidaksukaan ekstrem terhadap apapun?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(555, 53, 'parent_okupasi', 'daily_living_skills', 'dls_1', 1, 'Mengatur emosi?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(556, 53, 'parent_okupasi', 'daily_living_skills', 'dls_2', 2, 'Berpakaian / melepas pakaian?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(557, 53, 'parent_okupasi', 'daily_living_skills', 'dls_3', 3, 'Memakai sepatu / kaos kaki?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(558, 53, 'parent_okupasi', 'daily_living_skills', 'dls_4', 4, 'Menalikan tali sepatu?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(559, 53, 'parent_okupasi', 'daily_living_skills', 'dls_5', 5, 'Memasang kancing?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(560, 53, 'parent_okupasi', 'daily_living_skills', 'dls_6', 6, 'Membersihkan diri (cuci muka, dll)?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(561, 53, 'parent_okupasi', 'daily_living_skills', 'dls_7', 7, 'Sikat gigi?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(562, 53, 'parent_okupasi', 'daily_living_skills', 'dls_8', 8, 'Menyisir rambut?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(563, 53, 'parent_okupasi', 'daily_living_skills', 'dls_9', 9, 'Berdiri di atas satu kaki?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(564, 53, 'parent_okupasi', 'daily_living_skills', 'dls_10', 10, 'Melompat di tempat?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(565, 53, 'parent_okupasi', 'daily_living_skills', 'dls_11', 11, 'Lompat tali?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(566, 53, 'parent_okupasi', 'daily_living_skills', 'dls_12', 12, 'Mengendarai sepeda?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(567, 53, 'parent_okupasi', 'daily_living_skills', 'dls_13', 13, 'Menggunakan peralatan di taman bermain?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(568, 53, 'parent_okupasi', 'daily_living_skills', 'dls_14', 14, 'Naik / turun tangga?', 'yes_only', '[\"Ya\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(569, 54, 'parent_okupasi', 'behavior_social_statements', 'bs_1', 1, 'Pernyataan yang menggambarkan anak', 'checkbox', '[\"Diam\",\"Hiperaktif\",\"Kesulitan memanajemen frustasi\",\"Impulsif \\/ tidak punya rasa takut terhadap bahaya\",\"Tergila-gila pada perhatian\",\"Menarik diri\",\"Penasaran\",\"Agresif\",\"Pemalu\",\"Bermasalah dengan sikapnya di rumah\",\"Bermasalah dengan sikapnya di sekolah\",\"Emosional\",\"Memiliki ketakutan yang tidak biasa\",\"Suka mengamuk\",\"Memliki hubungan baik dengan saudara kandungnya\",\"Mudah berteman\",\"Mengerti peraturan permainan\",\"Mengerti lelucon\",\"Rigid\\/Kaku\\/Tidak fleksibel\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(570, 54, 'parent_okupasi', 'behavior_social_statements', 'bermain_anak', 2, 'Bermain dengan anak-anak', 'checkbox', '[\"Lebih tua\",\"Lebih muda\",\"Seumuran\"]', NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(571, 55, 'parent_okupasi', 'frequency_range', 'f_1', 1, 'Mudah menyerah', 'slider', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(572, 55, 'parent_okupasi', 'frequency_range', 'f_2', 2, 'Mudah teralihkan perhatian', 'slider', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(573, 55, 'parent_okupasi', 'frequency_range', 'f_3', 3, 'Mengalami kesulitan duduk diam di kursi selama lebih dari 5 menit', 'slider', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(574, 55, 'parent_okupasi', 'frequency_range', 'f_4', 4, 'Tidak dapat berkonsentrasi lebih dari 20 menit', 'slider', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(575, 55, 'parent_okupasi', 'frequency_range', 'f_5', 5, 'Ceroboh dan sering menghilangkan barang pribadi', 'slider', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(576, 55, 'parent_okupasi', 'frequency_range', 'f_6', 6, 'Mengamuk tanpa alasan yang jelas', 'slider', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(577, 55, 'parent_okupasi', 'frequency_range', 'f_7', 7, 'Menolak mengikuti perintah walupun tidak mengerti perintah tersebut', 'slider', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(578, 55, 'parent_okupasi', 'frequency_range', 'f_8', 8, 'Tidak sabar menunggu giliran', 'slider', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(579, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-1', 1, 'Ceritakan masalah bahasa bicara anak', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(580, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-2', 2, 'Bagaimana biasanya anak berkomunikasi (gerak tubuh, kata, frasa, kalimat)?', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(581, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-3', 3, 'Kapan masalah bahasa dan bicara pertama kali diketahui? Oleh siapa?', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(582, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-4', 4, 'Apakah penyebab utama dari gangguan tersebut?', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(583, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-5', 5, 'Apakah anak peduli dengan masalahnya?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(584, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-6', 6, 'Jika Ya, bagaimana dia merasakannya?', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":583,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(585, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-7', 7, 'Apakah sebelumnya anak sudah diperiksa oleh terapis wicara?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(586, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-8', 8, 'Siapa yang memeriksa?', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":585,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(587, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-9', 9, 'Kapan pemeriksaan dilakukan?', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":585,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(588, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-10', 10, 'Apa kesimpulannya?', 'textarea', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":585,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(589, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-11', 11, 'Apakah ahli lain (dokter, psikolog, ortopedi, dll) yang melakukan pemeriksaan?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(590, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-12', 12, 'Siapa yang memeriksa?', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":589,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(591, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-13', 13, 'Kapan pemeriksaan dilakukan?', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":589,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(592, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-14', 14, 'Apa kesimpulannya dan sarannya?', 'textarea', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":589,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(593, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-15', 15, 'Apakah ada anggota keluarga yang mengalami gangguan bicara, bahasa dan pendengaran?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(594, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-16', 16, 'Jika Ya, tolong ceritakan', 'textarea', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":593,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(595, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-17', 17, 'Berikan perkiraan usia anak mampu melakukan ini:', 'table', NULL, '\"{\\\"rows\\\":[\\\"Mengujarkan satu kata\\\",\\\"Mengujakan dua kata\\\",\\\"Mengujarkan tigas kata\\\\\\/lebih (kalimat)\\\",\\\"Mengujarkan pertanyaan sederhana\\\",\\\"Percakapan \\\\\\/ cerita\\\"],\\\"columns\\\":[\\\"usia\\\"],\\\"suffix\\\":\\\"Bulan\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(596, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-18', 18, 'Apakah ada masalah dalam feeding (misalnya: menelan, menghisap, drooling, mengunyah)?', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(597, 56, 'parent_wicara', 'wicara_orangtua', 'PW-WICARA_ORANGTUA-19', 19, 'Jelaskan respon anak terhadap bunyi bicara dan bunyi di lingkungannya', 'textarea', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(598, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-1', 1, 'Apakah pernah melakukan pengukuran IQ anak', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(599, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-2', 2, 'Apakah anak mengikuti jam tambahan yang bersifat akademis di sekolah?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(600, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-3', 3, 'Jika Ya, berapa skor IQ', 'text', NULL, '\"{\\\"conditional_rules\\\":[{\\\"when\\\":598,\\\"operator\\\":\\\"==\\\",\\\"value\\\":\\\"Ya\\\",\\\"required\\\":true}]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(601, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-4', 4, 'Apakah anak mempunyai Guru Pendamping Khusus (GPK) di sekolah?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(602, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-5', 5, 'Apakah ada modifikasi kurikulum dan materi yang dilakukan oleh GPK?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(603, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-6', 6, 'Dimana posisi tempat duduk anak di dalam kelas', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(604, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-7', 7, 'Apa hobi anak?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(605, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-8', 8, 'Apakah anak mengikuti kegiatan non akademis guna mengembangkan bakatnya (beladiri, renang, sepak bola, dll)', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(606, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-9', 9, 'Dimana kegiatan pengembangan diri tersebut dilakukan?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(607, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-10', 10, 'Kapan pengembangan diri tersebut dilakukan?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(608, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-11', 11, 'Apakah anak mampu fokus dalam pembelajaran?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(609, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-12', 12, 'Berapa lama ketahanan fokus anak?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(610, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-13', 13, 'Adakah ketertarikan anak terhadap benda-benda untuk menarik fokus kembali?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(611, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-14', 14, 'Apakah anak rutin belajar dirumah setiap hari?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(612, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-15', 15, 'Kapan waktu belajar anak dirumah?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(613, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-16', 16, 'Siapa pendamping anak ketika belajar dirumah?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(614, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-17', 17, 'Bagaimana pengkondisian tempat dan suasana anak ketika belajar?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(615, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-18', 18, 'Apa mata pelajaran yang disenangi anak?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(616, 57, 'parent_paedagog', 'akademis', 'PPD-AKADEMIS-19', 19, 'Apa mata pelajaran yang kurang disenangi anak?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(617, 58, 'parent_paedagog', 'ketunaan_visual', 'PPD-KETUNAAN_VISUAL-1', 1, 'Apakah anak anda mengalami gangguan visual?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(618, 58, 'parent_paedagog', 'ketunaan_visual', 'PPD-KETUNAAN_VISUAL-2', 2, 'Apakah anak pernah/sedang memakai kacamata baca?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(619, 58, 'parent_paedagog', 'ketunaan_visual', 'PPD-KETUNAAN_VISUAL-3', 3, 'Apakah anak nyaman bila membaca sambil duduk?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(620, 58, 'parent_paedagog', 'ketunaan_visual', 'PPD-KETUNAAN_VISUAL-4', 4, 'Apakah anak nyaman bila membaca sambil berbaring/tengkurap/tiduran?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(621, 58, 'parent_paedagog', 'ketunaan_visual', 'PPD-KETUNAAN_VISUAL-5', 5, 'Apakah anak tertarik dengan kegiatan belajar atau memperoleh informasi baru?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(622, 58, 'parent_paedagog', 'ketunaan_visual', 'PPD-KETUNAAN_VISUAL-6', 6, 'Berapa lama anak mengeksplore gadget? (per hari)', 'text', NULL, '\"{\\\"placeholder\\\":\\\"\\\\\\/Hari\\\"}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(623, 59, 'parent_paedagog', 'ketunaan_auditori', 'PPD-KETUNAAN_AUDITORI-1', 1, 'Apakah anak mengalami gangguan auditori?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(624, 59, 'parent_paedagog', 'ketunaan_auditori', 'PPD-KETUNAAN_AUDITORI-2', 2, 'Apakah anak sedang/pernah memakai alat bantu dengar (ABD)?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(625, 59, 'parent_paedagog', 'ketunaan_auditori', 'PPD-KETUNAAN_AUDITORI-3', 3, 'Apakah anak langsung merespon jika namanya dipanggil?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(626, 59, 'parent_paedagog', 'ketunaan_auditori', 'PPD-KETUNAAN_AUDITORI-4', 4, 'Apakah anak lebih suka mendengar musik / menyanyi?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(627, 59, 'parent_paedagog', 'ketunaan_auditori', 'PPD-KETUNAAN_AUDITORI-5', 5, 'Apakah anak lebih menyukai suasana yang tenang ketika belajar?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(628, 59, 'parent_paedagog', 'ketunaan_auditori', 'PPD-KETUNAAN_AUDITORI-6', 6, 'Apakah anak pernah/sering menunjukkan respon ketidaksukaannya dengan menutup telinga?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(629, 59, 'parent_paedagog', 'ketunaan_auditori', 'PPD-KETUNAAN_AUDITORI-7', 7, 'Apakah anak sering memakai headset?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(630, 60, 'parent_paedagog', 'ketunaan_motorik', 'PPD-KETUNAAN_MOTORIK-1', 1, 'Apakah anak mengalami gangguan motorik?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(631, 60, 'parent_paedagog', 'ketunaan_motorik', 'PPD-KETUNAAN_MOTORIK-2', 2, 'Jika YA bagian yang mengalami gangguan?', 'radio', '\"[\\\"Motorik Halus\\\",\\\"Motorik Kasar\\\"]\"', '\"{\\\"options\\\":[\\\"Motorik Halus\\\",\\\"Motorik Kasar\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(632, 60, 'parent_paedagog', 'ketunaan_motorik', 'PPD-KETUNAAN_MOTORIK-3', 3, 'Bentuk gangguan berupa?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(633, 60, 'parent_paedagog', 'ketunaan_motorik', 'PPD-KETUNAAN_MOTORIK-4', 4, 'Apakah anak mengalami kesulitan dalam mobilisasi secara mandiri?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(634, 60, 'parent_paedagog', 'ketunaan_motorik', 'PPD-KETUNAAN_MOTORIK-5', 5, 'Apakah anak mengalami kekakuan / kelayuan pada bagian tubuh tertentu?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(635, 61, 'parent_paedagog', 'ketunaan_kognitif', 'PPD-KETUNAAN_KOGNITIF-1', 1, 'Apakah anak mengalami gangguan kognitif?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(636, 61, 'parent_paedagog', 'ketunaan_kognitif', 'PPD-KETUNAAN_KOGNITIF-2', 2, 'Apakah anak perlu penjabaran dalam mengelola informasi?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(637, 61, 'parent_paedagog', 'ketunaan_kognitif', 'PPD-KETUNAAN_KOGNITIF-3', 3, 'Apakah anak tanggap terhadap sesuatu yang tiba-tiba terjadi?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(638, 61, 'parent_paedagog', 'ketunaan_kognitif', 'PPD-KETUNAAN_KOGNITIF-4', 4, 'Kegiatan yang paling diminati anak?', 'radio', '\"[\\\"Membaca\\\",\\\"Menulis\\\",\\\"Berhitung\\\"]\"', '\"{\\\"options\\\":[\\\"Membaca\\\",\\\"Menulis\\\",\\\"Berhitung\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(639, 61, 'parent_paedagog', 'ketunaan_kognitif', 'PPD-KETUNAAN_KOGNITIF-5', 5, 'Apakah anak tertarik dengan kegiatan belajar atau memperoleh informasi baru?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(640, 62, 'parent_paedagog', 'ketunaan_perilaku', 'PPD-KETUNAAN_PERILAKU-1', 1, 'Apakah anak mengalami masalah perilaku?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(641, 62, 'parent_paedagog', 'ketunaan_perilaku', 'PPD-KETUNAAN_PERILAKU-2', 2, 'Apakah anak mudah berteman dengan teman sebayanya?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(642, 62, 'parent_paedagog', 'ketunaan_perilaku', 'PPD-KETUNAAN_PERILAKU-3', 3, 'Apakah anak mengalami perubahan mood / “mood swing” yang cepat?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(643, 62, 'parent_paedagog', 'ketunaan_perilaku', 'PPD-KETUNAAN_PERILAKU-4', 4, 'Apakah anak suka kekerasan dalam melampiaskan emosinya?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(644, 62, 'parent_paedagog', 'ketunaan_perilaku', 'PPD-KETUNAAN_PERILAKU-5', 5, 'Apakah anak cenderung nyaman menyendiri?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(645, 62, 'parent_paedagog', 'ketunaan_perilaku', 'PPD-KETUNAAN_PERILAKU-6', 6, 'Apakah anak enggan menyapa / tersenyum terlebih dahulu dengan orang lain?', 'radio', '\"[\\\"Ya\\\",\\\"Tidak\\\"]\"', '\"{\\\"options\\\":[\\\"Ya\\\",\\\"Tidak\\\"]}\"', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(646, 63, 'parent_paedagog', 'sosialisasi', 'PPD-SOSIALISASI-1', 1, 'Bagaimana sikap anak ketika bertemu dengan orang-orang baru?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(647, 63, 'parent_paedagog', 'sosialisasi', 'PPD-SOSIALISASI-2', 2, 'Bagaimana sikap anak ketika berteman dengan teman-teman yang biasa ditemuinya?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(648, 63, 'parent_paedagog', 'sosialisasi', 'PPD-SOSIALISASI-3', 3, 'Apakah anak sering / tidak pernah mengawali pembicaraan?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(649, 63, 'parent_paedagog', 'sosialisasi', 'PPD-SOSIALISASI-4', 4, 'Apakah anak aktif ketika diajak bicara dengan orangtua atau anggota keluarga yang lain?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(650, 63, 'parent_paedagog', 'sosialisasi', 'PPD-SOSIALISASI-5', 5, 'Bagaimana sikap anak ketika ditempatkan pada situasi yang membuatnya kurang nyaman?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(651, 63, 'parent_paedagog', 'sosialisasi', 'PPD-SOSIALISASI-6', 6, 'Apakah anak bisa berbagi mainan/makanan ketika sedang bersama teman-teman?', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(652, 64, 'parent_fisio', 'fisio_data', 'FISIO-1', 1, 'Keluhan utama yang dialami anak saat ini:', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(653, 64, 'parent_fisio', 'fisio_data', 'FISIO-2', 2, 'Riwayat penyakit atau kondisi yang berhubungan dengan fisioterapi:', 'text', NULL, NULL, 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05');

-- --------------------------------------------------------

--
-- Table structure for table `assessment_question_groups`
--

CREATE TABLE `assessment_question_groups` (
  `id` bigint UNSIGNED NOT NULL,
  `assessment_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `group_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filled_by` enum('parent','assessor') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'assessor',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment_question_groups`
--

INSERT INTO `assessment_question_groups` (`id`, `assessment_type`, `group_title`, `group_key`, `filled_by`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'okupasi', 'Mengukur kemampuan sense of bodily self', 'bodily_self_sense', 'assessor', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(2, 'okupasi', 'Keseimbangan diri, posisi ruang, perencanaan gerak', 'balance_coordination', 'assessor', 2, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(3, 'okupasi', 'Konsentrasi, instruksi, problem solving', 'concentration_problem_solving', 'assessor', 3, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(4, 'okupasi', 'Konsep huruf, warna, anggota tubuh, orientasi waktu', 'concepts_orientation', 'assessor', 4, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(5, 'okupasi', 'Motoric Planning, Bilateral, Menggunting, Memori', 'motoric_planning', 'assessor', 5, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(6, 'okupasi', 'Laporan Akhir Okupasi', 'final_report', 'assessor', 6, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(7, 'paedagog', 'Membaca', 'reading', 'assessor', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(8, 'paedagog', 'Menulis', 'writing', 'assessor', 2, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(9, 'paedagog', 'Berhitung', 'counting', 'assessor', 3, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(10, 'paedagog', 'Kesiapan Belajar', 'readiness', 'assessor', 4, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(11, 'paedagog', 'Pengetahuan Umum', 'general', 'assessor', 5, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(12, 'wicara_oral', 'Evaluasi Wajah', 'face_eval', 'assessor', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(13, 'wicara_oral', 'Evaluasi Rahang dan Gigi', 'jaw_eval', 'assessor', 2, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(14, 'wicara_oral', 'Observasi Gigi', 'dental_eval', 'assessor', 3, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(15, 'wicara_oral', 'Evaluasi Bibir', 'lip_eval', 'assessor', 4, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(16, 'wicara_oral', 'Evaluasi Lidah', 'tongue_eval', 'assessor', 5, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(17, 'wicara_oral', 'Evaluasi Faring', 'pharynx_eval', 'assessor', 6, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(18, 'wicara_oral', 'Evaluasi Langit-langit Keras dan Lunak', 'palate_eval', 'assessor', 7, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(19, 'wicara_bahasa', 'Usia 0-6 Bulan', 'usia_0_6', 'assessor', 8, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(20, 'wicara_bahasa', 'Usia 7-12 Bulan', 'usia_7_12', 'assessor', 8, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(21, 'wicara_bahasa', 'Usia 13-18 Bulan', 'usia_13_18', 'assessor', 8, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(22, 'wicara_bahasa', 'Usia 19-24 Bulan', 'usia_19_24', 'assessor', 8, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(23, 'wicara_bahasa', 'Usia 2-3 Tahun', 'usia_2_3', 'assessor', 8, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(24, 'wicara_bahasa', 'Usia 3-4 Tahun', 'usia_3_4', 'assessor', 8, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(25, 'wicara_bahasa', 'Usia 4-5 Tahun', 'usia_4_5', 'assessor', 8, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(26, 'wicara_bahasa', 'Usia 5-6 Tahun', 'usia_5_6', 'assessor', 8, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(27, 'wicara_bahasa', 'Usia 6-7 Tahun', 'usia_6_7', 'assessor', 8, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(28, 'fisio', 'Pemeriksaan Umum', 'pemeriksaan_umum', 'assessor', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(29, 'fisio', 'Anamnesis Sistem', 'anamnesis_sistem', 'assessor', 2, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(30, 'fisio', 'pemeriksaan_sensoris', 'pemeriksaan_sensoris', 'assessor', 3, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(31, 'fisio', 'pemeriksaan_refleks_primitif', 'pemeriksaan_refleks_primitif', 'assessor', 4, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(32, 'fisio', 'gross_motor_pola_gerak', 'gross_motor_pola_gerak', 'assessor', 5, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(33, 'fisio', 'test_joint_laxity', 'test_joint_laxity', 'assessor', 6, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(34, 'fisio', 'pemeriksaan_spastisitas', 'pemeriksaan_spastisitas', 'assessor', 7, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(35, 'fisio', 'pemeriksaan_kekuatan_otot', 'pemeriksaan_kekuatan_otot', 'assessor', 8, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(36, 'fisio', 'palpasi_otot', 'palpasi_otot', 'assessor', 9, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(37, 'fisio', 'jenis_spastisitas', 'jenis_spastisitas', 'assessor', 10, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(38, 'fisio', 'test_fungsi_bermain', 'test_fungsi_bermain', 'assessor', 11, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(39, 'fisio', 'Diagnosa Fisioterapi', 'diagnosa_fisioterapi', 'assessor', 12, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(40, 'parent_general', 'Riwayat Psikososial', 'riwayat_psikososial', 'parent', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(41, 'parent_general', 'Riwayat Kehamilan', 'riwayat_kehamilan', 'parent', 2, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(42, 'parent_general', 'Riwayat Kelahiran', 'riwayat_kelahiran', 'parent', 3, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(43, 'parent_general', 'Riwayat Setelah Kelahiran', 'riwayat_setelah_kelahiran', 'parent', 4, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(44, 'parent_general', 'Riwayat Kesehatan', 'riwayat_kesehatan', 'parent', 5, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(45, 'parent_general', 'Riwayat Pendidikan', 'riwayat_pendidikan', 'parent', 6, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(46, 'parent_okupasi', 'General — Apakah anak anda ...', 'general_auditory_language', 'parent', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(47, 'parent_okupasi', 'Tes Gustatori / Olfaktori', 'gustatory_olfactory', 'parent', 2, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(48, 'parent_okupasi', 'Visual', 'visual', 'parent', 3, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(49, 'parent_okupasi', 'Taktil / Sensori Sentuhan', 'tactile', 'parent', 4, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(50, 'parent_okupasi', 'Proprioseptif', 'proprioseptif', 'parent', 5, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(51, 'parent_okupasi', 'Vestibular — Keseimbangan & Gerak', 'vestibular', 'parent', 6, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(52, 'parent_okupasi', 'Persepsi Tubuh & Reaksi terhadap Lingkungan', 'body_perception_reaction', 'parent', 7, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(53, 'parent_okupasi', 'Kemampuan Aktivitas Sehari-hari', 'daily_living_skills', 'parent', 8, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(54, 'parent_okupasi', 'Pernyataan Umum & Sosialisasi', 'behavior_social_statements', 'parent', 9, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(55, 'parent_okupasi', 'Tingkat Kesesuaian / Frekuensi Perilaku', 'frequency_range', 'parent', 10, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(56, 'parent_wicara', 'Assessment Terapi Wicara', 'wicara_orangtua', 'parent', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(57, 'parent_paedagog', 'Aspek Akademis', 'akademis', 'parent', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(58, 'parent_paedagog', 'Aspek Ketunaan - Visual', 'ketunaan_visual', 'parent', 2, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(59, 'parent_paedagog', 'Aspek Ketunaan - Auditori', 'ketunaan_auditori', 'parent', 3, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(60, 'parent_paedagog', 'Aspek Ketunaan - Motorik', 'ketunaan_motorik', 'parent', 4, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(61, 'parent_paedagog', 'Aspek Ketunaan - Kognitif', 'ketunaan_kognitif', 'parent', 5, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(62, 'parent_paedagog', 'Aspek Ketunaan - Perilaku', 'ketunaan_perilaku', 'parent', 6, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(63, 'parent_paedagog', 'Aspek Sosialisasi', 'sosialisasi', 'parent', 7, '2026-01-30 14:04:05', '2026-01-30 14:04:05'),
(64, 'parent_fisio', 'Data Fisioterapi', 'fisio_data', 'parent', 1, '2026-01-30 14:04:05', '2026-01-30 14:04:05');

-- --------------------------------------------------------

--
-- Table structure for table `children`
--

CREATE TABLE `children` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_birth_place` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_birth_date` date NOT NULL,
  `child_gender` enum('laki-laki','perempuan') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child_address` blob NOT NULL,
  `child_complaint` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_school` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `child_service_choice` varchar(250) COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_religion` enum('islam','kristen','katolik','hindu','budha','konghucu','lainnya') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `children`
--

INSERT INTO `children` (`id`, `family_id`, `child_name`, `child_birth_place`, `child_birth_date`, `child_gender`, `child_address`, `child_complaint`, `child_school`, `child_service_choice`, `child_religion`, `deleted_at`, `created_at`, `updated_at`) VALUES
('01kg7kqwbcrx19k3vnmd76x1mt', '01kg7kqwb45vby8by7mdyzh75p', 'Putra Pratama', 'Sukoharjo', '2020-02-01', 'laki-laki', 0x65794a7064694936496a46354d6c64544e57564d624659304d57354c556d64726257466e4e58633950534973496e5a686248566c496a6f6964586c6d4c323549526b5643593252725432355856486b3554585647556c425663564673517a6c6b4e32356865573942556a4d345348686b575430694c434a7459574d694f6949324f574535596d4d304d57597a4f57526a4e6d49354e7a5531596a4668596d45774e6d557a59325a6b4d6d4e6b4f4468684d474534597a597a4f4449774d6a4e6d4f57566c5932466d4f575a694e6a5a6c4e7a4533496977696447466e496a6f69496e303d, 'bengong', 'SD Bakti', 'Asesmen Tumbuh Kembang, Asesmen Terpadu', NULL, NULL, '2026-01-30 14:08:32', '2026-01-30 14:08:32'),
('01kg7pmt7jmprrbd5ds2mvtzrk', '01kg7pmt7ax95686qc3x2mnk4z', 'malaikha', 'KLATEN', '2018-06-30', 'perempuan', 0x65794a7064694936496d744e616b4a4859315235525752464e6d35366433704e555646505248633950534973496e5a686248566c496a6f69596a4233646c6c6b4d44493154575632616e6c344d6e6c3156446c6b5a6a566c646d4a42566c6c3359576461527a553552487073633246454f4430694c434a7459574d694f694a684d546b3259544d324d574e684e6a41785932466a4e44426b4e6a51335954517959545977596a59345a5759355a5749325a6a4a6d5a6a466b4d6d466a4e54526a4e54686c4d545978597a4d354d6d526c5a475a6d496977696447466e496a6f69496e303d, 'sulit fokus', 'SD taruna bangsa', 'Asesmen Tumbuh Kembang, Konsultasi Dokter', NULL, NULL, '2026-01-30 14:59:17', '2026-01-30 14:59:17'),
('01kk6pc5p5yg2fvt3cebvs53ey', '01kk6pc5kdd8h6pzkspv9mqs3g', 'Zefanya Lidia', 'Surakarta', '2019-02-16', 'perempuan', 0x65794a7064694936496d46334d5535754f456c464e3270695a304a5961453952566d6c545a30453950534973496e5a686248566c496a6f694d44464d535551325130387751334a3459546458566d46355330353251543039496977696257466a496a6f694e5441354d6a566d5a5463324f44426d4d7a4a6b4d574d795a6a4a694e4755324e57566d5a4755335954673359574a6c5a4459314e32597a5a6d5930597a67334e546c684d3259795a47566b4e324d784e5755785a434973496e52685a79493649694a39, 'Sulit fokus, Suka bengong', 'SD Surakarta', 'Konsultasi Dokter, Tes Psikologi', NULL, NULL, '2026-03-08 12:22:25', '2026-03-08 12:22:25'),
('01kk6phvg2m5dpxg8j1sxv5j5f', '01kk6phvfvtgheqzd2fed00wth', 'Zefanya Lidia', 'Surakarta', '2019-02-16', 'perempuan', 0x65794a7064694936496a524b5345526b645764584f586b78656e633463544572536d6f726458633950534973496e5a686248566c496a6f69655746315a4739314e4759344e444648526b5a304d6d70534c79744b5a7a3039496977696257466a496a6f69596a49785a544a6b596d52694d4446684f4441784d4467315a6d4e6a4d3255774e7a4a694f546b785a44686859574e6b4d4451344f5442694f4441785a546468596d466b4d7a67354e4456694d325a694d7a566a4e434973496e52685a79493649694a39, 'Sulit fokus, Suka bengong', 'SD Surakarta', 'Konsultasi Dokter, Tes Psikologi', NULL, NULL, '2026-03-08 12:25:31', '2026-03-08 12:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `families`
--

CREATE TABLE `families` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `families`
--

INSERT INTO `families` (`id`, `created_at`, `updated_at`) VALUES
('01kg7kqwb45vby8by7mdyzh75p', '2026-01-30 14:08:32', '2026-01-30 14:08:32'),
('01kg7pmt7ax95686qc3x2mnk4z', '2026-01-30 14:59:17', '2026-01-30 14:59:17'),
('01kk6pc5kdd8h6pzkspv9mqs3g', '2026-03-08 12:22:25', '2026-03-08 12:22:25'),
('01kk6phvfvtgheqzd2fed00wth', '2026-03-08 12:25:31', '2026-03-08 12:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `guardians`
--

CREATE TABLE `guardians` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `family_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `temp_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_type` enum('ayah','ibu','wali') COLLATE utf8mb4_unicode_ci NOT NULL,
  `guardian_identity_number` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `guardian_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guardian_phone` blob NOT NULL,
  `guardian_birth_date` date DEFAULT NULL,
  `guardian_occupation` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `relationship_with_child` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guardians`
--

INSERT INTO `guardians` (`id`, `family_id`, `user_id`, `temp_email`, `guardian_type`, `guardian_identity_number`, `guardian_name`, `guardian_phone`, `guardian_birth_date`, `guardian_occupation`, `profile_picture`, `relationship_with_child`, `created_at`, `updated_at`) VALUES
('01kg7kqwb7etgjhh9wa2gc5yky', '01kg7kqwb45vby8by7mdyzh75p', '01kg7kwwgynqy08xsr2nmkz5n7', NULL, 'ibu', NULL, 'Devi Ema', 0x65794a7064694936496e684e634868444d6c6472523270565444424d556b3553566d6f795646453950534973496e5a686248566c496a6f696357647259325651557a6c34633078786447563453574e474d6a423155543039496977696257466a496a6f694f446331597a41355a5745324d6a5a68597a49774f5451354d4455794d575135595751774e6d457a4d325a6b4d544e6d4e32513559544e684d3245784d474533597a6b78597a63344d6d526c5a44426c4f4459775a434973496e52685a79493649694a39, NULL, NULL, NULL, NULL, '2026-01-30 14:08:32', '2026-01-30 14:11:16'),
('01kg7pmt7eyjawp7bde10xbdjt', '01kg7pmt7ax95686qc3x2mnk4z', '01kg7psrd9f5y5865r1a70r6zd', NULL, 'ibu', NULL, 'Annisanqh', 0x65794a7064694936496e457955476c4857475a4b4e4339795154466a5930315557556c706445453950534973496e5a686248566c496a6f69616d7772614464475647497861476473655778365a6b6445615774735a7a3039496977696257466a496a6f694d446b7a595752684f475530596a49795a474a694d7a63794f57457a5a6d526c5a5759345a6d59794e574d354e6a41324e7a52684e32566c4d6d4a684f544d325a44633259575269596a6b785a5441334d4455354e694973496e52685a79493649694a39, NULL, NULL, NULL, NULL, '2026-01-30 14:59:17', '2026-01-30 15:01:59'),
('01kk6pc5ngn6v1p3cfknpvbngt', '01kk6pc5kdd8h6pzkspv9mqs3g', NULL, 'aliefarifin99@gmail.com', 'ayah', NULL, 'Alief Arifin Mahardiko', 0x65794a7064694936496d317363564a75527a4e456546633363454e5a545868555a4656566446453950534973496e5a686248566c496a6f69546a5a5865446730625756485a555a4861575643636e426a517a465355543039496977696257466a496a6f694d324e6a4e7a526b4f4456685a6d5178595449304f4441324e5455355a6d52694e4749794f544e6c5a54673459544d325a6a466c4f444e684d5459774e32526c4d446377597a49334d7a4e6c4f546b7a596d4a6a4d694973496e52685a79493649694a39, NULL, NULL, NULL, NULL, '2026-03-08 12:22:25', '2026-03-08 12:22:25'),
('01kk6phvfy22jtbnznrhqcc99h', '01kk6phvfvtgheqzd2fed00wth', NULL, 'aliefarfn.dev@gmail.com', 'ayah', NULL, 'Alief Arifin Mahardiko', 0x65794a7064694936496c523453554a79546b4a70556e4674526d396d65587049564778356130453950534973496e5a686248566c496a6f69534763344e336c30656c67356179397163567072527a4a715557747251543039496977696257466a496a6f694d6a6377596a45355a475177595755344e4449785a6a4a6d59546b35596a677a4f57597859544d314f5459784d445a684e7a526a4d3245354d7a417a4f474d774d574d774d544d335a54466d5a5749774f546b354d794973496e52685a79493649694a39, NULL, NULL, NULL, NULL, '2026-03-08 12:25:31', '2026-03-08 12:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(2, '2025_09_26_000922_create_users_table', 1),
(3, '2025_09_26_020649_create_therapists_table', 1),
(4, '2025_09_26_210807_create_families_table', 1),
(5, '2025_09_26_210815_create_guardians_table', 1),
(6, '2025_09_26_211055_create_children_table', 1),
(7, '2025_09_26_211200_create_admins_table', 1),
(8, '2025_09_26_211213_create_observations_table', 1),
(9, '2025_09_27_101232_create_password_reset_tokens_table', 1),
(10, '2025_09_28_081707_create_observation_questions_table', 1),
(11, '2025_09_28_081801_create_observation_answers_table', 1),
(12, '2025_10_04_142227_create_assessments_table', 1),
(13, '2025_10_04_142230_create_assessment_details_table', 1),
(14, '2025_11_23_080525_create_assessment_question_groups_table', 1),
(15, '2025_11_23_082602_create_assessment_questions_table', 1),
(16, '2025_11_23_082612_create_assessment_answers_table', 1),
(17, '2025_12_15_205639_create_permission_tables', 1),
(19, '2026_03_08_191400_create_notifications_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', '01kg7kfn4s3rm4q4vpj3pwnx30'),
(2, 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz'),
(4, 'App\\Models\\User', '01kg7kfnszynwm83hwjagkvppk'),
(4, 'App\\Models\\User', '01kg7kfntv6jc2db9s0svzve82'),
(4, 'App\\Models\\User', '01kg7kfnv5rx502xj1abe726ka'),
(4, 'App\\Models\\User', '01kg7kfnvf394ntf47ct6kteeb'),
(3, 'App\\Models\\User', '01kg7kfp80e8123k0vmray5eww'),
(3, 'App\\Models\\User', '01kg7kfp8f4k5khkef0588wyfz'),
(3, 'App\\Models\\User', '01kg7kfp8x76srvb3z9ze9jnyk'),
(3, 'App\\Models\\User', '01kg7kfp9d11mqx565nva72m04'),
(5, 'App\\Models\\User', '01kg7kwwgynqy08xsr2nmkz5n7'),
(5, 'App\\Models\\User', '01kg7psrd9f5y5865r1a70r6zd');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `notifiable_type`, `notifiable_id`, `data`, `read_at`, `created_at`, `updated_at`) VALUES
('60b16c79-d5c1-4215-84bf-81109fc09165', 'App\\Notifications\\NewRegistrationNotification', 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz', '{\"child_id\":\"01kk6phvg2m5dpxg8j1sxv5j5f\",\"child_name\":\"Zefanya Lidia\",\"guardian_name\":\"Alief Arifin Mahardiko\",\"message\":\"Pendaftaran baru: Zefanya Lidia (Alief Arifin Mahardiko)\",\"type\":\"registration\"}', '2026-03-08 12:28:09', '2026-03-08 12:25:31', '2026-03-08 12:28:09');

-- --------------------------------------------------------

--
-- Table structure for table `observations`
--

CREATE TABLE `observations` (
  `id` bigint UNSIGNED NOT NULL,
  `child_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_id` char(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `therapist_id` char(26) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scheduled_date` datetime DEFAULT NULL,
  `age_category` enum('balita','anak-anak','remaja','lainya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_score` int DEFAULT NULL,
  `conclusion` text COLLATE utf8mb4_unicode_ci,
  `recommendation` text COLLATE utf8mb4_unicode_ci,
  `status` enum('pending','scheduled','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `completed_at` time DEFAULT NULL,
  `is_continued_to_assessment` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `observations`
--

INSERT INTO `observations` (`id`, `child_id`, `admin_id`, `therapist_id`, `scheduled_date`, `age_category`, `total_score`, `conclusion`, `recommendation`, `status`, `completed_at`, `is_continued_to_assessment`, `created_at`, `updated_at`) VALUES
(1, '01kg7kqwbcrx19k3vnmd76x1mt', '01kg7kfnaz9evpa3f792ytcsg1', '01kg7kfntgw3zp1mqqh0bmxxp8', '2026-01-30 22:00:00', 'balita', 23, 'sakit', 'sakit', 'completed', '21:09:58', 1, '2026-01-30 14:08:32', '2026-01-30 14:10:46'),
(2, '01kg7pmt7jmprrbd5ds2mvtzrk', '01kg7kfnaz9evpa3f792ytcsg1', '01kg7kfntgw3zp1mqqh0bmxxp8', '2026-02-07 21:00:00', 'anak-anak', 31, 'fghjkl', 'dfghj', 'completed', '22:01:10', 1, '2026-01-30 14:59:17', '2026-01-30 15:01:42'),
(3, '01kk6pc5p5yg2fvt3cebvs53ey', NULL, NULL, '2026-03-10 19:22:25', 'anak-anak', NULL, NULL, NULL, 'pending', NULL, 0, '2026-03-08 12:22:25', '2026-03-08 12:22:25'),
(4, '01kk6phvg2m5dpxg8j1sxv5j5f', NULL, NULL, '2026-03-10 19:25:31', 'anak-anak', NULL, NULL, NULL, 'pending', NULL, 0, '2026-03-08 12:25:31', '2026-03-08 12:25:31');

-- --------------------------------------------------------

--
-- Table structure for table `observation_answers`
--

CREATE TABLE `observation_answers` (
  `id` bigint UNSIGNED NOT NULL,
  `observation_id` bigint UNSIGNED NOT NULL,
  `question_id` bigint UNSIGNED NOT NULL,
  `answer` tinyint(1) NOT NULL,
  `score_earned` int NOT NULL DEFAULT '0',
  `note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `observation_answers`
--

INSERT INTO `observation_answers` (`id`, `observation_id`, `question_id`, `answer`, `score_earned`, `note`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, 3, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(2, 1, 2, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(3, 1, 3, 1, 2, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(4, 1, 4, 1, 3, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(5, 1, 5, 1, 3, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(6, 1, 6, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(7, 1, 7, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(8, 1, 8, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(9, 1, 9, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(10, 1, 10, 1, 1, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(11, 1, 11, 1, 2, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(12, 1, 12, 1, 2, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(13, 1, 13, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(14, 1, 14, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(15, 1, 15, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(16, 1, 16, 1, 2, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(17, 1, 17, 1, 2, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(18, 1, 18, 1, 3, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(19, 1, 19, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(20, 1, 20, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(21, 1, 21, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(22, 1, 22, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(23, 1, 23, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(24, 1, 24, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(25, 1, 25, 0, 0, NULL, '2026-01-30 14:09:58', '2026-01-30 14:09:58'),
(26, 2, 26, 1, 3, 'fghj', '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(27, 2, 27, 0, 0, 'bnm', '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(28, 2, 28, 1, 3, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(29, 2, 29, 0, 0, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(30, 2, 30, 1, 3, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(31, 2, 31, 1, 3, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(32, 2, 32, 1, 1, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(33, 2, 33, 1, 2, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(34, 2, 34, 0, 0, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(35, 2, 35, 1, 2, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(36, 2, 36, 0, 0, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(37, 2, 37, 1, 1, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(38, 2, 38, 1, 2, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(39, 2, 39, 1, 3, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(40, 2, 40, 1, 2, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(41, 2, 41, 0, 0, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(42, 2, 42, 0, 0, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(43, 2, 43, 0, 0, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(44, 2, 44, 1, 1, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(45, 2, 45, 1, 1, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(46, 2, 46, 1, 2, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(47, 2, 47, 1, 1, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(48, 2, 48, 1, 1, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10'),
(49, 2, 49, 0, 0, NULL, '2026-01-30 15:01:10', '2026-01-30 15:01:10');

-- --------------------------------------------------------

--
-- Table structure for table `observation_questions`
--

CREATE TABLE `observation_questions` (
  `id` bigint UNSIGNED NOT NULL,
  `question_code` varchar(6) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age_category` enum('balita','anak-anak','remaja','lainya') COLLATE utf8mb4_unicode_ci NOT NULL,
  `question_number` int NOT NULL,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `score` int NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `observation_questions`
--

INSERT INTO `observation_questions` (`id`, `question_code`, `age_category`, `question_number`, `question_text`, `score`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'BPE-01', 'balita', 1, 'Hipoaktif atau bergerak tidak bertujuan', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(2, 'BPE-02', 'balita', 2, 'Hipoaktif atau lamban gerak', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(3, 'BPE-03', 'balita', 3, 'Tidak mampu mengikuti aturan', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(4, 'BPE-04', 'balita', 4, 'Menyakiti diri sendiri atau menyerang orang lain ketika marah', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(5, 'BPE-05', 'balita', 5, 'Perilaku repetitif atau berulang-ulang', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(6, 'BPE-06', 'balita', 6, 'Tidak dapat duduk tenang', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(7, 'BPE-07', 'balita', 7, 'Anak Jalan jinjit', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(8, 'BFM-01', 'balita', 8, 'Kelainan pada anggota tubuh atau pemakaian alat bantu', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(9, 'BFM-02', 'balita', 9, 'Tidak mampu melompat', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(10, 'BFM-03', 'balita', 10, 'Tidak mampu mengikuti contoh gerakan seperti senam', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(11, 'BFM-04', 'balita', 11, 'Tidak mampu membuat bentuk sederhana dari playdough', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(12, 'BFM-05', 'balita', 12, 'Tidak mampu merobek kertas', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(13, 'BBB-01', 'balita', 13, 'Saat ditanya mengulang pertanyaan atau perkataan', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(14, 'BBB-02', 'balita', 14, 'Tidak mampu memahami perintah/instruksi', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(15, 'BBB-03', 'balita', 15, 'Tidak mampu berkomunikasi 2 arah/tanya jawab', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(16, 'BKA-01', 'balita', 16, 'Tidak mampu menyelesaikan aktifitas', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(17, 'BKA-02', 'balita', 17, 'Tidak mampu mempertahankan atensi dan konsentrasi ketika diberi tugas', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(18, 'BKA-03', 'balita', 18, 'Tidak mampu menyebutkan identitas diri dan anggota keluarga', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(19, 'BKA-04', 'balita', 19, 'Tidak mampu menamai benda sekitar', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(20, 'BKA-05', 'balita', 20, 'Tidak mampu menyebutkan angka 1-5', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(21, 'BKA-06', 'balita', 21, 'Tidak mampu mengidentifikasi bentuk (minimal 1 bentuk konsisten)', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(22, 'BKA-07', 'balita', 22, 'Tidak mampu mengidentifikasi warna primer', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(23, 'BS-01', 'balita', 23, 'Tidak ada kontak mata/kontak mata minim saat diajak berbicara', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(24, 'BS-02', 'balita', 24, 'Suka menyendiri', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(25, 'BS-03', 'balita', 25, 'Kesulitan beradaptasi dengan lingkungan baru', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(26, 'APE-01', 'anak-anak', 1, 'Hiperaktif atau bergerak tidak bertujuan', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(27, 'APE-02', 'anak-anak', 2, 'Hiperaktif atau lamban gerak', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(28, 'APE-03', 'anak-anak', 3, 'Tidak mampu mengikuti aturan', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(29, 'APE-04', 'anak-anak', 4, 'Menyakiti diri sendiri atau menyerang orang lain ketika marah', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(30, 'APE-05', 'anak-anak', 5, 'Perilaku Repetitif atau berulang-ulang', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(31, 'APE-06', 'anak-anak', 6, 'Tidak dapat duduk tenang', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(32, 'AFM-01', 'anak-anak', 7, 'Kelainan pada anggota tubuh atau pemakaian alat bantu', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(33, 'AFM-02', 'anak-anak', 8, 'Tidak mampu melompat', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(34, 'AFM-03', 'anak-anak', 9, 'Tidak mampu mengikuti contoh gerakan seperti senam', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(35, 'AFM-04', 'anak-anak', 10, 'Tidak mampu menggunting', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(36, 'AFM-05', 'anak-anak', 11, 'Tidak mampu melipat kertas', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(37, 'ABB-01', 'anak-anak', 12, 'Saat ditanya Mengulang pertanyaan atau perkataan', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(38, 'ABB-02', 'anak-anak', 13, 'Tidak mampu memahami perintah/instruksi', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(39, 'ABB-03', 'anak-anak', 14, 'Tidak mampu berkomunikasi 2 arah/tanya jawab', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(40, 'AKA-01', 'anak-anak', 15, 'Tidak mampu menyelesaikan tugas', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(41, 'AKA-02', 'anak-anak', 16, 'Tidak mampu mempertahankan atensi dan konsentrasi ketika diberi tugas', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(42, 'AKA-03', 'anak-anak', 17, 'Tidak mampu menyebutkan identitas diri dan anggota keluarga', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(43, 'AKA-04', 'anak-anak', 18, 'Tidak mampu menamai benda sekitar', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(44, 'AKA-05', 'anak-anak', 19, 'Tidak mampu mengurutkan angka 1-10', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(45, 'AKA-06', 'anak-anak', 20, 'Tidak mampu mengurutkan abjad A-Z', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(46, 'AS-01', 'anak-anak', 21, 'Tidak ada kontak mata/kontak mata minim saat diajak berbicara', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(47, 'AS-02', 'anak-anak', 22, 'Suka menyendiri', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(48, 'AS-03', 'anak-anak', 23, 'Tidak mau berbagi dengan teman/egois', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(49, 'AS-04', 'anak-anak', 24, 'Kesulitan beradaptasi dengan lingkungan baru', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(50, 'RPE-01', 'remaja', 1, 'Hiperaktif atau bergerak tidak bertujuan', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(51, 'RPE-02', 'remaja', 2, 'Hipoaktif atau lamban gerak', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(52, 'RPE-03', 'remaja', 3, 'Tidak mampu mengikuti aturan', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(53, 'RPE-04', 'remaja', 4, 'Menyakiti diri sendiri atau menyerang orang lain', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(54, 'RPE-05', 'remaja', 5, 'Perilaku Repetitif atau berulang-ulang', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(55, 'RPE-06', 'remaja', 6, 'Tidak dapat duduk tenang', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(56, 'RPE-07', 'remaja', 7, 'Ketertarikan berlebih terhadap lawan jenis', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(57, 'RPE-08', 'remaja', 8, 'Emosi yang meledak-ledak', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(58, 'RFM-01', 'remaja', 9, 'Kelainan pada anggota tubuh atau pemakaian alat bantu', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(59, 'RFM-02', 'remaja', 10, 'Tidak mampu menganyam', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(60, 'RBB-01', 'remaja', 11, 'Saat ditanya mengulang pertanyaan atau perkataan', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(61, 'RBB-02', 'remaja', 12, 'Tidak mampu memahami perintah/instruksi tiga tahap', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(62, 'RBB-03', 'remaja', 13, 'Tidak mampu berkomunikasi 2 arah/tanya jawab', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(63, 'RKA-01', 'remaja', 14, 'Tidak mampu menyelesaikan tugas', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(64, 'RKA-02', 'remaja', 15, 'Tidak mampu mempertahankan atensi dan konsentrasi ketika diberi tugas', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(65, 'RKA-03', 'remaja', 16, 'Tidak mampu menceritakan diri sendiri', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(66, 'RKA-04', 'remaja', 17, 'Tidak mampu operasi hitung sederhana', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(67, 'RKA-05', 'remaja', 18, 'Tidak mampu membaca paragraf sederhana', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(68, 'RS-01', 'remaja', 19, 'Tidak ada kontak mata/kontak mata minim saat diajak berbicara', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(69, 'RS-02', 'remaja', 20, 'Suka menyendiri', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(70, 'RS-03', 'remaja', 21, 'Kesulitan beradaptasi dengan lingkungan baru', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(71, 'RK-01', 'remaja', 22, 'Tidak bisa mengancing baju sendiri', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(72, 'RK-02', 'remaja', 23, 'Tidak bisa toilet training', 3, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(73, 'RK-03', 'remaja', 24, 'Tidak berpenampilan rapi dan sopan', 1, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
(74, 'RK-04', 'remaja', 25, 'Tidak mengenal mata uang', 2, 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'show_unverified_admins', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(2, 'show_unverified_therapists', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(3, 'verified_user', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(4, 'rejected_user', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(5, 'show_admins', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(6, 'show_detail_admin', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(7, 'add_admin', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(8, 'edit_admin', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(9, 'delete_admin', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(10, 'show_therapists', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(11, 'show_detail_therapist', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(12, 'add_therapist', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(13, 'edit_therapist', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(14, 'delete_therapist', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(15, 'show_children', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(16, 'show_detail_child', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(17, 'edit_child', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(18, 'delete_child', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(19, 'show_observations', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(20, 'show_detail_observation', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(21, 'edit_schedule_observation', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(22, 'submit_observation', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(23, 'show_observation_answer', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(24, 'show_observation_summary', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(25, 'set_assessment', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(26, 'show_assessments', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(27, 'show_detail_assessment', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(28, 'show_own_children_assessment', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(29, 'show_own_child_detail_assessment', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(30, 'show_assessor_assessment_answer', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(31, 'show_parent_assessment_answer', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(32, 'edit_schedule_assessment', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(33, 'submit_assessment', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(34, 'submit_parent_assessment', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(35, 'upload_report_assessment_file', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(36, 'download_child_report_assessment_file', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz', 'api-token', 'b9e78e255c12ce6b86a90990ad0937ac504000085ec7e4d2ca4e85801d51d61a', '[\"*\"]', '2026-01-30 14:08:39', '2026-01-30 16:06:07', '2026-01-30 14:06:07', '2026-01-30 14:08:39'),
(2, 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz', 'api-token', 'f56243b9f98a9247c86e1c70a336fd37029f8092404184d82c7c4e62a684eb18', '[\"*\"]', '2026-01-30 14:09:07', '2026-01-30 16:08:39', '2026-01-30 14:08:39', '2026-01-30 14:09:07'),
(3, 'App\\Models\\User', '01kg7kfnszynwm83hwjagkvppk', 'api-token', 'e85bbd477a9a9f78d99786d3d96b7c0347a0108b7b8f3b576bf2eedc2e283ae1', '[\"*\"]', '2026-01-30 14:10:08', '2026-01-30 16:09:08', '2026-01-30 14:09:08', '2026-01-30 14:10:08'),
(4, 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz', 'api-token', 'b73b9639dc5c3b48736de2f6510a7c8fc0bfc90f70e85dffb44e397dbc9e6607', '[\"*\"]', '2026-01-30 14:11:53', '2026-01-30 16:10:08', '2026-01-30 14:10:08', '2026-01-30 14:11:53'),
(5, 'App\\Models\\User', '01kg7kwwgynqy08xsr2nmkz5n7', 'api-token', 'b1f13d3b8f2edceab9d6f005384541b038bb56bb8bb85910304eab09acad8fd7', '[\"*\"]', '2026-01-30 14:11:55', '2026-01-30 16:11:53', '2026-01-30 14:11:53', '2026-01-30 14:11:55'),
(6, 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz', 'api-token', 'f8cba3f3a5c53019a51b5d135fd3baef5de18c7150b4488b2c17da330d1ebb7b', '[\"*\"]', '2026-01-30 14:59:59', '2026-01-30 16:59:26', '2026-01-30 14:59:26', '2026-01-30 14:59:59'),
(7, 'App\\Models\\User', '01kg7kfnszynwm83hwjagkvppk', 'api-token', 'a548453c6f7c9fd2e72237522b14073ee5f6fa5d17de7072e776d28e15c47d4e', '[\"*\"]', '2026-01-30 15:01:24', '2026-01-30 16:59:59', '2026-01-30 14:59:59', '2026-01-30 15:01:24'),
(8, 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz', 'api-token', '18eb98c444e78bfae9516b214f31723df00adb5e981e987ea200ddfb665ea22b', '[\"*\"]', '2026-01-30 15:02:33', '2026-01-30 17:01:24', '2026-01-30 15:01:24', '2026-01-30 15:02:33'),
(9, 'App\\Models\\User', '01kg7psrd9f5y5865r1a70r6zd', 'api-token', '79ee29181eaef365aeaff3a836562b5c8a3d7c9c70f5005b7286a52280c660d3', '[\"*\"]', '2026-01-30 15:04:49', '2026-01-30 17:02:33', '2026-01-30 15:02:33', '2026-01-30 15:04:49'),
(10, 'App\\Models\\User', '01kg7psrd9f5y5865r1a70r6zd', 'api-token', 'b653e970c9e35fe6c79e975f55180148f964f352e7e0c1a3c887704ff45f8a0d', '[\"*\"]', '2026-01-30 15:09:44', '2026-01-30 17:04:49', '2026-01-30 15:04:49', '2026-01-30 15:09:44'),
(11, 'App\\Models\\User', '01kg7psrd9f5y5865r1a70r6zd', 'api-token', 'e26d54a309f63c5907dac0fcbe7823a235b79f85534dfeea1af75cf84795cedd', '[\"*\"]', '2026-01-30 15:07:53', '2026-01-30 17:07:09', '2026-01-30 15:07:09', '2026-01-30 15:07:53'),
(12, 'App\\Models\\User', '01kg7kfp80e8123k0vmray5eww', 'api-token', '66b8d668df8af31b3c75973947255f9579930b88c7320b91ca05f982aea2b355', '[\"*\"]', '2026-01-30 15:08:36', '2026-01-30 17:07:53', '2026-01-30 15:07:53', '2026-01-30 15:08:36'),
(13, 'App\\Models\\User', '01kg7kwwgynqy08xsr2nmkz5n7', 'api-token', '594965df32f54831441d1083d32001dcabc7b95dbe7ae36fe2e4c1ff3c93465a', '[\"*\"]', '2026-01-30 15:08:50', '2026-01-30 17:08:36', '2026-01-30 15:08:36', '2026-01-30 15:08:50'),
(14, 'App\\Models\\User', '01kg7psrd9f5y5865r1a70r6zd', 'api-token', '5df3e9df91ba4adf8f0b414f39d42057c245327489d5e0c7c510df8295cb5c37', '[\"*\"]', '2026-01-30 15:14:39', '2026-01-30 17:09:44', '2026-01-30 15:09:44', '2026-01-30 15:14:39'),
(15, 'App\\Models\\User', '01kg7kwwgynqy08xsr2nmkz5n7', 'api-token', '87cce13b3b6b9423a7ad9ee19e62684449b55a949c0e07a7b924ca3376f0bbad', '[\"*\"]', '2026-01-30 15:15:05', '2026-01-30 17:14:39', '2026-01-30 15:14:39', '2026-01-30 15:15:05'),
(16, 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz', 'api-token', 'b893ef3e4c53ad21b768ffbf5df196f631d8a7f33df5eff224fb9be70dd9735d', '[\"*\"]', '2026-01-31 02:09:38', '2026-01-31 04:08:04', '2026-01-31 02:08:04', '2026-01-31 02:09:38'),
(17, 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz', 'api-token', 'b3dc523dbd0aad465aa26b55ecfea83ede71ce1c2e4641485e0695af6e06b9cb', '[\"*\"]', NULL, '2026-03-08 14:09:43', '2026-03-08 12:09:43', '2026-03-08 12:09:43'),
(18, 'App\\Models\\User', '01kg7kfnasqyygb0n3g878wnvz', 'api-token', 'c583e21a756d6e66a9e7c82c8a14cda96459eb22779b303bcf5e25ccc7dcc745', '[\"*\"]', '2026-03-08 12:29:26', '2026-03-08 14:22:01', '2026-03-08 12:22:01', '2026-03-08 12:29:26');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'owner', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(2, 'admin', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(3, 'asesor', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(4, 'terapis', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02'),
(5, 'user', 'api', '2026-01-30 14:04:02', '2026-01-30 14:04:02');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint UNSIGNED NOT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(5, 1),
(6, 1),
(10, 1),
(11, 1),
(15, 1),
(16, 1),
(5, 2),
(6, 2),
(7, 2),
(8, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(30, 2),
(31, 2),
(32, 2),
(35, 2),
(19, 3),
(20, 3),
(22, 3),
(23, 3),
(24, 3),
(26, 3),
(27, 3),
(30, 3),
(31, 3),
(33, 3),
(35, 3),
(19, 4),
(20, 4),
(22, 4),
(23, 4),
(24, 4),
(17, 5),
(18, 5),
(28, 5),
(29, 5),
(31, 5),
(34, 5),
(36, 5);

-- --------------------------------------------------------

--
-- Table structure for table `therapists`
--

CREATE TABLE `therapists` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `therapist_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `therapist_section` enum('okupasi','fisio','wicara','paedagog') COLLATE utf8mb4_unicode_ci NOT NULL,
  `therapist_phone` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `therapist_birth_date` date DEFAULT NULL,
  `profile_picture` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `therapists`
--

INSERT INTO `therapists` (`id`, `user_id`, `therapist_name`, `therapist_section`, `therapist_phone`, `therapist_birth_date`, `profile_picture`, `created_at`, `updated_at`) VALUES
('01kg7kfntgw3zp1mqqh0bmxxp8', '01kg7kfnszynwm83hwjagkvppk', 'Nindya Zahri', 'fisio', 'eyJpdiI6IkhNSU1YWkRGNWdhTmR0UXIzUmIzOEE9PSIsInZhbHVlIjoiNzdkcTgzdVFjSHJiTUx2bnJYMXNLZz09IiwibWFjIjoiNGQ2NWU3NzlhNDA3ZWJkNmMyZTZkOTJkZDY5MjJiNjNjZDg1ZmMwYmNjY2YyZWNiNjM5MjRmY2FjZWZhZDYyYyIsInRhZyI6IiJ9', '2004-01-30', NULL, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfntxevb7ns8sw91ark37', '01kg7kfntv6jc2db9s0svzve82', 'Alfian Plumek', 'okupasi', 'eyJpdiI6InM4OFVYNVB4Q3BzL3ZzYnR1QnZRQ1E9PSIsInZhbHVlIjoicUU0MHYwRG1Day9YY0QraHNBKzJNQT09IiwibWFjIjoiNTU1Yzc3YTYwZTlkNWU1M2UxMGE3ZTgxOGUyZWZiM2Q3MGM4ZGU4Y2RhYjE4ZDAzNWNiZmZkN2E2OTcwZGRiOSIsInRhZyI6IiJ9', '1990-01-30', NULL, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfnv7rg6g6txxkhn7709y', '01kg7kfnv5rx502xj1abe726ka', 'Rano Karno', 'wicara', 'eyJpdiI6InJnU1I5TmxVdFNaMHZUMmN0Yi9RNGc9PSIsInZhbHVlIjoibFdxS05BZE5QRXdFRXlBQys4K2tkUT09IiwibWFjIjoiMDgxNjczNzA3YjM3MGI5ZGNiNDU2OGQ4YTQ1ODk0Njc1NzVlN2YxMzRmMWViNTgwYmI5NmM1YzE1YjEzN2E2NCIsInRhZyI6IiJ9', '1994-01-30', NULL, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfnvj8jdxnzhcp8rvmvzc', '01kg7kfnvf394ntf47ct6kteeb', 'Adit Tolongin', 'paedagog', 'eyJpdiI6IkpTYmtEOHBPQkFHYkVTZEtNZ3ZWWVE9PSIsInZhbHVlIjoiZjUzMXdyYkIvV2wzdkp2UURjTWV5QT09IiwibWFjIjoiODJhN2JhNTAzZTg0ODAyMGZkMDBhNjA2ODEyNzhiODM2M2I4Yjk4ZGMyMDY0OTg2NDk1NzAwMmI2NzQ3NWMwMSIsInRhZyI6IiJ9', '1999-01-30', NULL, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfp832x628xgh5tben0f2', '01kg7kfp80e8123k0vmray5eww', 'Alief Arifun', 'okupasi', 'eyJpdiI6IkFCV0wxSWNiaUhDY1VzTEIxY2tCSVE9PSIsInZhbHVlIjoiTkQya2xVWEVNTk0ycnNQelNhZk9odz09IiwibWFjIjoiZTNjNmZkNGI5MTE3NzVmYzQwZmY1OTRhZjBhMWJjNmZmYzQyMWNmMTU1ZGI2MjYyY2UyYjQxOWIwODhhYWY2ZiIsInRhZyI6IiJ9', '2002-01-30', NULL, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
('01kg7kfp8h9zmdysngaqtpa0qz', '01kg7kfp8f4k5khkef0588wyfz', 'Zamzam Berli', 'fisio', 'eyJpdiI6Ikppa0RDVW5STGF1ekdSNGEzaU01eVE9PSIsInZhbHVlIjoiK0pGS3lvTEZRZElwS292Vm11QlVpdz09IiwibWFjIjoiMDQzYjI0ZjgxYjc2NjhkMjNkYTYzMzI1ZjVkODE5MTJkMmMwZTQ3NzA2NDAyODZmOGVmMjA1YjE0NzFjMjE4MCIsInRhZyI6IiJ9', '1995-01-30', NULL, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
('01kg7kfp9067y7jy55jg877cmd', '01kg7kfp8x76srvb3z9ze9jnyk', 'Ema Emi', 'wicara', 'eyJpdiI6IndqbUF3SGs3ODVOQkVqZWRPM01sbmc9PSIsInZhbHVlIjoiVmw0K0J2UzZKYmZNSUF5emhZd0pHdz09IiwibWFjIjoiMTcyMGZiYTE3Y2RjZTRiODUzNDljMzhlOGI2YmViMmIyYTU2YTdjYTlhYzJiN2Q3MDNiNzc4YTgwMzNiNTk1MyIsInRhZyI6IiJ9', '1987-01-30', NULL, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
('01kg7kfp9gaqkb78zcd6zem2xe', '01kg7kfp9d11mqx565nva72m04', 'Rendra Prasetyo', 'paedagog', 'eyJpdiI6InJpZksvWnE2Sy9RdDZYbUZPZi9NMlE9PSIsInZhbHVlIjoiNEhzaEgycDE4bXA1cWJMdXU2aW41Zz09IiwibWFjIjoiYTM2YjY5ZDExZTU2OTYwMzY1YTVmYjkxNTAzNDBjMDczNTA2ZWJiYThmZjFmNTEyOTUyZmEwYjM5MWM5MTQzZiIsInRhZyI6IiJ9', '1999-01-30', NULL, '2026-01-30 14:04:04', '2026-01-30 14:04:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` char(26) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `email_verified_at`, `is_active`, `created_at`, `updated_at`) VALUES
('01kg7kfn4s3rm4q4vpj3pwnx30', 'ownerPuspa', 'owner@puspa.com', '$2y$10$TBp0xQwxYZ5d9kHNohjb8u4rHcEbaE5vi7vGp494vTpFFHOgx.Y2W', '2026-01-30 14:04:03', 1, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfnasqyygb0n3g878wnvz', 'adminAnnisa', 'annisa@admin.com', '$2y$10$X6mxuFwcj64WGHOp9ofVyOFOyyx7j.xxi2bL3WKfWRQukCqO/D0tS', '2026-01-30 14:04:03', 1, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfnszynwm83hwjagkvppk', 'fisioNindya', 'nindya@terapis.com', '$2y$10$SD.XnBBloE/Kz4f4CZwAIeAecLtDvrMxMFQH4i7/9qg7ecnkcPTpm', '2026-01-30 14:04:03', 1, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfntv6jc2db9s0svzve82', 'okupasiAlfian', 'alfian@terapis.com', '$2y$10$3bZD6kktPPE88Zls.5BtxOMMRC0YwRyfx63sxJ16vN.LE7MYGUZOW', '2026-01-30 14:04:03', 1, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfnv5rx502xj1abe726ka', 'wicaraRano', 'rano@terapis.com', '$2y$10$FUBzjM264GwdpzfMxBaQK.zCES90f0i36lRT0iKsfjPKtgHw9r8i6', '2026-01-30 14:04:03', 1, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfnvf394ntf47ct6kteeb', 'paedagogAdit', 'adit@terapis.com', '$2y$10$g7UyP103v.RseUNYWugYIOShE7vXKR89xNo9TphYws3ZRgr.zHyZW', '2026-01-30 14:04:03', 1, '2026-01-30 14:04:03', '2026-01-30 14:04:03'),
('01kg7kfp80e8123k0vmray5eww', 'okupasiAlief', 'alief@terapis.com', '$2y$10$/2Y2D8H1Sh5l3eyiLeZtNO0iiJ9KoQ3db5Abea.LBXX1YXLdOy2mO', '2026-01-30 14:04:04', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
('01kg7kfp8f4k5khkef0588wyfz', 'fisioZamzam', 'zamzam@admin.com', '$2y$10$qa28243Dur3HlWOaphC/7OtgIZDWhUF65gwncYv7eJJs9c75avsE6', '2026-01-30 14:04:04', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
('01kg7kfp8x76srvb3z9ze9jnyk', 'wicaraEma', 'ema@admin.com', '$2y$10$h1FvtWeg72YsuRaLPyl6Q.7/ExDzuh81GNUejYiE78r1ziu/LlCKW', '2026-01-30 14:04:04', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
('01kg7kfp9d11mqx565nva72m04', 'paedagogRendra', 'rendra@admin.com', '$2y$10$gtc4HT9fdzBEl81pj9FJpOaXQia/UM60AGHG3hxF3//51.thHt0ai', '2026-01-30 14:04:04', 1, '2026-01-30 14:04:04', '2026-01-30 14:04:04'),
('01kg7kwwgynqy08xsr2nmkz5n7', 'deviema', 'deviiemaaa@gmail.com', '$2y$10$MHRV8EntJuoTIzCbZP1/h.uGMiLrM9GkdhctucDaeJ4Hhrmvt6Eea', '2026-01-30 14:11:44', 1, '2026-01-30 14:11:16', '2026-01-30 14:11:44'),
('01kg7psrd9f5y5865r1a70r6zd', 'Annisanqh', 'annisanurqoriah12@gmail.com', '$2y$10$T08ydLGFjKW0.00OaoFpzeiVSpkpwgg2mDH4qOKaCNYPJwqqR7Ioe', '2026-01-30 15:02:26', 1, '2026-01-30 15:01:59', '2026-01-30 15:02:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id_idx` (`user_id`);

--
-- Indexes for table `assessments`
--
ALTER TABLE `assessments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessments_child_id_index` (`child_id`),
  ADD KEY `assessments_status_scheduled_date_index` (`status`,`scheduled_date`),
  ADD KEY `assessments_scheduled_date_index` (`scheduled_date`),
  ADD KEY `assessments_parent_status_index` (`parent_status`),
  ADD KEY `assessments_created_at_index` (`created_at`),
  ADD KEY `assessments_observation_id_index` (`observation_id`);

--
-- Indexes for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_answers_assessment_detail_id_index` (`assessment_detail_id`),
  ADD KEY `assessment_answers_type_index` (`type`),
  ADD KEY `assessment_answers_question_id_index` (`question_id`);

--
-- Indexes for table `assessment_details`
--
ALTER TABLE `assessment_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_details_admin_id_foreign` (`admin_id`),
  ADD KEY `assessment_details_assessment_id_index` (`assessment_id`),
  ADD KEY `assessment_details_type_completed_at_index` (`type`,`completed_at`),
  ADD KEY `assessment_details_created_at_index` (`created_at`),
  ADD KEY `assessment_details_completed_at_index` (`completed_at`),
  ADD KEY `assessment_details_therapist_id_index` (`therapist_id`);

--
-- Indexes for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `assessment_questions_question_code_unique` (`question_code`),
  ADD KEY `assessment_questions_group_id_index` (`group_id`),
  ADD KEY `assessment_questions_assessment_type_index` (`assessment_type`),
  ADD KEY `assessment_questions_section_index` (`section`);

--
-- Indexes for table `assessment_question_groups`
--
ALTER TABLE `assessment_question_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assessment_question_groups_assessment_type_index` (`assessment_type`),
  ADD KEY `assessment_question_groups_group_key_index` (`group_key`),
  ADD KEY `assessment_question_groups_sort_order_index` (`sort_order`);

--
-- Indexes for table `children`
--
ALTER TABLE `children`
  ADD PRIMARY KEY (`id`),
  ADD KEY `children_family_id_index` (`family_id`),
  ADD KEY `children_child_name_index` (`child_name`),
  ADD KEY `children_created_at_index` (`created_at`);

--
-- Indexes for table `families`
--
ALTER TABLE `families`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guardians`
--
ALTER TABLE `guardians`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `guardians_temp_email_unique` (`temp_email`),
  ADD UNIQUE KEY `guardians_guardian_identity_number_unique` (`guardian_identity_number`),
  ADD KEY `guardians_family_id_index` (`family_id`),
  ADD KEY `guardians_user_id_index` (`user_id`),
  ADD KEY `guardians_temp_email_index` (`temp_email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`);

--
-- Indexes for table `observations`
--
ALTER TABLE `observations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `observations_admin_id_foreign` (`admin_id`),
  ADD KEY `observations_child_id_status_index` (`child_id`,`status`),
  ADD KEY `observations_status_scheduled_date_index` (`status`,`scheduled_date`),
  ADD KEY `observations_scheduled_date_index` (`scheduled_date`),
  ADD KEY `observations_created_at_index` (`created_at`),
  ADD KEY `observations_therapist_id_index` (`therapist_id`);

--
-- Indexes for table `observation_answers`
--
ALTER TABLE `observation_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `observation_answers_observation_id_foreign` (`observation_id`),
  ADD KEY `observation_answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `observation_questions`
--
ALTER TABLE `observation_questions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `observation_questions_age_category_question_number_unique` (`age_category`,`question_number`),
  ADD UNIQUE KEY `observation_questions_question_code_unique` (`question_code`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `therapists`
--
ALTER TABLE `therapists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `therapists_user_id_index` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `username_email_idx` (`username`,`email`),
  ADD KEY `users_is_active_index` (`is_active`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessments`
--
ALTER TABLE `assessments`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_details`
--
ALTER TABLE `assessment_details`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_question_groups`
--
ALTER TABLE `assessment_question_groups`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `observations`
--
ALTER TABLE `observations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `observation_answers`
--
ALTER TABLE `observation_answers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `observation_questions`
--
ALTER TABLE `observation_questions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins`
--
ALTER TABLE `admins`
  ADD CONSTRAINT `admins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessments`
--
ALTER TABLE `assessments`
  ADD CONSTRAINT `assessments_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessments_observation_id_foreign` FOREIGN KEY (`observation_id`) REFERENCES `observations` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_answers`
--
ALTER TABLE `assessment_answers`
  ADD CONSTRAINT `assessment_answers_assessment_detail_id_foreign` FOREIGN KEY (`assessment_detail_id`) REFERENCES `assessment_details` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessment_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `assessment_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `assessment_details`
--
ALTER TABLE `assessment_details`
  ADD CONSTRAINT `assessment_details_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `assessment_details_assessment_id_foreign` FOREIGN KEY (`assessment_id`) REFERENCES `assessments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `assessment_details_therapist_id_foreign` FOREIGN KEY (`therapist_id`) REFERENCES `therapists` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `assessment_questions`
--
ALTER TABLE `assessment_questions`
  ADD CONSTRAINT `assessment_questions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `assessment_question_groups` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `children`
--
ALTER TABLE `children`
  ADD CONSTRAINT `children_family_id_foreign` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `guardians`
--
ALTER TABLE `guardians`
  ADD CONSTRAINT `guardians_family_id_foreign` FOREIGN KEY (`family_id`) REFERENCES `families` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `guardians_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `observations`
--
ALTER TABLE `observations`
  ADD CONSTRAINT `observations_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `observations_child_id_foreign` FOREIGN KEY (`child_id`) REFERENCES `children` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `observations_therapist_id_foreign` FOREIGN KEY (`therapist_id`) REFERENCES `therapists` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `observation_answers`
--
ALTER TABLE `observation_answers`
  ADD CONSTRAINT `observation_answers_observation_id_foreign` FOREIGN KEY (`observation_id`) REFERENCES `observations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `observation_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `observation_questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `therapists`
--
ALTER TABLE `therapists`
  ADD CONSTRAINT `therapists_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
