<?php
require_once "../entity/propertyListing.php";

class sellerTrackNumShortlistController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function getNumShortlist(int $listing_id): int
    {
        $numShortlist = $this->propertyListing->getNumShortlist($listing_id);

        return $numShortlist;
    }

}

?>