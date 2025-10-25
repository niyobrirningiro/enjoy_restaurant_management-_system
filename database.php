<?php
// fix_database.php
include 'connect.php';

echo "<h3>Fixing Database Password Issues</h3>";

// 1. Check current password column length
$check_sql = "SELECT CHARACTER_MAXIMUM_LENGTH 
              FROM INFORMATION_SCHEMA.COLUMNS 
              WHERE TABLE_NAME = 'customers' 
              AND COLUMN_NAME = 'Password' 
              AND TABLE_SCHEMA = 'restaurant_db'";
$result = $conn->query($check_sql);
$row = $result->fetch_assoc();

echo "Current Password column length: " . $row['CHARACTER_MAXIMUM_LENGTH'] . "<br>";

// 2. Alter table to fix password length
$alter_sql = "ALTER TABLE customers MODIFY Password VARCHAR(255)";
if ($conn->query($alter_sql) === TRUE) {
    echo "✅ Password column updated to VARCHAR(255)<br>";
} else {
    echo "❌ Error: " . $conn->error . "<br>";
}

// 3. Reset a test user password
$test_email = "john.doe@example.com"; // Change to your test email
$new_password = "password123";
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

$update_sql = "UPDATE customers SET Password = ? WHERE email = ?";
$stmt = $conn->prepare($update_sql);
$stmt->bind_param("ss", $hashed_password, $test_email);

if ($stmt->execute()) {
    echo "✅ Test user password reset<br>";
    echo "Email: " . $test_email . "<br>";
    echo "Password: " . $new_password . "<br>";
} else {
    echo "❌ Error resetting password: " . $stmt->error . "<br>";
}

$stmt->close();
$conn->close();

echo "<h4>🎉 Database fix complete! Try logging in with the test credentials above.</h4>";
?>