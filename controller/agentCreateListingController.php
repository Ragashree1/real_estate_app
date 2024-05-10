<?php 
require_once "../entity/propertyListing.php";

class AgentCreateListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function agentCreateListings(array $createInfo): bool
    {
        $created = $this->propertyListing->agentCreateListings($createInfo);
        
        return $created;
    }
}

?>