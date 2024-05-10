<?php 

class SellerSearchListedPropertyController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function searchListedProperty(array $searchInfo): array
    {
        $searchResults = $this->propertyListing->sellerSearchListedProperties($searchInfo);

        return $searchResults;
    }
}

?>