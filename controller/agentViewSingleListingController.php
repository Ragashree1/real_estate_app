<?php
require_once "../entity/propertyListing.php";

class agentViewSingleListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function agentGetSingleListing(int $listing_id): array
    {
        $allListings = $this->propertyListing->agentGetSingleListing($listing_id);

        return $allListings;
    }
}


?>