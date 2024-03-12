<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require "app/config/config.php";
require "app/classes/Phone.php";
require "app/classes/User.php";
require "app/classes/Support.php";

$phone = new Phone();
$user = new User();
$support = new Support();
