

<?php
require_once "partials/header.php"; 
require_once "partials/hero.php"; 
require_once "../controller/calculateMortgageController.php";

$cmController = new CalculateMortgageController();
// Assuming you're using POST method to pass parameters
$price = $_POST['price'] ?? null; // Set default value if not provided
$years = $_POST['years'] ?? null; // Set default value if not provided
$percentage = $_POST['percentage'] ?? null; // Set default value if not provided

// Calculate the result if all inputs are provided
$result = 0; // Default value for the result
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
            <button type="button" class="btn btn-primary" onclick="calculateInstallment()">Calculate Installment</button>
        </div>
    </div>
    <!-- Form fields -->
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title">Monthly Payment</h5>
            <h3 class="card-text" id="monthlyPayment">Amount: $<?php echo $result; ?></h3>
        </div>
    </div>
    <div id="result" class="mt-3"></div>
</div>

        </div>
    </div>
</div>

<script>
function calculateInstallment() {
    // Gather input values
    var price = document.getElementById('price').value;
    var years = document.getElementById('years').value;
    var percentage = document.getElementById('percentage').value;

    // Send AJAX request to backend
    fetch('../controller/calculateMortgageController.php', {
        method: 'POST', // Make sure it's a POST request
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'price=' + price + '&years=' + years + '&percentage=' + percentage
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.text();
    })
    .then(data => {
        // Update result in HTML
        document.getElementById('monthlyPayment').textContent = 'Amount: $' + data;
    })
    .catch(error => {
        // Handle error
        console.error('Error:', error);
    });
}
</script>

<?php
require_once "partials/footer.php";
?>


<!--

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
                        <div class=" form-group">
                            <label for="price">Price :</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" class="form-control" id="price" name="price" required min="1">
                            </div>
                            <br><br>

                            <label for="years">Number of Years :</label>
                            <input type="number" class="form-control" id="years" name="years" required min="1">
                            <br><br>

                            <label for="percentage">Percentage :</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="percentage" name="percentage" required min="1">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            <br><br>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" onclick="calculateInstallment()">Calculate Installment</button>
                            </div>
                        </div>
         Form fields 
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Monthly Payment</h5>
                <h3 class="card-text" id="monthlyPayment">Amount: $0.00</h3>
            </div>
                    </div>
                    <div id="result" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>


<script>
function calculateInstallment() {
    // Gather input values
    var price = document.getElementById('price').value;
    var years = document.getElementById('years').value;
    var percentage = document.getElementById('percentage').value;

}
</script>

    // Send AJAX request to backend
    fetch('/calculate-mortgage', {
        method: 'POST', // Make sure it's a POST request
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ price: price, years: years, percentage: percentage })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        // Update result in HTML
        document.getElementById('monthlyPayment').innerText = '$' + data.monthlyPayment.toFixed(2);
    })
    .catch(error => {
        // Handle error
        console.error('Error:', error);
    });

-->