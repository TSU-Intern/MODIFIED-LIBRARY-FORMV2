<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Layout</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      display: flex;
      height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #0D47A1;
      color: white;
      padding: 20px;
    }

    .sidebar h2 {
      margin-bottom: 10px;
    }

    .profile {
      text-align: center;
      margin-bottom: 30px;
    }

    .profile img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      margin-bottom: 10px;
    }

    .nav-links {
      list-style: none;
    }

    .nav-links li {
      margin: 15px 0;
      cursor: pointer;
    }

    .nav-links li:hover {
      background-color: #1565C0;
      padding: 5px 10px;
      border-radius: 4px;
    }
		.nav-links li.active {
			background-color: #1976D2;
			border-radius: 4px;
			padding: 5px 10px;
		}

    .main-content {
      flex-grow: 1;
      background-color: #f5f5f5;
      padding: 30px;
      display: grid;
      gap: 20px;
      grid-template-columns: repeat(4, 1fr);
      grid-template-rows: auto auto;
    }

    .card {
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      text-align: center;
    }

    .genres-box {
      grid-column: span 1;
      background: white;
      padding: 15px;
      border-left: 5px solid #0D47A1;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .genres-box h3 {
      margin-bottom: 10px;
    }

    .genres-box ul {
      padding-left: 20px;
    }

    .requests-box {
      grid-column: span 1;
      background: white;
      padding: 15px;
      border-left: 5px solid #FF5722;
      border-radius: 10px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .requests-box h3 {
      margin-bottom: 10px;
    }

    .requests-box ul {
      padding-left: 20px;
    }

    .card:nth-child(1) { background-color: #BBDEFB; }
    .card:nth-child(2) { background-color: #C8E6C9; }
    .card:nth-child(3) { background-color: #FFF9C4; }
    .card:nth-child(4) { background-color: #FFE0B2; }

		.booklist-container {
			max-width: 1200px;      /* Limit width like a typical container */
			margin: 40px auto;      /* Center horizontally with margin on top/bottom */
			padding: 0 30px;        /* Left and right padding */
		}

	.booklist-content {
		background: white;
		padding: 20px;
		border-radius: 10px;
		box-shadow: 0 2px 4px rgba(0,0,0,0.1);
	}
	.main-section-wrapper {
		flex: 1;
		overflow-y: auto;
		background-color: #f5f5f5;
		height: 100vh;
	}
	.form-input {
		width: 100%;
		padding: 10px;
		margin: 8px 0 20px 0;
		border: 1px solid #ccc;
		border-radius: 6px;
	}

	.form-row {
		display: flex;
		gap: 20px;
		margin-bottom: 20px;
	}

	.form-row > div {
		flex: 1;
	}

	textarea.form-input {
		resize: vertical;
	}

	.submit-button {
		background-color: #0D47A1;
		color: white;
		padding: 12px 20px;
		border: none;
		border-radius: 6px;
		cursor: pointer;
		font-weight: bold;
		margin-top: 10px;
	}

	.submit-button:hover {
		background-color: #1565C0;
	}
.edit-form-container {
  display: none;
  grid-template-columns: 2fr 1fr;
  gap: 30px;
}



		
  </style>
</head>
<body>

  <div class="sidebar">
    <h2>Admin</h2>
    <div class="profile">
      <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Admin Icon">
      <p>Dennis M. Soliman Jr.</p>
    </div>
    <ul class="nav-links">
			<li onclick="showSection('Dashboard', event)">Dashboard</li>
			<li onclick="showSection('Booklist', event)">Booklist</li>
			<li onclick="showSection('AddBook', event)">Add Book</li>
      	<li onclick="showSection('Requests', event)">Requests</li>
			<li onclick="showSection('ManageBooks', event)">Manage Books</li>
		</ul>
  </div>
<main class="main-section-wrapper">
  <!-- Dashboard Section -->
	<section id="Dashboard" class="content-section">
		<div class="main-content">
			<!-- Row 1 -->
			<div class="card">Total Users<br><span>120</span></div>
      <div class="card">Users today<br><span>120</span></div>
			<div class="card">Total Books<br><span>530</span></div>
			
			

			<!-- Row 2 -->
      <div class="card">genres<br><span>320</span></div>
			<div class="card">books borrowed<br><span>432</span></div>
			<div class="card">books returned<br><span>12 Genres</span></div>
		</div>
	</section>
	<!-- Dashboard Section END -->

	<!-- Booklist section -->
<section id="Booklist" class="content-section" style="display:none">
  <div class="booklist-container">
    <div class="booklist-content">

      <!-- Book List Wrapper -->
      <div id="bookListWrapper">
  <!-- Search Bar -->
  <input type="text" class="form-input" placeholder="Search books...">

  <!-- Metadata Headings -->
  <div style="display: grid; grid-template-columns: 1fr 1fr 2fr 1fr 1fr; font-weight: bold; margin-top: 20px;">
    <div>Book code</div>
    <div>Book</div>
    <div>Title</div>
    <div>Published</div>
    <div>Action</div>
  </div>

  <hr style="margin: 10px 0;">

  <!-- Book list content goes here -->
  <div id="bookItems">
    <?php include('booklist_data.php'); ?>
  </div>
</div>

              <div id="editForm" style="display:none; margin-top:30px; grid-template-columns: 2fr 1fr; gap: 30px;" class="edit-form-container">

        <div>
          <!-- Back arrow and heading -->
          <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <span style="font-size: 24px; cursor: pointer; margin-right: 10px;" onclick="goBackToList()">&#8592;</span>
            <h3 style="margin: 0;">Edit Book</h3>
          </div>

          <form action="edit_book.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="book_id" id="editBookId">

            <label>Title</label>
            <input type="text" name="bookTitle" id="editTitle" class="form-input">

            <div class="form-row">
              <div>
                <label>Book Code</label>
                <input type="number" name="book_code" id="editbook_code" class="form-input">
              </div>
              <div>
                <label>Published</label>
                <input type="text" name="published" id="editPublished" class="form-input">
              </div>

              <div>
                <label>Genre</label>
                <select name="genre" id="editGenre" class="form-input">
                  <option>Fiction</option>
                  <option>Science</option>
                  <option>Romance</option>
                  <option>History</option>
                  <option>Mystery</option>
                </select>
              </div>
            </div>

            <label>Description</label>
            <textarea name="description" id="editDescription" rows="3" class="form-input"></textarea>

            <div class="form-row">
              <div>
                <label>Author</label>
                <input type="text" name="author" id="editAuthor" class="form-input">
              </div>
            </div>

            <label>Replace Cover Image (optional)</label>
            <input type="file" name="coverUpload" class="form-input" accept="image/*">

            <button type="submit" class="submit-button">Save Changes</button>
          </form>
        </div>

        <div style="text-align: center;">
          <img id="editCoverImage" src="" alt="Book Cover" style="max-width: 100%; max-height: 300px; border-radius: 10px;">
        </div>
      </div>
    </div>
  </div>
</section>
	<!-- Booklist section END -->

	<section id="Requests" class="content-section" style="display:none">Requests Content</section>
<section id="AddBook" class="content-section" style="display:none">
    <div class="booklist-container">
      <div class="booklist-content">
        <h2 style="margin-bottom: 20px;">Add Book</h2>
        
        <form action="add_book.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
          <!-- Book Title -->
          <label for="bookTitle">Book Title</label>
          <input type="text" id="bookTitle" name="bookTitle" class="form-input" placeholder="Enter book title">

          <!-- Book Code, Published, Genre in one row -->
          <div class="form-row">
            <div>
              <label for="book_code">Book Code</label>
              <input type="text" id="book_code" name="book_code" class="form-input" placeholder="Enter book code">
            </div>
            <div>
              <label for="published">Published</label>
              <input type="text" id="published" name="published" class="form-input" placeholder="Enter date published">
            </div>
            <div>
              <label for="genre">Genre</label>
              <select id="genre" name="genre" class="form-input">
                <option value="">Select Genre</option>
                <option>Fiction</option>
                <option>Science</option>
                <option>Romance</option>
                <option>History</option>
                <option>Mystery</option>
              </select>
            </div>
          </div>

          <!-- Description -->
          <label for="description">Description</label>
          <textarea id="description" name="description" rows="4" class="form-input" placeholder="Enter book description..."></textarea>

          <!-- Author -->
          <label for="author">Author</label>
          <input type="text" id="author" name="author" class="form-input" placeholder="Enter author name">

          <!-- Upload Cover Image -->
          <div style="margin: 20px 0;">
            <label style="display: block; margin-bottom: 10px; font-weight: bold;">Upload Cover Image (Optional)</label>
            <input type="file" id="coverUpload" name="coverUpload" accept="image/*">
          </div>

          <!-- Add Book Button -->
          <button type="submit" class="submit-button" style="width: 100%;">Add Book</button>
        </form>
      </div>
    </div>
  </section>
		
	<section id="ManageBooks" class="content-section" style="display:none">Manage Books Content</section>

</main>

  
	<script>
  function showSection(id, event) {
		document.querySelectorAll('.content-section').forEach(section => {
			section.style.display = 'none';
		});
		document.getElementById(id).style.display = 'block';

		document.querySelectorAll('.nav-links li').forEach(li => {
			li.classList.remove('active');
		});
		event.target.classList.add('active');
	}
  function editBook(bookId) {
  fetch('get_book.php?id=' + bookId)
    .then(response => response.json())
    .then(data => {
      if (data.error) {
        alert('Book not found.');
        return;
      }

      // Hide list, show form
      document.getElementById('bookListWrapper').style.display = 'none';
      document.getElementById('editForm').style.display = 'grid';

      // Populate fields
      document.getElementById('editBookId').value = data.id;
      document.getElementById('editTitle').value = data.bookTitle;
      document.getElementById('editbook_code').value = data.book_code;
      document.getElementById('editPublished').value = data.published;
      document.getElementById('editGenre').value = data.genre;
      document.getElementById('editDescription').value = data.description;
      document.getElementById('editAuthor').value = data.author;

      // Image
      const img = document.getElementById('editCoverImage');
      img.src = data.coverImage ? 'uploads/' + data.coverImage : 'default.jpg';
    })
    .catch(error => {
      console.error('Error fetching book:', error);
      alert('An error occurred.');
    });
  }
  
  function goBackToList() {
  document.getElementById('editForm').style.display = 'none';
  document.getElementById('bookListWrapper').style.display = 'block';
  }

  function deleteBook(bookId) {
    if (!confirm("Are you sure you want to delete this book?")) return;

    fetch('delete_book.php?id=' + bookId, {
      method: 'GET'
    })
    .then(response => response.text())
    .then(result => {
      alert(result);
      // Refresh the book list
        fetch('booklist_data.php')
    .then(response => response.text())
    .then(html => {
      document.getElementById('bookItems').innerHTML = html;
    });

    })
    .catch(error => {
      console.error('Error:', error);
      alert('Failed to delete the book.');
    });
  }
   function validateForm() {
      const requiredFields = [
        {id: 'bookTitle', name: 'Book title'},
        {id: 'book_code', name: 'Book code'}, 
        {id: 'published', name: 'Published date'},
        {id: 'genre', name: 'Genre'}
      ];
      
      for (const field of requiredFields) {
        const element = document.getElementById(field.id);
        if (!element.value.trim()) {
          alert(`${field.name} is required`);
          element.focus();
          return false;
        }
      }
      return true;
    }
	</script>
</body>
</html>
