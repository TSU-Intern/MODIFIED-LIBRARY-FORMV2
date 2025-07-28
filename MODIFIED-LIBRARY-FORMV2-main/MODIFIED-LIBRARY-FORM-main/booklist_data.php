<?php
$conn = new mysqli("localhost", "root", "", "library_db");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM books ORDER BY id DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    echo '<div style="display: grid; grid-template-columns: 80px 100px 1fr 100px 120px; align-items: center; padding: 10px 0; border-bottom: 1px solid #eee;">';
    echo '<div>' . $row['book_code'] . '</div>';
    echo '<div><img src="uploads/' . $row['coverImage'] . '" style="width: 60px; height: auto;"></div>';
    echo '<div>' . htmlspecialchars($row['bookTitle']) . '</div>';
    echo '<div>' . $row['published'] . '</div>';
    echo '<div>
        <button onclick="editBook(' . $row['id'] . ')">Edit</button>
        <button style="color:red" onclick="deleteBook(' . $row['id'] . ')">Delete</button>
      </div>';

    echo '</div>';
  }
} else {
  echo "<p>No books found.</p>";
}

$conn->close();
?>
