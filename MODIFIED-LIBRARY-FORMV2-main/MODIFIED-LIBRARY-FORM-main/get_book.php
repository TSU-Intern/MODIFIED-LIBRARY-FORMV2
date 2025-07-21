<?php
$conn = new mysqli("localhost", "root", "", "library_db");

if ($conn->connect_error) {
  die(json_encode(['error' => 'Database connection failed.']));
}

if (!isset($_GET['id'])) {
  die(json_encode(['error' => 'Book ID is required.']));
}

$id = intval($_GET['id']);
$sql = "SELECT * FROM books WHERE id = $id";
$result = $conn->query($sql);

if ($result && $row = $result->fetch_assoc()) {
  echo json_encode($row);
} else {
  echo json_encode(['error' => 'Book not found.']);
}

$conn->close();
?>
