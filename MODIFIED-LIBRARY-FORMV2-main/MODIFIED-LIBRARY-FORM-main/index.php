<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "library_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all unique genres for the dropdown
$genres = [];
$genreQuery = "SELECT DISTINCT genre FROM books ORDER BY genre";
$genreResult = $conn->query($genreQuery);
if ($genreResult->num_rows > 0) {
    while($row = $genreResult->fetch_assoc()) {
        $genres[] = $row['genre'];
    }
}

// Pagination variables
$resultsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($currentPage < 1) $currentPage = 1;

// Handle search and filters
$searchResults = [];
$totalResults = 0;
if (isset($_GET['search']) || isset($_GET['genre']) || isset($_GET['sort'])) {
    $searchTerm = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
    $selectedGenre = isset($_GET['genre']) ? $conn->real_escape_string($_GET['genre']) : 'All';
    $sortOption = isset($_GET['sort']) ? $conn->real_escape_string($_GET['sort']) : 'title_asc';
    
    // Base query
    $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM books WHERE 1=1";
    
    // Add search conditions
    if (!empty($searchTerm)) {
        $sql .= " AND (bookTitle LIKE '%$searchTerm%' OR 
                      author LIKE '%$searchTerm%' OR  
                      genre LIKE '%$searchTerm%' OR
                      published LIKE '%$searchTerm%') ";
    }
    
    // Add genre filter
    if ($selectedGenre != 'All') {
        $sql .= " AND genre = '$selectedGenre'";
    }
    
    // Add sorting
    switch ($sortOption) {
        case 'title_asc':
            $sql .= " ORDER BY bookTitle ASC";
            break;
        case 'title_desc':
            $sql .= " ORDER BY bookTitle DESC";
            break;
        case 'author_asc':
            $sql .= " ORDER BY author ASC";
            break;
        case 'author_desc':
            $sql .= " ORDER BY author DESC";
            break;
        case 'year_asc':
            $sql .= " ORDER BY published ASC";
            break;
        case 'year_desc':
            $sql .= " ORDER BY published DESC";
            break;
        default:
            $sql .= " ORDER BY bookTitle ASC";
    }
    
    // Add pagination
    $offset = ($currentPage - 1) * $resultsPerPage;
    $sql .= " LIMIT $offset, $resultsPerPage";
    
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $searchResults[] = $row;
        }
    }
    
    // Get total results count
    $totalResult = $conn->query("SELECT FOUND_ROWS()");
    $totalResults = $totalResult->fetch_row()[0];
}

