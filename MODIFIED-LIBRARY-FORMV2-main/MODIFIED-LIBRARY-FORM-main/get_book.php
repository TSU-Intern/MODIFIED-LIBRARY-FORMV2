<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "library_db");

if ($conn->connect_error) {
  die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

// Validate and sanitize input
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die(json_encode(['error' => 'Invalid book ID.']));
}

$id = intval($_GET['id']);

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $book = $result->fetch_assoc();
  
  // Combine author fields if they exist separately
  if (isset($book['authorFirst']) && isset($book['authorLast'])) {
    $book['author'] = $book['authorFirst'] . ' ' . $book['authorLast'];
  }
  
  // Add full cover image path if exists
  if (!empty($book['coverImage'])) {
    $book['coverImagePath'] = 'uploads/' . $book['coverImage'];
  }
  
  echo json_encode($book);
} else {
  echo json_encode(['error' => 'Book not found.']);
}

$stmt->close();
$conn->close();
?>