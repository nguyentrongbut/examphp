<!DOCTYPE html>
<html>
<head>
    <title>Quản lý thư viện</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 5px;
        }

        input[type="submit"] {
            padding: 5px 15px;
            background-color: #333;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<h1>Quản lý thư viện</h1>

<?php
// Kết nối tới cơ sở dữ liệu
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "library_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Hiển thị tất cả sách
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>ID</th><th>Tác giả</th><th>Tên sách</th><th>ISBN</th><th>Năm xuất bản</th><th>Khả dụng</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["bookid"] . "</td><td>" . $row["authorid"] . "</td><td>" . $row["title"] . "</td><td>" . $row["ISBN"] . "</td><td>" . $row["pub_year"] . "</td><td>" . $row["available"] . "</td></tr>";
    }

    echo "</table>";
} else {
    echo "Không có sách trong thư viện.";
}

// Tìm sách theo tên
if (isset($_POST["search"])) {
    $searchTerm = $_POST["search"];
    $searchSql = "SELECT * FROM books WHERE title LIKE '%$searchTerm%'";
    $searchResult = $conn->query($searchSql);

    if ($searchResult->num_rows > 0) {
        echo "<h2>Kết quả tìm kiếm cho '$searchTerm':</h2>";
        echo "<table>";
        echo "<tr><th>ID</th><th>Tác giả</th><th>Tên sách</th><th>ISBN</th><th>Năm xuất bản</th><th>Khả dụng</th></tr>";

        while ($row = $searchResult->fetch_assoc()) {
            echo "<tr><td>" . $row["bookid"] . "</td><td>" . $row["authorid"] . "</td><td>" . $row["title"] . "</td><td>" . $row["ISBN"] . "</td><td>" . $row["pub_year"] . "</td><td>" . $row["available"] . "</td></tr>";
        }

        echo "</table>";
    } else {
        echo "<h2>Không tìm thấy kết quả cho '$searchTerm'.</h2>";
    }
}

$conn->close();
?>

<form method="post">
    <input type="text" name="search" placeholder="Tìm kiếm theo tên sách">
    <input type="submit" value="Tìm kiếm">
</form>
</body>
</html>
