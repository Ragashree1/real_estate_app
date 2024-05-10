<?php 

class BuyerSearchSoldListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function searchSoldListings(array $searchInfo): array
    {
        $searchResults = $this->propertyListing->searchSoldListings($searchInfo);

        return $searchResults;
    }
}

?>