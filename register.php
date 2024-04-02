<?php
include 'database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $current_timestamp = date('Y-m-d H:i:s');
    $default_permission = 0; // Set default permission to 0 (denied)

    $sql = "INSERT INTO users (email, password, created_at, permission) VALUES ('$email', '$password', '$current_timestamp', '$default_permission')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        header('location: register.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close(); 
?>

<?php
include 'database.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['login_email'];
    $password = $_POST['login_password'];

    // Check user credentials
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, check permission level
        $row = $result->fetch_assoc();
        $permission = $row['permission'];

        if ($permission == 1) {
            
            header('location: banner.php');
            exit();
        } elseif ($permission == 0) {
           echo "Request Denied";
            header('location: register.php?error=permission_denied');
            exit();
        } else {
           
            echo "Permission level not recognized";
        }
    } else {
        echo "Invalid email or password";
    }
}

$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Register</title>
    <style>
    .container {
        max-width: 400px;
        margin: 0 auto;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .btn-block {
        width: 100%;
    }

    #loginForm {
        display: none;
    }
    </style>
</head>

<body>
    <div class="container">
        <form action="register.php" method="POST" id="registerForm">
            <h1 class="mt-5 mb-4">Register</h1>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password"
                    required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit</button>

            <div class="mt-4 text-center">
                <p>Already have an account? <a href="#" onclick="toggleForms()">Sign in</a>.</p>
            </div>
        </form>

        <!-- Login Form -->
        <form action="" method="POST" id="loginForm">
            <h1 class="mb-4">Login</h1>

            <div class="form-group">
                <label for="login_email">Email</label>
                <input type="email" class="form-control" id="login_email" name="login_email" placeholder="Enter Email"
                    required>
            </div>

            <div class="form-group">
                <label for="login_password">Password</label>
                <input type="password" class="form-control" id="login_password" name="login_password"
                    placeholder="Enter Password" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Login</button>

           
        </form>
    </div>

    <script>
    function toggleForms() {
        var registerForm = document.getElementById('registerForm');
        var loginForm = document.getElementById('loginForm');

        if (registerForm.style.display === 'block') {
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
        } else {
            registerForm.style.display = 'block';
            loginForm.style.display = 'none';
        }
    }
    </script>

</body>

</html>
