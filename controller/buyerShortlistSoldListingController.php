<?php
require_once "../entity/shortlist.php";

class BuyerShortlistSoldListingController
{
    private Shortlist $shortlist;

    public function __construct()
    {
        $this->shortlist = new Shortlist();
    }

    public function shortlist(string $buyer_username, int $listing_id): bool
    {
        $shortlisted = $this->shortlist->shortlist($buyer_username, $listing_id);

        return $shortlisted;
    }

    public function isShortListed(string $buyer_username, int $listing_id): bool
    {
        $shortlisted = $this->shortlist->isShortListed($buyer_username, $listing_id);

        return $shortlisted;
    }
}

?>