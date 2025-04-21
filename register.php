<?php

include 'config.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
   $name = trim($_POST['name']);
   $email = trim($_POST['email']);
   $password = password_hash($_POST['password'], 
   PASSWORD_BCRYPT);
   $role='user'; //Default role

 $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
 $check_email->bind_param("s", $email);
 $check_email->execute();

 $result = $check_email->get_result();

 if($result->num_rows>0){
    echo "This email already exists..!";
 } else {
    //regjistru userat ne tabelen user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role)
    VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if($stmt->execute()){
        echo "Ju u regjistruat me sukses..! <a href='login.php'>Login</a>";
    } else {
        echo "Error: " .$stmt->error;
    }
 }

}



?>



<?php

include 'config.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
   $name = trim($_POST['name']);
   $email = trim($_POST['email']);
   $password = password_hash($_POST['password'], 
   PASSWORD_BCRYPT);
   $role='user'; //Default role

 $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
 $check_email->bind_param("s", $email);
 $check_email->execute();

 $result = $check_email->get_result();

 if($result->num_rows>0){
    echo "This email already exists..!";
 } else {
    //regjistru userat ne tabelen user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role)
    VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    if($stmt->execute()){
        echo "Ju u regjistruat me sukses..! <a href='login.php'>Login</a>";
    } else {
        echo "Error: " .$stmt->error;
    }
 }

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Register</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    
</body>
</html>