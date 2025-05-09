<?php
define("ROOT",__DIR__);
chdir(ROOT);

include ROOT."/content/system/config.php";

session_destroy();
header('location: '.DOM.VDIR."admin");  