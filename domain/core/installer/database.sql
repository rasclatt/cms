-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 08, 2021 at 04:12 PM
-- Server version: 10.2.10-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
-- --------------------------------------------------------

--
-- Table structure for table `components`
--

CREATE TABLE `components` (
  `ID` int(11) NOT NULL,
  `unique_id` varchar(100) COLLATE utf8_bin DEFAULT '',
  `ref_page` varchar(255) COLLATE utf8_bin DEFAULT '',
  `parent_id` varchar(100) COLLATE utf8_bin DEFAULT '',
  `ref_anchor` varchar(255) COLLATE utf8_bin DEFAULT '',
  `title` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `category_id` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `component_type` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `file` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT '',
  `file_size` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_path` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_name` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT current_timestamp(),
  `admin_notes` text CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `usergroup` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `group_id` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `cached` varchar(3) COLLATE utf8_bin DEFAULT NULL,
  `page_order` int(10) DEFAULT 1,
  `page_live` varchar(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `components`
--

INSERT INTO `components` (`ID`, `unique_id`, `ref_page`, `parent_id`, `ref_anchor`, `title`, `category_id`, `component_type`, `content`, `file`, `file_size`, `file_path`, `file_name`, `timestamp`, `admin_notes`, `usergroup`, `group_id`, `cached`, `page_order`, `page_live`) VALUES
(1, '20200526040921183475', '', '', '', '200usen', 'translator', 'status_code', 'OK', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(2, '20200526040921178813', '', '', '', '404usen', 'translator', 'status_code', 'Page does not exist', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(3, '20200526040921584919', '', '', '', '403usen', 'translator', 'status_code', 'Permission denied', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(4, '20200526040921988137', '', '', '', '500usen', 'translator', 'status_code', 'An unknown error occurred', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(5, '20200526040921681809', '', '', '', '403_deleteusen', 'translator', 'status_code', 'Permission denied to delete', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(6, '20200526040921736955', '', '', '', 'access_adminusen', 'translator', 'status_code', 'This is only accessable by admin or on the admin page', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(7, '20200526040921689158', '', '', '', 'successusen', 'translator', 'status_code', 'Action was successful', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(8, '20200526040921384215', '', '', '', 'success_sqlusen', 'translator', 'status_code', 'SQL performed successfully', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(9, '20200526040921975311', '', '', '', 'success_loginusen', 'translator', 'status_code', 'You have successfully signed in', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(10, '20200526040921594621', '', '', '', 'success_logoutusen', 'translator', 'status_code', 'You have successfully signed out', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(11, '20200526040921698264', '', '', '', 'success_createusen', 'translator', 'status_code', 'Item created successfully', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(12, '20200526040921914702', '', '', '', 'success_deleteusen', 'translator', 'status_code', 'Item deleted successfully', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(13, '20200526040921866699', '', '', '', 'success_updateusen', 'translator', 'status_code', 'Item updated successfully', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(14, '20200526040921925446', '', '', '', 'success_savedusen', 'translator', 'status_code', 'Successfully saved', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(15, '20200526040921272687', '', '', '', 'success_emailusen', 'translator', 'status_code', 'Email sent successfully', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(16, '20200526040921998452', '', '', '', 'success_thumbremovedusen', 'translator', 'status_code', 'Thumbnail removed', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(17, '20200526040921729288', '', '', '', 'success_uploadusen', 'translator', 'status_code', 'File uploaded successfully', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(18, '20200526040921893312', '', '', '', 'success_cachedeletedusen', 'translator', 'status_code', 'Cache was successfully deleted', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(19, '20200526040921132981', '', '', '', 'success_plugininactiveusen', 'translator', 'status_code', 'Plugin is inactive', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(20, '20200526040921808465', '', '', '', 'success_pluginactiveusen', 'translator', 'status_code', 'Plugin is activated', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(21, '20200526040921571592', '', '', '', 'success_settingssavedusen', 'translator', 'status_code', 'Settings were saved', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(22, '20200526040921401624', '', '', '', 'success_usercreateusen', 'translator', 'status_code', 'User successfully created', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(23, '20200526040921180775', '', '', '', 'success_componentcreateusen', 'translator', 'status_code', 'Component created successfully', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(24, '20200526040921146934', '', '', '', 'fail_savedusen', 'translator', 'status_code', 'Saving was unsuccessful', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(25, '20200526040921164844', '', '', '', 'fail_thumbremovedusen', 'translator', 'status_code', 'Thumbnail failed to be removed.', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(26, '20200526040921183822', '', '', '', 'fail_emailusen', 'translator', 'status_code', 'Email failed to send', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(27, '20200526040921632236', '', '', '', 'failusen', 'translator', 'status_code', 'Action failed', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(28, '20200526040921888910', '', '', '', 'fail_sqlusen', 'translator', 'status_code', 'SQL failed on execution', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(29, '20200526040921546774', '', '', '', 'fail_loginusen', 'translator', 'status_code', 'Invalid Username or Password', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(30, '20200526040921798956', '', '', '', 'fail_logoutusen', 'translator', 'status_code', 'You have unsuccessfully signed out. Try again', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(31, '20200526040921792838', '', '', '', 'fail_createusen', 'translator', 'status_code', 'Item failed to created', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(32, '20200526040921660106', '', '', '', 'fail_deleteusen', 'translator', 'status_code', 'Item failed to delete', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(33, '20200526040921216549', '', '', '', 'fail_updateusen', 'translator', 'status_code', 'Item failed to update', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(34, '20200526040921914811', '', '', '', 'fail_userexistsusen', 'translator', 'status_code', 'User already exists', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(35, '20200526040921858527', '', '', '', 'fail_usercreateusen', 'translator', 'status_code', 'An error occurred trying to create user', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(36, '20200526040921158810', '', '', '', 'fail_uploadusen', 'translator', 'status_code', 'File failed to upload - check file/folder permissions or file size limit', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(37, '20200526040921318239', '', '', '', 'fail_existsusen', 'translator', 'status_code', 'Item does not exist', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(38, '20200526040921497668', '', '', '', 'fail_widgetusen', 'translator', 'status_code', 'Can not activate Widget. Missing widget name.', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(39, '20200526040921429806', '', '', '', 'fail_connectionusen', 'translator', 'status_code', 'Connection failed', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(40, '20200526040921928034', '', '', '', 'requiredusen', 'translator', 'status_code', 'Required fields can not be empty', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(41, '20200526040921538911', '', '', '', 'required_filetypeusen', 'translator', 'status_code', 'File must me valid type', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(42, '20200526040921301834', '', '', '', 'account_disabledusen', 'translator', 'status_code', 'Your account is disabled', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(43, '20200526040921922960', '', '', '', 'account_savedusen', 'translator', 'status_code', 'User account saved', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(44, '20200526040921263692', '', '', '', 'account_savedfailusen', 'translator', 'status_code', 'User account failed to save', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(45, '20200526040921180061', '', '', '', 'cart_addedusen', 'translator', 'status_code', 'Added to cart', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(46, '20200526040921844799', '', '', '', 'cart_failaddedusen', 'translator', 'status_code', 'Product failed to add to cart', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(47, '20200526040921845772', '', '', '', 'cart_nothingusen', 'translator', 'status_code', 'Nothing to add to cart', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(48, '20200526040921692846', '', '', '', 'invalid_tokenusen', 'translator', 'status_code', 'Security token is invalid', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(49, '20200526040921144529', '', '', '', 'invalid_tokenmatchusen', 'translator', 'status_code', 'Security token does not match', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(50, '20200526040921113613', '', '', '', 'invalid_requestusen', 'translator', 'status_code', 'Invalid request', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(51, '20200526040921858339', '', '', '', 'invalid_userusen', 'translator', 'status_code', 'Username or password is invalid', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(52, '20200526040921492410', '', '', '', 'invalid_usernameusen', 'translator', 'status_code', 'Username is invalid', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(53, '20200526040921936286', '', '', '', 'invalid_fileusen', 'translator', 'status_code', 'File is invalid', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(54, '20200526040921954566', '', '', '', 'invalid_downloadusen', 'translator', 'status_code', 'Download is not available', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(55, '20200526040921946343', '', '', '', 'invalid_codeusen', 'translator', 'status_code', 'Code is invalid', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(56, '20200526040921200836', '', '', '', 'invalid_pageusen', 'translator', 'status_code', 'Page does not exist', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(57, '20200526040921600529', '', '', '', 'invalid_slugusen', 'translator', 'status_code', 'The slug is invalid', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(58, '20200526040921383999', '', '', '', 'invalid_slugexistsusen', 'translator', 'status_code', 'The slug already exists', '', NULL, NULL, NULL, '2020-05-26 04:09:21', NULL, NULL, NULL, NULL, 1, 'on'),
(59, '20200526040922175639', '', '', '', 'invalid_componentusen', 'translator', 'status_code', 'Component does not exist', '', NULL, NULL, NULL, '2020-05-26 04:09:22', NULL, NULL, NULL, NULL, 1, 'on'),
(60, '20200526040922730144', '', '', '', 'no_actionusen', 'translator', 'status_code', 'No action was taken', '', NULL, NULL, NULL, '2020-05-26 04:09:22', NULL, NULL, NULL, NULL, 1, 'on'),
(61, '20200526040922987622', '', '', '', 'ajax_invalidusen', 'translator', 'status_code', 'No actions to take, you may have been logged out', '', NULL, NULL, NULL, '2020-05-26 04:09:22', NULL, NULL, NULL, NULL, 1, 'on'),
(62, '20200526040922334637', '', '', '', 'site_comingsoonusen', 'translator', 'status_code', 'Site coming soon', '', NULL, NULL, NULL, '2020-05-26 04:09:22', NULL, NULL, NULL, NULL, 1, 'on'),
(63, '20200526040922369924', '', '', '', 'site_maintenanceusen', 'translator', 'status_code', 'Site is being worked on', '', NULL, NULL, NULL, '2020-05-26 04:09:22', NULL, NULL, NULL, NULL, 1, 'on'),
(72, '20200526135725795096', '20171226130020542864427', '', '', 'Contact Form', 'nbr_layout', 'contact_form', '', '', NULL, '', '', '2021-02-02 00:08:42', '', '0', '', '', 1, 'on'),
(75, '20210130005809718865', '201612021444165841104219', '', '', 'Add To Cart Demo', 'nbr_layout', 'code', '&lt;div class=&quot;margin-top-3 pad-top-2&quot;&gt;\r\n	&lt;button class=&quot;trans-cls addtocart button standard&quot; data-trans=&quot;addtocart&quot; data-itemcode=&quot;1011400&quot; data-quantity=&quot;1&quot;&gt;Add To Cart&lt;/button&gt;\r\n&lt;/div&gt;', '', NULL, '', '', '2021-02-02 22:08:05', '', '0', '', '', 3, 'on'),
(77, '20210131231729607141', '20210131160143431567', '', '', 'Checkout', 'nbr_layout', 'code', '~PLUGIN::widget_storefront[/page/checkout.php]~', '', NULL, '', '', '2021-01-31 23:18:10', '', '0', '', '', 1, 'on'),
(78, '20210201002611804399', '', '', '', 'itemsincart', '', 'transkey', 'Items in Cart', '', NULL, NULL, NULL, '2021-02-01 08:26:11', NULL, NULL, NULL, NULL, 1, 'on'),
(79, '20210201002611894069', '', '', '', 'product-title-1011400', '', 'transkey', 'Widget Express', '', NULL, NULL, NULL, '2021-02-01 08:26:11', NULL, NULL, NULL, NULL, 1, 'on'),
(80, '20210201002611899844', '', '', '', 'subtotal', '', 'transkey', 'Subtotal', '', NULL, NULL, NULL, '2021-02-01 08:26:11', NULL, NULL, NULL, NULL, 1, 'on'),
(81, '20210201002611217997', '', '', '', 'checkout', '', 'transkey', 'CHECKOUT', '', NULL, NULL, NULL, '2021-02-01 08:26:11', NULL, NULL, NULL, NULL, 1, 'on'),
(82, '20210201002611419518', '', '', '', 'clearcart', '', 'transkey', 'CLEAR', '', NULL, NULL, NULL, '2021-02-01 08:26:11', NULL, NULL, NULL, NULL, 1, 'on'),
(90, '20210203224944327907', '', '', '', 'clear', '', 'transkey', 'Clear', '', NULL, NULL, NULL, '2021-02-04 06:49:44', NULL, NULL, NULL, NULL, 1, 'on'),
(91, '20210203224944349794', '', '', '', 'cartsummary', '', 'transkey', 'Cart Summary', '', NULL, NULL, NULL, '2021-02-04 06:49:44', NULL, NULL, NULL, NULL, 1, 'on'),
(92, '20210203224944498203', '', '', '', 'tr-checkout', '', 'transkey', 'CHECKOUT', '', NULL, NULL, NULL, '2021-02-04 06:49:44', NULL, NULL, NULL, NULL, 1, 'on'),
(93, '20210203224945828210', '', '', '', 'shopnow', '', 'transkey', 'SHOP NOW', '', NULL, NULL, NULL, '2021-02-04 06:49:45', NULL, NULL, NULL, NULL, 1, 'on'),
(105, '20210205102519782325', '', '', '', 'addtocart', '', 'transkey', 'Add To Cart', '', NULL, NULL, NULL, '2021-02-05 18:25:19', NULL, NULL, NULL, NULL, 1, 'on'),
(107, '20210205110451114090', '', '', '', 'itemsincartusjp', 'translator', '', 'カート内のアイテム', '', NULL, NULL, NULL, '2021-02-05 19:04:51', NULL, NULL, NULL, NULL, 1, 'on'),
(108, '20210205110451521318', '', '', '', 'product-title-1011400usjp', 'translator', '', 'Widget Express', '', NULL, NULL, NULL, '2021-02-05 19:04:51', NULL, NULL, NULL, NULL, 1, 'on'),
(109, '20210205110451583522', '', '', '', 'subtotalusjp', 'translator', '', '小計', '', NULL, NULL, NULL, '2021-02-05 19:04:51', NULL, NULL, NULL, NULL, 1, 'on'),
(110, '20210205110451752955', '', '', '', 'checkoutusjp', 'translator', '', '仕上がり', '', NULL, NULL, NULL, '2021-02-05 19:04:51', NULL, NULL, NULL, NULL, 1, 'on'),
(111, '20210205110451694274', '', '', '', 'clearcartusjp', 'translator', '', '取り除く', '', NULL, NULL, NULL, '2021-02-05 19:04:51', NULL, NULL, NULL, NULL, 1, 'on'),
(112, '20210205110451544699', '', '', '', 'clearusjp', 'translator', '', '取り除く', '', NULL, NULL, NULL, '2021-02-05 19:04:51', NULL, NULL, NULL, NULL, 1, 'on'),
(113, '20210205110451834873', '', '', '', 'cartsummaryusjp', 'translator', '', '概要', '', NULL, NULL, NULL, '2021-02-05 19:04:51', NULL, NULL, NULL, NULL, 1, 'on'),
(114, '20210205110451859826', '', '', '', 'tr-checkoutusjp', 'translator', '', '支払う', '', NULL, NULL, NULL, '2021-02-05 19:04:51', NULL, NULL, NULL, NULL, 1, 'on'),
(115, '20210205110451504212', '', '', '', 'shopnowusjp', 'translator', '', 'ショップ', '', NULL, NULL, NULL, '2021-02-05 19:04:51', NULL, NULL, NULL, NULL, 1, 'on'),
(116, '20210205115322640679', '', '', '', 'addtocartusjp', 'translator', '', 'カートに追加', '', NULL, NULL, NULL, '2021-02-05 19:53:22', NULL, NULL, NULL, NULL, 1, 'on'),
(121, '20210205132614370127', '', '', '', 'home', '', 'transkey', 'Home', '', NULL, NULL, NULL, '2021-02-05 21:26:14', NULL, NULL, NULL, NULL, 1, 'on'),
(122, '20210205132614783183', '', '', '', 'homeusjp', 'translator', '', 'ホームページ', '', NULL, NULL, NULL, '2021-02-05 21:26:14', NULL, NULL, NULL, NULL, 1, 'on'),
(123, '20210205132614847364', '', '', '', 'contact', '', 'transkey', 'Contact', '', NULL, NULL, NULL, '2021-02-05 21:26:14', NULL, NULL, NULL, NULL, 1, 'on'),
(124, '20210205132614781954', '', '', '', 'contactusjp', 'translator', '', 'お問い合わせ', '', NULL, NULL, NULL, '2021-02-05 21:26:14', NULL, NULL, NULL, NULL, 1, 'on'),
(125, '20210205132614965675', '', '', '', 'myaccount', '', 'transkey', 'My Account', '', NULL, NULL, NULL, '2021-02-05 21:26:14', NULL, NULL, NULL, NULL, 1, 'on'),
(126, '20210205132614677585', '', '', '', 'myaccountusjp', 'translator', '', 'マイアカウント', '', NULL, NULL, NULL, '2021-02-05 21:26:14', NULL, NULL, NULL, NULL, 1, 'on'),
(127, '20210205133158180243', '', '', '', 'signout', '', 'transkey', 'Sign out?', '', NULL, NULL, NULL, '2021-02-05 21:31:58', NULL, NULL, NULL, NULL, 1, 'on'),
(128, '20210205133158154864', '', '', '', 'signoutusjp', 'translator', '', 'サインアウト?', '', NULL, NULL, NULL, '2021-02-05 21:31:58', NULL, NULL, NULL, NULL, 1, 'on'),
(129, '20210205142024212768', '', '', '', 'trans', '', 'transkey', 'Login', '', NULL, NULL, NULL, '2021-02-05 22:20:24', NULL, NULL, NULL, NULL, 1, 'on'),
(130, '20210205142024776001', '', '', '', 'loginusjp', 'translator', '', 'ログイン', '', NULL, NULL, NULL, '2021-02-05 22:20:24', NULL, NULL, NULL, NULL, 1, 'on');

-- --------------------------------------------------------

--
-- Table structure for table `component_locales`
--

CREATE TABLE `component_locales` (
  `ID` int(20) NOT NULL,
  `unique_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `comp_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `locale_abbr` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `page_live` varchar(4) COLLATE utf8_unicode_ci DEFAULT 'off'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dropdown_menus`
--

CREATE TABLE `dropdown_menus` (
  `ID` int(30) NOT NULL,
  `unique_id` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assoc_column` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menuName` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menuVal` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_order` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `restriction` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_live` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dropdown_menus`
--

INSERT INTO `dropdown_menus` (`ID`, `unique_id`, `assoc_column`, `menuName`, `menuVal`, `page_order`, `restriction`, `page_live`) VALUES
(1, '2014072705035210000', 'column_type', 'Text Box', 'text', '', '', 'on'),
(2, '20150109182049800000', 'column_type', 'Radio Buttons', 'radio', '', '', 'on'),
(3, '2014072705041030000', 'column_type', 'Text Area', 'textarea', '', '', 'on'),
(4, '20150109182050100000', 'column_type', 'File', 'file', '', '', 'on'),
(5, '20150109182051900000', 'column_type', 'Password', 'password', '', '', 'on'),
(6, '2015010918205460000', 'column_type', 'Hidden', 'hidden', '', '', 'on'),
(7, '20150109182053600000', 'column_type', 'Drop Down', 'select', '', '', 'on'),
(8, '20150109182057200000', 'column_type', 'Check Box', 'checkbox', '', '', 'on'),
(9, '20150109182057700000', 'component', 'Bypass Header', 'bypass_header', '', '', 'on'),
(10, '20150109182058400000', 'component', 'Bypass Login', 'bypass_login', '', '', 'on'),
(11, '20150109182059900000', 'component_type', 'Image', 'image', '', '', 'on'),
(12, '2015011319131250000', 'component_type', 'Code', 'code', '', '', 'on'),
(13, '20150113191310200000', 'component_type', 'Contact Form', 'contact_form', '', '', 'on'),
(14, '20150113191309700000', 'component_type', 'container', 'div', '', '', 'on'),
(15, '20150113191832200000', 'core_setting', 'User Setting', '0', '', '', 'on'),
(16, '20150113191821700000', 'email_id', 'account', 'account', '', '', 'on'),
(17, '20150113164806300000', 'in_menubar', 'on', 'on', '', '', 'on'),
(18, '2015011319173560000', 'login_permission', 'Super User', '1', '', '0', 'on'),
(19, '20150113191602800000', 'login_permission', 'Admin', '2', '', '0', 'on'),
(20, '2015011217344090000', 'login_permission', 'Web User', '3', '', '0', 'on'),
(21, '20150112173434700000', 'in_menubar', 'off', 'off', '', '', 'on'),
(22, '20150112173432100000', 'login_view', 'off', 'off', '', 'NULL', 'on'),
(23, '2014050714455920000', 'login_view', 'on', 'on', '', '', 'on'),
(24, '20150112161848400000', 'page_live', 'off', '', '', '', 'on'),
(25, '20150112161849400000', 'page_live', 'on', 'on', '', '', 'on'),
(26, '2015011217335070000', 'restriction', 'Admin', '1', '', '', 'on'),
(27, '20150112173352300000', 'restriction', 'Superuser', '0', '', 'NULL', 'on'),
(28, '20150112173347500000', 'restriction', 'Basic', '2', '', '', 'on'),
(29, '2014050714455760000', 'session_status', 'on', 'on', '', '', 'on'),
(30, '20150109182122800000', 'row_type', 'button', 'button', '', '', 'on'),
(31, '2014072420041510000', 'template', 'Default', '/core/template/default/', '', '0', 'on'),
(32, '20150109182120900000', 'session_status', 'off', 'off', '', '', 'on'),
(33, '20150109182107400000', 'usergroup', 'Web User', 'NBR_WEB', '1', '2', 'on'),
(34, '20150109182106500000', 'user_status', 'off', 'off', '', '', 'on'),
(35, '2014050714454930000', 'user_status', 'on', 'on', '', '', 'on'),
(36, '2015011217350550000', 'usergroup', 'Super User', 'NBR_SUPERUSER', '3', '0', 'on'),
(37, '2015011319170830000', 'auto_cache', 'off', 'off', '', 'NULL', 'on'),
(38, '2014050714454510000', 'auto_cache', 'on', 'on', '', '', 'on'),
(39, '2015010918210920000', 'user_access', 'disallow', '0', '', '', 'on'),
(40, '20150112173453900000', 'user_access', 'allow', '1', '', '', 'on'),
(41, '201501121735081000', 'usergroup', 'Admin User', 'NBR_ADMIN', '2', '0', 'on'),
(42, '20150112173147700000', 'activated', 'yes', 'on', '', '', 'on'),
(43, '20150112173144700000', 'activation_stage', 'Process Form', 'process', '', '', 'on'),
(44, '2015011217314340000', 'activated', 'off', '', '', '', 'on'),
(45, '20150112173043200000', 'component', 'Bypass Menu', 'bypass_menu', '', '', 'on'),
(46, '20150112173034700000', 'component', 'Bypass Footer', 'bypass_footer', '', '', 'on'),
(47, '20150112172912600000', 'email_id', 'default', 'default', '', '', 'on'),
(48, '20150112172909800000', 'core_setting', 'System Setting', '1', '', '', 'on'),
(49, '20150112161844200000', 'page_live', 'Off (Explicit)', 'off', '', '', 'on'),
(50, '20150205160323263133', 'is_admin', 'AdminTools', '1', '', 'NULL', 'on'),
(51, '20150205160340553079', 'is_admin', 'Display', '0', '', '0', 'on'),
(52, '201508232215545180558848252', 'is_admin', 'Home', '2', '', '', 'on'),
(53, '201810301012013521452', 'usergroup', 'Select', NULL, '0', NULL, 'on'),
(54, '2018103010245612345', 'component_type', 'Login Form', 'login', NULL, NULL, 'on'),
(55, '2018103119131250000', 'component_type', 'Select', '', '', '1', 'on'),
(56, '20210131151634652212', 'page_type', 'Admin', 'admin', '10', '2', 'on'),
(57, '20210131151748938321', 'page_type', 'Contact', 'contact', '9', '2', 'on'),
(58, '20210131151846635012', 'page_type', 'Normal', 'page', '1', '2', 'on'),
(59, '20210131151946665729', 'page_type', 'Login', 'login', '8', '2', 'on'),
(60, '20210131152002168285', 'page_type', 'Account', 'account', '7', '2', 'on'),
(61, '20210131160056311515', 'page_type', 'Checkout', 'checkout', '3', '2', 'on'),
(62, '20210131161034595727', 'template', 'Nubersoft 2020', '/core/template/nubersoft2020/', '1', '2', 'on'),
(63, '20210201084852887605', 'page_type', 'Translation Tool', 'transtool', '11', '1', 'on'),
(64, NULL, 'page_type', 'Home Page', 'home', '14', NULL, 'on');

-- --------------------------------------------------------

--
-- Table structure for table `emailer`
--

CREATE TABLE `emailer` (
  `ID` int(20) NOT NULL,
  `unique_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `content_back` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `return_copy` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `return_address` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `return_response` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `email_id` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `page_live` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `emailer`
--

INSERT INTO `emailer` (`ID`, `unique_id`, `content`, `content_back`, `return_copy`, `return_address`, `return_response`, `email_id`, `page_live`) VALUES
(1, '2013091712383917660', '&lt;html&gt;\n&lt;title&gt;Online Submission Form&lt;/title&gt;\n&lt;head&gt;\n&lt;link rel=&quot;stylesheet&quot; href=&quot;http://~SERVER::[HTTP_HOST]~/css/contrabrand.css&quot; type=&quot;text/css&quot; /&gt;\n&lt;link rel=&quot;stylesheet&quot; href=&quot;http://~SERVER::[HTTP_HOST]~/css/default.css&quot; type=&quot;text/css&quot; /&gt;\n&lt;style&gt;\nbody {\n	background-color: #EBEBEB;\n}\n#wrapper {\n	width:800px;\n	margin: 3% auto 60px auto;\n}\n.head_container	{\n	background-image: url(http://~SERVER::[HTTP_HOST]~/core.processor/images/email/background.jpg);\n	background-repeat: no-repeat;\n	display: block;\n	width: 780px;\n	height: 136px;\n	padding: 10px;\n	border-top-left-radius: 6px;\n	border-top-right-radius: 6px;\n}\n.l-hand-size	{\n	width: 380px;\n	display: inline-block;\n	float: left;\n	clear: none;\n}\np.header-h1	{\n	display: inline-block;\n	color: #FFFFFF;\n	text-shadow: 2px 2px 2px #333333;\n	font-size: 35px;\n	float: left;\n	clear: none;\n	margin: 0;\n	padding: 10px;\n}\na.login-button:link,\na.login-button:visited	{\n	display: inline-block;\n	float: left;\n	clear: left;\n	margin: 10;\n}\n.r-hand-size	{\n	width: 380px;\n	display: inline-block;\n	float: rigth;\n	clear: none;\n	text-align: right;\n}\nimg.default-logo	{\n	display: block;\n	float: right;\n}\n.body-content	{\n	width: 738px;\n	display: inline-block;\n	float: left;\n	clear: left;\n	padding: 30px;\n	border-left: 1px solid #888888;\n	border-right: 1px solid #888888;\n	border-bottom: 1px solid #888888;\n	border-radius-bottom: 15px;\n	margin-bottom: 30px;\n	background-color: #FFFFFF;\n	border-bottom-left-radius: 6px;\n	border-bottom-right-radius: 6px;\n}\n&lt;/style&gt;\n&lt;/head&gt;\n&lt;body&gt;\n&lt;div id=&quot;wrapper&quot;&gt;\n	&lt;div class=&quot;head_container&quot;&gt;\n		&lt;div class=&quot;l-hand-side&quot;&gt;\n			&lt;p class=&quot;header-h1&quot;&gt;Account Update&lt;/p&gt;\n			&lt;a class=&quot;formLinkButton login-button&quot; href=&quot;http://~SERVER::[HTTP_HOST]~&quot;&gt;Login&lt;/a&gt;\n		&lt;/div&gt;\n		&lt;div class=&quot;r-hand-size&quot;&gt;\n			&lt;img src=&quot;http://~SERVER::[HTTP_HOST]~/client_assets/images/logo/default.png&quot; class=&quot;default-logo&quot; /&gt;\n		&lt;/div&gt;\n	&lt;/div&gt;\n	&lt;div class=&quot;body-content&quot;&gt;\n		&lt;h2&gt;Automated Message for ~SERVER::[HTTP_HOST]~:&lt;/h2&gt;\n		&lt;p&gt;~POST::[question]~&lt;/p&gt;\n		&lt;p&gt;&lt;span style=&quot;font-size: 10px; color: #888888;&quot;&gt;This message is automated and is only sent to you when an update has been made. You will not be sent spam from this system. Please contact http://~SERVER::[HTTP_HOST]~ if you feel you have received this in error.&lt;/span&gt;&lt;/p&gt;\n	&lt;/div&gt;\n&lt;/div&gt;\n&lt;/body&gt;\n&lt;/html&gt;', '', 'on', 'rasclatt@me.com', '&lt;h3&gt;Thank you for your interest in our company.&lt;/h3&gt;', 'default', 'on');

-- --------------------------------------------------------

--
-- Table structure for table `file_activity`
--

CREATE TABLE `file_activity` (
  `ID` int(20) NOT NULL,
  `unique_id` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `ip_address` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `action_slug` varchar(20) COLLATE utf8_unicode_ci DEFAULT '',
  `file_id` varchar(30) COLLATE utf8_unicode_ci DEFAULT '',
  `timestamp` varchar(20) COLLATE utf8_unicode_ci DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `form_builder`
--

CREATE TABLE `form_builder` (
  `ID` int(20) NOT NULL,
  `unique_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `column_type` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `column_name` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default_setting` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `restriction` varchar(4) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_order` int(3) DEFAULT NULL,
  `page_live` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `form_builder`
--

INSERT INTO `form_builder` (`ID`, `unique_id`, `column_type`, `column_name`, `size`, `default_setting`, `restriction`, `page_order`, `page_live`) VALUES
(1, '20150109190421300000', 'text', 'title', '', '', '0', 0, 'on'),
(2, '20150109190413900000', 'text', 'width', '', '', '0', 0, 'on'),
(3, '20150113135135600000', 'select', 'page_element', '', '', '', 0, 'on'),
(4, '20150109190406800000', 'select', 'toggle', '', '', '', 0, 'on'),
(5, '2014072021153410000', 'select', 'create_folder', '', '', 'NULL', 0, 'on'),
(6, '20150109190744400000', 'select', 'text_shadow', '', '', '', 0, 'on'),
(7, '20150109190742800000', 'text', 'min_width', 'style=&quot;width: 30px;&quot;', '', '0', 0, 'on'),
(8, '20150109190741400000', 'text', 'min_height', 'style=&quot;width: 30px;&quot;', '', '0', 0, 'on'),
(9, '20150109190739700000', 'select', 'menu_component', '', '', '', 0, 'on'),
(10, '2015010919073740000', 'select', 'login_view', '', '', '', 0, 'on'),
(11, '20150109190734700000', 'select', 'login_permission', '', '', '', 0, 'on'),
(12, '20150109190647500000', 'text', 'link', '', '', '0', 0, 'on'),
(13, '20150109190635500000', 'select', 'in_menubar', '', '', '', 0, 'on'),
(14, '20150109190630400000', 'text', 'last_name', '', '', '', 0, 'on'),
(15, '20150109190632200000', 'select', 'image_corners', '', '', '', 0, 'on'),
(16, '20150109190622100000', 'select', 'image_border', '', '', '', 0, 'on'),
(17, '20150109190621600000', 'hidden', 'ID', '', '', '', 0, 'on'),
(18, '20150109190620700000', 'select', 'head_component', '', '', '', 0, 'on'),
(19, '2015010919061460000', 'hidden', 'file_size', '', '', '', 0, 'on'),
(20, '20150109190612600000', 'hidden', 'full_path', '', '', 'NULL', 0, 'on'),
(21, '20150109190611800000', 'text', 'first_name', '', '', '0', 0, 'on'),
(22, '20150109190610900000', 'text', 'font_size', '', '', '0', 0, 'on'),
(23, '20150109190609300000', 'hidden', 'file_name', '', '', '', 0, 'on'),
(24, '20150109190608800000', 'select', 'font_family', '', '', '', 0, 'on'),
(25, '20150109190607500000', 'select', 'difficulty', '', '', '', 0, 'on'),
(26, '20150109190605300000', 'text', 'file_path', '', '', '0', 0, 'on'),
(27, '2015010919060450000', 'select', 'display', '', '', '', 0, 'on'),
(28, '201501091905561000', 'hidden', 'command', '', '', '', 0, 'on'),
(29, '20150109190557800000', 'text', 'email', '', '', '0', 0, 'on'),
(30, '2015010919055370000', 'file', 'file', '', '', '', 0, 'on'),
(31, '20150109190554700000', 'select', 'core_setting', '', '', '', 0, 'on'),
(32, '20150109115820100000', 'textarea', 'description', 'style=&quot;min-width: 300px; width: 90%; min-height: 200px;&quot;', '', '', 0, 'on'),
(33, '20150109190549200000', 'text', 'border_radius', '', '', '0', 0, 'on'),
(34, '2015010911580690000', 'textarea', 'content', 'style=&quot;min-width: 300px; width: 90%; min-height: 200px;&quot; class=&quot;textarea&quot;', '', 'NULL', 0, 'on'),
(35, '2014072016145970000', 'text', 'component', '', '', '', 0, 'on'),
(36, '2014072023514730000', 'text', 'class', '', '', '', 0, 'on'),
(37, '20150109190536500000', 'select', 'column_type', '', '', '', 0, 'on'),
(38, '20150109190531300000', 'select', 'color', '', '', '', 0, 'on'),
(39, '2015010919053080000', 'select', 'component_type', '', '', '', 0, 'on'),
(40, '20150109190529100000', 'select', 'custom_components', '', '', '', 0, 'on'),
(41, '20150109190528600000', 'select', 'admin_tag', '', '', '', 0, 'on'),
(42, '2015010919052860000', 'select', 'background_color', '', '', '', 0, 'on'),
(43, '20150109190527500000', 'select', 'box_shadow', '', '', '', 0, 'on'),
(44, '20150109190526900000', 'checkbox', 'auto_fwd_post', '', '', '', 0, 'on'),
(45, '20150109190524500000', 'select', 'admin_lock', '', '', '', 0, 'on'),
(46, '2015010919052220000', 'select', 'allowed_request', '', '', '', 0, 'on'),
(47, '20150109190518600000', 'select', 'auto_cache', '', '', '', 0, 'on'),
(48, '20150109190515200000', 'text', 'a_href', '', '', '0', 0, 'on'),
(49, '201501091905142000', 'select', '_float', '', '', '', 0, 'on'),
(50, '2015010919051270000', 'select', '_position', '', '', '', 0, 'on'),
(51, '20150109190509600000', 'text', '_left', '', '', '0', 0, 'on'),
(52, '20150109190508100000', 'hidden', 'old_directory', '', '', '', 0, 'on'),
(53, '20150109190506100000', 'select', 'overflow', '', '', '', 0, 'on'),
(54, '2014072700504710000', 'text', 'page_order', 'style=&quot;max-width: 40px;&quot;', '', '0', 0, 'on'),
(55, '20150109190501300000', 'hidden', 'oldName', '', '', '', 0, 'on'),
(56, '20150109190459500000', 'password', 'password', '', '', '0', 0, 'on'),
(57, '20150109190458600000', 'hidden', 'unique_id', '', '', '', 0, 'on'),
(58, '20150109190457600000', 'select', 'restriction', '', '', '', 0, 'on'),
(59, '20150109190455100000', 'select', 'user_access', '', '', '', 0, 'on'),
(60, '20150109190454400000', 'select', 'session_status', '', '', '', 0, 'on'),
(61, '2015010919045320000', 'select', 'template', '', '', '', 0, 'on'),
(62, '20150109190452800000', 'select', 'style', '', '', '', 0, 'on'),
(63, '20150109190447100000', 'select', 'section', '', '', '', 0, 'on'),
(64, '20150109190446500000', 'select', 'user_status', '', '', '', 0, 'on'),
(65, '201501091904449000', 'text', 'username', '', '', '0', 0, 'on'),
(66, '20150109190441700000', 'select', 'usergroup', '', '', '', 0, 'on'),
(67, '2015010919042730000', 'text', 'name', '', '', '0', 0, 'on'),
(68, '20150109190433600000', 'select', 'text_align', '', '', '', 0, 'on'),
(69, '20150109115741600000', 'textarea', 'notes', 'style=&quot;height: 50px; width: 90%; border-color: #CCCCCC;&quot;', '', '', 0, 'on'),
(70, '20150205160420300000', 'select', 'is_admin', '', '', '0', 0, 'on'),
(71, '201503311814471166551157282', 'select', 'return_copy', '', '', 'NULL', 0, 'on'),
(72, '201503311816043367551149487', 'textarea', 'content_back', 'style=&quot;min-width: 300px; width: 90%; min-height: 200px;&quot; class=&quot;.textarea&quot;', '', 'NULL', 0, 'on'),
(73, '2015040118050651045516928007', 'text', 'css', ' ', '', 'NULL', 0, 'on'),
(74, '20150402154952323555196055', 'select', 'map_input', '', '', 'NULL', 0, 'on'),
(75, '20150404020249172155178910', 'textarea', 'menu_options', 'style=&quot;min-width: 300px; width: 90%; min-height: 200px;&quot; class=&quot;.textarea&quot;', '', 'NULL', 0, 'on'),
(76, '2016111815494258269660605', 'textarea', 'return_response', 'style=&quot;height: 100px; width: 300px;&quot;', '', '0', 0, 'on'),
(77, '20161120011114583138241', 'select', 'page_live', 'style=&quot;width: auto;&quot;', '', '0', 0, 'on'),
(78, '20161201130249584065955201', 'select', 'downloadable', '', '', '', 0, 'on'),
(79, '201612011309255840675573', 'select', 'editable', '', '', '', 0, 'on'),
(80, '2016120113233558406742', 'select', 'readable', '', '', '', 0, 'on'),
(81, '2016120713410958485751004', 'select', 'directory_protection', NULL, NULL, NULL, NULL, 'on'),
(82, '20170629193714595582707', 'select', 'locale_abbr', NULL, NULL, NULL, NULL, 'on'),
(83, '20210131155624107867', 'select', 'page_type', NULL, NULL, '1', NULL, 'on');

-- --------------------------------------------------------

--
-- Table structure for table `main_menus`
--

CREATE TABLE `main_menus` (
  `ID` int(20) NOT NULL,
  `unique_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `parent_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT '',
  `full_path` varchar(600) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_name` varchar(70) COLLATE utf8_unicode_ci DEFAULT NULL,
  `group_id` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_options` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `link` varchar(200) COLLATE utf8_unicode_ci DEFAULT '',
  `template` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'template/default',
  `use_page` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auto_cache` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `in_menubar` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `is_admin` varchar(1) COLLATE utf8_unicode_ci DEFAULT '0',
  `page_type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'page',
  `auto_fwd` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auto_fwd_post` varchar(4) COLLATE utf8_unicode_ci DEFAULT 'off',
  `session_status` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `usergroup` varchar(30) COLLATE utf8_unicode_ci DEFAULT 'NBR_WEB',
  `page_live` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'off',
  `page_order` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `main_menus`
--

INSERT INTO `main_menus` (`ID`, `unique_id`, `parent_id`, `full_path`, `menu_name`, `group_id`, `page_options`, `link`, `template`, `use_page`, `auto_cache`, `in_menubar`, `is_admin`, `page_type`, `auto_fwd`, `auto_fwd_post`, `session_status`, `usergroup`, `page_live`, `page_order`) VALUES
(1, '2016120214231458412266', '', '/admintools/', 'Nubersoft', NULL, '', 'admintools', '/core/template/nubersoft2020/', '', 'off', 'off', '1', 'admin', '', 'off', 'on', 'NBR_ADMIN', 'on', 1),
(2, '201612021444165841104219', '', '/', 'Home', NULL, '', 'home', '/core/template/nubersoft2020/', '', 'off', 'on', '2', 'home', '', 'off', 'off', '0', 'on', 1),
(3, '20171226130020542864427', '', '/contact-us/', 'Contact', NULL, '', 'contact-us', '/core/template/nubersoft2020/', '', 'off', 'on', '', 'contact', '', 'off', 'off', 'NBR_WEB', 'on', 2),
(4, '2018012313245356782531', '', '/login/', 'Login', NULL, '', 'login', '/core/template/nubersoft2020/', '', 'off', 'on', '3', 'login', '/account/', 'on', 'on', 'NBR_WEB', 'on', 15),
(5, '20181106110902768054', '', '/account/', 'My Account', NULL, NULL, 'account', '/core/template/nubersoft2020/', '', 'off', 'on', '', 'account', '', 'off', 'on', 'NBR_WEB', 'on', 4),
(6, '20210201084701936705', '', '/admintools/translator/', 'Translation Tool', '', '', 'translator', '/core/template/nubersoft2020/', '', 'off', 'off', '1', 'transtool', '', 'off', 'on', '2', 'on', 1),
(7, '20210131160143431567', '', '/checkout/', 'Checkout', '', '', 'checkout', '/core/template/nubersoft2020/', '', 'off', 'off', '0', 'checkout', '', 'off', 'on', '3', 'on', 1);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `ID` bigint(50) UNSIGNED NOT NULL,
  `unique_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '',
  `usergroup` int(2) DEFAULT NULL,
  `username` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT '',
  `file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `file_path` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `file_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT '',
  `file_size` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `terms_id` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `login_view` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `page_order` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `page_live` varchar(3) COLLATE utf8_unicode_ci DEFAULT 'on'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members_connected`
--

CREATE TABLE `members_connected` (
  `ID` int(11) NOT NULL,
  `unique_id` varchar(50) DEFAULT '',
  `ip_address` varchar(24) DEFAULT '',
  `username` varchar(100) DEFAULT '',
  `domain` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `ID` int(20) NOT NULL,
  `category_id` varchar(50) DEFAULT NULL,
  `option_group_name` varchar(50) DEFAULT NULL,
  `option_attribute` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `usergroup` int(4) DEFAULT 1,
  `action_slug` varchar(100) DEFAULT NULL,
  `page_live` varchar(3) DEFAULT NULL,
  `page_order` varchar(3) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`ID`, `category_id`, `option_group_name`, `option_attribute`, `usergroup`, `action_slug`, `page_live`, `page_order`) VALUES
(64, 'transhost', 'system', 'nubersoft.com', 1, NULL, 'on', '1'),
(785, 'composer', 'system', '{\r\n    &quot;name&quot;: &quot;rasclatt/cms&quot;,\r\n    &quot;type&quot;: &quot;project&quot;,\r\n    &quot;description&quot;: &quot;Mini CMS framework for PHP. Requires Nubersoft Class Library to run.&quot;,\r\n    &quot;keywords&quot;: [\r\n        &quot;Nubersoft&quot;,\r\n        &quot;PHP&quot;,\r\n        &quot;framework&quot;,\r\n        &quot;cms&quot;\r\n    ],\r\n    &quot;homepage&quot;: &quot;https://github.com/rasclatt/cms&quot;,\r\n    &quot;license&quot;: &quot;MIT&quot;,\r\n    &quot;authors&quot;: [\r\n        {\r\n            &quot;name&quot;: &quot;Ryan Rayner&quot;,\r\n            &quot;email&quot;: &quot;rasclatt@me.com&quot;,\r\n            &quot;role&quot;: &quot;Developer&quot;\r\n        }\r\n    ],\r\n    &quot;require&quot;: {\r\n        &quot;rasclatt/nubersoft&quot;: &quot;*&quot;,\r\n        &quot;firebase/php-jwt&quot;: &quot;*&quot;\r\n    }\r\n}', 1, NULL, 'on', '1'),
(786, 'webmaster', 'system', 'no-reply@nubersoft.local', 1, NULL, 'on', '1'),
(787, 'sign_up', 'system', 'on', 1, NULL, 'on', '1'),
(788, 'two_factor_auth', 'system', 'off', 1, NULL, 'on', '1'),
(789, 'frontend_admin', 'system', 'off', 1, NULL, 'on', '1'),
(790, 'maintenance_mode', 'system', 'off', 1, NULL, 'on', '1'),
(791, 'site_live', 'system', 'on', 1, NULL, 'on', '1'),
(792, 'template', 'system', '/core/template/nubersoft2020/', 1, NULL, 'on', '1'),
(793, 'timezone', 'system', 'America/Los_Angeles', 1, NULL, 'on', '1'),
(794, 'htaccess', 'system', '&lt;IfModule mod_headers.c&gt;\r\n    Header set Access-Control-Allow-Origin &quot;*&quot;\r\n&lt;/IfModule&gt;\r\n\r\n# Deny access to file extensions\r\n&lt;FilesMatch &quot;\\.(htaccess|htpasswd|ini|flag|log|sh|pref|json|txt|html|xml|zip|sql)$&quot;&gt;\r\nOrder Allow,Deny\r\nDeny from all\r\n&lt;/FilesMatch&gt;\r\n\r\nSetEnvIf Authorization &quot;(.*)&quot; HTTP_AUTHORIZATION=$1\r\n\r\nRewriteEngine On\r\n## FORCE HTTPS -&gt; Uncommment to force ssl\r\nRewriteCond %{HTTPS} !=on\r\nRewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301] \r\n## Normal Rewrites\r\nRewriteCond %{REQUEST_URI} !(/$|\\.|^$)\r\nRewriteRule (.*) %{REQUEST_URI}/ [R=301,L] \r\nRewriteCond $1 !^(index.php|images|robots.txt)\r\nRewriteCond %{REQUEST_FILENAME} !-f\r\nRewriteCond %{REQUEST_FILENAME} !-d\r\nRewriteRule ^(.*)$ /index.php?$1 [NC,QSA,L]', 1, NULL, 'on', '1'),
(795, 'fileid', 'system', 'off', 1, NULL, 'on', '1'),
(796, 'devmode', 'system', 'dev', 1, NULL, 'on', '1'),
(803, 'footer_html_toggle', 'system', 'on', 1, NULL, 'on', '1'),
(804, 'footer_html', 'system', '&lt;footer class=&quot;col-count-3 offset&quot;&gt;\r\n	&lt;div class=&quot;start2 pad-top-2 pad-bottom-2 align-middle&quot;&gt;&lt;p class=&quot;legal&quot;&gt;Copyright &amp;copy; My Company ~DATE::[Y]~. All Rights Reserved.&lt;/p&gt;&lt;/div&gt;\r\n&lt;/footer&gt;', 1, NULL, 'on', '1'),
(805, 'country', 'locale', 'us', 1, NULL, 'on', '1'),
(806, 'language', 'locale', 'en', 1, NULL, 'on', '1'),
(807, 'language', 'locale', 'jp', 1, NULL, 'on', '2');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `unique_id` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(256) COLLATE utf8_bin NOT NULL DEFAULT '',
  `first_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_1` text COLLATE utf8_bin DEFAULT NULL,
  `address_2` text COLLATE utf8_bin DEFAULT NULL,
  `city` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `state` varchar(4) COLLATE utf8_bin DEFAULT NULL,
  `country` varchar(100) COLLATE utf8_bin DEFAULT NULL,
  `postal` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `usergroup` varchar(30) COLLATE utf8_bin NOT NULL DEFAULT 'NBR_WEB',
  `user_status` varchar(4) COLLATE utf8_bin DEFAULT 'on',
  `file` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `file_path` varchar(200) COLLATE utf8_bin DEFAULT NULL,
  `file_name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `reset_password` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `attempts` varchar(1) COLLATE utf8_bin DEFAULT '0',
  `last_attempt` varchar(50) COLLATE utf8_bin DEFAULT '0',
  `timestamp` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `unique_id`, `username`, `password`, `first_name`, `last_name`, `email`, `address_1`, `address_2`, `city`, `state`, `country`, `postal`, `usergroup`, `user_status`, `file`, `file_path`, `file_name`, `reset_password`, `attempts`, `last_attempt`, `timestamp`) VALUES
(1, '202005260329152918946', 'rasclatt@me.com', '$2y$09$vFim2QB8RqfEhw3QoCv3RO538aT1GZjLn6rIF37hlQPF2bECYbzme', 'Ryan', 'Rayner', 'rasclatt@me.com', '', '', 'Reno', 'NV', 'US', '', 'NBR_SUPERUSER', 'on', '/client/media/images/woman-with-mobile-01.jpg', '/client/media/images/', 'woman-with-mobile-01.jpg', NULL, '', '', '2020-05-26 03:29:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

CREATE TABLE `user_roles` (
  `ID` int(20) NOT NULL,
  `user_role` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_attribute` longtext COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_id` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

$create[]	=	"
ALTER TABLE `components`
  ADD UNIQUE KEY `ID_UNIQUE` (`ID`),
  ADD KEY `parent_id` (`parent_id`),
  ADD KEY `unique_id` (`unique_id`),
  ADD KEY `ref_page` (`ref_page`,`ref_anchor`,`category_id`,`component_type`,`page_live`),
  ADD KEY `title` (`title`);
";
$create[]	=	"
ALTER TABLE `component_locales`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD KEY `comp_id` (`comp_id`,`locale_abbr`,`page_live`);
";
$create[]	=	"
ALTER TABLE `dropdown_menus`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `assoc_column` (`assoc_column`),
  ADD KEY `unique_id` (`unique_id`);
";
$create[]	=	"
ALTER TABLE `emailer`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `email_id` (`email_id`),
  ADD KEY `unique_id` (`unique_id`,`email_id`);
";
$create[]	=	"
ALTER TABLE `file_activity`
  ADD PRIMARY KEY (`ID`);
";
$create[]	=	"
ALTER TABLE `form_builder`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `unique_id` (`unique_id`),
  ADD KEY `column_type` (`column_type`,`column_name`,`page_live`);
";
$create[]	=	"
ALTER TABLE `main_menus`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `unique_id` (`unique_id`),
  ADD KEY `parent_id` (`parent_id`,`full_path`(255),`group_id`,`link`,`page_live`);
";
$create[]	=	"
ALTER TABLE `media`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `unique_id` (`unique_id`);
";
$create[]	=	"
ALTER TABLE `members_connected`
  ADD UNIQUE KEY `ID_UNIQUE` (`ID`),
  ADD UNIQUE KEY `username` (`username`);
";
$create[]	=	"
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`ID`);
";
$create[]	=	"
ALTER TABLE `users`
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `ID_UNIQUE` (`ID`),
  ADD KEY `password` (`password`(255)),
  ADD KEY `user_status` (`user_status`);
";
$create[]	=	"
ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_role` (`user_role`);
";
$create[]	=	"
ALTER TABLE `components`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;
";
$create[]	=	"
ALTER TABLE `component_locales`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT;
";
$create[]	=	"
ALTER TABLE `dropdown_menus`
  MODIFY `ID` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
";
$create[]	=	"
ALTER TABLE `emailer`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
";
$create[]	=	"
ALTER TABLE `file_activity`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT;
";
$create[]	=	"
ALTER TABLE `form_builder`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;
";
$create[]	=	"
ALTER TABLE `main_menus`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
";
$create[]	=	"
ALTER TABLE `media`
  MODIFY `ID` bigint(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
";
$create[]	=	"
ALTER TABLE `members_connected`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
";
$create[]	=	"
ALTER TABLE `system_settings`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=808;
";
$create[]	=	"
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
";
$create[]	=	"
ALTER TABLE `user_roles`
  MODIFY `ID` int(20) NOT NULL AUTO_INCREMENT;
COMMIT;
";