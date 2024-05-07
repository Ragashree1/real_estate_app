<?php 
require_once "../entity/propertyListing.php";

class AgentUpdateListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function agentUpdateListings(array $updateInfo, int $listing_id): bool
    {
        $updated = $this->propertyListing->agentUpdateListings($updateInfo, $listing_id);
        
        return $updated;
    }

    public function getListingToUpdate(int $listing_id): array
    {
        $listingToUpdate = $this->propertyListing->getSingleListing($listing_id);
        
        return $listingToUpdate;
    }
}

?>