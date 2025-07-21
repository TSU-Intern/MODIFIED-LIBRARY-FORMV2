<?php
$conn = new mysqli("localhost", "root", "", "library_db");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = intval($_POST['book_id']);
$title = $conn->real_escape_string($_POST['bookTitle']);
$published = $conn->real_escape_string($_POST['published']);
$copies = intval($_POST['copies']);
$genre = $conn->real_escape_string($_POST['genre']);
$description = $conn->real_escape_string($_POST['description']);
$authorFirst = $conn->real_escape_string($_POST['authorFirst']);
$authorLast = $conn->real_escape_string($_POST['authorLast']);

// Check if a new image was uploaded
$coverImage = '';
if (isset($_FILES['coverUpload']) && $_FILES['coverUpload']['error'] === UPLOAD_ERR_OK) {
  $imageName = basename($_FILES['coverUpload']['name']);
  $targetDir = "uploads/";
  $targetFile = $targetDir . time() . '_' . $imageName;

  if (move_uploaded_file($_FILES['coverUpload']['tmp_name'], $targetFile)) {
    $coverImage = basename($targetFile);
  }
}

// Update query
if ($coverImage !== '') {
  // With new image
  $sql = "UPDATE books SET 
    bookTitle='$title', 
    published='$published', 
    copies=$copies, 
    genre='$genre',
    description='$description',
    authorFirst='$authorFirst',
    authorLast='$authorLast',
    coverImage='$coverImage'
    WHERE id=$id";
} else {
  // Without changing the image
  $sql = "UPDATE books SET 
    bookTitle='$title', 
    published='$published', 
    copies=$copies, 
    genre='$genre',
    description='$description',
    authorFirst='$authorFirst',
    authorLast='$authorLast'
    WHERE id=$id";
}

if ($conn->query($sql) === TRUE) {
  header("Location: admin.php#Booklist"); // Go back to Booklist tab
  exit();
} else {
  echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
