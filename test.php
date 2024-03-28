<?php
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// require "app/config/config.php";
// require "app/classes/Phone.php";
// require "app/classes/User.php";
// require "app/classes/Support.php";
// require "app/classes/Messages.php";

// $phone = new Phone();
// $user = new User();
// $support = new Support();
// $message = new Messages();

// $memcache_obj = new Memcache;
// Učitavanje Composer autoload datoteke
require_once 'vendor/autoload.php';

use Symfony\Component\Cache\Adapter\FilesystemAdapter;


$cache = new FilesystemAdapter();
$cacheItem = $cache->getItem('novi_podaci');
$cachedValue = $cacheItem->get();

if ($cachedValue !== null) {
    echo "Keširan podatak: $cachedValue";
} else {
    $cacheItem->set('vrednost')->expiresAfter(3600);
    $cache->save($cacheItem);
    echo "Podaci nisu dostupni u kešu.";
}
