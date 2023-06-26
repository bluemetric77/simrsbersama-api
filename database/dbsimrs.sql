/*
 Navicat Premium Data Transfer

 Source Server         : MariaDB (localhost)
 Source Server Type    : MariaDB
 Source Server Version : 110002 (11.0.2-MariaDB)
 Source Host           : localhost:3306
 Source Schema         : dbsimrs

 Target Server Type    : MariaDB
 Target Server Version : 110002 (11.0.2-MariaDB)
 File Encoding         : 65001

 Date: 26/06/2023 11:18:40
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for m_bed
-- ----------------------------
DROP TABLE IF EXISTS `m_bed`;
CREATE TABLE `m_bed` (
  `sysid` int(11) NOT NULL,
  `warrd_sysid` int(11) DEFAULT NULL,
  `room_sysid` int(11) DEFAULT NULL,
  `bed_number` varchar(10) DEFAULT NULL,
  `is_temporary` varchar(5) DEFAULT NULL,
  `is_occupance` varchar(5) DEFAULT NULL,
  `bed_status` varchar(25) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `uuid_rec` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_bed
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_class
-- ----------------------------
DROP TABLE IF EXISTS `m_class`;
CREATE TABLE `m_class` (
  `sysid` int(11) NOT NULL,
  `price_code` varchar(20) DEFAULT NULL,
  `descriptions` varchar(100) DEFAULT NULL,
  `sort_name` varchar(50) DEFAULT NULL,
  `factor_inpatient` decimal(18,2) DEFAULT NULL,
  `factor_service` decimal(18,2) DEFAULT NULL,
  `factor_pharmacy` decimal(18,2) DEFAULT NULL,
  `is_base_price` varchar(5) DEFAULT NULL,
  `is_price_class` varchar(5) DEFAULT NULL,
  `is_service_class` varchar(5) DEFAULT NULL,
  `is_pharmacy_class` varchar(5) DEFAULT NULL,
  `is_bpjs_class` varchar(5) DEFAULT NULL,
  `minimum_deposit` decimal(18,2) DEFAULT NULL COMMENT '0',
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_class
-- ----------------------------
BEGIN;
INSERT INTO `m_class` (`sysid`, `price_code`, `descriptions`, `sort_name`, `factor_inpatient`, `factor_service`, `factor_pharmacy`, `is_base_price`, `is_price_class`, `is_service_class`, `is_pharmacy_class`, `is_bpjs_class`, `minimum_deposit`, `update_userid`, `create_date`, `update_date`) VALUES (8, '02', 'Kelas 2', 'II', 100.00, 100.00, 100.00, '0', '1', '1', '0', '0', 0.00, 'demo@gmail.com', NULL, '2022-10-04 21:24:39');
INSERT INTO `m_class` (`sysid`, `price_code`, `descriptions`, `sort_name`, `factor_inpatient`, `factor_service`, `factor_pharmacy`, `is_base_price`, `is_price_class`, `is_service_class`, `is_pharmacy_class`, `is_bpjs_class`, `minimum_deposit`, `update_userid`, `create_date`, `update_date`) VALUES (9, '03', 'Kelas 3', '3', 100.00, 100.00, 100.00, '1', '1', '0', '0', '0', 0.00, 'demo@gmail.com', NULL, '2022-10-07 10:27:00');
INSERT INTO `m_class` (`sysid`, `price_code`, `descriptions`, `sort_name`, `factor_inpatient`, `factor_service`, `factor_pharmacy`, `is_base_price`, `is_price_class`, `is_service_class`, `is_pharmacy_class`, `is_bpjs_class`, `minimum_deposit`, `update_userid`, `create_date`, `update_date`) VALUES (10, 'RJ', 'Rawat Jalan', 'RJ', 100.00, 100.00, 100.00, '0', '1', '1', '1', '0', 0.00, 'IT', '2022-10-04 12:51:59', '2022-10-04 12:51:59');
INSERT INTO `m_class` (`sysid`, `price_code`, `descriptions`, `sort_name`, `factor_inpatient`, `factor_service`, `factor_pharmacy`, `is_base_price`, `is_price_class`, `is_service_class`, `is_pharmacy_class`, `is_bpjs_class`, `minimum_deposit`, `update_userid`, `create_date`, `update_date`) VALUES (11, 'VIP', 'Kelas VIP', 'VIP', 100.00, 100.00, 100.00, '0', '1', '1', '0', '0', 0.00, 'IT', '2022-10-04 12:52:11', '2022-10-04 12:52:11');
INSERT INTO `m_class` (`sysid`, `price_code`, `descriptions`, `sort_name`, `factor_inpatient`, `factor_service`, `factor_pharmacy`, `is_base_price`, `is_price_class`, `is_service_class`, `is_pharmacy_class`, `is_bpjs_class`, `minimum_deposit`, `update_userid`, `create_date`, `update_date`) VALUES (12, 'SVIP', 'Kelas SVIP', 'SVIP', 100.00, 100.00, 100.00, '0', '1', '1', '0', '0', 0.00, 'demo@gmail.com', '2022-10-04 12:52:25', '2022-10-06 20:39:23');
INSERT INTO `m_class` (`sysid`, `price_code`, `descriptions`, `sort_name`, `factor_inpatient`, `factor_service`, `factor_pharmacy`, `is_base_price`, `is_price_class`, `is_service_class`, `is_pharmacy_class`, `is_bpjs_class`, `minimum_deposit`, `update_userid`, `create_date`, `update_date`) VALUES (13, 'ICU', 'Kelas ICU', 'ICU', 100.00, 100.00, 100.00, '0', '1', '0', '0', '0', 0.00, 'IT', '2022-10-04 12:52:44', '2022-10-04 12:52:44');
INSERT INTO `m_class` (`sysid`, `price_code`, `descriptions`, `sort_name`, `factor_inpatient`, `factor_service`, `factor_pharmacy`, `is_base_price`, `is_price_class`, `is_service_class`, `is_pharmacy_class`, `is_bpjs_class`, `minimum_deposit`, `update_userid`, `create_date`, `update_date`) VALUES (14, 'PHARRJ', 'Farnasi Rawat Jalan', 'RJ', 100.00, 100.00, 100.00, '0', '0', '0', '1', '0', 0.00, 'demo@gmail.com', '2022-10-06 15:30:17', '2022-10-06 15:30:17');
INSERT INTO `m_class` (`sysid`, `price_code`, `descriptions`, `sort_name`, `factor_inpatient`, `factor_service`, `factor_pharmacy`, `is_base_price`, `is_price_class`, `is_service_class`, `is_pharmacy_class`, `is_bpjs_class`, `minimum_deposit`, `update_userid`, `create_date`, `update_date`) VALUES (15, 'PHARRI', 'Farmasi Rawat Inap', 'RI', 100.00, 100.00, 100.00, '0', '0', '0', '1', '0', 0.00, 'demo@gmail.com', '2022-10-06 15:30:32', '2022-10-06 15:30:39');
INSERT INTO `m_class` (`sysid`, `price_code`, `descriptions`, `sort_name`, `factor_inpatient`, `factor_service`, `factor_pharmacy`, `is_base_price`, `is_price_class`, `is_service_class`, `is_pharmacy_class`, `is_bpjs_class`, `minimum_deposit`, `update_userid`, `create_date`, `update_date`) VALUES (16, 'PHAREMG', 'Obat Emergency', 'EMG', 100.00, 100.00, 100.00, '0', '0', '0', '1', '0', 0.00, 'demo@gmail.com', '2022-10-06 15:31:00', '2022-10-06 15:31:00');
COMMIT;

-- ----------------------------
-- Table structure for m_department
-- ----------------------------
DROP TABLE IF EXISTS `m_department`;
CREATE TABLE `m_department` (
  `sysid` int(11) NOT NULL,
  `dept_code` varchar(20) DEFAULT NULL,
  `dept_name` varchar(255) DEFAULT NULL,
  `sort_name` varchar(50) DEFAULT NULL,
  `wh_medical` int(11) DEFAULT NULL,
  `wh_general` int(11) DEFAULT NULL,
  `wh_pharmacy` int(11) DEFAULT NULL,
  `price_class` int(11) DEFAULT NULL,
  `dept_group` varchar(25) DEFAULT NULL,
  `cost_center_sysid` int(11) DEFAULT NULL,
  `is_executive` varchar(5) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_department
-- ----------------------------
BEGIN;
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (5, 'KSY001', 'Klinik Syaraf', 'SYARAF', NULL, NULL, 15, 10, 'OUTPATIENT', -1, '0', '1', 'demo@gmail.com', '2022-10-04 15:43:25', '2023-05-24 13:09:59');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (7, 'KTH001', 'Klinik THT', 'THT', NULL, NULL, 15, 10, 'OUTPATIENT', -1, '0', '1', 'demo@gmail.com', '2022-10-04 15:44:53', '2023-05-24 13:10:11');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (8, 'KGI001', 'Klinik Gigi', 'GIGI', NULL, NULL, 15, 10, 'OUTPATIENT', -1, '0', '1', 'demo@gmail.com', '2022-10-04 15:45:23', '2023-05-24 13:10:22');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (11, 'PJLAB', 'LABORATORIUM', 'LAB', NULL, NULL, NULL, -1, 'DIAGNOSTIC', -1, '0', '1', 'demo@gmail.com', '2022-10-04 16:27:35', '2023-05-09 13:27:14');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (12, 'RAD', 'RADIOLOGI', 'RAD', NULL, NULL, NULL, -1, 'DIAGNOSTIC', -1, '0', '1', 'demo@gmail.com', '2022-10-04 16:27:45', '2023-05-09 13:32:35');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (13, 'FISIO', 'FISIOTERAPI', 'FISIO', NULL, NULL, NULL, -1, 'DIAGNOSTIC', -1, '0', '1', 'IT', '2022-10-04 16:27:56', '2022-10-04 16:27:56');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (14, 'ENBOS', 'ENDOSKOPI', 'ENDOS', NULL, NULL, NULL, -1, 'DIAGNOSTIC', -1, '0', '1', 'IT', '2022-10-04 16:28:35', '2022-10-04 16:28:35');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (16, 'PHAR02', 'FARMASI RAWAT INAP', 'PHAR-RI', NULL, NULL, NULL, -1, 'PHARMACY', -1, '0', '1', 'IT', '2022-10-04 16:29:16', '2022-10-04 16:29:16');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (17, 'PHAR-OK', 'FARMASI RUANG OPERASI', 'PHAR-OK', NULL, NULL, NULL, -1, 'PHARMACY', -1, '0', '1', 'IT', '2022-10-04 16:29:35', '2022-10-04 16:29:35');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (18, 'PHAR-IGD', 'FARMASI IGD', 'PHAR-IGD', NULL, NULL, NULL, -1, 'PHARMACY', -1, '0', '1', 'IT', '2022-10-04 16:29:57', '2022-10-04 16:29:57');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (20, 'INICU', 'PELAYANAN ICU', 'ICU', NULL, NULL, NULL, -1, 'INPATIENT', -1, '0', '1', 'IT', '2022-10-04 16:50:07', '2022-10-04 16:50:07');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (21, 'INSBAYI', 'PELAYANAN KAMAR BAYI', 'BABYROOM', NULL, NULL, NULL, -1, 'INPATIENT', -1, '0', '1', 'IT', '2022-10-04 16:50:25', '2022-10-04 16:50:25');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (6, 'KBE001', 'Klinik Bedah', 'BEDAH', NULL, NULL, 15, 10, 'OUTPATIENT', -1, '0', '1', 'demo@gmail.com', '2022-10-04 15:43:40', '2023-05-24 13:09:27');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (22, 'MCU001', 'MEDICAL CHECKUP', 'MCU', NULL, NULL, NULL, -1, 'MCU', -1, '0', '1', 'IT', '2022-10-04 16:55:02', '2022-10-04 16:55:02');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (23, 'MCU002', 'MEDICAL CHECKUP (PROJECT)', 'MCU02', NULL, NULL, NULL, -1, 'MCU', -1, '0', '1', 'IT', '2022-10-04 16:55:23', '2022-10-04 16:55:23');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (4, 'KUR001', 'Klinik Urologi', 'UROLOGI', NULL, NULL, 15, 10, 'OUTPATIENT', -1, '0', '1', 'demo@gmail.com', '2022-10-04 15:43:07', '2023-05-24 13:09:42');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (3, 'KA0001', 'Klinik Anak', 'PEDIATRIC', 9, 6, 15, 10, 'OUTPATIENT', -1, '0', '1', 'demo@gmail.com', '2022-10-04 15:42:36', '2023-05-24 13:10:31');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (24, 'KPE002', 'Klinik Penyakit Dalam Executive', 'KPE002', 8, 6, 15, 10, 'OUTPATIENT', -1, '1', '1', 'demo@gmail.com', '2022-10-06 21:32:48', '2022-10-06 21:33:04');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (9, 'IGD01', 'Instalasi Gawat Darurat', 'IGD', 3, 4, 18, 10, 'IGD', -1, '0', '1', 'demo@gmail.com', '2022-10-04 16:18:08', '2022-10-07 09:39:09');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (15, 'PHAR01', 'FARMASI RAWAT JALAN', 'PHAR-RJ', 1, 4, NULL, -1, 'PHARMACY', -1, '0', '1', 'demo@gmail.com', '2022-10-04 16:28:55', '2022-10-07 09:50:50');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (19, 'INSTD', 'PELAYANAN STANDAR', 'STDR', 2, 4, 16, -1, 'INPATIENT', -1, '1', '1', 'demo@gmail.com', '2022-10-04 16:49:52', '2023-05-09 13:19:21');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'KPE001', 'Klinik Penyakit Dalam', 'INTERNIST', 14, 6, 15, 10, 'OUTPATIENT', -1, '0', '1', 'demo@gmail.com', '2022-10-04 15:41:18', '2022-10-07 16:39:07');
INSERT INTO `m_department` (`sysid`, `dept_code`, `dept_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_group`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, 'PKA001', 'Klinik Akupuntur', 'ACCUPUNTURE', 1, 4, 15, 10, 'OUTPATIENT', -1, '0', '1', 'demo@gmail.com', '2022-10-04 15:42:11', '2022-10-07 20:09:00');
COMMIT;

-- ----------------------------
-- Table structure for m_department_child
-- ----------------------------
DROP TABLE IF EXISTS `m_department_child`;
CREATE TABLE `m_department_child` (
  `sysid` int(11) NOT NULL,
  `department_sysid` int(11) DEFAULT NULL,
  `child_code` varchar(20) DEFAULT NULL,
  `child_name` varchar(255) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE,
  KEY `m_department_child_idx` (`department_sysid`,`child_code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_department_child
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_item_service
-- ----------------------------
DROP TABLE IF EXISTS `m_item_service`;
CREATE TABLE `m_item_service` (
  `sysid` int(11) NOT NULL,
  `uuid_rec` varchar(36) DEFAULT NULL,
  `service_code` varchar(25) DEFAULT NULL,
  `service_name1` varchar(255) NOT NULL,
  `service_name2` varchar(255) DEFAULT NULL,
  `service_groups` int(11) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `product_line` int(11) DEFAULT NULL,
  `journal_type` varchar(30) DEFAULT NULL,
  `revenue_outpatient` varchar(20) DEFAULT NULL,
  `revenue_inpatient` varchar(20) DEFAULT NULL,
  `revenue_diagnostic` varchar(20) DEFAULT NULL,
  `expense_outpatient` varchar(20) DEFAULT NULL,
  `expense_inpatient` varchar(20) DEFAULT NULL,
  `expense_diagnostic` varchar(20) DEFAULT NULL,
  `is_fixed` varchar(5) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `is_package` varchar(5) DEFAULT NULL,
  `dept_group` varchar(30) DEFAULT NULL,
  `is_have_material` varchar(5) DEFAULT NULL,
  `material_cost` decimal(18,2) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_item_service
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_item_service_department
-- ----------------------------
DROP TABLE IF EXISTS `m_item_service_department`;
CREATE TABLE `m_item_service_department` (
  `service_sysid` int(11) NOT NULL,
  `department_sysid` int(11) NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `is_used` varchar(5) DEFAULT NULL,
  `is_block` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`service_sysid`,`department_sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_item_service_department
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_item_service_group
-- ----------------------------
DROP TABLE IF EXISTS `m_item_service_group`;
CREATE TABLE `m_item_service_group` (
  `sysid` int(11) NOT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `sort_number` int(11) DEFAULT NULL,
  `is_doctor_fee` varchar(5) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_item_service_group
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_item_service_price
-- ----------------------------
DROP TABLE IF EXISTS `m_item_service_price`;
CREATE TABLE `m_item_service_price` (
  `sysid` int(11) NOT NULL,
  `price_group` int(11) DEFAULT NULL,
  `service_sysid` bigint(20) DEFAULT NULL,
  `doctor_group` int(11) DEFAULT NULL,
  `level_sysid` int(11) DEFAULT NULL,
  `class_sysid` int(11) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  `percent1` decimal(18,2) DEFAULT NULL,
  `percent2` decimal(18,2) DEFAULT NULL,
  `percent3` decimal(18,2) DEFAULT NULL,
  `percent4` decimal(18,2) DEFAULT NULL,
  `percent5` decimal(18,2) DEFAULT NULL,
  `value1` decimal(18,2) DEFAULT NULL,
  `value2` decimal(18,2) DEFAULT NULL,
  `value3` decimal(18,2) DEFAULT NULL,
  `value4` decimal(18,2) DEFAULT NULL,
  `value5` decimal(18,2) DEFAULT NULL,
  `base_doctor_fee` varchar(30) DEFAULT NULL,
  `apply_date` datetime DEFAULT NULL,
  `appy_userid` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_item_service_price
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_item_service_price_groups
-- ----------------------------
DROP TABLE IF EXISTS `m_item_service_price_groups`;
CREATE TABLE `m_item_service_price_groups` (
  `sysid` int(11) NOT NULL,
  `price_group_name` varchar(50) DEFAULT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `is_default` varchar(5) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_item_service_price_groups
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_item_service_price_history
-- ----------------------------
DROP TABLE IF EXISTS `m_item_service_price_history`;
CREATE TABLE `m_item_service_price_history` (
  `log_sysid` int(11) NOT NULL,
  `log_timestamp` datetime DEFAULT NULL,
  `sysid` bigint(20) DEFAULT NULL,
  `price_group` int(11) DEFAULT NULL,
  `service_sysid` bigint(20) DEFAULT NULL,
  `doctor_group` int(11) DEFAULT NULL,
  `level_sysid` int(11) DEFAULT NULL,
  `class_sysid` int(11) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  `percent1` decimal(18,2) DEFAULT NULL,
  `percent2` decimal(18,2) DEFAULT NULL,
  `percent3` decimal(18,2) DEFAULT NULL,
  `percent4` decimal(18,2) DEFAULT NULL,
  `percent5` decimal(18,2) DEFAULT NULL,
  `value1` decimal(18,2) DEFAULT NULL,
  `value2` decimal(18,2) DEFAULT NULL,
  `value3` decimal(18,2) DEFAULT NULL,
  `value4` decimal(18,2) DEFAULT NULL,
  `value5` decimal(18,2) DEFAULT NULL,
  `base_doctor_fee` varchar(30) DEFAULT NULL,
  `apply_date` datetime DEFAULT NULL,
  `appy_userid` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`log_sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_item_service_price_history
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_items
-- ----------------------------
DROP TABLE IF EXISTS `m_items`;
CREATE TABLE `m_items` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `item_code` varchar(20) DEFAULT NULL,
  `item_code_old` varchar(20) DEFAULT NULL,
  `item_name1` varchar(255) DEFAULT NULL,
  `item_name2` varchar(255) DEFAULT NULL,
  `mou_purchase` varchar(30) DEFAULT NULL,
  `conversion` decimal(18,3) DEFAULT 1.000,
  `mou_inventory` varchar(30) DEFAULT NULL,
  `product_line` int(11) DEFAULT NULL,
  `is_price_rounded` varchar(5) DEFAULT NULL,
  `price_rounded` int(11) DEFAULT NULL,
  `het_price` decimal(18,2) DEFAULT NULL,
  `is_expired_control` varchar(5) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `is_sales` varchar(5) DEFAULT NULL,
  `is_purchase` varchar(5) DEFAULT NULL,
  `is_production` varchar(5) DEFAULT NULL,
  `is_material` varchar(5) DEFAULT NULL,
  `is_consignment` varchar(5) DEFAULT NULL,
  `is_formularium` varchar(5) DEFAULT NULL,
  `is_employee` varchar(5) DEFAULT NULL,
  `is_inhealth` varchar(5) DEFAULT NULL,
  `is_bpjs` varchar(5) DEFAULT NULL,
  `is_national` varchar(5) DEFAULT NULL,
  `is_generic` varchar(5) DEFAULT NULL,
  `item_group_sysid` int(11) DEFAULT NULL,
  `item_subgroup_sysid` int(11) DEFAULT NULL,
  `trademark` int(11) DEFAULT NULL,
  `manufactur_sysid` int(11) DEFAULT NULL,
  `prefered_vendor_sysid` int(11) DEFAULT NULL,
  `hna` decimal(18,2) DEFAULT NULL,
  `cogs` decimal(18,2) DEFAULT NULL,
  `last_sales` datetime DEFAULT NULL,
  `last_purchase` datetime DEFAULT NULL,
  `on_hand` decimal(18,3) DEFAULT NULL,
  `on_hand_unit` decimal(18,3) DEFAULT NULL,
  `inventory_group` varchar(25) DEFAULT NULL,
  `image_path` varchar(250) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `uuid_rec` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE,
  UNIQUE KEY `item_code` (`item_code`),
  UNIQUE KEY `uuid_rec` (`uuid_rec`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items
-- ----------------------------
BEGIN;
INSERT INTO `m_items` (`sysid`, `item_code`, `item_code_old`, `item_name1`, `item_name2`, `mou_purchase`, `conversion`, `mou_inventory`, `product_line`, `is_price_rounded`, `price_rounded`, `het_price`, `is_expired_control`, `is_active`, `is_sales`, `is_purchase`, `is_production`, `is_material`, `is_consignment`, `is_formularium`, `is_employee`, `is_inhealth`, `is_bpjs`, `is_national`, `is_generic`, `item_group_sysid`, `item_subgroup_sysid`, `trademark`, `manufactur_sysid`, `prefered_vendor_sysid`, `hna`, `cogs`, `last_sales`, `last_purchase`, `on_hand`, `on_hand_unit`, `inventory_group`, `image_path`, `update_userid`, `create_date`, `update_date`, `uuid_rec`) VALUES (1, 'PA00210', '', 'Panadol Syrup 65 ml', 'Panadol Syrup', 'BOX', 10.000, 'Botol', -1, '0', 0, 4500.00, '0', '1', '1', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', 3, -1, -1, 2, 4, 4000.00, 3000.00, NULL, NULL, 100.000, 20.000, 'MEDICAL', 'inventory/20221027-163722-inm-13.jpg', 'demo@gmail.com', '2022-10-26 09:41:56', '2023-06-06 21:20:31', 'ebb86cde-0eb5-44ec-a9df-94284dfecc37');
INSERT INTO `m_items` (`sysid`, `item_code`, `item_code_old`, `item_name1`, `item_name2`, `mou_purchase`, `conversion`, `mou_inventory`, `product_line`, `is_price_rounded`, `price_rounded`, `het_price`, `is_expired_control`, `is_active`, `is_sales`, `is_purchase`, `is_production`, `is_material`, `is_consignment`, `is_formularium`, `is_employee`, `is_inhealth`, `is_bpjs`, `is_national`, `is_generic`, `item_group_sysid`, `item_subgroup_sysid`, `trademark`, `manufactur_sysid`, `prefered_vendor_sysid`, `hna`, `cogs`, `last_sales`, `last_purchase`, `on_hand`, `on_hand_unit`, `inventory_group`, `image_path`, `update_userid`, `create_date`, `update_date`, `uuid_rec`) VALUES (3, 'PA00101', '', 'COMBANTRIN  SYRUP', 'COMBANTRIN', 'BOX', 10.000, 'Botol', -1, '0', 100, 65000.00, '0', '1', '1', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', 1, -1, -1, 2, 4, 0.00, 0.00, NULL, NULL, 0.000, 0.000, 'MEDICAL', 'inventory/20221027-165743-cps-media-cobas-c-111-analyzer.png', 'demo@gmail.com', '2022-10-26 15:24:22', '2023-06-06 21:20:36', 'd7650fe3-ce9d-49f8-b121-03917328e46e');
INSERT INTO `m_items` (`sysid`, `item_code`, `item_code_old`, `item_name1`, `item_name2`, `mou_purchase`, `conversion`, `mou_inventory`, `product_line`, `is_price_rounded`, `price_rounded`, `het_price`, `is_expired_control`, `is_active`, `is_sales`, `is_purchase`, `is_production`, `is_material`, `is_consignment`, `is_formularium`, `is_employee`, `is_inhealth`, `is_bpjs`, `is_national`, `is_generic`, `item_group_sysid`, `item_subgroup_sysid`, `trademark`, `manufactur_sysid`, `prefered_vendor_sysid`, `hna`, `cogs`, `last_sales`, `last_purchase`, `on_hand`, `on_hand_unit`, `inventory_group`, `image_path`, `update_userid`, `create_date`, `update_date`, `uuid_rec`) VALUES (4, 'BL001', '', 'Balpoint  Pilot A.01', '', NULL, 1.000, 'Box', -1, '0', 0, 0.00, '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 5, -1, -1, 2, 4, 0.00, 0.00, NULL, NULL, 0.000, 0.000, 'GENERAL', '', 'demo@gmail.com', '2022-10-27 19:36:12', '2023-06-06 21:26:38', '6b7870bd-a16c-426f-a323-605d550bb18a');
INSERT INTO `m_items` (`sysid`, `item_code`, `item_code_old`, `item_name1`, `item_name2`, `mou_purchase`, `conversion`, `mou_inventory`, `product_line`, `is_price_rounded`, `price_rounded`, `het_price`, `is_expired_control`, `is_active`, `is_sales`, `is_purchase`, `is_production`, `is_material`, `is_consignment`, `is_formularium`, `is_employee`, `is_inhealth`, `is_bpjs`, `is_national`, `is_generic`, `item_group_sysid`, `item_subgroup_sysid`, `trademark`, `manufactur_sysid`, `prefered_vendor_sysid`, `hna`, `cogs`, `last_sales`, `last_purchase`, `on_hand`, `on_hand_unit`, `inventory_group`, `image_path`, `update_userid`, `create_date`, `update_date`, `uuid_rec`) VALUES (5, 'BAT001', '', 'Baterai Alkaline AA', '', NULL, 1.000, 'Box', -1, '0', 0, 0.00, '0', '1', '1', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', 5, -1, -1, -1, -1, 0.00, 0.00, NULL, NULL, 0.000, 0.000, 'GENERAL', '', 'demo@gmail.com', '2022-10-27 19:40:37', '2023-06-06 21:26:42', 'd1238160-67b8-4885-b9fd-55d6089512b1');
INSERT INTO `m_items` (`sysid`, `item_code`, `item_code_old`, `item_name1`, `item_name2`, `mou_purchase`, `conversion`, `mou_inventory`, `product_line`, `is_price_rounded`, `price_rounded`, `het_price`, `is_expired_control`, `is_active`, `is_sales`, `is_purchase`, `is_production`, `is_material`, `is_consignment`, `is_formularium`, `is_employee`, `is_inhealth`, `is_bpjs`, `is_national`, `is_generic`, `item_group_sysid`, `item_subgroup_sysid`, `trademark`, `manufactur_sysid`, `prefered_vendor_sysid`, `hna`, `cogs`, `last_sales`, `last_purchase`, `on_hand`, `on_hand_unit`, `inventory_group`, `image_path`, `update_userid`, `create_date`, `update_date`, `uuid_rec`) VALUES (6, 'BR0001', '', 'Beras Cianjur Rojolele', '', NULL, 1.000, 'Kg', -1, '0', 0, 0.00, '0', '1', '1', '0', '1', '0', '0', '0', '0', '0', '0', '0', '0', 8, -1, -1, -1, -1, 0.00, 0.00, NULL, NULL, 0.000, 0.000, 'NUTRITION', 'inventory/20221027-195419-e0ee2bf5e4e846dda162fa70ac11939f.png', 'demo@gmail.com', '2022-10-27 19:54:19', '2023-05-10 19:30:49', '4cef866a-37d8-4dda-8765-71fcf41246a6');
COMMIT;

-- ----------------------------
-- Table structure for m_items_convertions
-- ----------------------------
DROP TABLE IF EXISTS `m_items_convertions`;
CREATE TABLE `m_items_convertions` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `item_sysid` int(11) DEFAULT NULL,
  `mou_convertion` varchar(30) DEFAULT NULL,
  `mou_inventory` varchar(30) DEFAULT NULL,
  `convertion` int(11) DEFAULT 1,
  `descriptions` varchar(200) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT '1',
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_convertions
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_items_group
-- ----------------------------
DROP TABLE IF EXISTS `m_items_group`;
CREATE TABLE `m_items_group` (
  `sysid` int(11) NOT NULL,
  `group_code` varchar(20) DEFAULT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  `inventory_account` varchar(20) DEFAULT NULL,
  `cogs_account` varchar(20) DEFAULT NULL,
  `expense_account` varchar(20) DEFAULT NULL,
  `variant_account` varchar(20) DEFAULT NULL,
  `inventory_group` varchar(25) DEFAULT NULL,
  `is_subgroup` varchar(5) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_group
-- ----------------------------
BEGIN;
INSERT INTO `m_items_group` (`sysid`, `group_code`, `group_name`, `inventory_account`, `cogs_account`, `expense_account`, `variant_account`, `inventory_group`, `is_subgroup`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'GRM001', 'OBAT-OBATAN', '', '', '', '', 'MEDICAL', '0', '1', 'demo@gmail.com', '2022-10-25 08:56:07', '2022-10-25 09:00:59');
INSERT INTO `m_items_group` (`sysid`, `group_code`, `group_name`, `inventory_account`, `cogs_account`, `expense_account`, `variant_account`, `inventory_group`, `is_subgroup`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, 'GRM002', 'ALAT-ALAT KESEHATAN', '', '', '', '', 'MEDICAL', '0', '1', 'demo@gmail.com', '2022-10-25 08:57:17', '2022-10-25 09:01:05');
INSERT INTO `m_items_group` (`sysid`, `group_code`, `group_name`, `inventory_account`, `cogs_account`, `expense_account`, `variant_account`, `inventory_group`, `is_subgroup`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (3, 'GRM003', 'ALAT & REAGENSIA LABORATORIUM', '', '', '', '', 'MEDICAL', '0', '1', 'demo@gmail.com', '2022-10-25 09:00:03', '2022-10-25 09:01:11');
INSERT INTO `m_items_group` (`sysid`, `group_code`, `group_name`, `inventory_account`, `cogs_account`, `expense_account`, `variant_account`, `inventory_group`, `is_subgroup`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (4, 'GRM004', 'BAHAN FILM & CAIRAN RADIOLOGI', '', '', '', '', 'MEDICAL', '0', '1', 'demo@gmail.com', '2022-10-25 09:00:15', '2022-10-25 10:53:00');
INSERT INTO `m_items_group` (`sysid`, `group_code`, `group_name`, `inventory_account`, `cogs_account`, `expense_account`, `variant_account`, `inventory_group`, `is_subgroup`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (5, 'GRU001', 'ALAT TULIS & KANTOR', '', '', '', '', 'GENERAL', '0', '1', 'demo@gmail.com', '2022-10-25 09:00:48', '2022-10-25 09:00:48');
INSERT INTO `m_items_group` (`sysid`, `group_code`, `group_name`, `inventory_account`, `cogs_account`, `expense_account`, `variant_account`, `inventory_group`, `is_subgroup`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (6, 'GRD001', 'MAKANAN', '', '', '', '', 'NUTRITION', '0', '1', 'demo@gmail.com', '2022-10-25 09:01:54', '2022-10-25 09:01:54');
INSERT INTO `m_items_group` (`sysid`, `group_code`, `group_name`, `inventory_account`, `cogs_account`, `expense_account`, `variant_account`, `inventory_group`, `is_subgroup`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (7, 'GRD002', 'MINUMAN', '', '', '', '', 'NUTRITION', '0', '1', 'demo@gmail.com', '2022-10-25 09:02:11', '2022-10-25 09:02:11');
INSERT INTO `m_items_group` (`sysid`, `group_code`, `group_name`, `inventory_account`, `cogs_account`, `expense_account`, `variant_account`, `inventory_group`, `is_subgroup`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (8, 'GRD003', 'BAHAN BAKU DAPUR', '', '', '', '', 'NUTRITION', '0', '1', 'demo@gmail.com', '2022-10-25 09:02:22', '2022-10-25 09:02:22');
COMMIT;

-- ----------------------------
-- Table structure for m_items_informations
-- ----------------------------
DROP TABLE IF EXISTS `m_items_informations`;
CREATE TABLE `m_items_informations` (
  `sysid` bigint(20) NOT NULL,
  `generic_name` varchar(255) DEFAULT NULL,
  `rate` decimal(18,2) DEFAULT NULL,
  `units` varchar(30) DEFAULT NULL,
  `forms` varchar(30) DEFAULT NULL,
  `preparation` varchar(50) DEFAULT NULL,
  `item_classification_sysid` int(11) DEFAULT NULL,
  `medication_routes` int(11) DEFAULT NULL,
  `storage_instruction` text DEFAULT NULL,
  `medical_uses` varchar(255) DEFAULT NULL,
  `special_instruction` varchar(255) DEFAULT NULL,
  `is_generic` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_informations
-- ----------------------------
BEGIN;
INSERT INTO `m_items_informations` (`sysid`, `generic_name`, `rate`, `units`, `forms`, `preparation`, `item_classification_sysid`, `medication_routes`, `storage_instruction`, `medical_uses`, `special_instruction`, `is_generic`) VALUES (1, 'Panadol', 65.00, 'ml', '', NULL, NULL, NULL, 'Simpan dalam suhu ruang', 'Obat batuk', '', '0');
INSERT INTO `m_items_informations` (`sysid`, `generic_name`, `rate`, `units`, `forms`, `preparation`, `item_classification_sysid`, `medication_routes`, `storage_instruction`, `medical_uses`, `special_instruction`, `is_generic`) VALUES (3, 'Combantrin', 10.00, 'mg', '', NULL, NULL, NULL, '\n\n', 'asasa', 'asasasas', '0');
COMMIT;

-- ----------------------------
-- Table structure for m_items_price
-- ----------------------------
DROP TABLE IF EXISTS `m_items_price`;
CREATE TABLE `m_items_price` (
  `item_sysid` int(11) NOT NULL,
  `price_sysid` int(11) NOT NULL,
  `hna_price` decimal(18,2) DEFAULT 0.00,
  `het_price` decimal(18,2) DEFAULT 0.00,
  `cogs_price` decimal(18,2) DEFAULT 0.00,
  `price` decimal(28,2) DEFAULT 0.00,
  `change_price` datetime DEFAULT NULL,
  `method_change` varchar(50) DEFAULT NULL,
  `old_price` decimal(18,2) DEFAULT 0.00,
  `uuid_rec` varchar(50) DEFAULT '',
  PRIMARY KEY (`item_sysid`,`price_sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_price
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_items_price_history
-- ----------------------------
DROP TABLE IF EXISTS `m_items_price_history`;
CREATE TABLE `m_items_price_history` (
  `log_sysid` int(11) NOT NULL AUTO_INCREMENT,
  `log_timestamp` datetime DEFAULT NULL,
  `item_sysid` bigint(20) DEFAULT NULL,
  `price_sysid` int(11) DEFAULT NULL,
  `hna_price` decimal(18,2) DEFAULT 0.00,
  `het_price` decimal(18,2) DEFAULT 0.00,
  `cogs_price` decimal(18,2) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT 0.00,
  `method_change` varchar(30) DEFAULT NULL,
  `old_price` decimal(18,2) DEFAULT 0.00,
  `price_active` datetime DEFAULT NULL,
  `price_disavble` datetime DEFAULT NULL,
  PRIMARY KEY (`log_sysid`) USING BTREE,
  KEY `m_items_price_history_idx` (`item_sysid`,`price_sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_price_history
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_items_properties
-- ----------------------------
DROP TABLE IF EXISTS `m_items_properties`;
CREATE TABLE `m_items_properties` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `property_name` varchar(255) DEFAULT '',
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_properties
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_items_property
-- ----------------------------
DROP TABLE IF EXISTS `m_items_property`;
CREATE TABLE `m_items_property` (
  `sysid` bigint(20) NOT NULL,
  `property_sysid` int(11) NOT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sysid`,`property_sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_property
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_items_stock
-- ----------------------------
DROP TABLE IF EXISTS `m_items_stock`;
CREATE TABLE `m_items_stock` (
  `wh_sysid` int(11) NOT NULL,
  `item_sysid` int(11) NOT NULL,
  `mou_inventory` varchar(30) DEFAULT NULL,
  `on_hand` decimal(18,2) DEFAULT NULL,
  `on_order` decimal(18,2) DEFAULT NULL,
  `on_demand` decimal(18,2) DEFAULT NULL,
  `cogs` decimal(18,2) DEFAULT NULL,
  `out1` decimal(18,2) DEFAULT NULL,
  `out2` decimal(18,2) DEFAULT NULL,
  `out3` decimal(18,2) DEFAULT NULL,
  `is_hold` varchar(5) DEFAULT NULL,
  `last_in` datetime DEFAULT NULL,
  `last_out` datetime DEFAULT NULL,
  `minimum_stock` decimal(18,2) DEFAULT NULL,
  `maximum_stock` decimal(18,2) DEFAULT NULL,
  `far_expired_date` date DEFAULT NULL,
  `nearest_expired_date` date DEFAULT NULL,
  `is_visible` tinyint(1) DEFAULT 1,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`wh_sysid`,`item_sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_stock
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_items_supplier
-- ----------------------------
DROP TABLE IF EXISTS `m_items_supplier`;
CREATE TABLE `m_items_supplier` (
  `vendor_sysid` int(11) NOT NULL,
  `item_sysid` int(11) NOT NULL,
  `catalog_code` varchar(20) DEFAULT NULL,
  `barcode` varchar(20) DEFAULT NULL,
  `mou_inventory` varchar(30) DEFAULT NULL,
  `conversion` int(11) DEFAULT NULL,
  `price` decimal(18,2) DEFAULT NULL,
  `discount1` decimal(18,2) DEFAULT NULL,
  `discount2` decimal(18,2) DEFAULT NULL,
  `tax` decimal(18,2) DEFAULT NULL,
  `net_price` decimal(18,2) DEFAULT NULL,
  `net_price_stock` decimal(18,2) DEFAULT NULL,
  `last_order` date DEFAULT NULL,
  `last_receive` date DEFAULT NULL,
  `last_invoice` date DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`vendor_sysid`,`item_sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_supplier
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_items_trademarks
-- ----------------------------
DROP TABLE IF EXISTS `m_items_trademarks`;
CREATE TABLE `m_items_trademarks` (
  `sysid` int(11) NOT NULL,
  `trademark_code` varchar(20) DEFAULT NULL,
  `trademark_name` varchar(255) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_trademarks
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_items_unit
-- ----------------------------
DROP TABLE IF EXISTS `m_items_unit`;
CREATE TABLE `m_items_unit` (
  `sysid` int(11) NOT NULL,
  `mou_name` varchar(30) DEFAULT NULL,
  `descriptions` varchar(200) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_items_unit
-- ----------------------------
BEGIN;
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'Tablet', 'Satuan obat dalam bentuk tablet', '1', 'demo@gmail.com', '2022-10-24 23:08:50', '2022-10-24 23:13:27');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, 'Kapsul', 'Satuan obat dalam bentuk kapsul', '1', 'demo@gmail.com', '2022-10-24 23:11:21', '2022-10-24 23:13:33');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (3, 'Kaplet', 'Satuan obat dalam bentuk kaplet', '1', 'demo@gmail.com', '2022-10-24 23:12:00', '2022-10-24 23:13:41');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (4, 'Botol', 'Satuan obat/sirup dalam bentuk Botol', '1', 'demo@gmail.com', '2022-10-24 23:12:18', '2022-10-24 23:13:50');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (5, 'mg', 'Satuan berat dalam Miligram', '1', 'demo@gmail.com', '2022-10-24 23:12:39', '2022-10-24 23:12:39');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (6, 'gr', 'Satuan berat dalam gram', '1', 'demo@gmail.com', '2022-10-24 23:12:59', '2022-10-24 23:12:59');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (7, 'ml', 'Satuan obat dalam mililiter', '1', 'demo@gmail.com', '2022-10-24 23:13:18', '2022-10-24 23:13:18');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (9, 'Kg', 'Satuan belat dalam Kilogram', '1', 'demo@gmail.com', '2022-10-24 23:14:35', '2022-10-24 23:14:35');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (10, 'Ltr', 'Satuan volume (Liter)', '1', 'demo@gmail.com', '2022-10-24 23:15:05', '2022-10-24 23:15:05');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (11, 'Dus', 'Satuan dalam unit Dus', '1', 'demo@gmail.com', '2022-10-24 23:16:12', '2022-10-24 23:16:12');
INSERT INTO `m_items_unit` (`sysid`, `mou_name`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (12, 'Box', 'Satuan dalam Box', '1', 'demo@gmail.com', '2022-10-25 16:56:46', '2022-10-25 16:56:46');
COMMIT;

-- ----------------------------
-- Table structure for m_manufactur
-- ----------------------------
DROP TABLE IF EXISTS `m_manufactur`;
CREATE TABLE `m_manufactur` (
  `sysid` int(11) NOT NULL,
  `manufactur_code` varchar(20) DEFAULT NULL,
  `manufactur_name` varchar(255) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_manufactur
-- ----------------------------
BEGIN;
INSERT INTO `m_manufactur` (`sysid`, `manufactur_code`, `manufactur_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'SANBE01', 'PT Sanbe Farma', 't', 'demo@gmail.com', '2022-10-26 10:17:29', '2022-10-26 10:17:29');
INSERT INTO `m_manufactur` (`sysid`, `manufactur_code`, `manufactur_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, 'KIMIA01', 'PT. Kimia Farma', 't', 'demo@gmail.com', '2022-10-26 10:18:12', '2022-10-26 10:18:12');
COMMIT;

-- ----------------------------
-- Table structure for m_paramedic
-- ----------------------------
DROP TABLE IF EXISTS `m_paramedic`;
CREATE TABLE `m_paramedic` (
  `sysid` int(11) NOT NULL,
  `uuid_rec` varchar(36) DEFAULT NULL,
  `paramedic_code` varchar(20) DEFAULT NULL,
  `paramedic_name` varchar(200) DEFAULT NULL,
  `employee_id` varchar(15) DEFAULT NULL,
  `paramedic_type` varchar(50) DEFAULT NULL,
  `price_group` int(11) DEFAULT NULL,
  `is_internal` varchar(5) DEFAULT NULL,
  `is_permanent` varchar(5) DEFAULT NULL,
  `is_have_tax` varchar(5) DEFAULT NULL,
  `tax_number` varchar(25) DEFAULT NULL,
  `cityzen_number` varchar(25) DEFAULT NULL,
  `bpjs_numbner` varchar(25) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_email_reports` varchar(5) DEFAULT NULL,
  `is_transfer` varchar(5) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `specialist_sysid` int(11) DEFAULT NULL,
  `dept_sysid` int(11) DEFAULT NULL,
  `is_have_schedule` varchar(5) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_paramedic
-- ----------------------------
BEGIN;
INSERT INTO `m_paramedic` (`sysid`, `uuid_rec`, `paramedic_code`, `paramedic_name`, `employee_id`, `paramedic_type`, `price_group`, `is_internal`, `is_permanent`, `is_have_tax`, `tax_number`, `cityzen_number`, `bpjs_numbner`, `email`, `is_email_reports`, `is_transfer`, `bank_name`, `account_number`, `account_name`, `specialist_sysid`, `dept_sysid`, `is_have_schedule`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, NULL, 'AN01', 'Dr. Andi Sutanto, SpPD', NULL, 'DOCTOR', 1, '1', '1', '1', '111111', '', '', 'bluemetric@gmail.com', '1', '1', 'BCA', '415201213', 'Andi Sutanto', 1, 6, '0', '1', 'demo@gmail.com', '2022-10-07 11:27:03', '2022-10-07 16:22:09');
INSERT INTO `m_paramedic` (`sysid`, `uuid_rec`, `paramedic_code`, `paramedic_name`, `employee_id`, `paramedic_type`, `price_group`, `is_internal`, `is_permanent`, `is_have_tax`, `tax_number`, `cityzen_number`, `bpjs_numbner`, `email`, `is_email_reports`, `is_transfer`, `bank_name`, `account_number`, `account_name`, `specialist_sysid`, `dept_sysid`, `is_have_schedule`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, NULL, 'ZI001', 'dr. Zainal Irkam, SpPD(K)', NULL, 'DOCTOR', 5, '1', '1', '0', '', '', '', '', '0', '1', 'Bank Syariah Indonesia', '', 'Najla Nuranna Azizah', 1, -1, '0', '1', 'demo@gmail.com', '2022-10-07 14:49:10', '2023-05-09 14:02:37');
COMMIT;

-- ----------------------------
-- Table structure for m_paramedic_profile
-- ----------------------------
DROP TABLE IF EXISTS `m_paramedic_profile`;
CREATE TABLE `m_paramedic_profile` (
  `sysid` int(11) NOT NULL,
  `dob` date DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phone1` varchar(20) DEFAULT NULL,
  `phone2` varchar(20) DEFAULT NULL,
  `handphone1` varchar(20) DEFAULT NULL,
  `handphone2` varchar(20) DEFAULT NULL,
  `email` char(255) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_paramedic_profile
-- ----------------------------
BEGIN;
INSERT INTO `m_paramedic_profile` (`sysid`, `dob`, `address`, `phone1`, `phone2`, `handphone1`, `handphone2`, `email`) VALUES (1, '2022-10-01', 'Jl. Raya Centex Gg Mebel No.31', '-', '-', '081319777459', '081818100677', 'ade@rs-royaltaruma.com');
INSERT INTO `m_paramedic_profile` (`sysid`, `dob`, `address`, `phone1`, `phone2`, `handphone1`, `handphone2`, `email`) VALUES (2, NULL, 'Jakarta', '', NULL, '', '', '');
COMMIT;

-- ----------------------------
-- Table structure for m_patient
-- ----------------------------
DROP TABLE IF EXISTS `m_patient`;
CREATE TABLE `m_patient` (
  `sysid` int(11) NOT NULL,
  `uuid_rec` varchar(36) DEFAULT NULL,
  `medical_record` varchar(20) DEFAULT NULL,
  `medical_record_old` varchar(20) DEFAULT NULL,
  `bpjs_number` varchar(30) DEFAULT NULL,
  `inhealth_number` varchar(30) DEFAULT NULL,
  `salution` varchar(10) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `nickname` varchar(255) DEFAULT NULL,
  `card_name` varchar(255) DEFAULT NULL,
  `pob` varchar(100) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `enum_sex` varchar(25) DEFAULT NULL,
  `blood_group` varchar(10) DEFAULT NULL,
  `rhesus` varchar(10) DEFAULT NULL,
  `identity_type` varchar(20) DEFAULT NULL,
  `identity_number` varchar(25) DEFAULT NULL,
  `family_card_number` varchar(50) DEFAULT NULL,
  `regilion_sysid` int(11) DEFAULT NULL,
  `nationality_sysid` int(11) DEFAULT NULL,
  `mother_name` varchar(255) DEFAULT NULL,
  `father_mame` varchar(255) DEFAULT NULL,
  `couple_name` varchar(255) DEFAULT NULL,
  `child_name` varchar(255) DEFAULT NULL,
  `phone_number1` varchar(20) DEFAULT NULL,
  `phone_number2` varchar(20) DEFAULT NULL,
  `handphone1` varchar(20) DEFAULT NULL,
  `handphone2` varchar(20) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `payor_group` int(11) DEFAULT NULL,
  `company_sysid` int(11) DEFAULT NULL,
  `customer_sysid` int(11) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE,
  KEY `m_patient_uuid` (`uuid_rec`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_patient
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_patient_address
-- ----------------------------
DROP TABLE IF EXISTS `m_patient_address`;
CREATE TABLE `m_patient_address` (
  `sysid` bigint(20) NOT NULL,
  `line_type` varchar(25) NOT NULL,
  `address` text DEFAULT NULL,
  `rt` varchar(10) DEFAULT NULL,
  `rw` varchar(10) DEFAULT NULL,
  `village` varchar(200) DEFAULT NULL,
  `sub_district` varchar(200) DEFAULT NULL,
  `district` varchar(200) DEFAULT NULL,
  `province` varchar(200) DEFAULT NULL,
  `postal_code` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`sysid`,`line_type`) USING BTREE,
  KEY `m_patient_address_idx` (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_patient_address
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_patient_information
-- ----------------------------
DROP TABLE IF EXISTS `m_patient_information`;
CREATE TABLE `m_patient_information` (
  `sysid` bigint(20) NOT NULL,
  `education_sysid` int(11) DEFAULT NULL,
  `mother_language` int(11) DEFAULT NULL,
  `marital_sysid` int(11) DEFAULT NULL,
  `category_sysid` int(11) DEFAULT NULL,
  `etnic_sysid` int(11) DEFAULT NULL,
  `is_allergy` varchar(5) DEFAULT NULL,
  `is_smoke` varchar(5) DEFAULT NULL,
  `is_illiterate` varchar(5) DEFAULT NULL,
  `is_vip` varchar(5) DEFAULT NULL,
  `is_limitations` varchar(5) DEFAULT NULL,
  `limitations_notes` varchar(50) DEFAULT NULL,
  `is_problems` varchar(5) DEFAULT NULL,
  `promblems_notes` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_patient_information
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_patient_office
-- ----------------------------
DROP TABLE IF EXISTS `m_patient_office`;
CREATE TABLE `m_patient_office` (
  `sysid` bigint(20) NOT NULL,
  `job_sysid` int(11) DEFAULT NULL,
  `office_name` varchar(200) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `rt` varchar(10) DEFAULT NULL,
  `rw` varchar(10) DEFAULT NULL,
  `village` varchar(200) DEFAULT NULL,
  `sub_district` varchar(200) DEFAULT NULL,
  `district` varchar(200) DEFAULT NULL,
  `province` varchar(200) DEFAULT NULL,
  `postal_code` varchar(200) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_patient_office
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_price_level
-- ----------------------------
DROP TABLE IF EXISTS `m_price_level`;
CREATE TABLE `m_price_level` (
  `sysid` int(11) NOT NULL,
  `level_code` varchar(10) DEFAULT NULL,
  `descriptions` varchar(50) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_price_level
-- ----------------------------
BEGIN;
INSERT INTO `m_price_level` (`sysid`, `level_code`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'L1', 'Default', '1', 'demo@gmail.com', '2022-10-04 21:46:13', '2022-10-04 21:46:13');
INSERT INTO `m_price_level` (`sysid`, `level_code`, `descriptions`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, 'L2', 'Level 2', '1', 'demo@gmail.com', '2022-10-04 21:46:22', '2022-10-04 21:46:22');
COMMIT;

-- ----------------------------
-- Table structure for m_price_paramedic_groups
-- ----------------------------
DROP TABLE IF EXISTS `m_price_paramedic_groups`;
CREATE TABLE `m_price_paramedic_groups` (
  `sysid` int(11) NOT NULL,
  `group_code` varchar(20) DEFAULT NULL,
  `group_name` varchar(100) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_price_paramedic_groups
-- ----------------------------
BEGIN;
INSERT INTO `m_price_paramedic_groups` (`sysid`, `group_code`, `group_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'DEF01', 'Golongan Tarif Dokter Standar', '1', 'demo@gmail.com', NULL, '2022-10-07 15:43:59');
INSERT INTO `m_price_paramedic_groups` (`sysid`, `group_code`, `group_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (5, 'KONSUL01', 'Golongan Tarif Konsultan (Sub Spesialis)', '1', 'demo@gmail.com', '2022-10-07 15:44:37', '2022-10-07 15:44:37');
COMMIT;

-- ----------------------------
-- Table structure for m_product_line
-- ----------------------------
DROP TABLE IF EXISTS `m_product_line`;
CREATE TABLE `m_product_line` (
  `sysid` int(11) NOT NULL,
  `product_code` varchar(20) DEFAULT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `line_groups` varchar(50) DEFAULT NULL,
  `revenue_outpatient` varchar(20) DEFAULT NULL,
  `revenue_inpatient` varchar(20) DEFAULT NULL,
  `revenue_diagnostic` varchar(20) DEFAULT NULL,
  `expense_outpatient` varchar(20) DEFAULT NULL,
  `expense_inpatient` varchar(20) DEFAULT NULL,
  `expense_diagnostic` varchar(20) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_product_line
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_specialist
-- ----------------------------
DROP TABLE IF EXISTS `m_specialist`;
CREATE TABLE `m_specialist` (
  `sysid` int(11) NOT NULL,
  `specialist_name` varchar(255) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_specialist
-- ----------------------------
BEGIN;
INSERT INTO `m_specialist` (`sysid`, `specialist_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'Spesialis Penyakit Dalam', '1', 'demo@gmail.com', NULL, '2022-10-07 15:50:10');
INSERT INTO `m_specialist` (`sysid`, `specialist_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, 'Spesialis Mata', '1', 'demo@gmail.com', NULL, '2022-10-07 15:50:55');
INSERT INTO `m_specialist` (`sysid`, `specialist_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (3, 'Spesialis THT', '1', 'demo@gmail.com', NULL, '2022-10-07 15:51:46');
INSERT INTO `m_specialist` (`sysid`, `specialist_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (4, 'Spesialis Gigi', '1', 'demo@gmail.com', NULL, '2023-05-09 16:08:47');
INSERT INTO `m_specialist` (`sysid`, `specialist_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (5, 'Spesialis Jantung dan Pembuluh Darah', '1', NULL, NULL, NULL);
INSERT INTO `m_specialist` (`sysid`, `specialist_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (6, 'Spesialis Urologi', '1', 'demo@gmail.com', '2022-10-07 15:50:22', '2022-10-07 15:50:22');
INSERT INTO `m_specialist` (`sysid`, `specialist_name`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (7, 'Spesialis Paru', '1', 'demo@gmail.com', '2022-10-07 15:50:48', '2022-10-07 15:50:48');
COMMIT;

-- ----------------------------
-- Table structure for m_standard_code
-- ----------------------------
DROP TABLE IF EXISTS `m_standard_code`;
CREATE TABLE `m_standard_code` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `standard_code` varchar(10) DEFAULT NULL,
  `descriptions` varchar(255) DEFAULT '',
  `parent_id` int(11) DEFAULT -1,
  `sort_id` int(11) DEFAULT -1,
  `value` varchar(50) DEFAULT '',
  `is_active` tinyint(1) DEFAULT 1,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `uuid_rec` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sysid`),
  KEY `standart_code` (`standard_code`),
  KEY `parent_sysid` (`parent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_standard_code
-- ----------------------------
BEGIN;
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (1, 'C001@R', 'Rutine', 1, -1, '', 1, NULL, NULL, 1, '2023-05-25 16:47:14', 'e5c65f68-591d-49cf-81a5-9eba7590010c');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (2, 'C001@N', 'Non Rutine', 1, -1, '', 1, NULL, NULL, 1, '2023-05-25 16:47:11', 'b341d1a8-39ab-4a4c-81d1-18a10fab1fb6');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (3, 'C002@N', '', 2, -1, '', 1, NULL, NULL, NULL, NULL, 'C002@N');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (4, 'C002@1', 'Barang Umum', 2, -1, '', 1, NULL, NULL, NULL, NULL, 'C002@1');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (5, 'C002@2', 'Service/Jasa', 2, -1, '', 1, NULL, NULL, NULL, NULL, 'C002@2');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (6, 'C002@3', 'Barang Aset', 2, -1, '', 1, NULL, NULL, NULL, NULL, 'C002@3');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (7, 'C002@4', 'Bahan Makanan', 2, -1, '', 1, NULL, NULL, NULL, NULL, 'C002@4');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (8, 'C002@5', 'Alat Kesehatan (Radiologi)', 2, -1, '', 1, NULL, NULL, 1, '2023-05-25 16:42:43', 'a0c50cc8-ddc0-4491-a4cc-f51a3f458ca1');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (9, 'C002@6', 'Obat-Obatan Rawat Jalan', 2, -1, '', 1, NULL, NULL, NULL, NULL, 'C002@6');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (10, 'C002@7', 'Obat-Obatan Rawat Inap', 2, -1, '', 1, NULL, NULL, 1, '2023-05-25 16:40:37', 'daf72fd9-43f9-4979-86ec-5ffc3dc62710');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (11, 'C002@8', 'Alat Kesehatan (Laboratorium)', 2, -1, '', 1, 1, '2023-05-25 16:43:10', NULL, '2023-05-25 16:43:10', '042616c0-740d-4562-a14b-2e8cec7d8bf7');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (12, 'C001@C', 'Campign', 1, -1, '', 1, 1, '2023-05-25 16:47:43', NULL, '2023-05-25 16:47:43', 'e3477e86-c1cb-47a7-bd00-a8a0aee72792');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (13, 'C003@0', '0 hari', 3, -1, '', 1, 1, '2023-05-26 15:37:00', NULL, '2023-05-26 15:37:00', '67343715-ad44-4f3c-907c-7c8871b9d3a3');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (14, 'C003@7', '7 Hari', 3, -1, '', 1, 1, '2023-05-26 15:37:14', NULL, '2023-05-26 15:37:14', 'b7e51b6a-411f-4fb6-bb96-299f1cb9e7d2');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (15, 'C003@14', '14 hari', 3, -1, '', 1, 1, '2023-05-26 15:37:26', 1, '2023-05-26 15:37:37', 'e498d429-6ab4-48b1-b682-7c47d8b25e4f');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (16, 'C003@30', '30 hari', 3, -1, '', 1, 1, '2023-05-26 15:37:52', NULL, '2023-05-26 15:37:52', 'e67e24eb-78f5-4827-9a7b-f4bdea47ac11');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (17, 'C003@45', '45 Hari', 3, -1, '', 1, 1, '2023-05-26 15:38:07', NULL, '2023-05-26 15:38:07', 'e3b3e6a2-6532-490a-9c2e-14eb2f4498f1');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (18, 'C003@60', '60 Hari', 3, -1, '', 1, 1, '2023-05-26 15:38:19', NULL, '2023-05-26 15:38:19', '079358d9-667a-4fa4-aaa7-4e84db915c69');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (19, 'C004@M', 'Barang Medis', 4, -1, 'MEDICAL', 1, 1, '2023-05-30 16:33:07', 1, '2023-06-06 21:46:33', '24bfc210-1b3a-4b8e-b513-7aa25094d011');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (20, 'C004@U', 'Barang Umum', 4, -1, 'GENERAL', 1, 1, '2023-05-30 16:33:21', 1, '2023-06-06 21:46:43', '1223c77d-61af-4cd2-a21e-5bb1fae485f6');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (21, 'C004@G', 'Barang Gizi', 4, -1, 'GIZI', 1, 1, '2023-05-30 16:33:34', 1, '2023-06-06 21:46:49', '91c94082-8e2b-4cde-baf5-3095f4b57013');
INSERT INTO `m_standard_code` (`sysid`, `standard_code`, `descriptions`, `parent_id`, `sort_id`, `value`, `is_active`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (22, 'C004@A', 'Aktiva (Asset)', 4, -1, 'ASSET', 1, 1, '2023-05-30 16:33:55', 1, '2023-06-06 21:46:54', '94071020-aac2-429b-ad62-fa0906b276fd');
COMMIT;

-- ----------------------------
-- Table structure for m_standard_code_group
-- ----------------------------
DROP TABLE IF EXISTS `m_standard_code_group`;
CREATE TABLE `m_standard_code_group` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `parent_code` varchar(10) DEFAULT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `auto_sortable` tinyint(1) DEFAULT 1,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `uuid_rec` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_standard_code_group
-- ----------------------------
BEGIN;
INSERT INTO `m_standard_code_group` (`sysid`, `parent_code`, `descriptions`, `module`, `auto_sortable`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (1, 'C001', 'Jenis Pembelian', NULL, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `m_standard_code_group` (`sysid`, `parent_code`, `descriptions`, `module`, `auto_sortable`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (2, 'C002', 'Jenis Pemesanan', NULL, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `m_standard_code_group` (`sysid`, `parent_code`, `descriptions`, `module`, `auto_sortable`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (3, 'C003', 'Termin Pmbayaran', NULL, 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `m_standard_code_group` (`sysid`, `parent_code`, `descriptions`, `module`, `auto_sortable`, `create_by`, `create_date`, `update_by`, `update_date`, `uuid_rec`) VALUES (4, 'C004', 'Group utama item inventory', NULL, 1, NULL, NULL, NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for m_supplier
-- ----------------------------
DROP TABLE IF EXISTS `m_supplier`;
CREATE TABLE `m_supplier` (
  `sysid` int(11) NOT NULL,
  `supplier_code` varchar(20) DEFAULT NULL,
  `supplier_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone1` varchar(50) DEFAULT NULL,
  `phone2` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `contact_person` varchar(100) DEFAULT NULL,
  `contact_email` varchar(150) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `lead_time` int(11) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `bank_account_name` varchar(100) DEFAULT NULL,
  `bank_account_number` varchar(50) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE,
  KEY `m_supplier_idx1` (`supplier_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_supplier
-- ----------------------------
BEGIN;
INSERT INTO `m_supplier` (`sysid`, `supplier_code`, `supplier_name`, `address`, `phone1`, `phone2`, `fax`, `email`, `contact_person`, `contact_email`, `contact_phone`, `lead_time`, `bank_name`, `bank_account_name`, `bank_account_number`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (4, 'P001', 'PT. Anugrah Pharmindo Lestari', 'Jakarta', '0813', '0812', '021', 'cs@parmindo.com', 'Ade Doank', 'bluem@gmail.com', '0813108', 1, 'Bank BCA', 'Ade', '241817182', '1', 'demo@gmail.com', '2022-10-26 14:24:17', '2023-05-24 13:22:46');
INSERT INTO `m_supplier` (`sysid`, `supplier_code`, `supplier_name`, `address`, `phone1`, `phone2`, `fax`, `email`, `contact_person`, `contact_email`, `contact_phone`, `lead_time`, `bank_name`, `bank_account_name`, `bank_account_number`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (5, 'SP001', 'Toko Buku Sumber Bersama', 'Jakarta', '', '', '', '', '', '', '', 1, '', '', '', '1', 'demo@gmail.com', '2022-10-27 19:58:31', '2023-05-24 13:11:20');
COMMIT;

-- ----------------------------
-- Table structure for m_ward_room_beds
-- ----------------------------
DROP TABLE IF EXISTS `m_ward_room_beds`;
CREATE TABLE `m_ward_room_beds` (
  `sysid` int(11) NOT NULL,
  `ward_sysid` int(11) DEFAULT NULL,
  `room_sysid` int(11) DEFAULT NULL,
  `room_number` varchar(20) DEFAULT NULL,
  `bed_number` varchar(2) DEFAULT NULL,
  `ext_number` varchar(20) DEFAULT NULL,
  `bed_status` varchar(25) DEFAULT NULL,
  `registration_sysid` bigint(20) DEFAULT NULL,
  `registration_number` varchar(20) DEFAULT NULL,
  `medical_record_sysid` int(11) DEFAULT NULL,
  `medical_record_number` varchar(20) DEFAULT NULL,
  `patient_name` varchar(255) DEFAULT NULL,
  `enum_sex` varchar(25) DEFAULT NULL,
  `checkin_date` date DEFAULT NULL,
  `checkin_time` time DEFAULT NULL,
  `is_occupancy_rate` varchar(5) DEFAULT NULL,
  `is_temporary_bed` varchar(5) DEFAULT NULL,
  `service_class_sysid` int(11) DEFAULT NULL,
  `room_class_sysid` int(11) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_ward_room_beds
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for m_ward_rooms
-- ----------------------------
DROP TABLE IF EXISTS `m_ward_rooms`;
CREATE TABLE `m_ward_rooms` (
  `sysid` int(11) NOT NULL,
  `ward_sysid` int(11) DEFAULT NULL,
  `room_number` varchar(20) DEFAULT NULL,
  `capacity` int(11) DEFAULT NULL,
  `occupations` int(11) DEFAULT NULL,
  `is_temporary` varchar(5) DEFAULT NULL,
  `room_class_sysid` int(11) DEFAULT NULL,
  `service_class_sysid` int(11) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_ward_rooms
-- ----------------------------
BEGIN;
INSERT INTO `m_ward_rooms` (`sysid`, `ward_sysid`, `room_number`, `capacity`, `occupations`, `is_temporary`, `room_class_sysid`, `service_class_sysid`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 1, '301', 3, NULL, '0', 8, 8, '1', 'demo@gmail.com', '2022-10-07 21:16:43', '2022-10-07 21:16:43');
COMMIT;

-- ----------------------------
-- Table structure for m_wards
-- ----------------------------
DROP TABLE IF EXISTS `m_wards`;
CREATE TABLE `m_wards` (
  `sysid` int(11) NOT NULL,
  `ward_code` varchar(20) DEFAULT NULL,
  `ward_name` varchar(255) DEFAULT NULL,
  `sort_name` varchar(50) DEFAULT NULL,
  `wh_medical` int(11) DEFAULT NULL,
  `wh_general` int(11) DEFAULT NULL,
  `wh_pharmacy` int(11) DEFAULT NULL,
  `price_class` int(11) DEFAULT NULL,
  `dept_sysid` int(11) DEFAULT NULL,
  `cost_center_sysid` int(11) DEFAULT NULL,
  `is_executive` varchar(5) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_wards
-- ----------------------------
BEGIN;
INSERT INTO `m_wards` (`sysid`, `ward_code`, `ward_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_sysid`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'R1', 'Ruang Perawatan Topas', 'TOPAS', 5, 4, 16, -1, 19, -1, '0', '1', 'demo@gmail.com', '2022-10-07 17:13:30', '2022-10-07 20:16:02');
INSERT INTO `m_wards` (`sysid`, `ward_code`, `ward_name`, `sort_name`, `wh_medical`, `wh_general`, `wh_pharmacy`, `price_class`, `dept_sysid`, `cost_center_sysid`, `is_executive`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, 'R2', 'Ruang Perawatan Zircon', 'ZIRCON', 2, 4, 16, -1, 19, -1, '0', '1', 'demo@gmail.com', '2022-10-07 17:13:53', '2022-10-07 20:16:11');
COMMIT;

-- ----------------------------
-- Table structure for m_warehouse
-- ----------------------------
DROP TABLE IF EXISTS `m_warehouse`;
CREATE TABLE `m_warehouse` (
  `sysid` int(11) NOT NULL,
  `location_code` varchar(20) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `warehouse_type` varchar(30) DEFAULT NULL,
  `is_received` varchar(5) DEFAULT NULL,
  `is_sales` varchar(5) DEFAULT NULL,
  `is_distribution` varchar(5) DEFAULT NULL,
  `warehouse_group` varchar(25) DEFAULT NULL,
  `inventory_account` varchar(20) DEFAULT NULL,
  `expense_account` varchar(20) DEFAULT NULL,
  `variant_account` varchar(20) DEFAULT NULL,
  `cogs_account` varchar(20) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(50) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of m_warehouse
-- ----------------------------
BEGIN;
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'GFRJ01', 'Farmasi Rawat Jalan', NULL, '0', '1', '1', 'MEDICAL', NULL, NULL, NULL, NULL, '1', 'demo@gmail.com', NULL, NULL);
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, 'GFRI01', 'Farmasi Rawat Inap', NULL, '0', '1', '1', 'MEDICAL', NULL, NULL, NULL, NULL, '1', 'demo@gmail.com', NULL, NULL);
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (3, 'GFIGD0', 'Farmasi IGD', NULL, '0', '1', '1', 'MEDICAL', NULL, NULL, NULL, NULL, '1', 'demo@gmail.com', NULL, NULL);
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (4, 'GU0001', 'Gudang Logistik Umum', NULL, '1', '1', '1', 'GENERAL', NULL, NULL, NULL, NULL, '1', 'demo@gmail.com', NULL, NULL);
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (5, 'GF0001', 'Gudang Utama Farmasi', NULL, '1', '1', '1', 'MEDICAL', NULL, NULL, NULL, NULL, '1', 'demo@gmail.com', NULL, NULL);
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (6, 'POLITARUMA', 'POLI TARUMA', NULL, '0', '1', '1', 'GENERAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:03:35', '2022-10-05 17:04:00');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (7, 'POLIROYAL', 'POLI ROYAL', NULL, '0', '1', '1', 'GENERAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:03:52', '2022-10-05 17:03:52');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (8, 'KPE01', 'POLI PENYAKIT DALAM', NULL, '0', '1', '1', 'MEDICAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:04:59', '2022-10-05 17:05:17');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (9, 'KAN01', 'POLI ANAK', NULL, '0', '1', '1', 'MEDICAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:05:31', '2022-10-05 17:06:13');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (10, 'KSA01', 'POLI SYARAF', NULL, '0', '1', '1', 'MEDICAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:05:41', '2022-10-05 17:06:05');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (11, 'KJAN', 'POLI JANTUNG DAN PEMBULUH DARAH', NULL, '0', '1', '1', 'MEDICAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:06:00', '2022-10-05 17:06:00');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (12, 'KTH01', 'POLI THT', NULL, '0', '1', '1', 'MEDICAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:06:32', '2022-10-05 17:07:57');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (13, 'KPA01', 'POLI PARU', NULL, '0', '1', '1', 'MEDICAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:06:50', '2022-10-05 17:07:48');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (14, 'KMA01', 'POLI MATA', NULL, '0', '1', '1', 'MEDICAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:07:35', '2022-10-05 17:07:44');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (15, 'KBU01', 'POLI BEDAH UMUM', NULL, '0', '1', '1', 'MEDICAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:08:21', '2022-10-05 17:08:21');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (16, 'KOR', 'POLI ORTHOPEDI', NULL, '0', '1', '1', 'MEDICAL', '', '', '', '', '1', 'demo@gmail.com', '2022-10-05 17:08:47', '2022-10-05 17:08:47');
INSERT INTO `m_warehouse` (`sysid`, `location_code`, `location_name`, `warehouse_type`, `is_received`, `is_sales`, `is_distribution`, `warehouse_group`, `inventory_account`, `expense_account`, `variant_account`, `cogs_account`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (17, 'DP01', 'Gudang Gizi', NULL, '1', '1', '1', 'NUTRITION', '', '', '', '', '1', 'demo@gmail.com', '2022-10-19 16:20:14', '2022-10-19 16:20:14');
COMMIT;

-- ----------------------------
-- Table structure for o_documents
-- ----------------------------
DROP TABLE IF EXISTS `o_documents`;
CREATE TABLE `o_documents` (
  `sysid` bigint(20) NOT NULL,
  `document_code` char(25) NOT NULL,
  `descriptions` varchar(255) DEFAULT NULL,
  `update_userid` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Ini tabel untuk dokumen transaksi';

-- ----------------------------
-- Records of o_documents
-- ----------------------------
BEGIN;
INSERT INTO `o_documents` (`sysid`, `document_code`, `descriptions`, `update_userid`, `create_date`, `update_date`) VALUES (1, 'REG', 'Patient Registration', NULL, NULL, NULL);
INSERT INTO `o_documents` (`sysid`, `document_code`, `descriptions`, `update_userid`, `create_date`, `update_date`) VALUES (2, 'CSH', 'Patient Payment', NULL, NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for o_numbers
-- ----------------------------
DROP TABLE IF EXISTS `o_numbers`;
CREATE TABLE `o_numbers` (
  `document_code` varchar(25) NOT NULL,
  `years_period` int(11) NOT NULL,
  `month_period` int(11) NOT NULL,
  `counter` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`document_code`,`years_period`,`month_period`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Tabel untuk counter nomor  link ke o_document, nomor ini di generate per tahun dan perbulan.';

-- ----------------------------
-- Records of o_numbers
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for o_objects
-- ----------------------------
DROP TABLE IF EXISTS `o_objects`;
CREATE TABLE `o_objects` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `sort_number` int(11) DEFAULT -1,
  `parent_sysid` int(11) DEFAULT -1,
  `object_level` int(11) DEFAULT -1,
  `title` varchar(100) DEFAULT '',
  `descriptions` longtext DEFAULT NULL,
  `icons` varchar(100) DEFAULT NULL,
  `is_parent` varchar(5) DEFAULT '0',
  `url_link` varchar(255) DEFAULT '',
  `security` text DEFAULT NULL,
  `column_def` longtext DEFAULT NULL,
  `page_title` varchar(255) DEFAULT '',
  `api_link` text DEFAULT NULL,
  `is_active` varchar(5) DEFAULT '1',
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of o_objects
-- ----------------------------
BEGIN;
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (5, 99000, -1, 0, 'Seting Sistem', NULL, 'fa-solid fa-gear', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (6, 99001, 99000, 1, 'User & Group', NULL, 'fa-solid fa-users', '0', '/access/user', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true},\r\n{\"action\":\"password\",\"caption\":\"Password\",\"icon\":\"vpn_key\",\"onclick\":\"password\",\"tooltips\":\"Ubah Password\",\"is_show\":true},\r\n{\"action\":\"access\",\"caption\":\"Hak Akses\",\"icon\":\"how_to_reg\",\"onclick\":\"access_setup\",\"tooltips\":\"Hak akses\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                            ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"user_name\", \"align\": \"left\", \"label\": \"User ID\", \"field\": \"user_name\",\"sortable\": true },\r\n  { \"name\": \"full_name\", \"align\": \"left\", \"label\": \"Nama User\", \"field\": \"full_name\",\"sortable\": true  },\r\n  { \"name\": \"email\", \"align\": \"left\", \"label\": \"email\", \"field\": \"email\" },\r\n  { \"name\": \"phone\", \"align\": \"left\", \"label\": \"Telp\", \"field\": \"phone\" },\r\n  { \"name\": \"is_active\", \"align\": \"center\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"user_level\", \"align\": \"left\", \"label\": \"Level\", \"field\": \"user_level\" },\r\n  { \"name\": \"is_group\", \"align\": \"center\", \"label\": \"Group\", \"field\": \"is_group\" }\r\n]\r\n', 'User & Grup', '{\"retrieve\":\"user/users\",\"save\":\"user/users\",\"delete\":\"user/users\",\"edit\":\"user/users/get\",\"password\":\"user/userspwd\",\"access\":\"user/useraccess\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (10, 14000, -1, 0, 'Instalasi Gawat Darurat', NULL, 'fa-solid fa-truck-medical', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (11, 15000, -1, 0, 'Rawat Inap', NULL, 'fa-solid fa-bed-pulse', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (12, 16000, -1, 0, 'Laboratorium', NULL, 'fa-solid fa-vial-virus', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (13, 17000, -1, 0, 'Radiologi', NULL, 'fa-solid fa-x-ray', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (15, 18000, -1, 0, 'Penunjang Medis', NULL, 'fa-solid fa-suitcase-medical', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (16, 19000, -1, 0, 'Medical Checkup', NULL, 'fa-solid fa-heart-circle-check', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (17, 20000, -1, 0, 'Rekam Medis', NULL, 'fa-solid fa-notes-medical', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (18, 21000, -1, 0, 'Farmasi', NULL, 'fa-solid fa-prescription', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (19, 22000, -1, 0, 'Keperawatan', NULL, 'fa-solid fa-user-nurse', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (21, 23000, -1, 0, 'Inventory', NULL, 'fa-solid fa-cart-flatbed', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (22, 24000, -1, 0, 'Keuangan', NULL, 'fa-solid fa-coins', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (23, 25000, -1, 0, 'Akunting', NULL, 'fa-solid fa-calculator', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (24, 26000, -1, 0, 'Gizi', NULL, 'fa-solid fa-bowl-rice', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (29, 13000, -1, 0, 'Rawat Jalan', NULL, 'fa-solid fa-user-injured', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (31, 24101, 24100, 2, 'Kelompok Pelayanan', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (32, 24102, 24100, 2, 'Jasa Pelayanan', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (33, 24103, 24100, 2, 'Laboratorium', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (34, 24104, 24100, 2, 'Radiologi', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (35, 24105, 24100, 2, 'Penunjang Medis Lainnya', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (38, 23112, 23100, 2, 'Kelompok Barang', NULL, 'fa-solid fa-group-arrows-rotate', '0', '/master/inventory/inventory-group', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"group_code\", \"align\": \"left\", \"label\": \"Group\", \"field\": \"group_code\",\"sortable\": true },\r\n  { \"name\": \"group_name\", \"align\": \"left\", \"label\": \"Keterangan\", \"field\": \"group_name\",\"sortable\": true  },\r\n  { \"name\": \"inventory_account\", \"align\": \"left\", \"label\": \"Akun Stock\", \"field\": \"inventory_account\"},\r\n  { \"name\": \"cogs_account\", \"align\": \"left\", \"label\": \"Akun HPP\", \"field\": \"cogs_account\"},\r\n  { \"name\": \"cost_account\", \"align\": \"left\", \"label\": \"Akun Biaya\", \"field\": \"cost_account\"},\r\n  { \"name\": \"variant_account\", \"align\": \"left\", \"label\": \"Akuan Variant\", \"field\": \"variant_account\"},\r\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Group Inventory', '{\r\n\"retrieve\":\"master/inventory/inventory-group\",\r\n\"save\":\"master/inventory/inventory-group\",\r\n\"delete\":\"master/inventory/inventory-group\",\r\n\"edit\":\"master/inventory/inventory-group/get\"\r\n}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (39, 23300, 23000, 2, 'Master Inventory', NULL, 'fa-solid fa-boxes-stacked', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (40, 23310, 23300, 3, 'Inventory Medis', NULL, 'fa-solid fa-capsules', '0', '/master/inventory/items-medical', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true},\r\n{\"action\":\"supplier\",\"caption\":\"Harga per supplier\",\"icon\":\"fa-solid fa-handshake-simple\",\"onclick\":\"supplier_event\",\"tooltips\":\"Harga per supplier\",\"is_show\":true},\r\n{\"action\":\"price\",\"caption\":\"Harga Jual\",\"icon\":\"fa-solid fa-tags\",\"onclick\":\"supplier_event\",\"tooltips\":\"Harga Jual\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                         ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"item_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"item_code\",\"sortable\": true },\r\n  { \"name\": \"item_code_old\", \"align\": \"left\", \"label\": \"Kode Lama\", \"field\": \"item_code_old\",\"sortable\": true  },\r\n  { \"name\": \"item_name1\", \"align\": \"left\", \"label\": \"Nama Item\", \"field\": \"item_name1\"},\r\n  { \"name\": \"trademark_name\", \"align\": \"left\", \"label\": \"Merk Dagang\", \"field\": \"trademark_name\"},\r\n  { \"name\": \"mou_inventory\", \"align\": \"left\", \"label\": \"Satuan Simpan\", \"field\": \"mou_inventory\"},\r\n  { \"name\": \"manufactur\", \"align\": \"left\", \"label\": \"Manufaktur/Pabrik\", \"field\": \"manufactur\"},\r\n  { \"name\": \"supplier_name\", \"align\": \"left\", \"label\": \"Supplier\", \"field\": \"supplier_name\"},\r\n  { \"name\": \"het_price\", \"align\": \"right\", \"label\": \"HET\", \"field\": \"het_price\"},\r\n  { \"name\": \"hna\", \"align\": \"right\", \"label\": \"HNA\", \"field\": \"hna\"},\r\n  { \"name\": \"on_hand\", \"align\": \"right\", \"label\": \"Stock Gudang\", \"field\": \"on_hand\"},\r\n  { \"name\": \"on_hand_unit\", \"align\": \"right\", \"label\": \"Stock Unit\", \"field\": \"on_hand_unit\"},\r\n  { \"name\": \"group_name\", \"align\": \"left\", \"label\": \"Grup Inventory\", \"field\": \"group_name\"},\r\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Item inventory medis', '{\r\n\"retrieve\":\"master/inventory/inventory-item\",\r\n\"save\":\"master/inventory/inventory-item\",\r\n\"delete\":\"master/inventory/inventory-item\",\r\n\"edit\":\"master/inventory/inventory-item/get\"\r\n}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (41, 23311, 23300, 3, 'Inventory Umum', NULL, 'fa-solid fa-gift', '0', '/master/inventory/items-general', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true},\r\n{\"action\":\"supplier\",\"caption\":\"Harga per supplier\",\"icon\":\"fa-solid fa-handshake-simple\",\"onclick\":\"supplier_event\",\"tooltips\":\"Harga per supplier\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                 ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"item_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"item_code\",\"sortable\": true },\r\n  { \"name\": \"item_code_old\", \"align\": \"left\", \"label\": \"Kode Lama\", \"field\": \"item_code_old\",\"sortable\": true  },\r\n  { \"name\": \"item_name1\", \"align\": \"left\", \"label\": \"Nama Item\", \"field\": \"item_name1\"},\r\n  { \"name\": \"trademark_name\", \"align\": \"left\", \"label\": \"Merk Dagang\", \"field\": \"trademark_name\"},\r\n  { \"name\": \"mou_inventory\", \"align\": \"left\", \"label\": \"Satuan Simpan\", \"field\": \"mou_inventory\"},\r\n  { \"name\": \"manufactur\", \"align\": \"left\", \"label\": \"Manufaktur/Pabrik\", \"field\": \"manufactur\"},\r\n  { \"name\": \"supplier_name\", \"align\": \"left\", \"label\": \"Supplier\", \"field\": \"supplier_name\"},\r\n  { \"name\": \"on_hand\", \"align\": \"right\", \"label\": \"Stock Gudang\", \"field\": \"on_hand\"},\r\n  { \"name\": \"on_hand_unit\", \"align\": \"right\", \"label\": \"Stock Unit\", \"field\": \"on_hand_unit\"},\r\n  { \"name\": \"group_name\", \"align\": \"left\", \"label\": \"Grup Inventory\", \"field\": \"group_name\"},\r\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Item inventory Umum', '{\r\n\"retrieve\":\"master/inventory/inventory-item\",\r\n\"save\":\"master/inventory/inventory-item\",\r\n\"delete\":\"master/inventory/inventory-item\",\r\n\"edit\":\"master/inventory/inventory-item/get\"\r\n}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (42, 23312, 23300, 3, 'Inventory Gizi', NULL, 'fa-solid fa-kitchen-set', '0', '/master/inventory/items-kitchen', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true},\r\n{\"action\":\"supplier\",\"caption\":\"Harga per supplier\",\"icon\":\"fa-solid fa-handshake-simple\",\"onclick\":\"supplier_event\",\"tooltips\":\"Harga per supplier\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                 ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"item_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"item_code\",\"sortable\": true },\r\n  { \"name\": \"item_code_old\", \"align\": \"left\", \"label\": \"Kode Lama\", \"field\": \"item_code_old\",\"sortable\": true  },\r\n  { \"name\": \"item_name1\", \"align\": \"left\", \"label\": \"Nama Item\", \"field\": \"item_name1\"},\r\n  { \"name\": \"trademark_name\", \"align\": \"left\", \"label\": \"Merk Dagang\", \"field\": \"trademark_name\"},\r\n  { \"name\": \"mou_inventory\", \"align\": \"left\", \"label\": \"Satuan Simpan\", \"field\": \"mou_inventory\"},\r\n  { \"name\": \"manufactur\", \"align\": \"left\", \"label\": \"Manufaktur/Pabrik\", \"field\": \"manufactur\"},\r\n  { \"name\": \"supplier_name\", \"align\": \"left\", \"label\": \"Supplier\", \"field\": \"supplier_name\"},\r\n  { \"name\": \"on_hand\", \"align\": \"right\", \"label\": \"Stock Gudang\", \"field\": \"on_hand\"},\r\n  { \"name\": \"on_hand_unit\", \"align\": \"right\", \"label\": \"Stock Unit\", \"field\": \"on_hand_unit\"},\r\n  { \"name\": \"group_name\", \"align\": \"left\", \"label\": \"Grup Inventory\", \"field\": \"group_name\"},\r\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Item inventory Gizi/Dapur', '{\r\n\"retrieve\":\"master/inventory/inventory-item\",\r\n\"save\":\"master/inventory/inventory-item\",\r\n\"delete\":\"master/inventory/inventory-item\",\r\n\"edit\":\"master/inventory/inventory-item/get\"\r\n}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (44, 24100, 24000, 1, 'Jasa Pelayanan', NULL, 'fa-solid fa-notes-medical', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (45, 24200, 24000, 1, 'Tarif ', NULL, 'fa-solid fa-tag', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (46, 24206, 24200, 2, 'Tarif Pelayanan', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (47, 24208, 24200, 2, 'Tarif Laboratorium', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (48, 24210, 24200, 2, 'Tarif Radiologi', NULL, NULL, '0', ' ', NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (49, 24209, 24200, 2, 'Tarif Penunjang Medis Lainnya', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (50, 99202, 99200, 2, 'Kelas Perawatan', NULL, 'fa-regular fa-star', '0', '/setup/class', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"price_code\", \"align\": \"left\", \"label\": \"Kode Tarif\", \"field\": \"price_code\",\"sortable\": true },\r\n  { \"name\": \"descriptions\", \"align\": \"left\", \"label\": \"Nama Tarif\", \"field\": \"descriptions\",\"sortable\": true  },\r\n  { \"name\": \"sort_name\", \"align\": \"left\", \"label\": \"Singkatan\", \"field\": \"sort_name\" },\r\n  { \"name\": \"is_price_class\", \"align\": \"left\", \"label\": \"Kelas Rawat\", \"field\": \"is_price_class\" },\r\n  { \"name\": \"is_service_class\", \"align\": \"center\", \"label\": \"Kelas Jasa\", \"field\": \"is_service_class\" },\r\n  { \"name\": \"is_pharmacy_class\", \"align\": \"center\", \"label\": \"Kelas Farmasi\", \"field\": \"is_pharmacy_class\" },\r\n  { \"name\": \"factor_inpatient\", \"align\": \"right\", \"label\": \"% Margin Kamar\", \"field\": \"factor_inpatient\" },\r\n  { \"name\": \"factor_service\", \"align\": \"right\", \"label\": \"% Margin Jasa\", \"field\": \"factor_service\" },\r\n  { \"name\": \"factor_pharmacy\", \"align\": \"right\", \"label\": \"% Margin Farmasi\", \"field\": \"factor_pharmacy\" },\r\n  { \"name\": \"minimum_deposit\", \"align\": \"right\", \"label\": \"Min. Deposit\", \"field\": \"minimum_deposit\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Kelas', '{\"retrieve\":\"setup/class\",\"save\":\"setup/class\",\"delete\":\"setup/class\",\"edit\":\"setup/class/get\"}\r\n', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (52, 24600, 24000, 1, 'Bank', NULL, '  ', '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (53, 24601, 24600, 2, 'Bank', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (54, 24300, 24000, 1, 'Rekanan', NULL, 'fa-solid fa-handshake', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (55, 24301, 24300, 2, 'Kelompok Rekanan', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (56, 24302, 24300, 2, 'Rekanan/Instansi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (58, 24303, 24300, 2, 'Supplier', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (59, 24602, 24600, 2, 'Terimal EDC', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (60, 24603, 24600, 2, 'Surcharge EDC', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (61, 25100, 25000, 1, 'Data Master', NULL, 'fa-solid fa-folder', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (62, 25101, 25100, 2, 'Chart of Jurnal', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (63, 25102, 25100, 2, 'Voucher Jurnal', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (65, 25103, 25100, 2, 'Tipe Jurnal', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (66, 25600, 25000, 1, 'Jurnal', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (67, 25601, 25600, 2, 'Pencatatan Jurnal', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (68, 25602, 25600, 2, 'Proses Jurnal Otomatis', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (69, 99111, 99110, 2, 'Klinik', NULL, 'fa-solid fa-user-nurse', '0', '/setup/clinic', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"dept_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"dept_code\",\"sortable\": true },\r\n  { \"name\": \"dept_name\", \"align\": \"left\", \"label\": \"Nama Klinik\", \"field\": \"dept_name\",\"sortable\": true  },\r\n  { \"name\": \"sort_name\", \"align\": \"left\", \"label\": \"Singkatan\", \"field\": \"sort_name\" },\r\n  { \"name\": \"wh_medical_code\", \"align\": \"left\", \"label\": \"Gudang Obat\", \"field\": \"wh_medical_code\" },\r\n  { \"name\": \"wh_general_code\", \"align\": \"left\", \"label\": \"Gudang Umum\", \"field\": \"wh_general_code\" },\r\n  { \"name\": \"dept_code_pharmacy\", \"align\": \"left\", \"label\": \"Farmasi\", \"field\": \"dept_code_pharmacy\" },\r\n  { \"name\": \"price_class_name\", \"align\": \"left\", \"label\": \"Kelas Tarif\", \"field\": \"price_class_name\" },\r\n  { \"name\": \"setting\", \"align\": \"left\", \"label\": \"Seting\", \"field\": \"setting\" },\r\n  { \"name\": \"update_userid\", \"align\": \"left\", \"label\": \"User ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Tgl..Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]\r\n', 'Klinik', '{\"retrieve\":\"setup/department\",\"save\":\"setup/department\",\"delete\":\"setup/department\",\"edit\":\"setup/department/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (70, 99112, 99110, 2, 'Instalasi Gawat Darurat', NULL, 'fa-solid fa-truck-medical', '0', '/setup/igd', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"dept_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"dept_code\",\"sortable\": true },\r\n  { \"name\": \"dept_name\", \"align\": \"left\", \"label\": \"Pelayanan Gawat Darurat\", \"field\": \"dept_name\",\"sortable\": true  },\r\n  { \"name\": \"sort_name\", \"align\": \"left\", \"label\": \"Singkatan\", \"field\": \"sort_name\" },\r\n  { \"name\": \"wh_medical_code\", \"align\": \"left\", \"label\": \"Gudang Obat\", \"field\": \"wh_medical_code\" },\r\n  { \"name\": \"wh_general_code\", \"align\": \"left\", \"label\": \"Gudang Umum\", \"field\": \"wh_general_code\" },\r\n  { \"name\": \"dept_code_pharmacy\", \"align\": \"left\", \"label\": \"Farmasi\", \"field\": \"dept_code_pharmacy\" },\r\n  { \"name\": \"price_class_name\", \"align\": \"left\", \"label\": \"Kelas Tarif\", \"field\": \"price_class_name\" },\r\n  { \"name\": \"setting\", \"align\": \"left\", \"label\": \"Seting\", \"field\": \"setting\" },\r\n  { \"name\": \"update_userid\", \"align\": \"left\", \"label\": \"User ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Tgl..Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Instalasi Gawat Darurat', '{\"retrieve\":\"setup/department\",\"save\":\"setup/department\",\"delete\":\"setup/department\",\"edit\":\"setup/department/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (72, 99114, 99110, 2, 'Penunjang Medis', NULL, 'fa-solid fa-flask-vial', '0', '/setup/diagnostic', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"dept_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"dept_code\",\"sortable\": true },\r\n  { \"name\": \"dept_name\", \"align\": \"left\", \"label\": \"Nama Klinik\", \"field\": \"dept_name\",\"sortable\": true  },\r\n  { \"name\": \"sort_name\", \"align\": \"left\", \"label\": \"Singkatan\", \"field\": \"sort_name\" },\r\n  { \"name\": \"wh_medical_code\", \"align\": \"left\", \"label\": \"Gudang Obat\", \"field\": \"wh_medical_code\" },\r\n  { \"name\": \"wh_general_code\", \"align\": \"left\", \"label\": \"Gudang Umum\", \"field\": \"wh_general_code\" },\r\n  { \"name\": \"setting\", \"align\": \"left\", \"label\": \"Seting\", \"field\": \"setting\" },\r\n  { \"name\": \"update_userid\", \"align\": \"left\", \"label\": \"User ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Tgl..Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Penunjang Medis', '{\"retrieve\":\"setup/department\",\"save\":\"setup/department\",\"delete\":\"setup/department\",\"edit\":\"setup/department/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (73, 99115, 99110, 2, 'Medical Checkup', NULL, 'fa-solid fa-circle-radiation', '0', '/setup/medicalcheckup', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"dept_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"dept_code\",\"sortable\": true },\r\n  { \"name\": \"dept_name\", \"align\": \"left\", \"label\": \"Layanan Medical Check Up\", \"field\": \"dept_name\",\"sortable\": true  },\r\n  { \"name\": \"sort_name\", \"align\": \"left\", \"label\": \"Singkatan\", \"field\": \"sort_name\" },\r\n  { \"name\": \"wh_medical_code\", \"align\": \"left\", \"label\": \"Gudang Obat\", \"field\": \"wh_medical_code\" },\r\n  { \"name\": \"wh_general_code\", \"align\": \"left\", \"label\": \"Gudang Umum\", \"field\": \"wh_general_code\" },\r\n  { \"name\": \"dept_code_pharmacy\", \"align\": \"left\", \"label\": \"Farmasi\", \"field\": \"dept_code_pharmacy\" },\r\n  { \"name\": \"price_class_name\", \"align\": \"left\", \"label\": \"Kelas Tarif\", \"field\": \"price_class_name\" },\r\n  { \"name\": \"setting\", \"align\": \"left\", \"label\": \"Seting\", \"field\": \"setting\" },\r\n  { \"name\": \"update_userid\", \"align\": \"left\", \"label\": \"User ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Tgl..Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Medical Checkup', '{\"retrieve\":\"setup/department\",\"save\":\"setup/department\",\"delete\":\"setup/department\",\"edit\":\"setup/department/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (75, 99116, 99110, 2, 'Farmasi', NULL, 'fa-solid fa-prescription-bottle-medical', '0', '/setup/pharmacy', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"dept_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"dept_code\",\"sortable\": true },\r\n  { \"name\": \"dept_name\", \"align\": \"left\", \"label\": \"Layanan Farmasi\", \"field\": \"dept_name\",\"sortable\": true  },\r\n  { \"name\": \"sort_name\", \"align\": \"left\", \"label\": \"Singkatan\", \"field\": \"sort_name\" },\r\n  { \"name\": \"wh_medical_code\", \"align\": \"left\", \"label\": \"Gudang Obat\", \"field\": \"wh_medical_code\" },\r\n  { \"name\": \"wh_general_code\", \"align\": \"left\", \"label\": \"Gudang Umum\", \"field\": \"wh_general_code\" },\r\n  { \"name\": \"setting\", \"align\": \"left\", \"label\": \"Seting\", \"field\": \"setting\" },\r\n  { \"name\": \"update_userid\", \"align\": \"left\", \"label\": \"User ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Tgl..Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Pharmacy', '{\"retrieve\":\"setup/department\",\"save\":\"setup/department\",\"delete\":\"setup/department\",\"edit\":\"setup/department/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (77, 15101, 15100, 2, 'Kamar Perawatan', NULL, 'fa-solid fa-bed', '0', '/setup/wardroom', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"price_code\", \"align\": \"left\", \"label\": \"Kode Tarif\", \"field\": \"price_code\",\"sortable\": true },\r\n  { \"name\": \"descriptions\", \"align\": \"left\", \"label\": \"Nama Tarif\", \"field\": \"descriptions\",\"sortable\": true  },\r\n  { \"name\": \"sort_name\", \"align\": \"left\", \"label\": \"Singkatan\", \"field\": \"sort_name\" },\r\n  { \"name\": \"is_price_class\", \"align\": \"left\", \"label\": \"Kelas Rawat\", \"field\": \"is_price_class\" },\r\n  { \"name\": \"is_service_class\", \"align\": \"center\", \"label\": \"Kelas Jasa\", \"field\": \"is_service_class\" },\r\n  { \"name\": \"is_pharmacy_class\", \"align\": \"center\", \"label\": \"Kelas Farmasi\", \"field\": \"is_pharmacy_class\" },\r\n  { \"name\": \"factor_inpatient\", \"align\": \"right\", \"label\": \"% Margin Kamar\", \"field\": \"factor_inpatient\" },\r\n  { \"name\": \"factor_service\", \"align\": \"right\", \"label\": \"% Margin Jasa\", \"field\": \"factor_service\" },\r\n  { \"name\": \"factor_pharmacy\", \"align\": \"right\", \"label\": \"% Margin Farmasi\", \"field\": \"factor_pharmacy\" },\r\n  { \"name\": \"minimum_deposit\", \"align\": \"right\", \"label\": \"Min. Deposit\", \"field\": \"minimum_deposit\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (78, 99207, 99200, 2, 'Dokter & Paramedik', NULL, 'fa-solid fa-user-doctor', '0', '/setup/paramedic', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"paramedic_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"paramedic_code\",\"sortable\": true },\r\n  { \"name\": \"paramedic_name\", \"align\": \"left\", \"label\": \"Nama Dokter/Paramedic\", \"field\": \"paramedic_name\",\"sortable\": true  },\r\n  { \"name\": \"paramedic_type\", \"align\": \"left\", \"label\": \"Grup\", \"field\": \"paramedic_type\" },\r\n  { \"name\": \"price_group\", \"align\": \"left\", \"label\": \"Grup Tarif\", \"field\": \"price_group\" },\r\n  { \"name\": \"is_internal\", \"align\": \"center\", \"label\": \"Internal\", \"field\": \"is_internal\" },\r\n  { \"name\": \"is_permanent\", \"align\": \"center\", \"label\": \"Tetap\", \"field\": \"is_permanent\" },\r\n  { \"name\": \"tax_number\", \"align\": \"center\", \"label\": \"N.P.W.P\", \"field\": \"tax_number\" },\r\n  { \"name\": \"is_transfer\", \"align\": \"center\", \"label\": \"Transfer\", \"field\": \"is_transfer\" },\r\n  { \"name\": \"specialist_name\", \"align\": \"left\", \"label\": \"Spesialis\", \"field\": \"specialist_name\" },\r\n  { \"name\": \"bank_name\", \"align\": \"left\", \"label\": \"Nama Bank\", \"field\": \"bank_name\" },\r\n  { \"name\": \"account_name\", \"align\": \"left\", \"label\": \"Nama Akun\", \"field\": \"account_name\" },\r\n  { \"name\": \"account_number\", \"align\": \"left\", \"label\": \"Nomor Akun\", \"field\": \"account_number\" },\r\n  { \"name\": \"is_email_reports\", \"align\": \"center\", \"label\": \"Diemail\", \"field\": \"is_email_reports\" },\r\n  { \"name\": \"email\", \"align\": \"center\", \"label\": \"Email\", \"field\": \"email\" },\r\n  { \"name\": \"update_userid\", \"align\": \"left\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Paramedik', '{\"retrieve\":\"setup/paramedic\",\"save\":\"setup/paramedic\",\"delete\":\"setup/paramedic\",\"edit\":\"setup/paramedic/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (82, 99117, 99110, 2, 'Rawat Inap', NULL, 'fa-regular fa-hospital', '0', '/setup/inpatient', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"dept_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"dept_code\",\"sortable\": true },\r\n  { \"name\": \"dept_name\", \"align\": \"left\", \"label\": \"Pelayanan Rawat Inap\", \"field\": \"dept_name\",\"sortable\": true  },\r\n  { \"name\": \"sort_name\", \"align\": \"left\", \"label\": \"Singkatan\", \"field\": \"sort_name\" },\r\n  { \"name\": \"setting\", \"align\": \"left\", \"label\": \"Seting\", \"field\": \"setting\" },\r\n  { \"name\": \"update_userid\", \"align\": \"left\", \"label\": \"User ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Tgl..Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Rawat Inap', '{\"retrieve\":\"setup/department\",\"save\":\"setup/department\",\"delete\":\"setup/department\",\"edit\":\"setup/department/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (83, 99110, 99000, 1, 'Unit Pelayanan', NULL, 'fa-solid fa-stethoscope', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (92, 99204, 99200, 2, 'Level Tarif', NULL, 'fa-solid fa-arrows-spin', '0', '/setup/pricelevel', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"level_code\", \"align\": \"left\", \"label\": \"Level Tarif\", \"field\": \"level_code\",\"sortable\": true },\r\n  { \"name\": \"descriptions\", \"align\": \"left\", \"label\": \"Nama Tarif\", \"field\": \"descriptions\",\"sortable\": true  },\r\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Level Tarif', '{\"retrieve\":\"setup/pricelevel\",\"save\":\"setup/pricelevel\",\"delete\":\"setup/pricelevel\",\"edit\":\"setup/pricelevel/get\"}\r\n', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (93, 23100, 23000, 1, 'Data Master', NULL, 'fa-solid fa-folder', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (94, 23110, 23100, 2, 'Gudang/Lokasi', NULL, 'fa-solid fa-warehouse', '0', '/master/inventory/warehouse', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"loc_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"loc_code\",\"sortable\": true },\r\n  { \"name\": \"location_name\", \"align\": \"left\", \"label\": \"Nama Gudang\", \"field\": \"location_name\",\"sortable\": true  },\r\n  { \"name\": \"is_received\", \"align\": \"left\", \"label\": \"Terima\", \"field\": \"is_received\",\"sortable\": true  },\r\n  { \"name\": \"is_sales\", \"align\": \"left\", \"label\": \"Jual\", \"field\": \"is_sales\",\"sortable\": true  },\r\n  { \"name\": \"is_distribution\", \"align\": \"left\", \"label\": \"Distribusi\", \"field\": \"is_distribution\",\"sortable\": true  },\r\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Gudang/Lokasi Stock', '{\"retrieve\":\"master/inventory/warehouse\",\"save\":\"master/inventory/warehouse\",\"delete\":\"master/inventory/warehouse\",\"edit\":\"master/inventory/warehouse/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (95, 15100, 15000, 1, 'Data Master', NULL, 'fa-solid fa-folder', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (98, 99200, 99000, 1, 'Rumah Sakit', NULL, 'fa-solid fa-hospital', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (102, 99205, 99200, 2, 'Golongan Dokter/Paramedik', NULL, 'fa-solid fa-group-arrows-rotate', '0', '/setup/paramedic-group', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"group_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"group_code\",\"sortable\": true },\r\n  { \"name\": \"group_name\", \"align\": \"left\", \"label\": \"Golongan Dokter/Paramedik\", \"field\": \"group_name\",\"sortable\": true  },\r\n  { \"name\": \"is_active\", \"align\": \"center\", \"label\": \"Alktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"left\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Golongan Dokter/Paramedik', '{\"retrieve\":\"setup/price-group\",\"save\":\"setup/price-group\",\"delete\":\"setup/price-group\",\"edit\":\"setup/price-group/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (103, 99206, 99200, 2, 'Spesialis Dokter/Paramedik', NULL, 'fa-solid fa-lungs', '0', '/setup/specialist', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"specialist_name\", \"align\": \"left\", \"label\": \"Spesialiasi\", \"field\": \"specialist_name\",\"sortable\": true },\r\n  { \"name\": \"is_active\", \"align\": \"center\", \"label\": \"Alktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"left\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Spesialisasi', '{\"retrieve\":\"setup/specialist\",\"save\":\"setup/specialist\",\"delete\":\"setup/specialist\",\"edit\":\"setup/specialist/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (104, 99201, 99200, 2, 'Ruang Perawatan', NULL, 'fa-solid fa-person-dots-from-line', '0', '/setup/ward', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"ward_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"ward_code\",\"sortable\": true },\r\n  { \"name\": \"ward_name\", \"align\": \"left\", \"label\": \"Nama Ruangan\", \"field\": \"ward_name\",\"sortable\": true  },\r\n  { \"name\": \"sort_name\", \"align\": \"left\", \"label\": \"Singkatan\", \"field\": \"sort_name\" },\r\n  { \"name\": \"inpatient_service\", \"align\": \"left\", \"label\": \"Jenis Layanan Rawat Inap\", \"field\": \"inpatient_service\" },\r\n  { \"name\": \"wh_medical_code\", \"align\": \"left\", \"label\": \"Gudang Obat\", \"field\": \"wh_medical_code\" },\r\n  { \"name\": \"wh_general_code\", \"align\": \"left\", \"label\": \"Gudang Umum\", \"field\": \"wh_general_code\" },\r\n  { \"name\": \"dept_code_pharmacy\", \"align\": \"left\", \"label\": \"Farmasi\", \"field\": \"dept_code_pharmacy\" },\r\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Ruang Perawatan', '{\"retrieve\":\"setup/ward\",\"save\":\"setup/ward\",\"delete\":\"setup/ward\",\"edit\":\"setup/ward/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (106, 99203, 99200, 2, 'Kamar Perawatan', NULL, 'fa-solid fa-bed', '0', '/setup/rooms', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"room_number\", \"align\": \"left\", \"label\": \"No. Kamar\", \"field\": \"room_number\",\"sortable\": true },\r\n  { \"name\": \"capacity\", \"align\": \"left\", \"label\": \"Jumlah Bed\", \"field\": \"capacity\"},\r\n  { \"name\": \"room_class\", \"align\": \"left\", \"label\": \"Kelas Perawatan\", \"field\": \"room_class\" },\r\n  { \"name\": \"service_class\", \"align\": \"left\", \"label\": \"Kelas Jasa\", \"field\": \"service_class\" },\r\n  { \"name\": \"is_temporary\", \"align\": \"left\", \"label\": \"Kamar Sementara\", \"field\": \"is_temporary\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Kamar Perawatan', '{\"retrieve\":\"setup/rooms\",\"save\":\"setup/rooms\",\"delete\":\"setup/rooms\",\"edit\":\"setup/rooms/get\"}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (108, 23111, 23100, 2, 'Satuan/Unit', NULL, 'fa-solid fa-weight-scale', '0', '/master/inventory/mou', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"mou_name\", \"align\": \"left\", \"label\": \"Satuan/Unit\", \"field\": \"mou_name\",\"sortable\": true },\r\n  { \"name\": \"descriptions\", \"align\": \"left\", \"label\": \"Nama Keterangan\", \"field\": \"descriptions\",\"sortable\": true  },\r\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Satuan/Unit', '{\r\n\"retrieve\":\"master/inventory/mou\",\r\n\"save\":\"master/inventory/mou\",\r\n\"delete\":\"master/inventory/mou\",\r\n\"edit\":\"master/inventory/mou/get\"\r\n}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (110, 23113, 23100, 2, 'Manufaktur', NULL, 'fa-solid fa-industry', '0', '/master/inventory/manufactur', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"manufactur_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"manufactur_code\",\"sortable\": true },\r\n  { \"name\": \"manufactur_name\", \"align\": \"left\", \"label\": \"Manufaktur/Pabrik\", \"field\": \"manufactur_name\",\"sortable\": true  },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Manufatur', '{\r\n\"retrieve\":\"master/inventory/manufactur\",\r\n\"save\":\"master/inventory/manufactur\",\r\n\"delete\":\"master/inventory/manufactur\",\r\n\"edit\":\"master/inventory/manufactur/get\"\r\n}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (111, 23114, 23100, 2, 'Supplier', NULL, 'fa-solid fa-truck-field-un', '0', '/master/inventory/supplier', '[\r\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\r\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\r\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\r\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\r\n]\r\n                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ', '[\r\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\r\n  { \"name\": \"supplier_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"supplier_code\",\"sortable\": true },\r\n  { \"name\": \"supplier_name\", \"align\": \"left\", \"label\": \"Nama Supplier\", \"field\": \"supplier_name\",\"sortable\": true  },\r\n  { \"name\": \"address\", \"align\": \"left\", \"label\": \"Alamat\", \"field\": \"address\"},\r\n  { \"name\": \"phone1\", \"align\": \"left\", \"label\": \"Telepon 1\", \"field\": \"phone1\"},\r\n  { \"name\": \"phone2\", \"align\": \"left\", \"label\": \"Telepon 2\", \"field\": \"phone2\"},\r\n  { \"name\": \"fax\", \"align\": \"left\", \"label\": \"Fax\", \"field\": \"fax\"},\r\n  { \"name\": \"email\", \"align\": \"left\", \"label\": \"email\", \"field\": \"email\"},\r\n  { \"name\": \"contact_person\", \"align\": \"left\", \"label\": \"Kontak Person\", \"field\": \"contact_person\"},\r\n  { \"name\": \"contact_phone\", \"align\": \"left\", \"label\": \"Telepon\", \"field\": \"contact_phone\"},\r\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" },\r\n  { \"name\": \"update_userid\", \"align\": \"center\", \"label\": \"Use ID\", \"field\": \"update_userid\" },\r\n  { \"name\": \"create_date\", \"align\": \"center\", \"label\": \"Tgl. Buat\", \"field\": \"create_date\" },\r\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl. Ubah\", \"field\": \"update_date\" }\r\n]', 'Supplier', '{\r\n\"retrieve\":\"master/inventory/supplier\",\r\n\"save\":\"master/inventory/supplier\",\r\n\"delete\":\"master/inventory/supplier\",\r\n\"edit\":\"master/inventory/supplier/get\"\r\n}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (112, 21100, 21000, 1, 'Data Master', NULL, 'fa-solid fa-folder', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (113, 21101, 21100, 2, 'Harga Jual', NULL, 'fa-solid fa-tags', '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (114, 22100, 22000, 1, 'Data Master', NULL, 'fa-solid fa-folder', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (115, 22101, 22100, 2, 'Status Kamar Perawatan', NULL, 'fa-solid fa-bed-pulse', '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (116, 17100, 17000, 1, 'Data Master', NULL, 'fa-solid fa-folder', '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (117, 16100, 16000, 1, 'Data Master', NULL, 'fa-solid fa-folder', '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (118, 23400, 23000, 2, 'Pengadaan & Pembelian', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (119, 23410, 23400, 3, 'Pemesanan Barang', '', NULL, '0', '/inventory/purchase/order', '[\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\n{\"action\":\"delete\",\"caption\":\"Pembatalan Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true},\n{\"action\":\"posting\",\"caption\":\"Persetujuan\",\"icon\":\"verified\",\"onclick\":\"delete_event\",\"tooltips\":\"Posting data\",\"is_show\":true}\n]', '[]', 'Pemesanan Barang', '{\n\"save\":\"inventory/order/purchase\"\n}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (120, 23420, 23400, 3, 'Penerimaan Barang', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (121, 23401, 23400, 3, 'Permintaan Pembelian', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (122, 23500, 23000, 2, 'Gudang', NULL, NULL, '1', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (123, 23510, 23500, 3, 'Permintaan Barang', NULL, NULL, '0', NULL, NULL, NULL, NULL, NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (124, 99900, 99000, 1, 'Seting Aplikasi', NULL, NULL, '1', '', NULL, NULL, '', NULL, '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (125, 99901, 99900, 2, 'Parameter aplikasi', NULL, NULL, '0', '/setup/application/parameters', '[\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true}\n]\n', '[\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:50px\"},\n  { \"name\": \"key_groups\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"key_groups\",\"sortable\":true},\n  { \"name\": \"key_word\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"key_word\",\"sortable\":true},\n  { \"name\": \"key_descriptions\", \"align\": \"left\", \"label\": \"Keterangan\", \"field\": \"key_descriptions\",\"sortable\":true,\"style\":\"max-width:300px\"},\n  { \"name\": \"value\", \"align\": \"left\", \"label\": \"Nilai\", \"field\": \"value\" },\n  { \"name\": \"full_name\", \"align\": \"center\", \"label\": \"User ID\", \"field\": \"full_name\" },\n  { \"name\": \"update_date\", \"align\": \"center\", \"label\": \"Tgl.Perubahan\", \"field\": \"update_date\" }\n]\n', '', '{\n\"retrieve\":\"setup/application/parameter\",\n\"save\":\"setup/application/parameter\",\n\"edit\":\"setup/application/parameter/get\"\n}', '1', NULL, NULL);
INSERT INTO `o_objects` (`sysid`, `sort_number`, `parent_sysid`, `object_level`, `title`, `descriptions`, `icons`, `is_parent`, `url_link`, `security`, `column_def`, `page_title`, `api_link`, `is_active`, `create_date`, `update_date`) VALUES (126, 99902, 99900, 2, 'Standar Kode', NULL, NULL, '0', '/setup/application/standard-code', '[\n{\"action\":\"refresh\",\"caption\":\"Perbaharui\",\"icon\":\"refresh\",\"onclick\":\"loaddata\",\"tooltips\":\"Perbahaui\",\"is_show\":false},\n{\"action\":\"add\",\"caption\":\"Tambah Data\",\"icon\":\"add_circle\",\"onclick\":\"add_event\",\"tooltips\":\"Tambah data\",\"is_show\":false},\n{\"action\":\"edit\",\"caption\":\"Ubah Data\",\"icon\":\"edit\",\"onclick\":\"edit_event\",\"tooltips\":\"Ubah data\",\"is_show\":true},\n{\"action\":\"delete\",\"caption\":\"Hapus Data\",\"icon\":\"delete\",\"onclick\":\"delete_event\",\"tooltips\":\"Hapus data\",\"is_show\":true}\n]', '[\n  { \"name\": \"action\", \"align\": \"left\", \"label\": \"Aksi\", \"field\": \"action\",\"style\":\"width:100px\"},\n  { \"name\": \"standard_code\", \"align\": \"left\", \"label\": \"Kode\", \"field\": \"standard_code\",\"sortable\": true },\n  { \"name\": \"descriptions\", \"align\": \"left\", \"label\": \"Keterangan\", \"field\": \"descriptions\",\"sortable\": true  },\n  { \"name\": \"value\", \"align\": \"left\", \"label\": \"Nilai\", \"field\": \"value\"},\n  { \"name\": \"is_active\", \"align\": \"left\", \"label\": \"Aktif\", \"field\": \"is_active\" }, \n { \"name\": \"create_date\", \"align\": \"left\", \"label\": \"Dibuat\", \"field\": \"create_date\" },\n  { \"name\": \"update_date\", \"align\": \"left\", \"label\": \"Diubah\", \"field\": \"update_date\" }\n]', 'Standar Kode', '{\n\"groups\":\"setup/application/group-code\",\n\"retrieve\":\"setup/application/standard-code\",\n\"save\":\"setup/application/standard-code\",\n\"delete\":\"setup/application/standard-code\",\n\"edit\":\"setup/application/standard-code/get\"\n}', '1', NULL, NULL);
COMMIT;

-- ----------------------------
-- Table structure for o_parameters
-- ----------------------------
DROP TABLE IF EXISTS `o_parameters`;
CREATE TABLE `o_parameters` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `key_word` varchar(25) NOT NULL,
  `key_type` varchar(2) DEFAULT NULL,
  `key_groups` varchar(50) DEFAULT NULL,
  `key_length` int(11) DEFAULT 0,
  `key_decimal` int(11) DEFAULT 0,
  `key_descriptions` varchar(255) DEFAULT '-',
  `key_value_integer` int(11) DEFAULT -1,
  `key_value_decimal` decimal(18,3) DEFAULT 0.000,
  `key_value_date` date DEFAULT NULL,
  `key_value_nvarchar` varchar(1000) DEFAULT '-',
  `key_value_boolean` tinyint(1) DEFAULT 0,
  `key_ref` varchar(25) DEFAULT '',
  `key_ref_value` text DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `uuid_rec` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE,
  UNIQUE KEY `key_word` (`key_word`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- ----------------------------
-- Records of o_parameters
-- ----------------------------
BEGIN;
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (1, 'COMPANY_LOGO', 'C', 'General Setting', 0, 0, '-', -1, 0.000, NULL, 'img/logo.jpg', 0, '', NULL, -1, NULL, '2b4be444-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (2, 'COMPANY_NAME', 'C', 'General Setting', 0, 0, '-', -1, 0.000, NULL, 'RS. ROYAL TARUMA', 0, '', NULL, -1, NULL, '2b4bf1dc-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (3, 'EMAIL01', 'C', 'Email Setting', 0, 0, 'Akun email untuk pengiriman email', -1, 0.000, NULL, 'sycnlab@royaltaruma.xyz', 0, '', NULL, -1, '2022-11-15 11:04:06', '2b4bf272-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (4, 'EMAIL02', 'C', 'Email Setting', 0, 0, 'Password akun email', -1, 0.000, NULL, 'lala@220506', 0, 'PASSWORD', NULL, -1, '2022-11-15 11:15:09', '2b4bf2fe-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (5, 'EMAIL03', 'C', 'Email Setting', 0, 0, 'SMTP email', -1, 0.000, NULL, 'stmp.royaltaruma.xyz', 0, '', NULL, -1, '2022-11-15 11:04:22', '2b4bf36c-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (6, 'EMAIL04', 'C', 'Email Setting', 0, 0, 'Port server email', -1, 0.000, NULL, '465', 0, '', NULL, -1, '2022-11-15 11:04:29', '2b4bf3da-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (7, 'EMAIL05', 'C', 'Email Setting', 0, 0, 'Nama Yang tercantuk di sender email', -1, 0.000, NULL, 'RS. ROYAL TARUMA', 0, '', NULL, 1, '2023-05-26 10:43:24', '6f1022c7-bc2a-4089-b1be-9c4ba4b7de08');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (8, 'EMAIL06', 'C', 'Email Setting', 0, 0, 'Protocol email yang digunakan', -1, 0.000, NULL, 'ssl', 0, '', NULL, 1, '2023-05-26 10:43:10', 'f633e7db-6b04-4e66-b52b-5bd57de790bc');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (9, 'EMAIL07', 'C', 'Email Setting', 0, 0, 'Narasi pengiriman hasil', -1, 0.000, NULL, 'Pelanggan Yth <patient_name>\nBerikut ini kami informasikan hasil pemeriksaan di <profile_name> pada tanggal <ref_date>.\nTerima kasih atas kepercayaannya kepada kami, semoga Anda selalu diberikan kesehatan.\nUntuk membuka hasil pemeriksaan ini menggunakan password memakitanggal lahir dengan format DMMYYYY\nYYYY : Tahun Lahir\nMM : Bulan Lahir\nDD : Tanggal Lahir\n\nSalam Hangat,\n\n<profile_name>', 0, 'TEXT', NULL, -1, '2022-11-15 11:24:18', '2b4bf506-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (10, 'EXT001', 'B', 'General Setting', 0, 0, 'Apakah diperbolehkan update order setelah terdaftar di laboratorium', -1, 0.000, NULL, '-', 0, '', NULL, -1, '2022-10-11 20:17:34', '2b4bf588-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (11, 'LAB001', 'B', 'General Setting', 0, 0, 'Proses sampling dinyatakan otomatis waktu pendaftaran', -1, 0.000, NULL, '-', 0, '', NULL, -1, '2022-10-14 09:55:19', '2b4bf5ec-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (12, 'LAB002', 'B', 'General Setting', 0, 0, 'Proses checkin otomatis sesuai waktu sampkling', -1, 0.000, NULL, '-', 1, '', NULL, -1, '2022-10-12 00:23:38', '2b4bf65a-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (13, 'LAB003', 'B', 'General Setting', 0, 0, 'Aktifkan retriksi permintaan pemeriksaan laboratorium', -1, 0.000, NULL, '-', 0, '', NULL, -1, NULL, '2b4bf6b4-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (14, 'LAB004', 'B', 'General Setting', 0, 0, 'Aktifkan popup Detail pemeriksaan', -1, 0.000, NULL, '-', 0, '', NULL, -1, NULL, '2b4bf718-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (15, 'LAB005', 'B', 'General Setting', 0, 0, 'Cetak barcode verifikasikasi hasil di hasil pemeriksaan', -1, 0.000, NULL, '-', 1, '', NULL, -1, '2022-12-22 09:38:48', '2b4bf77c-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (16, 'LAB010', 'C', 'General Setting', 0, 0, 'Image Header pemeriksaan', -1, 0.000, NULL, '-', 0, 'UPLOAD', NULL, -1, NULL, '2b4bf7e0-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (17, 'LAB011', 'B', 'General setting', 0, 0, 'Lakukan pengiriman email secara otomatis jika hasil selesai di release/publish', -1, 0.000, NULL, '-', 1, '', NULL, -1, '2022-11-15 11:36:55', '2b4bf844-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (18, 'LAB012', 'C', 'General setting', 0, 0, 'Format Nomor Laboratorium', -1, 0.000, NULL, 'FORMAT2', 0, 'SELECT', '[\r\n{\"value\":\"FORMAT1\",\"label\":\"Format (YYMMDD-Counter)\"},\r\n{\"value\":\"FORMAT2\",\"label\":\"Format(YYMM-Counter)\"},\r\n{\"value\":\"FORMAT3\",\"label\":\"Format(YY-Counter)\"}\r\n]', 1, '2023-05-26 11:03:40', 'b124ad44-e4a6-447d-a058-c21cd037da4e');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (19, 'REP001', 'C', 'Report Setting', 0, 0, 'Jenis font yang digunakan di laporan hasil', -1, 0.000, NULL, 'times', 0, 'SELECT', '[\r\n{\"value\":\"helvetica\",\"label\":\"Helvetica\"},\r\n{\"value\":\"courier\",\"label\":\"Courier\"},\r\n{\"value\":\"times\",\"label\":\"Times New Roman\"},\r\n{\"value\":\"dejavusans\",\"label\":\"Dejavusans\"},\r\n{\"value\":\"dejavuserif\",\"label\":\"Dejavuserif\"},\r\n{\"value\":\"freemono\",\"label\":\"Freemono\"},\r\n{\"value\":\"freesans\",\"label\":\"Freesans\"},\r\n{\"value\":\"freesansi\",\"label\":\"Freesansi\"},\r\n{\"value\":\"pdfacourier\",\"label\":\"Fdfacourier\"}\r\n]', -1, '2022-10-10 14:54:16', '2b4bf98e-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (20, 'REP002', 'C', 'Report Setting', 0, 0, 'Ukuran/Jenis Kertas', -1, 0.000, NULL, 'A4', 0, 'SELECT', '[\r\n{\"value\":\"A4\",\"label\":\"A4\"},\r\n{\"value\":\"Letter\",\"label\":\"Letter\"},\r\n{\"value\":\"F4\",\"label\":\"F4\"},\r\n{\"value\":\"Legal\",\"label\":\"Legal\"},\r\n{\"value\":\"Customized\",\"label\":\"Customized\"}\r\n]', -1, NULL, '2b4bfa10-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (21, 'REP003', 'I', 'Report Setting', 0, 0, 'Posisi Y (Point)', 96, 0.000, NULL, '-', 0, '', '', -1, '2022-10-10 13:50:45', '2b4bfa7e-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (22, 'REP004', 'C', 'Report Setting', 0, 0, 'Gambar Kop surat', -1, 0.000, NULL, '-', 0, '', '', -1, NULL, '2b4bfae2-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (23, 'REP005', 'B', 'Report Setting', 0, 0, 'Cetak kop surat', -1, 0.000, NULL, '-', 1, '', '', -1, '2022-10-10 00:03:38', '2b4bfb46-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (24, 'REP006', 'C', 'Report Setting', 0, 0, 'Dokter Penanggung jawab laboratorium', -1, 0.000, NULL, 'dr. Apriyani', 0, '', NULL, -1, '2022-10-10 13:41:26', '2b4bfbaa-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (25, 'REP007', 'C', 'Report Setting', 0, 0, 'Catatan hasil pemeriksaan', -1, 0.000, NULL, 'Interpreasti hasil pemeriksaan laboratorium harus oleh dokter yang bersangkutan', 0, '', NULL, -1, '2022-10-10 15:21:17', '2b4bfc0e-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (26, 'REP008', 'C', 'Report Setting', 0, 0, 'Jenis Barcode', -1, 0.000, NULL, '1D', 0, 'SELECT', '[\r\n{\"value\":\"1D\",\"label\":\"Barcode 1D\"},\r\n{\"value\":\"2D\",\"label\":\"QR Code\"}\r\n]', -1, '2022-11-15 11:03:34', '2b4bfc72-fb75-11ed-907d-6261c7bc04e4');
INSERT INTO `o_parameters` (`sysid`, `key_word`, `key_type`, `key_groups`, `key_length`, `key_decimal`, `key_descriptions`, `key_value_integer`, `key_value_decimal`, `key_value_date`, `key_value_nvarchar`, `key_value_boolean`, `key_ref`, `key_ref_value`, `update_by`, `update_date`, `uuid_rec`) VALUES (27, 'SEC01', 'B', 'Security Setting', 0, 0, 'Otentikasi password 2 langkah', -1, 0.000, NULL, '-', 0, '', NULL, -1, '2022-12-22 09:39:18', '2b4bfcd6-fb75-11ed-907d-6261c7bc04e4');
COMMIT;

-- ----------------------------
-- Table structure for o_series_document
-- ----------------------------
DROP TABLE IF EXISTS `o_series_document`;
CREATE TABLE `o_series_document` (
  `prefix_code` varchar(4) NOT NULL,
  `year_period` int(11) NOT NULL,
  `month_period` int(11) NOT NULL,
  `numbering` varchar(4) DEFAULT NULL,
  PRIMARY KEY (`prefix_code`,`year_period`,`month_period`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- ----------------------------
-- Records of o_series_document
-- ----------------------------
BEGIN;
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 1900, 1, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 1, '0144');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 2, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 3, '0028');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 4, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 5, '0012');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 6, '0026');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 7, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 8, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 9, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 10, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 11, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2016, 12, '0018');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 1, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 2, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 3, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 4, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 5, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 6, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 7, '0012');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 8, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 9, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 10, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 11, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2017, 12, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 1, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 2, '0018');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 3, '0021');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 4, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 5, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 6, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 7, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 8, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 9, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 10, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 11, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2018, 12, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 1, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 2, '0018');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 3, '0023');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 4, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 5, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 6, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 7, '0028');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 8, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 9, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 10, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 11, '0018');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2019, 12, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 1, '0018');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 2, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 3, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 4, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 5, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 6, '0018');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 7, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 8, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 9, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 10, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 11, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2020, 12, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 1, '0018');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 2, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 3, '0023');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 4, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 5, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 6, '0018');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 7, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 8, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 9, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 10, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 11, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2021, 12, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 1, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 2, '0012');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 3, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 4, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 5, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 6, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 7, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 8, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 9, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 10, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 11, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2022, 12, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2023, 1, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2023, 2, '0018');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2023, 3, '0012');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2023, 4, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('AP', 2023, 12, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('CBR', 2017, 1, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('CBR', 2017, 3, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('CBR', 2018, 4, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2015, 12, '0004');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 1, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 2, '0028');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 3, '0023');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 4, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 5, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 6, '0003');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 7, '0003');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 8, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 9, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 10, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 11, '0012');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2016, 12, '0004');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('DOC', 2017, 1, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('FPP', 2018, 4, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('GRG', 2016, 8, '0004');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('GRG', 2016, 9, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('GRG', 2016, 10, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('GRG', 2016, 11, '0003');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('GRG', 2018, 8, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('IBG', 2015, 1, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('IBG', 2015, 2, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('IBG', 2015, 8, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('IIG', 2015, 1, '0004');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('IIG', 2015, 2, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISO', 2015, 1, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISO', 2015, 2, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISO', 2015, 5, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISO', 2015, 12, '0050');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISO', 2016, 2, '0003');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISO', 2016, 6, '0003');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2016, 6, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2016, 12, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 3, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 4, '0140');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 5, '0167');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 6, '0080');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 7, '0198');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 8, '0179');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 9, '0138');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 10, '0171');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 11, '0169');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2017, 12, '0123');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 1, '0157');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 2, '0176');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 3, '0156');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 4, '0212');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 5, '0168');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 6, '0074');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 7, '0164');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 8, '0214');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 9, '0188');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 10, '0230');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 11, '0173');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2018, 12, '0178');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 1, '0200');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 2, '0195');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 3, '0226');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 4, '0210');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 5, '0241');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 6, '0181');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 7, '0330');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 8, '0256');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 9, '0255');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 10, '0257');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 11, '0216');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2019, 12, '0264');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 1, '0260');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 2, '0259');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 3, '0263');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 4, '0275');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 5, '0169');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 6, '0218');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 7, '0180');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 8, '0170');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 9, '0190');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 10, '0193');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 11, '0166');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2020, 12, '0181');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 1, '0202');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 2, '0190');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 3, '0250');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 4, '0219');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 5, '0160');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 6, '0253');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 7, '0242');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 8, '0256');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 9, '0198');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 10, '0233');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 11, '0182');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2021, 12, '0232');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 1, '0204');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 2, '0186');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 3, '0219');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 4, '0142');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 5, '0175');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 6, '0209');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 7, '0191');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 8, '0246');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 9, '0192');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 10, '0221');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 11, '0158');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2022, 12, '0169');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2023, 1, '0171');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2023, 2, '0189');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2023, 3, '0160');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ISR', 2023, 4, '0027');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITI', 2017, 3, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITI', 2018, 8, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITI', 2018, 9, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITI', 2018, 10, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITI', 2019, 4, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITI', 2019, 7, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITI', 2019, 9, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITO', 2017, 3, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITO', 2018, 8, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITO', 2018, 9, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITO', 2018, 10, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITO', 2019, 4, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITO', 2019, 7, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('ITO', 2019, 9, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 1900, 1, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 1, '0040');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 2, '0087');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 3, '0032');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 4, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 5, '0028');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 6, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 7, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 8, '0027');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 9, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 10, '0021');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 11, '0026');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2016, 12, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LBCC', 2017, 1, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2015, 11, '0004');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2015, 12, '0030');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 1, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 2, '0040');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 3, '0040');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 4, '0028');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 5, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 6, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 7, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 8, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 9, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 10, '0021');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 11, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2016, 12, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 1, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 2, '0030');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 3, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 4, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 5, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 6, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 7, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 8, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 9, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 10, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 11, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2017, 12, '0023');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 1, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 2, '0023');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 3, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 4, '0025');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 5, '0021');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 6, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 7, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 8, '0026');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 9, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 10, '0030');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 11, '0037');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2018, 12, '0026');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 1, '0033');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 2, '0026');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 3, '0028');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 4, '0017');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 5, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 6, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 7, '0030');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 8, '0028');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 9, '0034');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 10, '0033');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 11, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2019, 12, '0030');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 1, '0023');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 2, '0026');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 3, '0032');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 4, '0028');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 5, '0021');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 6, '0025');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 7, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 8, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 9, '0027');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 10, '0027');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 11, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2020, 12, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 1, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 2, '0023');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 3, '0044');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 4, '0045');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 5, '0035');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 6, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 7, '0034');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 8, '0045');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 9, '0022');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 10, '0036');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 11, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2021, 12, '0031');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 1, '0028');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 2, '0029');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 3, '0026');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 4, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 5, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 6, '0026');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 7, '0024');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 8, '0023');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 9, '0019');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 10, '0021');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 11, '0027');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2022, 12, '0021');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2023, 1, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2023, 2, '0021');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2023, 3, '0020');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('LPB', 2023, 4, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2015, 2, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2015, 11, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2015, 12, '0140');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 1, '0160');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 2, '0191');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 3, '0267');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 4, '0249');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 5, '0247');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 6, '0232');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 7, '0169');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 8, '0240');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 9, '0185');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 10, '0242');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 11, '0249');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2016, 12, '0192');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 1, '0208');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 2, '0213');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 3, '0217');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 4, '0179');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 5, '0171');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 6, '0080');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 7, '0186');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 8, '0162');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 9, '0137');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 10, '0170');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 11, '0167');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2017, 12, '0124');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 1, '0160');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 2, '0176');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 3, '0156');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 4, '0212');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 5, '0166');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 6, '0074');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 7, '0163');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 8, '0199');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 9, '0180');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 10, '0228');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 11, '0173');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2018, 12, '0174');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 1, '0198');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 2, '0194');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 3, '0218');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 4, '0198');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 5, '0241');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 6, '0167');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 7, '0325');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 8, '0252');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 9, '0241');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 10, '0251');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 11, '0215');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2019, 12, '0260');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 1, '0254');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 2, '0255');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 3, '0255');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 4, '0273');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 5, '0174');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 6, '0211');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 7, '0178');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 8, '0170');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 9, '0179');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 10, '0192');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 11, '0165');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2020, 12, '0178');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 1, '0199');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 2, '0190');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 3, '0241');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 4, '0209');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 5, '0160');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 6, '0244');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 7, '0225');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 8, '0248');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 9, '0178');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 10, '0224');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 11, '0178');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2021, 12, '0222');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 1, '0199');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 2, '0177');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 3, '0214');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 4, '0139');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 5, '0170');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 6, '0206');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 7, '0187');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 8, '0228');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 9, '0189');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 10, '0209');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 11, '0172');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2022, 12, '0212');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2023, 1, '0206');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2023, 2, '0204');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2023, 3, '0190');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PBG', 2023, 4, '0037');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2015, 2, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2015, 3, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2015, 8, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2015, 11, '0004');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2015, 12, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 1, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 2, '0003');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 3, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 4, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 5, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 6, '0012');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 7, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 8, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 9, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 10, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 11, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2016, 12, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 1, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 2, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 3, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 4, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 5, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 6, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 7, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 8, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 9, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 10, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 11, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2017, 12, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 1, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 2, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 3, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 4, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 5, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 6, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 7, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 8, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 9, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 10, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 11, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2018, 12, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 1, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 2, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 3, '0012');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 4, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 5, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 6, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 7, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 8, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 9, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 10, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 11, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2019, 12, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 1, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 2, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 3, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 4, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 5, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 6, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 7, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 8, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 9, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 10, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 11, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2020, 12, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 1, '0016');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 2, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 3, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 4, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 5, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 6, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 7, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 8, '0015');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 9, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 10, '0014');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 11, '0003');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2021, 12, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 1, '0003');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 2, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 3, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 4, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 5, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 6, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 7, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 8, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 9, '0003');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 10, '0012');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 11, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2022, 12, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2023, 1, '0004');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2023, 2, '0013');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2023, 3, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PEG', 2023, 4, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2015, 1, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2015, 2, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2015, 8, '0002');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2015, 11, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2015, 12, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 1, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 2, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 3, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 4, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 5, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 6, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 7, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 8, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 9, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 10, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 11, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2016, 12, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 1, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 2, '0010');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 3, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 4, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 5, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 6, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 7, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 8, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 9, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 10, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2017, 11, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 1, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 2, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 3, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 4, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 5, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 6, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 8, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 9, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 10, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 11, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2018, 12, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 1, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 2, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 3, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 4, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 5, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 6, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 7, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 8, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 9, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 10, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 11, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2019, 12, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 1, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 2, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 3, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 4, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 5, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 6, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 7, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 8, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 9, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 10, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 11, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2020, 12, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 1, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 2, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 3, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 4, '0011');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 5, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 6, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 7, '0008');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 8, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 9, '0009');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 10, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 11, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2021, 12, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 1, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 2, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 3, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 4, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 5, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 6, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 7, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 8, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 9, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 10, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 11, '0007');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2022, 12, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2023, 1, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2023, 2, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2023, 3, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POG', 2023, 4, '0005');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('POI', 2023, 6, '2');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('PRO', 2014, 12, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2016, 6, '0001');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 3, '0006');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 4, '0176');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 5, '0184');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 6, '0105');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 7, '0201');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 8, '0180');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 9, '0144');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 10, '0177');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 11, '0149');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2017, 12, '0134');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 1, '0163');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 2, '0167');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 3, '0152');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 4, '0193');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 5, '0181');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 6, '0077');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 7, '0163');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 8, '0172');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 9, '0176');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 10, '0204');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 11, '0152');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2018, 12, '0150');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 1, '0147');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 2, '0160');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 3, '0208');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 4, '0194');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 5, '0167');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 6, '0164');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 7, '0178');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 8, '0187');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 9, '0202');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 10, '0229');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 11, '0170');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2019, 12, '0231');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 1, '0224');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 2, '0210');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 3, '0223');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 4, '0206');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 5, '0140');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 6, '0208');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 7, '0161');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 8, '0163');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 9, '0163');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 10, '0166');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 11, '0133');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2020, 12, '0156');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 1, '0190');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 2, '0187');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 3, '0240');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 4, '0218');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 5, '0148');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 6, '0238');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 7, '0211');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 8, '0255');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 9, '0192');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 10, '0232');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 11, '0176');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2021, 12, '0227');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 1, '0182');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 2, '0171');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 3, '0180');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 4, '0138');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 5, '0141');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 6, '0193');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 7, '0157');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 8, '0198');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 9, '0158');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 10, '0185');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 11, '0158');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2022, 12, '0149');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2023, 1, '0127');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2023, 2, '0123');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2023, 3, '0109');
INSERT INTO `o_series_document` (`prefix_code`, `year_period`, `month_period`, `numbering`) VALUES ('WOS', 2023, 4, '0024');
COMMIT;

-- ----------------------------
-- Table structure for o_sessions
-- ----------------------------
DROP TABLE IF EXISTS `o_sessions`;
CREATE TABLE `o_sessions` (
  `sign_code` varchar(60) NOT NULL,
  `session_number` varchar(60) DEFAULT NULL,
  `user_sysid` bigint(20) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `ip_number` varchar(25) DEFAULT NULL,
  `expired_date` datetime DEFAULT NULL,
  `refresh_date` datetime DEFAULT NULL,
  `is_locked` varchar(5) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sign_code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of o_sessions
-- ----------------------------
BEGIN;
INSERT INTO `o_sessions` (`sign_code`, `session_number`, `user_sysid`, `user_name`, `ip_number`, `expired_date`, `refresh_date`, `is_locked`, `create_date`, `update_date`) VALUES ('$2y$10$.IO5j/B2SHxT8wMa66mDVuhZoB4R97TEgjw4R5xLzkYSUD/PP.1Ka', 'QViIK7TQ5gyIRmtV8GfVzYnt85kdEy0FPBUEGszK', 1, 'demo@gmail.com', '127.0.0.1', '2023-06-07 21:35:07', '2023-06-07 03:35:07', '0', '2023-06-06 21:35:07', NULL);
INSERT INTO `o_sessions` (`sign_code`, `session_number`, `user_sysid`, `user_name`, `ip_number`, `expired_date`, `refresh_date`, `is_locked`, `create_date`, `update_date`) VALUES ('$2y$10$0yVItTvb9o1VQTmGFAB5IeV4cnsNbQOOCad5uaxoWnoZe6oQlHTty', 'A0LM5Cul3JrwH4iaMp0WDZTYPUHjfa5fsFhbD7fs', 1, 'demo@gmail.com', '127.0.0.1', '2023-06-08 19:36:37', '2023-06-08 01:36:37', '0', '2023-06-07 19:36:37', NULL);
INSERT INTO `o_sessions` (`sign_code`, `session_number`, `user_sysid`, `user_name`, `ip_number`, `expired_date`, `refresh_date`, `is_locked`, `create_date`, `update_date`) VALUES ('$2y$10$6.fJMeUsKVWz8WOSWNUES.1.0iw5iAxqLoRyMXwIeJkf5TG7kPdte', 'w4cU9Fby1XLYJg4QDjbC3mHcOVye1JAbNvVAnTka', 1, 'demo@gmail.com', '127.0.0.1', '2023-06-08 10:59:24', '2023-06-07 16:59:24', '0', '2023-06-07 10:59:24', NULL);
INSERT INTO `o_sessions` (`sign_code`, `session_number`, `user_sysid`, `user_name`, `ip_number`, `expired_date`, `refresh_date`, `is_locked`, `create_date`, `update_date`) VALUES ('$2y$10$cDXShcJMwBxeCB4y50CNsu3TP4eaW90juHtxMBnxUwJsIHL.0BkPe', '3qR8jTm8jykphwcOsLKdo4R51TDxU6QfPuvRM0mF', 1, 'demo@gmail.com', '127.0.0.1', '2023-06-08 19:51:52', '2023-06-08 01:51:52', '0', '2023-06-07 19:51:52', NULL);
INSERT INTO `o_sessions` (`sign_code`, `session_number`, `user_sysid`, `user_name`, `ip_number`, `expired_date`, `refresh_date`, `is_locked`, `create_date`, `update_date`) VALUES ('$2y$10$hVQsxrL19vm4vHCyDEYVne1rQZ7xHG0zdNLRYeQV07fF1EodAI1H.', 'phOtPmdZHkagqxv0X3YPtV5mENzod0jhnwxRzUYG', 1, 'demo@gmail.com', '127.0.0.1', '2023-06-07 20:40:58', '2023-06-07 02:40:58', '0', '2023-06-06 20:40:58', NULL);
COMMIT;

-- ----------------------------
-- Table structure for o_users
-- ----------------------------
DROP TABLE IF EXISTS `o_users`;
CREATE TABLE `o_users` (
  `sysid` bigint(20) NOT NULL,
  `uuid_rec` varchar(36) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `user_level` varchar(25) DEFAULT NULL,
  `failed_attemp` bigint(20) DEFAULT NULL,
  `attemp_lock` datetime DEFAULT NULL,
  `session_number` varchar(255) DEFAULT NULL,
  `ip_number` varchar(20) DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `sign` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `is_group` varchar(5) DEFAULT NULL,
  `is_active` varchar(5) DEFAULT NULL,
  `update_userid` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of o_users
-- ----------------------------
BEGIN;
INSERT INTO `o_users` (`sysid`, `uuid_rec`, `user_name`, `full_name`, `phone`, `password`, `role`, `user_level`, `failed_attemp`, `attemp_lock`, `session_number`, `ip_number`, `last_login`, `sign`, `photo`, `email`, `is_group`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (1, '300ca71d-a887-479e-92c6-78114a25b03f', 'demo@gmail.com', 'Ade Doank', NULL, '$2y$10$dJTeKd0FhttIEIM3qpnCbeXXPEcaCclYEZaNYClPhWxRGUmMrBE.2', NULL, 'ADMIN', 0, NULL, '3qR8jTm8jykphwcOsLKdo4R51TDxU6QfPuvRM0mF', '127.0.0.1', '2023-06-07 19:51:52', NULL, NULL, 'bluemetric@gmail.com', '0', '1', 'demo@gmail.com', NULL, '2023-06-07 19:51:52');
INSERT INTO `o_users` (`sysid`, `uuid_rec`, `user_name`, `full_name`, `phone`, `password`, `role`, `user_level`, `failed_attemp`, `attemp_lock`, `session_number`, `ip_number`, `last_login`, `sign`, `photo`, `email`, `is_group`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (2, '5ef21ef9-8b80-4eba-84d8-2c98c0ac091f', 'IT', 'System Administrator', '-', '$2y$10$hWQEBXGQtN3V5BRmKP3OheVdSiJTZZYrKBnW59yg0zSqCA2fKN.OS', NULL, 'ADMIN', 0, NULL, 'aJASDXMgFYnS2pNa5EVFhTC0bejN0hqO4UWc5wJh', '127.0.0.1', '2022-10-04 15:10:48', NULL, NULL, '@', '0', '1', 'demo@gmail.com', '2022-10-03 09:55:13', '2023-03-08 11:30:31');
INSERT INTO `o_users` (`sysid`, `uuid_rec`, `user_name`, `full_name`, `phone`, `password`, `role`, `user_level`, `failed_attemp`, `attemp_lock`, `session_number`, `ip_number`, `last_login`, `sign`, `photo`, `email`, `is_group`, `is_active`, `update_userid`, `create_date`, `update_date`) VALUES (4, '520da477-3940-4325-a99c-cb1ccbd6bdc7', 'G_CASHIER', 'GRUP KASIR', '-', NULL, NULL, 'USER', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '@', '0', '1', 'demo@gmail.com', '2022-10-03 12:17:37', '2023-03-08 10:19:11');
COMMIT;

-- ----------------------------
-- Table structure for o_users_access
-- ----------------------------
DROP TABLE IF EXISTS `o_users_access`;
CREATE TABLE `o_users_access` (
  `user_sysid` bigint(20) NOT NULL,
  `object_sysid` bigint(20) NOT NULL,
  `security` varchar(255) DEFAULT NULL,
  `update_userid` varchar(199) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `updatte_date` datetime DEFAULT NULL,
  PRIMARY KEY (`user_sysid`,`object_sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of o_users_access
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for o_users_reports
-- ----------------------------
DROP TABLE IF EXISTS `o_users_reports`;
CREATE TABLE `o_users_reports` (
  `user_sysid` int(11) NOT NULL,
  `report_sysid` int(11) NOT NULL,
  `is_allow` varchar(5) DEFAULT NULL,
  `is_export` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`user_sysid`,`report_sysid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of o_users_reports
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_ap_invoice1
-- ----------------------------
DROP TABLE IF EXISTS `t_ap_invoice1`;
CREATE TABLE `t_ap_invoice1` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `ref_date` date DEFAULT NULL,
  `doc_number` varchar(20) DEFAULT NULL,
  `ref_number` varchar(100) DEFAULT NULL,
  `partner_id` int(11) DEFAULT NULL,
  `partner_name` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `create_date` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `uuid_rec` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_ap_invoice1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_ap_invoice2
-- ----------------------------
DROP TABLE IF EXISTS `t_ap_invoice2`;
CREATE TABLE `t_ap_invoice2` (
  `sysid` int(11) NOT NULL,
  `line_no` int(11) NOT NULL,
  `ref_id` int(11) DEFAULT NULL,
  `ref_source` varchar(25) DEFAULT NULL,
  `doc_number` varchar(20) DEFAULT NULL,
  `invoice_number` varchar(100) DEFAULT NULL,
  `doc_date` date DEFAULT NULL,
  `tax_number` varchar(100) DEFAULT NULL,
  `partner_id` int(11) DEFAULT -1,
  `due_date` date DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT 0.00,
  `unpaid` decimal(10,2) DEFAULT 0.00,
  `paid` decimal(10,2) DEFAULT 0.00,
  `paid_date` date DEFAULT NULL,
  `paid_id` int(11) DEFAULT -1,
  `paid_number` varchar(20) DEFAULT '',
  `paid_state` int(11) DEFAULT 0,
  PRIMARY KEY (`sysid`,`line_no`),
  KEY `partner_id` (`partner_id`,`paid_state`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_ap_invoice2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_goods_issue1
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_issue1`;
CREATE TABLE `t_goods_issue1` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `ref_date` date DEFAULT NULL,
  `doc_number` varchar(20) DEFAULT NULL,
  `ref_number` varchar(100) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `location_cost` int(11) DEFAULT NULL,
  `location_cost_name` varchar(255) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT 0.00,
  `jurnal_id` int(11) DEFAULT NULL,
  `jurnal_number` varchar(20) DEFAULT NULL,
  `jurnal_date` date DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `uuid_rec` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_goods_issue1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_goods_issue2
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_issue2`;
CREATE TABLE `t_goods_issue2` (
  `sysid` int(11) NOT NULL,
  `line_number` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_code` varchar(20) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `mou_issue` varchar(50) DEFAULT NULL,
  `conversion` decimal(10,4) DEFAULT NULL,
  `mou_inventory` varchar(50) DEFAULT NULL,
  `item_cost` decimal(10,2) DEFAULT 0.00,
  `line_cost` decimal(10,2) DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `quantity_update` decimal(10,2) DEFAULT 0.00,
  PRIMARY KEY (`sysid`,`line_number`),
  KEY `sysid` (`sysid`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_goods_issue2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_goods_transfer1
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_transfer1`;
CREATE TABLE `t_goods_transfer1` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `ref_date` date DEFAULT NULL,
  `doc_number` varchar(20) DEFAULT NULL,
  `ref_number` varchar(100) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `source_name` varchar(255) DEFAULT NULL,
  `destination_id` int(11) DEFAULT NULL,
  `destination_name` varchar(255) DEFAULT NULL,
  `cost` decimal(10,2) DEFAULT 0.00,
  `jurnal_id` int(11) DEFAULT -1,
  `jurnal_number` varchar(20) DEFAULT '',
  `jurnal_date` date DEFAULT NULL,
  `transfer_type` varchar(20) DEFAULT NULL,
  `is_received` tinyint(1) DEFAULT 0,
  `create_date` datetime DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `uuid_rec` varchar(50) DEFAULT '',
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_goods_transfer1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_goods_transfer2
-- ----------------------------
DROP TABLE IF EXISTS `t_goods_transfer2`;
CREATE TABLE `t_goods_transfer2` (
  `sysid` int(11) NOT NULL,
  `line_number` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_code` varchar(20) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `mou_issue` varchar(50) DEFAULT NULL,
  `conversion` decimal(10,4) DEFAULT NULL,
  `mou_inventory` varchar(50) DEFAULT NULL,
  `item_cost` decimal(10,2) DEFAULT 0.00,
  `line_cost` decimal(10,2) DEFAULT 0.00,
  `quantity` decimal(10,2) DEFAULT 0.00,
  `quantity_update` decimal(10,2) DEFAULT 0.00,
  `account_transfer` varchar(20) DEFAULT NULL,
  `account_inventory` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`sysid`,`line_number`),
  KEY `sysid` (`sysid`,`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_goods_transfer2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_purchase_order1
-- ----------------------------
DROP TABLE IF EXISTS `t_purchase_order1`;
CREATE TABLE `t_purchase_order1` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `ref_date` date DEFAULT NULL,
  `doc_number` varchar(20) DEFAULT '',
  `ref_number` varchar(100) DEFAULT '',
  `delivery_date` date DEFAULT NULL,
  `expired_date` date DEFAULT NULL,
  `location_id` int(11) DEFAULT -1,
  `partner_id` int(11) DEFAULT -1,
  `partner_name` varchar(255) DEFAULT '',
  `term_id` varchar(10) DEFAULT '-1',
  `curr_code` varchar(10) DEFAULT '',
  `curr_rate` decimal(10,2) DEFAULT 1.00,
  `amount` decimal(18,2) DEFAULT 0.00,
  `discount1` decimal(18,2) DEFAULT 0.00,
  `discount2` decimal(18,2) DEFAULT 0.00,
  `tax` decimal(18,2) DEFAULT 0.00,
  `downpayment` decimal(10,2) DEFAULT 0.00,
  `delivery_fee` decimal(10,2) DEFAULT 0.00,
  `total` decimal(18,2) DEFAULT 0.00,
  `state` varchar(25) DEFAULT NULL,
  `is_tax` tinyint(1) DEFAULT NULL,
  `purchase_type` varchar(10) DEFAULT NULL,
  `order_type` varchar(10) DEFAULT NULL,
  `item_group` varchar(10) DEFAULT '',
  `remarks` varchar(255) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `is_posted` tinyint(1) DEFAULT 0,
  `posted_by` int(11) DEFAULT -1,
  `is_void` tinyint(1) DEFAULT 0,
  `void_by` int(11) DEFAULT -1,
  `void_date` datetime DEFAULT NULL,
  `purchase_request_id` int(11) DEFAULT -1,
  `ref_document` varchar(30) DEFAULT '',
  `doc_purchase_request` varchar(50) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `posted_date` datetime DEFAULT NULL,
  `uuid_rec` varchar(50) DEFAULT '',
  PRIMARY KEY (`sysid`),
  UNIQUE KEY `uuid_rec` (`uuid_rec`),
  KEY `ref_number` (`ref_number`),
  KEY `partner_id` (`partner_id`,`state`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_purchase_order1
-- ----------------------------
BEGIN;
INSERT INTO `t_purchase_order1` (`sysid`, `ref_date`, `doc_number`, `ref_number`, `delivery_date`, `expired_date`, `location_id`, `partner_id`, `partner_name`, `term_id`, `curr_code`, `curr_rate`, `amount`, `discount1`, `discount2`, `tax`, `downpayment`, `delivery_fee`, `total`, `state`, `is_tax`, `purchase_type`, `order_type`, `item_group`, `remarks`, `update_date`, `is_posted`, `posted_by`, `is_void`, `void_by`, `void_date`, `purchase_request_id`, `ref_document`, `doc_purchase_request`, `create_by`, `create_date`, `update_by`, `posted_date`, `uuid_rec`) VALUES (8, '2023-06-07', 'POI-23060001', '', NULL, '2023-06-07', 5, 4, 'PT. Anugrah Pharmindo Lestari', 'C003@30', 'IDR', 1.00, 5000000.00, 1300000.00, 0.00, 407000.00, 0.00, 0.00, 4107000.00, 'Draft', 0, 'C001@R', 'C002@6', 'C004@M', '', '2023-06-07 14:57:10', 0, -1, 0, -1, NULL, -1, 'General PO', '', 1, '2023-06-07 14:57:10', NULL, NULL, '8c1c7671-c90a-4e40-bf6b-c5c936624df9');
INSERT INTO `t_purchase_order1` (`sysid`, `ref_date`, `doc_number`, `ref_number`, `delivery_date`, `expired_date`, `location_id`, `partner_id`, `partner_name`, `term_id`, `curr_code`, `curr_rate`, `amount`, `discount1`, `discount2`, `tax`, `downpayment`, `delivery_fee`, `total`, `state`, `is_tax`, `purchase_type`, `order_type`, `item_group`, `remarks`, `update_date`, `is_posted`, `posted_by`, `is_void`, `void_by`, `void_date`, `purchase_request_id`, `ref_document`, `doc_purchase_request`, `create_by`, `create_date`, `update_by`, `posted_date`, `uuid_rec`) VALUES (9, '2023-06-07', 'POI-23060002', 'TEST', '2023-06-07', '2023-06-07', 4, 5, 'Toko Buku Sumber Bersama', 'C003@30', 'IDR', 1.00, 1250000.00, 312500.00, 0.00, 103125.00, 0.00, 0.00, 1040625.00, 'Draft', 0, 'C001@R', 'C002@6', 'C004@M', '', '2023-06-07 20:44:23', 0, -1, 0, -1, NULL, -1, 'General PO', '', 1, '2023-06-07 15:24:42', 1, NULL, '6057f70c-e3c6-4621-9495-2941b46bc8f2');
COMMIT;

-- ----------------------------
-- Table structure for t_purchase_order2
-- ----------------------------
DROP TABLE IF EXISTS `t_purchase_order2`;
CREATE TABLE `t_purchase_order2` (
  `sysid` int(11) NOT NULL,
  `line_no` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_code` varchar(20) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `mou_purchase` varchar(50) DEFAULT '',
  `conversion` decimal(10,3) DEFAULT 1.000,
  `mou_inventory` varchar(50) DEFAULT '',
  `qty_draft` decimal(10,2) DEFAULT 0.00,
  `qty_order` decimal(10,2) DEFAULT 0.00,
  `price` decimal(10,2) DEFAULT 0.00,
  `qty_received` decimal(10,2) DEFAULT 0.00,
  `prc_discount1` decimal(10,2) DEFAULT 0.00,
  `discount1` decimal(10,2) DEFAULT 0.00,
  `prc_discount2` decimal(10,2) DEFAULT 0.00,
  `discount2` decimal(10,2) DEFAULT 0.00,
  `prc_tax` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT '',
  `request_id` int(11) DEFAULT -1,
  `request_line` int(11) DEFAULT -1,
  `request_qty` decimal(10,2) DEFAULT 0.00,
  `line_type` varchar(25) DEFAULT '',
  `source_line` varchar(25) DEFAULT '',
  PRIMARY KEY (`sysid`,`line_no`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_purchase_order2
-- ----------------------------
BEGIN;
INSERT INTO `t_purchase_order2` (`sysid`, `line_no`, `item_id`, `item_code`, `item_name`, `mou_purchase`, `conversion`, `mou_inventory`, `qty_draft`, `qty_order`, `price`, `qty_received`, `prc_discount1`, `discount1`, `prc_discount2`, `discount2`, `prc_tax`, `tax`, `total`, `remarks`, `request_id`, `request_line`, `request_qty`, `line_type`, `source_line`) VALUES (8, 1, 3, 'PA00101', 'COMBANTRIN  SYRUP', 'BOX', 10.000, 'Botol', 10.00, 0.00, 100000.00, 0.00, 30.00, 300000.00, 0.00, 0.00, 11.00, 77000.00, 777000.00, '', -1, -1, 0.00, 'Follow', 'FreeLine');
INSERT INTO `t_purchase_order2` (`sysid`, `line_no`, `item_id`, `item_code`, `item_name`, `mou_purchase`, `conversion`, `mou_inventory`, `qty_draft`, `qty_order`, `price`, `qty_received`, `prc_discount1`, `discount1`, `prc_discount2`, `discount2`, `prc_tax`, `tax`, `total`, `remarks`, `request_id`, `request_line`, `request_qty`, `line_type`, `source_line`) VALUES (8, 2, 1, 'PA00210', 'Panadol Syrup 65 ml', 'BOX', 10.000, 'Botol', 20.00, 0.00, 200000.00, 0.00, 25.00, 1000000.00, 0.00, 0.00, 11.00, 330000.00, 3330000.00, '', -1, -1, 0.00, 'Follow', 'FreeLine');
INSERT INTO `t_purchase_order2` (`sysid`, `line_no`, `item_id`, `item_code`, `item_name`, `mou_purchase`, `conversion`, `mou_inventory`, `qty_draft`, `qty_order`, `price`, `qty_received`, `prc_discount1`, `discount1`, `prc_discount2`, `discount2`, `prc_tax`, `tax`, `total`, `remarks`, `request_id`, `request_line`, `request_qty`, `line_type`, `source_line`) VALUES (9, 1, 3, 'PA00101', 'COMBANTRIN  SYRUP', 'BOX', 10.000, 'Botol', 5.00, 0.00, 250000.00, 0.00, 25.00, 312500.00, 0.00, 0.00, 11.00, 103125.00, 1040625.00, '', -1, -1, 0.00, 'Follow', 'FreeLine');
COMMIT;

-- ----------------------------
-- Table structure for t_purchase_receive1
-- ----------------------------
DROP TABLE IF EXISTS `t_purchase_receive1`;
CREATE TABLE `t_purchase_receive1` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `ref_date` date DEFAULT NULL,
  `doc_number` varchar(20) DEFAULT '',
  `invoice_number` varchar(100) DEFAULT NULL,
  `location_id` int(11) DEFAULT -1,
  `partner_id` int(11) DEFAULT -1,
  `partner_name` varchar(255) DEFAULT '',
  `term_id` int(11) DEFAULT -1,
  `curr_code` varchar(10) DEFAULT '',
  `curr_rate` decimal(10,2) DEFAULT 1.00,
  `amount` decimal(18,2) DEFAULT 0.00,
  `discount1` decimal(18,2) DEFAULT 0.00,
  `discount2` decimal(18,2) DEFAULT 0.00,
  `tax` decimal(18,2) DEFAULT 0.00,
  `total` decimal(18,2) DEFAULT 0.00,
  `state` varchar(25) DEFAULT NULL,
  `is_tax` tinyint(1) DEFAULT NULL,
  `tax_number` varchar(50) DEFAULT '',
  `is_creditable` tinyint(1) DEFAULT 1,
  `is_credit_notes` tinyint(1) DEFAULT 0,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `uuid_rec` varchar(50) DEFAULT '',
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_purchase_receive1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_purchase_receive2
-- ----------------------------
DROP TABLE IF EXISTS `t_purchase_receive2`;
CREATE TABLE `t_purchase_receive2` (
  `sysid` int(11) NOT NULL,
  `line` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_code` varchar(20) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `muo_purchase` varchar(50) DEFAULT NULL,
  `conversion` decimal(10,4) DEFAULT NULL,
  `mou_inventory` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `qty_order` decimal(10,2) DEFAULT 0.00,
  `qty_received` decimal(10,2) DEFAULT 0.00,
  `prc_discount1` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `discount1` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `prc_discount2` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `discount2` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `prc_tax` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT '',
  `request_id` int(11) DEFAULT -1,
  `request_line` int(11) DEFAULT -1,
  `request_qty` decimal(10,2) DEFAULT NULL,
  `line_type` varchar(1) DEFAULT NULL,
  `qty_update` decimal(10,2) DEFAULT 0.00,
  `cost_update` decimal(10,4) DEFAULT 0.0000,
  PRIMARY KEY (`sysid`,`line`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_purchase_receive2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_purchase_request1
-- ----------------------------
DROP TABLE IF EXISTS `t_purchase_request1`;
CREATE TABLE `t_purchase_request1` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `ref_date` date DEFAULT NULL,
  `doc_number` varchar(20) DEFAULT '',
  `ref_number` varchar(100) DEFAULT '',
  `loc_id` int(11) DEFAULT -1,
  `is_submit` tinyint(1) DEFAULT 0,
  `submit_date` datetime DEFAULT NULL,
  `submit_by` int(11) DEFAULT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_by` int(11) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `remarks` varchar(255) DEFAULT '',
  PRIMARY KEY (`sysid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_purchase_request1
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_purchase_request2
-- ----------------------------
DROP TABLE IF EXISTS `t_purchase_request2`;
CREATE TABLE `t_purchase_request2` (
  `sysid` int(11) NOT NULL,
  `line` int(11) NOT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_code` varchar(20) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `muo_purchase` varchar(50) DEFAULT '',
  `conversion` decimal(10,4) DEFAULT 1.0000,
  `mou_inventory` varchar(50) DEFAULT '',
  `price` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `qty_order` decimal(10,2) DEFAULT 0.00,
  `qty_received` decimal(10,2) DEFAULT 0.00,
  `prc_discount1` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `discount1` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `prc_discount2` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `discount2` decimal(10,2) unsigned zerofill DEFAULT 00000000.00,
  `prc_tax` decimal(10,2) DEFAULT 0.00,
  `tax` decimal(10,2) DEFAULT 0.00,
  `total` decimal(10,2) DEFAULT 0.00,
  `remarks` varchar(255) DEFAULT '',
  `request_id` int(11) DEFAULT -1,
  `request_line` int(11) DEFAULT -1,
  `request_qty` decimal(10,2) DEFAULT NULL,
  `line_type` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`sysid`,`line`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_purchase_request2
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for t_user_logs
-- ----------------------------
DROP TABLE IF EXISTS `t_user_logs`;
CREATE TABLE `t_user_logs` (
  `sysid` int(11) NOT NULL AUTO_INCREMENT,
  `create_date` datetime DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `action` varchar(255) DEFAULT NULL,
  `data` longtext DEFAULT NULL,
  `document_sysid` bigint(20) DEFAULT NULL,
  `document_number` varchar(25) DEFAULT NULL,
  `descriptions` text DEFAULT NULL,
  `uri_link` text DEFAULT NULL,
  `time_execute` time DEFAULT NULL,
  PRIMARY KEY (`sysid`) USING BTREE,
  KEY `user_create_date` (`create_date`,`user_name`)
) ENGINE=InnoDB AUTO_INCREMENT=325 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of t_user_logs
-- ----------------------------
BEGIN;
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (1, '2022-10-04 11:39:22', 'IT', 'setupclass.store', 'setupclass.store^App\\Http\\Controllers\\Setup\\ServiceClassController@store', '{\"data\":{\"sysid\":-1,\"price_code\":\"01\",\"descriptions\":\"Kelas I\",\"sort_name\":\"I\",\"is_base_price\":true,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\",\"progress\":true}', 5, '01', 'Add/Update recods', 'api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (2, '2022-10-04 11:45:27', 'IT', 'setupclass.store^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":-1,\"price_code\":\"02\",\"descriptions\":\"Kelas 2\",\"sort_name\":\"II\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\",\"progress\":true}', 8, '02', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (3, '2022-10-04 12:06:17', 'IT', 'setupclass.store^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":-1,\"price_code\":\"03\",\"descriptions\":\"Kelas 3\",\"sort_name\":\"3\",\"is_base_price\":true,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\"}', 9, '03', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (4, '2022-10-04 12:18:01', 'IT', 'setup^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":8,\"price_code\":\"02\",\"descriptions\":\"Kelas 2\",\"sort_name\":\"II\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 8, '02', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (5, '2022-10-04 12:19:33', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":9,\"price_code\":\"03\",\"descriptions\":\"Kelas 3\",\"sort_name\":\"3\",\"is_base_price\":true,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 9, '03', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (6, '2022-10-04 12:37:15', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":9,\"price_code\":\"03\",\"descriptions\":\"Kelas 3\",\"sort_name\":\"3\",\"is_base_price\":true,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 9, '03', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (7, '2022-10-04 12:37:20', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@destroy', 'DELETE', '{\"sysid\":5}', 5, '01', 'Deleting recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (8, '2022-10-04 12:43:37', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":8,\"price_code\":\"02\",\"descriptions\":\"Kelas 2\",\"sort_name\":\"II\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 8, '02', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (9, '2022-10-04 12:44:08', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":9,\"price_code\":\"03\",\"descriptions\":\"Kelas 3\",\"sort_name\":\"3\",\"is_base_price\":true,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 9, '03', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (10, '2022-10-04 12:45:18', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":8,\"price_code\":\"02\",\"descriptions\":\"Kelas 2\",\"sort_name\":\"II\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 8, '02', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (11, '2022-10-04 12:51:59', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":-1,\"price_code\":\"RJ\",\"descriptions\":\"Rawat Jalan\",\"sort_name\":\"RJ\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":true,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\"}', 10, 'RJ', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (12, '2022-10-04 12:52:11', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":-1,\"price_code\":\"VIP\",\"descriptions\":\"Kelas VIP\",\"sort_name\":\"VIP\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\"}', 11, 'VIP', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (13, '2022-10-04 12:52:25', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":-1,\"price_code\":\"SVIP\",\"descriptions\":\"Kelas SVIP\",\"sort_name\":\"\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\"}', 12, 'SVIP', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (14, '2022-10-04 12:52:44', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":-1,\"price_code\":\"ICU\",\"descriptions\":\"Kelas ICU\",\"sort_name\":\"ICU\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\"}', 13, 'ICU', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (15, '2022-10-04 12:53:42', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":10,\"price_code\":\"RJ\",\"descriptions\":\"Rawat Jalan\",\"sort_name\":\"RJ\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":true,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 10, 'RJ', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (16, '2022-10-04 12:53:52', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":10,\"price_code\":\"RJ\",\"descriptions\":\"Rawat Jalan\",\"sort_name\":\"RJ\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":true,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 10, 'RJ', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (17, '2022-10-04 13:00:08', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":9,\"price_code\":\"03\",\"descriptions\":\"Kelas 3\",\"sort_name\":\"3\",\"is_base_price\":true,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 9, '03', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (18, '2022-10-04 13:00:12', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":11,\"price_code\":\"VIP\",\"descriptions\":\"Kelas VIP\",\"sort_name\":\"VIP\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 11, 'VIP', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (19, '2022-10-04 13:00:19', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":13,\"price_code\":\"ICU\",\"descriptions\":\"Kelas ICU\",\"sort_name\":\"ICU\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 13, 'ICU', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (20, '2022-10-04 15:41:18', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"dept_group\":\"OUTPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (21, '2022-10-04 15:42:11', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"PKA001\",\"dept_name\":\"Klinik Akupuntur\",\"sort_name\":\"ACCUPUNTURE\",\"dept_group\":\"OUTPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 2, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (22, '2022-10-04 15:42:36', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"KA0001\",\"dept_name\":\"Klinik Anak\",\"sort_name\":\"PEDIATRIC\",\"dept_group\":\"OUTPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (23, '2022-10-04 15:43:07', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"KUR001\",\"dept_name\":\"Klinik Urologi\",\"sort_name\":\"UROLOGI\",\"dept_group\":\"OUTPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 4, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (24, '2022-10-04 15:43:25', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"KSY001\",\"dept_name\":\"Klinik Syaraf\",\"sort_name\":\"SYARAF\",\"dept_group\":\"OUTPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 5, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (25, '2022-10-04 15:43:40', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"KBE\",\"dept_name\":\"Klinik Bedah\",\"sort_name\":\"BEDAH\",\"dept_group\":\"OUTPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 6, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (26, '2022-10-04 15:44:53', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"KTH001\",\"dept_name\":\"Klinik THT\",\"sort_name\":\"THT\",\"dept_group\":\"OUTPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 7, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (27, '2022-10-04 15:45:23', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"KGI001\",\"dept_name\":\"Klinik Gigi\",\"sort_name\":\"GIGI\",\"dept_group\":\"OUTPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 8, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (28, '2022-10-04 16:18:08', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"IGD01\",\"dept_name\":\"Instalasi Gawat Darurat\",\"sort_name\":\"IGD\",\"dept_group\":\"IGD\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 9, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (29, '2022-10-04 16:25:10', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"PHAR001\",\"dept_name\":\"Farmasi Rawat Jalan\",\"sort_name\":\"PHAR-RJ\",\"dept_group\":\"DIAGNOSTIC\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 10, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (30, '2022-10-04 16:27:00', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@destroy', 'DELETE', '{\"sysid\":10}', 10, NULL, 'Deleting recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (31, '2022-10-04 16:27:35', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"PJLAB\",\"dept_name\":\"LABORATORIUM\",\"sort_name\":\"LAB\",\"dept_group\":\"DIAGNOSTIC\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 11, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (32, '2022-10-04 16:27:45', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"RAD\",\"dept_name\":\"RADIOLOGI\",\"sort_name\":\"RAD\",\"dept_group\":\"DIAGNOSTIC\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 12, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (33, '2022-10-04 16:27:56', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"FISIO\",\"dept_name\":\"FISIOTERAPI\",\"sort_name\":\"FISIO\",\"dept_group\":\"DIAGNOSTIC\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 13, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (34, '2022-10-04 16:28:35', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"ENBOS\",\"dept_name\":\"ENDOSKOPI\",\"sort_name\":\"ENDOS\",\"dept_group\":\"DIAGNOSTIC\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 14, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (35, '2022-10-04 16:28:55', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"PHAR01\",\"dept_name\":\"FARMASI RAWAT JALAN\",\"sort_name\":\"PHAR-RJ\",\"dept_group\":\"PHARMACY\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 15, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (36, '2022-10-04 16:29:16', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"PHAR02\",\"dept_name\":\"FARMASI RAWAT INAP\",\"sort_name\":\"PHAR-RI\",\"dept_group\":\"PHARMACY\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 16, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (37, '2022-10-04 16:29:35', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"PHAR-OK\",\"dept_name\":\"FARMASI RUANG OPERASI\",\"sort_name\":\"PHAR-OK\",\"dept_group\":\"PHARMACY\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 17, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (38, '2022-10-04 16:29:57', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"PHAR-IGD\",\"dept_name\":\"FARMASI IGD\",\"sort_name\":\"PHAR-IGD\",\"dept_group\":\"PHARMACY\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 18, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (39, '2022-10-04 16:49:52', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"INSTD\",\"dept_name\":\"PELAYANAN STANDAR\",\"sort_name\":\"STDR\",\"dept_group\":\"INPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 19, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (40, '2022-10-04 16:50:07', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"INICU\",\"dept_name\":\"PELAYANAN ICU\",\"sort_name\":\"ICU\",\"dept_group\":\"INPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 20, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (41, '2022-10-04 16:50:25', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"INSBAYI\",\"dept_name\":\"PELAYANAN KAMAR BAYI\",\"sort_name\":\"BABYROOM\",\"dept_group\":\"INPATIENT\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 21, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (42, '2022-10-04 16:52:55', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":6,\"dept_code\":\"KBE001\",\"dept_name\":\"Klinik Bedah\",\"sort_name\":\"BEDAH\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"price_class\":\"\",\"is_active\":true,\"update_userid\":\"IT\",\"create_date\":\"2022-10-04T08:43:40.000000Z\",\"update_date\":\"2022-10-04T08:43:40.000000Z\"},\"operation\":\"updated\"}', 6, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (43, '2022-10-04 16:55:02', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"MCU001\",\"dept_name\":\"MEDICAL CHECKUP\",\"sort_name\":\"MCU\",\"dept_group\":\"MCU\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 22, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (44, '2022-10-04 16:55:23', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"MCU002\",\"dept_name\":\"MEDICAL CHECKUP (PROJECT)\",\"sort_name\":\"MCU02\",\"dept_group\":\"MCU\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wg_pharmacy_name\":\"\",\"is_active\":true},\"operation\":\"inserted\"}', 23, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (45, '2022-10-04 16:57:04', 'IT', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":8,\"dept_code\":\"KGI001\",\"dept_name\":\"Klinik Gigi\",\"sort_name\":\"GIGI\",\"wh_medical\":\"\",\"wh_general\":\"\",\"wh_pharmacy\":\"\",\"price_class\":\"\",\"is_active\":true,\"update_userid\":\"IT\",\"create_date\":\"2022-10-04T08:45:23.000000Z\",\"update_date\":\"2022-10-04T08:45:23.000000Z\"},\"operation\":\"updated\"}', 8, 'KGI001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (46, '2022-10-04 17:00:51', 'IT', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":13,\"price_code\":\"ICU\",\"descriptions\":\"Kelas ICU\",\"sort_name\":\"ICU\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 13, 'ICU', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (47, '2022-10-04 21:24:39', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":8,\"price_code\":\"02\",\"descriptions\":\"Kelas 2\",\"sort_name\":\"II\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 8, '02', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (48, '2022-10-04 21:46:13', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\PriceLevelController@store', 'POST', '{\"data\":{\"sysid\":-1,\"level_code\":\"L1\",\"descriptions\":\"Default\",\"is_active\":true},\"operation\":\"inserted\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/pricelevel', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (49, '2022-10-04 21:46:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\PriceLevelController@store', 'POST', '{\"data\":{\"sysid\":-1,\"level_code\":\"L2\",\"descriptions\":\"Level 2\",\"is_active\":true},\"operation\":\"inserted\"}', 2, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/pricelevel', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (50, '2022-10-05 16:46:46', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"GFRJ01\",\"location_name\":\"Gudang Farmasi Rawat Jalan\",\"is_sales\":true,\"is_distribution\":true,\"is_received\":true,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (51, '2022-10-05 16:47:10', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"GFRI01\",\"location_name\":\"Gudang Farmasi Rawat Inap\",\"is_sales\":true,\"is_distribution\":true,\"is_received\":true,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 2, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (52, '2022-10-05 16:47:30', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"GFIGD\",\"location_name\":\"Gudang Farmasi IGD\",\"is_sales\":true,\"is_distribution\":true,\"is_received\":true,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (53, '2022-10-05 16:52:20', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":3,\"loc_code\":\"GFIGD0\",\"location_name\":\"Gudang Farmasi IGD\",\"is_received\":true,\"is_sales\":true,\"is_distribution\":true,\"is_active\":true},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (54, '2022-10-05 16:57:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"GU0001\",\"location_name\":\"Gudang Logistik Umum\",\"is_sales\":false,\"is_distribution\":true,\"is_received\":true,\"warehouse_group\":\"GENERAL\",\"is_active\":true},\"operation\":\"inserted\"}', 4, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (55, '2022-10-05 16:57:43', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"GF0001\",\"location_name\":\"Gudang Farmasi\",\"is_sales\":true,\"is_distribution\":true,\"is_received\":true,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 5, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (56, '2022-10-05 16:57:53', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":5,\"loc_code\":\"GF0001\",\"location_name\":\"Gudang Utama Farmasi\",\"is_received\":true,\"is_sales\":true,\"is_distribution\":true,\"is_active\":true},\"operation\":\"updated\"}', 5, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (57, '2022-10-05 16:57:59', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":5,\"loc_code\":\"GF0001\",\"location_name\":\"Gudang Utama Farmasi\",\"is_received\":true,\"is_sales\":false,\"is_distribution\":true,\"is_active\":true},\"operation\":\"updated\"}', 5, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (58, '2022-10-05 16:58:19', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":3,\"loc_code\":\"GFIGD0\",\"location_name\":\"Gudang Farmasi IGD\",\"is_received\":false,\"is_sales\":true,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (59, '2022-10-05 16:58:29', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":3,\"loc_code\":\"GFIGD0\",\"location_name\":\"Farmasi IGD\",\"is_received\":false,\"is_sales\":true,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (60, '2022-10-05 16:58:41', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":2,\"loc_code\":\"GFRI01\",\"location_name\":\"Farmasi Rawat Inap\",\"is_received\":false,\"is_sales\":true,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 2, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (61, '2022-10-05 16:58:53', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":1,\"loc_code\":\"GFRJ01\",\"location_name\":\"Farmasi Rawat Jalan\",\"is_received\":false,\"is_sales\":true,\"is_distribution\":true,\"is_active\":true},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (62, '2022-10-05 16:59:02', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":1,\"loc_code\":\"GFRJ01\",\"location_name\":\"Farmasi Rawat Jalan\",\"is_received\":false,\"is_sales\":true,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (63, '2022-10-05 17:03:35', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"POLITARUMA\",\"location_name\":\"POLI TARUMA\",\"is_sales\":true,\"is_distribution\":true,\"is_received\":true,\"warehouse_group\":\"GENERAL\",\"is_active\":true},\"operation\":\"inserted\"}', 6, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (64, '2022-10-05 17:03:52', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"POLIROYAL\",\"location_name\":\"POLI ROYAL\",\"is_sales\":false,\"is_distribution\":false,\"is_received\":false,\"warehouse_group\":\"GENERAL\",\"is_active\":true},\"operation\":\"inserted\"}', 7, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (65, '2022-10-05 17:04:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":6,\"loc_code\":\"POLITARUMA\",\"location_name\":\"POLI TARUMA\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 6, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (66, '2022-10-05 17:04:07', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":6,\"loc_code\":\"POLITARUMA\",\"location_name\":\"POLI TARUMA\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 6, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (67, '2022-10-05 17:04:25', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":6,\"loc_code\":\"POLITARUMA\",\"location_name\":\"POLI TARUMA\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 6, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (68, '2022-10-05 17:04:59', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"POLPE01\",\"location_name\":\"POLI PENYAKIT DALAM\",\"is_sales\":false,\"is_distribution\":false,\"is_received\":false,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 8, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (69, '2022-10-05 17:05:17', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":8,\"loc_code\":\"KPE01\",\"location_name\":\"POLI PENYAKIT DALAM\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 8, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (70, '2022-10-05 17:05:31', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"KAN01\",\"location_name\":\"POLI ANAK\",\"is_sales\":true,\"is_distribution\":true,\"is_received\":true,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 9, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (71, '2022-10-05 17:05:41', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"KSA01\",\"location_name\":\"POLI SYARAF\",\"is_sales\":true,\"is_distribution\":true,\"is_received\":true,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 10, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (72, '2022-10-05 17:06:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"KJAN\",\"location_name\":\"POLI JANTUNG DAN PEMBULUH DARAH\",\"is_sales\":false,\"is_distribution\":false,\"is_received\":false,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 11, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (73, '2022-10-05 17:06:05', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":10,\"loc_code\":\"KSA01\",\"location_name\":\"POLI SYARAF\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 10, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (74, '2022-10-05 17:06:13', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":9,\"loc_code\":\"KAN01\",\"location_name\":\"POLI ANAK\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 9, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (75, '2022-10-05 17:06:32', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"PTH01\",\"location_name\":\"POLI THT\",\"is_sales\":true,\"is_distribution\":true,\"is_received\":true,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 12, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (76, '2022-10-05 17:06:50', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"PPA01\",\"location_name\":\"POLI PARU\",\"is_sales\":false,\"is_distribution\":false,\"is_received\":false,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 13, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (77, '2022-10-05 17:06:56', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":12,\"loc_code\":\"PTH01\",\"location_name\":\"POLI THT\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 12, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (78, '2022-10-05 17:07:35', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"PMA01\",\"location_name\":\"POLI MATA\",\"is_sales\":false,\"is_distribution\":false,\"is_received\":false,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 14, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (79, '2022-10-05 17:07:44', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":14,\"loc_code\":\"KMA01\",\"location_name\":\"POLI MATA\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 14, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (80, '2022-10-05 17:07:48', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":13,\"loc_code\":\"KPA01\",\"location_name\":\"POLI PARU\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 13, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (81, '2022-10-05 17:07:57', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":12,\"loc_code\":\"KTH01\",\"location_name\":\"POLI THT\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 12, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (82, '2022-10-05 17:08:21', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"KBU01\",\"location_name\":\"POLI BEDAH UMUM\",\"is_sales\":false,\"is_distribution\":false,\"is_received\":false,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 15, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (83, '2022-10-05 17:08:47', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"KOR\",\"location_name\":\"POLI ORTHOPEDI\",\"is_sales\":false,\"is_distribution\":false,\"is_received\":false,\"warehouse_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 16, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (84, '2022-10-05 17:42:28', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":2,\"loc_code\":\"GFRI01\",\"location_name\":\"Farmasi Rawat Inap\",\"is_received\":false,\"is_sales\":true,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 2, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (85, '2022-10-05 17:42:32', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":2,\"loc_code\":\"GFRI01\",\"location_name\":\"Farmasi Rawat Inap\",\"is_received\":false,\"is_sales\":true,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 2, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (86, '2022-10-05 19:51:49', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":15,\"loc_code\":\"KBU01\",\"location_name\":\"POLI BEDAH UMUM\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 15, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (87, '2022-10-06 15:25:24', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":4,\"dept_code\":\"KUR001\",\"dept_name\":\"Klinik Urologi\",\"sort_name\":\"UROLOGI\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":null,\"price_class\":\"\",\"is_active\":true,\"update_userid\":\"IT\",\"create_date\":\"2022-10-04T08:43:07.000000Z\",\"update_date\":\"2022-10-04T08:43:07.000000Z\"},\"operation\":\"updated\"}', 4, 'KUR001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (88, '2022-10-06 15:30:17', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":-1,\"price_code\":\"PHARRJ\",\"descriptions\":\"Farnasi Rawat Jalan\",\"sort_name\":\"RJ\",\"is_base_price\":false,\"is_price_class\":false,\"is_service_class\":false,\"is_pharmacy_class\":true,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\"}', 14, 'PHARRJ', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (89, '2022-10-06 15:30:32', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":-1,\"price_code\":\"PHARRI\",\"descriptions\":\"Farmasi Rawat Inap\",\"sort_name\":\"RI\",\"is_base_price\":false,\"is_price_class\":false,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\"}', 15, 'PHARRI', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (90, '2022-10-06 15:30:39', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":15,\"price_code\":\"PHARRI\",\"descriptions\":\"Farmasi Rawat Inap\",\"sort_name\":\"RI\",\"is_base_price\":false,\"is_price_class\":false,\"is_service_class\":false,\"is_pharmacy_class\":true,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 15, 'PHARRI', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (91, '2022-10-06 15:31:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":-1,\"price_code\":\"PHAREMG\",\"descriptions\":\"Obat Emergency\",\"sort_name\":\"EMG\",\"is_base_price\":false,\"is_price_class\":false,\"is_service_class\":false,\"is_pharmacy_class\":true,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"inserted\"}', 16, 'PHAREMG', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (92, '2022-10-06 15:40:58', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":1,\"loc_code\":\"GFRJ01\",\"location_name\":\"Farmasi Rawat Jalan\",\"is_received\":false,\"is_sales\":true,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (93, '2022-10-06 15:41:51', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":12,\"loc_code\":\"KTH01\",\"location_name\":\"POLI THT\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 12, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (94, '2022-10-06 15:49:56', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":6,\"loc_code\":\"POLITARUMA\",\"location_name\":\"POLI TARUMA\",\"is_received\":false,\"is_sales\":false,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 6, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (95, '2022-10-06 20:36:25', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"wh_medical\":8,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":\"\",\"is_active\":true,\"update_userid\":\"IT\",\"create_date\":\"2022-10-04T08:41:18.000000Z\",\"update_date\":\"2022-10-04T08:41:18.000000Z\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\",\"wh_medical_name\":\"KPE01 - POLI PENYAKIT DALAM\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (96, '2022-10-06 20:39:23', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":12,\"price_code\":\"SVIP\",\"descriptions\":\"Kelas SVIP\",\"sort_name\":\"SVIP\",\"is_base_price\":false,\"is_price_class\":true,\"is_service_class\":true,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 12, 'SVIP', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (97, '2022-10-06 20:48:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"wh_medical\":8,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":\"\",\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-04T08:41:18.000000Z\",\"update_date\":\"2022-10-06T13:36:25.000000Z\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\",\"wh_medical_name\":\"KPE01 - POLI PENYAKIT DALAM\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (98, '2022-10-06 20:51:58', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"wh_medical\":9,\"wh_general\":6,\"wh_pharmacy\":16,\"price_class\":\"\",\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-04T08:41:18.000000Z\",\"update_date\":\"2022-10-06T13:36:25.000000Z\",\"wh_medical_name\":\"KAN01 - POLI ANAK\",\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (99, '2022-10-06 20:52:17', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":3,\"dept_code\":\"KA0001\",\"dept_name\":\"Klinik Anak\",\"sort_name\":\"PEDIATRIC\",\"wh_medical\":9,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":\"\",\"is_active\":true,\"update_userid\":\"IT\",\"create_date\":\"2022-10-04T08:42:36.000000Z\",\"update_date\":\"2022-10-04T08:42:36.000000Z\",\"wh_medical_name\":\"KAN01 - POLI ANAK\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 3, 'KA0001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (100, '2022-10-06 21:16:19', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"wh_medical\":8,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-04T08:41:18.000000Z\",\"update_date\":\"2022-10-06T13:51:58.000000Z\",\"is_executive\":false,\"wh_medical_name\":\"KPE01 - POLI PENYAKIT DALAM\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\",\"price_class_name\":\"RJ - Rawat Jalan\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (101, '2022-10-06 21:30:36', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"is_executive\":false,\"wh_medical\":8,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":true,\"wh_medical_name\":\"KPE01 - POLI TARUMA\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (102, '2022-10-06 21:32:48', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":-1,\"dept_code\":\"KPE02\",\"dept_name\":\"Klinik Penyakit Dalam Executive\",\"sort_name\":\"KPE02\",\"dept_group\":\"OUTPATIENT\",\"wh_medical\":8,\"wh_general\":6,\"wh_pharmacy\":15,\"wh_medical_name\":\"KPE01 - POLI PENYAKIT DALAM\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\",\"is_executive\":true,\"price_class\":10,\"price_class_name\":\"RJ - Rawat Jalan\",\"is_active\":true},\"operation\":\"inserted\"}', 24, 'KPE02', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (103, '2022-10-06 21:33:04', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":24,\"dept_code\":\"KPE002\",\"dept_name\":\"Klinik Penyakit Dalam Executive\",\"sort_name\":\"KPE002\",\"is_executive\":true,\"wh_medical\":8,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":true,\"wh_medical_name\":\"KPE01 - POLI TARUMA\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 24, 'KPE002', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (104, '2022-10-07 09:39:09', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":9,\"dept_code\":\"IGD01\",\"dept_name\":\"Instalasi Gawat Darurat\",\"sort_name\":\"IGD\",\"is_executive\":false,\"wh_medical\":3,\"wh_general\":4,\"wh_pharmacy\":18,\"price_class\":10,\"is_active\":true,\"wh_medical_name\":\"GFIGD0 - Farmasi IGD\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR-IGD - FARMASI IGD\"},\"operation\":\"updated\"}', 9, 'IGD01', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (105, '2022-10-07 09:44:32', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":19,\"dept_code\":\"INSTD\",\"dept_name\":\"PELAYANAN STANDAR\",\"sort_name\":\"STDR\",\"is_executive\":false,\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":null,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"-\",\"wh_general_name\":\"-\",\"price_class_name\":\"-\",\"wh_pharmacy_name\":\"-\"},\"operation\":\"updated\"}', 19, 'INSTD', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (106, '2022-10-07 09:47:56', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":19,\"dept_code\":\"INSTD\",\"dept_name\":\"PELAYANAN STANDAR\",\"sort_name\":\"STDR\",\"is_executive\":false,\"wh_medical\":14,\"wh_general\":4,\"wh_pharmacy\":16,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"KMA01 - POLI MATA\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"-\",\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\"},\"operation\":\"updated\"}', 19, 'INSTD', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (107, '2022-10-07 09:50:50', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":15,\"dept_code\":\"PHAR01\",\"dept_name\":\"FARMASI RAWAT JALAN\",\"sort_name\":\"PHAR-RJ\",\"is_executive\":false,\"wh_medical\":1,\"wh_general\":4,\"wh_pharmacy\":null,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"GFRJ01 - Farmasi Rawat Jalan\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"-\",\"wh_pharmacy_name\":\"-\"},\"operation\":\"updated\"}', 15, 'PHAR01', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (108, '2022-10-07 10:27:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":9,\"price_code\":\"03\",\"descriptions\":\"Kelas 3\",\"sort_name\":\"3\",\"is_base_price\":true,\"is_price_class\":true,\"is_service_class\":false,\"is_pharmacy_class\":false,\"is_bpjs_class\":false,\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 9, '03', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (109, '2022-10-07 11:27:03', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":-1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"paramedic_type\":\"DOCTOR\",\"employee_id\":\"\",\"price_group\":null,\"email\":\"\",\"is_internal\":true,\"is_permanent\":true,\"is_transfer\":false,\"is_email_reports\":false,\"tax_number\":\"\",\"bank_name\":\"\",\"accout_name\":\"\",\"account_number\":\"\",\"cityzen_number\":\"\",\"bpjs_number\":\"\",\"is_active\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (110, '2022-10-07 11:28:49', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"BCA\",\"account_name\":\"Ade\",\"account_number\":\"415201213\",\"is_active\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (111, '2022-10-07 11:38:32', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"BCA\",\"account_number\":\"415201213\",\"is_active\":true,\"is_email_reports\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (112, '2022-10-07 11:39:12', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"BCA\",\"account_number\":\"415201213\",\"is_active\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (113, '2022-10-07 13:46:21', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"BCA\",\"account_number\":\"415201213\",\"is_active\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (114, '2022-10-07 13:48:36', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"BCA\",\"account_number\":\"415201213\",\"is_active\":true,\"is_email_reports\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (115, '2022-10-07 13:50:18', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"ADE\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_active\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (116, '2022-10-07 13:50:38', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"ADE\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_active\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (117, '2022-10-07 13:52:39', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"ADE\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_active\":true,\"is_transfer\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (118, '2022-10-07 13:52:50', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"ADE\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_active\":true,\"is_transfer\":true}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (119, '2022-10-07 14:31:12', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"ADE\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"address\":\"Jakarta\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\",\"dob\":\"2022-10-01\",\"phone1\":\"-\",\"phone2\":\"-\"}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (120, '2022-10-07 14:38:56', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"ADE\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"dob\":\"2022-10-01\",\"address\":\"Jl. Raya Centex Gg Mebel No.31\",\"phone1\":\"-\",\"phone2\":\"-\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\"}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (121, '2022-10-07 14:49:10', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":-1,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD\",\"paramedic_type\":\"DOCTOR\",\"employee_id\":\"\",\"price_group\":null,\"email\":\"\",\"is_internal\":true,\"is_permanent\":true,\"is_transfer\":true,\"is_email_reports\":false,\"tax_number\":\"\",\"bank_name\":\"BCA\",\"accout_name\":\"\",\"account_number\":\"\",\"cityzen_number\":\"\",\"bpjs_number\":\"\",\"is_active\":true,\"dept_sysid\":-1,\"dept_name\":\"\",\"specialist_sysid\":-1,\"specialist_name\":\"\",\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":\"\",\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\"}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (122, '2022-10-07 14:50:02', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"Andi Sutanto\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"dob\":\"2022-10-01\",\"address\":\"Jl. Raya Centex Gg Mebel No.31\",\"phone1\":\"-\",\"phone2\":\"-\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\"}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (123, '2022-10-07 14:52:03', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"Andi Sutanto\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"dob\":\"2022-10-01\",\"address\":\"Jl. Raya Centex Gg Mebel No.31\",\"phone1\":\"-\",\"phone2\":\"-\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\"}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (124, '2022-10-07 14:52:34', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":2,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"Bank Syariah Indonesia\",\"account_name\":\"Najla Nuranna Azizah\",\"account_number\":\"\",\"is_email_reports\":false,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":-1,\"dept_name\":\"-\",\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":null,\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\"}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (125, '2022-10-07 14:56:28', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":2,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"Bank Syariah Indonesia\",\"account_name\":\"Najla Nuranna Azizah\",\"account_number\":\"\",\"is_email_reports\":false,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":-1,\"dept_name\":\"-\",\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":null,\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\"}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (126, '2022-10-07 15:42:14', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicPriceGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"G1\",\"group_name\":\"Golongan Standar\",\"is_active\":true},\"operation\":\"inserted\"}', 4, 'G1', 'Add/Update recods', 'http://localhost:8000/api/setup/price-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (127, '2022-10-07 15:42:26', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicPriceGroupController@destroy', 'DELETE', '{\"sysid\":4}', 4, 'G1', 'Deleting recods', 'http://localhost:8000/api/setup/price-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (128, '2022-10-07 15:43:59', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicPriceGroupController@store', 'POST', '{\"data\":{\"sysid\":1,\"group_code\":\"DEF01\",\"group_name\":\"Golongan Tarif Dokter Standar\",\"is_active\":true},\"operation\":\"updated\"}', 1, 'DEF01', 'Add/Update recods', 'http://localhost:8000/api/setup/price-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (129, '2022-10-07 15:44:37', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicPriceGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"KONSUL01\",\"group_name\":\"Golongan Tarif Konsultan (Sub Spesialis)\",\"is_active\":true},\"operation\":\"inserted\"}', 5, 'KONSUL01', 'Add/Update recods', 'http://localhost:8000/api/setup/price-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (130, '2022-10-07 15:50:10', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicSpecialistController@store', 'POST', '{\"data\":{\"sysid\":1,\"specialist_name\":\"Spesialis Penyakit Dalam\",\"is_active\":true},\"operation\":\"updated\"}', 1, '', 'Add/Update recods', 'http://localhost:8000/api/setup/specialist', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (131, '2022-10-07 15:50:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicSpecialistController@store', 'POST', '{\"data\":{\"sysid\":-1,\"specialist_name\":\"Spesialis Urologi\",\"is_active\":true},\"operation\":\"inserted\"}', 6, '', 'Add/Update recods', 'http://localhost:8000/api/setup/specialist', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (132, '2022-10-07 15:50:48', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicSpecialistController@store', 'POST', '{\"data\":{\"sysid\":-1,\"specialist_name\":\"Spesialis Paru\",\"is_active\":true},\"operation\":\"inserted\"}', 7, '', 'Add/Update recods', 'http://localhost:8000/api/setup/specialist', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (133, '2022-10-07 15:50:55', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicSpecialistController@store', 'POST', '{\"data\":{\"sysid\":2,\"specialist_name\":\"Spesialis Mata\",\"is_active\":true},\"operation\":\"updated\"}', 2, '', 'Add/Update recods', 'http://localhost:8000/api/setup/specialist', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (134, '2022-10-07 15:51:46', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicSpecialistController@store', 'POST', '{\"data\":{\"sysid\":3,\"specialist_name\":\"Spesialis THT\",\"is_active\":true},\"operation\":\"updated\"}', 3, '', 'Add/Update recods', 'http://localhost:8000/api/setup/specialist', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (135, '2022-10-07 15:59:06', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":2,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD\",\"specialist_name\":null,\"price_group\":null,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"Bank Syariah Indonesia\",\"account_name\":\"Najla Nuranna Azizah\",\"account_number\":\"\",\"is_email_reports\":false,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":-1,\"dept_name\":\"-\",\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":null,\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\",\"price_groups\":1}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (136, '2022-10-07 16:01:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":1,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"Andi Sutanto\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"dob\":\"2022-10-01\",\"address\":\"Jl. Raya Centex Gg Mebel No.31\",\"phone1\":\"-\",\"phone2\":\"-\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\"}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (137, '2022-10-07 16:01:27', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":2,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD\",\"specialist_name\":null,\"price_group\":5,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"Bank Syariah Indonesia\",\"account_name\":\"Najla Nuranna Azizah\",\"account_number\":\"\",\"is_email_reports\":false,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":-1,\"dept_name\":\"-\",\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":null,\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\"}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (138, '2022-10-07 16:16:42', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":5,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"Andi Sutanto\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"dob\":\"2022-10-01\",\"address\":\"Jl. Raya Centex Gg Mebel No.31\",\"phone1\":\"-\",\"phone2\":\"-\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\"}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (139, '2022-10-07 16:16:56', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":2,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD(K)\",\"specialist_name\":null,\"price_group\":5,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"Bank Syariah Indonesia\",\"account_name\":\"Najla Nuranna Azizah\",\"account_number\":\"\",\"is_email_reports\":false,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":-1,\"dept_name\":\"-\",\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":null,\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\"}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (140, '2022-10-07 16:17:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":1,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"Andi Sutanto\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"dob\":\"2022-10-01\",\"address\":\"Jl. Raya Centex Gg Mebel No.31\",\"phone1\":\"-\",\"phone2\":\"-\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\"}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (141, '2022-10-07 16:22:09', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":null,\"price_group\":1,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"Andi Sutanto\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_transfer\":true,\"is_active\":true,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"dob\":\"2022-10-01\",\"address\":\"Jl. Raya Centex Gg Mebel No.31\",\"phone1\":\"-\",\"phone2\":\"-\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\",\"specialist_sysid\":1}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (142, '2022-10-07 16:23:03', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":\"Spesialis Penyakit Dalam\",\"price_group\":1,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"Andi Sutanto\",\"account_number\":\"415201213\",\"is_email_reports\":true,\"is_transfer\":true,\"is_active\":true,\"specialist_sysid\":1,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"dob\":\"2022-10-01\",\"address\":\"Jl. Raya Centex Gg Mebel No.31\",\"phone1\":\"-\",\"phone2\":\"-\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\"}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (143, '2022-10-07 16:23:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":2,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD(K)\",\"specialist_name\":null,\"price_group\":5,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"Bank Syariah Indonesia\",\"account_name\":\"Najla Nuranna Azizah\",\"account_number\":\"\",\"is_email_reports\":false,\"is_transfer\":true,\"is_active\":true,\"specialist_sysid\":1,\"dept_sysid\":-1,\"dept_name\":\"-\",\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":null,\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\"}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (144, '2022-10-07 16:37:16', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":19,\"dept_code\":\"INSTD\",\"dept_name\":\"PELAYANAN STANDAR\",\"sort_name\":\"STDR\",\"is_executive\":false,\"wh_medical\":2,\"wh_general\":4,\"wh_pharmacy\":16,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"GFRI01 - Farmasi Rawat Inap\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"-\",\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\"},\"operation\":\"updated\"}', 19, 'INSTD', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (145, '2022-10-07 16:38:53', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"is_executive\":false,\"wh_medical\":5,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":true,\"wh_medical_name\":\"GF0001 - Gudang Utama Farmasi\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (146, '2022-10-07 16:39:07', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"is_executive\":false,\"wh_medical\":14,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":true,\"wh_medical_name\":\"KMA01 - POLI MATA\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (147, '2022-10-07 16:41:02', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":9,\"dept_code\":\"IGD01\",\"dept_name\":\"Instalasi Gawat Darurat\",\"sort_name\":\"IGD\",\"is_executive\":false,\"wh_medical\":3,\"wh_general\":4,\"wh_pharmacy\":18,\"price_class\":10,\"is_active\":true,\"wh_medical_name\":\"GFIGD0 - Farmasi IGD\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR-IGD - FARMASI IGD\"},\"operation\":\"updated\"}', 9, 'IGD01', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (148, '2022-10-07 16:47:39', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":19,\"dept_code\":\"INSTD\",\"dept_name\":\"PELAYANAN STANDAR\",\"sort_name\":\"STDR\",\"is_executive\":false,\"wh_medical\":2,\"wh_general\":4,\"wh_pharmacy\":16,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"GFRI01 - Farmasi Rawat Inap\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"-\",\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\"},\"operation\":\"updated\"}', 19, 'INSTD', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (149, '2022-10-07 17:13:30', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardsController@store', 'POST', '{\"data\":{\"sysid\":-1,\"ward_cide\":\"\",\"ward_name\":\"Ruang Perawatan Topas\",\"sort_name\":\"TOPAS\",\"wh_medical\":-1,\"wh_general\":-1,\"wh_pharmacy\":-1,\"wh_medical_name\":\"\",\"wh_general_name\":\"\",\"wh_pharmacy_name\":\"\",\"is_executive\":false,\"is_active\":true,\"ward_code\":\"R1\"},\"operation\":\"inserted\"}', 1, 'R1', 'Add/Update recods', 'http://localhost:8000/api/setup/ward', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (150, '2022-10-07 17:13:53', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardsController@store', 'POST', '{\"data\":{\"sysid\":-1,\"ward_cide\":\"\",\"ward_name\":\"Ruang Perawatan Zircon\",\"sort_name\":\"ZIRCON\",\"wh_medical\":2,\"wh_general\":4,\"wh_pharmacy\":16,\"wh_medical_name\":\"GFRI01 - Farmasi Rawat Inap\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\",\"is_executive\":false,\"is_active\":true,\"ward_code\":\"R2\"},\"operation\":\"inserted\"}', 2, 'R2', 'Add/Update recods', 'http://localhost:8000/api/setup/ward', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (151, '2022-10-07 19:45:44', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardsController@store', 'POST', '{\"data\":{\"sysid\":1,\"ward_code\":\"R1\",\"ward_name\":\"Ruang Perawatan Topas\",\"sort_name\":\"TOPAS\",\"is_executive\":false,\"wh_medical\":5,\"wh_general\":4,\"wh_pharmacy\":16,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"GF0001 - Gudang Utama Farmasi\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\"},\"operation\":\"updated\"}', 1, 'R1', 'Add/Update recods', 'http://localhost:8000/api/setup/ward', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (152, '2022-10-07 19:47:44', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardsController@store', 'POST', '{\"data\":{\"sysid\":1,\"ward_code\":\"R1\",\"ward_name\":\"Ruang Perawatan Topas\",\"sort_name\":\"TOPAS\",\"is_executive\":false,\"wh_medical\":5,\"wh_general\":4,\"wh_pharmacy\":16,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"GF0001 - Gudang Utama Farmasi\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\"},\"operation\":\"updated\"}', 1, 'R1', 'Add/Update recods', 'http://localhost:8000/api/setup/ward', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (153, '2022-10-07 20:09:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":2,\"dept_code\":\"PKA001\",\"dept_name\":\"Klinik Akupuntur\",\"sort_name\":\"ACCUPUNTURE\",\"is_executive\":false,\"wh_medical\":1,\"wh_general\":4,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":true,\"wh_medical_name\":\"GFRJ01 - Farmasi Rawat Jalan\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 2, 'PKA001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (154, '2022-10-07 20:16:02', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardsController@store', 'POST', '{\"data\":{\"sysid\":1,\"ward_code\":\"R1\",\"ward_name\":\"Ruang Perawatan Topas\",\"sort_name\":\"TOPAS\",\"is_executive\":false,\"wh_medical\":5,\"wh_general\":4,\"wh_pharmacy\":16,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"GF0001 - Gudang Utama Farmasi\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\",\"inpatient_service\":\"INSTD - PELAYANAN STANDAR\",\"dept_sysid\":19},\"operation\":\"updated\"}', 1, 'R1', 'Add/Update recods', 'http://localhost:8000/api/setup/ward', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (155, '2022-10-07 20:16:11', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardsController@store', 'POST', '{\"data\":{\"sysid\":2,\"ward_code\":\"R2\",\"ward_name\":\"Ruang Perawatan Zircon\",\"sort_name\":\"ZIRCON\",\"is_executive\":false,\"wh_medical\":2,\"wh_general\":4,\"wh_pharmacy\":16,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"GFRI01 - Farmasi Rawat Inap\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\",\"inpatient_service\":\"INSTD - PELAYANAN STANDAR\",\"dept_sysid\":19},\"operation\":\"updated\"}', 2, 'R2', 'Add/Update recods', 'http://localhost:8000/api/setup/ward', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (156, '2022-10-07 21:16:43', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardRoomsController@store', 'POST', '{\"data\":{\"sysid\":-1,\"ward_sysid\":1,\"room_number\":\"301\",\"capacity\":3,\"is_temporary\":false,\"room_class_sysid\":8,\"service_class_sysid\":8,\"is_active\":true},\"operation\":\"inserted\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/rooms', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (157, '2022-10-07 21:22:43', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardRoomsController@store', 'POST', '{\"data\":{\"sysid\":-1,\"ward_sysid\":1,\"room_number\":\"302\",\"capacity\":1,\"is_temporary\":false,\"room_class_sysid\":11,\"service_class_sysid\":11,\"is_active\":true},\"operation\":\"inserted\"}', 2, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/rooms', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (158, '2022-10-07 21:37:28', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardRoomsController@store', 'POST', '{\"data\":{\"sysid\":1,\"ward_sysid\":1,\"room_number\":\"301\",\"capacity\":3,\"occupations\":null,\"room_class_sysid\":8,\"service_class_sysid\":8,\"descriptions\":\"Kelas 2\",\"sort_name\":\"II\",\"class_service\":\"Kelas 2\",\"is_temporary\":false},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/rooms', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (159, '2022-10-19 15:24:45', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicSpecialistController@store', 'POST', '{\"data\":{\"sysid\":-1,\"specialist_name\":\"Spesialis Penyakit Dalam\",\"is_active\":true},\"operation\":\"inserted\"}', 8, '', 'Add/Update recods', 'http://localhost:8000/api/setup/specialist', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (160, '2022-10-19 15:27:45', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicSpecialistController@destroy', 'DELETE', '{\"sysid\":8}', 8, NULL, 'Deleting recods', 'http://localhost:8000/api/setup/specialist', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (161, '2022-10-19 16:20:14', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":-1,\"loc_code\":\"DP01\",\"location_name\":\"Gudang Gizi\",\"is_sales\":false,\"is_distribution\":false,\"is_received\":true,\"warehouse_group\":\"NUTRITION\",\"is_active\":true},\"operation\":\"inserted\"}', 17, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (162, '2022-10-24 23:08:50', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"TABLET\",\"descriptions\":\"Satuan obat dalam tablet\",\"is_active\":true},\"operation\":\"inserted\"}', 1, 'TABLET', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (163, '2022-10-24 23:11:01', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":1,\"mou_name\":\"TABLET\",\"descriptions\":\"Satuan obat dalam bentuk tablet\",\"is_active\":true},\"operation\":\"updated\"}', 1, 'TABLET', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (164, '2022-10-24 23:11:21', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"KAPSUL\",\"descriptions\":\"Satuan obat dalam bentuk kapsul\",\"is_active\":true},\"operation\":\"inserted\"}', 2, 'KAPSUL', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (165, '2022-10-24 23:12:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"KAPLET\",\"descriptions\":\"Satuan obat dalam bentuk kaplet\",\"is_active\":true},\"operation\":\"inserted\"}', 3, 'KAPLET', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (166, '2022-10-24 23:12:18', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"BOTOL\",\"descriptions\":\"Satuan obat\\/sirup dalam bentuk Botol\",\"is_active\":true},\"operation\":\"inserted\"}', 4, 'BOTOL', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (167, '2022-10-24 23:12:39', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"mg\",\"descriptions\":\"Satuan berat dalam Miligram\",\"is_active\":true},\"operation\":\"inserted\"}', 5, 'mg', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (168, '2022-10-24 23:12:59', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"gr\",\"descriptions\":\"Satuan berat dalam gram\",\"is_active\":true},\"operation\":\"inserted\"}', 6, 'gr', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (169, '2022-10-24 23:13:18', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"ml\",\"descriptions\":\"Satuan obat dalam mililiter\",\"is_active\":true},\"operation\":\"inserted\"}', 7, 'ml', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (170, '2022-10-24 23:13:27', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":1,\"mou_name\":\"Tablet\",\"descriptions\":\"Satuan obat dalam bentuk tablet\",\"is_active\":true},\"operation\":\"updated\"}', 1, 'Tablet', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (171, '2022-10-24 23:13:33', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":2,\"mou_name\":\"Kapsul\",\"descriptions\":\"Satuan obat dalam bentuk kapsul\",\"is_active\":true},\"operation\":\"updated\"}', 2, 'Kapsul', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (172, '2022-10-24 23:13:41', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":3,\"mou_name\":\"Kaplet\",\"descriptions\":\"Satuan obat dalam bentuk kaplet\",\"is_active\":true},\"operation\":\"updated\"}', 3, 'Kaplet', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (173, '2022-10-24 23:13:50', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":4,\"mou_name\":\"Botol\",\"descriptions\":\"Satuan obat\\/sirup dalam bentuk Botol\",\"is_active\":true},\"operation\":\"updated\"}', 4, 'Botol', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (174, '2022-10-24 23:14:02', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"Bungkus\",\"descriptions\":\"-\",\"is_active\":true},\"operation\":\"inserted\"}', 8, 'Bungkus', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (175, '2022-10-24 23:14:35', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"Kg\",\"descriptions\":\"Satuan belat dalam Kilogram\",\"is_active\":true},\"operation\":\"inserted\"}', 9, 'Kg', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (176, '2022-10-24 23:15:05', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"Ltr\",\"descriptions\":\"Satuan volume (Liter)\",\"is_active\":true},\"operation\":\"inserted\"}', 10, 'Ltr', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (177, '2022-10-24 23:16:12', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"Dus\",\"descriptions\":\"Satuan dalam unit Dus\",\"is_active\":true},\"operation\":\"inserted\"}', 11, 'Dus', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (178, '2022-10-24 23:16:57', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@destroy', 'DELETE', '{\"sysid\":8}', 8, NULL, 'Deleting recods Bungkus', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (179, '2022-10-25 08:56:07', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"GRP001\",\"group_name\":\"OBAT-OBATAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"inventory_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 1, NULL, 'Add/Update recods [ GRP001-OBAT-OBATAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (180, '2022-10-25 08:57:17', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"GRP002\",\"group_name\":\"ALAT-ALAT KESEHATAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"inventory_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 2, NULL, 'Add/Update recods [ GRP002-ALAT-ALAT KESEHATAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (181, '2022-10-25 09:00:03', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"GRP003\",\"group_name\":\"ALAT & REAGENSIA LABORATORIUM\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"inventory_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 3, NULL, 'Add/Update recods [ GRP003-ALAT & REAGENSIA LABORATORIUM ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (182, '2022-10-25 09:00:15', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"GRP004\",\"group_name\":\"BAHAN RADIOLOGI\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"inventory_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 4, NULL, 'Add/Update recods [ GRP004-BAHAN RADIOLOGI ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (183, '2022-10-25 09:00:48', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"GRU001\",\"group_name\":\"ALAT TULIS & KANTOR\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"inventory_group\":\"GENERAL\",\"is_active\":true},\"operation\":\"inserted\"}', 5, NULL, 'Add/Update recods [ GRU001-ALAT TULIS & KANTOR ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (184, '2022-10-25 09:00:59', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":1,\"group_code\":\"GRM001\",\"group_name\":\"OBAT-OBATAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods [ GRM001-OBAT-OBATAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (185, '2022-10-25 09:01:05', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":2,\"group_code\":\"GRM002\",\"group_name\":\"ALAT-ALAT KESEHATAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 2, NULL, 'Add/Update recods [ GRM002-ALAT-ALAT KESEHATAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (186, '2022-10-25 09:01:11', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":3,\"group_code\":\"GRM003\",\"group_name\":\"ALAT & REAGENSIA LABORATORIUM\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods [ GRM003-ALAT & REAGENSIA LABORATORIUM ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (187, '2022-10-25 09:01:18', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":4,\"group_code\":\"GRM004\",\"group_name\":\"BAHAN RADIOLOGI\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 4, NULL, 'Add/Update recods [ GRM004-BAHAN RADIOLOGI ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (188, '2022-10-25 09:01:54', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"GRD001\",\"group_name\":\"MAKANAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"inventory_group\":\"NUTRITION\",\"is_active\":true},\"operation\":\"inserted\"}', 6, NULL, 'Add/Update recods [ GRD001-MAKANAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (189, '2022-10-25 09:02:11', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"GRD002\",\"group_name\":\"MINUMAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"inventory_group\":\"NUTRITION\",\"is_active\":true},\"operation\":\"inserted\"}', 7, NULL, 'Add/Update recods [ GRD002-MINUMAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (190, '2022-10-25 09:02:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":-1,\"group_code\":\"GRD003\",\"group_name\":\"BAHAN BAKU DAPUR\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"inventory_group\":\"NUTRITION\",\"is_active\":true},\"operation\":\"inserted\"}', 8, NULL, 'Add/Update recods [ GRD003-BAHAN BAKU DAPUR ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (191, '2022-10-25 10:50:09', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":4,\"group_code\":\"GRM004\",\"group_name\":\"BAHAN RADIOLOGI\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 4, NULL, 'Add/Update recods [ GRM004-BAHAN RADIOLOGI ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (192, '2022-10-25 10:50:13', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":2,\"group_code\":\"GRM002\",\"group_name\":\"ALAT-ALAT KESEHATAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 2, NULL, 'Add/Update recods [ GRM002-ALAT-ALAT KESEHATAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (193, '2022-10-25 10:50:17', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":1,\"group_code\":\"GRM001\",\"group_name\":\"OBAT-OBATAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods [ GRM001-OBAT-OBATAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (194, '2022-10-25 10:51:25', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":2,\"group_code\":\"GRM002\",\"group_name\":\"ALAT-ALAT KESEHATAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 2, NULL, 'Add/Update recods [ GRM002-ALAT-ALAT KESEHATAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (195, '2022-10-25 10:53:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":4,\"group_code\":\"GRM004\",\"group_name\":\"BAHAN FILM & CAIRAN RADIOLOGI\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"cost_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 4, NULL, 'Add/Update recods [ GRM004-BAHAN FILM & CAIRAN RADIOLOGI ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (196, '2022-10-25 16:56:46', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":-1,\"mou_name\":\"Box\",\"descriptions\":\"Satuan dalam Box\",\"is_active\":true},\"operation\":\"inserted\"}', 12, 'Box', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (197, '2022-10-25 16:58:02', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":12,\"mou_name\":\"Box\",\"descriptions\":\"Satuan dalam Box\",\"is_active\":true},\"operation\":\"updated\"}', 12, 'Box', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (198, '2022-10-25 23:07:43', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":1,\"loc_code\":\"GFRJ01\",\"location_name\":\"Farmasi Rawat Jalan\",\"inventory_account\":null,\"cogs_account\":null,\"expense_account\":null,\"variant_account\":null,\"warehouse_type\":null,\"is_received\":false,\"is_sales\":true,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (199, '2022-10-26 09:41:56', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":-1,\"item_code\":\"PA00210\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"item_group_sysid\":-1,\"group_name\":\"\",\"manufactur_sysid\":-1,\"manufactur\":\"\",\"prefered_vendor_sysid\":-1,\"supplier\":\"\",\"is_price_rounded\":false,\"price_rounded\":0,\"is_sales\":false,\"is_purchase\":false,\"is_production\":false,\"is_material\":false,\"is_consigment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_national\":false,\"is_bpjs\":false,\"is_expired_control\":false,\"is_generic\":false,\"trademark\":\"\",\"generic_name\":\"\",\"rate\":null,\"units\":\"\",\"forms\":\"\",\"medical_uses\":\"\",\"special_instruction\":\"\",\"storahe_instruction\":\"\",\"inventory_group\":\"MEDICAL\",\"is_active\":true},\"operation\":\"inserted\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (200, '2022-10-26 10:17:29', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\ManufacturController@store', 'POST', '{\"data\":{\"sysid\":-1,\"manufactur_code\":\"SANBE01\",\"manufactur_name\":\"PT Sanbe Farma\",\"is_active\":true},\"operation\":\"inserted\"}', 1, 'PT Sanbe Farma', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/manufactur', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (201, '2022-10-26 10:18:12', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\ManufacturController@store', 'POST', '{\"data\":{\"sysid\":-1,\"manufactur_code\":\"KIMIA01\",\"manufactur_name\":\"PT. Kimia Farma\",\"is_active\":true},\"operation\":\"inserted\"}', 2, 'PT. Kimia Farma', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/manufactur', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (202, '2022-10-26 11:04:55', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":false,\"is_sales\":false,\"is_purchase\":false,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":null,\"trademark\":-1,\"manufactur_sysid\":-1,\"prefered_vendor_sysid\":-1,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T02:41:56.000000Z\",\"manufactur\":null,\"inventory_group\":\"MEDICAL\",\"is_generic\":false},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (203, '2022-10-26 11:05:03', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":true,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":null,\"trademark\":-1,\"manufactur_sysid\":-1,\"prefered_vendor_sysid\":-1,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T02:41:56.000000Z\",\"manufactur\":null,\"inventory_group\":\"MEDICAL\",\"is_generic\":false},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (204, '2022-10-26 11:05:17', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":true,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":null,\"trademark\":-1,\"manufactur_sysid\":2,\"prefered_vendor_sysid\":-1,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T04:05:03.000000Z\",\"manufactur\":\"PT. Kimia Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (205, '2022-10-26 14:24:17', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\SupplierController@store', 'POST', '{\"data\":{\"sysid\":-1,\"supplier_code\":\"P001\",\"supplier_name\":\"PT. Anugrah Pharmindo Lestari\",\"address\":\"Jakarta\",\"phone1\":\"0813\",\"phone2\":\"0812\",\"fax\":\"021\",\"email\":\"cs@parmindo.com\",\"contact_person\":\"\",\"contact_phone\":\"0813108\",\"contact_email\":\"bluem@gmail.com\",\"bank_name\":\"Bank BCA\",\"bank_account_name\":\"Ade\",\"bank_account_number\":\"241817182\",\"lead_time\":1,\"is_active\":true,\"contact_nme\":\"Ade\"},\"operation\":\"inserted\"}', 4, 'P001', 'Add/Update recods PT. Anugrah Pharmindo Lestari', 'http://localhost:8000/api/master/inventory/supplier', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (206, '2022-10-26 14:28:23', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\SupplierController@store', 'POST', '{\"data\":{\"sysid\":4,\"supplier_code\":\"P001\",\"supplier_name\":\"PT. Anugrah Pharmindo Lestari\",\"address\":\"Jakarta\",\"phone1\":\"0813\",\"phone2\":\"0812\",\"fax\":\"021\",\"email\":\"cs@parmindo.com\",\"contact_person\":\"Ade Doank\",\"contact_email\":\"bluem@gmail.com\",\"contact_phone\":\"0813108\",\"bank_name\":\"Bank BCA\",\"bank_account_name\":\"Ade\",\"bank_account_number\":\"241817182\",\"lead_time\":1,\"is_active\":true},\"operation\":\"updated\"}', 4, 'P001', 'Add/Update recods PT. Anugrah Pharmindo Lestari', 'http://localhost:8000/api/master/inventory/supplier', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (207, '2022-10-26 14:29:48', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\SupplierController@store', 'POST', '{\"data\":{\"sysid\":4,\"supplier_code\":\"P001\",\"supplier_name\":\"PT. Anugrah Pharmindo Lestari\",\"address\":\"Jakarta\",\"phone1\":\"0813\",\"phone2\":\"0812\",\"fax\":\"021\",\"email\":\"cs@parmindo.com\",\"contact_person\":\"Ade Doank\",\"contact_email\":\"bluem@gmail.com\",\"contact_phone\":\"0813108\",\"bank_name\":\"Bank BCA\",\"bank_account_name\":\"Ade\",\"bank_account_number\":\"241817182\",\"lead_time\":1,\"is_active\":true},\"operation\":\"updated\"}', 4, 'P001', 'Add/Update recods PT. Anugrah Pharmindo Lestari', 'http://localhost:8000/api/master/inventory/supplier', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (208, '2022-10-26 14:32:01', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\SupplierController@store', 'POST', '{\"data\":{\"sysid\":4,\"supplier_code\":\"P001\",\"supplier_name\":\"PT. Anugrah Pharmindo Lestari\",\"address\":\"Jakarta\",\"phone1\":\"0813\",\"phone2\":\"0812\",\"fax\":\"021\",\"email\":\"cs@parmindo.com\",\"contact_person\":\"Ade Doank\",\"contact_email\":\"bluem@gmail.com\",\"contact_phone\":\"0813108\",\"bank_name\":\"Bank BCA\",\"bank_account_name\":\"Ade\",\"bank_account_number\":\"241817182\",\"lead_time\":1,\"is_active\":true},\"operation\":\"updated\"}', 4, 'P001', 'Add/Update recods PT. Anugrah Pharmindo Lestari', 'http://localhost:8000/api/master/inventory/supplier', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (209, '2022-10-26 14:47:36', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":true,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":null,\"trademark\":-1,\"manufactur_sysid\":2,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T04:05:17.000000Z\",\"manufactur\":\"PT. Kimia Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\"},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (210, '2022-10-26 15:16:12', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":true,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":null,\"trademark\":-1,\"manufactur_sysid\":2,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T07:47:36.000000Z\",\"manufactur\":\"PT. Kimia Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":8500,\"hna\":4000,\"cogs\":3000,\"on_hand\":0,\"on_hand_unit\":0},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (211, '2022-10-26 15:24:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":-1,\"item_code\":\"PA00101\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"item_group_sysid\":-1,\"group_name\":\"\",\"manufactur_sysid\":1,\"manufactur\":\"PT Sanbe Farma\",\"prefered_vendor_sysid\":4,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"is_price_rounded\":false,\"price_rounded\":0,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_national\":false,\"is_bpjs\":false,\"is_expired_control\":false,\"is_generic\":false,\"trademark\":\"\",\"generic_name\":\"\",\"rate\":\"60\",\"units\":\"ml\",\"forms\":\"\",\"medical_uses\":\"Obat Batuk\",\"special_instruction\":\"\",\"storahe_instruction\":\"\",\"inventory_group\":\"MEDICAL\",\"is_active\":true,\"het_price\":0,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"storage_instruction\":\"Simpan suhu ruang\"},\"operation\":\"inserted\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (212, '2022-10-26 15:25:53', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":false,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":null,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T08:24:22.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":0,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (213, '2022-10-26 15:27:20', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":1,\"group_code\":\"GRM001\",\"group_name\":\"OBAT-OBATAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"expense_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods [ GRM001-OBAT-OBATAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (214, '2022-10-26 15:27:27', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":4,\"group_code\":\"GRM004\",\"group_name\":\"BAHAN FILM & CAIRAN RADIOLOGI\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"expense_account\":\"\",\"variant_account\":\"\",\"is_active\":true},\"operation\":\"updated\"}', 4, NULL, 'Add/Update recods [ GRM004-BAHAN FILM & CAIRAN RADIOLOGI ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (215, '2022-10-26 16:00:38', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":false,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T08:24:22.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":0,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"group_name\":\"OBAT-OBATAN\"},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (216, '2022-10-26 16:00:49', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":false,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T08:24:22.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":0,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"group_name\":\"OBAT-OBATAN\"},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (217, '2022-10-26 16:09:08', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":false,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T08:24:22.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":0,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (218, '2022-10-26 16:09:17', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":true,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":3,\"trademark\":-1,\"manufactur_sysid\":2,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T07:47:36.000000Z\",\"manufactur\":\"PT. Kimia Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":4500,\"hna\":4000,\"cogs\":3000,\"on_hand\":100,\"on_hand_unit\":20,\"item_subgroup_sysid\":-1,\"group_name\":\"ALAT & REAGENSIA LABORATORIUM\",\"subgroup_name\":null},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (219, '2022-10-26 16:11:38', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":true,\"price_rounded\":100,\"is_expired_control\":false,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T09:09:08.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":0,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (220, '2022-10-26 16:11:50', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":true,\"price_rounded\":100,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":true,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T09:11:38.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":0,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null},\"operation\":\"updated\"}', 3, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (221, '2022-10-26 16:38:58', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":true,\"price_rounded\":100,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":true,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T09:11:50.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":0,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null,\"generic_name\":\"\",\"rate\":\"0\",\"units\":\"\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"\",\"medical_uses\":\"\"},\"operation\":\"updated\"}', 3, 'PA00101', 'Add/Update recods [PA00101-]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (222, '2022-10-26 16:41:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":true,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":3,\"trademark\":-1,\"manufactur_sysid\":2,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T09:09:17.000000Z\",\"manufactur\":\"PT. Kimia Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":4500,\"hna\":4000,\"cogs\":3000,\"on_hand\":100,\"on_hand_unit\":20,\"item_subgroup_sysid\":-1,\"group_name\":\"ALAT & REAGENSIA LABORATORIUM\",\"subgroup_name\":null,\"generic_name\":\"Panadol\",\"rate\":\"65\",\"units\":\"ml\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"Simpan dalam suhu ruang\",\"medical_uses\":\"Obat batuk\"},\"operation\":\"updated\"}', 1, 'PA00210', 'Add/Update recods [PA00210-Panadol Syrup 65 ml]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (223, '2022-10-26 16:41:12', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":true,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":3,\"trademark\":-1,\"manufactur_sysid\":2,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T09:09:17.000000Z\",\"manufactur\":\"PT. Kimia Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":true,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":4500,\"hna\":4000,\"cogs\":3000,\"on_hand\":100,\"on_hand_unit\":20,\"item_subgroup_sysid\":-1,\"group_name\":\"ALAT & REAGENSIA LABORATORIUM\",\"subgroup_name\":null,\"generic_name\":\"Panadol\",\"rate\":\"65.00\",\"units\":\"ml\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"Simpan dalam suhu ruang\",\"medical_uses\":\"Obat batuk\"},\"operation\":\"updated\"}', 1, 'PA00210', 'Add/Update recods [PA00210-Panadol Syrup 65 ml]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (224, '2022-10-26 16:41:56', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":true,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":3,\"trademark\":-1,\"manufactur_sysid\":2,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T09:41:12.000000Z\",\"manufactur\":\"PT. Kimia Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":true,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":4500,\"hna\":4000,\"cogs\":3000,\"on_hand\":100,\"on_hand_unit\":20,\"item_subgroup_sysid\":-1,\"group_name\":\"ALAT & REAGENSIA LABORATORIUM\",\"subgroup_name\":null,\"generic_name\":\"Panadol\",\"rate\":\"65.00\",\"units\":\"ml\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"Simpan dalam suhu ruang\",\"medical_uses\":\"Obat batuk\"},\"operation\":\"updated\"}', 1, 'PA00210', 'Add/Update recods [PA00210-Panadol Syrup 65 ml]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (225, '2022-10-26 16:42:13', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":true,\"price_rounded\":100,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":true,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T09:11:50.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":65000,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null,\"generic_name\":\"\",\"rate\":\"0.00\",\"units\":\"\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"\",\"medical_uses\":\"\"},\"operation\":\"updated\"}', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (226, '2022-10-26 16:43:06', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":true,\"price_rounded\":100,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":true,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T09:11:50.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":65000,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null,\"generic_name\":\"\",\"rate\":\"0.00\",\"units\":\"\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"\",\"medical_uses\":\"\"},\"operation\":\"updated\"}', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (227, '2022-10-27 14:22:48', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":true,\"price_rounded\":100,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":true,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T09:43:06.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":65000,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null,\"generic_name\":\"\",\"rate\":\"0.00\",\"units\":\"\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"\",\"medical_uses\":\"\"},\"operation\":\"updated\"}', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (228, '2022-10-27 14:22:53', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":1,\"item_code\":\"PA00210\",\"item_code_old\":\"\",\"item_name1\":\"Panadol Syrup 65 ml\",\"item_name2\":\"Panadol Syrup\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":false,\"price_rounded\":0,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":true,\"is_bpjs\":false,\"is_national\":false,\"item_group_sysid\":3,\"trademark\":-1,\"manufactur_sysid\":2,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T02:41:56.000000Z\",\"update_date\":\"2022-10-26T09:41:12.000000Z\",\"manufactur\":\"PT. Kimia Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":true,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":4500,\"hna\":4000,\"cogs\":3000,\"on_hand\":100,\"on_hand_unit\":20,\"item_subgroup_sysid\":-1,\"group_name\":\"ALAT & REAGENSIA LABORATORIUM\",\"subgroup_name\":null,\"generic_name\":\"Panadol\",\"rate\":\"65.00\",\"units\":\"ml\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"Simpan dalam suhu ruang\",\"medical_uses\":\"Obat batuk\"},\"operation\":\"updated\"}', 1, 'PA00210', 'Add/Update recods [PA00210-Panadol Syrup 65 ml]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (229, '2022-10-27 14:44:40', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":true,\"price_rounded\":100,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":true,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T09:43:06.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":65000,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null,\"generic_name\":\"\",\"rate\":\"0.00\",\"units\":\"\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"\",\"medical_uses\":\"\"},\"operation\":\"updated\"}', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (230, '2022-10-27 14:44:50', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":true,\"price_rounded\":100,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":true,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T09:43:06.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":65000,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null,\"generic_name\":\"\",\"rate\":\"0.00\",\"units\":\"\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"\",\"medical_uses\":\"\"},\"operation\":\"updated\"}', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (231, '2022-10-27 14:45:58', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '{\"data\":{\"sysid\":3,\"item_code\":\"PA00101\",\"item_code_old\":\"\",\"item_name1\":\"COMBANTRIN\",\"item_name2\":\"COMBANTRIN\",\"mou_inventory\":\"Botol\",\"product_line\":-1,\"is_price_rounded\":true,\"price_rounded\":100,\"is_expired_control\":true,\"is_sales\":true,\"is_purchase\":true,\"is_production\":false,\"is_material\":false,\"is_consignment\":false,\"is_formularium\":false,\"is_employee\":false,\"is_inhealth\":false,\"is_bpjs\":false,\"is_national\":true,\"item_group_sysid\":1,\"trademark\":-1,\"manufactur_sysid\":1,\"prefered_vendor_sysid\":4,\"is_active\":true,\"update_userid\":\"demo@gmail.com\",\"create_date\":\"2022-10-26T08:24:22.000000Z\",\"update_date\":\"2022-10-26T09:43:06.000000Z\",\"manufactur\":\"PT Sanbe Farma\",\"inventory_group\":\"MEDICAL\",\"is_generic\":false,\"supplier\":\"PT. Anugrah Pharmindo Lestari\",\"het_price\":65000,\"hna\":0,\"cogs\":0,\"on_hand\":0,\"on_hand_unit\":0,\"item_subgroup_sysid\":-1,\"group_name\":\"OBAT-OBATAN\",\"subgroup_name\":null,\"generic_name\":\"\",\"rate\":\"0.00\",\"units\":\"\",\"forms\":\"\",\"special_instruction\":\"\",\"storage_instruction\":\"\",\"medical_uses\":\"\"},\"operation\":\"updated\"}', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (232, '2022-10-27 14:47:27', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":1,\"loc_code\":\"GFRJ01\",\"location_name\":\"Farmasi Rawat Jalan\",\"inventory_account\":null,\"cogs_account\":null,\"expense_account\":null,\"variant_account\":null,\"warehouse_type\":null,\"is_received\":false,\"is_sales\":true,\"is_distribution\":false,\"is_active\":true},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (233, '2022-10-27 14:54:16', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (234, '2022-10-27 14:54:28', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN  SYRUP]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (235, '2022-10-27 14:59:11', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN  SYRUP]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (236, '2022-10-27 16:07:05', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 1, 'PA00210', 'Add/Update recods [PA00210-Panadol Syrup 65 ml]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (237, '2022-10-27 16:37:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 1, 'PA00210', 'Add/Update recods [PA00210-Panadol Syrup 65 ml]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (238, '2022-10-27 16:57:43', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN  SYRUP]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (239, '2022-10-27 19:36:12', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 4, 'BL001', 'Add/Update recods [BL001-Balpoint  Pilot A.01]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (240, '2022-10-27 19:40:37', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 5, 'BAT001', 'Add/Update recods [BAT001-Baterai Alkaline AA]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (241, '2022-10-27 19:45:07', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 5, 'BAT001', 'Add/Update recods [BAT001-Baterai Alkaline AA]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (242, '2022-10-27 19:54:19', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 6, 'BR0001', 'Add/Update recods [BR0001-Beras Cianjur Rojolele]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (243, '2022-10-27 19:55:18', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 6, 'BR0001', 'Add/Update recods [BR0001-Beras Cianjur Rojolele]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (244, '2022-10-27 19:55:25', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 6, 'BR0001', 'Add/Update recods [BR0001-Beras Cianjur Rojolele]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (245, '2022-10-27 19:58:31', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\SupplierController@store', 'POST', '{\"data\":{\"sysid\":-1,\"supplier_code\":\"SP001\",\"supplier_name\":\"Toko Buku Sumber Bersama\",\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":\"\",\"fax\":\"\",\"email\":\"\",\"contact_person\":\"\",\"contact_phone\":\"\",\"contact_email\":\"\",\"bank_name\":\"\",\"bank_account_name\":\"\",\"bank_account_number\":\"\",\"lead_time\":1,\"is_active\":true},\"operation\":\"inserted\"}', 5, 'SP001', 'Add/Update recods Toko Buku Sumber Bersama', 'http://localhost:8000/api/master/inventory/supplier', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (246, '2023-03-08 09:44:42', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":2,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD(K)\",\"specialist_name\":\"Spesialis Penyakit Dalam\",\"price_group\":5,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"Bank Syariah Indonesia\",\"account_name\":\"Najla Nuranna Azizah\",\"account_number\":\"\",\"is_email_reports\":false,\"is_transfer\":true,\"is_active\":true,\"specialist_sysid\":1,\"dept_sysid\":-1,\"dept_name\":\"-\",\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":null,\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\"}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (247, '2023-03-08 11:21:07', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":3,\"dept_code\":\"KA0001\",\"dept_name\":\"Klinik Anak\",\"sort_name\":\"PEDIATRIC\",\"is_executive\":false,\"wh_medical\":9,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":\"KAN01 - POLI ANAK\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":\"-\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 3, 'KA0001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (248, '2023-03-08 13:45:02', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":2,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD(K)\",\"specialist_name\":\"Spesialis Penyakit Dalam\",\"price_group\":5,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":true,\"is_permanent\":true,\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"Bank Syariah Indonesia\",\"account_name\":\"Najla Nuranna Azizah\",\"account_number\":\"\",\"is_email_reports\":false,\"is_transfer\":true,\"is_active\":true,\"specialist_sysid\":1,\"dept_sysid\":-1,\"dept_name\":\"-\",\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":null,\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\"}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (249, '2023-03-08 14:07:57', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\WardRoomsController@destroy', 'DELETE', '{\"sysid\":2}', 2, NULL, 'Deleting recods', 'http://localhost:8000/api/setup/rooms', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (250, '2023-03-08 14:13:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN  SYRUP]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (251, '2023-03-08 14:13:06', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN  SYRUP]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (252, '2023-05-09 13:07:43', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"is_executive\":true,\"wh_medical\":14,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":true,\"wh_medical_name\":\"KMA01 - POLI MATA\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (253, '2023-05-09 13:08:19', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"is_executive\":true,\"wh_medical\":14,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":true,\"wh_medical_name\":\"KMA01 - POLI MATA\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (254, '2023-05-09 13:08:23', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":8,\"dept_code\":\"KGI001\",\"dept_name\":\"Klinik Gigi\",\"sort_name\":\"GIGI\",\"is_executive\":true,\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":null,\"price_class\":-1,\"is_active\":true,\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":null,\"wh_pharmacy_name\":null},\"operation\":\"updated\"}', 8, 'KGI001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (255, '2023-05-09 13:19:21', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":19,\"dept_code\":\"INSTD\",\"dept_name\":\"PELAYANAN STANDAR\",\"sort_name\":\"STDR\",\"is_executive\":true,\"wh_medical\":2,\"wh_general\":4,\"wh_pharmacy\":16,\"price_class\":-1,\"is_active\":\"t\",\"wh_medical_name\":\"GFRI01 - Farmasi Rawat Inap\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":null,\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\"},\"operation\":\"updated\"}', 19, 'INSTD', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (256, '2023-05-09 13:20:47', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":9,\"dept_code\":\"IGD01\",\"dept_name\":\"Instalasi Gawat Darurat\",\"sort_name\":\"IGD\",\"is_executive\":\"f\",\"wh_medical\":3,\"wh_general\":4,\"wh_pharmacy\":18,\"price_class\":10,\"is_active\":\"t\",\"wh_medical_name\":\"GFIGD0 - Farmasi IGD\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR-IGD - FARMASI IGD\"},\"operation\":\"updated\"}', 9, 'IGD01', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (257, '2023-05-09 13:24:31', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":9,\"dept_code\":\"IGD01\",\"dept_name\":\"Instalasi Gawat Darurat\",\"sort_name\":\"IGD\",\"is_executive\":\"0\",\"wh_medical\":3,\"wh_general\":4,\"wh_pharmacy\":18,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":\"GFIGD0 - Farmasi IGD\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR-IGD - FARMASI IGD\"},\"operation\":\"updated\"}', 9, 'IGD01', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (258, '2023-05-09 13:27:14', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":11,\"dept_code\":\"PJLAB\",\"dept_name\":\"LABORATORIUM\",\"sort_name\":\"LAB\",\"is_executive\":\"0\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":null,\"price_class\":-1,\"is_active\":\"1\",\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":null,\"wh_pharmacy_name\":null},\"operation\":\"updated\"}', 11, 'PJLAB', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (259, '2023-05-09 13:32:35', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":12,\"dept_code\":\"RAD\",\"dept_name\":\"RADIOLOGI\",\"sort_name\":\"RAD\",\"is_executive\":\"0\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":null,\"price_class\":-1,\"is_active\":\"1\",\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":null,\"wh_pharmacy_name\":null},\"operation\":\"updated\"}', 12, 'RAD', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (260, '2023-05-09 13:36:18', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":9,\"dept_code\":\"IGD01\",\"dept_name\":\"Instalasi Gawat Darurat\",\"sort_name\":\"IGD\",\"is_executive\":\"0\",\"wh_medical\":3,\"wh_general\":4,\"wh_pharmacy\":18,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":\"GFIGD0 - Farmasi IGD\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR-IGD - FARMASI IGD\"},\"operation\":\"updated\"}', 9, 'IGD01', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (261, '2023-05-09 13:36:35', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":19,\"dept_code\":\"INSTD\",\"dept_name\":\"PELAYANAN STANDAR\",\"sort_name\":\"STDR\",\"is_executive\":\"1\",\"wh_medical\":2,\"wh_general\":4,\"wh_pharmacy\":16,\"price_class\":-1,\"is_active\":\"1\",\"wh_medical_name\":\"GFRI01 - Farmasi Rawat Inap\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":null,\"wh_pharmacy_name\":\"PHAR02 - FARMASI RAWAT INAP\"},\"operation\":\"updated\"}', 19, 'INSTD', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (262, '2023-05-09 13:52:36', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\PriceLevelController@store', 'POST', '{\"data\":{\"sysid\":1,\"level_code\":\"L1\",\"descriptions\":\"Default\",\"is_active\":\"1\"},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/pricelevel', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (263, '2023-05-09 13:57:05', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\PriceLevelController@store', 'POST', '{\"data\":{\"sysid\":2,\"level_code\":\"L2\",\"descriptions\":\"Level 2\",\"is_active\":\"1\"},\"operation\":\"updated\"}', 2, NULL, 'Add/Update recods', 'http://localhost:8000/api/setup/pricelevel', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (264, '2023-05-09 14:02:37', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":2,\"paramedic_code\":\"ZI001\",\"paramedic_name\":\"dr. Zainal Irkam, SpPD(K)\",\"specialist_name\":\"Spesialis Penyakit Dalam\",\"price_group\":5,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":\"1\",\"is_permanent\":\"1\",\"tax_number\":\"\",\"email\":\"\",\"bank_name\":\"Bank Syariah Indonesia\",\"account_name\":\"Najla Nuranna Azizah\",\"account_number\":\"\",\"is_email_reports\":\"0\",\"is_transfer\":\"1\",\"is_active\":\"1\",\"specialist_sysid\":1,\"dept_sysid\":-1,\"dept_name\":null,\"dob\":null,\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":null,\"handphone1\":\"\",\"handphone2\":\"\",\"email_personal\":\"\"}}', 2, 'ZI001', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (265, '2023-05-09 16:08:47', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicSpecialistController@store', 'POST', '{\"data\":{\"sysid\":4,\"specialist_name\":\"Spesialis Gigi\",\"is_active\":\"1\"},\"operation\":\"updated\"}', 4, '', 'Add/Update recods', 'http://localhost:8000/api/setup/specialist', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (266, '2023-05-10 18:51:37', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":2,\"dept_code\":\"PKA001\",\"dept_name\":\"Klinik Akupuntur\",\"sort_name\":\"ACCUPUNTURE\",\"is_executive\":\"0\",\"wh_medical\":1,\"wh_general\":4,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":\"GFRJ01 - Farmasi Rawat Jalan\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 2, 'PKA001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (267, '2023-05-10 18:52:25', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ServiceClassController@store', 'POST', '{\"data\":{\"sysid\":8,\"price_code\":\"02\",\"descriptions\":\"Kelas 2\",\"sort_name\":\"II\",\"is_base_price\":\"0\",\"is_price_class\":\"1\",\"is_service_class\":\"1\",\"is_pharmacy_class\":\"0\",\"is_bpjs_class\":\"0\",\"factor_inpatient\":100,\"factor_service\":100,\"factor_pharmacy\":100,\"minimum_deposit\":0},\"operation\":\"updated\"}', 8, '02', 'Add/Update recods', 'http://localhost:8000/api/setup/class', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (268, '2023-05-10 18:54:47', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\ParamedicController@store', 'POST', '{\"data\":{\"sysid\":1,\"paramedic_code\":\"AN01\",\"paramedic_name\":\"Dr. Andi Sutanto, SpPD\",\"specialist_name\":\"Spesialis Penyakit Dalam\",\"price_group\":1,\"paramedic_type\":\"DOCTOR\",\"employee_id\":null,\"is_internal\":\"1\",\"is_permanent\":\"1\",\"tax_number\":\"111111\",\"email\":\"bluemetric@gmail.com\",\"bank_name\":\"BCA\",\"account_name\":\"Andi Sutanto\",\"account_number\":\"415201213\",\"is_email_reports\":\"1\",\"is_transfer\":\"1\",\"is_active\":\"1\",\"specialist_sysid\":1,\"dept_sysid\":6,\"dept_name\":\"KBE001 - Klinik Bedah\",\"dob\":\"2022-10-01\",\"address\":\"Jl. Raya Centex Gg Mebel No.31\",\"phone1\":\"-\",\"phone2\":\"-\",\"handphone1\":\"081319777459\",\"handphone2\":\"081818100677\",\"email_personal\":\"ade@rs-royaltaruma.com\"}}', 1, 'AN01', 'Add/Update recods', 'http://localhost:8000/api/setup/paramedic', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (269, '2023-05-10 19:04:51', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":1,\"loc_code\":\"GFRJ01\",\"location_name\":\"Farmasi Rawat Jalan\",\"inventory_account\":null,\"cogs_account\":null,\"expense_account\":null,\"variant_account\":null,\"warehouse_type\":null,\"is_received\":\"0\",\"is_sales\":\"1\",\"is_distribution\":\"1\",\"is_active\":\"1\"},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (270, '2023-05-10 19:05:44', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\WarehouseController@store', 'POST', '{\"data\":{\"sysid\":9,\"loc_code\":\"KAN01\",\"location_name\":\"POLI ANAK\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"expense_account\":\"\",\"variant_account\":\"\",\"warehouse_type\":null,\"is_received\":\"0\",\"is_sales\":\"1\",\"is_distribution\":\"1\",\"is_active\":\"1\"},\"operation\":\"updated\"}', 9, NULL, 'Add/Update recods', 'http://localhost:8000/api/master/inventory/warehouse', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (271, '2023-05-10 19:08:39', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\MOUController@store', 'POST', '{\"data\":{\"sysid\":4,\"mou_name\":\"Botol\",\"descriptions\":\"Satuan obat\\/sirup dalam bentuk Botol\",\"is_active\":\"1\"},\"operation\":\"updated\"}', 4, 'Botol', 'Add/Update recods', 'http://localhost:8000/api/master/inventory/mou', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (272, '2023-05-10 19:12:50', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":1,\"group_code\":\"GRM001\",\"group_name\":\"OBAT-OBATAN\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"expense_account\":\"\",\"variant_account\":\"\",\"is_active\":\"1\"},\"operation\":\"updated\"}', 1, NULL, 'Add/Update recods [ GRM001-OBAT-OBATAN ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (273, '2023-05-10 19:13:05', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryGroupController@store', 'POST', '{\"data\":{\"sysid\":8,\"group_code\":\"GRD003\",\"group_name\":\"BAHAN BAKU DAPUR\",\"inventory_account\":\"\",\"cogs_account\":\"\",\"expense_account\":\"\",\"variant_account\":\"\",\"is_active\":\"1\"},\"operation\":\"updated\"}', 8, NULL, 'Add/Update recods [ GRD003-BAHAN BAKU DAPUR ]', 'http://localhost:8000/api/master/inventory/inventory-group', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (274, '2023-05-10 19:24:23', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 1, 'PA00210', 'Add/Update recods [PA00210-Panadol Syrup 65 ml]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (275, '2023-05-10 19:30:49', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 6, 'BR0001', 'Add/Update recods [BR0001-Beras Cianjur Rojolele]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (276, '2023-05-10 19:32:28', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 1, 'PA00210', 'Add/Update recods [PA00210-Panadol Syrup 65 ml]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (277, '2023-05-10 19:32:32', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN  SYRUP]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (278, '2023-05-10 19:33:02', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 4, 'BL001', 'Add/Update recods [BL001-Balpoint  Pilot A.01]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (279, '2023-05-10 19:33:05', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 5, 'BAT001', 'Add/Update recods [BAT001-Baterai Alkaline AA]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (280, '2023-05-24 12:10:29', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN  SYRUP]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (281, '2023-05-24 12:59:29', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":3,\"dept_code\":\"KA0001\",\"dept_name\":\"Klinik Anak\",\"sort_name\":\"PEDIATRIC\",\"is_executive\":\"0\",\"wh_medical\":9,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":-1,\"is_active\":\"1\",\"wh_medical_name\":\"KAN01 - POLI ANAK\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":null,\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 3, 'KA0001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (282, '2023-05-24 12:59:51', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":3,\"dept_code\":\"KA0001\",\"dept_name\":\"Klinik Anak\",\"sort_name\":\"PEDIATRIC\",\"is_executive\":\"0\",\"wh_medical\":9,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":-1,\"is_active\":\"1\",\"wh_medical_name\":\"KAN01 - POLI ANAK\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":null,\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 3, 'KA0001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (283, '2023-05-24 13:08:54', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":2,\"dept_code\":\"PKA001\",\"dept_name\":\"Klinik Akupuntur\",\"sort_name\":\"ACCUPUNTURE\",\"is_executive\":\"0\",\"wh_medical\":1,\"wh_general\":4,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":\"GFRJ01 - Farmasi Rawat Jalan\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 2, 'PKA001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (284, '2023-05-24 13:08:57', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":1,\"dept_code\":\"KPE001\",\"dept_name\":\"Klinik Penyakit Dalam\",\"sort_name\":\"INTERNIST\",\"is_executive\":\"0\",\"wh_medical\":14,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":\"KMA01 - POLI MATA\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 1, 'KPE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (285, '2023-05-24 13:09:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":4,\"dept_code\":\"KUR001\",\"dept_name\":\"Klinik Urologi\",\"sort_name\":\"UROLOGI\",\"is_executive\":\"0\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":null,\"price_class\":-1,\"is_active\":\"1\",\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":null,\"wh_pharmacy_name\":null},\"operation\":\"updated\"}', 4, 'KUR001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (286, '2023-05-24 13:09:27', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":6,\"dept_code\":\"KBE001\",\"dept_name\":\"Klinik Bedah\",\"sort_name\":\"BEDAH\",\"is_executive\":\"0\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 6, 'KBE001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (287, '2023-05-24 13:09:42', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":4,\"dept_code\":\"KUR001\",\"dept_name\":\"Klinik Urologi\",\"sort_name\":\"UROLOGI\",\"is_executive\":\"0\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 4, 'KUR001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (288, '2023-05-24 13:09:59', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":5,\"dept_code\":\"KSY001\",\"dept_name\":\"Klinik Syaraf\",\"sort_name\":\"SYARAF\",\"is_executive\":\"0\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 5, 'KSY001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (289, '2023-05-24 13:10:11', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":7,\"dept_code\":\"KTH001\",\"dept_name\":\"Klinik THT\",\"sort_name\":\"THT\",\"is_executive\":\"0\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 7, 'KTH001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (290, '2023-05-24 13:10:22', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":8,\"dept_code\":\"KGI001\",\"dept_name\":\"Klinik Gigi\",\"sort_name\":\"GIGI\",\"is_executive\":\"0\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 8, 'KGI001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (291, '2023-05-24 13:10:31', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":3,\"dept_code\":\"KA0001\",\"dept_name\":\"Klinik Anak\",\"sort_name\":\"PEDIATRIC\",\"is_executive\":\"0\",\"wh_medical\":9,\"wh_general\":6,\"wh_pharmacy\":15,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":\"KAN01 - POLI ANAK\",\"wh_general_name\":\"POLITARUMA - POLI TARUMA\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR01 - FARMASI RAWAT JALAN\"},\"operation\":\"updated\"}', 3, 'KA0001', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (292, '2023-05-24 13:10:45', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":9,\"dept_code\":\"IGD01\",\"dept_name\":\"Instalasi Gawat Darurat\",\"sort_name\":\"IGD\",\"is_executive\":\"0\",\"wh_medical\":3,\"wh_general\":4,\"wh_pharmacy\":18,\"price_class\":10,\"is_active\":\"1\",\"wh_medical_name\":\"GFIGD0 - Farmasi IGD\",\"wh_general_name\":\"GU0001 - Gudang Logistik Umum\",\"price_class_name\":\"RJ - Rawat Jalan\",\"wh_pharmacy_name\":\"PHAR-IGD - FARMASI IGD\"},\"operation\":\"updated\"}', 9, 'IGD01', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (293, '2023-05-24 13:11:04', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\DepartmentController@store', 'POST', '{\"data\":{\"sysid\":11,\"dept_code\":\"PJLAB\",\"dept_name\":\"LABORATORIUM\",\"sort_name\":\"LAB\",\"is_executive\":\"0\",\"wh_medical\":null,\"wh_general\":null,\"wh_pharmacy\":null,\"price_class\":-1,\"is_active\":\"1\",\"wh_medical_name\":null,\"wh_general_name\":null,\"price_class_name\":null,\"wh_pharmacy_name\":null},\"operation\":\"updated\"}', 11, 'PJLAB', 'Add/Update recods', 'http://localhost:8000/api/setup/department', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (294, '2023-05-24 13:11:20', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\SupplierController@store', 'POST', '{\"data\":{\"sysid\":5,\"supplier_code\":\"SP001\",\"supplier_name\":\"Toko Buku Sumber Bersama\",\"address\":\"Jakarta\",\"phone1\":\"\",\"phone2\":\"\",\"fax\":\"\",\"email\":\"\",\"contact_person\":\"\",\"contact_email\":\"\",\"contact_phone\":\"\",\"bank_name\":\"\",\"bank_account_name\":\"\",\"bank_account_number\":\"\",\"lead_time\":1,\"is_active\":true},\"operation\":\"updated\"}', 5, 'SP001', 'Add/Update recods Toko Buku Sumber Bersama', 'http://localhost:8000/api/master/inventory/supplier', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (295, '2023-05-24 13:22:46', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\SupplierController@store', 'POST', '{\"data\":{\"sysid\":4,\"supplier_code\":\"P001\",\"supplier_name\":\"PT. Anugrah Pharmindo Lestari\",\"address\":\"Jakarta\",\"phone1\":\"0813\",\"phone2\":\"0812\",\"fax\":\"021\",\"email\":\"cs@parmindo.com\",\"contact_person\":\"Ade Doank\",\"contact_email\":\"bluem@gmail.com\",\"contact_phone\":\"0813108\",\"bank_name\":\"Bank BCA\",\"bank_account_name\":\"Ade\",\"bank_account_number\":\"241817182\",\"lead_time\":1,\"is_active\":true},\"operation\":\"updated\"}', 4, 'P001', 'Add/Update recods PT. Anugrah Pharmindo Lestari', 'http://localhost:8000/api/master/inventory/supplier', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (296, '2023-05-24 13:23:31', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN  SYRUP]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (297, '2023-05-25 16:40:37', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":10,\"standard_code\":\"C002@7\",\"descriptions\":\"Obat-Obatan Rawat Inap\",\"parent_id\":2,\"is_active\":\"1\",\"update_date\":null,\"create_date\":null,\"uuid_rec\":\"C002@7\",\"parent_code\":\"C002\",\"parent_name\":\"Jenis Pemesanan\"},\"operation\":\"updated\"}', 10, 'C002@7', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (298, '2023-05-25 16:42:43', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":8,\"standard_code\":\"C002@5\",\"descriptions\":\"Alat Kesehatan (Radiologi)\",\"parent_id\":2,\"is_active\":\"1\",\"update_date\":null,\"create_date\":null,\"uuid_rec\":\"C002@5\",\"parent_code\":\"C002\",\"parent_name\":\"Jenis Pemesanan\"},\"operation\":\"updated\"}', 8, 'C002@5', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (299, '2023-05-25 16:43:10', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C002@8\",\"descriptions\":\"Alat Kesehatan (Laboratorium)\",\"parent_id\":2,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 11, 'C002@8', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (300, '2023-05-25 16:47:11', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":2,\"standard_code\":\"C001@N\",\"descriptions\":\"Non Rutine\",\"parent_id\":1,\"is_active\":\"1\",\"update_date\":null,\"create_date\":null,\"uuid_rec\":\"C001@N\",\"parent_code\":\"C001\",\"parent_name\":\"Jenis Pembelian\"},\"operation\":\"updated\"}', 2, 'C001@N', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (301, '2023-05-25 16:47:14', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":1,\"standard_code\":\"C001@R\",\"descriptions\":\"Rutine\",\"parent_id\":1,\"is_active\":\"1\",\"update_date\":null,\"create_date\":null,\"uuid_rec\":\"C001@R\",\"parent_code\":\"C001\",\"parent_name\":\"Jenis Pembelian\"},\"operation\":\"updated\"}', 1, 'C001@R', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (302, '2023-05-25 16:47:43', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C001@C\",\"descriptions\":\"Campign\",\"parent_id\":1,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 12, 'C001@C', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (303, '2023-05-26 15:37:00', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C003@0\",\"descriptions\":\"0 hari\",\"parent_id\":3,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 13, 'C003@0', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (304, '2023-05-26 15:37:14', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C003@7\",\"descriptions\":\"7 Hari\",\"parent_id\":3,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 14, 'C003@7', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (305, '2023-05-26 15:37:26', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C002@14\",\"descriptions\":\"14 hari\",\"parent_id\":3,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 15, 'C002@14', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (306, '2023-05-26 15:37:37', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":15,\"standard_code\":\"C003@14\",\"descriptions\":\"14 hari\",\"parent_id\":3,\"is_active\":\"1\",\"update_date\":\"2023-05-26T08:37:26.000000Z\",\"create_date\":\"2023-05-26T08:37:26.000000Z\",\"uuid_rec\":\"bf6cd3d2-f3b1-4048-aaf2-29d9b7f3e690\",\"parent_code\":\"C003\",\"parent_name\":\"Termin Pmbayaran\"},\"operation\":\"updated\"}', 15, 'C003@14', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (307, '2023-05-26 15:37:52', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C003@30\",\"descriptions\":\"30 hari\",\"parent_id\":3,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 16, 'C003@30', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (308, '2023-05-26 15:38:07', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C003@45\",\"descriptions\":\"45 Hari\",\"parent_id\":3,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 17, 'C003@45', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (309, '2023-05-26 15:38:19', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C003@60\",\"descriptions\":\"60 Hari\",\"parent_id\":3,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 18, 'C003@60', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (310, '2023-05-30 16:33:07', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C004@M\",\"descriptions\":\"Barang Medis\",\"parent_id\":4,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 19, 'C004@M', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (311, '2023-05-30 16:33:21', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C004@U\",\"descriptions\":\"Barang Umum\",\"parent_id\":4,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 20, 'C004@U', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (312, '2023-05-30 16:33:34', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C004@G\",\"descriptions\":\"Barang Gizi\",\"parent_id\":4,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 21, 'C004@G', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (313, '2023-05-30 16:33:55', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":-1,\"standard_code\":\"C004@A\",\"descriptions\":\"Aktiva (Asset)\",\"parent_id\":4,\"is_active\":\"1\"},\"operation\":\"inserted\"}', 22, 'C004@A', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (314, '2023-06-06 21:20:31', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 1, 'PA00210', 'Add/Update recods [PA00210-Panadol Syrup 65 ml]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (315, '2023-06-06 21:20:36', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 3, 'PA00101', 'Add/Update recods [PA00101-COMBANTRIN  SYRUP]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (316, '2023-06-06 21:26:38', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 4, 'BL001', 'Add/Update recods [BL001-Balpoint  Pilot A.01]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (317, '2023-06-06 21:26:42', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 5, 'BAT001', 'Add/Update recods [BAT001-Baterai Alkaline AA]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (318, '2023-06-06 21:27:24', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@store', 'POST', '[]', 7, 'TEST', 'Add/Update recods [TEST-Barang Test]', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (319, '2023-06-06 21:29:21', 'demo@gmail.com', '^App\\Http\\Controllers\\Master\\Inventory\\InventoryController@destroy', 'DELETE', '{\"uuidrec\":\"d392e652-91bf-4a8c-bcf9-4b20216377b4\"}', 7, '7', 'Deleting recods TEST-Barang Test', 'http://localhost:8000/api/master/inventory/inventory-item', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (320, '2023-06-06 21:42:14', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":22,\"standard_code\":\"C004@A\",\"descriptions\":\"Aktiva (Asset)\",\"parent_id\":4,\"is_active\":\"1\",\"update_date\":\"2023-05-30T09:33:55.000000Z\",\"create_date\":\"2023-05-30T09:33:55.000000Z\",\"uuid_rec\":\"3a990dc3-dfa7-4e30-ae36-ac75f9d37356\",\"parent_code\":\"C004\",\"parent_name\":\"Group utama item inventory\",\"value\":\"ASSET\"},\"operation\":\"updated\"}', 22, 'C004@A', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (321, '2023-06-06 21:46:33', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":19,\"standard_code\":\"C004@M\",\"descriptions\":\"Barang Medis\",\"parent_id\":4,\"value\":\"MEDICAL\",\"is_active\":\"1\",\"update_date\":\"2023-05-30T09:33:07.000000Z\",\"create_date\":\"2023-05-30T09:33:07.000000Z\",\"uuid_rec\":\"b6ff6250-ed3c-42f8-b4d9-9e16c2255744\",\"parent_code\":\"C004\",\"parent_name\":\"Group utama item inventory\"},\"operation\":\"updated\"}', 19, 'C004@M', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (322, '2023-06-06 21:46:43', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":20,\"standard_code\":\"C004@U\",\"descriptions\":\"Barang Umum\",\"parent_id\":4,\"value\":\"GENERAL\",\"is_active\":\"1\",\"update_date\":\"2023-05-30T09:33:21.000000Z\",\"create_date\":\"2023-05-30T09:33:21.000000Z\",\"uuid_rec\":\"ed42c269-8ffb-4f36-bb38-cebc38537685\",\"parent_code\":\"C004\",\"parent_name\":\"Group utama item inventory\"},\"operation\":\"updated\"}', 20, 'C004@U', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (323, '2023-06-06 21:46:49', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":21,\"standard_code\":\"C004@G\",\"descriptions\":\"Barang Gizi\",\"parent_id\":4,\"value\":\"GIZI\",\"is_active\":\"1\",\"update_date\":\"2023-05-30T09:33:34.000000Z\",\"create_date\":\"2023-05-30T09:33:34.000000Z\",\"uuid_rec\":\"8e877b2c-e6b2-4368-a69e-6a39f007fe5c\",\"parent_code\":\"C004\",\"parent_name\":\"Group utama item inventory\"},\"operation\":\"updated\"}', 21, 'C004@G', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
INSERT INTO `t_user_logs` (`sysid`, `create_date`, `user_name`, `module`, `action`, `data`, `document_sysid`, `document_number`, `descriptions`, `uri_link`, `time_execute`) VALUES (324, '2023-06-06 21:46:54', 'demo@gmail.com', '^App\\Http\\Controllers\\Setup\\GeneralCodeController@store', 'POST', '{\"data\":{\"sysid\":22,\"standard_code\":\"C004@A\",\"descriptions\":\"Aktiva (Asset)\",\"parent_id\":4,\"value\":\"ASSET\",\"is_active\":\"1\",\"update_date\":\"2023-06-06T14:42:14.000000Z\",\"create_date\":\"2023-05-30T09:33:55.000000Z\",\"uuid_rec\":\"4d262eb1-46d7-4d89-bc71-78bf0d27d03f\",\"parent_code\":\"C004\",\"parent_name\":\"Group utama item inventory\"},\"operation\":\"updated\"}', 22, 'C004@A', 'Add/Update recods', 'http://localhost:8000/api/setup/application/standard-code', NULL);
COMMIT;

-- ----------------------------
-- View structure for v_item_product_line
-- ----------------------------
DROP VIEW IF EXISTS `v_item_product_line`;
CREATE ALGORITHM = TEMPTABLE SQL SECURITY DEFINER VIEW `v_item_product_line` AS select `itm`.`item_code` AS `item_code`,`itm`.`item_name1` AS `item_name1` from (`m_items` `itm` left join `m_product_line` `pl` on(`itm`.`product_line` = `pl`.`sysid`));

SET FOREIGN_KEY_CHECKS = 1;
