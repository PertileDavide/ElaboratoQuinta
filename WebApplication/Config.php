<?php
    require_once('stripe-php-master/init.php');
    $publishableKey="pk_test_51IpabbAYTdDBH5ayhAmnOVszpnp2X7HCsWfQxLF55lBTDhQhKSVT1hKoPF1Uimy5kgsetWQ3J7fJQajL8lPM52Mv00549txcWk";
    $secretKey="sk_test_51IpabbAYTdDBH5ayWRkKAdADNcwceP3VbvazQrPoR7Wst8apJsu7ALXyVRzEosVUDU2F9s0qdnOWZ56WvIi2j9Ge00gjzOIt3w";
    \Stripe\Stripe::setApiKey($secretKey);
?>