<?php
class Restaurant {
    private $name;
    private $address;
    private $summaryOpinion;
    private $numberOfOpinions;
    private $typesOfMeals;
    private $imageUrl;

    public function __construct($name, $address, $summaryOpinion, $numberOfOpinions, $typesOfMeals, $imageUrl) {
        $this->name = $name;
        $this->address = $address;
        $this->summaryOpinion = $summaryOpinion;
        $this->numberOfOpinions = $numberOfOpinions;
        $this->typesOfMeals = $typesOfMeals;
        $this->imageUrl = $imageUrl;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getSummaryOpinion() {
        return $this->summaryOpinion;
    }

    public function setSummaryOpinion($summaryOpinion) {
        $this->summaryOpinion = $summaryOpinion;
    }

    public function getNumberOfOpinions() {
        return $this->numberOfOpinions;
    }

    public function setNumberOfOpinions($numberOfOpinions) {
        $this->numberOfOpinions = $numberOfOpinions;
    }

    public function getTypesOfMeals() {
        return $this->typesOfMeals;
    }

    public function setTypesOfMeals($typesOfMeals) {
        $this->typesOfMeals = $typesOfMeals;
    }

    public function getImageUrl() {
        return $this->imageUrl;
    }

    public function setImageUrl($imageUrl) {
        $this->imageUrl = $imageUrl;
    }
}

?>