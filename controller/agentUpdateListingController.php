<?php 
require_once "../entity/propertyListing.php";

class AgentUpdateListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function agentUpdateListings(array $createInfo, int $listing_id): array
    {
        $errors = $this->propertyListing->agentUpdateListings($createInfo, $listing_id);
        
        return $errors;
    }

    public function getListingToUpdate(int $listing_id): array
    {
        $listingToUpdate = $this->propertyListing->getSingleListing($listing_id);
        
        return $listingToUpdate;
    }
}

?>