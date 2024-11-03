<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'pgweb8'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Mengambil data dari tabel penduduk
    $query = $pdo->query("SELECT kecamatan, longitude, latitude, luas, jumlah_penduduk FROM penduduk");
    $data = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

// Proses menghapus data
if (isset($_GET['delete_id'])) {
    $delete_kecamatan = $_GET['delete_id'];
    $delete_sql = "DELETE FROM penduduk WHERE kecamatan = :kecamatan LIMIT 1";
    $stmt = $pdo->prepare($delete_sql);
    $stmt->bindParam(':kecamatan', $delete_kecamatan);

    if ($stmt->execute()) {
        $message = "<div style='color: green; margin: 10px 0;'>Data kecamatan " . htmlspecialchars($delete_kecamatan) . " berhasil dihapus!</div>";
    } else {
        $message = "<div style='color: red; margin: 10px 0;'>Error menghapus data: " . $stmt->errorInfo()[2] . "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Sleman</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
            background-color: #DFF2EB;
        }

        h1, h2 {
            text-align: center;
        }

        .navbar {
            width: 100%;
            background-color: #7AB2D3;
            overflow: hidden;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            margin-top: 20px;
        }

        #table-container {
            width: 70%;
            margin-right: 20px;
            overflow-y: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #6A9AB0;
            color: black;
            padding: 10px;
        }

        button {
            background-color: #6A9AB0;
            border: 1px solid black;
            width: 70px;
            height: 30px;
        }

        #map {
            width: 60%;
            height: 550px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h1>WebGIS</h1>
        <h2>Kabupaten Sleman</h2>
    </div>

    <div class="container">
        <div id="table-container">
            <table>
                <tr>
                    <th>Kecamatan</th>
                    <th>Longitude</th>
                    <th>Latitude</th>
                    <th>Luas</th>
                    <th>Jumlah Penduduk</th>
                    <th>Aksi</th>
                </tr>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['kecamatan']) ?></td>
                        <td><?= htmlspecialchars($row['longitude']) ?></td>
                        <td><?= htmlspecialchars($row['latitude']) ?></td>
                        <td><?= htmlspecialchars($row['luas']) ?></td>
                        <td><?= htmlspecialchars($row['jumlah_penduduk']) ?></td>
                        <td>
                            <!-- Form Edit -->
                            <a href="edit.php?kecamatan=<?= urlencode($row['kecamatan']) ?>" style="background-color: #6A9C89; color: white; padding: 5px; border-radius: 3px; text-decoration: none;">Edit</a>
                            <!-- Form Hapus -->
                            <form method="GET" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus kecamatan <?= htmlspecialchars($row['kecamatan']) ?>?');">
                                <input type="hidden" name="delete_id" value="<?= htmlspecialchars($row['kecamatan']) ?>">
                                <button type="submit" style="background-color: #507687; color: white; border: none; padding: 5px 10px; cursor: pointer; border-radius: 3px;">Hapus</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div id="map"></div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        var map = L.map("map").setView([-7.77, 110.30], 12);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        }).addTo(map);

        <?php foreach ($data as $row): ?>
            L.marker([<?= $row['latitude'] ?>, <?= $row['longitude'] ?>])
                .bindPopup("<b>Kecamatan: <?= htmlspecialchars($row['kecamatan']) ?></b><br>Luas: <?= htmlspecialchars($row['luas']) ?> km²<br>Jumlah Penduduk: <?= htmlspecialchars($row['jumlah_penduduk']) ?>")
                .addTo(map);
        <?php endforeach; ?>
    </script>
</body>
</html>