<?php
require_once "../entity/propertyListing.php";

class BuyerViewSoldListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function getSoldListing(): array
    {
        $allListings = $this->propertyListing->getSoldListing();

        return $allListings;
    }
}

?>