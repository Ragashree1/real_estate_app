<?php
require_once "../entity/propertyListing.php";

class ViewNewListingController
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
}

?>