-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2022 pada 10.21
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Database: `db_helpdesk`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_ajax_plugins`
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
-- Dumping data untuk tabel `tbl_ajax_plugins`
--

INSERT INTO `tbl_ajax_plugins` (`id`, `name`, `link`, `content`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Add sample text', 'add_lorem_ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'Add Lorem Ipsum to textarea', 1, 1, '2019-07-15 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_cms_categories`
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
-- Struktur dari tabel `tbl_cms_category_contents`
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
-- Struktur dari tabel `tbl_cms_comments`
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
-- Struktur dari tabel `tbl_cms_contents`
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
-- Struktur dari tabel `tbl_cms_content_photos`
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
-- Struktur dari tabel `tbl_component_messages`
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
-- Struktur dari tabel `tbl_component_message_categories`
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
-- Struktur dari tabel `tbl_component_message_labels`
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
-- Struktur dari tabel `tbl_component_message_status`
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
-- Dumping data untuk tabel `tbl_component_message_status`
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
-- Struktur dari tabel `tbl_component_notifications`
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
-- Struktur dari tabel `tbl_component_notification_categories`
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
-- Dumping data untuk tabel `tbl_component_notification_categories`
--

INSERT INTO `tbl_component_notification_categories` (`id`, `name`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'network', '-', 1, 1, '2019-02-02 00:00:00'),
(2, 'server', '-', 1, 1, '2019-02-02 00:00:00'),
(3, 'system', '-', 1, 1, '2019-02-02 00:00:00'),
(4, 'database', '-', 1, 1, '2019-02-02 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_component_notification_status`
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
-- Dumping data untuk tabel `tbl_component_notification_status`
--

INSERT INTO `tbl_component_notification_status` (`id`, `name`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'pending', '-', 1, 1, '2019-02-02 00:00:00'),
(2, 'read', '-', 1, 1, '2019-02-02 00:00:00'),
(3, 'replied', '-', 1, 1, '2019-02-02 00:00:00'),
(4, 'archive', '-', 1, 1, '2019-02-02 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_component_tasks`
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
-- Struktur dari tabel `tbl_component_task_categories`
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
-- Struktur dari tabel `tbl_component_task_status`
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
-- Struktur dari tabel `tbl_configs`
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
-- Dumping data untuk tabel `tbl_configs`
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
(17, 'login_footer_note', '<b>DeveloperASik &copy; 2022</b>', 0, 1, 1, '2019-09-02 00:00:00'),
(18, 'login_notification', '1', 0, 1, 1, '2019-07-12 16:18:24'),
(19, 'footer_about', ' <aside class=\"f_widget ab_widget\">\n                    <div class=\"f_title\">\n                        <h3>About Me</h3>\n                    </div>\n                    <p>If you own an Iphone, you’ve probably already worked out how much fun it is to use it to watch movies-it has that nice big screen, and the sound quality.</p>\n                </aside>', 1, 1, 1, '2019-02-12 00:00:00'),
(20, 'footer_newsletter', '<aside class=\"f_widget news_widget\">\r\n                    <div class=\"f_title\">\r\n                        <h3>Newsletter</h3>\r\n                    </div>\r\n                    <p>Stay updated with our latest trends</p>\r\n                    <div id=\"mc_embed_signup\">\r\n                        <form target=\"_blank\" method=\"post\" class=\"subscribes\">\r\n                            <div class=\"input-group d-flex flex-row\">\r\n                                <input name=\"EMAIL\" placeholder=\"Enter email address\" onfocus=\"this.placeholder = \'\'\" onblur=\"this.placeholder = \'Email Address \'\" required=\"\" type=\"email\">\r\n                                <button class=\"btn sub-btn\"><span class=\"lnr lnr-arrow-right\"></span></button>		\r\n                            </div>				\r\n                            <div class=\"mt-10 info\"></div>\r\n                        </form>\r\n                    </div>\r\n                </aside>', 1, 1, 1, '2019-02-12 00:00:00'),
(21, 'footer_socials', '<aside class=\"f_widget social_widget\">\n                    <div class=\"f_title\">\n                        <h3>Follow Me</h3>\n                    </div>\n                    <p>Let us be social</p>\n                    <ul class=\"list\">\n                        <li><a href=\"#\"><i class=\"fa fa-facebook\"></i></a></li>\n                        <li><a href=\"#\"><i class=\"fa fa-twitter\"></i></a></li>\n                        <li><a href=\"#\"><i class=\"fa fa-dribbble\"></i></a></li>\n                        <li><a href=\"#\"><i class=\"fa fa-behance\"></i></a></li>\n                    </ul>\n                </aside>', 1, 1, 1, '2019-02-12 00:00:00'),
(22, 'session_helpdesk', 'd98789iu8ghdjaw90d80po9', 0, 1, 1, '2018-07-23 00:00:00'),
(23, 'api_key', '98ufu83476yrhdge', 0, 1, 1, '2019-03-27 00:00:00'),
(24, 'api_user', 'api_09283hdjks', 0, 1, 1, '2019-03-27 00:00:00'),
(25, 'api_pass', '098eq7312&_DSA', 0, 1, 1, '2019-03-27 00:00:00'),
(26, 'copyright', '2022 © DeveloperAsik', 0, 1, 1, '2019-03-27 00:00:00'),
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
-- Struktur dari tabel `tbl_email_configs`
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
-- Dumping data untuk tabel `tbl_email_configs`
--

INSERT INTO `tbl_email_configs` (`id`, `protocol`, `host`, `port`, `user`, `pass`, `mailtype`, `charset`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'smtp', 'smtp.gmail.com', '587', 'firman.begin@gmail.com', 'Ab1234abcd', 'html', 'iso-8859-1', 1, 1, '2019-02-27 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_email_layout`
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
-- Dumping data untuk tabel `tbl_email_layout`
--

INSERT INTO `tbl_email_layout` (`id`, `keyword`, `value_eng`, `value_ind`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'user_activation', ' <center>[date]</center><br/>                         Pengguna yang terhormat,                         <br/>                         <br/>                         Terima kasih telah melakukan registrasi akun di pesky indosporttiming, berikut detail data akun anda :                         email       : [email]<br/>                         username    : [username]<br/>                         password    : [password]<br/>                         status      : tidak aktif<br/>                         <br/>                             Untuk aktivasi account klik <b>[activation_link]</b><br/>                         Akun yang belum di aktifkan tidak akan bisa melakukan pendaftaran event lomba atau login kedalam dashboard indosporttiming<br/>                         Mohon untuk tidak men-sharing atau berbagi pakai dengan pihak lain terhadap akun dengan data diri anda agar tidak terjadi hal - hal yang tidak di inginkan.<br/>                     ', '', '-', 1, 1, '2019-02-27 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_email_links`
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
-- Struktur dari tabel `tbl_groups`
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
-- Dumping data untuk tabel `tbl_groups`
--

INSERT INTO `tbl_groups` (`id`, `name`, `description`, `level`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'superuser', '-', 1, 1, 1, '2019-02-25 00:00:00'),
(2, 'employee', '-', 2, 1, 1, '2019-02-12 00:00:00'),
(3, 'vendor', '-', 3, 1, 1, '2019-02-12 00:00:00'),
(4, 'monitoring', '-', 4, 1, 1, '2019-07-16 10:04:47');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_group_permissions`
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
-- Dumping data untuk tabel `tbl_group_permissions`
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
(482, 1, 482, 1, 0, 1, 1, '2019-10-22 16:28:03'),
(483, 1, 483, 1, 0, 1, 1, '2019-10-14 14:50:15'),
(484, 1, 484, 1, 0, 1, 1, '2019-10-14 14:50:15'),
(485, 1, 485, 1, 0, 1, 1, '2019-10-14 14:50:15'),
(486, 1, 486, 1, 0, 1, 1, '2019-10-14 14:50:15'),
(487, 1, 487, 1, 0, 1, 1, '2019-10-14 14:50:16'),
(488, 1, 488, 1, 0, 1, 1, '2019-10-14 14:50:16'),
(489, 1, 489, 1, 0, 1, 1, '2019-10-22 11:26:14'),
(490, 1, 490, 1, 0, 1, 1, '2019-10-22 16:28:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_activities`
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
-- Dumping data untuk tabel `tbl_helpdesk_activities`
--

INSERT INTO `tbl_helpdesk_activities` (`id`, `ticket_id`, `response_time_start`, `response_time_stop`, `transfer_time_start`, `transfer_time_stop`, `solving_time_start`, `solving_time_stop`, `open_time`, `close_message`, `is_open`, `is_active`, `created_by`, `create_date`) VALUES
(1, 1, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2022-07-02 03:04:00'),
(2, 2, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '0000-00-00 00:00:00'),
(3, 3, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2022-05-07 03:09:00'),
(4, 4, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2022-04-08 08:08:00'),
(5, 5, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2022-01-09 06:04:00'),
(6, 6, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2022-03-04 08:08:00'),
(7, 7, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2022-06-08 06:06:00'),
(8, 8, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2022-08-04 00:06:00'),
(9, 9, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '0000-00-00 00:00:00'),
(10, 10, '2022-06-16 14:36:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '', 0, 1, 1, '2022-08-03 05:04:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_branchs`
--

CREATE TABLE `tbl_helpdesk_branchs` (
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
-- Dumping data untuk tabel `tbl_helpdesk_branchs`
--

INSERT INTO `tbl_helpdesk_branchs` (`id`, `code`, `name`, `address`, `email`, `zip_code`, `phone_number`, `fax_number`, `type`, `parent_id`, `level`, `lat`, `lng`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'JE', 'Cabang Jember', 'jember utara', 'jember.me@gmaol.co.id', '21312', '3423223432', '4324324234', '1', 0, 1, '', '', '-', 1, 1, '2022-06-16 13:02:03'),
(2, 'CB1', 'Cabang satoe', 'Satoeroe 1', 'satoe.me@gmaol.co.id', '21312', '3423223432', '4324324234', '1', 0, 1, '', '', '-', 1, 1, '2022-06-16 13:02:03'),
(3, 'CB2', 'Cabang doewa', 'Doewa 2', 'doewa.me@gmaol.co.id', '21312', '3423223432', '4324324234', '1', 0, 1, '', '', '-', 1, 1, '2022-06-16 13:02:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_contracts`
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
-- Dumping data untuk tabel `tbl_helpdesk_contracts`
--

INSERT INTO `tbl_helpdesk_contracts` (`id`, `name`, `file_path`, `description`, `expired_date`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'VISA/E-OFFICE/IZIN TINGGAL', '#', '-', '2020-01-01 00:00:00', 1, 1, '2019-04-21 00:00:00'),
(2, 'VISA/E-OFFICE/IZIN TINGGAL', '#', '-', '2020-01-01 00:00:00', 1, 1, '2019-04-21 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_employees`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_employee_monitors`
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
-- Dumping data untuk tabel `tbl_helpdesk_employee_monitors`
--

INSERT INTO `tbl_helpdesk_employee_monitors` (`id`, `employee_id`, `user_id`, `branch_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, 4, 14, 155, 1, 1, '2019-09-12 17:04:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_employee_users`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_login_notifications`
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
-- Dumping data untuk tabel `tbl_helpdesk_login_notifications`
--

INSERT INTO `tbl_helpdesk_login_notifications` (`id`, `name`, `content_summary`, `content_full`, `color`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'test informasi terbaru', 'ini hanya percobaan berita terbaru', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'red', '-', 1, 1, '2019-07-17 00:00:00'),
(2, 'testasss', 'tes aja biar gampang', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'blue', '-', 1, 1, '2019-07-18 10:30:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_logs`
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
-- Struktur dari tabel `tbl_helpdesk_tickets`
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
-- Dumping data untuk tabel `tbl_helpdesk_tickets`
--

INSERT INTO `tbl_helpdesk_tickets` (`id`, `parent_ticket_id`, `code`, `content`, `description`, `session_id`, `is_active`, `issued_by`, `created_by`, `create_date`) VALUES
(1, 0, '2022.06.16.TEST.00001', 'nyoba 10 dulu no : 1', '-', 0, 1, 5, 1, '2022-07-02 03:04:00'),
(2, 0, '2022.06.16.TEST.00002', 'nyoba 10 dulu no : 2', '-', 0, 1, 5, 1, '0000-00-00 00:00:00'),
(3, 0, '2022.06.16.TEST.00003', 'nyoba 10 dulu no : 3', '-', 0, 1, 5, 1, '2022-05-07 03:09:00'),
(4, 0, '2022.06.16.TEST.00004', 'nyoba 10 dulu no : 4', '-', 0, 1, 5, 1, '2022-04-08 08:08:00'),
(5, 0, '2022.06.16.TEST.00005', 'nyoba 10 dulu no : 5', '-', 0, 1, 5, 1, '2022-01-09 06:04:00'),
(6, 0, '2022.06.16.TEST.00006', 'nyoba 10 dulu no : 6', '-', 0, 1, 5, 1, '2022-03-04 08:08:00'),
(7, 0, '2022.06.16.TEST.00007', 'nyoba 10 dulu no : 7', '-', 0, 1, 5, 1, '2022-06-08 06:06:00'),
(8, 0, '2022.06.16.TEST.00008', 'nyoba 10 dulu no : 8', '-', 0, 1, 5, 1, '2022-08-04 00:06:00'),
(9, 0, '2022.06.16.TEST.00009', 'nyoba 10 dulu no : 9', '-', 0, 1, 5, 1, '0000-00-00 00:00:00'),
(10, 0, '2022.06.16.TEST.00010', 'nyoba 10 dulu no : 10', '-', 0, 1, 5, 1, '2022-08-03 05:04:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_categories`
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
-- Dumping data untuk tabel `tbl_helpdesk_ticket_categories`
--

INSERT INTO `tbl_helpdesk_ticket_categories` (`id`, `name`, `name_ina`, `rank`, `level`, `icon`, `is_active`, `description`, `parent_id`, `created_by`, `create_date`) VALUES
(1, 'SOFTWARE', 'Perangkat lunak', 0, 1, '3', 1, '-', 0, 1, '2019-05-21 09:45:00'),
(2, 'HARDWARE', 'Perangkat keras', 0, 1, '3', 1, '-', 0, 1, '2019-05-21 09:58:34'),
(3, 'NETWORK', 'Jaringan', 0, 1, '8', 1, '-', 0, 1, '2019-05-21 09:59:13'),
(4, 'Microsoft Office', '', 0, 2, '8', 1, '-', 1, 1, '2019-05-21 09:59:34'),
(5, 'Microsoft Outlook', 'Microsoft Outlook', 0, 2, '8', 1, '-', 1, 1, '2019-05-21 09:59:54'),
(6, 'Mozilla Thunderbird', 'Mozilla Thunderbird', 0, 2, '10', 1, '-', 1, 1, '2019-05-21 10:00:07'),
(7, 'Browser', 'Peramban', 0, 2, '5', 1, '', 1, 1, '2019-05-21 10:00:22'),
(8, 'Anti Virus', 'Anti Virus', 0, 2, '10', 1, '-', 1, 1, '2019-05-21 10:00:38'),
(9, 'Driver', '', 0, 2, '11', 1, '-', 1, 1, '2019-05-21 10:00:53'),
(10, 'Meeting Application', 'Aplikasi Rapat', 0, 2, '11', 1, '-', 1, 1, '2019-05-21 10:01:08'),
(11, 'SERVER', '', 1, 2, '9', 1, '-', 2, 1, '2019-05-21 10:01:25'),
(12, 'PRINTER', 'Alat cetak', 0, 2, '5', 1, '', 2, 1, '2019-05-21 10:01:40'),
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
(25, 'Image Processing', 'Pemroses Gambar', 0, 2, '7', 1, '-', 1, 1, '2019-09-12 10:10:02'),
(26, 'Other', 'Lainnya', 0, 2, '10', 1, '-', 1, 1, '2019-09-12 10:10:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_chats`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_files`
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
-- Dumping data untuk tabel `tbl_helpdesk_ticket_files`
--

INSERT INTO `tbl_helpdesk_ticket_files` (`id`, `code`, `path`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, '2022.06.16.TEST.00001', 'reserved_images/sample.jpg', '-', 0, 1, '2022-07-02 03:04:00'),
(2, '2022.06.16.TEST.00002', 'reserved_images/sample.jpg', '-', 0, 1, '0000-00-00 00:00:00'),
(3, '2022.06.16.TEST.00003', 'reserved_images/sample.jpg', '-', 0, 1, '2022-05-07 03:09:00'),
(4, '2022.06.16.TEST.00004', 'reserved_images/sample.jpg', '-', 0, 1, '2022-04-08 08:08:00'),
(5, '2022.06.16.TEST.00005', 'reserved_images/sample.jpg', '-', 0, 1, '2022-01-09 06:04:00'),
(6, '2022.06.16.TEST.00006', 'reserved_images/sample.jpg', '-', 0, 1, '2022-03-04 08:08:00'),
(7, '2022.06.16.TEST.00007', 'reserved_images/sample.jpg', '-', 0, 1, '2022-06-08 06:06:00'),
(8, '2022.06.16.TEST.00008', 'reserved_images/sample.jpg', '-', 0, 1, '2022-08-04 00:06:00'),
(9, '2022.06.16.TEST.00009', 'reserved_images/sample.jpg', '-', 0, 1, '0000-00-00 00:00:00'),
(10, '2022.06.16.TEST.00010', 'reserved_images/sample.jpg', '-', 0, 1, '2022-08-03 05:04:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_handlers`
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

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_issue_suggestions`
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
-- Dumping data untuk tabel `tbl_helpdesk_ticket_issue_suggestions`
--

INSERT INTO `tbl_helpdesk_ticket_issue_suggestions` (`id`, `value_eng`, `value_ina`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Ok, we are already on progressing this ticket. Please wait for further information and update will be inform', 'Baik, kami akan memproses tiket ini. Mohon tunggu untuk informasi selanjutnya dan perkembangan selanjutnya akan kami informasikan.', '-', 1, 1, '2019-04-21 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_logs`
--

CREATE TABLE `tbl_helpdesk_ticket_logs` (
  `id` int(32) NOT NULL,
  `ticket_id` int(32) NOT NULL,
  `action` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `created_by` int(32) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_priorities`
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
-- Dumping data untuk tabel `tbl_helpdesk_ticket_priorities`
--

INSERT INTO `tbl_helpdesk_ticket_priorities` (`id`, `name`, `style`, `checked`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Low', 'has-info', 1, '-', 1, 1, '2019-03-27 00:00:00'),
(2, 'Middle', 'has-warning', 0, '-', 1, 1, '2019-03-27 00:00:00'),
(3, 'High', 'has-error', 0, '-', 1, 1, '2019-03-27 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_problem_impacts`
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
-- Dumping data untuk tabel `tbl_helpdesk_ticket_problem_impacts`
--

INSERT INTO `tbl_helpdesk_ticket_problem_impacts` (`id`, `name`, `name_ina`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Affected less than 2 case', 'Kejadian kurang dari 2 kasus yang sama', '-', 1, 1, '2019-07-04 10:02:52'),
(2, 'Affected more than 2 case', 'Kejadian yang lebih dari 2 kasus yang sama', '-', 1, 1, '2019-07-04 10:03:18');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_reopen_logs`
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
-- Struktur dari tabel `tbl_helpdesk_ticket_requests`
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
-- Struktur dari tabel `tbl_helpdesk_ticket_rules`
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
-- Dumping data untuk tabel `tbl_helpdesk_ticket_rules`
--

INSERT INTO `tbl_helpdesk_ticket_rules` (`id`, `title`, `response_time`, `solving_time`, `fine_result`, `priority_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'low', 15, 120, '100000', 0, 1, 1, '2019-04-17 00:00:00'),
(2, 'medium', 15, 120, '100000', 2, 1, 1, '2019-04-17 00:00:00'),
(3, 'high', 15, 1440, '100000', 3, 1, 1, '2019-04-17 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_status`
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
-- Dumping data untuk tabel `tbl_helpdesk_ticket_status`
--

INSERT INTO `tbl_helpdesk_ticket_status` (`id`, `name`, `style`, `description`, `is_active`, `rank`, `created_by`, `create_date`) VALUES
(1, 'open', '', '-', 1, 1, 1, '2019-03-27 00:00:00'),
(2, 'progress', '', '-', 1, 2, 1, '2019-03-27 00:00:00'),
(3, 'transfer', '', '-', 1, 3, 1, '2019-03-27 00:00:00'),
(4, 'close', '', '-', 1, 4, 1, '2019-03-27 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_transactions`
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
-- Dumping data untuk tabel `tbl_helpdesk_ticket_transactions`
--

INSERT INTO `tbl_helpdesk_ticket_transactions` (`id`, `ticket_id`, `category_id`, `job_id`, `status_id`, `branch_id`, `priority_id`, `rule_id`, `problem_impact_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, 1, 1, 7, 1, 1, 1, 1, 1, 1, 1, '2022-07-02 03:04:00'),
(2, 2, 1, 7, 1, 1, 1, 1, 1, 1, 1, '0000-00-00 00:00:00'),
(3, 3, 1, 7, 1, 1, 1, 1, 1, 1, 1, '2022-05-07 03:09:00'),
(4, 4, 1, 7, 1, 1, 1, 1, 1, 1, 1, '2022-04-08 08:08:00'),
(5, 5, 1, 7, 1, 1, 1, 1, 1, 1, 1, '2022-01-09 06:04:00'),
(6, 6, 1, 7, 1, 1, 1, 1, 1, 1, 1, '2022-03-04 08:08:00'),
(7, 7, 1, 7, 1, 1, 1, 1, 1, 1, 1, '2022-06-08 06:06:00'),
(8, 8, 1, 7, 1, 1, 1, 1, 1, 1, 1, '2022-08-04 00:06:00'),
(9, 9, 1, 7, 1, 1, 1, 1, 1, 1, 1, '0000-00-00 00:00:00'),
(10, 10, 1, 7, 1, 1, 1, 1, 1, 1, 1, '2022-08-03 05:04:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_ticket_transfers`
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
-- Struktur dari tabel `tbl_helpdesk_users`
--

CREATE TABLE `tbl_helpdesk_users` (
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
-- Dumping data untuk tabel `tbl_helpdesk_users`
--

INSERT INTO `tbl_helpdesk_users` (`id`, `nik`, `name`, `email`, `phone_number`, `user_id`, `position_id`, `level_id`, `is_active`, `created_by`, `create_date`) VALUES
(1, '2019090601000001', 'superuser', 'superuser@gmaol.co.id', '', 1, 0, 0, 1, 1, '2019-09-07 19:17:38'),
(2, '2019090601000002', 'adit', 'adit@gmaol.co.id', '', 2, 0, 0, 1, 1, '2019-09-07 19:18:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_vendors`
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
-- Dumping data untuk tabel `tbl_helpdesk_vendors`
--

INSERT INTO `tbl_helpdesk_vendors` (`id`, `code`, `name`, `address`, `phone_number`, `email`, `fax`, `description`, `is_active`, `created_by`, `create_date`) VALUES
(1, '0976d1hd', 'Signet', '-', '021921312312', 'signet@gmail.com', '021432423423', '-', 1, 1, '2019-04-18 00:00:00'),
(2, '09734rtd', 'PT Maju mundur', '-', '021921312312', 'majumundur@gmail.com', '021432423423', '-', 1, 1, '2019-04-18 00:00:00'),
(3, '09324', 'PT ABC', 'jakarta', '08567465', 'abc@gmail.com', '012546678', 'desc', 1, 1, '2019-08-06 10:56:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_helpdesk_vendor_users`
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
-- Dumping data untuk tabel `tbl_helpdesk_vendor_users`
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
-- Struktur dari tabel `tbl_hepldesk_ticket_numbers`
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
-- Struktur dari tabel `tbl_icons`
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
-- Dumping data untuk tabel `tbl_icons`
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
-- Struktur dari tabel `tbl_layouts`
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
-- Dumping data untuk tabel `tbl_layouts`
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
-- Struktur dari tabel `tbl_layout_controllers`
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
-- Dumping data untuk tabel `tbl_layout_controllers`
--

INSERT INTO `tbl_layout_controllers` (`id`, `name`, `script`, `is_active`, `created_by`, `create_date`) VALUES
(2, 'class layout', '<?php\r\n\r\n/*\r\n * To change this license header, choose License Headers in Project Properties.\r\n * To change this template file, choose Tools | Templates\r\n * and open the template in the editor.\r\n */\r\n\r\n/**\r\n * Description of [class_name_ucfirst]\r\n *\r\n * @author SuperUser\r\n */\r\nclass [class_name_ucfirst] extends MY_Controller{\r\n\r\n    //put your code here\r\n\r\n    public function __construct() {\r\n        parent::__construct();\r\n        $this->load->model(array(\'[model_name_ucfirst]\'));\r\n    }\r\n\r\n    public function index() {\r\n        redirect([class_base_url](\'[class_path]view/\'));\r\n    }\r\n\r\n    public function view() {\r\n        $data[\'title_for_layout\'] = \'welcome\';\r\n        $data[\'view-header-title\'] = \'View [class_name_ucfirst] List\';\r\n        $data[\'content\'] = \'ini kontent web\';\r\n        $js_files = array(\r\n            static_url(\'templates/metronics/assets/global/scripts/datatable.js\'),\r\n            static_url(\'templates/metronics/assets/global/plugins/datatables/datatables.min.js\'),\r\n            static_url(\'templates/metronics/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js\'),\r\n        );\r\n        $this->load_js($js_files);\r\n        $this->parser->parse(\'layouts/pages/metronic.phtml\', $data);\r\n    }\r\n\r\n    public function get_list() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $this->load->library(\'pagination\');\r\n            //init config for datatables\r\n            $draw = $post[\'draw\'];\r\n            $start = $post[\'start\'];\r\n            $length = $post[\'length\'];\r\n            $search = trim($post[\'search\'][\'value\']);\r\n\r\n            $cond_count = array();\r\n            $cond[\'table\'] = $cond_count[\'table\'] = \'[model_name_ucfirst]\';\r\n            if (isset($search) && !empty($search)) {\r\n                $cond[\'like\'] = $cond_count[\'like\'] = array(\'a.name\', $search);\r\n            }\r\n            $cond[\'fields\'] = array(\'a.*\');\r\n            $cond[\'limit\'] = array(\'perpage\' => $length, \'offset\' => $start);\r\n            $total_rows = $this->[model_name_ucfirst]->find(\'count\', $cond_count);\r\n            $config = array(\r\n                \'base_url\' => [class_base_url](\'[class_path]get_list/\'),\r\n                \'total_rows\' => $total_rows,\r\n                \'per_page\' => $length,\r\n            );\r\n            $this->pagination->initialize($config);\r\n            $res = $this->[model_name_ucfirst]->find(\'all\', $cond);\r\n            $arr = array();\r\n            if (isset($res) && !empty($res)) {\r\n                $i = $start + 1;\r\n                foreach ($res as $d) {\r\n                    $status = \'\';\r\n                    if ($d[\'is_active\'] == 1) {\r\n                        $status = \'checked\';\r\n                    }\r\n                    $action_status = \'<div class=\"form-group\">\r\n                        <div class=\"col-md-9\" style=\"height:30px\">\r\n                            <input type=\"checkbox\" class=\"make-switch\" data-size=\"small\" data-value=\"\' . $d[\'is_active\'] . \'\" data-id=\"\' . $d[\'id\'] . \'\" name=\"status\" \' . $status . \'/>\r\n                        </div>\r\n                    </div>\';\r\n                    $data[\'rowcheck\'] = \'\r\n                    <div class=\"form-group form-md-checkboxes\">\r\n                        <div class=\"md-checkbox-list\">\r\n                            <div class=\"md-checkbox\">\r\n                                <input type=\"checkbox\" id=\"select_tr\' . $d[\'id\'] . \'\" class=\"md-check select_tr\" name=\"select_tr[\' . $d[\'id\'] . \']\" data-id=\"\' . $d[\'id\'] . \'\" />\r\n                                <label for=\"select_tr\' . $d[\'id\'] . \'\">\r\n                                    <span></span>\r\n                                    <span class=\"check\" style=\"left:20px;\"></span>\r\n                                    <span class=\"box\" style=\"left:14px;\"></span>\r\n                                </label>\r\n                            </div>\r\n                        </div>\r\n                    </div>\';\r\n					$data[\'num\'] = $i;\r\n                    $data[\'name\'] = $d[\'name\']; //optional	\r\n                    $data[\'active\'] = $action_status; //optional	\r\n                    $data[\'description\'] = $d[\'description\']; //optional\r\n                    $arr[] = $data;\r\n                    $i++;\r\n                }\r\n            }\r\n            $output = array(\r\n                \'draw\' => $draw,\r\n                \'recordsTotal\' => $total_rows,\r\n                \'recordsFiltered\' => $total_rows,\r\n                \'data\' => $arr,\r\n            );\r\n            //output to json format\r\n            echo json_encode($output);\r\n        } else {\r\n            echo json_encode(array());\r\n        }\r\n    }\r\n\r\n    public function get_data() {\r\n		$post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $res = $this->[model_name_ucfirst]->find(\'first\', array(\r\n                \'conditions\' => array(\'id\' => base64_decode($post[\'id\']))\r\n            ));\r\n            if (isset($res) && !empty($res)) {\r\n                echo json_encode($res);\r\n            } else {\r\n                echo null;\r\n            }\r\n        }\r\n    }\r\n\r\n    public function insert() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $status = 0;\r\n            if ($post[\'active\'] == \'true\') {\r\n                $status = 1;\r\n            }\r\n            $arr_insert = array(\r\n                \'name\' => $post[\'name\'],\r\n                \'description\' => $post[\'description\'],\r\n                \'is_active\' => $status,\r\n                \'created_by\' => (int) base64_decode($this->auth_config->user_id),\r\n                \'create_date\' => date_now()\r\n            );\r\n            $result = $this->[model_name_ucfirst]->insert($arr_insert);\r\n            if ($result == true) {\r\n                echo \'success\';\r\n            } else {\r\n                echo \'failed\';\r\n            }\r\n        } else {\r\n            echo \'failed\';\r\n        }\r\n    }\r\n\r\n    public function update() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $status = 0;\r\n            if ($post[\'active\'] == \"true\") {\r\n                $status = 1;\r\n            }\r\n            $arr = array(\r\n                \'name\' => $post[\'name\'],\r\n                \'description\' => $post[\'description\'],\r\n                \'is_active\' => $status,\r\n            );\r\n            $res = $this->[model_name_ucfirst]->update($arr, base64_decode($post[\'id\']));\r\n            if ($res == true) {\r\n                echo \'success\';\r\n            } else {\r\n                echo \'failed\';\r\n            }\r\n        } else {\r\n            echo \'failed\';\r\n        }\r\n    }\r\n\r\n    public function update_status() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n            $id = base64_decode($post[\'id\']);\r\n            $status = 0;\r\n            if ($post[\'active\'] == \"true\") {\r\n                $status = 1;\r\n            }\r\n            $arr = array(\r\n                \'is_active\' => $status\r\n            );\r\n            $res = $this->[model_name_ucfirst]->update($arr, $id);\r\n            if ($res == true) {\r\n                echo \'success\';\r\n            } else {\r\n                echo \'failed\';\r\n            }\r\n        }\r\n    }\r\n\r\n    public function remove() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n			if(is_array($post[\'id\'])){\r\n				$arr_res = 1;\r\n				foreach($post[\'id\'] AS $key => $val){\r\n					$arr_res = $this->[model_name_ucfirst]->remove($val);\r\n				}\r\n				if($arr_res == true){\r\n					echo \'success\';\r\n				} else {\r\n					echo \'failed\';\r\n				}\r\n			}else{\r\n				$id = base64_decode($post[\'id\']);\r\n				$res = $this->[model_name_ucfirst]->remove($id);\r\n				if ($res == true) {\r\n					echo \'success\';\r\n				} else {\r\n					echo \'failed\';\r\n				}\r\n			}\r\n        }\r\n    }\r\n\r\n    public function delete() {\r\n        $post = $this->input->post(NULL, TRUE);\r\n        if (isset($post) && !empty($post)) {\r\n			if(is_array($post[\'id\'])){\r\n				$arr_res = 1;\r\n				foreach($post[\'id\'] AS $key => $val){\r\n					$arr_res = $this->[model_name_ucfirst]->delete($val);\r\n				}\r\n				if($arr_res == true){\r\n					echo \'success\';\r\n				} else {\r\n					echo \'failed\';\r\n				}\r\n			}else{\r\n				$id = base64_decode($post[\'id\']);\r\n				$res = $this->[model_name_ucfirst]->delete($id);\r\n				if ($res == true) {\r\n					echo \'success\';\r\n				} else {\r\n					echo \'failed\';\r\n				}\r\n			}\r\n        }\r\n    }\r\n\r\n}\r\n', 1, 1, '2019-08-07 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_layout_models`
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
-- Dumping data untuk tabel `tbl_layout_models`
--

INSERT INTO `tbl_layout_models` (`id`, `name`, `script`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'Model Default', '<?php\r\n\r\n/*\r\n * To change this license header, choose License Headers in Project Properties.\r\n * To change this template file, choose Tools | Templates\r\n * and open the template in the editor.\r\n */\r\n\r\n/**\r\n * Description of [model_name_ucfirst]\r\n *\r\n * @author SuperUser\r\n */\r\nClass [model_name_ucfirst] extends MY_Model{\r\n\r\n	public $tableName = \'model_name_ucfirst\';\r\n	\r\n	public function __construct(){\r\n		parent::__construct();\r\n	}\r\n\r\n}\r\n', 1, 1, '2019-05-06 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_layout_views`
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
-- Dumping data untuk tabel `tbl_layout_views`
--

INSERT INTO `tbl_layout_views` (`id`, `name`, `view_html`, `view_js`, `is_active`, `created_by`, `create_date`) VALUES
(1, 'view default', '<div class=\"row\">\r\n    <div class=\"col-md-12\">\r\n        <!-- Begin: life time stats -->\r\n        <div class=\"portlet light portlet-fit portlet-datatable bordered\">\r\n            <div class=\"portlet-title\">\r\n                <div class=\"caption\">\r\n                    <i class=\"icon-settings font-dark\"></i>\r\n                    <span class=\"caption-subject font-dark sbold uppercase\">{view-header-title}</span>\r\n                </div>\r\n                <div class=\"actions\">\r\n                    <div class=\"btn-group\">\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Insert new\" class=\"btn dark btn-outline sbold col-ms-2\" data-toggle=\"modal\" data-id=\"add\" href=\"#modal_add_edit\" id=\"opt_add\">\r\n                            <i class=\"fa fa-plus-square\"></i>\r\n                        </a>\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Update exist\" class=\"btn dark btn-outline sbold disabled col-ms-2\" data-toggle=\"modal\" data-id=\"edit\" href=\"#modal_add_edit\" id=\"opt_edit\" disabled=\"\">\r\n                            <i class=\"fa fa-pencil-square-o\"></i>\r\n                        </a>\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Remove\" class=\"btn dark btn-outline sbold disabled col-ms-2\" data-value=\"remove\" data-id=\"remove\" id=\"opt_remove\" disabled=\"\">\r\n                            <i class=\"fa fa-remove\"></i>\r\n                        </a>\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Delete\" class=\"btn dark btn-outline sbold disabled col-ms-2\" data-value=\"delete\" data-id=\"delete\" id=\"opt_delete\" disabled=\"\">\r\n                            <i class=\"fa fa-trash\"></i>\r\n                        </a>\r\n                        <a style=\"font-size:10px; text-align:center\" title=\"Refresh\" class=\"btn dark btn-outline sbold col-ms-2\" data-value=\"refresh\" data-id=\"refresh\" id=\"opt_refresh\">\r\n                            <i class=\"fa fa-refresh\"></i>\r\n                        </a>\r\n                    </div>\r\n                </div>\r\n            </div>\r\n            <div class=\"portlet-body\">\r\n                <div class=\"table-container\">\r\n                    <table class=\"table table-striped table-bordered table-hover table-checkable\" id=\"datatable_ajax\">\r\n                        <thead>\r\n                            <tr role=\"row\" class=\"heading\">\r\n                                <th width=\"2%\">\r\n                                    <div class=\"form-group form-md-checkboxes\">\r\n                                        <div class=\"md-checkbox-list\">\r\n                                            <div class=\"md-checkbox\">\r\n                                                <input type=\"checkbox\" id=\"select_all\" name=\"select_all\" class=\"md-check\">\r\n                                                <label for=\"select_all\">\r\n                                                    <span></span>\r\n                                                    <span class=\"check\" style=\"left:20px;\"></span>\r\n                                                    <span class=\"box\" style=\"left:14px;\"></span>\r\n                                                </label>\r\n                                            </div>\r\n                                        </div>\r\n                                    </div>\r\n                                </th>\r\n								<th width=\"5%\"> # </th>\r\n                                <th width=\"15%\"> Name </th>\r\n                                <th width=\"15%\"> Status </th>\r\n                                <th width=\"200\"> Description </th>\r\n                            </tr>							\r\n                        </thead>\r\n                        <tbody></tbody>\r\n                    </table>\r\n                </div>\r\n            </div>\r\n        </div>\r\n        <!-- End: life time stats -->\r\n    </div>\r\n</div>\r\n<!-- /.modal -->\r\n<div id=\"modal_add_edit\" class=\"modal\">\r\n    <div class=\"modal-dialog\">\r\n        <div class=\"modal-content\">\r\n            <form method=\"POST\" id=\"add_edit\">\r\n                <div class=\"modal-header\">\r\n                    <button type=\"button\" class=\"close\" data-action=\"close-modal\" aria-hidden=\"true\"></button>\r\n                    <h4 class=\"modal-title\" id=\"title_mdl\"></h4>\r\n                </div>\r\n                <div class=\"modal-body\">\r\n                    <div class=\"scroller\" style=\"height:300px\" data-always-visible=\"1\" data-rail-visible1=\"1\">\r\n                        <div class=\"row\">\r\n                            <div class=\"col-md-12\">\r\n                                <div class=\"form-group\">\r\n                                    <label class=\"control-label\">Name</label>\r\n                                    <div class=\"input-icon right\">\r\n                                        <i class=\"fa fa-info-circle tooltips\" data-original-title=\"Email address\" data-container=\"body\"></i>\r\n                                        <input class=\"form-control\" type=\"text\" name=\"name\" /> \r\n                                    </div>\r\n                                </div>\r\n                                <div class=\"form-group\">\r\n                                    <label>Description</label>\r\n                                    <textarea class=\"form-control\" rows=\"3\" name=\"description\"></textarea>\r\n                                </div>\r\n                                <div class=\"form-group\" style=\"height:30px\">\r\n                                    <label>Active</label><br/>\r\n                                    <input type=\"checkbox\" class=\"make-switch\" data-size=\"small\" name=\"status\"/>\r\n                                </div>\r\n                            </div>\r\n                        </div>\r\n                    </div>\r\n                </div>\r\n                <div class=\"modal-footer\">\r\n                    <input type=\"text\" name=\"id\" hidden />\r\n                    <button type=\"button\" data-action=\"close-modal\" class=\"btn dark btn-outline\">Close</button>\r\n                    <button type=\"submit\" class=\"btn green\">Save changes</button>\r\n                </div>\r\n            </form>\r\n        </div>\r\n    </div>\r\n</div>', '\r\n    var TableDatatablesAjax = function () {\r\n        return {\r\n            //main function to initiate the module\r\n            init: function () {\r\n                var table = $(\'#datatable_ajax\').DataTable({\r\n                    \"lengthMenu\": [[10, 25, 50], [10, 25, 50]],\r\n                    \"sPaginationType\": \"bootstrap\",\r\n                    \"paging\": true,\r\n                    \"pagingType\": \"full_numbers\",\r\n                    \"ordering\": false,\r\n                    \"serverSide\": true,\r\n                    \"ajax\": {\r\n                        url: [class_base_url] + \'[class_path]get_list/\',\r\n                        type: \'POST\'\r\n                    },\r\n                    \"columns\": [\r\n                        {\"data\": \"rowcheck\"},\r\n                        {\"data\": \"num\"},\r\n                        {\"data\": \"name\"},\r\n                        {\"data\": \"active\"},\r\n                        {\"data\": \"description\"}\r\n                    ],\r\n                    \"drawCallback\": function (master) {\r\n                        $(\'.make-switch\').bootstrapSwitch();\r\n                    }\r\n                });\r\n\r\n                $(\'#datatable_ajax\').on(\'switchChange.bootstrapSwitch\', \'input[name=\"status\"]\', function (event, state) {\r\n                    console.log(state); // true | false\r\n                    var id = $(this).attr(\'data-id\');\r\n                    var formdata = {\r\n                        id: Base64.encode(id),\r\n                        active: state\r\n                    };\r\n                    $.ajax({\r\n                        url: [class_base_url] + \'[class_path]update_status/\',\r\n                        method: \"POST\", //First change type to method here\r\n                        data: formdata,\r\n                        success: function (response) {\r\n                            toastr.success(\'Successfully \' + response);\r\n                            return false;\r\n                        },\r\n                        error: function () {\r\n                            toastr.error(\'Failed \' + response);\r\n                            return false;\r\n                        }\r\n\r\n                    });\r\n                });\r\n\r\n                $(\'a.btn\').on(\'click\', function () {\r\n                    var action = $(this).attr(\'data-id\');\r\n                    var count = $(\'input.select_tr:checkbox\').filter(\':checked\').length;\r\n                    switch (action) {\r\n                        case \'add\':\r\n                            $(\'.modal-title\').html(\'Insert New [class_name_ucfirst]\');\r\n                            break;\r\n\r\n                        case \'edit\':\r\n                            $(\'.modal-title\').html(\'Update Exist [class_name_ucfirst]\');\r\n                            var status_ = $(this).hasClass(\'disabled\');\r\n                            var id = $(\'input.select_tr:checkbox:checked\').attr(\'data-id\');\r\n                            if (status_ == 0) {\r\n                                var formdata = {\r\n                                    id: Base64.encode(id)\r\n                                };\r\n                                $.ajax({\r\n                                    url: [class_base_url] + \'[class_path]get_data/\',\r\n                                    method: \"POST\", //First change type to method here\r\n                                    data: formdata,\r\n                                    success: function (response) {\r\n                                        var row = JSON.parse(response);\r\n                                        var status_ = false;\r\n                                        if (row.is_active == 1) {\r\n                                            status_ = true;\r\n                                        }\r\n                                        $(\'input[name=\"id\"]\').val(row.id);\r\n                                        $(\'input[name=\"name\"]\').val(row.name);\r\n                                        $(\"[name=\'status\']\").bootstrapSwitch(\'state\', status_);\r\n                                        $(\'textarea[name=\"description\"]\').val(row.description);\r\n                                        $(\'#modal_add_edit\').modal(\'show\');\r\n                                    },\r\n                                    error: function () {\r\n                                        fnToStr(\'Error is occured, please contact administrator.\', \'error\');\r\n                                    }\r\n                                });\r\n                                return false;\r\n                            }\r\n                            break;\r\n\r\n                        case \'remove\':\r\n                            bootbox.confirm(\"Are you sure to remove this id?\", function (result) {\r\n                                if (result == true) {\r\n                                    var uri = [class_base_url] + \'[class_path]remove/\';\r\n                                    if (count > 1) {\r\n                                        var ids = [];\r\n                                        $(\"input.select_tr:checkbox:checked\").each(function () {\r\n                                            ids.push($(this).data(\"id\"));\r\n                                        });\r\n                                    } else {\r\n                                        var ids = $(\'input.select_tr:checkbox:checked\').attr(\'data-id\');\r\n                                    }\r\n                                    fnActionId(uri, ids, \'remove\');\r\n                                    fnRefreshDataTable();\r\n                                    fnResetBtn();\r\n                                } else {\r\n                                    fnToStr(\'You re cancelling remove this id\', \'info\');\r\n                                    fnRefreshDataTable();\r\n                                    fnResetBtn();\r\n                                }\r\n                            });\r\n                            break;\r\n\r\n                        case \'delete\':\r\n                            bootbox.confirm(\"Are you sure to delete this id?\", function (result) {\r\n                                if (result == true) {\r\n                                    var uri = [class_base_url] + \'[class_path]delete/\';\r\n                                    if (count > 1) {\r\n                                        id = [];\r\n                                        $(\"input.select_tr:checkbox:checked\").each(function () {\r\n                                            id.push($(this).data(\"id\"));\r\n                                        });\r\n                                    }\r\n                                    fnActionId(uri, id, \'remove\');\r\n                                    fnRefreshDataTable();\r\n                                    fnResetBtn();\r\n                                } else {\r\n                                    fnToStr(\'You re cancelling delete this id\', \'info\');\r\n                                    fnRefreshDataTable();\r\n                                    fnResetBtn();\r\n                                }\r\n                            });\r\n                            break;\r\n\r\n                        case \'refresh\':\r\n                            fnRefreshDataTable();\r\n                            break;\r\n                    }\r\n                });\r\n\r\n                $(\"#add_edit\").submit(function () {\r\n                    var id = $(\'input[name=\"id\"]\').val();\r\n                    var is_active = $(\"[name=\'status\']\").bootstrapSwitch(\'state\');\r\n                    var uri = [class_base_url] + \'[class_path]insert/\';\r\n                    var txt = \'add new group\';\r\n                    var formdata = {\r\n                        name: $(\'input[name=\"name\"]\').val(),\r\n                        description: $(\'textarea[name=\"description\"]\').val(),\r\n                        active: is_active\r\n                    };\r\n                    if (id)\r\n                    {\r\n                        uri = [class_base_url] + \'[class_path]update/\';\r\n                        txt = \'update group\';\r\n                        formdata = {\r\n                            id: Base64.encode(id),\r\n                            name: $(\'input[name=\"name\"]\').val(),\r\n                            description: $(\'textarea[name=\"description\"]\').val(),\r\n                            active: is_active\r\n                        };\r\n                    }\r\n                    $.ajax({\r\n                        url: uri,\r\n                        method: \"POST\", //First change type to method here\r\n                        data: formdata,\r\n                        success: function (response) {\r\n                            toastr.success(\'Successfully \' + txt);\r\n                            fnCloseModal();\r\n                        },\r\n                        error: function () {\r\n                            toastr.error(\'Failed \' + txt);\r\n                            fnCloseModal();\r\n                        }\r\n\r\n                    });\r\n                    return false;\r\n                });\r\n            }\r\n        };\r\n\r\n    }();\r\n\r\n    jQuery(document).ready(function () {\r\n        TableDatatablesAjax.init();\r\n    });', 1, 1, '2019-05-06 00:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_menus`
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
-- Dumping data untuk tabel `tbl_menus`
--

INSERT INTO `tbl_menus` (`id`, `name`, `name_ina`, `path`, `rank`, `level`, `icon`, `badge`, `is_open`, `is_badge`, `module_id`, `is_logged_in`, `is_active`, `description`, `parent_id`, `created_by`, `create_date`) VALUES
(1, 'Tickets', 'Tiket', '#', 1, 1, '10', '', 1, 0, 2, 1, 1, '-', 0, 1, '2019-05-08 12:34:58'),
(2, 'Create', 'Buat baru', 'tickets/master/create', 1, 2, '7', '', 0, 0, 2, 1, 1, '-', 1, 1, '2019-05-08 12:37:03'),
(3, 'Views', 'Lihat', '#', 2, 2, '7', '', 1, 0, 2, 1, 1, '-', 1, 1, '2019-05-08 13:01:43'),
(4, 'Open', 'Open', 'tickets/master/view/open', 1, 3, '4', '#5ccd18', 1, 1, 2, 1, 1, '-', 3, 1, '2019-05-08 13:03:52'),
(5, 'Progress', 'Progress', 'tickets/master/view/progress', 2, 3, '7', '#ffb136', 1, 1, 2, 1, 1, '-', 3, 1, '2019-05-08 13:07:38'),
(6, 'Close', 'Close', 'tickets/master/view/close', 4, 3, '7', '#32c5d2', 1, 1, 2, 1, 1, '-', 3, 1, '2019-05-08 13:08:10'),
(7, 'Accounts', 'Akun', '#', 2, 1, '5', '', 0, 0, 2, 1, 1, '-', 0, 1, '2019-05-08 13:08:50'),
(8, 'Employee Officer', 'Karyawan kantor ', 'accounts/officer/view', 0, 2, '8', '', 0, 0, 2, 1, 1, '-', 7, 1, '2019-05-08 13:09:16'),
(9, 'vendor', 'vendor', 'accounts/vendor/view', 0, 2, '7', '', 0, 0, 2, 1, 1, '-', 7, 1, '2019-05-08 13:09:34'),
(10, 'Admin', 'Admin', 'accounts/admin/view', 0, 2, '9', '', 0, 0, 2, 1, 1, '-', 7, 1, '2019-05-08 13:10:11'),
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
(23, 'Office Branch', 'Kantor Cabang', 'tickets/office_branch/view', 0, 3, '10', '', 0, 0, 2, 1, 1, '-', 12, 1, '2019-05-08 13:25:31'),
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
(65, 'Ticket', 'Tiket', '#', 1, 2, '11', '', 0, 0, 2, 1, 1, '', 31, 1, '2019-06-27 09:35:17'),
(69, 'By Category', 'Berdasarkan Kategori', 'reports/ticket/by_category', 1, 3, '4', '', 0, 0, 2, 1, 1, '-', 65, 1, '2019-06-27 10:14:29'),
(72, 'By Ticket Code', 'Berdasarkan kode tiket', 'reports/ticket/by_ticket', 2, 3, '-- select one --', '', 0, 0, 2, 1, 1, '-', 65, 1, '2019-07-01 08:19:14'),
(73, 'Problem Effect', 'Efek permasalahan', 'master/problem_effect/view', 8, 2, '6', '', 0, 0, 2, 1, 1, '-', 11, 1, '2019-07-04 09:55:13'),
(74, 'Login Notification', 'Pemberitahuan masuk', 'prefferences/login_notification/view', 5, 2, '10', '', 0, 0, 2, 1, 1, '-', 25, 1, '2019-07-12 16:10:47'),
(75, 'Ajax Plugin', 'Ajax Tambahan ', 'prefferences/ajax_plugin/view', 7, 2, '7', '', 0, 0, 2, 1, 1, '-', 25, 1, '2019-07-16 08:40:53'),
(76, 'Monitoring', 'Pemantau', 'accounts/monitor/view', 4, 2, '4', '', 0, 0, 2, 1, 1, '-', 7, 1, '2019-07-16 10:22:40'),
(77, 'Graphic', 'Grafik', 'vendor/report/monitoring/view', 2, 2, '5', '', 0, 0, 3, 1, 1, '-', 39, 1, '2019-09-12 17:34:02'),
(79, 'By category', 'Berdasarkan Kategori', 'reports/v1_ticket/by_category', 1, 3, '7', '', 0, 0, 2, 1, 1, '-', 64, 1, '2019-09-23 09:53:45'),
(80, 'By Ticket Code', 'Berdasarkan kode tiket', 'reports/v1_ticket/by_ticket', 2, 3, '10', '', 0, 0, 2, 1, 1, '-', 64, 1, '2019-09-23 09:54:57'),
(81, 'Graphics', 'Grafik', 'reports/monitoring/view', 3, 3, '6', '', 0, 0, 2, 1, 1, '-', 65, 1, '2019-09-23 09:56:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_method_masters`
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
-- Dumping data untuk tabel `tbl_method_masters`
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
-- Struktur dari tabel `tbl_modules`
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
-- Dumping data untuk tabel `tbl_modules`
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
-- Struktur dari tabel `tbl_permissions`
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
-- Dumping data untuk tabel `tbl_permissions`
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
(74, 'backend', 'office_branch', 'index', '-', 1, 1, '2019-05-13 10:11:50'),
(75, 'backend', 'office_branch', 'view', '-', 1, 1, '2019-05-13 10:11:50'),
(76, 'backend', 'office_branch', 'insert', '-', 1, 1, '2019-05-13 10:11:50'),
(77, 'backend', 'office_branch', 'remove', '-', 1, 1, '2019-05-13 10:11:51'),
(78, 'backend', 'office_branch', 'delete', '-', 1, 1, '2019-05-13 10:11:51'),
(79, 'backend', 'office_branch', 'update', '-', 1, 1, '2019-05-13 10:11:51'),
(80, 'backend', 'office_branch', 'get_list', '-', 1, 1, '2019-05-13 10:11:51'),
(81, 'backend', 'office_branch', 'get_data', '-', 1, 1, '2019-05-13 10:11:51'),
(82, 'backend', 'office_branch', 'get_vendor_user_list', '-', 1, 1, '2019-05-13 10:11:51'),
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
(403, 'backend', 'officer', 'update_status', '-', 1, 1, '2019-08-02 08:00:42'),
(404, 'backend', 'rule', 'update_status', '-', 1, 1, '2019-08-02 14:28:28'),
(405, 'backend', 'office_branch', 'update_status', '-', 1, 1, '2019-08-02 15:00:54'),
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
(446, 'backend', 'ticket', 'index', '-', 1, 1, '2019-09-23 11:39:21'),
(447, 'backend', 'ticket', 'view', '-', 1, 1, '2019-09-23 11:39:21'),
(448, 'backend', 'ticket', 'get_list', '-', 1, 1, '2019-09-23 11:39:21'),
(449, 'backend', 'ticket', 'get_data', '-', 1, 1, '2019-09-23 11:39:21'),
(450, 'backend', 'ticket', 'index', '-', 1, 1, '2019-09-23 11:40:06'),
(451, 'backend', 'ticket', 'view', '-', 1, 1, '2019-09-23 11:40:06'),
(452, 'backend', 'ticket', 'get_list', '-', 1, 1, '2019-09-23 11:40:06'),
(453, 'backend', 'ticket', 'get_data', '-', 1, 1, '2019-09-23 11:40:06'),
(454, 'backend', 'monitoring', 'index', '-', 1, 1, '2019-09-23 11:40:41'),
(455, 'backend', 'monitoring', 'view', '-', 1, 1, '2019-09-23 11:40:41'),
(456, 'backend', 'monitoring', 'get_list', '-', 1, 1, '2019-09-23 11:40:41'),
(457, 'backend', 'monitoring', 'get_data', '-', 1, 1, '2019-09-23 11:40:41'),
(458, 'backend', 'ticket', 'by_ticket', '-', 1, 1, '2019-09-23 11:41:21'),
(459, 'backend', 'ticket', 'by_category', '-', 1, 1, '2019-09-23 11:41:44'),
(460, 'backend', 'ticket', 'by_category', '-', 1, 1, '2019-09-23 11:41:49'),
(461, 'backend', 'ticket', 'by_category', '-', 1, 1, '2019-09-23 13:11:41'),
(462, 'backend', 'ticket', 'by_ticket', '-', 1, 1, '2019-09-23 13:11:58'),
(463, 'backend', 'ticket', 'get_category_select', '-', 1, 1, '2019-09-23 13:49:16'),
(464, 'backend', 'ticket', 'generate', '-', 1, 1, '2019-09-24 11:42:37'),
(465, 'backend', 'ticket', 'gen_to_pdf', '-', 1, 1, '2019-10-02 13:55:09'),
(466, 'vendor', 'ticket', 'gen_to_pdf', '-', 1, 1, '2019-10-03 09:57:17'),
(467, 'backend', 'monitoring', 'get_total_ticket_per_month', '-', 1, 1, '2019-10-04 11:31:41'),
(468, 'backend', 'monitoring', 'get_total_ticket_per_kanim', '-', 1, 1, '2019-10-04 11:31:59'),
(469, 'backend', 'monitoring', 'get_total_ticket_per_month_by_status', '-', 1, 1, '2019-10-04 11:32:19'),
(470, 'backend', 'monitoring', 'get_total_ticket_progress_per_month', '-', 1, 1, '2019-10-04 11:32:56'),
(471, 'backend', 'officer', 'download_sample', '-', 1, 1, '2019-10-14 14:36:29'),
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
(482, 'backend', 'ticket', 'gen_to_pdf', '-', 1, 1, '2019-10-22 16:28:03'),
(483, 'backend', 'officer', 'index', '-', 1, 1, '2019-09-23 11:39:21'),
(484, 'backend', 'officer', 'view', '-', 1, 1, '2019-09-23 11:39:21'),
(485, 'backend', 'officer', 'get_list', '-', 1, 1, '2019-09-23 11:39:21'),
(486, 'backend', 'officer', 'get_data', '-', 1, 1, '2019-09-23 11:39:21'),
(487, 'backend', 'officer', 'index', '-', 1, 1, '2019-09-23 11:40:06'),
(488, 'backend', 'officer', 'view', '-', 1, 1, '2019-09-23 11:40:06'),
(489, 'backend', 'officer', 'get_list', '-', 1, 1, '2019-09-23 11:40:06'),
(490, 'backend', 'officer', 'get_data', '-', 1, 1, '2019-09-23 11:40:06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_users`
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
-- Dumping data untuk tabel `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `nik`, `username`, `first_name`, `last_name`, `email`, `password`, `activation_code`, `status`, `is_active`, `is_logged_in`, `created_by`, `create_date`) VALUES
(1, '2019090601000001', 'superuser', 'super', 'user', 'superuser@gmaol.co.id', '$2y$12$kihT9/YswV0QItLCnvGScuiTDfwqoW0ppG1K91ElwUXQ6TvJs6rbS', '', 3, 1, 1, 1, '2019-09-07 19:17:38'),
(2, '2019090601000002', 'adit', 'adit', 'admin', 'adit@gmaol.co.id', '$2y$12$3dBjIajcGTGn.Hjqw.GftesA.fczhgEJvU86CeWRX3Nc.SPQhgare', '', 3, 1, 1, 1, '2019-09-07 19:18:48'),
(4, '20190906023000002', 'jaksel', 'kanim', 'jaksel', 'jaksel@gmaol.co.id', '$2y$12$m9FuNKamAMa.rFwoaCvm6O0livsb32UbS9Uk4/JcdAaaAXhSRtV3S', '', 3, 1, 1, 1, '2019-09-07 20:04:51'),
(5, '20190906023000003', 'jakut', 'kanim', 'jakut', 'jakut@gmaol.co.id', '$2y$12$VKNVvcvoQYbifP1skVT6DeguEbBRCK/5uzdCUiPqG5dBtJQ0C2a96', '', 3, 1, 1, 1, '2019-09-07 20:06:37'),
(6, '20190906011000002', 'bayu ', 'bayus', 'signet', 'bayu@gmaol.co.id', '$2y$12$VvNdgwkufTWYNJMpnjuAMOsbsby/xvp9oSWN0QZ9unJ6Sfg3P4KMy', '', 3, 1, 1, 1, '2019-09-08 18:33:49'),
(7, '20190906011000003', 'valdi ', 'valdi', 'signet', 'valdi@gmaol.co.id', '$2y$12$HPbOCdHesB0xEiExu9vl1e54YN8H7pco0pU1aZe7iE5NnlYx99DKu', '', 3, 1, 0, 1, '2019-09-10 09:16:17'),
(8, '20190906011000004', 'budi', 'budi', 'signet', 'budi@gmaol.co.id', '$2y$12$hPtEZ4mNp.RVGJTTnaEABeLd98W8.m1n6Jh1fUWF3ODsMUE.K3Gdi', '', 3, 1, 1, 1, '2019-09-10 09:19:39'),
(9, '20190906025000002', 'dede abc', 'dede', 'abc', 'dede@gmaol.co.id', '$2y$12$54JZFgbSzjwOn2q3binDLeJJfdL/eQ63KDUMBYQQOEavAM3ML/OWW', '', 3, 1, 1, 1, '2019-09-10 09:27:40'),
(10, '20190906023000006', 'dadang abc', 'dadang', 'abc', 'dadang@gmaol.co.id', '$2y$12$A2R1QaCXmVM47M3Isw0USucPPXFrj6f2EamLk8qdE8puX78Hd7H6i', '', 3, 1, 1, 1, '2019-09-10 09:38:43'),
(11, '20190906023000007', 'syehbi', 'syehbi', 'signet', 'syehbi@gmaol.co.id', '$2y$12$2FzENvFvCkLm2i73oOElJ./seYIIYg2I6/XJBpVMa4.jBFBFufxdC', '', 3, 1, 0, 1, '2019-09-12 15:31:53'),
(12, '20190906023000007', 'syehbi ', 'syehbi', 'sadsadas', 'syehbi@gmail.co.id', '$2y$12$orL70CstmSTJyD/kcKw/2uW.IyBuBVoN1gHv4JnXl5uFMDMTEGQaC', '', 3, 1, 0, 1, '2019-09-12 15:33:50'),
(13, '20190906011000004', 'budi ', 'budis', 'signet', 'budi@gmaol.co.id', '$2y$12$YZej.S7oWCuAHRcfseqRSuFY.Gx5Q8wYULqmzrYe7AfxZhb8HpAoq', '', 3, 1, 0, 1, '2019-09-12 16:27:21'),
(14, '', 'monitoring', 'monitoring', 'imi', 'monitoring@gmaol.co.id', '$2y$12$PtycFur4oLVVMHOHSg6Nv.j48Sl5f9jLTUfZFTpp1faxxqzmjK35O', '', 3, 1, 1, 1, '2019-09-12 17:04:15'),
(15, '20190906023000004', 'jakbar', '', 'jakbar', 'jakbar@gmaol.co.id', '$2y$12$eVSu1VQoqGHpqa7BKMX.lOvsMSyv4sQC4j4OGLDraTSZveSXKnlEC', '', 3, 1, 0, 1, '2019-09-17 14:46:30'),
(16, '20190906023000005', 'jaktim', '', 'jaktim', 'jaktim@gmaol.co.id', '$2y$12$Mh2.oakpeHLFVDkbKJUl0OKP/g5RjbBDGDOnHA2bI.XREqtR6bpCW', '', 3, 1, 0, 1, '2019-09-17 14:51:41'),
(17, '20190906023000005', 'ambon', '', 'ambon', 'ambon@gmaol.co.id', '$2y$12$rwwEtMdw4lUfhSdYH1rniOVvp21usY1ixNkPZDsC2B3QyG/hjW0Om', '', 3, 1, 0, 1, '2019-09-17 14:59:26'),
(18, '20190906023000006', 'balikpapan', '', 'balikpapan', 'balikpapan@gmaol.co.id', '$2y$12$N8lvVIWUARN5wviPuYZnWeZflmzHmgxfYrocKw2oX2niepnF7Wz4W', '', 3, 1, 0, 1, '2019-09-17 16:18:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tbl_user_groups`
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
-- Dumping data untuk tabel `tbl_user_groups`
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
-- Struktur dari tabel `tbl_user_profiles`
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
-- Indeks untuk tabel `tbl_ajax_plugins`
--
ALTER TABLE `tbl_ajax_plugins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_cms_categories`
--
ALTER TABLE `tbl_cms_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_cms_category_contents`
--
ALTER TABLE `tbl_cms_category_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_cms_comments`
--
ALTER TABLE `tbl_cms_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_cms_contents`
--
ALTER TABLE `tbl_cms_contents`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_cms_content_photos`
--
ALTER TABLE `tbl_cms_content_photos`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_component_messages`
--
ALTER TABLE `tbl_component_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_component_message_categories`
--
ALTER TABLE `tbl_component_message_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_component_message_labels`
--
ALTER TABLE `tbl_component_message_labels`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_component_notifications`
--
ALTER TABLE `tbl_component_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_component_notification_categories`
--
ALTER TABLE `tbl_component_notification_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_component_notification_status`
--
ALTER TABLE `tbl_component_notification_status`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_component_task_categories`
--
ALTER TABLE `tbl_component_task_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_component_task_status`
--
ALTER TABLE `tbl_component_task_status`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_configs`
--
ALTER TABLE `tbl_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_email_configs`
--
ALTER TABLE `tbl_email_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_email_layout`
--
ALTER TABLE `tbl_email_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_groups`
--
ALTER TABLE `tbl_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_group_permissions`
--
ALTER TABLE `tbl_group_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_activities`
--
ALTER TABLE `tbl_helpdesk_activities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_branchs`
--
ALTER TABLE `tbl_helpdesk_branchs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_contracts`
--
ALTER TABLE `tbl_helpdesk_contracts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_employees`
--
ALTER TABLE `tbl_helpdesk_employees`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_employee_monitors`
--
ALTER TABLE `tbl_helpdesk_employee_monitors`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_employee_users`
--
ALTER TABLE `tbl_helpdesk_employee_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_login_notifications`
--
ALTER TABLE `tbl_helpdesk_login_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_logs`
--
ALTER TABLE `tbl_helpdesk_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_tickets`
--
ALTER TABLE `tbl_helpdesk_tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_categories`
--
ALTER TABLE `tbl_helpdesk_ticket_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_chats`
--
ALTER TABLE `tbl_helpdesk_ticket_chats`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_files`
--
ALTER TABLE `tbl_helpdesk_ticket_files`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_handlers`
--
ALTER TABLE `tbl_helpdesk_ticket_handlers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_issue_suggestions`
--
ALTER TABLE `tbl_helpdesk_ticket_issue_suggestions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_logs`
--
ALTER TABLE `tbl_helpdesk_ticket_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_priorities`
--
ALTER TABLE `tbl_helpdesk_ticket_priorities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_problem_impacts`
--
ALTER TABLE `tbl_helpdesk_ticket_problem_impacts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_reopen_logs`
--
ALTER TABLE `tbl_helpdesk_ticket_reopen_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_requests`
--
ALTER TABLE `tbl_helpdesk_ticket_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_rules`
--
ALTER TABLE `tbl_helpdesk_ticket_rules`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_status`
--
ALTER TABLE `tbl_helpdesk_ticket_status`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_transactions`
--
ALTER TABLE `tbl_helpdesk_ticket_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_ticket_transfers`
--
ALTER TABLE `tbl_helpdesk_ticket_transfers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_users`
--
ALTER TABLE `tbl_helpdesk_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_vendors`
--
ALTER TABLE `tbl_helpdesk_vendors`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_helpdesk_vendor_users`
--
ALTER TABLE `tbl_helpdesk_vendor_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_hepldesk_ticket_numbers`
--
ALTER TABLE `tbl_hepldesk_ticket_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_icons`
--
ALTER TABLE `tbl_icons`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_layouts`
--
ALTER TABLE `tbl_layouts`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_layout_controllers`
--
ALTER TABLE `tbl_layout_controllers`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_layout_models`
--
ALTER TABLE `tbl_layout_models`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_layout_views`
--
ALTER TABLE `tbl_layout_views`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_menus`
--
ALTER TABLE `tbl_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_method_masters`
--
ALTER TABLE `tbl_method_masters`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_modules`
--
ALTER TABLE `tbl_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_user_groups`
--
ALTER TABLE `tbl_user_groups`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `tbl_user_profiles`
--
ALTER TABLE `tbl_user_profiles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tbl_ajax_plugins`
--
ALTER TABLE `tbl_ajax_plugins`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_cms_categories`
--
ALTER TABLE `tbl_cms_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_cms_category_contents`
--
ALTER TABLE `tbl_cms_category_contents`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_cms_comments`
--
ALTER TABLE `tbl_cms_comments`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_cms_contents`
--
ALTER TABLE `tbl_cms_contents`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_cms_content_photos`
--
ALTER TABLE `tbl_cms_content_photos`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_component_messages`
--
ALTER TABLE `tbl_component_messages`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_component_message_categories`
--
ALTER TABLE `tbl_component_message_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_component_message_labels`
--
ALTER TABLE `tbl_component_message_labels`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_component_notifications`
--
ALTER TABLE `tbl_component_notifications`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_component_notification_categories`
--
ALTER TABLE `tbl_component_notification_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_component_notification_status`
--
ALTER TABLE `tbl_component_notification_status`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_component_task_categories`
--
ALTER TABLE `tbl_component_task_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_component_task_status`
--
ALTER TABLE `tbl_component_task_status`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_configs`
--
ALTER TABLE `tbl_configs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT untuk tabel `tbl_email_configs`
--
ALTER TABLE `tbl_email_configs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_email_layout`
--
ALTER TABLE `tbl_email_layout`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_groups`
--
ALTER TABLE `tbl_groups`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_group_permissions`
--
ALTER TABLE `tbl_group_permissions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_activities`
--
ALTER TABLE `tbl_helpdesk_activities`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_branchs`
--
ALTER TABLE `tbl_helpdesk_branchs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_contracts`
--
ALTER TABLE `tbl_helpdesk_contracts`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_employees`
--
ALTER TABLE `tbl_helpdesk_employees`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_employee_monitors`
--
ALTER TABLE `tbl_helpdesk_employee_monitors`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_employee_users`
--
ALTER TABLE `tbl_helpdesk_employee_users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_login_notifications`
--
ALTER TABLE `tbl_helpdesk_login_notifications`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_logs`
--
ALTER TABLE `tbl_helpdesk_logs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_tickets`
--
ALTER TABLE `tbl_helpdesk_tickets`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_categories`
--
ALTER TABLE `tbl_helpdesk_ticket_categories`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_chats`
--
ALTER TABLE `tbl_helpdesk_ticket_chats`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_files`
--
ALTER TABLE `tbl_helpdesk_ticket_files`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_handlers`
--
ALTER TABLE `tbl_helpdesk_ticket_handlers`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_issue_suggestions`
--
ALTER TABLE `tbl_helpdesk_ticket_issue_suggestions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_logs`
--
ALTER TABLE `tbl_helpdesk_ticket_logs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_priorities`
--
ALTER TABLE `tbl_helpdesk_ticket_priorities`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_problem_impacts`
--
ALTER TABLE `tbl_helpdesk_ticket_problem_impacts`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_reopen_logs`
--
ALTER TABLE `tbl_helpdesk_ticket_reopen_logs`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_requests`
--
ALTER TABLE `tbl_helpdesk_ticket_requests`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_rules`
--
ALTER TABLE `tbl_helpdesk_ticket_rules`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_status`
--
ALTER TABLE `tbl_helpdesk_ticket_status`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_transactions`
--
ALTER TABLE `tbl_helpdesk_ticket_transactions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_ticket_transfers`
--
ALTER TABLE `tbl_helpdesk_ticket_transfers`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_users`
--
ALTER TABLE `tbl_helpdesk_users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_vendors`
--
ALTER TABLE `tbl_helpdesk_vendors`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tbl_helpdesk_vendor_users`
--
ALTER TABLE `tbl_helpdesk_vendor_users`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tbl_hepldesk_ticket_numbers`
--
ALTER TABLE `tbl_hepldesk_ticket_numbers`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tbl_icons`
--
ALTER TABLE `tbl_icons`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `tbl_layouts`
--
ALTER TABLE `tbl_layouts`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `tbl_layout_controllers`
--
ALTER TABLE `tbl_layout_controllers`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `tbl_layout_models`
--
ALTER TABLE `tbl_layout_models`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `tbl_permissions`
--
ALTER TABLE `tbl_permissions`
  MODIFY `id` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=491;
COMMIT;
