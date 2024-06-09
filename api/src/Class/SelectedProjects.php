<?php

namespace App\Class;

use App\Models\SelectedProjectsDAO;

class SelectedProjects {
    public $id;
    public $product_Id;
    public $position;
    public $createdAt;
    public $updatedAt;

    public function __construct($product) {
        $this->id               = $product['id'] ?? '';
        $this->product_Id       = $product['product_Id'] ?? '';
        $this->position         = $product['position'] ?? '';
        $this->createdAt        = $product['createdAt'] ?? '';
        $this->updatedAt        = $product['updatedAt'] ?? '';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getProductId() {
        return $this->product_Id;
    }

    public function setProductId($product_Id) {
        $this->product_Id = $product_Id;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($order) {
        $this->position = $order;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function save() {
        return SelectedProjectsDAO::save($this);
    }

}