<?php
class CalculateMortgageController
{
    public function calculate($price, $years, $percentage) : float
    {
        $interest = $percentage / 100 / 12;
        $num_payments = $years * 12;

        $monthlyPayment = ($price * $interest) / (1 - pow(1 + $interest, -$num_payments));

        // Render the view with the result
        return $monthlyPayment;    
    }
}
?>