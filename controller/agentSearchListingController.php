<?php 
require_once "../entity/propertyListing.php";

class AgentSearchListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function agentSearchListings(array $searchInfo): array
    {
        $searchResults = $this->propertyListing->agentSearchListings($searchInfo);

        return $searchResults;
    }
}

?>