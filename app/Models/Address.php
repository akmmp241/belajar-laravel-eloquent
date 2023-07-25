<?php

namespace App\Models;

class Address
{
    public string $street;
    public string $city;
    public string $country;
    public string $post_code;

    public function __construct(string $street, string $city, string $country, string $postcode)
    {
        $this->street = $street;
        $this->city = $city;
        $this->country = $country;
        $this->post_code = $postcode;
    }


}
