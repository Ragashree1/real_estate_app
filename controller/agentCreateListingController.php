<?php 
require_once "../entity/propertyListing.php";

class AgentCreateListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function agentCreateListings(array $createInfo): array
    {
        $errors = $this->propertyListing->agentCreateListings($createInfo);
        
        return $errors;
    }
}

?>