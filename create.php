<?php
include('includes/db.php');
$table = $_GET['table'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $columns = implode(", ", array_keys($_POST));
    $values = "'" . implode("', '", array_values($_POST)) . "'";
    $sql = "INSERT INTO $table ($columns) VALUES ($values)";
    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$result = $conn->query("DESCRIBE $table");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Data</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Tambah Data ke Tabel: <?php echo $table; ?></h2>
    <form method="POST">
        <?php while ($row = $result->fetch_assoc()): ?>
            <label><?php echo $row['Field']; ?></label><br>
            <input type="text" name="<?php echo $row['Field']; ?>" required><br><br>
        <?php endwhile; ?>
        <button type="submit" class="add">Simpan</button>
    </form>
</body>
</html>
