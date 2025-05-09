<?php
session_start();

define("UPDATE_DOMAIN","https://nerdycms.com/tengine");

//WEB USER NEED WRITE PERMISSION ON CONTENT FOLDERS
define("BULK_UPLOAD_DIR",ROOT."/upload");
define("DROP_IMPORT_DIR",ROOT."/dropbox");
define("COM_CONTENT_DIR",ROOT."/content/common");
define("SYS_CONTENT_DIR",ROOT."/content/system");
define("DATA_CONTENT_DIR",ROOT."/content/data");
define("MEM_CONTENT_DIR",ROOT."/content/usr");

define("THEME_DIR",ROOT."/themes");
define("RESOURCE_DIR",ROOT."/resources");

define("BRAND_NAME","DevCMS");
define("PAGE_TITLE_POST","DevCMS");
define("VDIR","/");
define("NERDY_LINK",true);
define('DEV_ERRLVL',E_ALL ^ E_DEPRECATED);
define("VID_THREADS","1");
define("VID_PRESET","ultrafast");
define("SLIDE_THREADS","1");

