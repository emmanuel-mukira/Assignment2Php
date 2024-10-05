<?php
date_default_timezone_set("AFRICA/Nairobi");

if (!defined('DBTYPE')) {
    define('DBTYPE', 'PDO');
}
if (!defined('HOSTNAME')) {
    define('HOSTNAME', 'localhost');
}
if (!defined('DBPORT')) {
    define('DBPORT', '3306');
}
if (!defined('HOSTUSER')) {
    define('HOSTUSER', 'root');
}
if (!defined('HOSTPASS')) {
    define('HOSTPASS', 'shigi460');
}
if (!defined('DBNAME')) {
    define('DBNAME', 'users');
}

$protocol = isset($_SERVER['HTTPS']) && 
$_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
$base_url = $protocol . $_SERVER['HTTP_HOST'] . '/';

$conf = []; // Initialize the $conf array

$conf['ver_code_time'] = date("Y-m-d H:i:s", strtotime("+ 1 days"));
$conf['verification_code'] = rand(10000,99999);
$conf['site_initials'] = "ICS 2024";
$conf['site_url'] = "$base_url/". DBNAME;

// Define the valid domains
$conf['valid_domains'] = ["strathmore.edu", "gmail.com", "yahoo.com", "mada.co.ke", "outlook.com"];
