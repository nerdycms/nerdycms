/* OLD */
DROP TABLE em_template;

CREATE TABLE em_template (
    id INT AUTO_INCREMENT PRIMARY KEY,    
    body TEXT,
    email_subject VARCHAR(128)
);

DROP TABLE custom_menu_item;

CREATE TABLE custom_menu_item (
    id INT AUTO_INCREMENT PRIMARY KEY,    
    url TEXT,
    title VARCHAR(128)
);

DROP TABLE custom_page;

CREATE TABLE custom_page (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    syskey VARCHAR(128),
    hook TEXT,
    body TEXT
);

DROP TABLE theme;

CREATE TABLE theme (
    id INT AUTO_INCREMENT PRIMARY KEY,     
    light_mode VARCHAR(5),
    custom_css TEXT
);

DROP TABLE blog;

CREATE TABLE blog (
    id INT AUTO_INCREMENT PRIMARY KEY,        
    title VARCHAR(128),
    slug VARCHAR(128),
    body TEXT,
    member_id INT
);

DROP TABLE msg;

CREATE TABLE msg (
    id INT AUTO_INCREMENT PRIMARY KEY,            
    msg TEXT,
    incoming_msg_id INT,
    outgoing_msg_id INT
);

DROP TABLE mref;

CREATE TABLE mref (
    id INT AUTO_INCREMENT PRIMARY KEY,                
    from_id INT,
    new_mem_id INT,
    stamp VARCHAR(28)
);

DROP TABLE sbdy;

CREATE TABLE sbdy (
    id INT AUTO_INCREMENT PRIMARY KEY,                
    body TEXT
);

DROP TABLE trail;

CREATE TABLE trail (
    id INT AUTO_INCREMENT PRIMARY KEY,    
    poster_url TEXT,
    video_url TEXT,
    enabled VARCHAR(5),
    label VARCHAR(128)
);

DROP TABLE ann;

CREATE TABLE ann (
    id INT AUTO_INCREMENT PRIMARY KEY,     
    msg_id INT,
    target_id INT,
    been_read VARCHAR(5)
);

CREATE TABLE ann (
    id INT AUTO_INCREMENT PRIMARY KEY,     
    msg_id INT,
    target_id INT,
    been_read VARCHAR(5)
);

CREATE TABLE `ucomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usr_id` int(11) DEFAULT NULL,
  `vid_id` int(11) DEFAULT NULL,
  `comment` TEXT DEFAULT NULL,
  PRIMARY KEY (`id`)
);

ALTER TABLE usr ADD COLUMN last_login_ip VARCHAR(16);
ALTER TABLE usr ADD COLUMN last_login_country VARCHAR(64);
ALTER TABLE usr ADD COLUMN first_name VARCHAR(64);
ALTER TABLE usr ADD COLUMN last_name VARCHAR(64);
ALTER TABLE usr ADD COLUMN country VARCHAR(64);
ALTER TABLE usr ADD COLUMN date_of_birth VARCHAR(64);
ALTER TABLE usr ADD COLUMN occupation VARCHAR(64);
ALTER TABLE usr ADD COLUMN email VARCHAR(64);
ALTER TABLE usr ADD COLUMN mobile VARCHAR(64);
ALTER TABLE usr ADD COLUMN phone VARCHAR(64);
ALTER TABLE usr ADD COLUMN bio TEXT;

ALTER TABLE usr ADD COLUMN wallet_balance DECIMAL(10,2) DEFAULT 0;

ALTER TABLE video ADD COLUMN view_price DECIMAL(10,2);
ALTER TABLE video ADD COLUMN image_gallery TEXT;
ALTER TABLE video ADD COLUMN trailer_url TEXT;

ALTER TABLE model ADD COLUMN banner_url TEXT;

alter table citem add column wallet_value decimal(10,2);

alter table usr add column created_date varchar(32);

alter table usr_trans add column tamount decimal(10,2);
alter table usr_trans add column tref varchar(64);
alter table usr_trans add column tstatus varchar(64);
alter table em_template add column tpl_key varchar(64);

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
  `last_login_ip` varchar(16) DEFAULT NULL,
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
  `access` text,
  PRIMARY KEY (`id`)
);

alter table usr add column sso_token TEXT;