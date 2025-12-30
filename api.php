<?php
// FILE: api.php
header('Content-Type: application/json');

// 1. Connect to Database
require 'db_connect.php';

// --- CONFIGURATION ---
$doctor_email = "shivpandey94@gmail.com"; // Your email for notifications
// ---------------------

// 2. Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitize Inputs
    $name = htmlspecialchars(strip_tags(trim($_POST['name'] ?? '')));
    $phone = htmlspecialchars(strip_tags(trim($_POST['phone'] ?? '')));
    $service = htmlspecialchars(strip_tags(trim($_POST['service'] ?? '')));
    $date = htmlspecialchars(strip_tags(trim($_POST['date'] ?? '')));

    // Validation
    if(empty($name) || empty($phone)) {
        echo json_encode(["status" => "error", "message" => "Name and Phone are required."]);
        exit;
    }

    // 3. Insert into Database
    // Note: 'status' column is optional, defaulting to 'Pending' in DB usually
    $stmt = $conn->prepare("INSERT INTO appointments (patient_name, phone, service_type, preferred_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $service, $date);

    if ($stmt->execute()) {
        
        // 4. Send Email Notification (Optional - works if server supports mail)
        $subject = "New Appointment: $name";
        $msg = "New Booking:\nName: $name\nPhone: $phone\nService: $service\nDate: $date";
        $headers = "From: no-reply@pearlsshine.co.in";
        @mail($doctor_email, $subject, $msg, $headers);

        echo json_encode(["status" => "success", "message" => "Booking Confirmed!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database Error: " . $conn->error]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid Request"]);
}
?>