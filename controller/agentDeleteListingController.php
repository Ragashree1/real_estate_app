<?php 
require_once "../entity/propertyListing.php";

class AgentDeleteListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function agentDeleteListings(int $listing_id): bool
    {
        $deleted = $this->propertyListing->agentDeleteListings($listing_id);
        
        return $deleted;
    }
}

?>