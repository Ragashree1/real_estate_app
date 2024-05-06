<?php
require_once "../entity/propertyListing.php";

class agentViewListingController
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

    public function agentGetSingleListing(int $listing_id): array
    {
        $allListings = $this->propertyListing->agentGetSingleListing($listing_id);

        return $allListings;
    }
}


?>