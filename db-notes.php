<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sessionUsername = $_SESSION['username'];
    $subject = $_POST['subject'];
    $note = $_POST['note'];

    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "notes";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO note (subject, note, username) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $subject, $note, $sessionUsername);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}