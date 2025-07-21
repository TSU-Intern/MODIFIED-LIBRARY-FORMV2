<?php
$conn = new mysqli("localhost", "root", "", "library_db");

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$bookTitle = $_POST['bookTitle'];
$published = $_POST['published'];
$copies = $_POST['copies'];
$genre = $_POST['genre'];
$description = $_POST['description'];
$authorFirst = $_POST['authorFirst'];
$authorLast = $_POST['authorLast'];

$targetDir = "uploads/";
if (!is_dir($targetDir)) mkdir($targetDir);
$coverImage = $_FILES["coverUpload"]["name"];
$targetFile = $targetDir . basename($coverImage);
move_uploaded_file($_FILES["coverUpload"]["tmp_name"], $targetFile);

$sql = "INSERT INTO books 
(bookTitle, published, copies, genre, description, authorFirst, authorLast, coverImage)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssisssss", 
  $bookTitle, $published, $copies, $genre, $description, $authorFirst, $authorLast, $coverImage);

if ($stmt->execute()) {
  echo "✅ Book added successfully!";
} else {
  echo "❌ Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
