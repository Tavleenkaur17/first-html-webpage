<?php
// LESSON 4: Hidden field + redirecting the user
// Open this page as:  index.php?product=Smart Watch
//
// This file does the WORK (PHP only).
// view.php shows the PAGE (HTML only).

$shopName = "ShopEase";
$products = ["Wireless Headphones", "Smart Watch", "Running Shoes"];
$errors   = [];

// NEW: which product is the customer asking about?
//      First visit (GET):      it comes from the URL      ->  index.php?product=Smart Watch
//      After pressing Send (POST): it comes ONLY from the hidden field in the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product = $_POST['product'] ?? '';
} else {
    $product = $_GET['product'] ?? '';
}

// NEW: a hidden field can be changed by the user, so check it is a real product
if (!in_array($product, $products, true)) {
    $product = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $errors[] = "Please enter your name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if ($message === '') {
        $errors[] = "Please write a message.";
    }

    // NEW: no mistakes -> send the browser to the thank-you page
    if (count($errors) === 0) {
        header('Location: thanks.php?name=' . urlencode($name) . '&product=' . urlencode($product));
        exit;   // stop here: nothing else must run after a redirect
    }
}

require 'view.php';
