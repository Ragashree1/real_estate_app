<?php 
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/calculateMortgageController.php";

$cmController = new CalculateMortgageController();
// Assuming you're using POST method to pass parameters
$price = $_POST['price'] ?? null; // Set default value if not provided
$years = $_POST['years'] ?? null; // Set default value if not provided
$percentage = $_POST['percentage'] ?? null; // Set default value if not provided

// Call the PHP controller function with the input values
$result = null; // Default value for the result
if ($price > 0 && $years > 0 && $percentage > 0) {
    $result = $cmController->calculate($price, $years, $percentage);
}
?>

<!-- Modal -->
<div class="modal fade" id="modalCalculator" tabindex="-1" role="dialog" aria-labelledby="modalCalculator"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCalculatorTitle">Calculate Mortgage</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id='mortgageForm'>
                <form id="mortgageForm" method="post"> <!-- Added method="post" -->
                    <div class="form-group">
                        <label for="price">Price :</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" class="form-control" id="price" name="price" required min="1" value="<?php echo $price; ?>">
                        </div>
                        <br><br>

                        <label for="years">Number of Years :</label>
                        <input type="number" class="form-control" id="years" name="years" required min="1" value="<?php echo $years; ?>">
                        <br><br>

                        <label for="percentage">Percentage :</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="percentage" name="percentage" required min="1" value="<?php echo $percentage; ?>">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <br><br>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Calculate Installment</button> <!-- Changed type to "submit" -->
                        </div>
                    </div>
                </form>
                <!-- Form fields -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Monthly Payment</h5>
                        <h3 class="card-text" id="monthlyPayment">Amount: $<?php echo $result; ?></h3> <!-- Display result here -->
                    </div>
                </div>
                <div id="result" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>
<?php
require_once "partials/footer.php";
?>
