<?php
class Restaurant implements JsonSerializable
{
    private $id;
    private $name;
    private $address;
    private $averageRating;
    private $numberOfReviews;
    private $cuisineTypes;
    private $imageUrl;
    public $city;

    public function __construct($id, $name, $address, $averageRating, $numberOfReviews, $cuisineTypes, $imageUrl, $city)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->averageRating = $averageRating;
        $this->numberOfReviews = $numberOfReviews;
        $this->cuisineTypes = $cuisineTypes;
        $this->imageUrl = $imageUrl;
        $this->city = $city;
    }
    public function getId()
    {
        return $this->id;
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
    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'average_rating' => $this->averageRating,
            'number_of_reviews' => $this->numberOfReviews,
            'cuisine' => $this->cuisineTypes,
            'image_path' => $this->imageUrl,
            'city' => $this->city,
        ];
    }
}
