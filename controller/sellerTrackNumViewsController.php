<?php
require_once "../entity/propertyListing.php";

class sellerTrackNumViewsController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function getNumViews(int $listing_id): int
    {
        $numViews = $this->propertyListing->getNumViews($listing_id);

        return $numViews;
    }

}

?>