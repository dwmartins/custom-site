<?php 

namespace App\Class;

use App\Models\SiteInfoDAO;

class SiteInfo {
    public $id;
    public $webSiteName;
    public $email;
    public $phone;
    public $city;
    public $state;
    public $address;
    public $workSchedule;
    public $instagram;
    public $facebook;
    public $createdAt;
    public $updatedAt;

    public function __construct($siteInfo) {
        $this->id           = $siteInfo['id'] ?? '';
        $this->webSiteName  = $siteInfo['webSiteName'] ?? '';
        $this->email        = $siteInfo['email'] ?? '';
        $this->phone        = $siteInfo['phone'] ?? '';
        $this->city         = $siteInfo['city'] ?? '';
        $this->state        = $siteInfo['state'] ?? '';
        $this->address      = $siteInfo['address'] ?? '';
        $this->workSchedule = $siteInfo['workSchedule'] ?? '';
        $this->instagram    = $siteInfo['instagram'] ?? '';
        $this->facebook     = $siteInfo['facebook'] ?? '';
        $this->createdAt    = $product['createdAt'] ?? '';
        $this->updatedAt    = $product['updatedAt'] ?? '';
    }

    public function getId() {
        return $this->id;
    }

    public function getWebSiteName() {
        return $this->webSiteName;
    }

    public function setWebSiteName($webSiteName) {
        $this->webSiteName = $webSiteName;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getWorkSchedule() {
        return $this->workSchedule;
    }

    public function setWorkSchedule($schedule) {
        $this->workSchedule = $schedule;
    }

    public function getInstagram() {
        return $this->instagram;
    }

    public function setInstagram($instagram) {
        $this->instagram = $instagram;
    }

    public function getFacebook() {
        return $this->facebook;
    }

    public function setFacebook($facebook) {
        $this->facebook = $facebook;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function save() {
        SiteInfoDAO::save($this);
    }
}