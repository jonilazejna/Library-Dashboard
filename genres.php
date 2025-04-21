<?php
include 'config.php'; // Include the database connection

// Add a genre if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'])) {
    $name = trim($_POST['name']);

    // Check if the genre already exists
    $check = $conn->prepare("SELECT * FROM genres WHERE name = ?");
    $check->bind_param("s", $name);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<div class='alert alert-warning'>This genre already exists!</div>";
    } else {
        // Insert new genre
        $stmt = $conn->prepare("INSERT INTO genres (name) VALUES (?)");
        $stmt->bind_param("s", $name);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Genre added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genres Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Set the background color of the body to light pink */
        body {
            background-color: #ffb6c1; /* Light pink */
        }

        /* Optional: Set background color for content and add a border-radius */
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background-color: #343a40; /* Dark background for navbar */
        }

        .navbar-brand, .nav-link {
            color: #ffffff !important; /* White text for navbar */
        }

        .alert {
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Navigation Bar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Genre Dashboard</a>
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
                <li class="nav-item active">
                    <a class="nav-link" href="genres.php">Manage Genres</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Add Genre Form -->
<div class="container mt-5">
    <h2 class="mb-4">Add New Genre</h2>
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Genre Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter genre name" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Genre</button>
    </form>

    <!-- List of Existing Genres -->
    <h2 class="mt-4">Existing Genres</h2>
    <ul class="list-group">
        <?php
        // Fetch all genres from the database
        $result = $conn->query("SELECT * FROM genres");  // Correct query here
        while ($genre = $result->fetch_assoc()) {
            echo "<li class='list-group-item'>" . htmlspecialchars($genre['name']) . "</li>";
        }
        ?>
    </ul>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

</body>
</html>
