-- MariaDB dump 10.19  Distrib 10.6.12-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: Nerdy_pt-demo
-- ------------------------------------------------------
-- Server version	10.6.12-MariaDB-0ubuntu0.22.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `EpochTransStats`
--

DROP TABLE IF EXISTS `EpochTransStats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `EpochTransStats` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ets_transaction_id` bigint(20) NOT NULL,
  `ets_member_idx` bigint(20) NOT NULL,
  `ets_transaction_date` datetime NOT NULL,
  `ets_transaction_type` char(1) NOT NULL,
  `ets_co_code` varchar(6) NOT NULL,
  `ets_pi_code` varchar(32) NOT NULL,
  `ets_reseller_code` varchar(16) NOT NULL,
  `ets_transaction_amount` decimal(10,2) NOT NULL,
  `ets_payment_type` char(1) NOT NULL,
  `ets_pst_type` char(2) NOT NULL,
  `ets_username` varchar(32) NOT NULL,
  `ets_password` varchar(32) NOT NULL,
  `ets_ref_trans_ids` bigint(20) NOT NULL,
  `ets_password_expire` varchar(20) NOT NULL,
  `ets_email` varchar(64) NOT NULL,
  `ets_ipaddr` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `MemberCancelStats`
--

DROP TABLE IF EXISTS `MemberCancelStats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `MemberCancelStats` (
  `mcs_or_idx` bigint(20) NOT NULL,
  `mcs_canceldate` datetime NOT NULL,
  `mcs_signupdate` datetime NOT NULL,
  `mcs_cocode` varchar(16) NOT NULL,
  `mcs_picode` varchar(32) NOT NULL,
  `mcs_reseller` varchar(16) NOT NULL,
  `mcs_reason` varchar(64) NOT NULL,
  `mcs_memberstype` char(1) NOT NULL,
  `mcs_username` varchar(32) NOT NULL,
  `mcs_email` varchar(64) NOT NULL,
  `mcs_passwordremovaldate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `adm`
--

DROP TABLE IF EXISTS `adm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `active` varchar(128) DEFAULT NULL,
  `urole` varchar(128) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `banned` varchar(5) DEFAULT NULL,
  `profile_img` text DEFAULT NULL,
  `mobile` varchar(64) DEFAULT NULL,
  `last_login_ip` varchar(64) DEFAULT NULL,
  `last_login_country` varchar(64) DEFAULT NULL,
  `last_login_at` varchar(20) DEFAULT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `date_of_birth` varchar(64) DEFAULT NULL,
  `occupation` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_date` varchar(32) DEFAULT NULL,
  `access` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ann`
--

DROP TABLE IF EXISTS `ann`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ann` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg_id` int(11) DEFAULT NULL,
  `target_id` int(11) DEFAULT NULL,
  `been_read` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) DEFAULT NULL,
  `slug` varchar(128) DEFAULT NULL,
  `member_id` int(11) DEFAULT NULL,
  `updated` varchar(20) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `featured_image` varchar(128) DEFAULT NULL,
  `body` mediumtext DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `citem`
--

DROP TABLE IF EXISTS `citem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `citem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(128) DEFAULT NULL,
  `item_tip` varchar(128) DEFAULT NULL,
  `item_desc` varchar(128) DEFAULT NULL,
  `item_dur` int(11) DEFAULT NULL,
  `vendo_code` varchar(128) DEFAULT NULL,
  `item_type` varchar(64) DEFAULT NULL,
  `aquete_code` varchar(64) DEFAULT NULL,
  `wallet_value` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_menu_item`
--

DROP TABLE IF EXISTS `custom_menu_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_menu_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` text DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `custom_page`
--

DROP TABLE IF EXISTS `custom_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `custom_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `syskey` varchar(128) DEFAULT NULL,
  `hook` text DEFAULT NULL,
  `body` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `em_template`
--

