<?php

namespace App\Class;

class Product {
    public $id;
    public $name;
    public $type;
    public $photo;
    public $referenceCode;
    public $createdAt;
    public $updatedAt;

    public function __construct($product) {
        $this->id               = $product['id'] ?? '';
        $this->name             = $product['name'] ?? '';
        $this->type             = $product['type'] ?? '';
        $this->photo            = $product['photo'] ?? '';
        $this->referenceCode    = $product['referenceCode'] ?? '';
        $this->createdAt        = $product['createdAt'] ?? '';
        $this->updatedAt        = $product['updatedAt'] ?? '';
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;
    }

    public function getReferenceCode() {
        return $this->referenceCode;
    }

    public function setReferenceCode($referenceCode) {
        $this->referenceCode = $referenceCode;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }
}