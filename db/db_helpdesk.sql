-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2019 at 05:27 AM
-- Server version: 10.4.6-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_helpdesk`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ajax_plugins`
--

CREATE TABLE `tbl_ajax_plugins` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_ajax_plugins`
--

INSERT INTO `tbl_ajax_plugins` (`id`, `name`, `link`, `content`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Add sample text', 'add_lorem_ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Add Lorem Ipsum to textarea', 1, 1, '2019-07-15 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_categories`
--

CREATE TABLE `tbl_cms_categories` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parent_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `created_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_category_contents`
--

CREATE TABLE `tbl_cms_category_contents` (
  `id` int(32) NOT NULL,
  `content_id` int(32) NOT NULL,
  `content_category_id` int(32) NOT NULL,
  `description` text NOT NULL,
  `created_by` int(32) NOT NULL,
  `created_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_comments`
--

CREATE TABLE `tbl_cms_comments` (
  `id` int(32) NOT NULL,
  `text` text NOT NULL,
  `content_id` int(32) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `reason_for_block` text NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_contents`
--

CREATE TABLE `tbl_cms_contents` (
  `id` int(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` longtext NOT NULL,
  `meta_keyword` text NOT NULL,
  `meta_description` text NOT NULL,
  `is_footer` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) DEFAULT 0,
  `is_page` tinyint(1) NOT NULL DEFAULT 0,
  `menu_id` int(32) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cms_content_photos`
--

CREATE TABLE `tbl_cms_content_photos` (
  `id` int(32) NOT NULL,
  `path` varchar(255) NOT NULL,
  `content_id` int(32) NOT NULL,
  `description` text NOT NULL,
  `created_by` int(32) NOT NULL,
  `created_datetime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_messages`
--

CREATE TABLE `tbl_component_messages` (
  `id` int(32) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `from_id` int(32) NOT NULL,
  `to_id` int(32) NOT NULL,
  `status_id` int(32) NOT NULL,
  `category_id` int(32) DEFAULT NULL,
  `label_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_message_categories`
--

CREATE TABLE `tbl_component_message_categories` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_message_labels`
--

CREATE TABLE `tbl_component_message_labels` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_message_status`
--

CREATE TABLE `tbl_component_message_status` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_component_message_status`
--

INSERT INTO `tbl_component_message_status` (`id`, `name`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'unread', '-', 1, 1, '2019-02-11 00:00:00'),
(2, 'read', '-', 1, 1, '2019-02-11 00:00:00'),
(3, 'archive', '-', 1, 1, '2019-02-11 00:00:00'),
(1, 'unread', '-', 1, 1, '2019-02-11 00:00:00'),
(2, 'read', '-', 1, 1, '2019-02-11 00:00:00'),
(3, 'archive', '-', 1, 1, '2019-02-11 00:00:00'),
(1, 'unread', '-', 1, 1, '2019-02-11 00:00:00'),
(2, 'read', '-', 1, 1, '2019-02-11 00:00:00'),
(3, 'archive', '-', 1, 1, '2019-02-11 00:00:00'),
(1, 'unread', '-', 1, 1, '2019-02-11 00:00:00'),
(2, 'read', '-', 1, 1, '2019-02-11 00:00:00'),
(3, 'archive', '-', 1, 1, '2019-02-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_notifications`
--

CREATE TABLE `tbl_component_notifications` (
  `id` int(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `label` varchar(255) NOT NULL,
  `category_id` int(32) DEFAULT NULL,
  `status_id` int(32) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_notification_categories`
--

CREATE TABLE `tbl_component_notification_categories` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_component_notification_categories`
--

INSERT INTO `tbl_component_notification_categories` (`id`, `name`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'network', '-', 1, 1, '2019-02-02 00:00:00'),
(2, 'server', '-', 1, 1, '2019-02-02 00:00:00'),
(3, 'system', '-', 1, 1, '2019-02-02 00:00:00'),
(4, 'database', '-', 1, 1, '2019-02-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_notification_status`
--

CREATE TABLE `tbl_component_notification_status` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` int(11) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_component_notification_status`
--

INSERT INTO `tbl_component_notification_status` (`id`, `name`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'pending', '-', 1, 1, '2019-02-02 00:00:00'),
(2, 'read', '-', 1, 1, '2019-02-02 00:00:00'),
(3, 'replied', '-', 1, 1, '2019-02-02 00:00:00'),
(4, 'archive', '-', 1, 1, '2019-02-02 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_tasks`
--

CREATE TABLE `tbl_component_tasks` (
  `id` int(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `progress` int(3) NOT NULL,
  `description` text NOT NULL,
  `status_id` int(32) NOT NULL,
  `category_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_task_categories`
--

CREATE TABLE `tbl_component_task_categories` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_component_task_status`
--

CREATE TABLE `tbl_component_task_status` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_configs`
--

CREATE TABLE `tbl_configs` (
  `id` int(32) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `is_static` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_configs`
--

INSERT INTO `tbl_configs` (`id`, `keyword`, `value`, `is_static`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'app_name', 'helpdesk', 0, 1, 1, '2018-07-23 00:00:00'),
(2, 'lang_id', '28173tgfds7tf', 0, 1, 1, '2018-07-23 00:00:00'),
(3, 'lang_name', 'english', 0, 1, 1, '2018-07-23 00:00:00'),
(4, 'salt', '834red567gh4765vbfr76538', 0, 1, 1, '2018-07-23 00:00:00'),
(5, 'session_name', 'd98786tayghdjaw90d87atw', 0, 1, 1, '2018-07-23 00:00:00'),
(6, 'website_id', 'd9s8a7yudhioas987dyuhss', 0, 1, 1, '2018-07-23 00:00:00'),
(7, 'cookie_id', '90daw786tyghdjioaw987d6', 0, 1, 1, '2018-07-23 00:00:00'),
(8, 'redirect_success_login_backend', 'backend/dashboard', 0, 1, 1, '2018-07-23 00:00:00'),
(9, 'redirect_failed_login_backend', 'backend/login', 0, 1, 1, '2018-07-23 00:00:00'),
(10, 'mod_active', 'frontend', 0, 1, 1, '2018-11-04 00:00:00'),
(11, 'controller_active', 'home', 0, 1, 1, '2018-11-04 00:00:00'),
(12, 'global_title_en', 'welcome to helpdesk', 0, 1, 1, '2018-11-09 07:53:48'),
(13, 'uri_img_item_color', 'media/img/items/colors/', 0, 1, 1, '2019-01-03 09:45:11'),
(14, 'uri_img_item_brand', 'media/img/items/brands/', 0, 1, 1, '2019-01-03 09:45:41'),
(15, 'dev_status', '1', 0, 1, 1, '2019-02-01 00:00:00'),
(16, 'login_layout', '1', 0, 1, 1, '2019-03-27 00:00:00'),
(17, 'login_footer_note', '<b>Direktorat Jenderal Imigrasi &copy; 2019</b>', 0, 1, 1, '2019-09-02 00:00:00'),
(18, 'login_notification', '1', 0, 1, 1, '2019-07-12 16:18:24'),
(19, 'footer_about', ' <aside class=\"f_widget ab_widget\">\r\n                    <div class=\"f_title\">\r\n                        <h3>About Me</h3>\r\n                    </div>\r\n                    <p>If you own an Iphone, you’ve probably already worked out how much fun it is to use it to watch movies-it has that nice big screen, and the sound quality.</p>\r\n                </aside>', 1, 1, 1, '2019-02-12 00:00:00'),
(20, 'footer_newsletter', '<aside class=\"f_widget news_widget\">\r\n                    <div class=\"f_title\">\r\n                        <h3>Newsletter</h3>\r\n                    </div>\r\n                    <p>Stay updated with our latest trends</p>\r\n                    <div id=\"mc_embed_signup\">\r\n                        <form target=\"_blank\" method=\"post\" class=\"subscribes\">\r\n                            <div class=\"input-group d-flex flex-row\">\r\n                                <input name=\"EMAIL\" placeholder=\"Enter email address\" onfocus=\"this.placeholder = \'\'\" onblur=\"this.placeholder = \'Email Address \'\" required=\"\" type=\"email\">\r\n                                <button class=\"btn sub-btn\"><span class=\"lnr lnr-arrow-right\"></span></button>		\r\n                            </div>				\r\n                            <div class=\"mt-10 info\"></div>\r\n                        </form>\r\n                    </div>\r\n                </aside>', 1, 1, 1, '2019-02-12 00:00:00'),
(21, 'footer_socials', '<aside class=\"f_widget social_widget\">\r\n                    <div class=\"f_title\">\r\n                        <h3>Follow Me</h3>\r\n                    </div>\r\n                    <p>Let us be social</p>\r\n                    <ul class=\"list\">\r\n                        <li><a href=\"#\"><i class=\"fa fa-facebook\"></i></a></li>\r\n                        <li><a href=\"#\"><i class=\"fa fa-twitter\"></i></a></li>\r\n                        <li><a href=\"#\"><i class=\"fa fa-dribbble\"></i></a></li>\r\n                        <li><a href=\"#\"><i class=\"fa fa-behance\"></i></a></li>\r\n                    </ul>\r\n                </aside>', 1, 1, 1, '2019-02-12 00:00:00'),
(22, 'session_helpdesk', 'd98789iu8ghdjaw90d80po9', 0, 1, 1, '2018-07-23 00:00:00'),
(23, 'api_key', '98ufu83476yrhdge', 0, 1, 1, '2019-03-27 00:00:00'),
(24, 'api_user', 'api_09283hdjks', 0, 1, 1, '2019-03-27 00:00:00'),
(25, 'api_pass', '098eq7312&_DSA', 0, 1, 1, '2019-03-27 00:00:00'),
(26, 'copyright', '2019 © Telkom Signet', 0, 1, 1, '2019-03-27 00:00:00'),
(27, '_total_row_cache_name_', 'jshu765gdte5wgd6gsdbcsdew654rde31', 0, 1, 1, '2018-07-23 00:00:00'),
(28, '_total_row_ticket_report_by_ctg_cache_name', '23hu765gdt3ewgdtg4rbcs43w654rde3e', 0, 1, 1, '2018-07-23 00:00:00'),
(29, '_total_row_cache_name_progress', '452sw65gdte5wgd6gsdbcsdew654rde3', 0, 1, 1, '2018-07-23 00:00:00'),
(30, '_total_row_cache_name_transfer', '4r5t365gdte5wgd6gsdbcsdew654rde3w', 0, 1, 1, '2018-07-23 00:00:00'),
(31, '_total_row_cache_name_close', '23hu7634r5e5wgd6g3ew2sdew654rde3', 0, 1, 1, '2018-07-23 00:00:00'),
(32, '_total_row_cache_name_open', 'ws237634r5e5wgd6g3ew2sdew654rde3', 0, 1, 1, '2018-07-23 00:00:00'),
(33, '_total_row_ticket_report', '3e437634r54r5td6g3ew2sdew654rq21', 0, 1, 1, '2018-07-23 00:00:00'),
(34, '_total_row_cache_name_transfer_in', '4r5t363ew2e5wgd6gsd984rewol4rde3w', 0, 1, 1, '2018-07-23 00:00:00'),
(35, '_total_row_cache_name_transfer_out', '4r5t365gd3e4rgd6gsdb9ijew654rde3w', 0, 1, 1, '2018-07-23 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_configs`
--

CREATE TABLE `tbl_email_configs` (
  `id` int(32) NOT NULL,
  `protocol` varchar(255) NOT NULL,
  `host` varchar(255) NOT NULL,
  `port` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `mailtype` varchar(255) NOT NULL,
  `charset` varchar(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_email_configs`
--

INSERT INTO `tbl_email_configs` (`id`, `protocol`, `host`, `port`, `user`, `pass`, `mailtype`, `charset`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'smtp', 'smtp.gmail.com', '587', 'firman.begin@gmail.com', 'Ab1234abcd', 'html', 'iso-8859-1', 1, 1, '2019-02-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_layout`
--

CREATE TABLE `tbl_email_layout` (
  `id` int(32) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `value_eng` text NOT NULL,
  `value_ind` text NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_email_layout`
--

INSERT INTO `tbl_email_layout` (`id`, `keyword`, `value_eng`, `value_ind`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'user_activation', ' <center>[date]</center><br/>                         Pengguna yang terhormat,                         <br/>                         <br/>                         Terima kasih telah melakukan registrasi akun di pesky indosporttiming, berikut detail data akun anda :                         email       : [email]<br/>                         username    : [username]<br/>                         password    : [password]<br/>                         status      : tidak aktif<br/>                         <br/>                             Untuk aktivasi account klik <b>[activation_link]</b><br/>                         Akun yang belum di aktifkan tidak akan bisa melakukan pendaftaran event lomba atau login kedalam dashboard indosporttiming<br/>                         Mohon untuk tidak men-sharing atau berbagi pakai dengan pihak lain terhadap akun dengan data diri anda agar tidak terjadi hal - hal yang tidak di inginkan.<br/>                     ', '', '-', 1, 1, '2019-02-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_email_links`
--

CREATE TABLE `tbl_email_links` (
  `id` int(32) NOT NULL,
  `email_layout_id` int(32) NOT NULL,
  `keyword` int(255) NOT NULL,
  `value` text NOT NULL,
  `is_active` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `create_date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_groups`
--

CREATE TABLE `tbl_groups` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `level` tinyint(1) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_groups`
--

INSERT INTO `tbl_groups` (`id`, `name`, `description`, `level`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'superuser', '-', 1, 1, 1, '2019-02-25 00:00:00'),
(2, 'employee', '-', 2, 1, 1, '2019-02-12 00:00:00'),
(3, 'vendor', '-', 3, 1, 1, '2019-02-12 00:00:00'),
(4, 'monitoring', '-', 4, 1, 1, '2019-07-16 10:04:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_group_permissions`
--

CREATE TABLE `tbl_group_permissions` (
  `id` int(32) NOT NULL,
  `group_id` int(32) NOT NULL,
  `permission_id` int(32) NOT NULL,
  `is_allowed` tinyint(1) NOT NULL DEFAULT 0,
  `is_public` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_group_permissions`
--

INSERT INTO `tbl_group_permissions` (`id`, `group_id`, `permission_id`, `is_allowed`, `is_public`, `is_active`, `created_by`, `create_date`) VALUES
(1, 1, 1, 1, 1, 1, 1, '2019-05-10 00:00:00'),
(2, 1, 2, 1, 1, 1, 1, '2019-05-10 00:00:00'),
(3, 3, 3, 1, 1, 1, 1, '2019-05-10 00:00:00'),
(4, 2, 4, 1, 1, 1, 1, '2019-05-10 00:00:00'),
(5, 1, 5, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(6, 1, 6, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(7, 1, 7, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(8, 1, 8, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(9, 1, 9, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(10, 1, 10, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(11, 1, 11, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(12, 1, 12, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(13, 1, 13, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(14, 1, 14, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(15, 1, 15, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(16, 1, 16, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(17, 1, 17, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(18, 1, 18, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(19, 1, 19, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(20, 1, 20, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(21, 1, 21, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(22, 1, 22, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(23, 1, 23, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(24, 1, 24, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(25, 1, 25, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(26, 1, 26, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(27, 1, 27, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(28, 1, 28, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(29, 1, 29, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(30, 1, 30, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(31, 1, 31, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(32, 1, 32, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(33, 1, 33, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(34, 1, 34, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(35, 1, 35, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(36, 1, 36, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(37, 1, 37, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(38, 1, 38, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(39, 1, 39, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(40, 1, 40, 1, 0, 1, 1, '2019-05-13 08:54:27'),
(41, 1, 41, 1, 0, 1, 1, '2019-05-13 08:54:28'),
(42, 1, 42, 1, 0, 1, 1, '2019-05-13 08:54:28'),
(43, 1, 43, 1, 0, 1, 1, '2019-05-13 08:54:28'),
(44, 1, 44, 1, 0, 1, 1, '2019-05-13 08:54:28'),
(45, 1, 45, 1, 0, 1, 1, '2019-05-13 08:54:28'),
(46, 1, 46, 1, 0, 1, 1, '2019-05-13 08:54:28'),
(47, 1, 47, 1, 0, 1, 1, '2019-05-13 08:54:28'),
(48, 1, 48, 1, 0, 1, 1, '2019-05-13 08:58:17'),
(49, 1, 49, 1, 0, 1, 1, '2019-05-13 09:09:58'),
(50, 1, 50, 1, 0, 1, 1, '2019-05-13 09:10:27'),
(51, 1, 51, 1, 0, 1, 1, '2019-05-13 09:10:27'),
(52, 1, 52, 1, 0, 1, 1, '2019-05-13 09:10:28'),
(53, 1, 53, 1, 0, 1, 1, '2019-05-13 09:10:28'),
(54, 1, 54, 1, 0, 1, 1, '2019-05-13 09:10:28'),
(55, 1, 55, 1, 0, 1, 1, '2019-05-13 09:10:28'),
(56, 1, 56, 1, 0, 1, 1, '2019-05-13 09:10:28'),
(57, 1, 57, 1, 0, 1, 1, '2019-05-13 09:10:28'),
(58, 1, 58, 1, 0, 1, 1, '2019-05-13 09:13:12'),
(59, 1, 59, 1, 0, 1, 1, '2019-05-13 09:13:12'),
(60, 1, 60, 1, 0, 1, 1, '2019-05-13 09:13:12'),
(61, 1, 61, 1, 0, 1, 1, '2019-05-13 09:13:13'),
(62, 1, 62, 1, 0, 1, 1, '2019-05-13 09:13:13'),
(63, 1, 63, 1, 0, 1, 1, '2019-05-13 09:13:13'),
(64, 1, 64, 1, 0, 1, 1, '2019-05-13 09:13:13'),
(65, 1, 65, 1, 0, 1, 1, '2019-05-13 09:13:13'),
(66, 1, 66, 1, 0, 1, 1, '2019-05-13 09:14:38'),
(67, 1, 67, 1, 0, 1, 1, '2019-05-13 09:14:38'),
(68, 1, 68, 1, 0, 1, 1, '2019-05-13 09:14:39'),
(69, 1, 69, 1, 0, 1, 1, '2019-05-13 09:14:39'),
(70, 1, 70, 1, 0, 1, 1, '2019-05-13 09:14:39'),
(71, 1, 71, 1, 0, 1, 1, '2019-05-13 09:14:39'),
(72, 1, 72, 1, 0, 1, 1, '2019-05-13 09:14:39'),
(73, 1, 73, 1, 0, 1, 1, '2019-05-13 09:14:39'),
(74, 1, 74, 1, 0, 1, 1, '2019-05-13 10:11:50'),
(75, 1, 75, 1, 0, 1, 1, '2019-05-13 10:11:50'),
(76, 1, 76, 1, 0, 1, 1, '2019-05-13 10:11:50'),
(77, 1, 77, 1, 0, 1, 1, '2019-05-13 10:11:51'),
(78, 1, 78, 1, 0, 1, 1, '2019-05-13 10:11:51'),
(79, 1, 79, 1, 0, 1, 1, '2019-05-13 10:11:51'),
(80, 1, 80, 1, 0, 1, 1, '2019-05-13 10:11:51'),
(81, 1, 81, 1, 0, 1, 1, '2019-05-13 10:11:51'),
(82, 1, 82, 1, 0, 1, 1, '2019-05-10 00:00:00'),
(83, 1, 83, 1, 0, 1, 1, '2019-05-13 10:56:57'),
(84, 1, 84, 1, 0, 1, 1, '2019-05-13 10:56:57'),
(85, 1, 85, 1, 0, 1, 1, '2019-05-13 10:56:58'),
(86, 1, 86, 1, 0, 1, 1, '2019-05-13 10:56:58'),
(87, 1, 87, 1, 0, 1, 1, '2019-05-13 10:56:58'),
(88, 1, 88, 1, 0, 1, 1, '2019-05-13 10:56:58'),
(89, 1, 89, 1, 0, 1, 1, '2019-05-13 10:56:58'),
(90, 1, 90, 1, 0, 1, 1, '2019-05-13 10:56:58'),
(91, 1, 91, 1, 0, 1, 1, '2019-05-13 11:01:23'),
(92, 1, 92, 1, 0, 1, 1, '2019-05-13 11:01:23'),
(93, 1, 93, 1, 0, 1, 1, '2019-05-13 11:01:23'),
(94, 1, 94, 1, 0, 1, 1, '2019-05-13 11:01:23'),
(95, 1, 95, 1, 0, 1, 1, '2019-05-13 11:01:23'),
(96, 1, 96, 1, 0, 1, 1, '2019-05-13 11:01:23'),
(97, 1, 97, 1, 0, 1, 1, '2019-05-13 11:01:23'),
(98, 1, 98, 1, 0, 1, 1, '2019-05-13 11:01:23'),
(99, 1, 99, 1, 0, 1, 1, '2019-05-13 11:02:40'),
(100, 1, 100, 1, 0, 1, 1, '2019-05-13 11:04:28'),
(101, 1, 101, 1, 0, 1, 1, '2019-05-13 11:04:28'),
(102, 1, 102, 1, 0, 1, 1, '2019-05-13 11:04:28'),
(103, 1, 103, 1, 0, 1, 1, '2019-05-13 11:04:28'),
(104, 1, 104, 1, 0, 1, 1, '2019-05-13 11:04:28'),
(105, 1, 105, 1, 0, 1, 1, '2019-05-13 11:04:28'),
(106, 1, 106, 1, 0, 1, 1, '2019-05-13 11:04:29'),
(107, 1, 107, 1, 0, 1, 1, '2019-05-13 11:04:29'),
(108, 1, 108, 1, 0, 1, 1, '2019-05-13 11:35:13'),
(109, 1, 109, 1, 0, 1, 1, '2019-05-13 11:35:13'),
(110, 1, 110, 1, 0, 1, 1, '2019-05-13 11:35:13'),
(111, 1, 111, 1, 0, 1, 1, '2019-05-13 11:35:13'),
(112, 1, 112, 1, 0, 1, 1, '2019-05-13 11:35:13'),
(113, 1, 113, 1, 0, 1, 1, '2019-05-13 11:35:13'),
(114, 1, 114, 1, 0, 1, 1, '2019-05-13 11:35:13'),
(115, 1, 115, 1, 0, 1, 1, '2019-05-13 11:35:14'),
(116, 1, 116, 1, 0, 1, 1, '2019-05-13 11:41:51'),
(117, 1, 117, 1, 0, 1, 1, '2019-05-13 11:41:52'),
(118, 1, 118, 1, 0, 1, 1, '2019-05-13 11:41:52'),
(119, 1, 119, 1, 0, 1, 1, '2019-05-13 11:41:52'),
(120, 1, 120, 1, 0, 1, 1, '2019-05-13 11:41:52'),
(121, 1, 121, 1, 0, 1, 1, '2019-05-13 11:41:52'),
(122, 1, 122, 1, 0, 1, 1, '2019-05-13 11:41:52'),
(123, 1, 123, 1, 0, 1, 1, '2019-05-13 11:41:52'),
(124, 1, 124, 1, 0, 1, 1, '2019-05-13 11:43:31'),
(125, 1, 125, 1, 0, 1, 1, '2019-05-13 11:43:31'),
(126, 1, 126, 1, 0, 1, 1, '2019-05-13 11:43:31'),
(127, 1, 127, 1, 0, 1, 1, '2019-05-13 11:43:31'),
(128, 1, 128, 1, 0, 1, 1, '2019-05-13 11:43:31'),
(129, 1, 129, 1, 0, 1, 1, '2019-05-13 11:43:31'),
(130, 1, 130, 1, 0, 1, 1, '2019-05-13 11:43:31'),
(131, 1, 131, 1, 0, 1, 1, '2019-05-13 11:43:31'),
(132, 1, 132, 1, 0, 1, 1, '2019-05-13 11:45:37'),
(133, 1, 133, 1, 0, 1, 1, '2019-05-13 11:45:37'),
(134, 1, 134, 1, 0, 1, 1, '2019-05-13 11:45:38'),
(135, 1, 135, 1, 0, 1, 1, '2019-05-13 11:45:38'),
(136, 1, 136, 1, 0, 1, 1, '2019-05-13 11:45:38'),
(137, 1, 137, 1, 0, 1, 1, '2019-05-13 11:45:38'),
(138, 1, 138, 1, 0, 1, 1, '2019-05-13 11:45:38'),
(139, 1, 139, 1, 0, 1, 1, '2019-05-13 11:45:38'),
(140, 1, 140, 1, 0, 1, 1, '2019-05-13 11:51:54'),
(141, 1, 141, 1, 0, 1, 1, '2019-05-13 11:51:54'),
(142, 1, 142, 1, 0, 1, 1, '2019-05-13 11:51:54'),
(143, 1, 143, 1, 0, 1, 1, '2019-05-13 11:51:54'),
(144, 1, 144, 1, 0, 1, 1, '2019-05-13 11:51:54'),
(145, 1, 145, 1, 0, 1, 1, '2019-05-13 11:51:55'),
(146, 1, 146, 1, 0, 1, 1, '2019-05-13 11:51:55'),
(147, 1, 147, 1, 0, 1, 1, '2019-05-13 11:51:55'),
(148, 1, 148, 1, 0, 1, 1, '2019-05-13 11:53:20'),
(149, 1, 149, 1, 0, 1, 1, '2019-05-13 11:53:20'),
(150, 1, 150, 1, 0, 1, 1, '2019-05-13 11:53:20'),
(151, 1, 151, 1, 0, 1, 1, '2019-05-13 11:53:20'),
(152, 1, 152, 1, 0, 1, 1, '2019-05-13 11:53:20'),
(153, 1, 153, 1, 0, 1, 1, '2019-05-13 11:53:20'),
(154, 1, 154, 1, 0, 1, 1, '2019-05-13 11:53:21'),
(155, 1, 155, 1, 0, 1, 1, '2019-05-13 11:53:21'),
(156, 1, 156, 1, 0, 1, 1, '2019-05-13 13:16:16'),
(157, 1, 157, 1, 0, 1, 1, '2019-05-13 13:16:16'),
(158, 1, 158, 1, 0, 1, 1, '2019-05-13 13:16:16'),
(159, 1, 159, 1, 0, 1, 1, '2019-05-13 13:16:16'),
(160, 1, 160, 1, 0, 1, 1, '2019-05-13 13:16:16'),
(161, 1, 161, 1, 0, 1, 1, '2019-05-13 13:16:16'),
(162, 1, 162, 1, 0, 1, 1, '2019-05-13 13:16:16'),
(163, 1, 163, 1, 0, 1, 1, '2019-05-13 13:16:16'),
(164, 1, 164, 1, 0, 1, 1, '2019-05-13 13:20:32'),
(165, 1, 165, 1, 0, 1, 1, '2019-05-13 13:20:54'),
(166, 1, 166, 1, 0, 1, 1, '2019-05-13 13:22:16'),
(167, 1, 167, 1, 0, 1, 1, '2019-05-13 13:22:16'),
(168, 1, 168, 1, 0, 1, 1, '2019-05-13 13:22:17'),
(169, 1, 169, 1, 0, 1, 1, '2019-05-13 13:22:17'),
(170, 1, 170, 1, 0, 1, 1, '2019-05-13 13:22:17'),
(171, 1, 171, 1, 0, 1, 1, '2019-05-13 13:22:17'),
(172, 1, 172, 1, 0, 1, 1, '2019-05-13 13:22:17'),
(173, 1, 173, 1, 0, 1, 1, '2019-05-13 13:22:17'),
(174, 1, 174, 1, 0, 1, 1, '2019-05-13 13:26:11'),
(175, 1, 175, 1, 0, 1, 1, '2019-05-13 13:26:11'),
(176, 1, 176, 1, 0, 1, 1, '2019-05-13 13:26:11'),
(177, 1, 177, 1, 0, 1, 1, '2019-05-13 13:26:11'),
(178, 1, 178, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(179, 1, 179, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(180, 1, 180, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(181, 1, 181, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(182, 1, 182, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(183, 1, 183, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(184, 1, 184, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(185, 1, 185, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(186, 1, 186, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(187, 1, 187, 1, 0, 1, 1, '2019-05-13 13:26:12'),
(188, 1, 188, 1, 0, 1, 1, '2019-05-13 13:26:13'),
(189, 1, 189, 1, 0, 1, 1, '2019-05-13 13:26:13'),
(190, 1, 190, 1, 0, 1, 1, '2019-05-13 13:39:11'),
(191, 1, 191, 1, 0, 1, 1, '2019-05-13 13:39:11'),
(192, 1, 192, 1, 0, 1, 1, '2019-05-13 13:39:11'),
(193, 1, 193, 1, 0, 1, 1, '2019-05-13 13:39:11'),
(194, 1, 194, 1, 0, 1, 1, '2019-05-13 13:39:11'),
(195, 1, 195, 1, 0, 1, 1, '2019-05-13 13:39:12'),
(196, 1, 196, 1, 0, 1, 1, '2019-05-13 13:39:12'),
(197, 1, 197, 1, 0, 1, 1, '2019-05-13 13:39:12'),
(198, 1, 198, 1, 0, 1, 1, '2019-05-13 13:39:36'),
(199, 1, 199, 1, 0, 1, 1, '2019-05-13 13:40:55'),
(200, 1, 200, 1, 0, 1, 1, '2019-05-13 14:07:30'),
(201, 1, 201, 1, 0, 1, 1, '2019-05-13 14:09:34'),
(202, 1, 202, 1, 0, 1, 1, '2019-05-13 14:10:04'),
(203, 1, 203, 1, 0, 1, 1, '2019-05-14 14:48:37'),
(204, 3, 204, 1, 0, 1, 1, '2019-05-14 15:11:09'),
(205, 1, 205, 1, 0, 1, 1, '2019-05-14 15:56:27'),
(207, 1, 207, 1, 0, 1, 1, '2019-05-14 16:34:56'),
(208, 1, 208, 1, 0, 1, 1, '2019-05-14 16:51:13'),
(209, 2, 209, 1, 0, 1, 1, '2019-05-15 07:28:41'),
(210, 2, 210, 1, 0, 1, 1, '2019-05-15 07:28:41'),
(211, 2, 211, 1, 0, 1, 1, '2019-05-15 07:28:41'),
(212, 2, 212, 1, 0, 1, 1, '2019-05-15 07:28:41'),
(213, 2, 213, 1, 0, 1, 1, '2019-05-15 07:28:41'),
(214, 2, 214, 1, 0, 1, 1, '2019-05-15 07:28:41'),
(215, 2, 215, 1, 0, 1, 1, '2019-05-15 07:28:41'),
(216, 2, 216, 1, 0, 1, 1, '2019-05-15 07:28:42'),
(217, 2, 217, 1, 0, 1, 1, '2019-05-15 07:29:31'),
(218, 2, 218, 1, 0, 1, 1, '2019-05-15 07:33:06'),
(219, 2, 219, 1, 0, 1, 1, '2019-05-15 07:34:19'),
(221, 2, 221, 1, 0, 1, 1, '2019-05-15 07:39:49'),
(222, 2, 222, 1, 0, 1, 1, '2019-05-15 07:40:13'),
(223, 2, 223, 1, 0, 1, 1, '2019-05-15 07:41:31'),
(224, 3, 224, 1, 0, 1, 1, '2019-05-15 08:01:15'),
(225, 3, 225, 1, 0, 1, 1, '2019-05-15 08:03:04'),
(226, 3, 226, 1, 0, 1, 1, '2019-05-15 08:03:24'),
(227, 3, 227, 1, 0, 1, 1, '2019-05-15 08:03:54'),
(228, 3, 228, 1, 0, 1, 1, '2019-05-15 08:04:13'),
(229, 3, 229, 1, 0, 1, 1, '2019-05-15 08:04:33'),
(230, 3, 230, 1, 0, 1, 1, '2019-05-15 08:07:27'),
(231, 3, 231, 1, 0, 1, 1, '2019-05-15 08:43:46'),
(232, 3, 232, 1, 0, 1, 1, '2019-05-15 08:44:09'),
(233, 1, 233, 1, 0, 1, 1, '2019-05-16 10:41:04'),
(234, 1, 234, 1, 0, 1, 1, '2019-05-16 10:41:23'),
(235, 1, 235, 1, 0, 1, 1, '2019-05-16 10:41:56'),
(236, 1, 236, 1, 0, 1, 1, '2019-05-16 10:42:14'),
(237, 1, 237, 1, 0, 1, 1, '2019-05-16 13:30:22'),
(238, 1, 238, 1, 0, 1, 1, '2019-05-16 13:30:23'),
(239, 1, 239, 1, 0, 1, 1, '2019-05-16 13:30:23'),
(240, 1, 240, 1, 0, 1, 1, '2019-05-16 13:30:23'),
(241, 1, 241, 1, 0, 1, 1, '2019-05-16 13:30:23'),
(242, 1, 242, 1, 0, 1, 1, '2019-05-16 13:30:23'),
(243, 1, 243, 1, 0, 1, 1, '2019-05-16 13:30:23'),
(244, 1, 244, 1, 0, 1, 1, '2019-05-16 13:30:23'),
(245, 3, 245, 1, 0, 1, 1, '2019-05-16 15:04:20'),
(246, 3, 246, 1, 0, 1, 1, '2019-05-16 15:04:20'),
(247, 3, 247, 1, 0, 1, 1, '2019-05-16 15:04:20'),
(248, 3, 248, 1, 0, 1, 1, '2019-05-16 15:04:20'),
(249, 3, 249, 1, 0, 1, 1, '2019-05-16 15:04:20'),
(250, 3, 250, 1, 0, 1, 1, '2019-05-16 15:04:20'),
(251, 3, 251, 1, 0, 1, 1, '2019-05-16 15:04:20'),
(252, 3, 252, 1, 0, 1, 1, '2019-05-16 15:04:20'),
(253, 3, 253, 1, 0, 1, 1, '2019-05-16 15:04:56'),
(254, 3, 254, 1, 0, 1, 1, '2019-05-16 15:05:19'),
(255, 3, 255, 1, 0, 1, 1, '2019-05-16 15:05:34'),
(256, 1, 256, 1, 0, 1, 1, '2019-05-20 08:49:44'),
(257, 1, 257, 1, 0, 1, 1, '2019-05-20 13:13:22'),
(258, 1, 258, 1, 0, 1, 1, '2019-05-21 08:04:43'),
(259, 3, 259, 1, 0, 1, 1, '2019-05-21 11:09:07'),
(260, 3, 260, 1, 0, 1, 1, '2019-05-21 13:47:02'),
(261, 3, 261, 1, 0, 1, 1, '2019-05-21 14:10:08'),
(262, 1, 262, 1, 0, 1, 1, '2019-05-23 11:09:45'),
(263, 1, 263, 1, 0, 1, 1, '2019-05-23 13:39:02'),
(264, 3, 264, 1, 0, 1, 1, '2019-05-24 08:40:34'),
(265, 3, 265, 1, 0, 1, 1, '2019-05-24 08:43:26'),
(266, 3, 266, 1, 0, 1, 1, '2019-05-24 08:43:26'),
(267, 3, 267, 1, 0, 1, 1, '2019-05-24 08:43:26'),
(268, 3, 268, 1, 0, 1, 1, '2019-05-24 08:43:26'),
(269, 3, 269, 1, 0, 1, 1, '2019-05-24 08:43:26'),
(270, 3, 270, 1, 0, 1, 1, '2019-05-24 08:43:26'),
(271, 3, 271, 1, 0, 1, 1, '2019-05-24 08:43:26'),
(272, 3, 272, 1, 0, 1, 1, '2019-05-24 08:43:26'),
(273, 3, 273, 1, 0, 1, 1, '2019-05-24 08:46:58'),
(274, 3, 274, 1, 0, 1, 1, '2019-05-24 08:47:32'),
(275, 2, 275, 1, 0, 1, 1, '2019-05-24 10:03:41'),
(276, 2, 276, 1, 0, 1, 1, '2019-05-24 10:03:41'),
(277, 2, 277, 1, 0, 1, 1, '2019-05-24 10:03:41'),
(278, 2, 278, 1, 0, 1, 1, '2019-05-24 10:03:41'),
(279, 2, 279, 1, 0, 1, 1, '2019-05-24 10:03:41'),
(280, 2, 280, 1, 0, 1, 1, '2019-05-24 10:03:41'),
(281, 2, 281, 1, 0, 1, 1, '2019-05-24 10:03:41'),
(282, 2, 282, 1, 0, 1, 1, '2019-05-24 10:03:41'),
(291, 2, 291, 1, 0, 1, 1, '2019-05-24 10:07:00'),
(292, 2, 292, 1, 0, 1, 1, '2019-05-24 10:15:07'),
(293, 2, 293, 1, 0, 1, 1, '2019-05-24 10:15:32'),
(294, 1, 294, 1, 0, 1, 6, '2019-05-27 08:15:19'),
(295, 1, 295, 1, 0, 1, 6, '2019-05-27 08:50:02'),
(296, 2, 296, 1, 0, 1, 6, '2019-05-27 10:43:26'),
(297, 1, 297, 1, 0, 1, 1, '2019-05-27 12:47:57'),
(298, 3, 298, 1, 0, 1, 1, '2019-05-27 13:30:24'),
(299, 2, 299, 1, 0, 1, 1, '2019-05-27 13:51:44'),
(300, 3, 300, 1, 0, 1, 1, '2019-05-27 14:07:28'),
(301, 3, 301, 1, 0, 1, 1, '2019-05-27 15:06:16'),
(302, 1, 302, 1, 0, 1, 1, '2019-05-28 13:31:10'),
(303, 1, 303, 1, 0, 1, 1, '2019-05-28 13:31:11'),
(304, 1, 304, 1, 0, 1, 1, '2019-05-28 13:31:11'),
(305, 1, 305, 1, 0, 1, 1, '2019-05-28 13:31:11'),
(306, 1, 306, 1, 0, 1, 1, '2019-05-28 13:31:11'),
(307, 1, 307, 1, 0, 1, 1, '2019-05-28 13:31:11'),
(308, 1, 308, 1, 0, 1, 1, '2019-05-28 13:31:11'),
(309, 1, 309, 1, 0, 1, 1, '2019-05-28 13:31:11'),
(310, 1, 310, 1, 0, 1, 1, '2019-05-29 11:12:45'),
(311, 1, 311, 1, 0, 1, 1, '2019-06-10 14:09:48'),
(312, 1, 312, 1, 0, 1, 1, '2019-06-10 17:02:51'),
(313, 2, 313, 1, 0, 1, 1, '2019-06-24 13:39:54'),
(314, 3, 314, 1, 0, 1, 1, '2019-06-26 17:04:48'),
(315, 3, 315, 1, 0, 1, 1, '2019-06-28 16:48:20'),
(316, 2, 316, 1, 0, 1, 1, '2019-07-01 10:30:08'),
(317, 2, 317, 1, 0, 1, 1, '2019-07-01 10:33:30'),
(318, 1, 318, 1, 0, 1, 1, '2019-07-01 15:14:24'),
(319, 2, 319, 1, 0, 1, 1, '2019-07-02 09:09:54'),
(320, 3, 320, 1, 0, 1, 1, '2019-07-03 08:54:06'),
(321, 1, 321, 1, 0, 1, 1, '2019-07-03 10:09:58'),
(322, 1, 322, 1, 0, 1, 1, '2019-07-04 10:00:11'),
(323, 1, 323, 1, 0, 1, 1, '2019-07-04 10:00:11'),
(324, 1, 324, 1, 0, 1, 1, '2019-07-04 10:00:11'),
(325, 1, 325, 1, 0, 1, 1, '2019-07-04 10:00:11'),
(326, 1, 326, 1, 0, 1, 1, '2019-07-04 10:00:11'),
(327, 1, 327, 1, 0, 1, 1, '2019-07-04 10:00:11'),
(328, 1, 328, 1, 0, 1, 1, '2019-07-04 10:00:11'),
(329, 1, 329, 1, 0, 1, 1, '2019-07-04 10:00:11'),
(330, 1, 330, 1, 0, 1, 1, '2019-07-05 09:42:07'),
(331, 1, 331, 1, 0, 1, 1, '2019-07-05 09:42:07'),
(332, 1, 332, 1, 0, 1, 1, '2019-07-05 09:42:07'),
(333, 1, 333, 1, 0, 1, 1, '2019-07-05 09:42:07'),
(334, 1, 334, 1, 0, 1, 1, '2019-07-05 09:42:08'),
(335, 1, 335, 1, 0, 1, 1, '2019-07-05 09:42:08'),
(336, 1, 336, 1, 0, 1, 1, '2019-07-05 09:42:08'),
(337, 1, 337, 1, 0, 1, 1, '2019-07-05 09:42:08'),
(338, 2, 338, 1, 0, 1, 1, '2019-07-08 16:53:28'),
(339, 3, 339, 1, 0, 1, 1, '2019-07-08 17:36:24'),
(340, 1, 340, 1, 0, 1, 1, '2019-07-08 18:26:18'),
(341, 1, 341, 1, 0, 1, 1, '2019-07-11 09:33:48'),
(342, 1, 342, 1, 0, 1, 1, '2019-07-12 16:16:16'),
(343, 1, 343, 1, 0, 1, 1, '2019-07-12 16:16:16'),
(344, 1, 344, 1, 0, 1, 1, '2019-07-12 16:16:17'),
(345, 1, 345, 1, 0, 1, 1, '2019-07-12 16:16:17'),
(346, 1, 346, 1, 0, 1, 1, '2019-07-12 16:16:17'),
(347, 1, 347, 1, 0, 1, 1, '2019-07-12 16:16:17'),
(348, 1, 348, 1, 0, 1, 1, '2019-07-12 16:16:17'),
(349, 1, 349, 1, 0, 1, 1, '2019-07-12 16:16:17'),
(351, 2, 351, 1, 0, 1, 1, '2019-07-15 09:54:19'),
(352, 2, 352, 1, 0, 1, 1, '2019-07-15 17:02:41'),
(353, 1, 353, 1, 0, 1, 1, '2019-07-15 17:03:01'),
(354, 3, 354, 1, 0, 1, 1, '2019-07-15 17:03:28'),
(355, 1, 355, 1, 0, 1, 1, '2019-07-15 21:51:02'),
(358, 1, 358, 1, 0, 1, 1, '2019-07-16 09:14:39'),
(359, 1, 359, 1, 0, 1, 1, '2019-07-16 09:14:39'),
(360, 1, 360, 1, 0, 1, 1, '2019-07-16 09:14:39'),
(361, 1, 361, 1, 0, 1, 1, '2019-07-16 09:14:39'),
(362, 1, 362, 1, 0, 1, 1, '2019-07-16 09:14:39'),
(363, 1, 363, 1, 0, 1, 1, '2019-07-16 09:14:39'),
(364, 1, 364, 1, 0, 1, 1, '2019-07-16 09:14:39'),
(365, 1, 365, 1, 0, 1, 1, '2019-07-16 09:14:40'),
(366, 1, 366, 1, 0, 1, 1, '2019-07-16 10:26:15'),
(367, 1, 367, 1, 0, 1, 1, '2019-07-16 10:26:15'),
(368, 1, 368, 1, 0, 1, 1, '2019-07-16 10:26:15'),
(369, 1, 369, 1, 0, 1, 1, '2019-07-16 10:26:15'),
(370, 1, 370, 1, 0, 1, 1, '2019-07-16 10:26:15'),
(371, 1, 371, 1, 0, 1, 1, '2019-07-16 10:26:16'),
(372, 1, 372, 1, 0, 1, 1, '2019-07-16 10:26:16'),
(373, 1, 373, 1, 0, 1, 1, '2019-07-16 10:26:16'),
(374, 4, 374, 1, 0, 1, 1, '2019-07-17 08:48:34'),
(375, 4, 375, 1, 0, 1, 1, '2019-07-17 08:48:34'),
(376, 4, 376, 1, 0, 1, 1, '2019-07-17 08:48:34'),
(377, 4, 377, 1, 0, 1, 1, '2019-07-17 08:48:35'),
(378, 4, 378, 1, 0, 1, 1, '2019-07-17 08:48:35'),
(379, 4, 379, 1, 0, 1, 1, '2019-07-17 08:48:35'),
(380, 4, 380, 1, 0, 1, 1, '2019-07-17 08:48:35'),
(381, 4, 381, 1, 0, 1, 1, '2019-07-17 08:48:35'),
(382, 4, 382, 1, 0, 1, 1, '2019-07-17 08:54:27'),
(383, 2, 383, 1, 0, 1, 1, '2019-07-17 16:22:32'),
(384, 3, 384, 1, 0, 1, 1, '2019-07-17 16:22:50'),
(385, 1, 385, 1, 0, 1, 1, '2019-07-17 16:23:10'),
(386, 2, 386, 1, 0, 1, 1, '2019-07-17 16:25:23'),
(387, 2, 387, 1, 1, 1, 1, '2019-07-18 10:42:57'),
(388, 3, 388, 1, 0, 1, 1, '2019-07-22 15:18:12'),
(390, 4, 390, 1, 0, 1, 1, '2019-07-23 08:23:38'),
(391, 4, 391, 1, 0, 1, 1, '2019-07-23 08:23:38'),
(392, 4, 392, 1, 0, 1, 1, '2019-07-23 08:23:38'),
(393, 2, 393, 1, 0, 1, 1, '2019-07-25 10:36:05'),
(394, 3, 394, 1, 0, 1, 1, '2019-07-25 14:19:24'),
(395, 3, 395, 1, 0, 1, 1, '2019-07-25 14:31:31'),
(396, 1, 396, 1, 0, 1, 1, '2019-07-25 15:09:18'),
(397, 2, 397, 1, 0, 1, 1, '2019-07-28 18:54:20'),
(398, 3, 398, 1, 0, 1, 1, '2019-07-28 21:48:55'),
(399, 3, 399, 1, 0, 1, 1, '2019-07-28 21:56:58'),
(400, 1, 400, 1, 0, 1, 1, '2019-07-29 07:24:12'),
(401, 1, 401, 1, 0, 1, 1, '2019-08-01 17:34:28'),
(402, 1, 402, 1, 0, 1, 1, '2019-08-01 17:37:18'),
(403, 1, 403, 1, 0, 1, 1, '2019-08-02 08:00:42'),
(404, 1, 404, 1, 0, 1, 1, '2019-08-02 14:28:28'),
(405, 1, 405, 1, 0, 1, 1, '2019-08-02 15:00:54'),
(406, 1, 406, 1, 0, 1, 1, '2019-08-05 08:39:17'),
(407, 1, 407, 1, 0, 1, 1, '2019-08-05 08:39:40'),
(408, 1, 408, 1, 0, 1, 1, '2019-08-05 08:39:58'),
(409, 1, 409, 1, 0, 1, 1, '2019-08-07 09:26:10'),
(410, 1, 410, 1, 0, 1, 1, '2019-08-07 09:46:12'),
(411, 1, 411, 1, 0, 1, 1, '2019-08-08 15:07:32'),
(412, 3, 412, 1, 0, 1, 1, '2019-08-12 11:50:33'),
(413, 2, 413, 1, 0, 1, 1, '2019-08-14 09:56:07'),
(414, 4, 414, 1, 0, 1, 1, '2019-08-19 13:35:00'),
(415, 1, 415, 1, 0, 1, 1, '2019-08-23 11:29:41'),
(416, 3, 416, 1, 0, 1, 9, '2019-08-26 11:20:04'),
(417, 3, 417, 1, 0, 1, 1, '2019-09-02 17:28:06'),
(418, 1, 418, 1, 0, 1, 9, '2019-09-03 19:44:10'),
(419, 4, 419, 1, 0, 1, 1, '2019-09-04 09:37:22'),
(420, 3, 420, 1, 0, 1, 1, '2019-09-09 13:08:24'),
(421, 3, 421, 1, 0, 1, 1, '2019-09-09 13:26:49'),
(422, 1, 422, 1, 0, 1, 1, '2019-09-12 16:58:00'),
(423, 3, 423, 1, 0, 1, 1, '2019-09-12 17:11:48'),
(424, 3, 424, 1, 0, 1, 1, '2019-09-12 17:11:48'),
(425, 3, 425, 1, 0, 1, 1, '2019-09-12 17:11:48'),
(426, 3, 426, 1, 0, 1, 1, '2019-09-12 17:11:48'),
(427, 3, 427, 1, 0, 1, 1, '2019-09-12 17:11:48'),
(428, 3, 428, 1, 0, 1, 1, '2019-09-12 17:11:48'),
(429, 3, 429, 1, 0, 1, 1, '2019-09-12 17:11:48'),
(430, 3, 430, 1, 0, 1, 1, '2019-09-12 17:11:48'),
(431, 3, 431, 1, 0, 1, 1, '2019-09-12 17:12:11'),
(432, 3, 432, 1, 0, 1, 1, '2019-09-12 17:12:28'),
(433, 3, 433, 1, 0, 1, 1, '2019-09-13 10:06:44'),
(434, 1, 434, 1, 0, 1, 1, '2019-09-13 10:14:18'),
(435, 1, 435, 1, 0, 1, 1, '2019-09-13 10:14:18'),
(436, 1, 436, 1, 0, 1, 1, '2019-09-13 10:14:18'),
(437, 1, 437, 1, 0, 1, 1, '2019-09-13 10:14:18'),
(438, 1, 438, 1, 0, 1, 1, '2019-09-13 10:14:18'),
(439, 1, 439, 1, 0, 1, 1, '2019-09-13 10:14:18'),
(440, 1, 440, 1, 0, 1, 1, '2019-09-13 10:14:18'),
(441, 1, 441, 1, 0, 1, 1, '2019-09-13 10:14:18'),
(442, 1, 442, 1, 0, 1, 1, '2019-09-13 10:14:41'),
(443, 1, 443, 1, 0, 1, 1, '2019-09-13 10:14:59'),
(444, 1, 444, 1, 0, 1, 1, '2019-09-13 10:15:19'),
(445, 1, 445, 1, 0, 1, 2, '2019-09-16 13:34:22'),
(446, 1, 446, 1, 0, 1, 1, '2019-09-23 11:39:21'),
(447, 1, 447, 1, 0, 1, 1, '2019-09-23 11:39:21'),
(448, 1, 448, 1, 0, 1, 1, '2019-09-23 11:39:21'),
(449, 1, 449, 1, 0, 1, 1, '2019-09-23 11:39:21'),
(450, 1, 450, 1, 0, 1, 1, '2019-09-23 11:40:06'),
(451, 1, 451, 1, 0, 1, 1, '2019-09-23 11:40:06'),
(452, 1, 452, 1, 0, 1, 1, '2019-09-23 11:40:06'),
(453, 1, 453, 1, 0, 1, 1, '2019-09-23 11:40:07'),
(454, 1, 454, 1, 0, 1, 1, '2019-09-23 11:40:41'),
(455, 1, 455, 1, 0, 1, 1, '2019-09-23 11:40:41'),
(456, 1, 456, 1, 0, 1, 1, '2019-09-23 11:40:41'),
(457, 1, 457, 1, 0, 1, 1, '2019-09-23 11:40:41'),
(458, 1, 458, 1, 0, 1, 1, '2019-09-23 11:41:21'),
(459, 1, 459, 1, 0, 1, 1, '2019-09-23 11:41:44'),
(461, 1, 461, 1, 0, 1, 1, '2019-09-23 13:11:41'),
(462, 1, 462, 1, 0, 1, 1, '2019-09-23 13:11:58'),
(463, 1, 463, 1, 0, 1, 1, '2019-09-23 13:49:16'),
(464, 1, 464, 1, 0, 1, 1, '2019-09-24 11:42:37'),
(465, 1, 465, 1, 0, 1, 1, '2019-10-02 13:55:09'),
(466, 3, 466, 1, 0, 1, 1, '2019-10-03 09:57:17'),
(467, 1, 467, 1, 0, 1, 1, '2019-10-04 11:31:41'),
(468, 1, 468, 1, 0, 1, 1, '2019-10-04 11:31:59'),
(469, 1, 469, 1, 0, 1, 1, '2019-10-04 11:32:19'),
(470, 1, 470, 1, 0, 1, 1, '2019-10-04 11:32:56'),
(471, 1, 471, 1, 0, 1, 1, '2019-10-14 14:36:29'),
(472, 1, 472, 1, 0, 1, 1, '2019-10-14 14:40:15'),
(473, 1, 473, 1, 0, 1, 1, '2019-10-14 14:50:14'),
(474, 1, 474, 1, 0, 1, 1, '2019-10-14 14:50:15'),
(475, 1, 475, 1, 0, 1, 1, '2019-10-14 14:50:15'),
(476, 1, 476, 1, 0, 1, 1, '2019-10-14 14:50:15'),
(477, 1, 477, 1, 0, 1, 1, '2019-10-14 14:50:15'),
(478, 1, 478, 1, 0, 1, 1, '2019-10-14 14:50:15'),
(479, 1, 479, 1, 0, 1, 1, '2019-10-14 14:50:16'),
(480, 1, 480, 1, 0, 1, 1, '2019-10-14 14:50:16'),
(481, 1, 481, 1, 0, 1, 1, '2019-10-22 11:26:14'),
(482, 1, 482, 1, 0, 1, 1, '2019-10-22 16:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_activities`
--

CREATE TABLE `tbl_helpdesk_activities` (
  `id` int(32) NOT NULL,
  `ticket_id` int(32) NOT NULL,
  `response_time_start` datetime NOT NULL,
  `response_time_stop` datetime NOT NULL,
  `transfer_time_start` datetime NOT NULL,
  `transfer_time_stop` datetime NOT NULL,
  `solving_time_start` datetime NOT NULL,
  `solving_time_stop` datetime NOT NULL,
  `open_time` datetime NOT NULL,
  `close_message` text NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_activities`
--

INSERT INTO `tbl_helpdesk_activities` (`id`, `ticket_id`, `response_time_start`, `response_time_stop`, `transfer_time_start`, `transfer_time_stop`, `solving_time_start`, `solving_time_stop`, `open_time`, `close_message`, `is_open`, `is_active`, `created_by`, `create_date`) VALUES
(1, 4, '2019-10-22 10:36:57', '2019-10-22 11:22:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2019-10-22 11:22:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2019-10-22 11:22:13'),
(2, 1, '2019-10-22 13:41:05', '2019-10-22 13:45:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '2019-10-22 13:45:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 6, '2019-10-22 13:45:19'),
(3, 2, '2019-10-22 17:23:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2019-10-22 17:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_contracts`
--

CREATE TABLE `tbl_helpdesk_contracts` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `expired_date` datetime NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_contracts`
--

INSERT INTO `tbl_helpdesk_contracts` (`id`, `name`, `file_path`, `description`, `expired_date`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'VISA/E-OFFICE/IZIN TINGGAL', '#', '-', '2020-01-01 00:00:00', 1, 1, '2019-04-21 00:00:00'),
(2, 'VISA/E-OFFICE/IZIN TINGGAL', '#', '-', '2020-01-01 00:00:00', 1, 1, '2019-04-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_employees`
--

CREATE TABLE `tbl_helpdesk_employees` (
  `id` int(32) NOT NULL,
  `nik` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_employees`
--

INSERT INTO `tbl_helpdesk_employees` (`id`, `nik`, `name`, `email`, `phone_number`, `is_active`, `created_by`, `create_date`) VALUES
(1, '20190906023000001', 'kanim jakpus', 'kanim.jakpus@imigrasi.go.id', '0867218387123', 1, 1, '2019-09-07 20:03:09'),
(2, '20190906023000002', 'kanim jaksel', 'kanim.jaksel@imigrasi.go.id', '0867218387123', 1, 1, '2019-09-07 20:04:51'),
(3, '20190906023000003', 'kanim jakut', 'kanim.jakut@imigrasi.go.id', '0867218387123', 1, 1, '2019-09-07 20:06:37'),
(4, '20190906023000023', 'monitoring', 'monitoring@imigrasi.go.id', '0867218387123', 1, 1, '2019-09-12 17:04:15'),
(5, '20190906023000004', 'kanim jakbar', 'kanim.jakbar@imigrasi.go.id', '0867218387123', 1, 1, '2019-09-17 14:46:30'),
(6, '20190906023000005', 'kanim jaktim', 'kanim.jaktim@imigaris.go.id', '0867218387123', 1, 1, '2019-09-17 14:51:41'),
(7, '20190906023000005', 'kanim ambon', 'kanim.ambon@imigrasi.go.id', '0867218387123', 1, 1, '2019-09-17 14:59:26'),
(8, '20190906023000006', 'kanim balikpapan', 'kanim.balikpapan@imigrasi.go.id', '0867218387123', 1, 1, '2019-09-17 16:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_employee_monitors`
--

CREATE TABLE `tbl_helpdesk_employee_monitors` (
  `id` int(32) NOT NULL,
  `employee_id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `branch_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_employee_monitors`
--

INSERT INTO `tbl_helpdesk_employee_monitors` (`id`, `employee_id`, `user_id`, `branch_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, 4, 14, 155, 1, 1, '2019-09-12 17:04:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_employee_users`
--

CREATE TABLE `tbl_helpdesk_employee_users` (
  `id` int(32) NOT NULL,
  `employee_id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `branch_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_employee_users`
--

INSERT INTO `tbl_helpdesk_employee_users` (`id`, `employee_id`, `user_id`, `branch_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, 1, 3, 32, 1, 1, '2019-09-07 20:03:09'),
(2, 2, 4, 33, 1, 1, '2019-09-07 20:04:51'),
(3, 3, 5, 34, 1, 1, '2019-09-07 20:06:37'),
(4, 5, 15, 30, 1, 1, '2019-09-17 14:46:30'),
(5, 6, 16, 31, 1, 1, '2019-09-17 14:51:41'),
(6, 7, 17, 87, 1, 1, '2019-09-17 14:59:26'),
(7, 8, 18, 78, 1, 1, '2019-09-17 16:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_imigration_branchs`
--

CREATE TABLE `tbl_helpdesk_imigration_branchs` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(255) NOT NULL,
  `zip_code` varchar(12) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `fax_number` varchar(16) NOT NULL,
  `type` varchar(6) NOT NULL,
  `parent_id` int(32) NOT NULL,
  `level` int(4) NOT NULL,
  `lat` varchar(32) NOT NULL,
  `lng` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL DEFAULT 1,
  `create_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_imigration_branchs`
--

INSERT INTO `tbl_helpdesk_imigration_branchs` (`id`, `code`, `name`, `address`, `email`, `zip_code`, `phone_number`, `fax_number`, `type`, `parent_id`, `level`, `lat`, `lng`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'TB', 'KANTOR IMIGRASI KELAS II LHOKSEUMAWE', 'JL. PELABUHAN NO.05', 'email@email.com', '', '(0645)-43039', '', 'KANIM', 128, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(2, 'TC', 'KANTOR IMIGRASI KELAS I BANDA ACEH', 'JL. TEUKU NYAK ARIEF NO. 18 ', '', '', '(0651)-23784', '', '-- sel', 128, 3, '5.550039', '95.319786', '', 1, 1, '2019-04-15 13:25:47'),
(3, 'TD', 'KANTOR IMIGRASI KELAS II LANGSA', 'JL. JEND. A. YANI NO. 2A', '', '', '(0641)21794', '(0641)21794', 'KANIM', 128, 3, '4.466561', '97.975388', '', 1, 1, '2019-04-15 13:25:47'),
(4, 'TE', 'KANTOR IMIGRASI KELAS II MEULABOH', 'JL. MERDEKA NO. 4', '', '', '(0655)21496', '', 'KANIM', 128, 3, '4.145776', '96.124878', '', 1, 1, '2019-04-15 13:25:47'),
(5, 'TF', 'KANTOR IMIGRASI KELAS II SABANG', 'JL. TEUKU UMAR NO.10', '', '', '(0652)21343', '', 'KANIM', 128, 3, '5.894682', '95.316718', '', 1, 1, '2019-04-15 13:25:47'),
(6, 'G1', 'KANTOR IMIGRASI KELAS I POLONIA', 'Jl. MANGKUBUMI NO. 2', '', '', '(061)4533117', '(061)4558488', 'KANIM', 141, 3, '3.584717', '98.67907', '', 1, 1, '2019-04-15 13:25:47'),
(7, 'G2', 'KANTOR IMIGRASI KELAS II BELAWAN', 'JL. SERMA HANAFIAH NO. 1', '', '20412', '(061)6941008', '(061)6941754', 'KANIM', 141, 3, '3.784867', '98.682311', '', 1, 1, '2019-04-15 13:25:47'),
(8, 'G3', 'KANTOR IMIGRASI KELAS II SIBOLGA', 'JL. SISINGAMANGARAJA NO. 435', '', '', '(0361)22929', '(0361)21714', 'KANIM', 141, 3, '1.734459', '98.789063', '', 1, 1, '2019-04-15 13:25:47'),
(9, 'GB', 'KANTOR IMIGRASI KELAS II PEMATANG SIANTAR', 'JL. RAYA MEDAN KM. 11,5', '', '', '(0622)465018', '(0622)645015', 'KANIM', 141, 3, '2.967213', '99.07578', '', 1, 1, '2019-04-15 13:25:47'),
(10, 'GC', 'KANTOR IMIGRASI KELAS II TANJUNG BALAI ASAHAN', 'JL. JEND. SUDIRMAN KM 4,5', '', '21369', '(0623)92220', '(0623)92078', 'KANIM', 141, 3, '2.96927', '99.799805', '', 1, 1, '2019-04-15 13:25:47'),
(11, 'GD', 'KANTOR IMIGRASI KELAS I KHUSUS MEDAN', 'JL. GATOT SUBROTO KM 6,2 NO. 268 A', '', '20123', '	061-8452112, 82', '	061-8455941 ', 'KANIM', 141, 3, '3.592319', '98.646841', '', 1, 1, '2019-04-15 13:25:47'),
(12, 'QB', 'KANTOR IMIGRASI KELAS I PADANG', 'JL. KHOTIB SULAIMAN KEL. BELANTI TIMUR ', '', '', '	0751-55113 ', '	0751-41900 ', 'KANIM', 139, 3, '-0.914273', '100.358348', '', 1, 1, '2019-04-15 13:25:47'),
(13, 'QC', 'KANTOR IMIGRASI KELAS II BUKIT TINGGI', 'JL. PERWIRA UJUNG NO. 1', '', '', '	(0752) 21301, 4', '', 'KANIM', 139, 3, '-0.299462', '100.372639', '', 1, 1, '2019-04-15 13:25:47'),
(14, 'BE', 'KANTOR IMIGRASI KELAS II BAGAN SIAPI-API', 'JL. GEDUNG NASIONAL NO. 78', '', '', '	0767-21472 ', '	0767-21160 ', 'KANIM', 133, 3, '2.166537', '100.81501', '', 1, 1, '2019-04-15 13:25:47'),
(15, 'BF', 'KANTOR IMIGRASI KELAS II BENGKALIS', 'JL. A. YANI NO. 004', '', '28712', '	0766-21021, 231', '	0766-21022 ', 'KANIM', 133, 3, '101.447668', '102.250271', '', 1, 1, '2019-04-15 13:25:47'),
(16, 'BG', 'KANTOR IMIGRASI KELAS II DUMAI', 'JL. YOS SOEDARSO NO. 2', '', '28814', '	(0765) 31280, 3', '	(0765) 34898 ', 'KANIM', 133, 3, '1.667369', '101.447668', '', 1, 1, '2019-04-15 13:25:47'),
(17, 'BH', 'KANTOR IMIGRASI KELAS II TEMBILAHAN', 'JL. PRAJA SAKTI NO. 03', '', '', '	0282-533335, 53', '0282-533375', 'KANIM', 133, 3, '-0.34478', '103.169003', '', 1, 1, '2019-04-15 13:25:47'),
(18, 'BJ', 'KANTOR IMIGRASI KELAS II SELAT PANJANG', 'JL. MERDEKA NO. 150', '', '', '(0763) 31018, 31', '	(0763) 33818', 'KANIM', 133, 3, '0.990437', '102.702547', '', 1, 1, '2019-04-15 13:25:47'),
(19, 'BL', 'KANTOR IMIGRASI KELAS I PEKANBARU', 'JL. TERATAI MODERATOR NO. 87 ', '', '', '0761-21536 ', '	0761-40393 ', 'KANIM', 133, 3, '0.523388', '101.44033', '', 1, 1, '2019-04-15 13:25:47'),
(20, 'BN', 'KANTOR IMIGRASI KELAS II SIAK', 'JL. SULTAN ISMAIL NO. 130', '', '', '(0764) 320899 ', '	(0764) 320799 ', 'KANIM', 133, 3, '0.721045', '102.046123', '', 1, 1, '2019-04-15 13:25:47'),
(21, 'UA', 'KANTOR IMIGRASI KELAS I JAMBI', 'JL. ARIF RACHMAN HAKIM NO.63', '', '36124', '	0741-62033, 622', '0741-61383 ', 'KANIM', 116, 3, '-1.482302', '102.438412', '', 1, 1, '2019-04-15 13:25:47'),
(22, 'UC', 'KANTOR IMIGRASI KELAS II KUALA TUNGKAL', 'JL. A. MAJID BRANGAS', '', '', '	0742-21468 ', '0742-21824 ', 'KANIM', 116, 3, '-1.013951', '104.366512', '', 1, 1, '2019-04-15 13:25:47'),
(23, 'HC', 'KANTOR IMIGRASI KELAS I PALEMBANG', 'JL. PANGERAN RATU NO. 1', '', '', '	0711-321375', '	0711-710055 ', 'KANIM', 140, 3, '-3.018598', '104.774208', '', 1, 1, '2019-04-15 13:25:47'),
(24, 'HE', 'KANTOR IMIGRASI KELAS II MUARA ENIM', 'JL. JEND. SUDIRMAN NO.152', '', '', '	(0734) 421148, ', '	(0734) 421666 ', 'KANIM', 140, 3, '-3.637762', '103.781319', '', 1, 1, '2019-04-15 13:25:47'),
(25, '4A', 'KANTOR IMIGRASI KELAS I BENGKULU', 'JL. PEMBANGUNANPO BOX 116 HARAPAN BARU BENGKULU', '', '38225', '	0736-21675, 233', '	0736-341246 ', 'KANIM', 112, 3, '-3.815762', '102.287714', '', 1, 1, '2019-04-15 13:25:47'),
(26, 'VB', 'KANTOR IMIGRASI KELAS I BANDAR LAMPUNG', 'JL. DIPONEGORO NO.133', '', '', '	0721-452828 ', '	0721-482607', 'KANIM', 125, 3, '-5.436013', '105.264151', '', 1, 1, '2019-04-15 13:25:47'),
(27, 'VC', 'KANTOR IMIGRASI KELAS III PANJANG', 'JL. YOS SUDARSO NO. 28 WAY LUNIK ', '', '35244', '	0721-31817, 341', '', 'KANIM', 125, 3, '-5.45213', '105.307217', '', 1, 1, '2019-04-15 13:25:47'),
(28, 'J1', 'KANTOR IMIGRASI KELAS I KHUSUS SOEKARNO-HATTA', 'BANDAR UDARA INTERNATIONAL SOEKARNO-HATTA', '', '19100', '	021-5507185 ', '	021-5507187 ', 'KANIM', 114, 3, '-6.127498', '106.656106', '', 1, 1, '2019-04-15 13:25:47'),
(29, 'J2', 'KANTOR IMIGRASI KELAS I TANJUNG PRIOK', 'JL. MELATI 124 A KOJA', '', '', '	021-494909, 430', '	021-4352253 ', 'KANIM', 114, 3, '-6.109661', '106.893857', '', 1, 1, '2019-04-15 13:25:47'),
(30, 'JB', 'KANTOR IMIGRASI KELAS I KHUSUS JAKARTA BARAT', 'JL. POS KOTA NO. 4', '', '11110', '021-6904795', '021-6930544', 'KANIM', 114, 3, '-6.134272', '106.813685', '', 1, 1, '2019-04-15 13:25:47'),
(31, 'JC', 'KANTOR IMIGRASI KELAS I JAKARTA TIMUR', 'JL. BEKASI TIMUR RAYA NO. 169', '', '', '	021-8503896, 85', '	021-5809105 ', 'KANIM', 114, 3, '-6.209973', '106.893475', '', 1, 1, '2019-04-15 13:25:47'),
(32, 'JD', 'KANTOR IMIGRASI KELAS I JAKARTA PUSAT', 'JL. MERPATI BLOK B12 NO. 3 KEMAYORAN', '', '', '	021-6541209, 65', '021-6541210', 'KANIM', 114, 3, '-6.135722', '106.832557', '', 1, 1, '2019-04-15 13:25:47'),
(33, 'JE', 'KANTOR IMIGRASI KELAS I KHUSUS JAKARTA SELATAN', 'JL. WARUNG BUNCIT RAYA NO.207', '', '', '021-7996334, 799', '	021-79192883 ', 'KANIM', 114, 3, '-6.265731', '106.830441', '', 1, 1, '2019-04-15 13:25:47'),
(34, 'JF', 'KANTOR IMIGRASI KELAS I JAKARTA UTARA', 'KOMP. ARTHA GADING NIAGA - JL. BOULEVARD ARTHA GADING BLOK A NO.5-7, KELAPA GADING', '', '', '	021-45840542 ', '	021-45840527 ', 'KANIM', 114, 3, '-6.163873', '106.89163', '', 1, 1, '2019-04-15 13:25:47'),
(35, 'AB', 'KANTOR IMIGRASI KELAS II BOGOR', 'JL. JEND. A. YANI NO. 65', '', '', '	0251-338074 ', '	0251-332870', 'KANIM', 117, 3, '-6.570034', '106.804672', '', 1, 1, '2019-04-15 13:25:47'),
(36, 'AC', 'KANTOR IMIGRASI KELAS II CIREBON', 'Jl. SULTAN AGENGTIRTAYASA NO. 51 KEDUNGDAWA KEC. KEDAWUNG', '', '', '0231-202955 ', '	0231-202955 ', 'KANIM', 117, 3, '-6.740517', '108.523035', '', 1, 1, '2019-04-15 13:25:47'),
(37, 'AD', 'KANTOR IMIGRASI KELAS I BANDUNG', 'JL. SURAPATI NO. 82', '', '40122', '	(022) 7272081, ', '(022) 7275294 ', 'KANIM', 117, 3, '-6.899161', '107.622972', '', 1, 1, '2019-04-15 13:25:47'),
(38, 'AH', 'KANTOR IMIGRASI KELAS II SUKABUMI', 'Jl. LINGKAR SELATAN NO. 7', '', '', '0266-214456 ', '', 'KANIM', 117, 3, '-6.951263', '106.924267', '', 1, 1, '2019-04-15 13:25:47'),
(39, 'AJ', 'KANTOR IMIGRASI KELAS II KARAWANG', 'JL. A. YANI NO. 18', '', '', '	0267-400725, 40', '0267-400726 ', 'KANIM', 117, 3, '-6.400559', '107.444766', '', 1, 1, '2019-04-15 13:25:47'),
(40, 'AK', 'KANTOR IMIGRASI KELAS II TASIKMALAYA', 'Jl. Letnan Harun, Kota Tasikmalaya, telepon: (0265) 346144, fax: (0265) 346430', '', '', '	0256-453825 ', '0256-453826 ', 'KANIM', 117, 3, '-7.333333', '108.200462', '', 1, 1, '2019-04-15 13:25:47'),
(41, 'AL', 'KANTOR IMIGRASI KELAS II DEPOK', 'KOMPLEK PERKANTORAN PEMDA KOTA DEPOK JL. BOULEVARD RAYA GRAND DEPOK CITY', '', '', '021-77212549 ', '', 'KANIM', 117, 3, '-6.378829', '106.831162', '', 1, 1, '2019-04-15 13:25:47'),
(42, 'LB', 'KANTOR IMIGRASI KELAS II CILACAP', 'JL. URIP SUMOHARJO NO.249 CILACAP', '', '', '0282-547779', '	0282-547775', 'KANIM', 118, 1, '-7.720369', '109.007163', '', 1, 1, '2019-04-15 13:25:47'),
(43, 'LC', 'KANTOR IMIGRASI KELAS I SEMARANG', 'JL. SILIWANGI KRAPYAK', '', '', '	024-7623145, 76', '	024-7607461 ', 'KANIM', 118, 3, '-6.98695', '110.372279', '', 1, 1, '2019-04-15 13:25:47'),
(44, 'LD', 'KANTOR IMIGRASI KELAS I SURAKARTA', 'JL. ADI SUCIPTO NO.8, COLOMADU', '', '57174', '	0271-718479, 71', '	0271-719887 ', 'KANIM', 118, 3, '-7.549942', '110.788354', '', 1, 1, '2019-04-15 13:25:47'),
(45, 'LE', 'KANTOR IMIGRASI KELAS II WONOSOBO', 'JL. RAYA DIENG NO. 132', '', '', '0286-321628 ', '0286-321628 ', 'KANIM', 118, 3, '-7.343122', '109.907849', '', 1, 1, '2019-04-15 13:25:47'),
(46, 'LF', 'KANTOR IMIGRASI KELAS II PEMALANG', 'JL. PERINTIS KEMERDEKAAN NO.110 KELURAHAN TAMAN, KECAMATAN BEJI.', 'kanim_pemalang@imigrasi.go.id', '52313', '0284-325010', '0284-324219', 'KANIM', 118, 1, '-6.894133', '109.423946', '', 1, 1, '2019-04-15 13:25:47'),
(47, 'LG', 'KANTOR IMIGRASI KELAS II PATI', 'JL. RAYA PATI-KUDUS KM 7 NO.1 MARGOREJO', '', '', '0295-386277, 386', '', 'KANIM', 118, 3, '-6.534967', '111.040224', '', 1, 1, '2019-04-15 13:25:47'),
(48, 'YA', 'KANTOR IMIGRASI KELAS I YOGYAKARTA', 'JL. SOLO KM.10 PO BOX 19 YKAP YOGYAKARTA ', '', '55282', '0274-487165 ', '	0274-487130 ', 'KANIM', 113, 3, '-7.783473', '110.434763', '', 1, 1, '2019-04-15 13:25:47'),
(49, 'C1', 'KANTOR IMIGRASI KELAS I TG. PERAK', 'JL. DARMO INDAH NO.21', '', '', '(031)-7315570; 7', '', 'KANIM', 119, 3, '-7.266055', '112.683399', '', 1, 1, '2019-04-15 13:25:47'),
(50, 'CB', 'KANTOR IMIGRASI KELAS II JEMBER', 'JL. LETJEN. DI. PANJAITAN NO. 47', '', '68121', '0331-335494, 333', '0331-333157 ', 'KANIM', 119, 3, '-8.180291', '113.711157', '', 1, 1, '2019-04-15 13:25:47'),
(51, 'CC', 'KANTOR IMIGRASI KELAS I MALANG', 'JL. R. PANJI SUROSO NO. 4', '', '', '(0341)-491039', '', 'KANIM', 119, 1, '-7.940236', '112.64949', '', 1, 1, '2019-04-15 13:25:47'),
(52, 'CD', 'KANTOR IMIGRASI KELAS I KHUSUS SURABAYA', 'JL. JEND. S.PARMAN 58 A', '', '61256', '031-8531785', '	031-8531926 ', 'KANIM', 119, 3, '-7.349549', '112.729157', '', 1, 1, '2019-04-15 13:25:47'),
(53, 'CE', 'KANTOR IMIGRASI KELAS II MADIUN', 'JL. PANGLIMA SUDIRMAN CARUBAN, MADIUN', '', '', '	0351-492859, 49', '	0351-499777 ', 'KANIM', 119, 3, '-7.649408', '111.519856', '', 1, 1, '2019-04-15 13:25:47'),
(54, 'CF', 'KANTOR IMIGRASI KELAS II BLITAR', 'JL. RAYA MASTRIP NO. 45 SRENGAT', '', '66152', '0342-554789 ', '	0342-554759-60 ', 'KANIM', 119, 3, '-8.066028', '112.16217', '', 1, 1, '2019-04-15 13:25:47'),
(55, 'AE', 'KANTOR IMIGRASI KELAS II CILEGON', 'JL. RAYA MERAK KM. 116, KP. TEGAL WANGI DESA ARUM, KEC. PULO MERAK', '', '42436', '	0254-574033, 57', '0254-571084 ', 'KANIM', 111, 3, '-5.966815', '106.003902', '', 1, 1, '2019-04-15 13:25:47'),
(56, 'AF', 'KANTOR IMIGRASI KELAS I TANGERANG', 'Jl. TAMAN MAKAM PAHLAWAN TARUNA NO. 10', '', '', '	021-55790871, 5', '021-55771874 ', 'KANIM', 111, 3, '-6.176374', '106.637893', '', 1, 1, '2019-04-15 13:25:47'),
(57, 'AG', 'KANTOR IMIGRASI KELAS I SERANG', 'JL. WARUNG JAUD NO.82 KALIGANDU', '', '42151', '	0254-209489 ', '	0254-209440 ', 'KANIM', 111, 3, '-6.104658', '106.176821', '', 1, 1, '2019-04-15 13:25:47'),
(58, 'E1', 'KANTOR IMIGRASI KELAS I KHUSUS NGURAH RAI', 'JL. RAYA I GUSTI NGURAH RAI TUBAN', '', '80361', '0361-751039 ', '0361-757011 ', 'KANIM', 109, 3, '-8.73715', '115.180492', '', 1, 1, '2019-04-15 13:25:47'),
(59, 'EB', 'KANTOR IMIGRASI KELAS I DENPASAR', 'JL. DI. PANJAITAN, KOMP. MANDALA RENON', '', '80235', '(0361) 244340 ', '	(0361) 227828, ', 'KANIM', 109, 3, '-8.669721', '115.230317', '', 1, 1, '2019-04-15 13:25:47'),
(60, 'ED', 'KANTOR IMIGRASI KELAS II SINGARAJA', 'JL. SERIRIT - SINGARAJA', '', '', '(0362) 32174 ', '', 'KANIM', 109, 3, '-8.162216', '115.012951', '', 1, 1, '2019-04-15 13:25:47'),
(61, 'EC', 'KANTOR IMIGRASI KELAS I MATARAM', 'JL. UDAYANA No.2', '', '83122', '0370-632520, 633', '	0370-635285 ', 'KANIM', 129, 3, '-8.574019', '116.102743', '', 1, 1, '2019-04-15 13:25:47'),
(62, 'EE', 'KANTOR IMIGRASI KELAS II SUMBAWA BESAR', 'JL. GARUDA NO. 131', '', '', '	0371-21061 ', '', 'KANIM', 129, 3, '-8.445205', '117.430115', '', 1, 1, '2019-04-15 13:25:47'),
(63, 'X1', 'KANTOR IMIGRASI KELAS II ATAMBUA', 'JL. ADI SUCIPTO NO. 8', '', '', '	(0389) 2325064 ', '	(0389) 2325068 ', 'KANIM', 130, 3, '-9.082434', '124.891205', '', 1, 1, '2019-04-15 13:25:47'),
(64, 'X2', 'KANTOR IMIGRASI KELAS II MAUMERE', 'JL. ADI SUCIPTO NO. 24', '', '86111', '	(0382) 21150-51', '	(0382) 21180 ', 'KANIM', 130, 3, '-8.483239', '122.200928', '', 1, 1, '2019-04-15 13:25:47'),
(65, 'XB', 'KANTOR IMIGRASI KELAS I KUPANG', 'JL. PERINTIS KEMERDEKAAN', '', '', '	0380-831880 ', '	0380-825649 ', 'KANIM', 130, 3, '-10.182991', '123.59499', '', 1, 1, '2019-04-15 13:25:47'),
(66, 'KB', 'KANTOR IMIGRASI KELAS II SINGKAWANG', 'JL. FIRDAUS H. RAIS NO.31', '', '', '	0562-631646 ', '	0562-633455 ', 'KANIM', 120, 3, '0.969497', '108.970642', '', 1, 1, '2019-04-15 13:25:47'),
(67, 'KC', 'KANTOR IMIGRASI KELAS I PONTIANAK', 'JL. LETJEN. SUTOYO', '', '', '0561-765576, 721', '0561-734516 ', 'KANIM', 120, 3, '0.178528', '109.25354', '', 1, 1, '2019-04-15 13:25:47'),
(68, 'KD', 'KANTOR IMIGRASI KELAS II SANGGAU', 'JL. SULTAN SYAHRIR NO. 261', '', '', '	0564-21464, 228', '', 'KANIM', 120, 3, '0.152435', '110.603485', '', 1, 1, '2019-04-15 13:25:47'),
(69, 'KE', 'KANTOR IMIGRASI KELAS II ENTIKONG', 'JL. RAYA ENTIKONG', '', '', '	0564-31180 ', '0564-31181 ', 'KANIM', 120, 3, '0.129089', '110.571899', '', 1, 1, '2019-04-15 13:25:47'),
(70, 'KF', 'KANTOR IMIGRASI KELAS II SAMBAS', 'JL. PEMBANGUNAN SAMBAS', '', '', '	(0562) 392111, ', '	(0562) 392111 ', 'KANIM', 120, 3, '1.369384', '109.310188', '', 1, 1, '2019-04-15 13:25:47'),
(71, 'PC', 'KANTOR IMIGRASI KELAS II SAMPIT', 'JL. CILIK RIWUT', '', '', '	0531-21512 ', '', 'KANIM', 122, 3, '-2.473901', '112.953186', '', 1, 1, '2019-04-15 13:25:47'),
(72, 'ZA', 'KANTOR IMIGRASI KELAS I PALANGKARAYA', 'JL. G. OBOS NO. 10', '', '', '	0536-21869, 679', '', 'KANIM', 122, 3, '-2.172026', '113.963928', '', 1, 1, '2019-04-15 13:25:47'),
(73, 'PB', 'KANTOR IMIGRASI KELAS I BANJARMASIN', 'JL. JEND. A. YANI KM. 5,5 NO. 24', '', '70249', '	0511-253670, 25', '0511-258682 ', 'KANIM', 121, 3, '-3.366744', '114.583282', '', 1, 1, '2019-04-15 13:25:47'),
(74, 'PI', 'KANTOR IMIGRASI KELAS II BATULICIN', 'JL. H. HASAN BASRI NO. 16D', '', '', '0518-21376 ', '0518-21376 ', 'KANIM', 121, 3, '-2.811371', '116.276001', '', 1, 1, '2019-04-15 13:25:47'),
(75, 'M1', 'KANTOR IMIGRASI KELAS II NUNUKAN', 'JL. UJANG DEWA SEDADAP NUNUKAN SELATAN ', 'kanim_nunukan@imigrasi.go.id', '177182', '0556-21012', '0556-21812 ', 'KANIM', 123, 3, '4.158104', '117.649841', '', 1, 1, '2019-04-15 13:25:47'),
(76, 'MB', 'KANTOR IMIGRASI KELAS II TARAKAN', 'JL. SUMATERA NO. 1', '', '', '	0551-21242, 247', '	0551-24745 ', 'KANIM', 123, 3, '3.392791', '117.608643', '', 1, 1, '2019-04-15 13:25:47'),
(77, 'MC', 'KANTOR IMIGRASI KELAS I SAMARINDA', 'JL. Ir. H. JUANDA NO. 45', '', '75124', '	(0541) 743945 ', '	(0541) 202242 ', 'KANIM', 123, 3, '-0.430866', '117.248497', '', 1, 1, '2019-04-15 13:25:47'),
(78, 'MD', 'KANTOR IMIGRASI KELAS I BALIKPAPAN', 'JL. JEND. SUDIRMAN NO. 23', '', '95511', '	(0542) 421175, ', '	(0542) 421681 ', 'KANIM', 123, 3, '-0.98872', '116.806641', '', 1, 1, '2019-04-15 13:25:47'),
(79, 'S1', 'KANTOR IMIGRASI KELAS II BITUNG', 'JL. Dr. SAM RATU LANGI', '', '', '	0438-31869 ', '	0438-34410 ', 'KANIM', 138, 3, '1.472692', '125.202255', '', 1, 1, '2019-04-15 13:25:47'),
(80, 'SB', 'KANTOR IMIGRASI KELAS I MANADO', 'JL. 17 AGUSTUS', '', '', '	0431-863491 ', '0431-841688 ', 'KANIM', 138, 3, '1.47162', '124.842753', '', 1, 1, '2019-04-15 13:25:47'),
(81, 'SG', 'KANTOR IMIGRASI KELAS II TAHUNA', 'JL. PELABUHAN TAHUNA RT. 04 LINGK. III', '', '', '	(0432) 24639 ', '	(0432) 24639 ', 'KANIM', 138, 3, '3.644315', '125.472107', '', 1, 1, '2019-04-15 13:25:47'),
(82, '1A', 'KANTOR IMIGRASI KELAS I PALU', 'JL. R.A KARTINI NO.53', '', '91122', '	0451-421433, 45', '0451-455279 ', 'KANIM', 136, 3, '-0.90067', '119.880495', '', 1, 1, '2019-04-15 13:25:47'),
(83, 'FB', 'KANTOR IMIGRASI KELAS I MAKASAR', 'JL. PERINTIS KEMERDEKAAN KM.13 DAYA', '', '', '	(0411) 584559 ', '	(0411) 584906 ', 'KANIM', 135, 3, '-5.106504', '119.510822', '', 1, 1, '2019-04-15 13:25:47'),
(84, 'FC', 'KANTOR IMIGRASI KELAS II PARE - PARE', 'JL. JEND SUDIRMAN NO. 87', '', '', '0421-22298, 2101', '', 'KANIM', 135, 3, '-4.016667', '119.623611', '', 1, 1, '2019-04-15 13:25:47'),
(85, '3A', 'KANTOR IMIGRASI KELAS I KENDARI', 'JL. JEND. A. YANI NO. 101', '', '93117', '	0401-390851 ', '	0401-390350', 'KANIM', 137, 3, '-3.988931', '122.505927', '', 1, 1, '2019-04-15 13:25:47'),
(86, 'SC', 'KANTOR IMIGRASI KELAS I GORONTALO', 'JL. BRIGJEN. PIOLA ISA NO. 214', '', '', '0435-827662 - 82', '0435-827662', 'KANIM', 115, 3, '0.564886', '123.075585', '', 1, 1, '2019-04-15 13:25:47'),
(87, 'RC', 'KANTOR IMIGRASI KELAS I AMBON', 'JL. DR. KAYADOE NO 48 A', '', '', '	0911-353066 ', '	0911-343712 ', 'KANIM', 126, 3, '-3.706671', '128.163071', '', 1, 1, '2019-04-15 13:25:47'),
(88, 'RD', 'KANTOR IMIGRASI KELAS II TUAL', 'JL. JEND. A. YANI', '', '', '	(0916) 23678 ', '(0916) 23678 ', 'KANIM', 126, 3, '-5.639219', '132.669525', '', 1, 1, '2019-04-15 13:25:47'),
(89, 'RB', 'KANTOR IMIGRASI KELAS I TERNATE', 'JL. SKSD PALAPA NO.388', '', '', '	0921-21568 ', '	0921-25598 ', 'KANIM', 127, 3, '0.894663', '127.31575', '', 1, 1, '2019-04-15 13:25:47'),
(90, 'RE', 'KANTOR IMIGRASI KELAS II TOBELO', 'HALMAHERA, MALUKU UTARA', '', '', '2188959671', '', 'KANIM', 127, 3, '0.615223', '127.871246', '', 1, 1, '2019-04-15 13:25:47'),
(91, 'HB', 'KANTOR IMIGRASI KELAS I PANGKALPINANG', 'JL. JEND. SUDIRMAN KM.3, SELINDANG BARU, PANGKAL PINANG', '', '', '	0717-421774 ', '	0717-424700 ', 'KANIM', 110, 3, '-2.230862', '106.135311', '', 1, 1, '2019-04-15 13:25:47'),
(92, 'HD', 'KANTOR IMIGRASI KELAS II TANJUNG PANDAN', 'JL. JEND. SUDIRMAN KM 6,5', '', '33413', '	(0719) 22688 ', '	(0719) 21814', 'KANIM', 110, 3, '-2.76542', '107.662411', '', 1, 1, '2019-04-15 13:25:47'),
(93, 'B1', 'KANTOR IMIGRASI KELAS II TANJUNG UBAN', 'JL. INDUN SURI NO. 09', '', '', '	0771-81927 ', '	0771-81760 ', 'KANIM', 124, 3, '1.176347', '104.376869', '', 1, 1, '2019-04-15 13:25:47'),
(94, 'B4', 'KANTOR IMIGRASI KELAS III TAREMPA', 'JL. KARTINI NO. 51', '', '', '	0772-31028, 310', '', 'KANIM', 124, 3, '3.388404', '106.278076', '', 1, 1, '2019-04-15 13:25:47'),
(95, 'B9', 'KANTOR IMIGRASI KELAS III DABO SINGKEP', 'JL. KARTINI SETAJAM', '', '', '	0776-21823 ', '	0776-21182 ', 'KANIM', 124, 3, '-0.471583', '104.56192', '', 1, 1, '2019-04-15 13:25:47'),
(96, 'BB', 'KANTOR IMIGRASI KELAS II BELAKANG PADANG', 'JL. HANG TUAH NO. 1', '', '', '0778-312419 ', '	0778-312419 ', 'KANIM', 124, 3, '1.023459', '103.78212', '', 1, 1, '2019-04-15 13:25:47'),
(97, 'BC', 'KANTOR IMIGRASI KELAS II TANJUNG BALAI KARIMUN', 'JL. TRIKORA TANJUNG BALAI KARIMUN ', '', '', '	0777-22273, 212', '', 'KANIM', 124, 3, '0.916358', '103.451157', '', 1, 1, '2019-04-15 13:25:47'),
(98, 'BD', 'KANTOR IMIGRASI KELAS I TANJUNG PINANG', 'JL. A. YANI NO.31', '', '', '	0771-21034, 210', '', 'KANIM', 124, 3, '1.087993', '104.483871', '', 1, 1, '2019-04-15 13:25:47'),
(99, 'BK', 'KANTOR IMIGRASI KELAS I KHUSUS BATAM', 'JL. ENGKU PUTRI NO. 3', '', '', '	0778-462068, 46', '	0778-462004 ', 'KANIM', 124, 3, '1.055452', '104.03183', '', 1, 1, '2019-04-15 13:25:47'),
(100, 'BM', 'KANTOR IMIGRASI KELAS II RANAI', 'JL. DATUK KAYAWAN MOCH. BENTENG RANAI', '', '', '	0773-31015, 310', '	0773-31015 ', 'KANIM', 124, 3, '3.988109', '108.400268', '', 1, 1, '2019-04-15 13:25:47'),
(101, 'D1', 'KANTOR IMIGRASI KELAS II TEMBAGAPURA', 'JL. KANTOR UTAMA PT. FREEPORT INDONESIA', '', '', '	0901-404220, 40', '	0901-351273 ', 'KANIM', 131, 3, '-4.274107', '137.017822', '', 1, 1, '2019-04-15 13:25:47'),
(102, 'DB', 'KANTOR IMIGRASI KELAS II BIAK', 'JL. JEND. SUDIRMAN NO.1', '', '98112', '	(0981) 25455 ', '	(0981) 21109 ', 'KANIM', 131, 3, '-0.90963', '136.091308', '', 1, 1, '2019-04-15 13:25:47'),
(103, 'DC', 'KANTOR IMIGRASI KELAS II MERAUKE', 'JL. TAMAN MAKAM PAHLAWAN TRIKORA NO. 88', '', '99613', '	0971-321977 ', '	0971-321054 ', 'KANIM', 131, 3, '-8.501711', '140.38147', '', 1, 1, '2019-04-15 13:25:47'),
(104, 'DE', 'KANTOR IMIGRASI KELAS I JAYAPURA', 'JL. PERCETAKAN NEGARA NO. 15', '', '', '0967-533647', '0967-534147', 'KANIM', 131, 3, '-2.511494', '140.6987', '', 1, 1, '2019-04-15 13:25:47'),
(105, 'DD', 'KANTOR IMIGRASI KELAS II SORONG', 'JL. MASJID RAYA HBM', '', '', '	0951-321393, 32', '', 'KANIM', 132, 3, '-4.058248', '138.964233', '', 1, 1, '2019-04-15 13:25:47'),
(106, 'DF', 'KANTOR IMIGRASI KELAS II MANOKWARI', 'JL. TRIKORA - ARFAI II - MANOKWARI', '', '', '	0986 213436 ', '', 'KANIM', 132, 3, '-0.861866', '134.078643', '', 1, 1, '2019-04-15 13:25:47'),
(107, 'FD', 'KANTOR IMIGRASI KELAS II MAMUJU', 'JL. H ABDUL MALIK PATTANA ENDENG, RANGAS', '', '', '	0426-2325240 ', '0426-2325241', 'KANIM', 134, 1, '-2.674729', '118.886787', '', 1, 1, '2019-04-15 13:25:47'),
(108, 'FE', 'KANTOR IMIGRASI KELAS II POLEWALI MANDAR', 'JL. TRITURA NO. 12', '', '', '0428-21901 ', '', 'KANIM', 134, 3, '-3.387547', '119.220829', '', 1, 1, '2019-04-15 13:25:47'),
(109, 'W16', 'KANTOR WILAYAH BALI', 'JL. PUPUTAN RAYA PO BOX. 64', '', '80234', '	(0361) 228718, ', '	228718, 240752 ', 'KANWIL', 155, 2, '-8.672945', '115.233407', '', 1, 1, '2019-04-15 13:25:47'),
(110, 'W30', 'KANTOR WILAYAH BANGKA BELITUNG', 'KOMPLEK PERKANTORAN DAN PEMUKIMAN TERPADU PROPINSI BANGKA BELITUNG', '', '', '	(0717) 439436, ', '439436', 'KANWIL', 155, 2, '-2.369624', '106.12793', '', 1, 1, '2019-04-15 13:25:47'),
(111, 'W29', 'KANTOR WILAYAH BANTEN', 'JL. BRIGJEN KH. SAMI\'UN NO. 44 ', '', '', '	(0254) 223104, ', '	218833, 207610 ', 'KANWIL', 155, 2, '-6.40879', '106.063385', '', 1, 1, '2019-04-15 13:25:47'),
(112, 'W21', 'KANTOR WILAYAH BENGKULU', 'JL. PANGERAN NATADIRJA KM. 7 PO BOX 93', '', '38225', '(0736) 22234, 42', '	26304 ', 'KANWIL', 155, 2, '-3.799169', '102.258682', '', 1, 1, '2019-04-15 13:25:47'),
(113, 'W22', 'KANTOR WILAYAH D.I YOGYAKARTA', 'JL. GEDONG KUNING NO. 146 ', '', '55121', '	(0274) 378431, ', '	378432', 'KANWIL', 155, 2, '-7.807262', '110.366764', '', 1, 1, '2019-04-15 13:25:47'),
(114, 'W7', 'KANTOR WILAYAH DKI JAKARTA', 'JL. MT. HARYONO NO. 24', '', '13630', '	(021) 8090912, ', '8012274', 'KANWIL', 155, 2, '-6.323829', '106.886501', '', 1, 1, '2019-04-15 13:25:47'),
(115, 'W31', 'KANTOR WILAYAH GORONTALO', 'JL. TINALOGA NO. 1 BONE BALANGO ', '', '', '	(0435) 826242 ', '	831287 ', 'KANWIL', 155, 2, '0.553127', '123.065586', '', 1, 1, '2019-04-15 13:25:47'),
(116, 'W20', 'KANTOR WILAYAH JAMBI', 'JL. KAPTEN SUJONO KOTABARU PO BOX 1432', '', '36128', '(0741) 40085, 40', '	444029 ', 'KANWIL', 155, 2, '-1.614776', '103.568115', '', 1, 1, '2019-04-15 13:25:47'),
(117, 'W8', 'KANTOR WILAYAH JAWA BARAT', 'JL. JAKARTA NO 27', '', '40122', '	(022) 7208031, ', '7210300, 7107145', 'KANWIL', 155, 2, '-6.914179', '107.638614', '', 1, 1, '2019-04-15 13:25:47'),
(118, 'W9', 'KANTOR WILAYAH JAWA TENGAH', 'JL. DR. CIPTO NO. 64', '', '50126', '(024) 3561503, 3', '	3561386, 358342', 'KANWIL', 155, 2, '-6.984298', '110.349727', '', 1, 1, '2019-04-15 13:25:47'),
(119, 'W10', 'KANTOR WILAYAH JAWA TIMUR', 'JL. KAY.OON NO. 50-52 KEC. GENTENG', '', '60111', '(031) 5482735, 5', '(031) 5345496, 5', 'KANWIL', 155, 2, '-7.260563', '112.742815', '', 1, 1, '2019-04-15 13:25:47'),
(120, 'W11', 'KANTOR WILAYAH KALIMANTAN BARAT', 'JL. K.S TUBUN NO. 26 PONTIANAK SELATAN ', '', '78121', '	(0561) 732229, ', '	762624, 761788 ', 'KANWIL', 155, 2, '0.186767', '109.259033', '', 1, 1, '2019-04-15 13:25:47'),
(121, 'W12', 'KANTOR WILAYAH KALIMANTAN SELATAN', 'JL. BRIGJEN H HASAN BARI NO. 30', '', '70123', '(0511) 52790, 68', '	3302790 ', 'KANWIL', 155, 2, '-3.140516', '114.598389', '', 1, 1, '2019-04-15 13:25:47'),
(122, 'W23', 'KANTOR WILAYAH KALIMANTAN TENGAH', 'JL. G. OBOS NO 10', '', '73111', '	(0536) 3221554 ', '3220150', 'KANWIL', 155, 2, '-1.540647', '113.222351', '', 1, 1, '2019-04-15 13:25:47'),
(123, 'W13', 'KANTOR WILAYAH KALIMANTAN TIMUR', 'JL. LETJEN. MT. HARYONO', '', '75124', '	(0541) 741539, ', '	747740, 736516 ', 'KANWIL', 155, 2, '-0.431896', '117.247124', '', 1, 1, '2019-04-15 13:25:47'),
(124, 'W27', 'KANTOR WILAYAH KEPULAUAN RIAU', 'JL. RAYA SENGGARANG KM 14', '', '29113', '	(0771) 7333004', '	441466 ', 'KANWIL', 155, 2, '1.087581', '104.482727', '', 1, 1, '2019-04-15 13:25:47'),
(125, 'W6', 'KANTOR WILAYAH LAMPUNG', 'JL. WR. MONGINSIDI NO. 184 ', '', '35215', '	(0721) 45427, 4', '483927, 471060 ', 'KANWIL', 155, 2, '-5.449225', '105.266533', '', 1, 1, '2019-04-15 13:25:47'),
(126, 'W18', 'KANTOR WILAYAH MALUKU', 'JL. SULTAN ABDULLAH NO. 17', '', '97115', '(0911) 352803 ', '352803', 'KANWIL', 155, 2, '-3.70393', '128.162727', '', 1, 1, '2019-04-15 13:25:47'),
(127, 'W28', 'KANTOR WILAYAH MALUKU UTARA', 'JL. CENGKEH AFO NO. 40 TERNATE MALUKU UTARA ', '', '', '(0921) 328194 ', '	22118 ', 'KANWIL', 155, 2, '0.804722', '127.342529', '', 1, 1, '2019-04-15 13:25:47'),
(128, 'W1', 'KANTOR WILAYAH NANGGROE ACEH DARUSSALAM', 'JL. T. NYAK ARIEF NO. 185', '', '23114', '	(0651) 53494, 5', '(0651) 7553494 ', 'KANWIL', 155, 2, '5.57603', '95.355041', '', 1, 1, '2019-04-15 13:25:47'),
(129, 'W24', 'KANTOR WILAYAH NUSA TENGGARA BARAT', 'JL. MAJAPAHIT NO. 44 ', '', '83127', '(0370) 22341, 21', '621819, 625341 ', 'KANWIL', 155, 2, '-8.581615', '116.106777', '', 1, 1, '2019-04-15 13:25:47'),
(130, 'W17', 'KANTOR WILAYAH NUSA TENGGARA TIMUR', 'JL. WJ. LATUMETIK NO. 98', '', '85228', '	(0380) 833101, ', '	821126 ', 'KANWIL', 155, 2, '-10.181639', '123.59499', '', 1, 1, '2019-04-15 13:25:47'),
(131, 'W19', 'KANTOR WILAYAH PAPUA', 'JL. TANJUNG RIA NO. 92 BASE G', '', '', '(0967) 541044, 5', '	541847 ', 'KANWIL', 155, 2, '-2.528266', '140.72319', '', 1, 1, '2019-04-15 13:25:47'),
(132, 'W33', 'KANTOR WILAYAH PAPUA BARAT', 'JL. TRIKORA WOSI NO. 84 ', '', '', '	(0986) 214300 ', '	214300', 'KANWIL', 155, 2, '-0.834931', '134.055176', '', 1, 1, '2019-04-15 13:25:47'),
(133, 'W4', 'KANTOR WILAYAH RIAU', 'JL. JEND. SUDIRMAN NO. 233', '', '28000', '(0761) 21860', '	(0761) 46969, 8', 'KANWIL', 155, 2, '0.506051', '101.452045', '', 1, 1, '2019-04-15 13:25:47'),
(134, 'W32', 'KANTOR WILAYAH SULAWESI BARAT', 'JL. AMMANA PATOLLA NO. 4 ', '', '', '(0428) 23262 ', '	23262 ', 'KANWIL', 155, 2, '-2.792168', '119.237366', '', 1, 1, '2019-04-15 13:25:47'),
(135, 'W15', 'KANTOR WILAYAH SULAWESI SELATAN', 'JL. ST. ALAUDIN NO. 102', '', '90223', '	(0411) 854731, ', '871160', 'KANWIL', 155, 2, '-5.137322', '119.412374', '', 1, 1, '2019-04-15 13:25:47'),
(136, 'W26', 'KANTOR WILAYAH SULAWESI TENGAH', 'JL. DEWI SARTIKA NO. 26', '', '94114', '	(0451) 482353, ', '	481205 ', 'KANWIL', 155, 2, '-0.898782', '119.893799', '', 1, 1, '2019-04-15 13:25:47'),
(137, 'W25', 'KANTOR WILAYAH SULAWESI TENGGARA', 'JL. BALAIKOTA NO. 7A', '', '93117', '(0401) 321340, 3', '321340', 'KANWIL', 155, 2, '-3.957678', '122.570772', '', 1, 1, '2019-04-15 13:25:47'),
(138, 'W14', 'KANTOR WILAYAH SULAWESI UTARA', 'JL. DIPONEGORO NO. 87', '', '95112', '	(0431) 863780, ', '864288, 870359 ', 'KANWIL', 155, 2, '1.473379', '124.844856', '', 1, 1, '2019-04-15 13:25:47'),
(139, 'W3', 'KANTOR WILAYAH SUMATERA BARAT', 'JL. S. PARMAN NO. 256 ULAK KARANG', '', '25133', '(0751) 7055471, ', '	(0751) 7055510 ', 'KANWIL', 155, 2, '-2.822344', '119.21814', '', 1, 1, '2019-04-15 13:25:47'),
(140, 'W5', 'KANTOR WILAYAH SUMATERA SELATAN', 'JL. JENDRAL SUDIRMAN KM 3,5', '', '30116', '0711-358433, 350', '	0711-378384 ', 'KANWIL', 155, 2, '-2.990356', '104.757385', '', 1, 1, '2019-04-15 13:25:47'),
(141, 'W2', 'KANTOR WILAYAH SUMATERA UTARA', 'JL. PUTRI HIJAU NO 4', 'divimsumur@gmail.com', '20111', '	(061) 4579571', '(061) 4533493 ', 'KANWIL', 155, 2, '3.587436', '98.675079', '', 1, 1, '2019-04-15 13:25:47'),
(142, 'PR', 'RUDENIM PUSAT TANJUNG PINANG', 'JL. JEND. A.YANI No. 32 TANJUNGPINANG - 29124', '', '', '', '', 'RUDENI', 124, 3, '1.084149', '104.482727', '', 1, 1, '2019-04-15 13:25:47'),
(143, 'MR', 'RUDENIM BALIKPAPAN', 'JL. SOSIAL TENGAH NO.66 LAMARU, BALIKPAPAN, 76117', '', '', '', '', 'RUDENI', 123, 3, '-1.252342', '116.762695', '', 1, 1, '2019-04-15 13:25:47'),
(144, 'ER', 'RUDENIM DENPASAR', 'JL. ULUWATU NO.108, JIMBARAN KUTA SELATAN, BADUNG, BALI, 80361', '', '', '', '', 'RUDENI', 109, 3, '-8.685906', '115.240102', '', 1, 1, '2019-04-15 13:25:47'),
(145, 'JR', 'RUDENIM DKI JAKARTA', 'JL. PETA SELATAN NO.5-D, KALIDERES, JAKARTA BARAT', '', '', '(6221)54376207', '54376208', 'RUDENI', 114, 3, '-6.14559', '106.711063', '', 1, 1, '2019-04-15 13:25:47'),
(146, 'XR', 'RUDENIM KUPANG', 'JL. SOEKARNO NO. 16A', '', '', '(62380) 8081392', '', 'RUDENI', 130, 3, '-10.183329', '123.594818', '', 1, 1, '2019-04-15 13:25:47'),
(147, 'DR', 'RUDENIM JAYAPURA', 'JL. KABUPATEN I No. 1 APO JAYAPURA', '', '', '', '', 'RUDENI', 131, 3, '-2.519177', '140.699158', '', 1, 1, '2019-04-15 13:25:47'),
(148, 'FR', 'RUDENIM MAKASAR', 'JL. LEMBAGA BOLANGI KABUPATEN GOWA 92172', '', '', '(62411)5068584', '5068150', 'RUDENI', 135, 3, '-5.090944', '120.058594', '', 1, 1, '2019-04-15 13:25:47'),
(149, 'CR', 'RUDENIM SURABAYA', 'JL. RAYA RACI KEC.BANGIL, KAB.PASURUAN, SURABAYA', '', '', '', '', 'RUDENI', 119, 3, '-7.263373', '112.742386', '', 1, 1, '2019-04-15 13:25:47'),
(150, 'LR', 'RUDENIM SEMARANG', 'JL. HANOMAN RAYA NO. 10, SEMARANG', '', '', '62247622595', '', 'RUDENI', 118, 3, '-6.986918', '110.372214', '', 1, 1, '2019-04-15 13:25:47'),
(151, 'SR', 'RUDENIM MANADO', 'JL. A.A. MARAMIS - LAPANGAN, MAPANGET', '', '', '62431811155', '811155', 'RUDENI', 138, 3, '1.543607', '124.91925', '', 1, 1, '2019-04-15 13:25:47'),
(152, 'KR', 'RUDENIM PONTIANAK', 'JL. ADI SUCIPTO KM.15, PONTIANAK, KALIMANTAN BARAT 78391', '', '', '62561732229', '762624', 'RUDENI', 120, 3, '0.152435', '109.25766', '', 1, 1, '2019-04-15 13:25:47'),
(153, 'GR', 'RUDENIM MEDAN', 'JL. SELEBES - BELAWAN', '', '', '62616945822', '6945811', 'RUDENI', 141, 3, '3.7793', '98.685336', '', 1, 1, '2019-04-15 13:25:47'),
(154, 'BR', 'RUDENIM PEKANBARU', 'JL. JENDERAL SUDIRMAN NO. 233', '', '', '', '', 'RUDENI', 133, 3, '0.505536', '101.452045', '', 1, 1, '2019-04-15 13:25:47'),
(155, 'IMI', 'DIREKTORAT JENDERAL IMIGRASI', 'JL. HR RASUNA SAID KAV 8 - 9', '', '', '', '', 'DIREKT', 0, 1, '-6.216842', '106.832917', '', 1, 1, '2019-04-15 13:25:47'),
(156, 'BTJ', 'TPI SULTAN ISKANDAR MUDA', 'BANDA ACEH', '', '', '', '', 'TPI', 2, 4, '5.5182990178', '95.41872102', '', 1, 1, '2019-04-15 13:25:47'),
(157, 'BDO', 'TPI HUSEIN SASTRANEGARA', 'HUSEIN SASTRANEGARA AIRPORT ', '', '', '', '', 'TPI', 37, 4, '-6.8997275576', '107.57785577', '', 1, 1, '2019-04-15 13:25:47'),
(158, 'BTH', 'TPI BATAM CENTER', 'JL. ENGKU PUTRI NO. 3 BATAM-CENTRE ', '', '', '(0778) 462070 ', '	462004 ', 'TPI', 99, 4, '1.1308078999', '104.05511755', '', 1, 1, '2019-04-15 13:25:47'),
(159, 'BUR', 'TPI HARBOUR BAY', 'JL. LUMBA-LUMBA NO.5 BATU AMPAR ', '', '', '	0778-455471, 45', '', 'TPI', 99, 4, '1.1560370973', '104.02993697', '', 1, 1, '2019-04-15 13:25:47'),
(160, 'TSB', 'TPI MARINA', 'PELABUHAN MARINA CITY', '', '', '', '', 'TPI', 99, 4, '1.0821885197', '103.93585581', '', 1, 1, '2019-04-15 13:25:47'),
(161, 'NGA', 'TPI NONGSA', 'JL. HANG LEKIU-NONGSA ', '', '', '	0778-761777 ', '', 'TPI', 99, 4, '1.1183487571', '104.13544703', '', 1, 1, '2019-04-15 13:25:47'),
(162, 'SKP', 'TPI SEKUPANG', 'JL. RE MARTADINATA SEKUPANG ', '', '', '	0778-322080, 32', '', 'TPI', 99, 4, '1.0791527992', '103.93060941', '', 1, 1, '2019-04-15 13:25:47'),
(163, 'LGO', 'TPI BINTAN LAGOI', 'TELUK SEBONG LAGOI BINTAN UTARA ', '', '', '', '', 'TPI', 93, 4, '1.1713922584', '104.37935638', '', 1, 1, '2019-04-15 13:25:47'),
(164, 'TAN', 'TPI BANDAR SRI UDANA LOBAM', 'BINTAN', '', '', '', '', 'TPI', 93, 4, '1.0629229063', '104.2241745', '', 1, 1, '2019-04-15 13:25:47'),
(165, 'TNJ', 'TPI SRI BINTAN PURA TANJUNG PINANG', 'JL. S.M. AMIN NO. 1 ', '', '29111', '(0771) 21785 ', '29969', 'TPI', 98, 4, '0.9057901576', '104.43922329', '', 1, 1, '2019-04-15 13:25:47'),
(166, 'DPS', 'TPI NGURAH RAI', 'JL. RAYA I. GUSTI NGURAH RAI ', '', '', '	(0361) 751011 ', '751032', 'TPI', 58, 4, '-8.7472022813', '115.16967773', '', 1, 1, '2019-04-15 13:25:47'),
(167, 'ENG', 'TPI ENTIKONG', 'JL. MALINDO', '', '', '', '', 'TPI', 69, 4, '0.98673890674', '110.35264391', '', 1, 1, '2019-04-15 13:25:47'),
(168, 'CGK', 'TPI SOEKARNO HATTA ', 'JL. SOEKARNO - HATTA 13', '', '', '	021-5406177 ', '021-5406176 ', 'TPI', 28, 4, '-6.1266734984', '106.65824699', '', 1, 1, '2019-04-15 13:25:47'),
(169, 'TJB', 'TPI TANJUNG BALAI KARIMUN ', 'JL. TRIKORA TANJUNG BALAI KARIMUN ', '', '', '	(0777) 23570 ', '325349', 'TPI', 97, 4, '0.99259865918', '103.44588327', '', 1, 1, '2019-04-15 13:25:47'),
(170, 'KOE', 'TPI ELTARI', 'JL. ADI SUCIPTO ELTARI', '', '', '', '', 'TPI', 65, 4, '-10.168911454', '123.66770077', '', 1, 1, '2019-04-15 13:25:47'),
(171, 'UPG', 'TPI HASANUDDIN ', 'MAKASSAR BANDAR UDARA HASANUDDIN MANDAI', '', '90552', '	(0411) 558083 ', '	553082 ', 'TPI', 83, 4, '-5.0758409781', '119.54568195', '', 1, 1, '2019-04-15 13:25:47'),
(172, 'AMI', 'TPI SELAPARANG', 'JL. ADISUTJIPTO NO. 1 ', '', '', '(0370) 22987, 37', '	32030 ', 'TPI', 61, 4, '-8.5628291456', '116.10244709', '', 1, 1, '2019-04-15 13:25:47'),
(173, 'BLW', 'TPI BELAWAN', 'JL. SUMATERA NO. 1', '', '20411', '	(061) 6941919 ', '	6941300 ', 'TPI', 7, 4, '3.7861222867', '98.690412521', '', 1, 1, '2019-04-15 13:25:47'),
(174, 'MES', 'TPI POLONIA', 'JL. MANGKUBUMI NO. 2 ', '', '', '	(061) 4533117 ', '4558488', 'TPI', 6, 4, '3.5822966584', '98.66692543', '', 1, 1, '2019-04-15 13:25:47'),
(175, 'MDC', 'TPI SAM RATULANGI', 'JL. A.A MARAMIS ', '', '', '(0431) 60449 ', '	60595 ', 'TPI', 80, 4, '1.5433685925', '124.92348152', '', 1, 1, '2019-04-15 13:25:47'),
(176, 'PDG', 'TPI MINANGKABAU', 'MINANGKABAU INTERNATIONAL AIRPORT, KETAPING ', '', '', '', '', 'TPI', 12, 4, '-0.78810172532', '100.28248596', '', 1, 1, '2019-04-15 13:25:47'),
(177, 'PLM', 'TPI SULTAN MUHAMMAD BAHARUDIN II', 'Jl. TANJUNG API - API NO. 1', '', '', '(0711) 385001', '(0711) 385015', 'TPI', 23, 4, '-2.8978668853', '104.7018528', '', 1, 1, '2019-04-15 13:25:47'),
(178, 'PKU', 'TPI SULTAN SYARIF KASIM II', 'BANDARA SULTAN SYARIF KASIM II PEKANBARU ', '', '', '', '', 'TPI', 19, 4, '0.46479521027', '101.44551325', '', 1, 1, '2019-04-15 13:25:47'),
(179, 'SUB', 'TPI JUANDA', 'JL. IR. H. JUANDA ', '', '', '', '', 'TPI', 52, 4, '-7.3796613864', '112.79319763', '', 1, 1, '2019-04-15 13:25:47'),
(180, 'SOC', 'TPI ADISUMARMO', 'BANDARA ADISUMARMO', '', '', '(0271) 780715, 7', '	780058 ', 'TPI', 44, 4, '-7.5177039247', '110.75695038', '', 1, 1, '2019-04-15 13:25:47'),
(181, 'JOG', 'TPI ADISUCIPTO', 'JL. SOLO KM 9', '', '', '	(0274) 512144, ', '	(0274) 560155', 'TPI', 48, 4, '-7.7903400965', '110.42989254', '', 1, 1, '2019-04-15 13:25:47'),
(182, 'TEU', 'TPI TENAU', 'JL. YOS SUDARSO NO. 23 ', '', '', '	(0391) 21790 ', '', 'TPI', 65, 4, '-10.141932', '123.522034', '', 1, 1, '2019-04-15 13:25:47'),
(183, 'TBY', 'TPI TELUK BAYUR', 'JL. SEMARANG NO. 3 ', '', '', '', '', 'TPI', 12, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(184, 'TPK', 'TPI TANJUNG PRIOK', 'JL. RAYA PELABUHAN NO. 9 TANJUNG PRIOK', '', '', '(021) 4367505 ', '4372933', 'TPI', 29, 4, '-6.1062767404', '106.79506111', '', 1, 1, '2019-04-15 13:25:47'),
(185, 'TMA', 'TPI TANJUNG MAS', 'JL. COASTER NO. 10 ', '', '', '', '', 'TPI', 43, 4, '-6.951689', '110.418992', '', 1, 1, '2019-04-15 13:25:47'),
(186, 'SLG', 'TPI SIBOLGA', 'JL. SISINGAMANGARAJA NO. 435', '', '', '	(0361) 22929 ', '	21714 ', 'TPI', 8, 4, '1.944207', '98.76709', '', 1, 1, '2019-04-15 13:25:47'),
(187, 'BPN', 'TPI SEPINGGAN', 'JL. MARSMA ISWAHYUDI ', '', '76115', '	(0542) 66886 ', '	66832 ', 'TPI', 78, 4, '-1.2624267278', '116.89873058', '', 1, 1, '2019-04-15 13:25:47'),
(188, 'x', 'TPI PARE-PARE', 'JL. ANDI CAMMI 1', '', '91111', '', '', 'TPI', 84, 4, '-4.008881', '119.620814', '', 1, 1, '2019-04-15 13:25:47'),
(189, 'PBA', 'TPI PADANG BAI', 'DESA PADANG BAI, KECAMATAN MANGGIS,KABUPATEN KARANG ASEM', '', '', '', '', 'TPI', 59, 4, '-8.533032', '115.507897', '', 1, 1, '2019-04-15 13:25:47'),
(190, 'MAU', 'TPI MAUMERE', 'JL. PELABUHAN NO. 3', '', '', '(0382) 54618 ', '', 'TPI', 64, 4, '-8.586453', '122.24762', '', 1, 1, '2019-04-15 13:25:47'),
(191, 'HNG', 'TPI HANG NADIEM', 'JL. BANDARA HANG NADIEM ', '', '', '', '', 'TPI', 99, 4, '1.1231758097', '104.1152634', '', 1, 1, '2019-04-15 13:25:47'),
(192, 'JCU1', 'TPI HALIM PERDANA KUSUMA', 'BANDARA HALIM PERDANA KUSUMA, CAWANG,', '', '13610', '', '', 'TPI', 31, 4, '-6.2647896866', '106.8853845', '', 1, 1, '2019-04-15 13:25:47'),
(193, 'BIT', 'TPI BITUNG', 'JL. DS SUMOLANG NO. 1', '', '95522', '(0438) 21196 ', '	21380 ', 'TPI', 79, 4, '1.469947', '125.205688', '', 1, 1, '2019-04-15 13:25:47'),
(194, 'BOA', 'TPI BENOA', 'JL. PELABUHAN BENOA ', '', '', '', '', 'TPI', 59, 4, '-8.798847', '115.21019', '', 1, 1, '2019-04-15 13:25:47'),
(195, 'x', 'TPI TANJUNG UBAN', 'JL. NUSA INDAH 1 TANJUNG UBAN, BINTAN UTARA', '', '29152', '	(0771) 81064 ', '	483454 ', 'TPI', 93, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(196, 'ME', 'KANTOR IMIGRASI KELAS III TANJUNG REDEB', 'JL. MANGGA II, TANJUNG REDEB', '', '', '', '', 'KANIM', 123, 0, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(197, 'AM', 'KANTOR IMIGRASI KELAS III BEKASI', 'JL. AHMAD YANI NO.2 BEKASI', '', '', '021-88968018', '', 'KANIM', 117, 0, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(198, 'VD', 'KANTOR IMIGRASI KELAS III KALIANDA', '', '', '', '', '', 'KANIM', 125, 0, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(199, 'VE', 'KANTOR IMIGRASI KELAS III KOTABUMI', '', '', '', '', '', 'KANIM', 125, 0, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(200, 'IMI.1', 'SETDITJEN IMIGRASI', '', '', '', '', '', '', 0, 0, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(202, 'IMI.2', 'DIT. DOKUMEN PERJALANAN, VISA DAN FASILITASI KEIMI', 'JL. HR RASUNA SAID KAV 8 - 9', '', '', '', '', 'DIREKT', 0, 0, '-6.216842', '106.832917', '', 1, 1, '2019-04-15 13:25:47'),
(203, 'IMI.3', 'DIT. IZIN TINGGAL DAN STATUSKIM', 'JL. HR RASUNA SAID KAV 8 - 9', '', '', '', '', 'DIREKT', 0, 0, '-6.216842', '106.832917', '', 1, 1, '2019-04-15 13:25:47'),
(204, 'IMI.4', 'DIT. INTELIJEN KEIMIGRASIAN', 'JL. HR RASUNA SAID KAV 8 - 9', '', '', '', '', 'DIREKT', 0, 0, '-6.216842', '106.832917', '', 1, 1, '2019-04-15 13:25:47'),
(205, 'IMI.5', 'DIT. PENYIDIKAN DAN PENINDAKAN KEIMIGRASIAN', 'JL. HR RASUNA SAID KAV 8 - 9', '', '', '', '', 'DIREKT', 0, 0, '-6.216842', '106.832917', '', 1, 1, '2019-04-15 13:25:47'),
(206, 'IMI.6', 'DIT. LINTAS BATAS DAN KERJASAMA LUAR NEGERI', 'JL. HR RASUNA SAID KAV 8 - 9', '', '', '', '', 'DIREKT', 0, 0, '-6.216842', '106.832917', '', 1, 1, '2019-04-15 13:25:47'),
(207, 'IMI.7', 'DIT. SISTEM INFORMASI KEIMIGRASIAN', 'JL. HR RASUNA SAID KAV 8 - 9', '', '', '', '', 'DIREKT', 0, 0, '-6.216842', '106.832917', '', 1, 1, '2019-04-15 13:25:47'),
(208, 'x', 'TPI SKOU', 'JAYAPURA', '', '', '', '', 'TPI', 104, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(209, 'x', 'TPI ARUK', 'KABUPATEN SAMBAS', '', '', '', '', 'TPI', 70, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(210, 'x', 'TPI MOTA\'AIN', 'ATAMBUA', '', '', '', '', 'TPI', 63, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(211, 'x', 'TPI METAMEUK', 'ATAMBUA', '', '', '', '', 'TPI', 63, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(212, 'x', 'TPI NAPAN', 'ATAMBUA', '', '', '', '', 'TPI', 63, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(213, 'x', 'TPI NANGA BADAU', 'KABUPATEN KAPUAS HULU', '', '', '', '', 'TPI', 70, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(215, 'DUM', 'TPI DUMAI', 'JL. DATUK LAKSAMANA ', '', '', '', '', 'TPI', 16, 4, '1.730084', '101.4505', '', 1, 1, '2019-04-15 13:25:47'),
(216, 'PNK', 'TPI SUPADIO', ' Jl. ADI SUCIPTO KM 17', '', '', '(0561) 721142', '', 'TPI', 67, 4, '-0.132647', '109.402605', '', 1, 1, '2019-04-15 13:25:47'),
(217, 'x', 'TPI SOEKARNO HATTA MAKASAR', 'JL. SOEKARNO NO. 1', '', '', '', '', 'TPI', 83, 4, '-5.117959', '119.408684', '', 1, 1, '2019-04-15 13:25:47'),
(219, 'x', 'TPI JAYAPURA', 'JL. YABASO JAYAPURA 99352', '', '', '', '', 'TPI', 104, 4, '-2.505457', '140.712685', '', 1, 1, '2019-04-15 13:25:47'),
(220, 'x', 'TPI YOS SUDARSO', 'Jl. YOS SUDARSO NO. 1', '', '', '', '', 'TPI', 87, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(221, 'X3', 'KANTOR IMIGRASI KELAS III LABUAN BAJO', 'LABUAN BAJO', '', '', '(0385) 42134', '', 'KANIM', 130, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(222, 'TG', 'KANTOR IMIGRASI KELAS III TAKENGON', 'KOMPLEK PEMDA JL. YOS SUDARSO', '', '', '0643-8001104', '', 'KANIM', 128, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(223, 'CG', 'KANTOR IMIGRASI KELAS III KEDIRI', 'Jl. IR. SUTAMI NO. 16', '', '', '0354-688307', '', 'KANIM', 119, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(224, 'CH', 'KANTOR IMIGRASI KELAS III PAMEKASAN', 'Jl. RAYA PAMEKASAN EX GD DISNAKERTRANS', '', '', ' (0324)-336978, ', '', 'KANIM', 119, 4, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(225, 'x', 'DRC IMIGRASI', 'JL. Ganesha 10', '', '', '', '', 'DIREKT', 0, 0, '-6.892088', '107.610158', '', 1, 1, '2019-04-15 13:25:47'),
(226, 'KG', 'KANTOR IMIGRASI KELAS III PUTUSSIBAU', '', '', '', '0567-21231', '', 'KANIM', 120, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(227, '1B', 'KANTOR IMIGRASI KELAS III BANGGAI', '', '', '', '', '', 'KANIM', 136, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(228, 'S2', 'KANTOR IMIGRASI KELAS III KOTAMOBAGU', '', '', '', '(0434)-24474', '', 'KANIM', 138, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(229, '3B', 'KANTOR IMIGRASI KELAS III WAKATOBI', '', '', '', '', '', 'KANIM', 137, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(230, '3C', 'KANTOR IMIGRASI KELAS III BAUBAU', 'JL. MUH, HUSNI THAMRIN NO 32', '', '', '(0402)-2823789', '', 'KANIM', 137, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(231, 'JZ', 'UNIT LAYANAN PASPOR KANIM KELAS I KHUSUS JAKARTA S', '', '', '', '', '', 'KANIM_', 114, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(232, 'JY', 'UNIT LAYANAN PASPOR KANIM KELAS I KHUSUS JAKARTA S', '', '', '', '', '', 'KANIM_', 114, 0, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(233, 'IMI-HAM', 'MENTERI HUKUM DAN HAM', '', '', '', '', '', 'DIREKT', 0, 1, '-6.216842', '106.832917', '', 1, 1, '2019-04-15 13:25:47'),
(237, 'FF', 'KANTOR IMIGRASI KELAS III PALOPO', 'JL. PATANG II NO.2 KOTA PALOPO', '', '', '', '', 'KANIM', 135, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(240, 'KH', 'KANTOR IMIGRASI KELAS III KETAPANG', 'JL.LINGKAR KOTA KELUARAHAN MULIA BARU KECAMATAN DELTA PAWAN KETAPANG', '', '', '', '', 'KANIM', 120, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(244, 'CI', 'KANTOR IMIGRASI KELAS III PONOROGO', '', '', '', '', '', 'KANIM', 119, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(245, 'EF', 'KANTOR IMIGRASI KELAS III BIMA', '', '', '', '', '', 'KANIM', 129, 3, '', '', '', 1, 1, '2019-04-15 13:25:47'),
(247, 'BI', 'KANTOR IMIGRASI KELAS II BATULICIN', '', '', '', '', '', 'KANIM', 121, 3, '', '', '', 1, 1, '2019-04-15 13:25:47');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_login_notifications`
--

CREATE TABLE `tbl_helpdesk_login_notifications` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `content_summary` varchar(255) NOT NULL,
  `content_full` text NOT NULL,
  `color` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_login_notifications`
--

INSERT INTO `tbl_helpdesk_login_notifications` (`id`, `name`, `content_summary`, `content_full`, `color`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'test informasi terbaru', 'ini hanya percobaan berita terbaru di imigrasi', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'red', '-', 1, 1, '2019-07-17 00:00:00'),
(2, 'testasss', 'tes aja biar gampang', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'blue', '-', 1, 1, '2019-07-18 10:30:58');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_logs`
--

CREATE TABLE `tbl_helpdesk_logs` (
  `id` int(32) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `value` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_tickets`
--

CREATE TABLE `tbl_helpdesk_tickets` (
  `id` int(32) NOT NULL,
  `parent_ticket_id` int(32) NOT NULL DEFAULT 0,
  `code` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `session_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `issued_by` int(32) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_tickets`
--

INSERT INTO `tbl_helpdesk_tickets` (`id`, `parent_ticket_id`, `code`, `content`, `description`, `session_id`, `is_active`, `issued_by`, `created_by`, `create_date`) VALUES
(1, 0, '2019.10.22.JE.00001', 'iyry', '-', 1571714395, 1, 0, 4, '2019-10-22 10:32:49'),
(2, 0, '2019.10.22.IMI.00001', 'oihg', '-', 1571714338, 1, 0, 1, '2019-10-22 10:34:19'),
(3, 0, '2019.10.22.JE.00002', '-', '-', 1571714395, 0, 0, 4, '2019-10-22 10:34:24'),
(4, 0, '2019.10.22.JE.00003', 'test', '-', 1571714395, 1, 0, 4, '2019-10-22 10:35:08'),
(5, 0, '2019.10.22.JE.00001', '-', '-', 1571726374, 0, 0, 4, '2019-10-22 13:40:43'),
(6, 0, '2019.10.22.JE.00002', '-', '-', 1571726374, 0, 0, 4, '2019-10-22 13:44:52'),
(7, 0, '2019.10.22.IMI.00001', '-', '-', 1571728752, 0, 0, 1, '2019-10-22 17:23:20');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_categories`
--

CREATE TABLE `tbl_helpdesk_ticket_categories` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_ina` varchar(255) NOT NULL,
  `rank` tinyint(1) NOT NULL DEFAULT 0,
  `level` tinyint(1) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `parent_id` int(32) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_categories`
--

INSERT INTO `tbl_helpdesk_ticket_categories` (`id`, `name`, `name_ina`, `rank`, `level`, `icon`, `is_active`, `description`, `parent_id`, `created_by`, `create_date`) VALUES
(1, 'SOFTWARE', 'Perangkat lunak', 0, 1, '3', 1, '-', 0, 1, '2019-05-21 09:45:00'),
(2, 'HARDWARE', 'Perangkat keras', 0, 1, '3', 1, '-', 0, 1, '2019-05-21 09:58:34'),
(3, 'NETWORK', 'Jaringan', 0, 1, '8', 1, '-', 0, 1, '2019-05-21 09:59:13'),
(4, 'SPRI & PASPOR', '', 0, 2, '8', 1, '-', 1, 1, '2019-05-21 09:59:34'),
(5, 'VISAs', 'VISAs', 0, 2, '8', 1, '-', 1, 1, '2019-05-21 09:59:54'),
(6, 'FASILITATIF', '', 3, 2, '10', 1, '-', 1, 1, '2019-05-21 10:00:07'),
(7, 'ADMINISTRATIF', '', 4, 2, '5', 1, '', 1, 1, '2019-05-21 10:00:22'),
(8, 'BCM', '', 5, 2, '10', 1, '-', 1, 1, '2019-05-21 10:00:38'),
(9, 'NYIDAKIM', '', 6, 2, '11', 1, '-', 1, 1, '2019-05-21 10:00:53'),
(10, 'RUDENIM', '', 7, 2, '11', 1, '-', 1, 1, '2019-05-21 10:01:08'),
(11, 'SERVER', '', 1, 2, '9', 1, '-', 2, 1, '2019-05-21 10:01:25'),
(12, 'PRINTER PASPOR', '', 2, 2, '5', 1, '', 2, 1, '2019-05-21 10:01:40'),
(13, 'ROUTER', '', 1, 2, '10', 1, '-', 3, 1, '2019-05-21 10:02:21'),
(14, 'MODEM', '', 2, 2, '16', 1, '-', 3, 1, '2019-05-21 10:02:35'),
(15, 'FIREWALL', '', 3, 2, '8', 1, '-', 3, 1, '2019-05-21 10:02:47'),
(16, 'LAN', '', 4, 2, '5', 1, '-', 3, 1, '2019-05-21 10:02:59'),
(17, 'Empty Ink', '', 1, 3, '7', 1, '-', 12, 6, '2019-05-27 07:43:58'),
(18, 'Cartridge ', '', 2, 3, '8', 1, '-', 12, 6, '2019-05-27 07:46:22'),
(19, 'Paper roll', '', 3, 3, '3', 1, '-', 12, 6, '2019-05-27 07:49:28'),
(20, 'Power Supply', '', 4, 3, '6', 1, '-', 12, 6, '2019-05-27 07:49:41'),
(21, 'Motherboard', '', 1, 3, '4', 1, '', 11, 6, '2019-05-27 07:49:55'),
(22, 'Processor', '', 2, 3, '8', 1, '-', 11, 6, '2019-05-27 07:50:59'),
(23, 'Power Supply', '', 3, 3, '9', 1, '', 11, 6, '2019-05-27 07:51:23'),
(25, 'E-OFFICE', 'E-OFFICE', 8, 2, '7', 1, '-', 1, 1, '2019-09-12 10:10:02'),
(26, 'IZIN TINGGAL', 'IZIN TINGGAL', 9, 2, '10', 1, '-', 1, 1, '2019-09-12 10:10:42');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_chats`
--

CREATE TABLE `tbl_helpdesk_ticket_chats` (
  `id` int(32) NOT NULL,
  `messages` text NOT NULL,
  `ticket_id` int(32) NOT NULL,
  `ticket_code` varchar(32) NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 0,
  `is_show` tinyint(1) NOT NULL DEFAULT 0,
  `is_vendor` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `reply_to` int(32) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_chats`
--

INSERT INTO `tbl_helpdesk_ticket_chats` (`id`, `messages`, `ticket_id`, `ticket_code`, `is_open`, `is_show`, `is_vendor`, `is_active`, `reply_to`, `created_by`, `create_date`) VALUES
(1, 'Tiket berhasil dibuat', 4, '2019.10.22.JE.00003', 0, 0, 0, 1, 0, 0, '2019-10-22 10:36:57'),
(2, 'telah di respon oleh superuser', 4, '2019.10.22.JE.00003', 0, 0, 0, 1, 0, 0, '2019-10-22 11:22:13'),
(3, 'ok', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 4, 1, '2019-10-22 11:22:13'),
(4, '<p>wew</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:23:10'),
(5, 'uye', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:24:49'),
(6, 'wew', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:26:34'),
(7, 'ok', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:30:30'),
(8, '<p>qw<br></p>', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 1, 1, '2019-10-22 11:32:00'),
(9, 'uyw', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:32:20'),
(10, 'po', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:32:51'),
(11, 'ojihg', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:33:05'),
(12, 'wew', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:33:42'),
(13, 'dwa', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:34:01'),
(14, 'werw', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:34:52'),
(15, 'wew', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:36:54'),
(16, 'p[', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:37:15'),
(17, '<p>wew</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 11:37:49'),
(18, 'dwa', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 12:52:55'),
(19, 'po', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 12:54:16'),
(20, 'dwa', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 12:54:45'),
(21, 'we', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 12:55:50'),
(22, 'pl', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 12:58:07'),
(23, 'dwa', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 12:59:39'),
(24, 'fe', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:00:17'),
(25, 'dw', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:00:46'),
(26, '<p>dfsfs</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:01:32'),
(27, 'dsada', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:01:52'),
(28, '<p>wee<br></p>', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 1, 1, '2019-10-22 13:02:41'),
(29, 'erwer', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 1, 1, '2019-10-22 13:04:15'),
(30, 'wda', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:08:18'),
(31, '<p>dwa</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:10:41'),
(32, '<p>asdsa<br></p>', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 1, 1, '2019-10-22 13:11:14'),
(33, 'po', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 1, 1, '2019-10-22 13:11:28'),
(34, '<p>qw<br></p>', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 1, 1, '2019-10-22 13:11:53'),
(35, '<p>dwa</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:12:57'),
(36, '<p>fse</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:13:30'),
(37, 'wad', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:13:38'),
(38, 'dwaawd', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:14:14'),
(39, '<p>wewre</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:18:47'),
(40, 'g', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:19:10'),
(41, '<p>a</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:19:57'),
(42, '<p>d</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:20:49'),
(43, '<p>ds</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:22:55'),
(44, '<p>p</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:24:17'),
(45, '<p>yu</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:26:18'),
(46, '<p>ok</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:26:59'),
(47, '<p>okl</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:27:21'),
(48, 'ds', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:27:53'),
(49, 'b', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:28:27'),
(50, '<p>fes<br></p>', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 1, 1, '2019-10-22 13:28:38'),
(51, 'woi', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 1, 1, '2019-10-22 13:29:59'),
(52, 'oi', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:30:30'),
(53, 'csa', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 1, 1, '2019-10-22 13:31:17'),
(54, 'dwa', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:37:05'),
(55, '<p>dwa</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:37:26'),
(56, '<p>f<br></p>', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 4, 1, '2019-10-22 13:38:08'),
(57, '<p>yuhu<br></p>', 4, '2019.10.22.JE.00003', 0, 1, 1, 1, 4, 1, '2019-10-22 13:40:03'),
(58, '<p>uy</p>', 4, '2019.10.22.JE.00003', 0, 1, 0, 1, 1, 4, '2019-10-22 13:40:22'),
(59, 'Tiket berhasil dibuat', 1, '2019.10.22.JE.00001', 0, 0, 0, 1, 0, 0, '2019-10-22 13:41:05'),
(60, 'ter', 1, '2019.10.22.JE.00001', 0, 1, 1, 1, 4, 6, '2019-10-22 13:45:18'),
(61, 'telah di respon oleh bayu signet', 1, '2019.10.22.JE.00001', 0, 0, 0, 1, 0, 0, '2019-10-22 13:45:18'),
(62, '<p>wew</p>', 1, '2019.10.22.JE.00001', 0, 1, 0, 1, 6, 4, '2019-10-22 13:45:37'),
(63, '<p>wew<br></p>', 1, '2019.10.22.JE.00001', 0, 1, 1, 1, 4, 6, '2019-10-22 13:47:03'),
(64, 'iryr', 1, '2019.10.22.JE.00001', 0, 1, 0, 1, 6, 4, '2019-10-22 13:47:09'),
(65, 'Tiket berhasil dibuat', 2, '2019.10.22.IMI.00001', 0, 0, 0, 1, 0, 0, '2019-10-22 17:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_files`
--

CREATE TABLE `tbl_helpdesk_ticket_files` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `path` text NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_files`
--

INSERT INTO `tbl_helpdesk_ticket_files` (`id`, `code`, `path`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, '2019.10.22.JE.00001', '2019.10.22.JE.00001/1.jpg', '-', 1, 4, '2019-10-22 10:33:01'),
(2, '2019.10.22.JE.00002', '2019.10.22.JE.00002/2.jpg', '-', 1, 4, '2019-10-22 10:34:47'),
(3, '2019.10.22.JE.00003', '2019.10.22.JE.00003/1.jpg', '-', 1, 4, '2019-10-22 10:35:19'),
(4, '2019.10.22.JE.00001', '2019.10.22.JE.00001/4.jpg', '-', 1, 4, '2019-10-22 13:41:01'),
(5, '2019.10.22.IMI.00001', '2019.10.22.IMI.00001/3.jpg', '-', 1, 1, '2019-10-22 17:23:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_handlers`
--

CREATE TABLE `tbl_helpdesk_ticket_handlers` (
  `id` int(32) NOT NULL,
  `ticket_id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `group_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_handlers`
--

INSERT INTO `tbl_helpdesk_ticket_handlers` (`id`, `ticket_id`, `user_id`, `group_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, 4, 1, 1, 1, 1, '2019-10-22 11:22:13'),
(2, 1, 6, 3, 1, 6, '2019-10-22 13:45:19');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_issue_suggestions`
--

CREATE TABLE `tbl_helpdesk_ticket_issue_suggestions` (
  `id` int(32) NOT NULL,
  `value_eng` text NOT NULL,
  `value_ina` text NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_issue_suggestions`
--

INSERT INTO `tbl_helpdesk_ticket_issue_suggestions` (`id`, `value_eng`, `value_ina`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Ok, we are already on progressing this ticket. Please wait for further information and update will be inform', 'Baik, kami akan memproses tiket ini. Mohon tunggu untuk informasi selanjutnya dan perkembangan selanjutnya akan kami informasikan.', '-', 1, 1, '2019-04-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_logs`
--

CREATE TABLE `tbl_helpdesk_ticket_logs` (
  `id` int(32) NOT NULL,
  `ticket_id` int(32) NOT NULL,
  `action` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_logs`
--

INSERT INTO `tbl_helpdesk_ticket_logs` (`id`, `ticket_id`, `action`, `is_active`, `created_by`, `create_date`) VALUES
(1, 4, 'Tiket berhasil dibuat', 1, 0, '2019-10-22 10:36:57'),
(2, 4, 'response ticket', 1, 1, '2019-10-22 11:22:13'),
(3, 1, 'Tiket berhasil dibuat', 1, 0, '2019-10-22 13:41:05'),
(4, 2, 'Tiket berhasil dibuat', 1, 0, '2019-10-22 17:23:34');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_priorities`
--

CREATE TABLE `tbl_helpdesk_ticket_priorities` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `style` varchar(255) NOT NULL,
  `checked` tinyint(1) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_priorities`
--

INSERT INTO `tbl_helpdesk_ticket_priorities` (`id`, `name`, `style`, `checked`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Low', 'has-info', 1, '-', 1, 1, '2019-03-27 00:00:00'),
(2, 'Middle', 'has-warning', 0, '-', 1, 1, '2019-03-27 00:00:00'),
(3, 'High', 'has-error', 0, '-', 1, 1, '2019-03-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_problem_impacts`
--

CREATE TABLE `tbl_helpdesk_ticket_problem_impacts` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_ina` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_problem_impacts`
--

INSERT INTO `tbl_helpdesk_ticket_problem_impacts` (`id`, `name`, `name_ina`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Affected less than 2 case', 'Kejadian kurang dari 2 kasus yang sama', '-', 1, 1, '2019-07-04 10:02:52'),
(2, 'Affected more than 2 case', 'Kejadian yang lebih dari 2 kasus yang sama', '-', 1, 1, '2019-07-04 10:03:18');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_reopen_logs`
--

CREATE TABLE `tbl_helpdesk_ticket_reopen_logs` (
  `id` int(32) NOT NULL,
  `message` text NOT NULL,
  `ticket_id` int(32) NOT NULL,
  `handle_by` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_requests`
--

CREATE TABLE `tbl_helpdesk_ticket_requests` (
  `id` int(32) NOT NULL,
  `ticket_id` int(32) NOT NULL,
  `job_list` text NOT NULL,
  `message` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_rules`
--

CREATE TABLE `tbl_helpdesk_ticket_rules` (
  `id` int(32) NOT NULL,
  `title` varchar(255) NOT NULL,
  `response_time` int(3) NOT NULL,
  `solving_time` int(8) NOT NULL,
  `fine_result` text NOT NULL,
  `priority_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(1) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_rules`
--

INSERT INTO `tbl_helpdesk_ticket_rules` (`id`, `title`, `response_time`, `solving_time`, `fine_result`, `priority_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'low', 15, 120, '100000', 0, 1, 1, '2019-04-17 00:00:00'),
(2, 'medium', 15, 120, '100000', 2, 1, 1, '2019-04-17 00:00:00'),
(3, 'high', 15, 1440, '100000', 3, 1, 1, '2019-04-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_status`
--

CREATE TABLE `tbl_helpdesk_ticket_status` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `style` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `rank` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_status`
--

INSERT INTO `tbl_helpdesk_ticket_status` (`id`, `name`, `style`, `description`, `is_active`, `rank`, `created_by`, `create_date`) VALUES
(1, 'open', '', '-', 1, 1, 1, '2019-03-27 00:00:00'),
(2, 'progress', '', '-', 1, 2, 1, '2019-03-27 00:00:00'),
(3, 'transfer', '', '-', 1, 3, 1, '2019-03-27 00:00:00'),
(4, 'close', '', '-', 1, 4, 1, '2019-03-27 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_transactions`
--

CREATE TABLE `tbl_helpdesk_ticket_transactions` (
  `id` int(32) NOT NULL,
  `ticket_id` int(32) NOT NULL,
  `category_id` int(32) NOT NULL,
  `job_id` int(32) NOT NULL,
  `status_id` int(32) NOT NULL,
  `branch_id` int(32) NOT NULL,
  `priority_id` int(32) NOT NULL,
  `rule_id` int(32) NOT NULL,
  `problem_impact_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_ticket_transactions`
--

INSERT INTO `tbl_helpdesk_ticket_transactions` (`id`, `ticket_id`, `category_id`, `job_id`, `status_id`, `branch_id`, `priority_id`, `rule_id`, `problem_impact_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, 4, 1, 4, 2, 33, 1, 1, 1, 1, 4, '2019-10-22 10:36:57'),
(2, 1, 2, 12, 2, 33, 1, 1, 1, 1, 4, '2019-10-22 13:41:05'),
(3, 2, 1, 5, 1, 155, 1, 1, 1, 1, 1, '2019-10-22 17:23:33');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_ticket_transfers`
--

CREATE TABLE `tbl_helpdesk_ticket_transfers` (
  `id` int(32) NOT NULL,
  `parent_ticket_id` int(32) NOT NULL,
  `ticket_id` int(32) NOT NULL,
  `parent_ticket_code` varchar(32) NOT NULL,
  `ticket_code` varchar(32) NOT NULL,
  `notes` text NOT NULL,
  `user_from` int(32) NOT NULL,
  `user_to` int(32) NOT NULL,
  `is_max_transfer` tinyint(1) NOT NULL,
  `is_received` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_timtik_users`
--

CREATE TABLE `tbl_helpdesk_timtik_users` (
  `id` int(32) NOT NULL,
  `nik` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `user_id` int(32) NOT NULL,
  `position_id` int(32) NOT NULL,
  `level_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_timtik_users`
--

INSERT INTO `tbl_helpdesk_timtik_users` (`id`, `nik`, `name`, `email`, `phone_number`, `user_id`, `position_id`, `level_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, '2019090601000001', 'superuser', 'superuser@imigrasi.go.id', '', 1, 0, 0, 1, 1, '2019-09-07 19:17:38'),
(2, '2019090601000002', 'adit', 'adit@imigrasi.go.id', '', 2, 0, 0, 1, 1, '2019-09-07 19:18:49');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_vendors`
--

CREATE TABLE `tbl_helpdesk_vendors` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fax` varchar(32) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_vendors`
--

INSERT INTO `tbl_helpdesk_vendors` (`id`, `code`, `name`, `address`, `phone_number`, `email`, `fax`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, '0976d1hd', 'Signet', '-', '021921312312', 'signet@gmail.com', '021432423423', '-', 1, 1, '2019-04-18 00:00:00'),
(2, '09734rtd', 'PT Maju mundur', '-', '021921312312', 'majumundur@gmail.com', '021432423423', '-', 1, 1, '2019-04-18 00:00:00'),
(3, '09324', 'PT ABC', 'jakarta', '08567465', 'abc@gmail.com', '012546678', 'desc', 1, 1, '2019-08-06 10:56:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_helpdesk_vendor_users`
--

CREATE TABLE `tbl_helpdesk_vendor_users` (
  `id` int(32) NOT NULL,
  `nik` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `vendor_id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `contract_id` int(32) NOT NULL,
  `category_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_helpdesk_vendor_users`
--

INSERT INTO `tbl_helpdesk_vendor_users` (`id`, `nik`, `name`, `phone_number`, `vendor_id`, `user_id`, `contract_id`, `category_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, '20190906011000002', 'bayu signet', '0867218387123', 1, 6, 1, 0, 1, 1, '2019-09-08 18:33:49'),
(2, '20190906011000003', 'valdi signet', '0867218387123', 1, 7, 1, 0, 1, 1, '2019-09-10 09:16:17'),
(3, '20190906011000004', 'budi signet', '0867218387123', 1, 8, 1, 0, 1, 1, '2019-09-10 09:19:40'),
(4, '20190906025000002', 'dede abc', '0867218387123', 3, 9, 1, 0, 1, 1, '2019-09-10 09:27:40'),
(5, '20190906023000006', 'dadang abc', '0867218387123', 3, 10, 1, 0, 1, 1, '2019-09-10 09:38:43'),
(6, '20190906023000007', 'syehbi signet', '0867218387123', 1, 12, 1, 0, 1, 1, '2019-09-12 15:33:50'),
(7, '20190906011000004', 'budi signet', '0867218387123', 1, 13, 1, 0, 1, 1, '2019-09-12 16:27:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_hepldesk_ticket_numbers`
--

CREATE TABLE `tbl_hepldesk_ticket_numbers` (
  `id` int(32) NOT NULL,
  `code` varchar(32) NOT NULL,
  `office_id` varchar(32) NOT NULL,
  `client_id` varchar(32) NOT NULL,
  `client_group` varchar(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_icons`
--

CREATE TABLE `tbl_icons` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_icons`
--

INSERT INTO `tbl_icons` (`id`, `name`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'fa-automobile', 'description', 1, 1, '2018-02-14 22:06:55'),
(2, 'fa-bomb', '-', 1, 1, '2018-02-14 22:09:37'),
(3, 'fa-child ', '-', 1, 1, '2018-02-14 22:10:42'),
(4, 'fa-cube', '-', 1, 1, '2018-02-14 22:13:07'),
(5, ' fa-deviantart', '-', 1, 1, '2018-02-14 22:13:35'),
(6, 'fa-envelope-square', '-', 1, 1, '2018-02-14 22:16:45'),
(7, 'fa-file-code-o ', '-', 1, 1, '2018-02-14 22:18:56'),
(8, 'fa-file-pdf-o ', '-', 1, 1, '2018-02-14 22:19:40'),
(9, ' fa-file-sound-o', '-', 1, 1, '2018-02-14 22:20:30'),
(10, 'fa-ge', '-', 1, 1, '2018-02-15 09:17:46'),
(11, 'fa-graduation-cap ', '-', 1, 1, '2018-02-15 09:18:34'),
(12, 'fa-institution', '-', 1, 1, '2018-02-15 09:19:37'),
(13, 'fa-life-bouy', '-', 1, 1, '2018-02-17 00:31:49'),
(14, 'fa-openid ', '-', 1, 1, '2018-02-18 20:15:10'),
(15, 'fa-bank', '-', 1, 1, '2018-02-18 20:17:28'),
(16, 'fa-building ', '-', 1, 1, '2018-02-18 20:19:00'),
(17, 'fa-circle-o-notch ', '-', 1, 1, '2018-02-18 20:19:53'),
(18, 'fa-cubes ', '-', 1, 1, '2018-02-18 20:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_layouts`
--

CREATE TABLE `tbl_layouts` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_layouts`
--

INSERT INTO `tbl_layouts` (`id`, `name`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'login.min.css', '-', 1, 1, '2019-03-28 00:00:00'),
(2, 'login-2.min.css', '-', 1, 1, '2019-03-28 00:00:00'),
(3, 'login-3.min.css', '-', 1, 1, '2019-03-28 00:00:00'),
(4, 'login-4.min.css', '-', 1, 1, '2019-03-28 00:00:00'),
(5, 'login-5.min.css', '-', 1, 1, '2019-03-28 00:00:00'),
(6, 'login-5.min.css', '-', 1, 1, '2019-03-28 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_layout_controllers`
--

CREATE TABLE `tbl_layout_controllers` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `script` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_layout_controllers`
--

INSERT INTO `tbl_layout_controllers` (`id`, `name`, `script`, `is_active`, `created_by`, `create_date`) VALUES
(2, 'class layout', '<?php\r\n\r\n/*\r\n * To change this license header, choose License Headers in Project Properties.\r\n * To change this template file, choose Tools | Templates\r\n * and open the template in the editor.\r\n */\r\n\r\n/**\r\n * Description of [class_name_ucfirst]\r\n *\r\n * @author SuperUser\r\n */\r\nclass [class_name_ucfirst] extends MY_Controller{\r\n\r\n    //put your code here\r\n\r\n    public function __construct() {\r\n        parent::__construct();\r\n        $this->load->model(array(\'[model_name_ucfirst]\'));\r\n    }\r\n\r\n    public function index() {\r\n        redirect([class_base_url](\'[class_path]view/\'));\r\n    }\r\n\r\n    public function view() {\r\n        $data[\'title_for_layout\'] = \'welcome\';\r\n        $data[\'view-header-title\'] = \'View [class_name_ucfirst] List\';\r\n        $data[\'content\'] = \'ini kontent web\';\r\n        $js_files = array(\r\n            static_url(\'templates/metronics/assets/global/scripts/datatable.js\'),\r\n            static_url(\'templates/metronics/assets/global/plugins/datatables/datatables.min.js\'),\r\n            static_url(\'templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js\'),\r\n        );\r\n        $this->load_js($js_files);\r\n        $this->parser->parse(\'layouts/pages/metronic.phtml\', $data);\r\n    }\r\n\r\n    public function get_list() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $this->load->library(\'pagination\');\r\n            //init config for datatables\r\n            $draw = $post[\'draw\'];\r\n            $start = $post[\'start\'];\r\n            $length = $post[\'length\'];\r\n            $search = trim($post[\'search\'][\'value\']);\r\n\r\n            $cond_count = array();\r\n            $cond[\'table\'] = $cond_count[\'table\'] = \'[model_name_ucfirst]\';\r\n            if (isset($search) && !empty($search)) {\r\n                $cond[\'like\'] = $cond_count[\'like\'] = array(\'a.name\', $search);\r\n            }\r\n            $cond[\'fields\'] = array(\'a.*\');\r\n            $cond[\'limit\'] = array(\'perpage\' => $length, \'offset\' => $start);\r\n            $total_rows = $this->[model_name_ucfirst]->find(\'count\', $cond_count);\r\n            $config = array(\r\n                \'base_url\' => [class_base_url](\'[class_path]get_list/\'),\r\n                \'total_rows\' => $total_rows,\r\n                \'per_page\' => $length,\r\n            );\r\n            $this->pagination->initialize($config);\r\n            $res = $this->[model_name_ucfirst]->find(\'all\', $cond);\r\n            $arr = array();\r\n            if (isset($res) && !empty($res)) {\r\n                $i = $start + 1;\r\n                foreach ($res as $d) {\r\n                    $status = \'\';\r\n                    if ($d[\'is_active\'] == 1) {\r\n                        $status = \'checked\';\r\n                    }\r\n                    $action_status = \'<div class=\"form-group\">\r\n                        <div class=\"col-md-9\" style=\"height:30px\">\r\n                            <input type=\"checkbox\" class=\"make-switch\" data-size=\"small\" data-value=\"\' . $d[\'is_active\'] . \'\" data-id=\"\' . $d[\'id\'] . \'\" name=\"status\" \' . $status . \'/>\r\n                        </div>\r\n                    </div>\';\r\n                    $data[\'rowcheck\'] = \'\r\n                    <div class=\"form-group form-md-checkboxes\">\r\n                        <div class=\"md-checkbox-list\">\r\n                            <div class=\"md-checkbox\">\r\n                                <input type=\"checkbox\" id=\"select_tr\' . $d[\'id\'] . \'\" class=\"md-check select_tr\" name=\"select_tr[\' . $d[\'id\'] . \']\" data-id=\"\' . $d[\'id\'] . \'\" />\r\n                                <label for=\"select_tr\' . $d[\'id\'] . \'\">\r\n                                    <span></span>\r\n                                    <span class=\"check\" style=\"left:20px;\"></span>\r\n                                    <span class=\"box\" style=\"left:14px;\"></span>\r\n                                </label>\r\n                            </div>\r\n                        </div>\r\n                    </div>\';\r\n					$data[\'num\'] = $i;\r\n                    $data[\'name\'] = $d[\'name\']; //optional	\r\n                    $data[\'active\'] = $action_status; //optional	\r\n                    $data[\'description\'] = $d[\'description\']; //optional\r\n                    $arr[] = $data;\r\n                    $i++;\r\n                }\r\n            }\r\n            $output = array(\r\n                \'draw\' => $draw,\r\n                \'recordsTotal\' => $total_rows,\r\n                \'recordsFiltered\' => $total_rows,\r\n                \'data\' => $arr,\r\n            );\r\n            //output to json format\r\n            echo json_encode($output);\r\n        } else {\r\n            echo json_encode(array());\r\n        }\r\n    }\r\n\r\n    public function get_data() {\r\n		$post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $res = $this->[model_name_ucfirst]->find(\'first\', array(\r\n                \'conditions\' => array(\'id\' => base64_decode($post[\'id\']))\r\n            ));\r\n            if (isset($res) && !empty($res)) {\r\n                echo json_encode($res);\r\n            } else {\r\n                echo null;\r\n            }\r\n        }\r\n    }\r\n\r\n    public function insert() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $status = 0;\r\n            if ($post[\'active\'] == \'true\') {\r\n                $status = 1;\r\n            }\r\n            $arr_insert = array(\r\n                \'name\' => $post[\'name\'],\r\n                \'description\' => $post[\'description\'],\r\n                \'is_active\' => $status,\r\n                \'created_by\' => (int) base64_decode($this->auth_config->user_id),\r\n                \'create_date\' => date_now()\r\n            );\r\n            $result = $this->[model_name_ucfirst]->insert($arr_insert);\r\n            if ($result == true) {\r\n                echo \'success\';\r\n            } else {\r\n                echo \'failed\';\r\n            }\r\n        } else {\r\n            echo \'failed\';\r\n        }\r\n    }\r\n\r\n    public function update() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $status = 0;\r\n            if ($post[\'active\'] == \"true\") {\r\n                $status = 1;\r\n            }\r\n            $arr = array(\r\n                \'name\' => $post[\'name\'],\r\n                \'description\' => $post[\'description\'],\r\n                \'is_active\' => $status,\r\n            );\r\n            $res = $this->[model_name_ucfirst]->update($arr, base64_decode($post[\'id\']));\r\n            if ($res == true) {\r\n                echo \'success\';\r\n            } else {\r\n                echo \'failed\';\r\n            }\r\n        } else {\r\n            echo \'failed\';\r\n        }\r\n    }\r\n\r\n    public function update_status() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $id = base64_decode($post[\'id\']);\r\n            $status = 0;\r\n            if ($post[\'active\'] == \"true\") {\r\n                $status = 1;\r\n            }\r\n            $arr = array(\r\n                \'is_active\' => $status\r\n            );\r\n            $res = $this->[model_name_ucfirst]->update($arr, $id);\r\n            if ($res == true) {\r\n                echo \'success\';\r\n            } else {\r\n                echo \'failed\';\r\n            }\r\n        }\r\n    }\r\n\r\n    public function remove() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n			if(is_array($post[\'id\'])){\r\n				$arr_res = 1;\r\n				foreach($post[\'id\'] AS $key => $val){\r\n					$arr_res = $this->[model_name_ucfirst]->remove($val);\r\n				}\r\n				if($arr_res == true){\r\n					echo \'success\';\r\n				} else {\r\n					echo \'failed\';\r\n				}\r\n			}else{\r\n				$id = base64_decode($post[\'id\']);\r\n				$res = $this->[model_name_ucfirst]->remove($id);\r\n				if ($res == true) {\r\n					echo \'success\';\r\n				} else {\r\n					echo \'failed\';\r\n				}\r\n			}\r\n        }\r\n    }\r\n\r\n    public function delete() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n			if(is_array($post[\'id\'])){\r\n				$arr_res = 1;\r\n				foreach($post[\'id\'] AS $key => $val){\r\n					$arr_res = $this->[model_name_ucfirst]->delete($val);\r\n				}\r\n				if($arr_res == true){\r\n					echo \'success\';\r\n				} else {\r\n					echo \'failed\';\r\n				}\r\n			}else{\r\n				$id = base64_decode($post[\'id\']);\r\n				$res = $this->[model_name_ucfirst]->delete($id);\r\n				if ($res == true) {\r\n					echo \'success\';\r\n				} else {\r\n					echo \'failed\';\r\n				}\r\n			}\r\n        }\r\n    }\r\n\r\n}\r\n', 1, 1, '2019-08-07 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_layout_models`
--

CREATE TABLE `tbl_layout_models` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `script` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_layout_models`
--

INSERT INTO `tbl_layout_models` (`id`, `name`, `script`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Model Default', '<?php\r\n\r\n/*\r\n * To change this license header, choose License Headers in Project Properties.\r\n * To change this template file, choose Tools | Templates\r\n * and open the template in the editor.\r\n */\r\n\r\n/**\r\n * Description of [model_name_ucfirst]\r\n *\r\n * @author SuperUser\r\n */\r\nClass [model_name_ucfirst] extends MY_Model{\r\n\r\n	public $tableName = \'model_name_ucfirst\';\r\n	\r\n	public function __construct(){\r\n		parent::__construct();\r\n	}\r\n\r\n}\r\n', 1, 1, '2019-05-06 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_layout_views`
--

CREATE TABLE `tbl_layout_views` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `view_html` text NOT NULL,
  `view_js` text NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_layout_views`
--

INSERT INTO `tbl_layout_views` (`id`, `name`, `view_html`, `view_js`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'view default', '<div class=\"row\">\r\n    <div class=\"col-md-12\">\r\n        <!-- Begin: life time stats -->\r\n        <div class=\"portlet light portlet-fit portlet-datatable bordered\">\r\n            <div class=\"portlet-title\">\r\n                <div class=\"caption\">\r\n                    <i class=\"icon-settings font-dark\"></i>\r\n                    <span class=\"caption-subject font-dark sbold uppercase\">{view-header-title}</span>\r\n                </div>\r\n                <div class=\"actions\">\r\n                    <div class=\"btn-group\">\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Insert new\" class=\"btn dark btn-outline sbold col-ms-2\" data-toggle=\"modal\" data-id=\"add\" href=\"#modal_add_edit\" id=\"opt_add\">\r\n                            <i class=\"fa fa-plus-square\"></i>\r\n                        </a>\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Update exist\" class=\"btn dark btn-outline sbold disabled col-ms-2\" data-toggle=\"modal\" data-id=\"edit\" href=\"#modal_add_edit\" id=\"opt_edit\" disabled=\"\">\r\n                            <i class=\"fa fa-pencil-square-o\"></i>\r\n                        </a>\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Remove\" class=\"btn dark btn-outline sbold disabled col-ms-2\" data-value=\"remove\" data-id=\"remove\" id=\"opt_remove\" disabled=\"\">\r\n                            <i class=\"fa fa-remove\"></i>\r\n                        </a>\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Delete\" class=\"btn dark btn-outline sbold disabled col-ms-2\" data-value=\"delete\" data-id=\"delete\" id=\"opt_delete\" disabled=\"\">\r\n                            <i class=\"fa fa-trash\"></i>\r\n                        </a>\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Refresh\" class=\"btn dark btn-outline sbold col-ms-2\" data-value=\"refresh\" data-id=\"refresh\" id=\"opt_refresh\">\r\n                            <i class=\"fa fa-refresh\"></i>\r\n                        </a>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"portlet-body\">\r\n                <div class=\"table-container\">\r\n                    <table class=\"table table-striped table-bordered table-hover table-checkable\" id=\"datatable_ajax\">\r\n                        <thead>\r\n                            <tr role=\"row\" class=\"heading\">\r\n                                <th width=\"2%\">\r\n                                    <div class=\"form-group form-md-checkboxes\">\r\n                                        <div class=\"md-checkbox-list\">\r\n                                            <div class=\"md-checkbox\">\r\n                                                <input type=\"checkbox\" id=\"select_all\" name=\"select_all\" class=\"md-check\">\r\n                                                <label for=\"select_all\">\r\n                                                    <span></span>\r\n                                                    <span class=\"check\" style=\"left:20px;\"></span>\r\n                                                    <span class=\"box\" style=\"left:14px;\"></span>\r\n                                                </label>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </th>\r\n								<th width=\"5%\"> # </th>\r\n                                <th width=\"15%\"> Name </th>\r\n                                <th width=\"15%\"> Status </th>\r\n                                <th width=\"200\"> Description </th>\r\n                            </tr>							\r\n                        </thead>\r\n                        <tbody></tbody>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <!-- End: life time stats -->\r\n    </div>\r\n</div>\r\n<!-- /.modal -->\r\n<div id=\"modal_add_edit\" class=\"modal\">\r\n    <div class=\"modal-dialog\">\r\n        <div class=\"modal-content\">\r\n            <form method=\"POST\" id=\"add_edit\">\r\n                <div class=\"modal-header\">\r\n                    <button type=\"button\" class=\"close\" data-action=\"close-modal\" aria-hidden=\"true\"></button>\r\n                    <h4 class=\"modal-title\" id=\"title_mdl\"></h4>\r\n                </div>\r\n                <div class=\"modal-body\">\r\n                    <div class=\"scroller\" style=\"height:300px\" data-always-visible=\"1\" data-rail-visible1=\"1\">\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-12\">\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"control-label\">Name</label>\r\n                                    <div class=\"input-icon right\">\r\n                                        <i class=\"fa fa-info-circle tooltips\" data-original-title=\"Email address\" data-container=\"body\"></i>\r\n                                        <input class=\"form-control\" type=\"text\" name=\"name\" /> \r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label>Description</label>\r\n                                    <textarea class=\"form-control\" rows=\"3\" name=\"description\"></textarea>\r\n                                </div>\r\n                                <div class=\"form-group\" style=\"height:30px\">\r\n                                    <label>Active</label><br/>\r\n                                    <input type=\"checkbox\" class=\"make-switch\" data-size=\"small\" name=\"status\"/>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"modal-footer\">\r\n                    <input type=\"text\" name=\"id\" hidden />\r\n                    <button type=\"button\" data-action=\"close-modal\" class=\"btn dark btn-outline\">Close</button>\r\n                    <button type=\"submit\" class=\"btn green\">Save changes</button>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>\r\n</div>', '\r\n    var TableDatatablesAjax = function () {\r\n        return {\r\n            //main function to initiate the module\r\n            init: function () {\r\n                var table = $(\'#datatable_ajax\').DataTable({\r\n                    \"lengthMenu\": [[10, 25, 50], [10, 25, 50]],\r\n                    \"sPaginationType\": \"bootstrap\",\r\n                    \"paging\": true,\r\n                    \"pagingType\": \"full_numbers\",\r\n                    \"ordering\": false,\r\n                    \"serverSide\": true,\r\n                    \"ajax\": {\r\n                        url: [class_base_url] + \'[class_path]get_list/\',\r\n                        type: \'POST\'\r\n                    },\r\n                    \"columns\": [\r\n                        {\"data\": \"rowcheck\"},\r\n                        {\"data\": \"num\"},\r\n                        {\"data\": \"name\"},\r\n                        {\"data\": \"active\"},\r\n                        {\"data\": \"description\"}\r\n                    ],\r\n                    \"drawCallback\": function (master) {\r\n                        $(\'.make-switch\').bootstrapSwitch();\r\n                    }\r\n                });\r\n\r\n                $(\'#datatable_ajax\').on(\'switchChange.bootstrapSwitch\', \'input[name=\"status\"]\', function (event, state) {\r\n                    console.log(state); // true | false\r\n                    var id = $(this).attr(\'data-id\');\r\n                    var formdata = {\r\n                        id: Base64.encode(id),\r\n                        active: state\r\n                    };\r\n                    $.ajax({\r\n                        url: [class_base_url] + \'[class_path]update_status/\',\r\n                        method: \"POST\", //First change type to method here\r\n                        data: formdata,\r\n                        success: function (response) {\r\n                            toastr.success(\'Successfully \' + response);\r\n                            return false;\r\n                        },\r\n                        error: function () {\r\n                            toastr.error(\'Failed \' + response);\r\n                            return false;\r\n                        }\r\n\r\n                    });\r\n                });\r\n\r\n                $(\'a.btn\').on(\'click\', function () {\r\n                    var action = $(this).attr(\'data-id\');\r\n                    var count = $(\'input.select_tr:checkbox\').filter(\':checked\').length;\r\n                    switch (action) {\r\n                        case \'add\':\r\n                            $(\'.modal-title\').html(\'Insert New [class_name_ucfirst]\');\r\n                            break;\r\n\r\n                        case \'edit\':\r\n                            $(\'.modal-title\').html(\'Update Exist [class_name_ucfirst]\');\r\n                            var status_ = $(this).hasClass(\'disabled\');\r\n                            var id = $(\'input.select_tr:checkbox:checked\').attr(\'data-id\');\r\n                            if (status_ == 0) {\r\n                                var formdata = {\r\n                                    id: Base64.encode(id)\r\n                                };\r\n                                $.ajax({\r\n                                    url: [class_base_url] + \'[class_path]get_data/\',\r\n                                    method: \"POST\", //First change type to method here\r\n                                    data: formdata,\r\n                                    success: function (response) {\r\n                                        var row = JSON.parse(response);\r\n                                        var status_ = false;\r\n                                        if (row.is_active == 1) {\r\n                                            status_ = true;\r\n                                        }\r\n                                        $(\'input[name=\"id\"]\').val(row.id);\r\n                                        $(\'input[name=\"name\"]\').val(row.name);\r\n                                        $(\"[name=\'status\']\").bootstrapSwitch(\'state\', status_);\r\n                                        $(\'textarea[name=\"description\"]\').val(row.description);\r\n                                        $(\'#modal_add_edit\').modal(\'show\');\r\n                                    },\r\n                                    error: function () {\r\n                                        fnToStr(\'Error is occured, please contact administrator.\', \'error\');\r\n                                    }\r\n                                });\r\n                                return false;\r\n                            }\r\n                            break;\r\n\r\n                        case \'remove\':\r\n                            bootbox.confirm(\"Are you sure to remove this id?\", function (result) {\r\n                                if (result == true) {\r\n                                    var uri = [class_base_url] + \'[class_path]remove/\';\r\n                                    if (count > 1) {\r\n                                        var ids = [];\r\n                                        $(\"input.select_tr:checkbox:checked\").each(function () {\r\n                                            ids.push($(this).data(\"id\"));\r\n                                        });\r\n                                    } else {\r\n                                        var ids = $(\'input.select_tr:checkbox:checked\').attr(\'data-id\');\r\n                                    }\r\n                                    fnActionId(uri, ids, \'remove\');\r\n                                    fnRefreshDataTable();\r\n                                    fnResetBtn();\r\n                                } else {\r\n                                    fnToStr(\'You re cancelling remove this id\', \'info\');\r\n                                    fnRefreshDataTable();\r\n                                    fnResetBtn();\r\n                                }\r\n                            });\r\n                            break;\r\n\r\n                        case \'delete\':\r\n                            bootbox.confirm(\"Are you sure to delete this id?\", function (result) {\r\n                                if (result == true) {\r\n                                    var uri = [class_base_url] + \'[class_path]delete/\';\r\n                                    if (count > 1) {\r\n                                        id = [];\r\n                                        $(\"input.select_tr:checkbox:checked\").each(function () {\r\n                                            id.push($(this).data(\"id\"));\r\n                                        });\r\n                                    }\r\n                                    fnActionId(uri, id, \'remove\');\r\n                                    fnRefreshDataTable();\r\n                                    fnResetBtn();\r\n                                } else {\r\n                                    fnToStr(\'You re cancelling delete this id\', \'info\');\r\n                                    fnRefreshDataTable();\r\n                                    fnResetBtn();\r\n                                }\r\n                            });\r\n                            break;\r\n\r\n                        case \'refresh\':\r\n                            fnRefreshDataTable();\r\n                            break;\r\n                    }\r\n                });\r\n\r\n                $(\"#add_edit\").submit(function () {\r\n                    var id = $(\'input[name=\"id\"]\').val();\r\n                    var is_active = $(\"[name=\'status\']\").bootstrapSwitch(\'state\');\r\n                    var uri = [class_base_url] + \'[class_path]insert/\';\r\n                    var txt = \'add new group\';\r\n                    var formdata = {\r\n                        name: $(\'input[name=\"name\"]\').val(),\r\n                        description: $(\'textarea[name=\"description\"]\').val(),\r\n                        active: is_active\r\n                    };\r\n                    if (id)\r\n                    {\r\n                        uri = [class_base_url] + \'[class_path]update/\';\r\n                        txt = \'update group\';\r\n                        formdata = {\r\n                            id: Base64.encode(id),\r\n                            name: $(\'input[name=\"name\"]\').val(),\r\n                            description: $(\'textarea[name=\"description\"]\').val(),\r\n                            active: is_active\r\n                        };\r\n                    }\r\n                    $.ajax({\r\n                        url: uri,\r\n                        method: \"POST\", //First change type to method here\r\n                        data: formdata,\r\n                        success: function (response) {\r\n                            toastr.success(\'Successfully \' + txt);\r\n                            fnCloseModal();\r\n                        },\r\n                        error: function () {\r\n                            toastr.error(\'Failed \' + txt);\r\n                            fnCloseModal();\r\n                        }\r\n\r\n                    });\r\n                    return false;\r\n                });\r\n            }\r\n        };\r\n\r\n    }();\r\n\r\n    jQuery(document).ready(function () {\r\n        TableDatatablesAjax.init();\r\n    });', 1, 1, '2019-05-06 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_menus`
--

CREATE TABLE `tbl_menus` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_ina` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `rank` tinyint(1) NOT NULL DEFAULT 0,
  `level` tinyint(1) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `badge` varchar(32) NOT NULL,
  `is_open` tinyint(1) NOT NULL DEFAULT 0,
  `is_badge` tinyint(1) NOT NULL DEFAULT 0,
  `module_id` int(32) DEFAULT NULL,
  `is_logged_in` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `parent_id` int(32) NOT NULL,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_menus`
--

INSERT INTO `tbl_menus` (`id`, `name`, `name_ina`, `path`, `rank`, `level`, `icon`, `badge`, `is_open`, `is_badge`, `module_id`, `is_logged_in`, `is_active`, `description`, `parent_id`, `created_by`, `create_date`) VALUES
(1, 'Tickets', 'Tiket', '#', 1, 1, '10', '', 1, 0, 2, 1, 1, '-', 0, 1, '2019-05-08 12:34:58'),
(2, 'Create', 'Buat baru', 'tickets/master/create', 1, 2, '7', '', 0, 0, 2, 1, 1, '-', 1, 1, '2019-05-08 12:37:03'),
(3, 'Views', 'Lihat', '#', 2, 2, '7', '', 1, 0, 2, 1, 1, '-', 1, 1, '2019-05-08 13:01:43'),
(4, 'Open', 'Open', 'tickets/master/view/open', 1, 3, '4', '#5ccd18', 1, 1, 2, 1, 1, '-', 3, 1, '2019-05-08 13:03:52'),
(5, 'Progress', 'Progress', 'tickets/master/view/progress', 2, 3, '7', '#ffb136', 1, 1, 2, 1, 1, '-', 3, 1, '2019-05-08 13:07:38'),
(6, 'Close', 'Close', 'tickets/master/view/close', 4, 3, '7', '#32c5d2', 1, 1, 2, 1, 1, '-', 3, 1, '2019-05-08 13:08:10'),
(7, 'Accounts', 'Akun', '#', 2, 1, '5', '', 0, 0, 2, 1, 1, '-', 0, 1, '2019-05-08 13:08:50'),
(8, 'Imigration Officer', 'Petugas Imigrasi ', 'accounts/immigration/view', 0, 2, '8', '', 0, 0, 2, 1, 1, '-', 7, 1, '2019-05-08 13:09:16'),
(9, 'vendor', 'vendor', 'accounts/vendor/view', 0, 2, '7', '', 0, 0, 2, 1, 1, '-', 7, 1, '2019-05-08 13:09:34'),
(10, 'Admin (TimTik)', 'Admin (TimTik)', 'accounts/admin/view', 0, 2, '9', '', 0, 0, 2, 1, 1, '-', 7, 1, '2019-05-08 13:10:11'),
(11, 'Master', 'Master', '#', 3, 1, '7', '', 0, 0, 2, 1, 1, '-', 0, 1, '2019-05-08 13:10:41'),
(12, 'Options', 'Opsi', '#', 3, 2, '13', '', 0, 0, 2, 1, 1, '-', 1, 1, '2019-05-08 13:11:17'),
(13, 'Categories', 'Kategori', 'tickets/category/view', 0, 3, '7', '', 0, 0, 2, 1, 1, '-', 12, 1, '2019-05-08 13:12:19'),
(14, 'Priorities', 'Prioritas', 'tickets/priority/view', 0, 3, '10', '', 0, 0, 2, 1, 1, '-', 12, 1, '2019-05-08 13:13:07'),
(15, 'Status', 'Status', 'tickets/status/view', 0, 3, '8', '', 0, 0, 2, 1, 1, '-', 12, 1, '2019-05-08 13:14:32'),
(16, 'Rules', 'Peraturan', 'tickets/rule/view', 0, 3, '7', '', 0, 0, 2, 1, 1, '-', 12, 1, '2019-05-08 13:17:08'),
(18, 'Group', 'Kelompok', 'master/group/view', 2, 2, '15', '', 0, 0, 2, 1, 1, '-', 11, 1, '2019-05-08 13:20:30'),
(19, 'Permission', 'Perizinan', 'master/permission/view', 0, 2, '11', '', 0, 0, 2, 1, 1, '-', 11, 1, '2019-05-08 13:21:43'),
(20, 'Method', 'Metode', 'master/method/view', 4, 2, '9', '', 0, 0, 2, 1, 1, '-', 11, 1, '2019-05-08 13:22:10'),
(21, 'Modules', 'Modul', 'master/module/view', 5, 2, '5', '', 0, 0, 2, 1, 1, '-', 11, 1, '2019-05-08 13:22:39'),
(22, 'Icons', 'Ikon', 'master/icon/view', 6, 2, '15', '', 0, 0, 2, 1, 1, '-', 11, 1, '2019-05-08 13:24:34'),
(23, 'Immigration Branchs', 'Kantor Imigrasi', 'tickets/immigration_branch/view', 0, 3, '10', '', 0, 0, 2, 1, 1, '-', 12, 1, '2019-05-08 13:25:31'),
(24, 'Layouts', 'Tata letak', 'master/layout/view', 7, 2, '13', '', 0, 0, 2, 1, 1, '-', 11, 1, '2019-05-08 13:26:20'),
(25, 'Prefferences', 'Pilihan', '#', 4, 1, '15', '', 0, 0, 2, 1, 1, '-', 0, 1, '2019-05-08 13:26:48'),
(26, 'Group User', 'Kelompok pengguna', 'prefferences/group_user/view', 0, 2, '4', '', 0, 0, 2, 1, 1, '-', 25, 1, '2019-05-08 13:27:22'),
(27, 'Group Permission', 'Kelompok perizinan', 'prefferences/group_permission/view', 0, 2, '11', '', 0, 0, 2, 1, 1, '-', 25, 1, '2019-05-08 13:30:06'),
(28, 'Config', 'Konfigurasi', 'prefferences/config/view', 0, 2, '16', '', 0, 0, 2, 1, 1, '-', 25, 1, '2019-05-08 13:30:47'),
(29, 'Menu', 'Menu', 'prefferences/menu/view', 0, 2, '12', '', 0, 0, 2, 1, 1, '-', 25, 1, '2019-05-08 13:31:28'),
(30, 'Email Layout', 'Rancangan surel', 'prefferences/email_layout/view', 0, 2, '10', '', 0, 0, 2, 1, 1, '-', 25, 1, '2019-05-08 13:32:05'),
(31, 'Reports', 'Laporan', '#', 5, 1, '12', '', 0, 0, 2, 1, 1, '-', 0, 1, '2019-05-08 13:49:45'),
(34, 'Ticket', 'Tiket', '#', 1, 1, '7', '', 1, 0, 3, 1, 1, '-', 0, 1, '2019-05-10 09:26:35'),
(35, 'Open', 'Open', 'vendor/ticket/view/open', 1, 2, '4', '#5ccd18', 1, 1, 3, 1, 1, '-', 34, 1, '2019-05-10 09:27:05'),
(36, 'Progress', 'Progress', 'vendor/ticket/view/progress', 2, 2, '6', '#f1c40f', 1, 1, 3, 1, 1, '-', 34, 1, '2019-05-10 09:27:43'),
(37, 'Close', 'Close', 'vendor/ticket/view/close', 4, 2, '5', '#32c5d2', 1, 1, 3, 1, 1, '-', 34, 1, '2019-05-10 09:28:21'),
(39, 'Reports', 'Laporan', '#', 2, 1, '9', '', 0, 0, 3, 1, 1, '-', 0, 1, '2019-05-10 09:29:48'),
(40, 'Export File', 'Ekspor Berkas', 'vendor/report/ticket/by_category', 1, 2, '11', '', 0, 0, 3, 1, 1, '-', 39, 1, '2019-05-10 09:30:11'),
(45, 'Ticket', 'Tiket', '#', 1, 1, '7', '', 1, 0, 1, 1, 1, '-', 0, 1, '2019-05-10 10:15:09'),
(46, 'Create New', 'Buat baru', 'ticket/create', 1, 2, '6', '', 1, 0, 1, 1, 1, '', 45, 1, '2019-05-10 10:15:51'),
(47, 'Views', 'Lihat', '#', 2, 2, '14', '', 1, 0, 1, 1, 1, '', 45, 1, '2019-05-10 10:16:32'),
(48, 'Open', 'Open', 'ticket/view/open', 1, 3, '14', '#5ccd18', 1, 1, 1, 1, 1, '', 47, 1, '2019-05-10 10:16:58'),
(49, 'Progress', 'Progress', 'ticket/view/progress', 2, 3, '12', '#ffb136', 1, 1, 1, 1, 1, '-', 47, 1, '2019-05-10 10:17:21'),
(50, 'Close', 'Close', 'ticket/view/close', 4, 3, '14', '#32c5d2', 1, 1, 1, 1, 1, '', 47, 1, '2019-05-10 10:17:48'),
(51, 'Reports', 'Laporan', '#', 2, 1, '10', '', 0, 0, 1, 1, 1, '', 0, 1, '2019-05-10 10:19:01'),
(52, 'By Category', 'Berdasarkan Kategori', 'report/ticket/by_category', 0, 2, '9', '', 0, 0, 1, 1, 1, '', 51, 1, '2019-05-10 10:19:20'),
(61, 'Transfer', 'Transfer', 'ticket/view/transfer', 3, 3, '8', '#ed6b75', 1, 1, 1, 0, 1, '-', 47, 1, '2019-05-27 15:48:25'),
(63, 'Transfer', 'Transfer', 'vendor/ticket/view/transfer', 3, 2, '9', '#ed6b75', 1, 1, 3, 1, 1, '-', 34, 1, '2019-05-27 15:50:34'),
(64, 'Ticket V1', 'Tiket V1', '#', 1, 2, '4', '', 0, 0, 2, 1, 1, '-', 31, 1, '2019-06-26 16:07:13'),
(65, 'Ticket V2', 'Tiket V2', '#', 1, 2, '11', '', 0, 0, 2, 1, 1, '', 31, 1, '2019-06-27 09:35:17'),
(69, 'By Category', 'Berdasarkan Kategori', 'reports/v2_ticket/by_category', 1, 3, '4', '', 0, 0, 2, 1, 1, '-', 65, 1, '2019-06-27 10:14:29'),
(72, 'By Ticket Code', 'Berdasarkan kode tiket', 'reports/v2_ticket/by_ticket', 2, 3, '-- select one --', '', 0, 0, 2, 1, 1, '-', 65, 1, '2019-07-01 08:19:14'),
(73, 'Problem Effect', 'Efek permasalahan', 'master/problem_effect/view', 8, 2, '6', '', 0, 0, 2, 1, 1, '-', 11, 1, '2019-07-04 09:55:13'),
(74, 'Login Notification', 'Pemberitahuan masuk', 'prefferences/login_notification/view', 5, 2, '10', '', 0, 0, 2, 1, 1, '-', 25, 1, '2019-07-12 16:10:47'),
(75, 'Ajax Plugin', 'Ajax Tambahan ', 'prefferences/ajax_plugin/view', 7, 2, '7', '', 0, 0, 2, 1, 1, '-', 25, 1, '2019-07-16 08:40:53'),
(76, 'Monitoring', 'Pemantau', 'accounts/monitor/view', 4, 2, '4', '', 0, 0, 2, 1, 1, '-', 7, 1, '2019-07-16 10:22:40'),
(77, 'Graphic', 'Grafik', 'vendor/report/monitoring/view', 2, 2, '5', '', 0, 0, 3, 1, 1, '-', 39, 1, '2019-09-12 17:34:02'),
(79, 'By category', 'Berdasarkan Kategori', 'reports/v1_ticket/by_category', 1, 3, '7', '', 0, 0, 2, 1, 1, '-', 64, 1, '2019-09-23 09:53:45'),
(80, 'By Ticket Code', 'Berdasarkan kode tiket', 'reports/v1_ticket/by_ticket', 2, 3, '10', '', 0, 0, 2, 1, 1, '-', 64, 1, '2019-09-23 09:54:57'),
(81, 'Graphics', 'Grafik', 'reports/v2_monitoring/view', 3, 3, '6', '', 0, 0, 2, 1, 1, '-', 65, 1, '2019-09-23 09:56:15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_method_masters`
--

CREATE TABLE `tbl_method_masters` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `rank` int(2) NOT NULL,
  `is_mandatory` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_method_masters`
--

INSERT INTO `tbl_method_masters` (`id`, `name`, `description`, `rank`, `is_mandatory`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'index', '-', 1, 1, 1, 1, '2018-10-17 00:00:00'),
(2, 'view', '-', 2, 1, 1, 2, '2018-10-17 00:00:00'),
(3, 'insert', '-', 3, 1, 1, 1, '2018-10-17 00:00:00'),
(4, 'remove', '-', 4, 1, 1, 2, '2018-10-17 00:00:00'),
(5, 'delete', '-', 5, 1, 1, 1, '2018-10-17 00:00:00'),
(6, 'dashboard', '-', 6, 0, 1, 1, '2018-10-17 21:39:30'),
(7, 'logout', '-', 7, 0, 1, 1, '2018-10-17 21:40:44'),
(8, 'login', '-', 8, 0, 1, 1, '2018-10-17 21:40:44'),
(9, 'auth', '-', 9, 0, 1, 1, '2018-10-17 21:40:02'),
(10, 'update', '-', 10, 1, 1, 1, '2018-10-17 00:00:00'),
(11, 'update_status', '-', 11, 0, 1, 1, '2018-10-17 00:00:00'),
(12, 'get_list', '-', 12, 1, 1, 1, '2018-10-17 00:00:00'),
(13, 'get_data', '-', 13, 1, 1, 1, '2018-10-17 00:00:00'),
(14, 'get_group', '-', 14, 0, 1, 1, '2018-10-17 00:00:00'),
(15, 'get_method', '-', 15, 0, 1, 1, '2018-10-17 00:00:00'),
(16, 'get_icon', '-', 16, 0, 1, 1, '2018-10-26 09:27:35'),
(17, 'get_menu', '-', 17, 0, 1, 1, '2018-10-29 19:57:39'),
(18, 'task', '-', 18, 0, 1, 1, '2018-11-20 21:27:47'),
(19, 'inbox', '-', 19, 0, 1, 1, '2018-11-20 21:27:58'),
(20, 'rank', '-', 20, 0, 1, 1, '2018-11-24 15:53:22');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_modules`
--

CREATE TABLE `tbl_modules` (
  `id` int(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_modules`
--

INSERT INTO `tbl_modules` (`id`, `name`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'helpdesk', '-', 1, 1, '2019-01-18 00:00:00'),
(2, 'backend', '-', 1, 1, '2019-01-18 00:00:00'),
(3, 'vendor', '-', 1, 1, '2019-01-18 00:00:00'),
(4, 'api', '-', 1, 1, '2019-01-18 00:00:00'),
(5, 'developer', '-', 1, 1, '2019-01-18 00:00:00'),
(6, 'auth', '-', 1, 1, '2019-01-18 00:00:00'),
(7, 'monitor', '-', 1, 1, '2019-07-16 10:13:06');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_permissions`
--

CREATE TABLE `tbl_permissions` (
  `id` int(32) NOT NULL,
  `module` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_permissions`
--

INSERT INTO `tbl_permissions` (`id`, `module`, `class`, `action`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'auth', 'user', 'login', '-', 1, 1, '2019-05-10 00:00:00'),
(2, 'backend', 'user', 'dashboard', '-', 1, 1, '2019-05-10 00:00:00'),
(3, 'vendor', 'user', 'dashboard', '-', 1, 1, '2019-05-10 00:00:00'),
(4, 'helpdesk', 'user', 'dashboard', '-', 1, 1, '2019-05-10 00:00:00'),
(5, 'backend', 'mvc', 'generate', '-', 1, 1, '2019-05-10 00:00:00'),
(6, 'backend', 'mvc', 'index', '-', 1, 1, '2019-05-10 00:00:00'),
(7, 'backend', 'mvc', 'get_data', '-', 1, 1, '2019-05-10 00:00:00'),
(8, 'backend', 'mvc', 'insert', '-', 1, 1, '2019-05-10 00:00:00'),
(9, 'backend', 'master', 'view', '-', 1, 1, '2019-05-10 00:00:00'),
(10, 'backend', 'master', 'get_list', '-', 1, 1, '2019-05-10 00:00:00'),
(11, 'backend', 'master', 'get_data', '-', 1, 1, '2019-05-10 00:00:00'),
(12, 'backend', 'master', 'insert', '-', 1, 1, '2019-05-10 00:00:00'),
(13, 'backend', 'master', 'update', '-', 1, 1, '2019-05-10 00:00:00'),
(14, 'backend', 'master', 'update_status', '-', 1, 1, '2019-05-10 00:00:00'),
(15, 'backend', 'master', 'remove', '-', 1, 1, '2019-05-10 00:00:00'),
(16, 'backend', 'master', 'delete', '-', 1, 1, '2019-05-10 00:00:00'),
(17, 'backend', 'master', 'get_ticket_detail', '-', 1, 1, '2019-05-10 00:00:00'),
(18, 'backend', 'master', 'get_issue_suggest', '-', 1, 1, '2019-05-10 00:00:00'),
(19, 'backend', 'master', 'set_open', '-', 1, 1, '2019-05-10 00:00:00'),
(20, 'backend', 'master', 'set_close', '-', 1, 1, '2019-05-10 00:00:00'),
(21, 'backend', 'master', 'tracking', '-', 1, 1, '2019-05-10 00:00:00'),
(22, 'backend', 'master', 'get_content', '-', 1, 1, '2019-05-10 00:00:00'),
(23, 'backend', 'master', 'insert_message', '-', 1, 1, '2019-05-10 00:00:00'),
(24, 'backend', 'master', 'create', '-', 1, 1, '2019-05-10 00:00:00'),
(25, 'backend', 'master', 'action', '-', 1, 1, '2019-05-10 00:00:00'),
(26, 'backend', 'master', 'get_vendor', '-', 1, 1, '2019-05-10 00:00:00'),
(27, 'backend', 'master', 'get_category', '-', 1, 1, '2019-05-10 00:00:00'),
(28, 'backend', 'group_permission', 'index', '-', 1, 1, '2019-05-10 00:00:00'),
(29, 'backend', 'group_permission', 'view', '-', 1, 1, '2019-05-10 00:00:00'),
(30, 'backend', 'group_permission', 'get_list', '-', 1, 1, '2019-05-10 00:00:00'),
(31, 'backend', 'group_permission', 'get_data', '-', 1, 1, '2019-05-10 00:00:00'),
(32, 'backend', 'group_permission', 'insert', '-', 1, 1, '2019-05-10 00:00:00'),
(33, 'backend', 'group_permission', 'update', '-', 1, 1, '2019-05-10 00:00:00'),
(34, 'backend', 'group_permission', 'update_status', '-', 1, 1, '2019-05-10 00:00:00'),
(35, 'backend', 'group_permission', 'remove', '-', 1, 1, '2019-05-10 00:00:00'),
(36, 'backend', 'group_permission', 'delete', '-', 1, 1, '2019-05-10 00:00:00'),
(37, 'backend', 'group_permission', 'get_module', '-', 1, 1, '2019-05-10 00:00:00'),
(38, 'backend', 'group_permission', 'get_group', '-', 1, 1, '2019-05-10 00:00:00'),
(39, 'backend', 'group_permission', 'get_method', '-', 1, 1, '2019-05-10 00:00:00'),
(40, 'backend', 'menu', 'index', '-', 1, 1, '2019-05-13 08:54:27'),
(41, 'backend', 'menu', 'view', '-', 1, 1, '2019-05-13 08:54:28'),
(42, 'backend', 'menu', 'insert', '-', 1, 1, '2019-05-13 08:54:28'),
(43, 'backend', 'menu', 'remove', '-', 1, 1, '2019-05-13 08:54:28'),
(44, 'backend', 'menu', 'delete', '-', 1, 1, '2019-05-13 08:54:28'),
(45, 'backend', 'menu', 'update', '-', 1, 1, '2019-05-13 08:54:28'),
(46, 'backend', 'menu', 'get_list', '-', 1, 1, '2019-05-13 08:54:28'),
(47, 'backend', 'menu', 'get_data', '-', 1, 1, '2019-05-13 08:54:28'),
(48, 'backend', 'menu', 'get_menu', '-', 1, 1, '2019-05-13 08:58:17'),
(49, 'backend', 'category', '', '-', 1, 1, '2019-05-13 09:09:58'),
(50, 'backend', 'category', 'index', '-', 1, 1, '2019-05-13 09:10:27'),
(51, 'backend', 'category', 'view', '-', 1, 1, '2019-05-13 09:10:27'),
(52, 'backend', 'category', 'insert', '-', 1, 1, '2019-05-13 09:10:28'),
(53, 'backend', 'category', 'remove', '-', 1, 1, '2019-05-13 09:10:28'),
(54, 'backend', 'category', 'delete', '-', 1, 1, '2019-05-13 09:10:28'),
(55, 'backend', 'category', 'update', '-', 1, 1, '2019-05-13 09:10:28'),
(56, 'backend', 'category', 'get_list', '-', 1, 1, '2019-05-13 09:10:28'),
(57, 'backend', 'category', 'get_data', '-', 1, 1, '2019-05-13 09:10:28'),
(58, 'backend', 'Priority', 'index', '-', 1, 1, '2019-05-13 09:13:12'),
(59, 'backend', 'Priority', 'view', '-', 1, 1, '2019-05-13 09:13:12'),
(60, 'backend', 'Priority', 'insert', '-', 1, 1, '2019-05-13 09:13:12'),
(61, 'backend', 'Priority', 'remove', '-', 1, 1, '2019-05-13 09:13:13'),
(62, 'backend', 'Priority', 'delete', '-', 1, 1, '2019-05-13 09:13:13'),
(63, 'backend', 'Priority', 'update', '-', 1, 1, '2019-05-13 09:13:13'),
(64, 'backend', 'Priority', 'get_list', '-', 1, 1, '2019-05-13 09:13:13'),
(65, 'backend', 'Priority', 'get_data', '-', 1, 1, '2019-05-13 09:13:13'),
(66, 'backend', 'rule', 'index', '-', 1, 1, '2019-05-13 09:14:38'),
(67, 'backend', 'rule', 'view', '-', 1, 1, '2019-05-13 09:14:38'),
(68, 'backend', 'rule', 'insert', '-', 1, 1, '2019-05-13 09:14:39'),
(69, 'backend', 'rule', 'remove', '-', 1, 1, '2019-05-13 09:14:39'),
(70, 'backend', 'rule', 'delete', '-', 1, 1, '2019-05-13 09:14:39'),
(71, 'backend', 'rule', 'update', '-', 1, 1, '2019-05-13 09:14:39'),
(72, 'backend', 'rule', 'get_list', '-', 1, 1, '2019-05-13 09:14:39'),
(73, 'backend', 'rule', 'get_data', '-', 1, 1, '2019-05-13 09:14:39'),
(74, 'backend', 'immigration_branch', 'index', '-', 1, 1, '2019-05-13 10:11:50'),
(75, 'backend', 'immigration_branch', 'view', '-', 1, 1, '2019-05-13 10:11:50'),
(76, 'backend', 'immigration_branch', 'insert', '-', 1, 1, '2019-05-13 10:11:50'),
(77, 'backend', 'immigration_branch', 'remove', '-', 1, 1, '2019-05-13 10:11:51'),
(78, 'backend', 'immigration_branch', 'delete', '-', 1, 1, '2019-05-13 10:11:51'),
(79, 'backend', 'immigration_branch', 'update', '-', 1, 1, '2019-05-13 10:11:51'),
(80, 'backend', 'immigration_branch', 'get_list', '-', 1, 1, '2019-05-13 10:11:51'),
(81, 'backend', 'immigration_branch', 'get_data', '-', 1, 1, '2019-05-13 10:11:51'),
(82, 'backend', 'immigration_branch', 'get_vendor_user_list', '-', 1, 1, '2019-05-13 10:11:51'),
(83, 'backend', 'immigration', 'index', '-', 1, 1, '2019-05-13 10:56:57'),
(84, 'backend', 'immigration', 'view', '-', 1, 1, '2019-05-13 10:56:57'),
(85, 'backend', 'immigration', 'insert', '-', 1, 1, '2019-05-13 10:56:57'),
(86, 'backend', 'immigration', 'remove', '-', 1, 1, '2019-05-13 10:56:58'),
(87, 'backend', 'immigration', 'delete', '-', 1, 1, '2019-05-13 10:56:58'),
(88, 'backend', 'immigration', 'update', '-', 1, 1, '2019-05-13 10:56:58'),
(89, 'backend', 'immigration', 'get_list', '-', 1, 1, '2019-05-13 10:56:58'),
(90, 'backend', 'immigration', 'get_data', '-', 1, 1, '2019-05-13 10:56:58'),
(91, 'backend', 'vendor', 'index', '', 1, 1, '2019-05-13 11:01:23'),
(92, 'backend', 'vendor', 'view', '', 1, 1, '2019-05-13 11:01:23'),
(93, 'backend', 'vendor', 'insert', '', 1, 1, '2019-05-13 11:01:23'),
(94, 'backend', 'vendor', 'remove', '', 1, 1, '2019-05-13 11:01:23'),
(95, 'backend', 'vendor', 'delete', '', 1, 1, '2019-05-13 11:01:23'),
(96, 'backend', 'vendor', 'update', '', 1, 1, '2019-05-13 11:01:23'),
(97, 'backend', 'vendor', 'get_list', '', 1, 1, '2019-05-13 11:01:23'),
(98, 'backend', 'vendor', 'get_data', '', 1, 1, '2019-05-13 11:01:23'),
(99, 'backend', 'vendor', 'get_vendor_user_list', '-', 1, 1, '2019-05-13 11:02:40'),
(100, 'backend', 'admin', 'index', '-', 1, 1, '2019-05-13 11:04:28'),
(101, 'backend', 'admin', 'view', '-', 1, 1, '2019-05-13 11:04:28'),
(102, 'backend', 'admin', 'insert', '-', 1, 1, '2019-05-13 11:04:28'),
(103, 'backend', 'admin', 'remove', '-', 1, 1, '2019-05-13 11:04:28'),
(104, 'backend', 'admin', 'delete', '-', 1, 1, '2019-05-13 11:04:28'),
(105, 'backend', 'admin', 'update', '-', 1, 1, '2019-05-13 11:04:28'),
(106, 'backend', 'admin', 'get_list', '-', 1, 1, '2019-05-13 11:04:28'),
(107, 'backend', 'admin', 'get_data', '-', 1, 1, '2019-05-13 11:04:29'),
(108, 'backend', 'user', 'index', '-', 1, 1, '2019-05-13 11:35:13'),
(109, 'backend', 'user', 'view', '-', 1, 1, '2019-05-13 11:35:13'),
(110, 'backend', 'user', 'insert', '-', 1, 1, '2019-05-13 11:35:13'),
(111, 'backend', 'user', 'remove', '-', 1, 1, '2019-05-13 11:35:13'),
(112, 'backend', 'user', 'delete', '-', 1, 1, '2019-05-13 11:35:13'),
(113, 'backend', 'user', 'update', '-', 1, 1, '2019-05-13 11:35:13'),
(114, 'backend', 'user', 'get_list', '-', 1, 1, '2019-05-13 11:35:13'),
(115, 'backend', 'user', 'get_data', '-', 1, 1, '2019-05-13 11:35:14'),
(116, 'backend', 'group', 'index', '-', 1, 1, '2019-05-13 11:41:51'),
(117, 'backend', 'group', 'view', '-', 1, 1, '2019-05-13 11:41:51'),
(118, 'backend', 'group', 'insert', '-', 1, 1, '2019-05-13 11:41:52'),
(119, 'backend', 'group', 'remove', '-', 1, 1, '2019-05-13 11:41:52'),
(120, 'backend', 'group', 'delete', '-', 1, 1, '2019-05-13 11:41:52'),
(121, 'backend', 'group', 'update', '-', 1, 1, '2019-05-13 11:41:52'),
(122, 'backend', 'group', 'get_list', '-', 1, 1, '2019-05-13 11:41:52'),
(123, 'backend', 'group', 'get_data', '-', 1, 1, '2019-05-13 11:41:52'),
(124, 'backend', 'method', 'index', '-', 1, 1, '2019-05-13 11:43:31'),
(125, 'backend', 'method', 'view', '-', 1, 1, '2019-05-13 11:43:31'),
(126, 'backend', 'method', 'insert', '-', 1, 1, '2019-05-13 11:43:31'),
(127, 'backend', 'method', 'remove', '-', 1, 1, '2019-05-13 11:43:31'),
(128, 'backend', 'method', 'delete', '-', 1, 1, '2019-05-13 11:43:31'),
(129, 'backend', 'method', 'update', '-', 1, 1, '2019-05-13 11:43:31'),
(130, 'backend', 'method', 'get_list', '-', 1, 1, '2019-05-13 11:43:31'),
(131, 'backend', 'method', 'get_data', '-', 1, 1, '2019-05-13 11:43:31'),
(132, 'backend', 'module', 'index', '-', 1, 1, '2019-05-13 11:45:37'),
(133, 'backend', 'module', 'view', '-', 1, 1, '2019-05-13 11:45:37'),
(134, 'backend', 'module', 'insert', '-', 1, 1, '2019-05-13 11:45:37'),
(135, 'backend', 'module', 'remove', '-', 1, 1, '2019-05-13 11:45:38'),
(136, 'backend', 'module', 'delete', '-', 1, 1, '2019-05-13 11:45:38'),
(137, 'backend', 'module', 'update', '-', 1, 1, '2019-05-13 11:45:38'),
(138, 'backend', 'module', 'get_list', '-', 1, 1, '2019-05-13 11:45:38'),
(139, 'backend', 'module', 'get_data', '-', 1, 1, '2019-05-13 11:45:38'),
(140, 'backend', 'icon', 'index', '', 1, 1, '2019-05-13 11:51:54'),
(141, 'backend', 'icon', 'view', '', 1, 1, '2019-05-13 11:51:54'),
(142, 'backend', 'icon', 'insert', '', 1, 1, '2019-05-13 11:51:54'),
(143, 'backend', 'icon', 'remove', '', 1, 1, '2019-05-13 11:51:54'),
(144, 'backend', 'icon', 'delete', '', 1, 1, '2019-05-13 11:51:54'),
(145, 'backend', 'icon', 'update', '', 1, 1, '2019-05-13 11:51:54'),
(146, 'backend', 'icon', 'get_list', '', 1, 1, '2019-05-13 11:51:55'),
(147, 'backend', 'icon', 'get_data', '', 1, 1, '2019-05-13 11:51:55'),
(148, 'backend', 'layout', 'index', '', 1, 1, '2019-05-13 11:53:20'),
(149, 'backend', 'layout', 'view', '', 1, 1, '2019-05-13 11:53:20'),
(150, 'backend', 'layout', 'insert', '', 1, 1, '2019-05-13 11:53:20'),
(151, 'backend', 'layout', 'remove', '', 1, 1, '2019-05-13 11:53:20'),
(152, 'backend', 'layout', 'delete', '', 1, 1, '2019-05-13 11:53:20'),
(153, 'backend', 'layout', 'update', '', 1, 1, '2019-05-13 11:53:20'),
(154, 'backend', 'layout', 'get_list', '', 1, 1, '2019-05-13 11:53:21'),
(155, 'backend', 'layout', 'get_data', '', 1, 1, '2019-05-13 11:53:21'),
(156, 'backend', 'Group_user', 'index', '-', 1, 1, '2019-05-13 13:16:16'),
(157, 'backend', 'Group_user', 'view', '-', 1, 1, '2019-05-13 13:16:16'),
(158, 'backend', 'Group_user', 'insert', '-', 1, 1, '2019-05-13 13:16:16'),
(159, 'backend', 'Group_user', 'remove', '-', 1, 1, '2019-05-13 13:16:16'),
(160, 'backend', 'Group_user', 'delete', '-', 1, 1, '2019-05-13 13:16:16'),
(161, 'backend', 'Group_user', 'update', '-', 1, 1, '2019-05-13 13:16:16'),
(162, 'backend', 'Group_user', 'get_list', '-', 1, 1, '2019-05-13 13:16:16'),
(163, 'backend', 'Group_user', 'get_data', '-', 1, 1, '2019-05-13 13:16:16'),
(164, 'backend', 'group_user', 'get_group', '-', 1, 1, '2019-05-13 13:20:32'),
(165, 'backend', 'group_user', 'get_user', '-', 1, 1, '2019-05-13 13:20:54'),
(166, 'backend', 'config', 'index', '-', 1, 1, '2019-05-13 13:22:16'),
(167, 'backend', 'config', 'view', '-', 1, 1, '2019-05-13 13:22:16'),
(168, 'backend', 'config', 'insert', '-', 1, 1, '2019-05-13 13:22:16'),
(169, 'backend', 'config', 'remove', '-', 1, 1, '2019-05-13 13:22:17'),
(170, 'backend', 'config', 'delete', '-', 1, 1, '2019-05-13 13:22:17'),
(171, 'backend', 'config', 'update', '-', 1, 1, '2019-05-13 13:22:17'),
(172, 'backend', 'config', 'get_list', '-', 1, 1, '2019-05-13 13:22:17'),
(173, 'backend', 'config', 'get_data', '-', 1, 1, '2019-05-13 13:22:17'),
(174, 'backend', 'email_layout', 'index', '', 1, 1, '2019-05-13 13:26:11'),
(175, 'backend', 'email_layout', 'view', '', 1, 1, '2019-05-13 13:26:11'),
(176, 'backend', 'email_layout', 'insert', '', 1, 1, '2019-05-13 13:26:11'),
(177, 'backend', 'email_layout', 'remove', '', 1, 1, '2019-05-13 13:26:11'),
(178, 'backend', 'email_layout', 'delete', '', 1, 1, '2019-05-13 13:26:12'),
(179, 'backend', 'email_layout', 'update', '', 1, 1, '2019-05-13 13:26:12'),
(180, 'backend', 'email_layout', 'get_list', '', 1, 1, '2019-05-13 13:26:12'),
(181, 'backend', 'email_layout', 'get_data', '', 1, 1, '2019-05-13 13:26:12'),
(182, 'backend', 'email_layout', 'index', '', 1, 1, '2019-05-13 13:26:12'),
(183, 'backend', 'email_layout', 'view', '', 1, 1, '2019-05-13 13:26:12'),
(184, 'backend', 'email_layout', 'insert', '', 1, 1, '2019-05-13 13:26:12'),
(185, 'backend', 'email_layout', 'remove', '', 1, 1, '2019-05-13 13:26:12'),
(186, 'backend', 'email_layout', 'delete', '', 1, 1, '2019-05-13 13:26:12'),
(187, 'backend', 'email_layout', 'update', '', 1, 1, '2019-05-13 13:26:12'),
(188, 'backend', 'email_layout', 'get_list', '', 1, 1, '2019-05-13 13:26:13'),
(189, 'backend', 'email_layout', 'get_data', '', 1, 1, '2019-05-13 13:26:13'),
(190, 'backend', 'ticket', 'index', '-', 1, 1, '2019-05-13 13:39:11'),
(191, 'backend', 'ticket', 'view', '-', 1, 1, '2019-05-13 13:39:11'),
(192, 'backend', 'ticket', 'insert', '-', 1, 1, '2019-05-13 13:39:11'),
(193, 'backend', 'ticket', 'remove', '-', 1, 1, '2019-05-13 13:39:11'),
(194, 'backend', 'ticket', 'delete', '-', 1, 1, '2019-05-13 13:39:11'),
(195, 'backend', 'ticket', 'update', '-', 1, 1, '2019-05-13 13:39:11'),
(196, 'backend', 'ticket', 'get_list', '-', 1, 1, '2019-05-13 13:39:12'),
(197, 'backend', 'ticket', 'get_data', '-', 1, 1, '2019-05-13 13:39:12'),
(198, 'backend', 'ticket', 'by_category', '-', 1, 1, '2019-05-13 13:39:36'),
(199, 'backend', 'ticket', 'by_date', '-', 1, 1, '2019-05-13 13:40:55'),
(200, 'backend', 'vendor', 'get_vendors', '-', 1, 1, '2019-05-13 14:07:30'),
(201, 'backend', 'vendor', 'insert_user', '-', 1, 1, '2019-05-13 14:09:34'),
(202, 'backend', 'vendor', 'update_user', '-', 1, 1, '2019-05-13 14:10:04'),
(203, 'backend', 'vendor', 'get_category', '-', 1, 1, '2019-05-14 14:48:37'),
(204, 'vendor', 'ticket', 'get_list', '-', 1, 1, '2019-05-14 15:11:09'),
(205, 'backend', 'vendor', 'get_vendor_user', '-', 1, 1, '2019-05-14 15:56:27'),
(207, 'backend', 'vendor', 'assign_category_user', '-', 1, 1, '2019-05-14 16:34:56'),
(208, 'backend', 'master', 'detail', '-', 1, 1, '2019-05-14 16:51:13'),
(209, 'helpdesk', 'ticket', 'index', '-', 1, 1, '2019-05-15 07:28:41'),
(210, 'helpdesk', 'ticket', 'view', '-', 1, 1, '2019-05-15 07:28:41'),
(211, 'helpdesk', 'ticket', 'insert', '-', 1, 1, '2019-05-15 07:28:41'),
(212, 'helpdesk', 'ticket', 'remove', '-', 1, 1, '2019-05-15 07:28:41'),
(213, 'helpdesk', 'ticket', 'delete', '-', 1, 1, '2019-05-15 07:28:41'),
(214, 'helpdesk', 'ticket', 'update', '-', 1, 1, '2019-05-15 07:28:41'),
(215, 'helpdesk', 'ticket', 'get_list', '-', 1, 1, '2019-05-15 07:28:41'),
(216, 'helpdesk', 'ticket', 'get_data', '-', 1, 1, '2019-05-15 07:28:42'),
(217, 'helpdesk', 'ticket', 'create', '-', 1, 1, '2019-05-15 07:29:31'),
(218, 'helpdesk', 'ticket', 'get_category', '-', 1, 1, '2019-05-15 07:33:06'),
(219, 'helpdesk', 'ticket', 'tracking', '-', 1, 1, '2019-05-15 07:34:19'),
(221, 'helpdesk', 'ticket', 'get_ticket_detail', '-', 1, 1, '2019-05-15 07:39:49'),
(222, 'helpdesk', 'ticket', 'insert_message', '-', 1, 1, '2019-05-15 07:40:13'),
(223, 'helpdesk', 'ticket', 'get_content', '-', 1, 1, '2019-05-15 07:41:30'),
(224, 'vendor', 'user', 'get_ticket_detail', '-', 1, 1, '2019-05-15 08:01:15'),
(225, 'vendor', 'user', 'get_issue_suggest', '-', 1, 1, '2019-05-15 08:03:04'),
(226, 'vendor', 'ticket', 'set_close', '', 1, 1, '2019-05-15 08:03:24'),
(227, 'vendor', 'ticket', 'get_list', '', 1, 1, '2019-05-15 08:03:54'),
(228, 'vendor', 'ticket', 'tracking', '', 1, 1, '2019-05-15 08:04:13'),
(229, 'vendor', 'ticket', 'view', '', 1, 1, '2019-05-15 08:04:33'),
(230, 'vendor', 'ticket', 'set_open', '', 1, 1, '2019-05-15 08:07:27'),
(231, 'vendor', 'ticket', 'by_category', '', 1, 1, '2019-05-15 08:43:46'),
(232, 'vendor', 'ticket', 'by_date', '', 1, 1, '2019-05-15 08:44:09'),
(233, 'backend', 'user', 'my_profile', '', 1, 1, '2019-05-16 10:41:04'),
(234, 'backend', 'user', 'my_inbox', '-', 1, 1, '2019-05-16 10:41:23'),
(235, 'backend', 'user', 'lock_screen', '', 1, 1, '2019-05-16 10:41:56'),
(236, 'backend', 'user', 'un_lock_screen', '', 1, 1, '2019-05-16 10:42:14'),
(237, 'backend', 'status', 'index', '', 1, 1, '2019-05-16 13:30:22'),
(238, 'backend', 'status', 'view', '', 1, 1, '2019-05-16 13:30:23'),
(239, 'backend', 'status', 'insert', '', 1, 1, '2019-05-16 13:30:23'),
(240, 'backend', 'status', 'remove', '', 1, 1, '2019-05-16 13:30:23'),
(241, 'backend', 'status', 'delete', '', 1, 1, '2019-05-16 13:30:23'),
(242, 'backend', 'status', 'update', '', 1, 1, '2019-05-16 13:30:23'),
(243, 'backend', 'status', 'get_list', '', 1, 1, '2019-05-16 13:30:23'),
(244, 'backend', 'status', 'get_data', '', 1, 1, '2019-05-16 13:30:23'),
(245, 'vendor', 'user', 'index', '', 1, 1, '2019-05-16 15:04:20'),
(246, 'vendor', 'user', 'view', '', 1, 1, '2019-05-16 15:04:20'),
(247, 'vendor', 'user', 'insert', '', 1, 1, '2019-05-16 15:04:20'),
(248, 'vendor', 'user', 'remove', '', 1, 1, '2019-05-16 15:04:20'),
(249, 'vendor', 'user', 'delete', '', 1, 1, '2019-05-16 15:04:20'),
(250, 'vendor', 'user', 'update', '', 1, 1, '2019-05-16 15:04:20'),
(251, 'vendor', 'user', 'get_list', '', 1, 1, '2019-05-16 15:04:20'),
(252, 'vendor', 'user', 'get_data', '', 1, 1, '2019-05-16 15:04:20'),
(253, 'vendor', 'user', 'my_profile', '', 1, 1, '2019-05-16 15:04:56'),
(254, 'vendor', 'user', 'lock_screen', '', 1, 1, '2019-05-16 15:05:18'),
(255, 'vendor', 'user', 'un_lock_screen', '', 1, 1, '2019-05-16 15:05:34'),
(256, 'backend', 'user', 'get_user', '', 1, 1, '2019-05-20 08:49:44'),
(257, 'backend', 'master', 'response_ticket', '', 1, 1, '2019-05-20 13:13:22'),
(258, 'backend', 'category', 'get_category', '', 1, 1, '2019-05-21 08:04:43'),
(259, 'vendor', 'ticket', 'check_status_ticket', '', 1, 1, '2019-05-21 11:09:07'),
(260, 'vendor', 'ticket', 'get_ticket_detail', '', 1, 1, '2019-05-21 13:47:02'),
(261, 'vendor', 'ticket', 'response_ticket', '', 1, 1, '2019-05-21 14:10:08'),
(262, 'backend', 'ticket', 'by_ticket', '', 1, 1, '2019-05-23 11:09:45'),
(263, 'backend', 'ticket', 'generate', '', 1, 1, '2019-05-23 13:39:02'),
(264, 'vendor', 'ticket', 'tracking', '', 1, 1, '2019-05-24 08:40:34'),
(265, 'vendor', 'tracking', 'index', '', 1, 1, '2019-05-24 08:43:26'),
(266, 'vendor', 'tracking', 'view', '', 1, 1, '2019-05-24 08:43:26'),
(267, 'vendor', 'tracking', 'insert', '', 1, 1, '2019-05-24 08:43:26'),
(268, 'vendor', 'tracking', 'remove', '', 1, 1, '2019-05-24 08:43:26'),
(269, 'vendor', 'tracking', 'delete', '', 1, 1, '2019-05-24 08:43:26'),
(270, 'vendor', 'tracking', 'update', '', 1, 1, '2019-05-24 08:43:26'),
(271, 'vendor', 'tracking', 'get_list', '', 1, 1, '2019-05-24 08:43:26'),
(272, 'vendor', 'tracking', 'get_data', '', 1, 1, '2019-05-24 08:43:26'),
(273, 'vendor', 'tracking', 'get_content', '', 1, 1, '2019-05-24 08:46:58'),
(274, 'vendor', 'tracking', 'get_ticket_detail', '', 1, 1, '2019-05-24 08:47:32'),
(275, 'helpdesk', 'ticket', 'index', '', 1, 1, '2019-05-24 10:03:40'),
(276, 'helpdesk', 'ticket', 'view', '', 1, 1, '2019-05-24 10:03:41'),
(277, 'helpdesk', 'ticket', 'insert', '', 1, 1, '2019-05-24 10:03:41'),
(278, 'helpdesk', 'ticket', 'remove', '', 1, 1, '2019-05-24 10:03:41'),
(279, 'helpdesk', 'ticket', 'delete', '', 1, 1, '2019-05-24 10:03:41'),
(280, 'helpdesk', 'ticket', 'update', '', 1, 1, '2019-05-24 10:03:41'),
(281, 'helpdesk', 'ticket', 'get_list', '', 1, 1, '2019-05-24 10:03:41'),
(282, 'helpdesk', 'ticket', 'get_data', '', 1, 1, '2019-05-24 10:03:41'),
(291, 'helpdesk', 'ticket', 'by_category', '', 1, 1, '2019-05-24 10:07:00'),
(292, 'helpdesk', 'ticket', 'by_date', '', 1, 1, '2019-05-24 10:15:07'),
(293, 'helpdesk', 'ticket', 'by_ticket', '', 1, 1, '2019-05-24 10:15:32'),
(294, 'backend', 'master', 'get_job_desc', '-', 1, 6, '2019-05-27 08:15:19'),
(295, 'backend', 'master', 'close_ticket', '', 1, 6, '2019-05-27 08:50:02'),
(296, 'helpdesk', 'ticket', 'close_status', '', 1, 6, '2019-05-27 10:43:26'),
(297, 'backend', 'master', 'check_ticket_timeout', '', 1, 1, '2019-05-27 12:47:57'),
(298, 'vendor', 'tracking', 'insert_message', '-', 1, 1, '2019-05-27 13:30:23'),
(299, 'api', 'tracking', 'get_job_desc', '', 1, 1, '2019-05-27 13:51:43'),
(300, 'vendor', 'tracking', 'get_job_desc', '', 1, 1, '2019-05-27 14:07:28'),
(301, 'vendor', 'tracking', 'close_ticket', '', 1, 1, '2019-05-27 15:06:16'),
(302, 'backend', 'permissions', 'index', '', 1, 1, '2019-05-28 13:31:10'),
(303, 'backend', 'permissions', 'view', '', 1, 1, '2019-05-28 13:31:11'),
(304, 'backend', 'permissions', 'insert', '', 1, 1, '2019-05-28 13:31:11'),
(305, 'backend', 'permissions', 'remove', '', 1, 1, '2019-05-28 13:31:11'),
(306, 'backend', 'permissions', 'delete', '', 1, 1, '2019-05-28 13:31:11'),
(307, 'backend', 'permissions', 'update', '', 1, 1, '2019-05-28 13:31:11'),
(308, 'backend', 'permissions', 'get_list', '', 1, 1, '2019-05-28 13:31:11'),
(309, 'backend', 'permissions', 'get_data', '', 1, 1, '2019-05-28 13:31:11'),
(310, 'backend', 'master', 'check_ticket_open', '', 1, 1, '2019-05-29 11:12:44'),
(311, 'backend', 'user', 'get_history', '', 1, 1, '2019-06-10 14:09:48'),
(312, 'backend', 'group', 'update_status', '', 1, 1, '2019-06-10 17:02:51'),
(313, 'helpdesk', 'ticket', 'generate', '-', 1, 1, '2019-06-24 13:39:54'),
(314, 'vendor', 'user', 'get_history', '-', 1, 1, '2019-06-26 17:04:48'),
(315, 'vendor', 'ticket', 'by_ticket', '-', 1, 1, '2019-06-28 16:48:20'),
(316, 'helpdesk', 'user', 'my_profile', '-', 1, 1, '2019-07-01 10:30:08'),
(317, 'helpdesk', 'user', 'get_data', '-', 1, 1, '2019-07-01 10:33:30'),
(318, 'backend', 'master', 'mark_as_solve', '-', 1, 1, '2019-07-01 15:14:24'),
(319, 'helpdesk', 'ticket', 'action', '-', 1, 1, '2019-07-02 09:09:53'),
(320, 'vendor', 'tracking', 'success_close', '-', 1, 1, '2019-07-03 08:54:06'),
(321, 'backend', 'mvc', 'reset', '-', 1, 1, '2019-07-03 10:09:58'),
(322, 'backend', 'problem_effect', 'index', '-', 1, 1, '2019-07-04 10:00:11'),
(323, 'backend', 'problem_effect', 'view', '-', 1, 1, '2019-07-04 10:00:11'),
(324, 'backend', 'problem_effect', 'insert', '-', 1, 1, '2019-07-04 10:00:11'),
(325, 'backend', 'problem_effect', 'remove', '-', 1, 1, '2019-07-04 10:00:11'),
(326, 'backend', 'problem_effect', 'delete', '-', 1, 1, '2019-07-04 10:00:11'),
(327, 'backend', 'problem_effect', 'update', '-', 1, 1, '2019-07-04 10:00:11'),
(328, 'backend', 'problem_effect', 'get_list', '-', 1, 1, '2019-07-04 10:00:11'),
(329, 'backend', 'problem_effect', 'get_data', '-', 1, 1, '2019-07-04 10:00:11'),
(330, 'backend', 'ticket_v1', 'index', '-', 1, 1, '2019-07-05 09:42:07'),
(331, 'backend', 'ticket_v1', 'view', '-', 1, 1, '2019-07-05 09:42:07'),
(332, 'backend', 'ticket_v1', 'insert', '-', 1, 1, '2019-07-05 09:42:07'),
(333, 'backend', 'ticket_v1', 'remove', '-', 1, 1, '2019-07-05 09:42:07'),
(334, 'backend', 'ticket_v1', 'delete', '-', 1, 1, '2019-07-05 09:42:08'),
(335, 'backend', 'ticket_v1', 'update', '-', 1, 1, '2019-07-05 09:42:08'),
(336, 'backend', 'ticket_v1', 'get_list', '-', 1, 1, '2019-07-05 09:42:08'),
(337, 'backend', 'ticket_v1', 'get_data', '-', 1, 1, '2019-07-05 09:42:08'),
(338, 'helpdesk', 'ticket', 'insert_image_summernote', '-', 1, 1, '2019-07-08 16:53:28'),
(339, 'vendor', 'tracking', 'insert_image_summernote', '-', 1, 1, '2019-07-08 17:36:24'),
(340, 'backend', 'master', 'insert_image_summernote', '-', 1, 1, '2019-07-08 18:26:18'),
(341, 'backend', 'master', 'set_priority', '-', 1, 1, '2019-07-11 09:33:48'),
(342, 'backend', 'Login_notification', 'index', '-', 1, 1, '2019-07-12 16:16:16'),
(343, 'backend', 'Login_notification', 'view', '-', 1, 1, '2019-07-12 16:16:16'),
(344, 'backend', 'Login_notification', 'insert', '-', 1, 1, '2019-07-12 16:16:17'),
(345, 'backend', 'Login_notification', 'remove', '-', 1, 1, '2019-07-12 16:16:17'),
(346, 'backend', 'Login_notification', 'delete', '-', 1, 1, '2019-07-12 16:16:17'),
(347, 'backend', 'Login_notification', 'update', '-', 1, 1, '2019-07-12 16:16:17'),
(348, 'backend', 'Login_notification', 'get_list', '-', 1, 1, '2019-07-12 16:16:17'),
(349, 'backend', 'Login_notification', 'get_data', '-', 1, 1, '2019-07-12 16:16:17'),
(351, 'helpdesk', 'ticket', 'reopen', '-', 1, 1, '2019-07-15 09:54:19'),
(352, 'api', 'request', 'get_ajax_text_plugin', '-', 1, 1, '2019-07-15 17:02:41'),
(353, 'api', 'request', 'get_ajax_text_plugin', '-', 1, 1, '2019-07-15 17:03:01'),
(354, 'api', 'request', 'get_ajax_text_plugin', '-', 1, 1, '2019-07-15 17:03:28'),
(355, 'api', 'request', 'get_content', '', 1, 1, '2019-07-15 21:51:02'),
(358, 'backend', 'ajax_plugin', 'index', '-', 1, 1, '2019-07-16 09:14:39'),
(359, 'backend', 'ajax_plugin', 'view', '-', 1, 1, '2019-07-16 09:14:39'),
(360, 'backend', 'ajax_plugin', 'insert', '-', 1, 1, '2019-07-16 09:14:39'),
(361, 'backend', 'ajax_plugin', 'remove', '-', 1, 1, '2019-07-16 09:14:39'),
(362, 'backend', 'ajax_plugin', 'delete', '-', 1, 1, '2019-07-16 09:14:39'),
(363, 'backend', 'ajax_plugin', 'update', '-', 1, 1, '2019-07-16 09:14:39'),
(364, 'backend', 'ajax_plugin', 'get_list', '-', 1, 1, '2019-07-16 09:14:39'),
(365, 'backend', 'ajax_plugin', 'get_data', '-', 1, 1, '2019-07-16 09:14:40'),
(366, 'backend', 'monitor', 'index', '-', 1, 1, '2019-07-16 10:26:15'),
(367, 'backend', 'monitor', 'view', '-', 1, 1, '2019-07-16 10:26:15'),
(368, 'backend', 'monitor', 'insert', '-', 1, 1, '2019-07-16 10:26:15'),
(369, 'backend', 'monitor', 'remove', '-', 1, 1, '2019-07-16 10:26:15'),
(370, 'backend', 'monitor', 'delete', '-', 1, 1, '2019-07-16 10:26:15'),
(371, 'backend', 'monitor', 'update', '-', 1, 1, '2019-07-16 10:26:16'),
(372, 'backend', 'monitor', 'get_list', '-', 1, 1, '2019-07-16 10:26:16'),
(373, 'backend', 'monitor', 'get_data', '-', 1, 1, '2019-07-16 10:26:16'),
(374, 'monitor', 'user', 'index', '-', 1, 1, '2019-07-17 08:48:34'),
(375, 'monitor', 'user', 'view', '-', 1, 1, '2019-07-17 08:48:34'),
(376, 'monitor', 'user', 'insert', '-', 1, 1, '2019-07-17 08:48:34'),
(377, 'monitor', 'user', 'remove', '-', 1, 1, '2019-07-17 08:48:34'),
(378, 'monitor', 'user', 'delete', '-', 1, 1, '2019-07-17 08:48:35'),
(379, 'monitor', 'user', 'update', '-', 1, 1, '2019-07-17 08:48:35'),
(380, 'monitor', 'user', 'get_list', '-', 1, 1, '2019-07-17 08:48:35'),
(381, 'monitor', 'user', 'get_data', '-', 1, 1, '2019-07-17 08:48:35'),
(382, 'monitor', 'user', 'dashboard', '', 1, 1, '2019-07-17 08:54:26'),
(383, 'api', 'request', 'get_ajax_text_plugin', '-', 1, 1, '2019-07-17 16:22:32'),
(384, 'api', 'request', 'get_ajax_text_plugin', '-', 1, 1, '2019-07-17 16:22:50'),
(385, 'api', 'request', 'get_ajax_text_plugin', '-', 1, 1, '2019-07-17 16:23:10'),
(386, 'helpdesk', 'request', 'get_content', '-', 1, 1, '2019-07-17 16:25:23'),
(387, 'api', 'user', 'get_running_text', '', 1, 1, '2019-07-18 10:42:57'),
(388, 'auth', 'user', 'ticket_push', '-', 1, 1, '2019-07-22 15:18:12'),
(390, 'monitor', 'ticket', 'index', '-', 1, 1, '2019-07-23 08:23:38'),
(391, 'monitor', 'ticket', 'view', '-', 1, 1, '2019-07-23 08:23:38'),
(392, 'monitor', 'ticket', 'get_list', '-', 1, 1, '2019-07-23 08:23:38'),
(393, 'auth', 'user', 'ticket_push', '-', 1, 1, '2019-07-25 10:36:05'),
(394, 'vendor', 'user', 'get_user', '-', 1, 1, '2019-07-25 14:19:24'),
(395, 'vendor', 'user', 'transfer_ticket', '-', 1, 1, '2019-07-25 14:31:31'),
(396, 'backend', 'master', 'transfer_ticket', '-', 1, 1, '2019-07-25 15:09:18'),
(397, 'helpdesk', 'user', 'update', '-', 1, 1, '2019-07-28 18:54:20'),
(398, 'vendor', 'ticket', 'check_ticket_timeout', '-', 1, 1, '2019-07-28 21:48:55'),
(399, 'vendor', 'user', 'update', '-', 1, 1, '2019-07-28 21:56:58'),
(400, 'backend', 'master', 'reopen', '-', 1, 1, '2019-07-29 07:24:12'),
(401, 'backend', 'priority', 'update_status', '-', 1, 1, '2019-08-01 17:34:28'),
(402, 'backend', 'status', 'update_status', '-', 1, 1, '2019-08-01 17:37:18'),
(403, 'backend', 'immigration', 'update_status', '-', 1, 1, '2019-08-02 08:00:42'),
(404, 'backend', 'rule', 'update_status', '-', 1, 1, '2019-08-02 14:28:28'),
(405, 'backend', 'immigration_branch', 'update_status', '-', 1, 1, '2019-08-02 15:00:54'),
(406, 'backend', 'vendor', 'update_status_vendor', '-', 1, 1, '2019-08-05 08:39:16'),
(407, 'backend', 'vendor', 'insert_vendor', '-', 1, 1, '2019-08-05 08:39:40'),
(408, 'backend', 'vendor', 'update_vendor', '-', 1, 1, '2019-08-05 08:39:58'),
(409, 'backend', 'mvc', 'get_category', '-', 1, 1, '2019-08-07 09:26:10'),
(410, 'backend', 'mvc', 'insert_ticket', '-', 1, 1, '2019-08-07 09:46:11'),
(411, 'backend', 'vendor', 'get_data_vendor_user', '-', 1, 1, '2019-08-08 15:07:32'),
(412, 'vendor', 'ticket', 'agreement_to_take_over_ticket', '-', 1, 1, '2019-08-12 11:50:33'),
(413, 'helpdesk', 'user', 'get_history', '-', 1, 1, '2019-08-14 09:56:07'),
(414, 'monitor', 'user', 'get_total_ticket_per_month', '-', 1, 1, '2019-08-19 13:35:00'),
(415, 'backend', 'master', 'agreement_to_take_over_ticket', '-', 1, 1, '2019-08-23 11:29:41'),
(416, 'vendor', 'ticket', 'check_ticket_open', '', 1, 9, '2019-08-26 11:20:04'),
(417, 'vendor', 'tracking', 'close_ticket_request', '-', 1, 1, '2019-09-02 17:28:06'),
(418, 'backend', 'master', 'check_status_ticket', '-', 1, 9, '2019-09-03 19:44:10'),
(419, 'monitor', 'user', 'get_total_ticket_per_month_by_status', '-', 1, 1, '2019-09-04 09:37:22'),
(420, 'vendor', 'ticket', 'get_category', '-', 1, 1, '2019-09-09 13:08:24'),
(421, 'vendor', 'ticket', 'get_data', '-', 1, 1, '2019-09-09 13:26:48'),
(422, 'backend', 'vendor', 'delete_user', '-', 1, 1, '2019-09-12 16:58:00'),
(423, 'vendor', 'monitoring', 'index', '-', 1, 1, '2019-09-12 17:11:47'),
(424, 'vendor', 'monitoring', 'view', '-', 1, 1, '2019-09-12 17:11:48'),
(425, 'vendor', 'monitoring', 'insert', '-', 1, 1, '2019-09-12 17:11:48'),
(426, 'vendor', 'monitoring', 'remove', '-', 1, 1, '2019-09-12 17:11:48'),
(427, 'vendor', 'monitoring', 'delete', '-', 1, 1, '2019-09-12 17:11:48'),
(428, 'vendor', 'monitoring', 'update', '-', 1, 1, '2019-09-12 17:11:48'),
(429, 'vendor', 'monitoring', 'get_list', '-', 1, 1, '2019-09-12 17:11:48'),
(430, 'vendor', 'monitoring', 'get_data', '-', 1, 1, '2019-09-12 17:11:48'),
(431, 'vendor', 'monitoring', 'get_total_ticket_per_month', '-', 1, 1, '2019-09-12 17:12:10'),
(432, 'vendor', 'monitoring', 'get_total_ticket_per_month_by_status', '-', 1, 1, '2019-09-12 17:12:28'),
(433, 'vendor', 'monitoring', 'get_total_ticket_per_month_by_user', '-', 1, 1, '2019-09-13 10:06:44'),
(434, 'backend', 'monitoring', 'index', '-', 1, 1, '2019-09-13 10:14:18'),
(435, 'backend', 'monitoring', 'view', '-', 1, 1, '2019-09-13 10:14:18'),
(436, 'backend', 'monitoring', 'insert', '-', 1, 1, '2019-09-13 10:14:18'),
(437, 'backend', 'monitoring', 'remove', '-', 1, 1, '2019-09-13 10:14:18'),
(438, 'backend', 'monitoring', 'delete', '-', 1, 1, '2019-09-13 10:14:18'),
(439, 'backend', 'monitoring', 'update', '-', 1, 1, '2019-09-13 10:14:18'),
(440, 'backend', 'monitoring', 'get_list', '-', 1, 1, '2019-09-13 10:14:18'),
(441, 'backend', 'monitoring', 'get_data', '-', 1, 1, '2019-09-13 10:14:18'),
(442, 'backend', 'monitoring', 'get_total_ticket_per_month', '-', 1, 1, '2019-09-13 10:14:41'),
(443, 'backend', 'monitoring', 'get_total_ticket_per_month_by_status', '-', 1, 1, '2019-09-13 10:14:59'),
(444, 'backend', 'monitoring', 'get_total_ticket_per_month_by_user', '-', 1, 1, '2019-09-13 10:15:19'),
(445, 'backend', 'master', 'check_row_date', '-', 1, 2, '2019-09-16 13:34:22'),
(446, 'backend', 'V1_ticket', 'index', '-', 1, 1, '2019-09-23 11:39:21'),
(447, 'backend', 'V1_ticket', 'view', '-', 1, 1, '2019-09-23 11:39:21'),
(448, 'backend', 'V1_ticket', 'get_list', '-', 1, 1, '2019-09-23 11:39:21'),
(449, 'backend', 'V1_ticket', 'get_data', '-', 1, 1, '2019-09-23 11:39:21'),
(450, 'backend', 'V2_ticket', 'index', '-', 1, 1, '2019-09-23 11:40:06'),
(451, 'backend', 'V2_ticket', 'view', '-', 1, 1, '2019-09-23 11:40:06'),
(452, 'backend', 'V2_ticket', 'get_list', '-', 1, 1, '2019-09-23 11:40:06'),
(453, 'backend', 'V2_ticket', 'get_data', '-', 1, 1, '2019-09-23 11:40:06'),
(454, 'backend', 'V2_monitoring', 'index', '-', 1, 1, '2019-09-23 11:40:41'),
(455, 'backend', 'V2_monitoring', 'view', '-', 1, 1, '2019-09-23 11:40:41'),
(456, 'backend', 'V2_monitoring', 'get_list', '-', 1, 1, '2019-09-23 11:40:41'),
(457, 'backend', 'V2_monitoring', 'get_data', '-', 1, 1, '2019-09-23 11:40:41'),
(458, 'backend', 'V2_ticket', 'by_ticket', '-', 1, 1, '2019-09-23 11:41:21'),
(459, 'backend', 'V2_ticket', 'by_category', '-', 1, 1, '2019-09-23 11:41:44'),
(460, 'backend', 'V2_ticket', 'by_category', '-', 1, 1, '2019-09-23 11:41:49'),
(461, 'backend', 'V1_ticket', 'by_category', '-', 1, 1, '2019-09-23 13:11:41'),
(462, 'backend', 'V1_ticket', 'by_ticket', '-', 1, 1, '2019-09-23 13:11:58'),
(463, 'backend', 'V1_ticket', 'get_category_select', '-', 1, 1, '2019-09-23 13:49:16'),
(464, 'backend', 'V1_ticket', 'generate', '-', 1, 1, '2019-09-24 11:42:37'),
(465, 'backend', 'V1_ticket', 'gen_to_pdf', '-', 1, 1, '2019-10-02 13:55:09'),
(466, 'vendor', 'ticket', 'gen_to_pdf', '-', 1, 1, '2019-10-03 09:57:17'),
(467, 'backend', 'V2_monitoring', 'get_total_ticket_per_month', '-', 1, 1, '2019-10-04 11:31:41'),
(468, 'backend', 'V2_monitoring', 'get_total_ticket_per_kanim', '-', 1, 1, '2019-10-04 11:31:59'),
(469, 'backend', 'V2_monitoring', 'get_total_ticket_per_month_by_status', '-', 1, 1, '2019-10-04 11:32:19'),
(470, 'backend', 'V2_monitoring', 'get_total_ticket_progress_per_month', '-', 1, 1, '2019-10-04 11:32:56'),
(471, 'backend', 'immigration', 'download_sample', '-', 1, 1, '2019-10-14 14:36:29'),
(472, 'backend', 'vendor', 'download_sample', '-', 1, 1, '2019-10-14 14:40:15'),
(473, 'backend', 'permission', 'index', '-', 1, 1, '2019-10-14 14:50:14'),
(474, 'backend', 'permission', 'view', '-', 1, 1, '2019-10-14 14:50:15'),
(475, 'backend', 'permission', 'insert', '-', 1, 1, '2019-10-14 14:50:15'),
(476, 'backend', 'permission', 'remove', '-', 1, 1, '2019-10-14 14:50:15'),
(477, 'backend', 'permission', 'delete', '-', 1, 1, '2019-10-14 14:50:15'),
(478, 'backend', 'permission', 'update', '-', 1, 1, '2019-10-14 14:50:15'),
(479, 'backend', 'permission', 'get_list', '-', 1, 1, '2019-10-14 14:50:16'),
(480, 'backend', 'permission', 'get_data', '-', 1, 1, '2019-10-14 14:50:16'),
(481, 'auth', 'user', 'ticket_push', '-', 1, 1, '2019-10-22 11:26:14'),
(482, 'backend', 'V2_ticket', 'gen_to_pdf', '-', 1, 1, '2019-10-22 16:28:03');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(32) NOT NULL,
  `nik` varchar(32) NOT NULL,
  `username` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(155) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(128) NOT NULL,
  `activation_code` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '1 => present, 2 => away, 3 => inactive',
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `is_logged_in` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `nik`, `username`, `first_name`, `last_name`, `email`, `password`, `activation_code`, `status`, `is_active`, `is_logged_in`, `created_by`, `create_date`) VALUES
(1, '2019090601000001', 'superuser', 'super', 'user', 'superuser@imigrasi.go.id', '$2y$12$kihT9/YswV0QItLCnvGScuiTDfwqoW0ppG1K91ElwUXQ6TvJs6rbS', '', 3, 1, 1, 1, '2019-09-07 19:17:38'),
(2, '2019090601000002', 'adit', 'adit', 'admin', 'adit@imigrasi.go.id', '$2y$12$3dBjIajcGTGn.Hjqw.GftesA.fczhgEJvU86CeWRX3Nc.SPQhgare', '', 3, 1, 1, 1, '2019-09-07 19:18:48'),
(3, '20190906023000001', 'kanim jakpus', 'kanim', 'jakpus', 'kanim.jakpus@imigrasi.go.id', '$2y$12$WRmjOFP5UEmEIoCMmEzP2eRCKPqAs5lkvramto.ueHrERWrQxE7Oe', '', 3, 1, 1, 1, '2019-09-07 20:03:09'),
(4, '20190906023000002', 'kanim jaksel', 'kanim', 'jaksel', 'kanim.jaksel@imigrasi.go.id', '$2y$12$m9FuNKamAMa.rFwoaCvm6O0livsb32UbS9Uk4/JcdAaaAXhSRtV3S', '', 3, 1, 1, 1, '2019-09-07 20:04:51'),
(5, '20190906023000003', 'kanim jakut', 'kanim', 'jakut', 'kanim.jakut@imigrasi.go.id', '$2y$12$VKNVvcvoQYbifP1skVT6DeguEbBRCK/5uzdCUiPqG5dBtJQ0C2a96', '', 3, 1, 1, 1, '2019-09-07 20:06:37'),
(6, '20190906011000002', 'bayu signet', 'bayus', 'signet', 'bayu@signet.com', '$2y$12$VvNdgwkufTWYNJMpnjuAMOsbsby/xvp9oSWN0QZ9unJ6Sfg3P4KMy', '', 3, 1, 1, 1, '2019-09-08 18:33:49'),
(7, '20190906011000003', 'valdi signet', 'valdi', 'signet', 'valdi@signet.com', '$2y$12$HPbOCdHesB0xEiExu9vl1e54YN8H7pco0pU1aZe7iE5NnlYx99DKu', '', 3, 1, 0, 1, '2019-09-10 09:16:17'),
(8, '20190906011000004', 'budi signet', 'budi', 'signet', 'budi@signet.com', '$2y$12$hPtEZ4mNp.RVGJTTnaEABeLd98W8.m1n6Jh1fUWF3ODsMUE.K3Gdi', '', 3, 1, 1, 1, '2019-09-10 09:19:39'),
(9, '20190906025000002', 'dede abc', 'dede', 'abc', 'dede@abc.com', '$2y$12$54JZFgbSzjwOn2q3binDLeJJfdL/eQ63KDUMBYQQOEavAM3ML/OWW', '', 3, 1, 1, 1, '2019-09-10 09:27:40'),
(10, '20190906023000006', 'dadang abc', 'dadang', 'abc', 'dadang@signet.com', '$2y$12$A2R1QaCXmVM47M3Isw0USucPPXFrj6f2EamLk8qdE8puX78Hd7H6i', '', 3, 1, 1, 1, '2019-09-10 09:38:43'),
(11, '20190906023000007', 'syehbi signet', 'syehbi', 'signet', 'syehbi@signet.com', '$2y$12$2FzENvFvCkLm2i73oOElJ./seYIIYg2I6/XJBpVMa4.jBFBFufxdC', '', 3, 1, 0, 1, '2019-09-12 15:31:53'),
(12, '20190906023000007', 'syehbi signet', 'syehbi', 'sadsadas', 'syehbi@signet.com', '$2y$12$orL70CstmSTJyD/kcKw/2uW.IyBuBVoN1gHv4JnXl5uFMDMTEGQaC', '', 3, 1, 0, 1, '2019-09-12 15:33:50'),
(13, '20190906011000004', 'budi signet', 'budis', 'signet', 'budi@signet.com', '$2y$12$YZej.S7oWCuAHRcfseqRSuFY.Gx5Q8wYULqmzrYe7AfxZhb8HpAoq', '', 3, 1, 0, 1, '2019-09-12 16:27:21'),
(14, '', 'monitoring', 'monitoring', 'imi', 'monitoring@imigrasi.go.id', '$2y$12$PtycFur4oLVVMHOHSg6Nv.j48Sl5f9jLTUfZFTpp1faxxqzmjK35O', '', 3, 1, 1, 1, '2019-09-12 17:04:15'),
(15, '20190906023000004', 'kanim jakbar', 'kanim', 'jakbar', 'kanim.jakbar@imigrasi.go.id', '$2y$12$eVSu1VQoqGHpqa7BKMX.lOvsMSyv4sQC4j4OGLDraTSZveSXKnlEC', '', 3, 1, 0, 1, '2019-09-17 14:46:30'),
(16, '20190906023000005', 'kanim jaktim', 'kanim', 'jaktim', 'kanim.jaktim@imigaris.go.id', '$2y$12$Mh2.oakpeHLFVDkbKJUl0OKP/g5RjbBDGDOnHA2bI.XREqtR6bpCW', '', 3, 1, 0, 1, '2019-09-17 14:51:41'),
(17, '20190906023000005', 'kanim ambon', 'kanim', 'ambon', 'kanim.ambon@imigrasi.go.id', '$2y$12$rwwEtMdw4lUfhSdYH1rniOVvp21usY1ixNkPZDsC2B3QyG/hjW0Om', '', 3, 1, 0, 1, '2019-09-17 14:59:26'),
(18, '20190906023000006', 'kanim balikpapan', 'kanim', 'balikpapan', 'kanim.balikpapan@imigrasi.go.id', '$2y$12$N8lvVIWUARN5wviPuYZnWeZflmzHmgxfYrocKw2oX2niepnF7Wz4W', '', 3, 1, 0, 1, '2019-09-17 16:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_groups`
--

CREATE TABLE `tbl_user_groups` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `group_id` int(32) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_user_groups`
--

INSERT INTO `tbl_user_groups` (`id`, `user_id`, `group_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, 1, 1, 1, 1, '2019-09-07 19:17:38'),
(2, 2, 1, 1, 1, '2019-09-07 19:18:48'),
(3, 3, 2, 1, 1, '2019-09-07 20:03:09'),
(4, 4, 2, 1, 1, '2019-09-07 20:04:51'),
(5, 5, 2, 1, 1, '2019-09-07 20:06:37'),
(6, 6, 3, 1, 1, '2019-09-08 18:33:49'),
(7, 7, 3, 1, 1, '2019-09-10 09:16:17'),
(8, 8, 3, 1, 1, '2019-09-10 09:19:39'),
(9, 9, 3, 1, 1, '2019-09-10 09:27:40'),
(10, 10, 3, 1, 1, '2019-09-10 09:38:43'),
(11, 11, 3, 1, 1, '2019-09-12 15:31:53'),
(12, 12, 3, 1, 1, '2019-09-12 15:33:50'),
(13, 13, 3, 1, 1, '2019-09-12 16:27:21'),
(14, 14, 4, 1, 1, '2019-09-12 17:04:15'),
(15, 15, 2, 1, 1, '2019-09-17 14:46:30'),
(16, 16, 2, 1, 1, '2019-09-17 14:51:41'),
(17, 17, 2, 1, 1, '2019-09-17 14:59:26'),
(18, 18, 2, 1, 1, '2019-09-17 16:18:26');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user_profiles`
--

CREATE TABLE `tbl_user_profiles` (
  `id` int(32) NOT NULL,
  `user_id` int(32) NOT NULL,
  `address` text NOT NULL,
  `lat` varchar(64) NOT NULL,
  `lng` varchar(64) NOT NULL,
  `zoom` int(4) NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_ajax_plugins`
--
ALTER TABLE `tbl_ajax_plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cms_categories`
--
ALTER TABLE `tbl_cms_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cms_category_contents`
--
ALTER TABLE `tbl_cms_category_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cms_comments`
--
ALTER TABLE `tbl_cms_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cms_contents`
--
ALTER TABLE `tbl_cms_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_cms_content_photos`
--
ALTER TABLE `tbl_cms_content_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_component_messages`
--
ALTER TABLE `tbl_component_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_component_message_categories`
--
ALTER TABLE `tbl_component_message_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_component_message_labels`
--
ALTER TABLE `tbl_component_message_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_component_notifications`
--
ALTER TABLE `tbl_component_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_component_notification_categories`
--
ALTER TABLE `tbl_component_notification_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_component_notification_status`
--
ALTER TABLE `tbl_component_notification_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_component_task_categories`
--
ALTER TABLE `tbl_component_task_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_component_task_status`
--
ALTER TABLE `tbl_component_task_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_configs`
--
ALTER TABLE `tbl_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_configs`
--
ALTER TABLE `tbl_email_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_email_layout`
--
ALTER TABLE `tbl_email_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_groups`
--
ALTER TABLE `tbl_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_group_permissions`
--
ALTER TABLE `tbl_group_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_activities`
--
ALTER TABLE `tbl_helpdesk_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_contracts`
--
ALTER TABLE `tbl_helpdesk_contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_employees`
--
ALTER TABLE `tbl_helpdesk_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_employee_monitors`
--
ALTER TABLE `tbl_helpdesk_employee_monitors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_employee_users`
--
ALTER TABLE `tbl_helpdesk_employee_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_imigration_branchs`
--
ALTER TABLE `tbl_helpdesk_imigration_branchs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_login_notifications`
--
ALTER TABLE `tbl_helpdesk_login_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_logs`
--
ALTER TABLE `tbl_helpdesk_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_tickets`
--
ALTER TABLE `tbl_helpdesk_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_categories`
--
ALTER TABLE `tbl_helpdesk_ticket_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_chats`
--
ALTER TABLE `tbl_helpdesk_ticket_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_files`
--
ALTER TABLE `tbl_helpdesk_ticket_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_handlers`
--
ALTER TABLE `tbl_helpdesk_ticket_handlers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_issue_suggestions`
--
ALTER TABLE `tbl_helpdesk_ticket_issue_suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_logs`
--
ALTER TABLE `tbl_helpdesk_ticket_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_priorities`
--
ALTER TABLE `tbl_helpdesk_ticket_priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_problem_impacts`
--
ALTER TABLE `tbl_helpdesk_ticket_problem_impacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_reopen_logs`
--
ALTER TABLE `tbl_helpdesk_ticket_reopen_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_requests`
--
ALTER TABLE `tbl_helpdesk_ticket_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_rules`
--
ALTER TABLE `tbl_helpdesk_ticket_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_status`
--
ALTER TABLE `tbl_helpdesk_ticket_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_transactions`
--
ALTER TABLE `tbl_helpdesk_ticket_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_ticket_transfers`
--
ALTER TABLE `tbl_helpdesk_ticket_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_timtik_users`
--
ALTER TABLE `tbl_helpdesk_timtik_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_vendors`
--
ALTER TABLE `tbl_helpdesk_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_helpdesk_vendor_users`
--
ALTER TABLE `tbl_helpdesk_vendor_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_hepldesk_ticket_numbers`
--
ALTER TABLE `tbl_hepldesk_ticket_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_icons`
--
ALTER TABLE `tbl_icons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_layouts`
--
ALTER TABLE `tbl_layouts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_layout_controllers`
--
ALTER TABLE `tbl_layout_controllers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_layout_models`
--
ALTER TABLE `tbl_layout_models`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_layout_views`
--
ALTER TABLE `tbl_layout_views`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_method_masters`
--
ALTER TABLE `tbl_method_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_modules`
--
ALTER TABLE `tbl_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_groups`
--
ALTER TABLE `tbl_user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user_profiles`
--
ALTER TABLE `tbl_user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_ajax_plugins`
--
ALTER TABLE `tbl_ajax_plugins`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_cms_categories`
--
ALTER TABLE `tbl_cms_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cms_category_contents`
--
ALTER TABLE `tbl_cms_category_contents`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cms_comments`
--
ALTER TABLE `tbl_cms_comments`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cms_contents`
--
ALTER TABLE `tbl_cms_contents`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_cms_content_photos`
--
ALTER TABLE `tbl_cms_content_photos`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_component_messages`
--
ALTER TABLE `tbl_component_messages`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_component_message_categories`
--
ALTER TABLE `tbl_component_message_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_component_message_labels`
--
ALTER TABLE `tbl_component_message_labels`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_component_notifications`
--
ALTER TABLE `tbl_component_notifications`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_component_notification_categories`
--
ALTER TABLE `tbl_component_notification_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_component_notification_status`
--
ALTER TABLE `tbl_component_notification_status`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_component_task_categories`
--
ALTER TABLE `tbl_component_task_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_component_task_status`
--
ALTER TABLE `tbl_component_task_status`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_configs`
--
ALTER TABLE `tbl_configs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_email_configs`
--
ALTER TABLE `tbl_email_configs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_email_layout`
--
ALTER TABLE `tbl_email_layout`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_groups`
--
ALTER TABLE `tbl_groups`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_group_permissions`
--
ALTER TABLE `tbl_group_permissions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_activities`
--
ALTER TABLE `tbl_helpdesk_activities`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_contracts`
--
ALTER TABLE `tbl_helpdesk_contracts`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_employees`
--
ALTER TABLE `tbl_helpdesk_employees`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_employee_monitors`
--
ALTER TABLE `tbl_helpdesk_employee_monitors`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_employee_users`
--
ALTER TABLE `tbl_helpdesk_employee_users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_imigration_branchs`
--
ALTER TABLE `tbl_helpdesk_imigration_branchs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_login_notifications`
--
ALTER TABLE `tbl_helpdesk_login_notifications`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_logs`
--
ALTER TABLE `tbl_helpdesk_logs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_tickets`
--
ALTER TABLE `tbl_helpdesk_tickets`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_categories`
--
ALTER TABLE `tbl_helpdesk_ticket_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_chats`
--
ALTER TABLE `tbl_helpdesk_ticket_chats`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_files`
--
ALTER TABLE `tbl_helpdesk_ticket_files`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_handlers`
--
ALTER TABLE `tbl_helpdesk_ticket_handlers`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_issue_suggestions`
--
ALTER TABLE `tbl_helpdesk_ticket_issue_suggestions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_logs`
--
ALTER TABLE `tbl_helpdesk_ticket_logs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_priorities`
--
ALTER TABLE `tbl_helpdesk_ticket_priorities`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_problem_impacts`
--
ALTER TABLE `tbl_helpdesk_ticket_problem_impacts`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_reopen_logs`
--
ALTER TABLE `tbl_helpdesk_ticket_reopen_logs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_requests`
--
ALTER TABLE `tbl_helpdesk_ticket_requests`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_rules`
--
ALTER TABLE `tbl_helpdesk_ticket_rules`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_status`
--
ALTER TABLE `tbl_helpdesk_ticket_status`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_transactions`
--
ALTER TABLE `tbl_helpdesk_ticket_transactions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_ticket_transfers`
--
ALTER TABLE `tbl_helpdesk_ticket_transfers`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_timtik_users`
--
ALTER TABLE `tbl_helpdesk_timtik_users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_vendors`
--
ALTER TABLE `tbl_helpdesk_vendors`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_helpdesk_vendor_users`
--
ALTER TABLE `tbl_helpdesk_vendor_users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_hepldesk_ticket_numbers`
--
ALTER TABLE `tbl_hepldesk_ticket_numbers`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_icons`
--
ALTER TABLE `tbl_icons`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `tbl_layouts`
--
ALTER TABLE `tbl_layouts`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_layout_controllers`
--
ALTER TABLE `tbl_layout_controllers`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_layout_models`
--
ALTER TABLE `tbl_layout_models`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
