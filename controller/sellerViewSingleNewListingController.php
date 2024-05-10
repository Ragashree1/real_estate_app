<?php
require_once "../entity/propertyListing.php";

class SellerViewSingleNewListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function getSingleNewListing(int $listing_id): array
    {
        $listing = $this->propertyListing->getSingleListing($listing_id);

        return $listing;
    }
}

?>