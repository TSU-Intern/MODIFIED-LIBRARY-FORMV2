<?php
$conn = new mysqli("localhost", "root", "", "library_db");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // Optional: Delete the cover image file too
  $imageQuery = "SELECT coverImage FROM books WHERE id = $id";
  $imageResult = $conn->query($imageQuery);
  if ($imageResult->num_rows > 0) {
    $row = $imageResult->fetch_assoc();
    $imagePath = 'uploads/' . $row['coverImage'];
    if (file_exists($imagePath)) {
      unlink($imagePath); // Delete image file
    }
  }

  // Delete book record
  $sql = "DELETE FROM books WHERE id = $id";
  if ($conn->query($sql) === TRUE) {
    echo "Book deleted successfully.";
  } else {
    echo "Error deleting book: " . $conn->error;
  }
} else {
  echo "No book ID provided.";
}

$conn->close();
?>
