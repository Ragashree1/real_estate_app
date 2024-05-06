<?php
class CalculateMortgageController
{
    public function calculate($price, $years, $percentage) 
    {
        // Convert percentage to decimal and monthly interest rate
        $interest = ($percentage / 100) / 12;
        $num_payments = $years * 12;

        // Calculate monthly payment using the formula
        $monthlyPayment = ($price * $interest) / (1 - pow(1 + $interest, -$num_payments));

        // Round the result to two decimal places
        $monthlyPayment = round($monthlyPayment, 2);

        // Return the calculated monthly payment
        return $monthlyPayment;
    }
}



?>