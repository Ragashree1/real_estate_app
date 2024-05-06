<?php 

class SearchListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function searchListings(array $searchInfo): array
    {
        $searchResults = $this->propertyListing->searchListings($searchInfo);

        return $searchResults;
    }
}

?>