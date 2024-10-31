<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Leaflet JS</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        #map {
            width: 100%;
            height: 500px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Arial, sans-serif;
        }
        th {
            background-color:  #6699ff;
            color: white;
            padding: 10px;
        }
        td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2;
        }
        tr:nth-child(odd) {
            background-color: #e9f5e9;
        }
        tr:hover {
            background-color: #ddd;
        }
        button {
            padding: 5px 10px;
            background-color: #9933ff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #ff4d4d;
      
    </style>
</head>

<body>
<main>
        <div class="container border border-primary rounded">
            <div class="alert alert-primary text-center" role="alert">
                <h1>KEPENDUDUKAN KOTA YOGYAKARTA</h1>
                <h4>Provinsi Daerah Istimewa Yogyakarta</h4>
            </div>
        </div>
</main>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Inisialisasi peta
        var map = L.map("map").setView([-7.7828, 110.3008], 12);
        
        // Tile Layer Base Map
        var osm = L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        });
        osm.addTo(map);
    </script>

    <script>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "acara8";

        // Membuat koneksi
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Memeriksa koneksi
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if (isset($_POST['delete_id'])) {
            $delete_id = $_POST['delete_id'];
            $sql_delete = "DELETE FROM penduduk WHERE id = $delete_id";
            if ($conn->query($sql_delete) === TRUE) {
                echo "<script>alert('Record deleted successfully');</script>";
            } else {
                echo "<script>alert('Error deleting record: " . $conn->error . "');</script>";
            }
        }

        $sql = "SELECT * FROM penduduk";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $long = $row["longitude"];
                $lat = $row["latitude"];
                $kec = $row["kecamatan"];
                echo "L.marker([$lat, $long]).addTo(map).bindPopup('$kec');\n";
            }
        }
        ?>
    </script>

    <?php
    if ($result->num_rows > 0) {
        echo "<table><tr>
        <th>ID</th>
        <th>Kecamatan</th>
        <th>Longitude</th>
        <th>Latitude</th>
        <th>Luas</th>
        <th>Jumlah Penduduk</th>
        <th>Aksi</th>
        </tr>";

        $result->data_seek(0);
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>{$row["id"]}</td>
                <td>{$row["kecamatan"]}</td>
                <td>{$row["longitude"]}</td>
                <td>{$row["latitude"]}</td>
                <td>{$row["luas"]}</td>
                <td>{$row["jumlah_penduduk"]}</td>
                <td>
                    <a href='edit.php?id={$row["id"]}' class='btn btn-warning'>Edit</a>
                    <form method='POST' action='' style='display:inline;'>
                        <button type='submit' name='delete_id' value='{$row["id"]}' onclick='return confirm(\"Yakin ingin menghapus data ini?\")'>Hapus</button>
                    </form>
                </td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>Tidak ada data</p>";
    }
    $conn->close();
    ?>
</body>

</html>