DROP TABLE IF EXISTS `em_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `em_template` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text DEFAULT NULL,
  `email_subject` varchar(128) DEFAULT NULL,
  `preset` varchar(64) DEFAULT NULL,
  `tpl_key` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `epc_mem`
--

DROP TABLE IF EXISTS `epc_mem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epc_mem` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `epc_mem_id` bigint(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `inv_period` int(11) NOT NULL,
  `pi_code` varchar(100) NOT NULL,
  `last_instant` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `epc_sett`
--

DROP TABLE IF EXISTS `epc_sett`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `epc_sett` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `live_mode` tinyint(4) NOT NULL,
  `epc_code_1` varchar(100) NOT NULL,
  `epc_name_1` varchar(100) NOT NULL,
  `epc_tip_1` varchar(100) NOT NULL,
  `epc_desc_1` varchar(100) NOT NULL,
  `epc_dur_1` int(11) NOT NULL,
  `epc_code_2` varchar(100) NOT NULL,
  `epc_name_2` varchar(100) NOT NULL,
  `epc_tip_2` varchar(100) NOT NULL,
  `epc_desc_2` varchar(100) NOT NULL,
  `epc_dur_2` int(11) NOT NULL,
  `epc_code_3` varchar(100) NOT NULL,
  `epc_name_3` varchar(100) NOT NULL,
  `epc_tip_3` varchar(100) NOT NULL,
  `epc_desc_3` varchar(100) NOT NULL,
  `epc_dur_3` int(11) NOT NULL,
  `epc_code_4` varchar(100) NOT NULL,
  `epc_name_4` varchar(100) NOT NULL,
  `epc_tip_4` varchar(100) NOT NULL,
  `epc_desc_4` varchar(100) NOT NULL,
  `epc_dur_4` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `label`
--

DROP TABLE IF EXISTS `label`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `label` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain_match` varchar(128) DEFAULT NULL,
  `domain_name` varchar(128) DEFAULT NULL,
  `site_title` varchar(128) DEFAULT NULL,
  `copyright_name` varchar(128) DEFAULT NULL,
  `logo_url` text DEFAULT NULL,
  `background_color` varchar(128) DEFAULT NULL,
  `text_color` varchar(128) DEFAULT NULL,
  `button_color` varchar(128) DEFAULT NULL,
  `line_color` varchar(128) DEFAULT NULL,
  `custom_css` text DEFAULT NULL,
  `meta_tags` text DEFAULT NULL,
  `sexuality` varchar(128) DEFAULT NULL,
  `custom_homepage` varchar(128) DEFAULT NULL,
  `custom_register_video_url` varchar(128) DEFAULT NULL,
  `custom_head_code` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `model_name` varchar(128) DEFAULT NULL,
  `gender` varchar(128) DEFAULT NULL,
  `place_of_birth` varchar(128) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `biopic_url` text DEFAULT NULL,
  `sexuality` varchar(128) DEFAULT NULL,
  `banner_url` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `mref`
--

DROP TABLE IF EXISTS `mref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mref` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `from_id` int(11) DEFAULT NULL,
  `new_mem_id` int(11) DEFAULT NULL,
  `stamp` varchar(28) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `msg`
--

DROP TABLE IF EXISTS `msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `msg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `msg` text DEFAULT NULL,
  `incoming_msg_id` int(11) DEFAULT NULL,
  `outgoing_msg_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pwd_reset`
--

DROP TABLE IF EXISTS `pwd_reset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pwd_reset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) DEFAULT NULL,
  `token` varchar(128) DEFAULT NULL,
  `expires` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sbdy`
--

DROP TABLE IF EXISTS `sbdy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sbdy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `body` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tag`
--

DROP TABLE IF EXISTS `tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tag` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=141 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `theme`
--

DROP TABLE IF EXISTS `theme`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `theme` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `light_mode` varchar(5) DEFAULT NULL,
  `custom_css` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5463834 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `trail`
--

DROP TABLE IF EXISTS `trail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `poster_url` text DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `label` varchar(128) DEFAULT NULL,
  `enabled` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ucomment`
