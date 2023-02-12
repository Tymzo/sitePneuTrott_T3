<?php


namespace App;

include './php/constant.php';

class paypalPaiement
{
  public function ui($montant): string
  {
    $clientId  = PAYPAL_ID;
    $total = $montant;
    return <<<HTML
        <script src="https://www.paypal.com/sdk/js?client-id={$clientId}&currency=CHF"></script>
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>
    <script>
      paypal.Buttons({
        // Sets up the transaction when a payment button is clicked
        createOrder: (data, actions) => {
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: {$total} // Can also reference a variable or function
              }
            }]
          });
        },
        // Finalize the transaction after payer approval
        onApprove: (data, actions) => {
          actions.redirect('remerciment.php');
          return actions.order.capture().then(function(orderData) {
            // Successful capture! For dev/demo purposes:
            document.location.href = "https://esig-sandbox.ch/t23_3_v21/sitePneuTrott/remerciement.php";
        });
        }
        
      }).render('#paypal-button-container');
    </script>
    HTML;
  }
}