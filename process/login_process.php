<?php
session_start();

include '../config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $role);
        $stmt->fetch();

        // Verify password
        if (password_verify($password, $hashed_password)) {
            // Successful login
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            if ($role == 'admin') {
                header("Location: ../dashboard/admin_dashboard.php");
                exit();
            }else if ($role == 'general') {
                header("Location:../dashboard/dashboard.php");
                exit();
            } 
            else {
                header("Location: ../index.php");
                exit();
            }
        } else {
            // Incorrect password
            header("Location: ../login.php?error=1");
            exit();
        }
    } else {
        // Username not found
        header("Location: ../login.php?error=1");
        exit();
    }
}
?>
