<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 



?>

<!-- search bar -->
<div class="container-fluid mt-3">
    <form class="form-inline" method="GET" action="search.php" style="background-color: grey; padding: 10px; border-radius: 5px; width: 90vw;">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search" style="width: 25%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Price" name="min_price" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Max Price" name="max_price" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="Min Area" name="min_area" style="width: 15%;">
        <input class="form-control mr-sm-2" type="number" placeholder="bedroom+hall+kitchen num" name="bhk" style="width: 20;">
        <button class="btn btn-success my-2 my-sm-0" type="submit" style="width: 10%;">Search</button>
    </form>
</div>


<?php require_once "partials/footer.php"; ?>