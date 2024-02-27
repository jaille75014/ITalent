<?php 
session_start();
include('includes/bd.php');

$rand_verification_email = rand(100000, 999999);
echo $rand_verification_email;

?>