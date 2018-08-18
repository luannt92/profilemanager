-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2018 at 07:11 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `profilemanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `i18n`
--

CREATE TABLE `i18n` (
  `id` int(11) NOT NULL,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ntl_categories`
--

CREATE TABLE `ntl_categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `position` int(11) NOT NULL DEFAULT '0',
  `menu_display` int(1) NOT NULL DEFAULT '1',
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` text,
  `meta_description` text,
  `meta_keyword` text,
  `status` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ntl_educations`
--

CREATE TABLE `ntl_educations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ntl_experiences`
--

CREATE TABLE `ntl_experiences` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ntl_mail_templates`
--

CREATE TABLE `ntl_mail_templates` (
  `id` int(11) NOT NULL,
  `subject` varchar(512) NOT NULL,
  `content` text NOT NULL,
  `code` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `ntl_mail_templates`
--

INSERT INTO `ntl_mail_templates` (`id`, `subject`, `content`, `code`, `created_at`, `updated_at`) VALUES
(1, 'Template order', '<p><strong>Cảm ơn bạn đ&atilde; đặt h&agrave;ng tại <a href=\"phuquocdelivery.com\">phuquocdelivery.com</a></strong></p>', 'TPL0005', '2018-04-01 12:02:23', '2018-04-23 08:38:07'),
(2, '[PhuQuocDelivery] Xác nhận email đăng ký tài khoản', '<table cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td><img class=\"img-responsive\" src=\"/img/header.jpg\" /></td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">\r\n<h3>X&aacute;c nhận email đăng k&yacute; t&agrave;i khoản</h3>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">Xin ch&agrave;o %user%. Một t&agrave;i khoản đ&atilde; được tạo cho bạn tại <strong>phuquocdelivery.com</strong>. Bạn h&atilde;y nhấn x&aacute;c nhận ở dưới để ho&agrave;n tất việc đăng k&yacute; t&agrave;i khoản nh&eacute;!</td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\" style=\"text-align: center;\"><a class=\"btn-primary\" href=\"%link%\">X&Aacute;C NHẬN</a></td>\r\n</tr>\r\n</tbody>\r\n</table>', 'TPL0001', '2018-04-01 12:03:20', '2018-04-07 15:44:45'),
(3, '[Phuquocdelivery] Liên hệ từ người dùng', '<table cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td><img class=\"img-responsive\" src=\"/img/header.jpg\" /></td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">\r\n<h3>Bạn đ&atilde; nhận được phản hồi mới từ Phuquocdelivery</h3>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block order\">\r\n<h3 class=\"contact-title\">Fullname:</h3>\r\n<p class=\"contact-content\">%fullname%</p>\r\n<h3 class=\"contact-title\">Phone number:</h3>\r\n<p class=\"contact-content\">%phone%</p>\r\n<h3 class=\"contact-title\">Email:</h3>\r\n<p class=\"contact-content\">%email%</p>\r\n<h3 class=\"contact-title\">Title:</h3>\r\n<p class=\"contact-content\">%title%</p>\r\n<h3 class=\"contact-title\">Content:</h3>\r\n<p class=\"contact-content\">%content%</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'TPL0006', '2018-03-31 00:00:00', '2018-04-11 11:21:20'),
(4, '[PhuQuocDelivery] Thông báo kích hoạt tài khoản thành công.', '<table cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td><img class=\"img-responsive\" src=\"/img/header.jpg\" /></td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">\r\n<h3>Th&ocirc;ng b&aacute;o tạo t&agrave;i khoản th&agrave;nh c&ocirc;ng.</h3>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">\r\n<p>Xin ch&agrave;o %user%.</p>\r\n<p>Bạn đ&atilde; k&iacute;ch hoạt t&agrave;i khoản th&agrave;nh c&ocirc;ng tr&ecirc;n <strong>phuquocdelivery.com</strong>.</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'TPL0004', '2018-04-07 15:58:02', '2018-04-08 10:06:54'),
(5, '[PhuQuocDelivery] Xác nhận đổi mật khẩu mới', '<table cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td><img class=\"img-responsive\" src=\"/img/header.jpg\" /></td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">\r\n<h3>X&aacute;c nhận đổi mật khẩu mới</h3>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">Xin ch&agrave;o %user%. Ch&uacute;ng t&ocirc;i đ&atilde; nhận được phản hồi của bạn về việc qu&ecirc;n mật khẩu t&agrave;i khoản. Nếu bạn thật sự gặp vấn đề tr&ecirc;n, h&atilde;y đổi mật khẩu mới tại đ&acirc;y:</td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\" style=\"text-align: center;\"><a class=\"btn-primary\" href=\"%link%\">Đổi mật khẩu mới</a></td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">Nếu bạn kh&ocirc;ng gặp sự cố, h&atilde;y bỏ qua email n&agrave;y v&agrave; mật khẩu t&agrave;i khoản của bạn vẫn được giữ nguy&ecirc;n.</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'TPL0002', '2018-04-08 10:30:39', '2018-04-08 10:30:39'),
(6, '[PhuQuocDelivery] Thông báo đổi mật khẩu thành công.', '<table cellspacing=\"0\" cellpadding=\"0\">\r\n<tbody>\r\n<tr>\r\n<td><img class=\"img-responsive\" src=\"/img/header.jpg\" /></td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">\r\n<h3>Th&ocirc;ng b&aacute;o đổi mật khẩu th&agrave;nh c&ocirc;ng.</h3>\r\n</td>\r\n</tr>\r\n<tr>\r\n<td class=\"content-block\">\r\n<p>Xin ch&agrave;o %user%.</p>\r\n<p>Bạn đ&atilde; đổi mật khẩu t&agrave;i khoản th&agrave;nh c&ocirc;ng tr&ecirc;n <strong>phuquocdelivery.com</strong>.</p>\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>', 'TPL0003', '2018-04-10 14:17:48', '2018-04-10 14:17:48'),
(7, '[PHUQUOC DELIVERY] Cập nhật trạng thái đơn hàng ', ' <table cellspacing=\"0\" cellpadding=\"0\">\r\n                                            <tbody>\r\n                                            <tr>\r\n                                                <td class=\"content-block\">\r\n                                                </td>\r\n                                            </tr>\r\n                                            <tr>\r\n                                                <td class=\"content-block text-center\">\r\n                                                    <h3>Bạn đ&atilde; nhận được phản hồi mới từ Phuquocdelivery</h3>\r\n                                                </td>\r\n                                            </tr>\r\n                                            <tr>\r\n                                                <td><form action=\"\">\r\n                                                    <table>\r\n                                                        <tbody>\r\n                                                        <tr>\r\n                                                            <td width=\"100px\">Mã order</td>\r\n                                                            <td><strong>%tracking%</strong></td>\r\n                                                        </tr>\r\n                                                        <tr>\r\n                                                            <td>Full name</td>\r\n                                                            <td>%fullname%</td>\r\n                                                        </tr>\r\n                                                        <tr>\r\n                                                            <td>Order time</td>\r\n                                                            <td>%time%</td>\r\n                                                        </tr>\r\n                                                        <tr>\r\n                                                            <td class=\"content-block\">Thông báo</td>\r\n                                                            <td class=\"content-block\">Đã chuyển sang trạng thái: <strong>%status%</strong></td>\r\n                                                        </tr>\r\n                                                        </tbody>\r\n                                                    </table>\r\n                                                </form></td>\r\n                                            </tr>\r\n                                            </tbody>\r\n                                        </table>', 'TPL0007', '2018-04-10 00:00:00', '2018-04-10 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ntl_menus`
--

CREATE TABLE `ntl_menus` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(1) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1: active, 0: deactive, -1: delete, 2: schedule',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ntl_menus`
--

INSERT INTO `ntl_menus` (`id`, `name`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Menu header', 1, 1, '2018-04-04 11:59:17', '2018-04-04 11:59:17'),
(2, 'Menu footer', 2, 1, '2018-04-10 15:32:16', '2018-04-10 15:32:16'),
(3, 'Menu Link', 3, 1, '2018-04-10 15:32:52', '2018-04-10 15:32:52');

-- --------------------------------------------------------

--
-- Table structure for table `ntl_menu_items`
--

CREATE TABLE `ntl_menu_items` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `type` int(1) NOT NULL COMMENT '1: category, 2: tag, 3: link',
  `obj_id` int(11) DEFAULT NULL,
  `target` int(1) DEFAULT '0',
  `position` int(11) NOT NULL DEFAULT '0',
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1: active, 0: deactive, -1: delete, 2: schedule',
  `parent_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ntl_news`
--

CREATE TABLE `ntl_news` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `new_category_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL COMMENT 'default:generate link from title',
  `meta_title` text COLLATE utf8_unicode_ci,
  `meta_keyword` text COLLATE utf8_unicode_ci,
  `meta_description` text COLLATE utf8_unicode_ci,
  `description` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT 'for SEO',
  `content` text CHARACTER SET utf8 NOT NULL,
  `publish_date` datetime NOT NULL,
  `image` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1: active, 0: deactive, -1: delete, 2: schedule',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ntl_news`
--

INSERT INTO `ntl_news` (`id`, `user_id`, `new_category_id`, `title`, `slug`, `meta_title`, `meta_keyword`, `meta_description`, `description`, `content`, `publish_date`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'tin tức 001', 'tin-tuc-001', 'meta tin tức 01', 'keyword tin tức 0§', 'Mô tả tin tức 01', 'Mô tả tin tức 001', '<p>Conten tin tức 01</p>', '1990-01-01 00:00:00', '/thumbs/1522068301loading7_orange.gif', 1, '2018-03-30 16:42:02', '2018-04-04 14:40:14');

-- --------------------------------------------------------

--
-- Table structure for table `ntl_new_categories`
--

CREATE TABLE `ntl_new_categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` text,
  `meta_description` text,
  `meta_keyword` text,
  `status` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ntl_new_categories`
--

INSERT INTO `ntl_new_categories` (`id`, `parent_id`, `name`, `slug`, `meta_title`, `meta_description`, `meta_keyword`, `status`, `created_at`, `updated_at`) VALUES
(1, 0, 'Test 2018', 'test-2018', 'chính sách', 'test', 'chính sách', 1, '2018-04-04 12:12:54', '2018-04-04 13:41:58');

-- --------------------------------------------------------

--
-- Table structure for table `ntl_new_tags`
--

CREATE TABLE `ntl_new_tags` (
  `id` int(11) NOT NULL,
  `new_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1: active, 0: deactive, -1: delete, 2: schedule'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ntl_new_tags`
--

INSERT INTO `ntl_new_tags` (`id`, `new_id`, `tag_id`, `status`) VALUES
(7, 1, 9, 1),
(8, 1, 10, 1),
(9, 1, 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `ntl_pages`
--

CREATE TABLE `ntl_pages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text,
  `type` int(1) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `meta_keyword` varchar(255) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ntl_pages`
--

INSERT INTO `ntl_pages` (`id`, `user_id`, `title`, `slug`, `content`, `type`, `meta_title`, `meta_description`, `meta_keyword`, `image`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Câu hỏi thường gặp', 'cau-hoi-thuong-gap', '<p>Nội Dung</p>', 0, 'Câu hỏi thường gặp', 'Câu hỏi thường gặp', 'Câu hỏi thường gặp', '', 1, '2018-04-04 11:13:32', '2018-04-04 11:13:32'),
(2, 2, 'Hướng dẫn', 'huong-dan', '<p>test</p>', 0, '', '', '', '', 1, '2018-04-10 16:32:27', '2018-04-10 16:32:27');

-- --------------------------------------------------------

--
-- Table structure for table `ntl_portfolios`
--

CREATE TABLE `ntl_portfolios` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ntl_settings`
--

CREATE TABLE `ntl_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `value` text CHARACTER SET utf8 NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1: active, 0: deactive, -1: delete, 2: schedule',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ntl_settings`
--

INSERT INTO `ntl_settings` (`id`, `name`, `value`, `status`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Nguyễn Thành Luân', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(2, 'site_description', 'Hello! I am Anthony Barnett. Web Developer, Graphic Designer and Photographer.\r\n\r\nCreative CV is a HTML resume template for professionals. Built with Bootstrap 4, Now UI Kit and FontAwesome, this modern and responsive design template is perfect to showcase your portfolio, skills and experience.', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(3, 'site_language', '1', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(4, 'site_banner_popup', '', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(5, 'site_mail_hostname', 'smtp.gmail.com', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(6, 'site_mail_username', 'ntluan0@gmail.com', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(7, 'site_mail_password', '123456', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(8, 'site_mail_port', '465', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(9, 'site_mail_timeout', '30', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(10, 'site_mail_number', '100', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(11, 'me_about_vi', 'Hello! I am Anthony Barnett. Web Developer, Graphic Designer and Photographer.\r\n\r\nCreative CV is a HTML resume template for professionals. Built with Bootstrap 4, Now UI Kit and FontAwesome, this modern and responsive design template is perfect to showcase your portfolio, skills and experience.', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(12, 'me_about_en', 'Hello! I am Anthony Barnett. Web Developer, Graphic Designer and Photographer.\r\n\r\nCreative CV is a HTML resume template for professionals. Built with Bootstrap 4, Now UI Kit and FontAwesome, this modern and responsive design template is perfect to showcase your portfolio, skills and experience.', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(13, 'me_mail', 'luannt292@gmail.com', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(14, 'me_birthday', '20-02-1992', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(15, 'me_phone', '0964696656', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(16, 'me_address_vi', 'Hà Nội', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(17, 'me_address_en', 'Ha Noi', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(18, 'meta_title_en', '', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(19, 'meta_keyword_en', '', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(20, 'meta_description_en', '', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(21, 'meta_title_vi', '', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(22, 'meta_keyword_vi', '', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31'),
(23, 'meta_description_vi', '', 1, '2018-08-18 12:02:31', '2018-08-18 12:02:31');

-- --------------------------------------------------------

--
-- Table structure for table `ntl_skills`
--

CREATE TABLE `ntl_skills` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `percent` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ntl_sliders`
--

CREATE TABLE `ntl_sliders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `position` int(1) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32;

--
-- Dumping data for table `ntl_sliders`
--

INSERT INTO `ntl_sliders` (`id`, `user_id`, `title`, `description`, `url`, `image`, `position`, `status`, `created_at`, `updated_at`) VALUES
(2, 1, 'Slider001', 'Mô tả slider 001', '', '/img/slide.jpg', 1, 1, '2018-04-04 11:42:57', '2018-04-04 11:42:57'),
(3, 1, 'Slider002', 'Mô tả Slider002', '', '/img/slide.jpg', 2, 1, '2018-04-04 11:44:34', '2018-04-04 11:44:34');

-- --------------------------------------------------------

--
-- Table structure for table `ntl_users`
--

CREATE TABLE `ntl_users` (
  `id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `full_name` varchar(100) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL COMMENT 'avatar của user',
  `address` varchar(255) DEFAULT NULL,
  `phone_number` varchar(50) DEFAULT NULL,
  `note` text NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ntl_users`
--

INSERT INTO `ntl_users` (`id`, `user_group_id`, `email`, `password`, `full_name`, `avatar`, `address`, `phone_number`, `note`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'ntluan0@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Nguyen Luan', NULL, 'Thanh Hóa', '0964696656', '', 1, '2018-08-14 00:00:00', '2018-08-14 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ntl_user_groups`
--

CREATE TABLE `ntl_user_groups` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ntl_user_groups`
--

INSERT INTO `ntl_user_groups` (`id`, `name`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 1, 1, '2018-03-28 00:00:00', '2018-03-28 00:00:00'),
(2, 'Member', 2, 1, '2018-04-06 00:00:00', '2018-04-06 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `ntl_user_group_permissions`
--

CREATE TABLE `ntl_user_group_permissions` (
  `id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ntl_user_group_permissions`
--

INSERT INTO `ntl_user_group_permissions` (`id`, `user_group_id`, `code`) VALUES
(1, 4, 100),
(2, 4, 101),
(3, 4, 102),
(4, 4, 103),
(5, 4, 104),
(6, 4, 105),
(7, 4, 300),
(8, 4, 301),
(9, 4, 302),
(10, 4, 303),
(11, 4, 304),
(12, 4, 305),
(13, 4, 600),
(14, 4, 601),
(15, 4, 602),
(16, 4, 603),
(17, 4, 604),
(18, 4, 605),
(19, 4, 800),
(20, 4, 801),
(21, 4, 802),
(22, 4, 803),
(23, 4, 804),
(24, 4, 805),
(25, 4, 806),
(26, 4, 807),
(27, 4, 1200),
(28, 4, 1201),
(29, 4, 1202),
(30, 4, 1203),
(31, 4, 1204),
(32, 4, 1205),
(33, 4, 1300),
(34, 4, 1301),
(35, 4, 1302),
(36, 4, 1303),
(37, 4, 1304),
(38, 4, 1305);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `i18n`
--
ALTER TABLE `i18n`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `I18N_LOCALE_FIELD` (`locale`,`model`,`foreign_key`,`field`),
  ADD KEY `I18N_FIELD` (`model`,`foreign_key`,`field`);

--
-- Indexes for table `ntl_categories`
--
ALTER TABLE `ntl_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_educations`
--
ALTER TABLE `ntl_educations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_experiences`
--
ALTER TABLE `ntl_experiences`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_mail_templates`
--
ALTER TABLE `ntl_mail_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_menus`
--
ALTER TABLE `ntl_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_menu_items`
--
ALTER TABLE `ntl_menu_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_news`
--
ALTER TABLE `ntl_news`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKUsers_UserID_idx` (`user_id`);

--
-- Indexes for table `ntl_new_categories`
--
ALTER TABLE `ntl_new_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_new_tags`
--
ALTER TABLE `ntl_new_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_NewTags_NewID_idx` (`new_id`) USING BTREE,
  ADD KEY `FK_NewTags_TagID_idx` (`tag_id`) USING BTREE;

--
-- Indexes for table `ntl_pages`
--
ALTER TABLE `ntl_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_portfolios`
--
ALTER TABLE `ntl_portfolios`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_settings`
--
ALTER TABLE `ntl_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_skills`
--
ALTER TABLE `ntl_skills`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_sliders`
--
ALTER TABLE `ntl_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_users`
--
ALTER TABLE `ntl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_user_groups`
--
ALTER TABLE `ntl_user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ntl_user_group_permissions`
--
ALTER TABLE `ntl_user_group_permissions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `i18n`
--
ALTER TABLE `i18n`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ntl_categories`
--
ALTER TABLE `ntl_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ntl_educations`
--
ALTER TABLE `ntl_educations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ntl_experiences`
--
ALTER TABLE `ntl_experiences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ntl_mail_templates`
--
ALTER TABLE `ntl_mail_templates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ntl_menus`
--
ALTER TABLE `ntl_menus`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ntl_menu_items`
--
ALTER TABLE `ntl_menu_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ntl_news`
--
ALTER TABLE `ntl_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ntl_new_categories`
--
ALTER TABLE `ntl_new_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ntl_new_tags`
--
ALTER TABLE `ntl_new_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `ntl_pages`
--
ALTER TABLE `ntl_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ntl_portfolios`
--
ALTER TABLE `ntl_portfolios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ntl_settings`
--
ALTER TABLE `ntl_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `ntl_skills`
--
ALTER TABLE `ntl_skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ntl_sliders`
--
ALTER TABLE `ntl_sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ntl_users`
--
ALTER TABLE `ntl_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ntl_user_groups`
--
ALTER TABLE `ntl_user_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ntl_user_group_permissions`
--
ALTER TABLE `ntl_user_group_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
