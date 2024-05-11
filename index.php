<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.html");
    exit();
}
echo "<script>console.log('logged: " . $_SESSION['username'] . "');</script>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notes | Home</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>

    <header>
        <h1>>> NOTE</h1>
        <input id="search-box" type="text" placeholder="Search">
        <div>
            <?php
            if (isset($_SESSION['username'])) {
                echo "<input id='logout-btn' type='button' onclick='logout()' value='Logout {" . $_SESSION['username'] . "}'>";
            } else {
                echo "<input id='login-btn' type='button' value='Login'>";
            }
            ?>
            <input onclick="logout()" id="take-note-btn" type="button" value="Take Note">
        </div>
    </header>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "notes";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $username = $_SESSION['username'];
    $sql = "SELECT id, subject, note FROM note WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='note'>";
            echo "<h2 class='note-content'> >> " . $row['subject'] . "</h2>";
            echo "<p class='note-content'>" . $row['note'] . "</p>";
            echo "<br>";
            echo "</div>";
        }
    } else {
        echo "<h1>..:: NOTHING TO DISPLAY ::..</h1>";
    }

    $conn->close();
    ?>

    <?php
    include ("footer.html");
    ?>

    <script>
        
        document.getElementById('take-note-btn').addEventListener('click', function () {
            window.location.href = 'createnote.html';
        });

        function logout(){
            window.location.href = 'logout.php';
        }
    </script>
</body>

</html>