<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Set background color for the entire body to light pink */
        body {
            background-color: #ffb6c1; /* Light pink background color */
        }

        .book-card {
            transition: transform 0.2s;
        }

        .book-card:hover {
            transform: scale(1.05);
        }

        .book-image {
            height: 300px;
            object-fit: cover;
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
                        <a class="nav-link active" href="dashboard.php">Home</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="add_book.php">Add Book</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link active" href="genres.php">Manage genres</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search books..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="mb-4">Popular Books</h2>
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php
            $result = $conn->query("SELECT * FROM books");
            while($book = $result->fetch_assoc()){
                echo "
                <div class='col-md-4'>
                    <div class='card mb-3 book-card'>
                        <img src='{$book['image']}' class='card-img-top book-image' alt='{$book['title']}'>
                        <div class='card-body'>
                            <h5 class='card-title'>{$book['title']}</h5>
                            <p class='card-text'>{$book['description']}</p>
                            <p class='card-text'>Released: {$book['release_date']}</p>
                            <a href='edit_book.php?id={$book['id']}' class='btn btn-danger'>Edit</a>
                        </div>
                    </div>
                </div>
                ";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
