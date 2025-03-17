<?php
session_start();
include('database.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $year_released = $_POST['year_released'];
    $genre = $_POST['genre'];
    $ratings = $_POST['ratings'];
    $description = $_POST['description'];


    $stmt = $conn->prepare("INSERT INTO movies (title, year_released, genre, ratings, description) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $title, $year_released, $genre, $ratings, $description);


    if ($stmt->execute()) {
        $_SESSION['status'] = "created";
    } else {
        $_SESSION['status'] = "error: " . $stmt->error;
    }

    $stmt->close();
    mysqli_close($conn);

    // Redirect to the index page
    header('Location: index.php');
    exit();
}
?>
