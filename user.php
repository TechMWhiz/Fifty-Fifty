<?php
require_once 'database/database.php';

session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signup'])) {
    ob_start(); 

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }
    if (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters long.';
    }

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Checking if the email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $execResult = $stmt->execute();
    if ($execResult === false) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $errors['user_exist'] = 'Email is already registered';
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: register.php');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (email, name, username, password) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssss", $email, $name, $username, $hashedPassword);
    $execResult = $stmt->execute();
    if ($execResult === false) {
        die("Error executing statement: " . $stmt->error);
    }

    echo "Registration successful! Redirecting...";
    ob_end_flush();

    header('Location: login.php');
    exit();
}

// Login process
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];


    if (empty($username)) {
        $errors['username'] = 'Username is required';
    }
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    if (empty($errors)) {
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Checking username exists in the database
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        if ($stmt === false) {
            die("Error preparing statement: " . $conn->error);
        }

        $stmt->bind_param("s", $username);
        $execResult = $stmt->execute();
        if ($execResult === false) {
            die("Error executing statement: " . $stmt->error);
        }

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'],
                'username' => $user['username']
            ];

            header('Location: index.php');
            exit();
        } else {
            $errors['login'] = 'Invalid username or password';
            $_SESSION['errors'] = $errors;
            header('Location: login.php');
            exit();
        }
    }
}

?>