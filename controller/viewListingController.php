<?php
require_once "../entity/propertyListing.php";

class ViewListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function getNewListing(): array
    {
        $allListings = $this->propertyListing->getNewListing();

        return $allListings;
    }

    public function getSingleListing(int $listing_id): array
    {
        $allListings = $this->propertyListing->getSingleListing($listing_id);

        return $allListings;
    }
}

?>