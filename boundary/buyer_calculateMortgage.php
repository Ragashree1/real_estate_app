<div class="modal fade" id="modalCalculator" tabindex="-1" role="dialog" aria-labelledby="modalCalculator" aria-hidden="true">
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
                        <input type="number" class="form-control" id="price" name="price" required min="1">
                    </div>
                    <br><br>

                    <label for="years">Number of Years :</label>
                    <input type="number" class="form-control" id="years" name="years" required min="1">
                    <br><br>

                    <label for="percentage">Percentage :</label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="percentage" name="percentage" required min="0">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <br><br>
                </div>
                <!-- Form fields -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Monthly Payment</h5>
                        <h3 class="card-text" id="monthlyPayment">Amount: $0.00</h3> <!-- Display initial value -->
                    </div>
                </div>
                <div id="result" class="mt-3"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="calculateMortgage()">Calculate Installment</button> <!-- Call JavaScript function -->
            </div>
        </div>
    </div>
</div>

<script>
    function calculateMortgage() {
        // Get input values
        var price = parseFloat(document.getElementById('price').value);
        var years = parseFloat(document.getElementById('years').value);
        var percentage = parseFloat(document.getElementById('percentage').value);

        // Convert percentage to decimal and monthly interest rate
        var interest = (percentage / 100) / 12;
        var numPayments = years * 12;

        // Calculate monthly payment using the formula
        var monthlyPayment = (price * interest) / (1 - Math.pow(1 + interest, -numPayments));

        // Round the result to two decimal places
        monthlyPayment = Math.round(monthlyPayment * 100) / 100;

        if(monthlyPayment < 0)
        {
            monthlyPayment = 0;
            alert("price or years or percentage cannot be less than 0");
        }

        // Update the result
        document.getElementById('monthlyPayment').innerText = 'Amount: $' + monthlyPayment.toFixed(2);
        document.getElementById('resultContainer').style.display = 'block';
    }

</script>
