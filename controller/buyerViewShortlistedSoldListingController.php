<?php
require_once "../entity/shortlist.php";

class BuyerViewShortlistedSoldListingController
{
    private Shortlist $shortlist;

    public function __construct()
    {
        $this->shortlist = new Shortlist();
    }

    public function getShortlistedSoldListings(string $buyer_username): array
    {
        $listings= $this->shortlist->getShortlistedSoldListings($buyer_username);
        
        return $listings;
    }
}

?>