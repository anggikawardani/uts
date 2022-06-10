<?php 
session_start();
require 'include/function.php';

// cek apakah ada session
if (!isset($_SESSION['login'])) {
	header("Location: login.php");
}

$nama = '';
$jenjang = '';

// cek apakah tombol tambah data ditekan
if (isset($_POST['btn-tambah'])) {

	if ($_POST['jenjang'] == "novalue") {

		$jenjangkosong = true;

		$nama= $_POST['nama'];
		
	} else {

		// masukkan inputan ke variabel data
		$data = $_POST;
		$namamuatan = htmlspecialchars($data['nama']);
		$jenjang = htmlspecialchars($data['jenjang']);

		// cek apakah ada muatan yang sama
		$query = "SELECT * FROM muatan WHERE nama_muatan='$namamuatan'";
		$result = $conn->query($query);

		// jika tidak ada, insert data
		if ($result->rowcount() == 0) {
			// prepare sql dan binding parameters
			$pst = $conn->prepare("INSERT INTO muatan VALUES ('', :namamuatan, :jenjang, 'on')");
			$pst->bindParam(':namamuatan', $namamuatan);
			$pst->bindParam(':jenjang', $jenjang);

			// execute query
			if ($pst->execute()) {
				echo "
				<script>
					alert('data berhasil diinsert!');
					document.location.href = 'muatan.php';
				</script>
				";
			} else {
				echo "
				<script>
					alert('data gagal diinsert!');
					document.location.href = 'tambahmuatan.php';
				</script>
				";
			}
		} else {

			// jika muatan sudah ada
			$muataninvalid = true;
			$nama= $_POST['nama'];
			$jenjang = $_POST['jenjang'];
		}
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Halaman muatan</title>
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
				<h2 class="datatruk">Tambah Data Muatan</h2>
				
				<form action="" method="post">

					<div class="input">
						
						<div class="input-group">
							<label for="nama">Max Muatan</label>
							<input type="text" name="nama" id="nama" required autocomplete="off" value="<?= $nama; ?>">
							<?php if (isset($muataninvalid)) : ?>
								<label class="tahun-invalid">Muatan sudah ada!</label>
							<?php endif; ?>
						</div>
						
						<div class="input-group">
							<label for="jenjang">Min Muatan</label>
							<select name="jenjang" id="jenjang" required <?= (isset($jenjangkosong)) ? 'class="error"' : 'class=""' ?>
							onfocusout="myFunction()">
								<option value="novalue">--Pilih Minimal Muatan--</option>
								<option value="26" <?= ($jenjang == '26') ? 'selected' : '' ?>>26 Ton</option>
								<option value="27" <?= ($jenjang == '27') ? 'selected' : '' ?>>27 Ton</option>
								<option value="28" <?= ($jenjang == '28') ? 'selected' : '' ?>>28 Ton</option>
								<option value="29" <?= ($jenjang == '29') ? 'selected' : '' ?>>29 Ton</option>
								<option value="30" <?= ($jenjang == '30') ? 'selected' : '' ?>>30 Ton</option>
							</select>
						</div>
						
						<button type="submit" name="btn-tambah">Tambah Data</button>

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