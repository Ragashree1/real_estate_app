<?php
require_once "../entity/propertyListing.php";

class SellerViewSingleListedPropertyController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function getSingleListedProperty(int $listing_id): array
    {
        $listing = $this->propertyListing->getSingleListing($listing_id);

        return $listing;
    }
}

?>