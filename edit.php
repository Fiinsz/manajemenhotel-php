<?php
include('includes/db.php');

// Ambil tabel dan ID dari URL
$table = $_GET['table'];
$id = $_GET['id'];

// Pastikan ID valid
if (!$id) {
    echo "ID tidak ditemukan.";
    exit;
}

// Tentukan kolom Primary Key berdasarkan tabel
switch ($table) {
    case 'Pelanggan':
        $primary_key = 'pelanggan_id';
        break;
    case 'Kamar':
        $primary_key = 'kamar_id';
        break;
    case 'Pelayanan':
        $primary_key = 'pelayanan_id';
        break;
    case 'Fasilitas':
        $primary_key = 'fasilitas_id';
        break;
    case 'Pemesanan_Fasilitas':
        $primary_key = 'pemesanan_fasilitas_id';
        break;
    case 'Ulasan':
        $primary_key = 'ulasan_id';
        break;
    case 'Reservasi':
        $primary_key = 'reservasi_id';
        break;
    case 'Pembayaran':
        $primary_key = 'pembayaran_id';
        break;
    default:
        echo "Tabel tidak dikenal.";
        exit;
}

// Ambil data berdasarkan ID yang sesuai dengan tabel
$sql = "SELECT * FROM $table WHERE $primary_key = $id"; // Ganti 'id' dengan kolom Primary Key yang sesuai
$result = $conn->query($sql);
$data = $result->fetch_assoc();

// Proses jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $updates = [];
    foreach ($_POST as $column => $value) {
        $updates[] = "$column = '$value'"; // Update tiap kolom
    }

    // Query untuk mengupdate data berdasarkan ID
    $sql = "UPDATE $table SET " . implode(", ", $updates) . " WHERE $primary_key = $id"; // Ganti 'id' dengan Primary Key yang sesuai
    if ($conn->query($sql)) {
        header("Location: index.php?table=$table"); // Kembali ke halaman utama tabel
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Data</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Edit Data di Tabel: <?php echo $table; ?></h2>
    <form method="POST">
        <?php foreach ($data as $column => $value): ?>
            <label><?php echo $column; ?></label><br>
            <input type="text" name="<?php echo $column; ?>" value="<?php echo $value; ?>" required><br><br>
        <?php endforeach; ?>
        <button type="submit" class="edit">Simpan Perubahan</button>
        <button class="exit"><a href="index.php?table=<?php echo $table; ?>" style="color:white;text-decoration:none;">Keluar</a></button>
    </form>
</body>
</html>
