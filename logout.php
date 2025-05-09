<?php
session_start();
session_destroy();
define("ROOT",__DIR__);
chdir(ROOT);
include ROOT."/_ncms/config/config.php";
header('location: '.DOM.VDIR);