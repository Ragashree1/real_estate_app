<?php
require_once "../entity/propertyListing.php";

class BuyerViewSingleSoldListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function getSingleListing(int $listing_id): array
    {
        $listing = $this->propertyListing->getSingleListing($listing_id);

        return $listing;
    }
}

?>