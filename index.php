<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "crud_demo";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>



======index
<?php include 'db_connect.php'; ?>

<h2>Book List</h2>
<a href="create.php">Add New Book</a>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th><th>Title</th><th>Author</th><th>Year</th><th>ISBN</th><th>Actions</th>
    </tr>
    <?php
    $sql = "SELECT * FROM books";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['title']}</td>
            <td>{$row['author']}</td>
            <td>{$row['publication_year']}</td>
            <td>{$row['isbn']}</td>
            <td>
                <a href='edit.php?id={$row['id']}'>Edit</a> |
                <a href='delete.php?id={$row['id']}'>Delete</a>
            </td>
        </tr>";
    }

    mysqli_close($conn);
    ?>
</table>




======create

<?php include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $isbn = $_POST['isbn'];

    $sql = "INSERT INTO books (title, author, publication_year, isbn) VALUES ('$title', '$author', '$year', '$isbn')";
    mysqli_query($conn, $sql);

    header("Location: index.php");
}
?>

<h2>Add New Book</h2>
<form method="post">
    Title: <input type="text" name="title"><br><br>
    Author: <input type="text" name="author"><br><br>
    Year: <input type="number" name="year"><br><br>
    ISBN: <input type="text" name="isbn"><br><br>
    <input type="submit" value="Save">
</form>
<a href="index.php">Back to List</a>
====update

<?php
include 'db_connect.php';

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $year = $_POST['year'];
    $isbn = $_POST['isbn'];

    $sql = "UPDATE books SET title='$title', author='$author', publication_year='$year', isbn='$isbn' WHERE id=$id";
    mysqli_query($conn, $sql);

    header("Location: index.php");
}

$sql = "SELECT * FROM books WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<h2>Edit Book</h2>
<form method="post">
    Title: <input type="text" name="title" value="<?= $row['title'] ?>"><br><br>
    Author: <input type="text" name="author" value="<?= $row['author'] ?>"><br><br>
    Year: <input type="number" name="year" value="<?= $row['publication_year'] ?>"><br><br>
    ISBN: <input type="text" name="isbn" value="<?= $row['isbn'] ?>"><br><br>
    <input type="submit" value="Update">
</form>
<a href="index.php">Back to List</a>
===delete
<?php
include 'db_connect.php';

$id = $_GET['id'];

$sql = "DELETE FROM books WHERE id=$id";
mysqli_query($conn, $sql);

header("Location: index.php");
?>
