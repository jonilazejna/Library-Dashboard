<?php
include 'config.php';

// Function to handle image upload
function uploadImage($image) {
    $image_name = basename($image['name']);
    $image_tmp = $image['tmp_name'];
    $image_path = "./images/" . $image_name;

    // Check if the image is a valid file type
    $valid_image_types = ['image/jpeg', 'image/png', 'image/gif'];
    $image_type = mime_content_type($image_tmp);

    if (!in_array($image_type, $valid_image_types)) {
        return "Error: Invalid image file type!";
    }

    // Ensure the 'images' directory exists and is writable
    if (!is_dir('images')) {
        mkdir('images', 0777, true);  // Create the directory if it doesn't exist
    }

    // Try to move the uploaded file to the 'images' directory
    if (move_uploaded_file($image_tmp, $image_path)) {
        return $image_path;
    } else {
        return "Error: Image upload failed!";
    }
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $release_date = $_POST['release_date'];

    // Validate fields
    if (empty($title) || empty($description) || empty($release_date)) {
        echo "Please fill in all fields.";
    } else {
        // Handle file upload
        $image_upload_result = uploadImage($_FILES['image']);

        if (strpos($image_upload_result, "Error") !== false) {
            echo $image_upload_result;
        } else {
            $image_path = $image_upload_result;

            // Prepare the SQL query to insert book data
            $stm = $conn->prepare("INSERT INTO books (title, description, release_date, image) VALUES (?, ?, ?, ?)");
            $stm->bind_param("ssss", $title, $description, $release_date, $image_path);

            // Execute the query
            if ($stm->execute()) {
                echo "Book added successfully!";
            } else {
                echo "Error: " . $stm->error;
            }

            // Close the prepared statement
            $stm->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Set background color to pink */
        body {
            background-color: #ffb6c1; /* Light pink background color */
        }

        /* Optional: Add some styling to improve contrast */
        .container {
            background-color: white; /* White background for content */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Book Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="add_book.php">Add Book</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="genres.php">Manage Genres</a>
                </li>
            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search books..." aria-label="Search">
                <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>

<!-- Add Book Form -->
<div class="container mt-5">
    <h2 class="mb-4">Add New Book</h2>
    <form method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="title" class="form-label">Book Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Book title" required>
            <div class="invalid-feedback">Please enter a book title.</div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" placeholder="Description" rows="3" required></textarea>
            <div class="invalid-feedback">Please enter a description.</div>
        </div>
        <div class="mb-3">
            <label for="release_date" class="form-label">Release Date</label>
            <input type="date" class="form-control" id="release_date" name="release_date" required>
            <div class="invalid-feedback">Please select a release date.</div>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Book Image</label>
            <input type="file" class="form-control" id="image" name="image" required>
            <div class="invalid-feedback">Please upload an image.</div>
        </div>
        <button type="submit" class="btn btn-primary">Add Book</button>
    </form>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

<!-- Optional: Add form validation script -->
<script>
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>

</body>
</html>
