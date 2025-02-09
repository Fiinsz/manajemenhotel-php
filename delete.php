<?php
include('includes/db.php');

// Ambil tabel dan ID dari URL
$table = $_GET['table'];
$id = $_GET['id'];

// Cek apakah ID valid
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

// Cek apakah ada data yang mengacu ke ID yang ingin dihapus
if ($table == 'Kamar') {
    // Memeriksa apakah kamar_id ini digunakan dalam tabel Reservasi
    $check_sql = "SELECT COUNT(*) FROM Reservasi WHERE kamar_id = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    
    if ($count > 0) {
        echo "Data tidak bisa dihapus karena masih digunakan dalam tabel 'Reservasi'.";
        exit;
    }
}

// Query untuk menghapus data berdasarkan ID yang sesuai dengan tabel
$sql = "DELETE FROM $table WHERE $primary_key = ?"; // Menggunakan prepared statement untuk menghindari SQL injection
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id); // Bind ID sebagai integer
if ($stmt->execute()) {
    header("Location: index.php?table=$table"); // Kembali ke halaman utama tabel
} else {
    echo "Error: Data tidak bisa dihapus karena ada Foreign Key Constraint yang mencegah penghapusan.";
}
?>
