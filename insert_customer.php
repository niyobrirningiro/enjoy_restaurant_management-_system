<?php
// insert_customer.php
// Database configuration
$host = 'localhost';
$dbname = 'restaurant_db';
$username = 'root'; // Change to your database username
$password = ''; // Change to your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Get form data
$first_name = $_POST['first_name'] ?? '';
$last_name = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$address = $_POST['address'] ?? '';
$password = $_POST['password'] ?? '';

// Validate required fields
if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
    die("Required fields are missing");
}

// Hash password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    // Check if email already exists
    $check_stmt = $pdo->prepare("SELECT customer_id FROM customers WHERE email = ?");
    $check_stmt->execute([$email]);
    
    if ($check_stmt->fetch()) {
        die("Email already exists. Please use a different email.");
    }

    // Insert new customer
    $stmt = $pdo->prepare("
        INSERT INTO customers (first_name, last_name, email, phone, address, loyalty_points, total_orders, total_spent, password) 
        VALUES (?, ?, ?, ?, ?, 0, 0, 0.00, ?)
    ");
    
    $stmt->execute([$first_name, $last_name, $email, $phone, $address, $hashed_password]);
    
    // Get the new customer ID
    $customer_id = $pdo->lastInsertId();
    
    // Start session and set customer data
    session_start();
    $_SESSION['customer_id'] = $customer_id;
    $_SESSION['customer_name'] = $first_name . ' ' . $last_name;
    $_SESSION['customer_email'] = $email;

    // Redirect to customer dashboard
    header("Location:index.php");
    exit();
    
} catch(PDOException $e) {
    die("Error creating account: " . $e->getMessage());
}
?>