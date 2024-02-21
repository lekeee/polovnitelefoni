<?php
include_once(__DIR__ . '/../exceptions/adExceptions.php');

abstract class Ad
{
    protected $con;
    protected $user_id, $brand, $model, $title, $state, $description, $images, $stateRange;
    protected $price, $new_price, $views, $availability, $damage;

    public function __construct($user_id = null, $brand = null, $model = null, $title = null, $state = null, $stateRange = null, $description = null, $images = null, $price = null, $new_price = null, $views = null, $availability = null, $damage = null)
    {
        global $con;
        $this->con = $con;

        $this->user_id = $user_id;
        $this->brand = $brand;
        $this->model = $model;
        $this->title = $title;
        $this->state = $state;
        $this->stateRange = $stateRange;
        $this->description = $description;
        $this->images = $images;
        $this->price = $price;
        $this->new_price = $new_price;
        $this->views = $views;
        $this->availability = $availability;
        $this->damage = $damage;
    }

    abstract public function create($user_id, $brand, $model, $title, $state, $stateRange, $description, $price, $images, $availability, $damage, $accessories);
    abstract public function saveImages($uploadDirectory, $imageSrcArray);
    abstract public function select24();

    abstract public function read($user_id);
    abstract public function checkVisit($ip, $ad_id);
    abstract public function addVisit($ip, $ad_id);
    abstract public function totalVisits($ad_id);
    abstract public function countSaves($ad_id);
    abstract public function save($user_id, $ad_id);
    abstract public function deleteSave($user_id, $ad_id);
    abstract public function filter($sort = null, $brands = null, $models = null, $minPrice = null, $maxPrice = null, $new = false, $used = false, $damaged = false, $offset = 0, $limit = 24);
    abstract public function mostViewedAd();
    abstract public function mostSavedAd();
    abstract public function newestAd();
    abstract public function deleteAd($ad_id);
    abstract public function deleteAdfromSaves($ad_id);
    abstract public function deleteAdfromVisit($ad_id);

    abstract public function countAllAds();
    abstract public function countAllFilteredAds($sort = null, $brands = null, $models = null, $minPrice = null, $maxPrice = null, $new = false, $used = false, $damaged = false, $offset = 0, $limit = 24);
    abstract public function updateAd($ad_id, $brand, $model, $title, $state, $stateRange, $description, $price, $images, $availability, $damage, $accessories);
    abstract public function getAdFolder($ad_id);
    abstract public function getDeviceImage($brandName, $modelName);
    abstract public function deleteImagesFromFolder($folder);
    abstract public function deleteImagesFolder($ad_id);
}