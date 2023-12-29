<?php
class Restaurant
{
    private $name;
    private $address;
    private $averageRating;
    private $numberOfReviews;
    private $cuisineTypes;
    private $imageUrl;
    public $city;

    public function __construct($name, $address, $averageRating, $numberOfReviews, $cuisineTypes, $imageUrl, $city)
    {
        $this->name = $name;
        $this->address = $address;
        $this->averageRating = $averageRating;
        $this->numberOfReviews = $numberOfReviews;
        $this->cuisineTypes = $cuisineTypes;
        $this->imageUrl = $imageUrl;
        $this->city = $city;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getAverageRating()
    {
        return $this->averageRating;
    }

    public function getNumberOfReviews()
    {
        return $this->numberOfReviews;
    }

    public function getCuisineTypes()
    {
        return $this->cuisineTypes;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    // Setters
    public function setName($name)
    {
        $this->name = $name;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function setAverageRating($averageRating)
    {
        $this->averageRating = $averageRating;
    }

    public function setNumberOfReviews($numberOfReviews)
    {
        $this->numberOfReviews = $numberOfReviews;
    }

    public function setCuisineTypes($cuisineTypes)
    {
        $this->cuisineTypes = $cuisineTypes;
    }

    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }
    public function getCity()
    {
        return $this->city;
    }
}
