<?php
require_once "../entity/propertyListing.php";

class AgentViewCreatedListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function agentGetCreatedListings(string $agent_username): array
    {
        $allListings = $this->propertyListing->agentGetCreatedListing($agent_username);

        return $allListings;
    }
}


?>