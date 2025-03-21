<?php
session_start();
include_once 'database.php'; // Include the database connection
var_dump($_POST['id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate the ID
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = intval($_POST['id']); // Convert the ID to an integer

        // Prepare and execute the DELETE query
        if ($stmt = $conn->prepare("DELETE FROM movies WHERE id = ?")) {
            $stmt->bind_param("i", $id);

            if ($stmt->execute()) {
                // Success
                $_SESSION['status'] = 'Record deleted successfully.';
            } else {
                // Error executing the query
                $_SESSION['status'] = 'Error deleting the record.';
                error_log("Delete Error: " . $stmt->error);
            }

            $stmt->close();
        } else {
            // Error preparing the query
            $_SESSION['status'] = 'Error preparing the deletion statement.';
            error_log("Prepare Error: " . $conn->error);
        }
    } else {
        // Invalid ID
        $_SESSION['status'] = 'Invalid record ID.';
    }

    // Redirect back to the index page
    mysqli_close($conn);
    header('Location: ../index.php');
    exit();
}
?>
