<?php

$rurl = base64_decode($_GET['bed']);
//$rurl = str_replace("dev.aquete.com","45.76.233.39:8443",$rurl);
$resp = file_get_contents($rurl);
echo json_decode($resp);

