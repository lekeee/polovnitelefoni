<?php

abstract class Ad{
    protected $con;
    protected $user_id, $brand, $model, $title, $state, $description, $images;
    protected $price, $new_price, $views, $availability, $damage;

    public function __construct($user_id = null, $brand = null, $model = null, $title = null, $state = null, $description = null, $images = null, $price = null, $new_price = null, $views = null, $availability = null, $damage = null){
        global $con;
        $this->con = $con;
    
        $this->user_id = $user_id;
        $this->brand = $brand;
        $this->model = $model;
        $this->title = $title;
        $this->state = $state;
        $this->description = $description;
        $this->images = $images;
        $this->price = $price;
        $this->new_price = $new_price;
        $this->views = $views;
        $this->availability = $availability;
        $this->damage = $damage;
    }
    
    abstract public function create($user_id, $brand, $model, $title, $state, $description, $price, $new_price, $images, $availability, $damage, $accessories);
    abstract public function select24();
    abstract public function read($user_id);
    abstract public function rating();

}
