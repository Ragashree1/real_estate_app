<?php
require_once "../entity/shortlist.php";

class BuyerRemoveShortlistNewListingController
{
    private Shortlist $shortlist;

    public function __construct()
    {
        $this->shortlist = new Shortlist();
    }

    public function removeShortlist(string $buyer_username, int $listing_id)
    {
        $this->shortlist->removeShortlist($buyer_username, $listing_id);
    }
}

?>