--

DROP TABLE IF EXISTS `ucomment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ucomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) DEFAULT NULL,
  `vid_id` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ufav`
--

DROP TABLE IF EXISTS `ufav`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ufav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) DEFAULT NULL,
  `vid_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `urating`
--

DROP TABLE IF EXISTS `urating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `urating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) DEFAULT NULL,
  `vid_id` int(11) DEFAULT NULL,
  `rating` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usr`
--

DROP TABLE IF EXISTS `usr`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `password` text DEFAULT NULL,
  `signup_domain` varchar(128) DEFAULT NULL,
  `active` varchar(128) DEFAULT NULL,
  `urole` varchar(128) DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `banned` varchar(5) DEFAULT NULL,
  `profile_img` text DEFAULT NULL,
  `mobile` varchar(64) DEFAULT NULL,
  `last_login_ip` varchar(64) DEFAULT NULL,
  `last_login_country` varchar(64) DEFAULT NULL,
  `last_login_at` varchar(20) DEFAULT NULL,
  `first_name` varchar(64) DEFAULT NULL,
  `last_name` varchar(64) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `date_of_birth` varchar(64) DEFAULT NULL,
  `occupation` varchar(64) DEFAULT NULL,
  `phone` varchar(64) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `balance` decimal(10,2) DEFAULT 0.00,
  `wallet_balance` decimal(10,2) DEFAULT NULL,
  `created_date` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=114 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `usr_trans`
--

DROP TABLE IF EXISTS `usr_trans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usr_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tuser_id` int(11) DEFAULT NULL,
  `tdatetime` datetime DEFAULT NULL,
  `ttype` varchar(128) DEFAULT NULL,
  `tinfo` text DEFAULT NULL,
  `citem_id` int(11) DEFAULT NULL,
  `prov` varchar(128) DEFAULT NULL,
  `prov_json` text DEFAULT NULL,
  `tamount` decimal(10,2) DEFAULT NULL,
  `tref` varchar(64) DEFAULT NULL,
  `tstatus` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `video`
--

DROP TABLE IF EXISTS `video`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `seo_url` text DEFAULT NULL,
  `title` varchar(128) DEFAULT NULL,
  `category` varchar(128) DEFAULT NULL,
  `show_on_homepage` varchar(128) DEFAULT NULL,
  `poster_url` text DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `duration` varchar(128) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `created` int(11) DEFAULT NULL,
  `models` text DEFAULT NULL,
  `release_date` varchar(128) DEFAULT NULL,
  `casting_on` varchar(128) DEFAULT NULL,
  `quality` varchar(128) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `dislikes` int(11) DEFAULT NULL,
  `views` int(11) DEFAULT NULL,
  `publish_status` varchar(128) DEFAULT NULL,
  `process_status` varchar(128) DEFAULT NULL,
  `sexuality` varchar(128) DEFAULT NULL,
  `attributes` text DEFAULT NULL,
  `view_price` decimal(10,2) DEFAULT NULL,
  `image_gallery` text DEFAULT NULL,
  `trailer_url` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=550 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;


ALTER TABLE video DROP COLUMN `view_price`;
ALTER TABLE video ADD COLUMN `premium_member_view_price` decimal(10,2) DEFAULT NULL;
ALTER TABLE video ADD COLUMN `free_member_view_price` decimal(10,2) DEFAULT NULL;


CREATE TABLE `wal_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tuser_id` int(11) DEFAULT NULL,
  `tdatetime` datetime DEFAULT NULL,
  `ttype` varchar(128) DEFAULT NULL,
  `tinfo` text DEFAULT NULL,
  `pitem_id` int(11) DEFAULT NULL,  
  `pitem_type` varchar(64) DEFAULT NULL,
  `tamount` decimal(10,2) DEFAULT NULL,
  `tref` varchar(64) DEFAULT NULL,
  `tstatus` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
); 


/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-04-18 23:31:11
