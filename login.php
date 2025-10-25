<?php
// Set headers for JSON response FIRST
header('Content-Type: application/json');

// Start session at the very beginning
session_start();

include 'connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['login_email']);
    $password = $_POST['login_password'];
    
    // Debug output
    error_log("Login attempt for: " . $email);
    
    // Find user by email
    $stmt = $conn->prepare("SELECT customer_id, first_name, last_name, email, Password FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Check if password is hashed (length 60 for bcrypt)
        if (strlen($user['Password']) === 60) {
            // Password is properly hashed, use password_verify
            if (password_verify($password, $user['Password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['customer_id'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_first_name'] = $user['first_name'];
                $_SESSION['user_last_name'] = $user['last_name'];
                
                echo json_encode([
                    "success" => true, 
                    "message" => "Login successful!",
                    "redirect" => "customer_dashboard.php",
                    "user" => [
                        "name" => $user['first_name'] . ' ' . $user['last_name'],
                        "email" => $user['email']
                    ]
                ]);
            } else {
                error_log("Hashed password verification failed");
                echo json_encode([
                    "success" => false, 
                    "message" => "Invalid password. Please check your credentials and try again."
                ]);
            }
        } else {
            // Password is not properly hashed - compare directly (for existing users)
            if ($user['Password'] === $password) {
                error_log("Plain text password match detected - rehashing password");
                
                // Re-hash the password properly and update the database
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE customers SET Password = ? WHERE email = ?");
                $update_stmt->bind_param("ss", $hashed_password, $email);
                
                if ($update_stmt->execute()) {
                    error_log("Password re-hashed and updated successfully");
                } else {
                    error_log("Failed to update password hash: " . $update_stmt->error);
                }
                $update_stmt->close();
                
                // Set session variables
                $_SESSION['user_id'] = $user['customer_id'];
                $_SESSION['user_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_first_name'] = $user['first_name'];
                $_SESSION['user_last_name'] = $user['last_name'];
                
                echo json_encode([
                    "success" => true, 
                    "message" => "Login successful! Your password has been updated for security.",
                    "redirect" => "customer_dashboard.php",
                    "user" => [
                        "name" => $user['first_name'] . ' ' . $user['last_name'],
                        "email" => $user['email']
                    ]
                ]);
            } else {
                error_log("Plain text password comparison failed");
                echo json_encode([
                    "success" => false, 
                    "message" => "Invalid password. Please reset your password or contact support."
                ]);
            }
        }
    } else {
        error_log("User not found: " . $email);
        echo json_encode([
            "success" => false, 
            "message" => "User not found. Please check your email or register for an account."
        ]);
    }
    
    $stmt->close();
} else {
    echo json_encode([
        "success" => false, 
        "message" => "Invalid request method. Please use the login form."
    ]);
}

$conn->close();
?>