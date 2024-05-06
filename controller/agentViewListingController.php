<?php
require_once "../entity/propertyListing.php";

class agentViewListingController
{
    private PropertyListing $propertyListing;

    public function __construct()
    {
        $this->propertyListing = new PropertyListing();
    }

    public function getCreatedListings(string $agent_username): array
    {
        $allListings = $this->propertyListing->agentGetCreatedListing($agent_username);

        return $allListings;
    }

    public function getSingleListing(int $listing_id): array
    {
        $allListings = $this->propertyListing->getSingleListing($listing_id);

        return $allListings;
    }

    public function getSellerInfo(int $listing_id): array
    {
        $sellerInfo = $this->propertyListing->getSellerInfo($listing_id);

        return $sellerInfo;
    }

}


?>