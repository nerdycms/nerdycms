<?php

/* 
 * Author: Simon Newton
 * ...
 */

if(!isset($argv)) return;

define("VERSION","4");
define("ROOT",__DIR__."/../../..");

chdir(__DIR__);

if(!is_dir(ROOT."/content/migrate")) mkdir(ROOT."/content/migrate");
if(!is_dir(ROOT."/content/migrate/".VERSION)) mkdir(ROOT."/content/migrate/".VERSION);
if(!is_dir(ROOT."/content/migrate/".VERSION."/previous")) mkdir(ROOT."/content/migrate/".VERSION."/previous");

$ignore = [".","..","content"];
$files = scandir(ROOT);
foreach($files as $f) {
    if(in_array($f,$ignore)) continue;
    
    shell_exec("mv ".ROOT."/$f ".ROOT."/content/migrate/".VERSION."/previous/$f");
}

$files = scandir(ROOT."/content/migrate/".VERSION);
foreach($files as $f) {
    if(in_array($f,["release.zip","boot.php"])) continue;
    if(in_array($f,$ignore)) continue;

    shell_exec("cp -rf ".ROOT."/content/migrate/".VERSION."/$f ".ROOT."/$f");
}

$hta = "RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-d
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_URI} !-FI\..$ [NC]
RewriteRule ^(.+)$ index.php [PT,L,QSA]";

file_put_contents(ROOT."/.htaccess",$hta);
shell_exec("chown -R www-data:www-data ".ROOT);


$dbl = '{
    "name": "kunalvarma05/dropbox-php-sdk",
    "description": "Dropbox PHP API V2 SDK (Unofficial)",
    "keywords" : ["dropbox", "sdk", "api", "client", "php", "unofficial"],
    "license": "MIT",
    "authors": [
        {
            "name": "Kunal Varma",
            "email": "kunalvarma05@gmail.com"
        }
    ],
    "require": {
        "guzzlehttp/guzzle": "*",
        "illuminate/collections": "*"
    },
    "autoload": {
        "psr-4": {
            "Kunnu\\\\\\\\Dropbox\\\\\\\\": "src/Dropbox"
        }
    }
}';

$args['ipath'] = ROOT;

//shell_exec("mv $args[ipath]/vendor/dropbox $args[ipath]/vendor/old-dropbox >> /root/cms-inst.log");
shell_exec("cd $args[ipath]; composer -n require kunalvarma05/dropbox-php-sdk");
shell_exec("mv $args[ipath]/vendor/kunalvarma05/dropbox-php-sdk $args[ipath]/vendor/dropbox >> /root/cms-upgrade.log");
shell_exec("echo '$dbl' > $args[ipath]/vendor/dropbox/composer.json");
shell_exec("cd $args[ipath]/vendor/dropbox; composer -n install >> /root/cms-upgrade.log");



