<?php 

class SearchNewListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function searchNewListings(array $searchInfo): array
    {
        $searchResults = $this->propertyListing->searchNewListings($searchInfo);

        return $searchResults;
    }
}

?>