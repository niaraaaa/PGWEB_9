<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'pgweb8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengecek jika ada parameter kecamatan di URL
    if (isset($_GET['kecamatan'])) {
        $kecamatan = $_GET['kecamatan'];

        // Mengambil data kecamatan dari database
        $stmt = $pdo->prepare("SELECT * FROM penduduk WHERE kecamatan = :kecamatan");
        $stmt->bindParam(':kecamatan', $kecamatan);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            die("Data tidak ditemukan.");
        }
    }

    // Memproses perubahan data jika form di-submit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kecamatan = $_POST['kecamatan'];
        $longitude = $_POST['longitude'];
        $latitude = $_POST['latitude'];
        $luas = $_POST['luas'];
        $jumlah_penduduk = $_POST['jumlah_penduduk'];

        $update_sql = "UPDATE penduduk SET longitude = :longitude, latitude = :latitude, luas = :luas, jumlah_penduduk = :jumlah_penduduk WHERE kecamatan = :kecamatan";
        $stmt = $pdo->prepare($update_sql);
        $stmt->bindParam(':longitude', $longitude);
        $stmt->bindParam(':latitude', $latitude);
        $stmt->bindParam(':luas', $luas);
        $stmt->bindParam(':jumlah_penduduk', $jumlah_penduduk);
        $stmt->bindParam(':kecamatan', $kecamatan);

        if ($stmt->execute()) {
            echo "<div style='color: green; margin: 10px 0;'>Data berhasil diupdate!</div>";
            echo "<a href='index.php'>Kembali ke tabel</a>";
            exit();
        } else {
            echo "<div style='color: red; margin: 10px 0;'>Error mengubah data: " . $stmt->errorInfo()[2] . "</div>";
        }
    }
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Data Kecamatan</title>
</head>

<body>
    <h1>Edit Data Kecamatan <?= htmlspecialchars($data['kecamatan']) ?></h1>
    <form method="POST">
        <input type="hidden" name="kecamatan" value="<?= htmlspecialchars($data['kecamatan']) ?>">
        <label>Longitude:</label>
        <input type="text" name="longitude" value="<?= htmlspecialchars($data['longitude']) ?>" required><br>
        <label>Latitude:</label>
        <input type="text" name="latitude" value="<?= htmlspecialchars($data['latitude']) ?>" required><br>
        <label>Luas:</label>
        <input type="text" name="luas" value="<?= htmlspecialchars($data['luas']) ?>" required><br>
        <label>Jumlah Penduduk:</label>
        <input type="text" name="jumlah_penduduk" value="<?= htmlspecialchars($data['jumlah_penduduk']) ?>" required><br>
        <button type="submit">Simpan Perubahan</button>
    </form>
    <br>
    <a href="index.php">Kembali ke tabel</a>
</body>

</html>