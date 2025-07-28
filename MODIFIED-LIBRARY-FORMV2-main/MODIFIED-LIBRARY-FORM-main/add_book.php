<?php
$conn = new mysqli("localhost", "root", "", "library_db");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get form data with basic validation
$bookTitle = isset($_POST['bookTitle']) ? trim($_POST['bookTitle']) : '';
$book_code = isset($_POST['book_code']) ? trim($_POST['book_code']) : '';
$published = isset($_POST['published']) ? trim($_POST['published']) : '';
$genre = isset($_POST['genre']) ? trim($_POST['genre']) : '';
$description = isset($_POST['description']) ? trim($_POST['description']) : '';
$author = isset($_POST['author']) ? trim($_POST['author']) : '';

// Debug: Check what values are being received
error_log("Received values:");
error_log("Title: $bookTitle");
error_log("Code: $book_code");
error_log("Published: $published");
error_log("Genre: $genre");
error_log("Description: $description");
error_log("Author: $author");

// Validate required fields with more specific error messages
$errors = [];
if (empty($bookTitle)) $errors[] = "Book title is required";
if (empty($book_code)) $errors[] = "Book code is required";
if (empty($published)) $errors[] = "Published date is required";
if (empty($genre)) $errors[] = "Genre is required";

if (!empty($errors)) {
    die("❌ Error: " . implode(", ", $errors));
}

// Handle file upload
$coverImage = null;
if (!empty($_FILES["coverUpload"]["name"])) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        if (!mkdir($targetDir, 0755, true)) {
            die("❌ Error: Could not create upload directory");
        }
    }
    
    $fileExtension = pathinfo($_FILES["coverUpload"]["name"], PATHINFO_EXTENSION);
    $coverImage = uniqid() . '.' . $fileExtension;
    $targetFile = $targetDir . $coverImage;
    
    // Try to move uploaded file
    if (!move_uploaded_file($_FILES["coverUpload"]["tmp_name"], $targetFile)) {
        error_log("File upload failed");
        $coverImage = null;
    }
}

// Prepare SQL statement
$sql = "INSERT INTO books 
        (bookTitle, book_code, published, genre, description, author, coverImage)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("❌ Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("sssssss", 
    $bookTitle, 
    $book_code, 
    $published, 
    $genre, 
    $description, 
    $author, 
    $coverImage);

// Execute and respond
if ($stmt->execute()) {
    echo "✅ Book added successfully!";
} else {
    echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>