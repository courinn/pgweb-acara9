<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "acara8";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM penduduk WHERE id = $id";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $kecamatan = $_POST['kecamatan'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    $luas = $_POST['luas'];
    $jumlah_penduduk = $_POST['jumlah_penduduk'];

    $sql_update = "UPDATE penduduk SET kecamatan='$kecamatan', longitude='$longitude', latitude='$latitude', luas='$luas', jumlah_penduduk='$jumlah_penduduk' WHERE id=$id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<script>alert('Data berhasil diperbarui'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Data</title>
</head>

<body>
    <h2>Edit Data Penduduk</h2>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo $data['id']; ?>">
        <label>Kecamatan:</label><br>
        <input type="text" name="kecamatan" value="<?php echo $data['kecamatan']; ?>"><br>
        <label>Longitude:</label><br>
        <input type="text" name="longitude" value="<?php echo $data['longitude']; ?>"><br>
        <label>Latitude:</label><br>
        <input type="text" name="latitude" value="<?php echo $data['latitude']; ?>"><br>
        <label>Luas:</label><br>
        <input type="text" name="luas" value="<?php echo $data['luas']; ?>"><br>
        <label>Jumlah Penduduk:</label><br>
        <input type="text" name="jumlah_penduduk" value="<?php echo $data['jumlah_penduduk']; ?>"><br><br>
        <button type="submit">Simpan Perubahan</button>
    </form>
</body>

</html>
