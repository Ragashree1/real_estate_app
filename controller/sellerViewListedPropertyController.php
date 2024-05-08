<?php
require_once "../entity/propertyListing.php";

class SellerViewListedPropertyController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function sellerGetListedProperties(string $seller_username): array
    {
        $allListings = $this->propertyListing->sellerGetListedProperties($seller_username);

        return $allListings;
    }
}


?>