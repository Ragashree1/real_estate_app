<?php
require_once "../entity/shortlist.php";

class BuyerViewShortlistedNewListingController
{
    private Shortlist $shortlist;

    public function __construct()
    {
        $this->shortlist = new Shortlist();
    }

    public function getShortlistedNewListings(string $buyer_username): array
    {
        $listings = $this->shortlist->getShortlistedNewListings($buyer_username);
        
        return $listings;
    }
}

?>