// Calculate total pages
$totalPages = ceil($totalResults / $resultsPerPage);
if ($currentPage > $totalPages && $totalPages > 0) {
    $currentPage = $totalPages;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECC Library Book Search</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('bg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            background-color: royalblue;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            color: white;
            font-size: 15px;
        }

        .header-container {
            background-color: rgba(0, 0, 0, 0.829);
            width: 100%;
            padding: 5px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 10px;
            box-sizing: border-box;
            color: rgb(255, 255, 255);
        }

        .header-container img {
            width: 42px;
            height: 42px;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
            transition: all 0.3s ease;
            transform-origin: center;
        }

        .header-container a:hover img {
            transform: scale(1.1) rotate(5deg);
            filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
        }

        .header-container span {
            font-size: 30px;
            font-weight: bold;
            margin-left: 10px;
        }

        .header-container nav {
            margin-left: auto;
            display: flex;
            gap: 15px;
        }

        .header-container nav a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 15px;
            padding: 8px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .header-container nav a:hover {
            background-color: rgb(228, 41, 56);
        }

        .container {
            text-align: center;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            max-width: 80%;
            width: 1200px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .header {
            background: linear-gradient(to right, rgb(16, 17, 22), #4169e1);
            color: white;
            text-align: center;
            font-weight: bold;
            font-size: 24px;
            margin-bottom: 20px;
            padding: 10px;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 10px;
            width: 60%;
            border: 2px solid #4169e1;
            border-radius: 5px 0 0 5px;
            font-size: 16px;
            outline: none;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #4169e1;
            color: white;
            border: none;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .search-container button:hover {
            background-color: darkblue;
        }

        .no-results {
            color: black;
            font-size: 18px;
            margin-top: 20px;
        }

        .results-count {
            color: black;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: left;
            font-size: 16px;
        }
        
        .filters-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .filter-group label {
            font-weight: bold;
            color: black;
        }
        
        .filter-group select {
            padding: 8px;
            border: 1px solid lightgray;
            border-radius: 5px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: linear-gradient(to bottom, #ffffff, #f0f0f0);
            color: black;
            border-radius: 10px;
            overflow: hidden;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            text-align: center;
            padding: 8px;
            font-size: 15px;
        }

        th {
            background-color: royalblue;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .available {
            color: #4CAF50;
            font-weight: bold;
        }

        .unavailable {
            color: #f44336;
            font-weight: bold;
        }

        .pagination {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .pagination button {
            padding: 5px 10px;
            background-color: royalblue;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        .pagination button:disabled {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .pagination span {
            font-weight: bold;
            color: black;
        }
    </style>
</head>

<body>
    <!-- Navigation Menu -->
    <div class="header-container">
        <a href="frontpage.html"> <img src="ecclogo.png" alt="ECC Logo"> </a>
        <span><b>ECUMENICAL CHRISTIAN COLLEGE</b></span>
        <nav>
            <a href="index.php">EXPLORE</a>
            <a href="LogForm.html">LOG FORM</a>
            <a href="voucher.html">ECC PORTAL</a>
            <a href="BorrowersForm.html">BORROWERS FORM</a>
            <a href="Admin.php" style="margin-right: 10px;">ADMIN</a>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="container">
        <div class="header">LIBRARY EXPLORE PAGE</div>

        <form method="GET" action="index.php" class="search-container">
            <input type="text" name="search" placeholder="Search by title, author, or genre..." 
                   value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
        
        <div class="filters-container">
            <div class="filter-group">
                <label for="genre">Genre:</label>
                <select name="genre" id="genre" onchange="this.form.submit()">
                    <option value="All" <?php echo (empty($_GET['genre']) || $_GET['genre'] == 'All') ? 'selected' : ''; ?>>All Genres</option>
                    <?php foreach ($genres as $genre): ?>
                        <option value="<?php echo htmlspecialchars($genre); ?>" 
                            <?php echo (isset($_GET['genre']) && $_GET['genre'] == $genre) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($genre); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="filter-group">
                <label for="sort">Sort by:</label>
                <select name="sort" id="sort" onchange="this.form.submit()">
                    <option value="title_asc" <?php echo (empty($_GET['sort']) || $_GET['sort'] == 'title_asc') ? 'selected' : ''; ?>>Title (A-Z)</option>
                    <option value="title_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'title_desc') ? 'selected' : ''; ?>>Title (Z-A)</option>
                    <option value="author_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'author_asc') ? 'selected' : ''; ?>>Author (A-Z)</option>
                    <option value="author_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'author_desc') ? 'selected' : ''; ?>>Author (Z-A)</option>
                    <option value="year_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'year_asc') ? 'selected' : ''; ?>>Year (Oldest first)</option>
                    <option value="year_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'year_desc') ? 'selected' : ''; ?>>Year (Newest first)</option>
                </select>
            </div>
        </div>

        <?php if (!empty($searchResults)): ?>
            <div class="results-count">
                Found <?php echo $totalResults; ?> book(s)
                <?php if (isset($_GET['genre']) && $_GET['genre'] != 'All'): ?>
                    in genre: <?php echo htmlspecialchars($_GET['genre']); ?>
                <?php endif; ?>
            </div>
            
            <table>
                <thead>
                    <tr>
                        <th>Book No.</th>
                        <th>Book Title</th>
                        <th>Genre</th>
                        <th>Author</th>
                        <th>Date Published</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($searchResults as $book): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($book['book_code']); ?></td>
                            <td><?php echo htmlspecialchars($book['bookTitle']); ?></td>
                            <td><?php echo htmlspecialchars($book['genre']); ?></td>
                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                            <td><?php echo htmlspecialchars($book['published']); ?></td>
                        
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <div class="pagination">
                <?php if ($currentPage > 1): ?>
                    <a href="?<?php 
                        echo http_build_query(array_merge(
                            $_GET,
                            ['page' => $currentPage - 1]
                        )); 
                    ?>"><button>Previous</button></a>
                <?php else: ?>
                    <button disabled>Previous</button>
                <?php endif; ?>
                
                <span>Page <?php echo $currentPage; ?> of <?php echo $totalPages; ?></span>
                
                <?php if ($currentPage < $totalPages): ?>
                    <a href="?<?php 
                        echo http_build_query(array_merge(
                            $_GET,
                            ['page' => $currentPage + 1]
                        )); 
                    ?>"><button>Next</button></a>
                <?php else: ?>
                    <button disabled>Next</button>
                <?php endif; ?>
            </div>
        <?php elseif (isset($_GET['search']) || isset($_GET['genre']) || isset($_GET['sort'])): ?>
            <div class="no-results">No books found matching your criteria.</div>
        <?php else: ?>
            <div class="no-results">Enter a search term or select filters to find books in our library.</div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>