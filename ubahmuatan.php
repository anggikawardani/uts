<?php 
session_start();
require 'include/function.php';

// cek apakah ada session
if (!isset($_SESSION['login'])) {
	header("Location: login.php");
}

// ambil id_muatan dari url
$id_muatan = $_GET['id'];

// ambil data muatan sesuai id yang dikirim
$query = "SELECT * FROM muatan WHERE id_muatan=$id_muatan";
$result = $conn->query($query);
$data = $result->fetch();

// buat variabel utk menambuh jenjang
// variabel ini digunakan utk menentukan option mana selected di combobox
$selected_jenjang = $data['jenjang'];

// cek apakah tombol ubah data ditekan
if (isset($_POST['btn-ubah'])) {
	
	if ($_POST['jenjang'] == "novalue") {

		$jenjangkosong = true;

		$nama= $_POST['nama'];

	} else {

		// pindahkan data dari $_POST ke variabel
		$data = $_POST;
		$nama_muatan = htmlspecialchars($data['nama']);
		$jenjang = htmlspecialchars($data['jenjang']);

		// prepare sql dan bind parameters
		$pst = $conn->prepare("UPDATE muatan SET nama_muatan=:nama_muatan, jenjang=:jenjang WHERE id_muatan=:id_muatan");
		$pst->bindParam(':nama_muatan', $nama_muatan);
		$pst->bindParam(':jenjang', $jenjang);
		$pst->bindParam(':id_muatan', $id_muatan);

		// execute query
		if ($pst->execute()) {
			echo "
			<script>
				alert('data berhasil diupdate!');
				document.location.href = 'muatan.php';
			</script>
			";
		} else {
			echo "
			<script>
				alert('data gagal diupdate!');
				document.location.href = 'ubahmuatan.php';
			</script>
			";
		}
		
	}

	

}





?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Halaman Muatan</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

	<div class="container">
		<header>
			<h2>Sistem Informasi Truk PT. Florindo</h2>
			<div class="profil">
				<p><?= $_SESSION['nama']; ?></p>
				<img src="assets/img/prof2.png" alt="foto-profil">
			</div>
		</header>

		<main>

			<nav>
				<div class="truk">
					<a href="index.php">Truk</a>
				</div>
				<div class="muatan active">
					<a href="muatan.php">Muatan</a>
				</div>
				<div class="divisi">
					<a href="divisi.php">Divisi</a>
				</div>
				<div class="logout">
					<a href="logout.php">Keluar</a>
				</div>
			</nav>

			<article class="article">
				<h2 class="datatruk">Ubah Data Muatan</h2>
				
				<form action="" method="post">

					<div class="input">
						
						<div class="input-group">
							<label for="nama">Max Muatan</label>
							<input type="text" name="nama" id="nama" required autocomplete="off" value="<?= $data['nama_muatan']; ?>">
						</div>
						
						<div class="input-group">
							<label for="jenjang">Min Muatan</label>
							<select name="jenjang" id="jenjang" required <?= (isset($jenjangkosong)) ? 'class="error"' : 'class=""' ?>
							onfocusout="myFunction()">
								<option value="novalue">--Pilih Minimal Muatan--</option>
								<option value="26" <?= ($selected_jenjang == '26') ? 'selected' : '' ?>>26 Ton</option>
								<option value="27" <?= ($selected_jenjang == '27') ? 'selected' : '' ?>>27 Ton</option>
								<option value="28" <?= ($selected_jenjang == '28') ? 'selected' : '' ?>>28 Ton</option>
								<option value="29" <?= ($selected_jenjang == '29') ? 'selected' : '' ?>>29 Ton</option>
								<option value="30" <?= ($selected_jenjang == '30') ? 'selected' : '' ?>>30 Ton</option>
							</select>
						</div>
						
						<button type="submit" name="btn-ubah">Ubah Data</button>

					</div>
							
				</form>

			</article>

		</main>
	</div>

<!-- script untuk menghilangkan warna merah pada combobox -->
<script>
function myFunction() {
  var jenjang = document.getElementById("jenjang");
  jenjang.classList.add('lostfocus');
}

</script>
	
</body>
</html>