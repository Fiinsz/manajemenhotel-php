<?php
include('includes/db.php');

// Daftar tabel yang tersedia di database
$database_name = "Manajemen Hotel";
$tables = ["pelanggan", "kamar", "pelayanan", "fasilitas", "pemesanan_fasilitas", "ulasan", "reservasi", "pembayaran"];
$current_table = $_GET['table'] ?? $tables[0]; // Jika tidak ada tabel yang dipilih, tampilkan tabel pertama

// Ambil data dari tabel yang dipilih
$sql = "SELECT * FROM $current_table";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Hotel</title>
    <link rel="stylesheet" href="css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header class="navbar">
        <div class="db-info"><?php echo $database_name; ?></div>
        <nav class="nav-links">
            <?php foreach ($tables as $table): ?>
                <a href="index.php?table=<?php echo $table; ?>" class="nav-link <?php echo ($table === $current_table) ? 'active' : ''; ?>">
                    <?php echo $table; ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </header>
    <main>
        <div class="container">
            <h2>Tabel: <?php echo $current_table; ?></h2>
            <button class="add">
                <a href="create.php?table=<?php echo $current_table; ?>" style="color:white; text-decoration:none;">Tambah Data</a>
            </button>
            <?php
            if ($result->num_rows > 0) {
                echo "<table>";
                echo "<tr>";
                // Header tabel
                while ($field = $result->fetch_field()) {
                    echo "<th>" . $field->name . "</th>";
                }
                echo "<th>Aksi</th>"; // Tambahkan kolom aksi untuk Edit dan Delete
                echo "</tr>";

                // Menampilkan data tabel
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    foreach ($row as $value) {
                        echo "<td>" . htmlspecialchars($value) . "</td>";
                    }
                    $id = $row[array_key_first($row)]; // Ambil ID dari kolom pertama (misal pelanggan_id, kamar_id)
                    echo "<td>
                            <button class='edit'>
                                <a href='edit.php?table=$current_table&id=$id' style='color:white;text-decoration:none;'>Edit</a>
                            </button>
                            <button class='delete'>
                                <a href='delete.php?table=$current_table&id=$id' style='color:white;text-decoration:none;'>Hapus</a>
                            </button>
                          </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>Tidak ada data dalam tabel ini.</p>";
            }
            ?>
        </div>
    </main>
</body>
</html>
