<?php 
session_start();
require 'include/function.php';

// cek apakah ada session
if (!isset($_SESSION['login'])) {
	header("Location: login.php");
}

$pro = '';
$dw = '';

// ambil data muatan dan divisi untuk combo box
$muatan = tampil("SELECT id_muatan, nama_muatan FROM muatan WHERE status='on'");
$divisi = tampil("SELECT id_divisi, nama_divisi FROM divisi WHERE status='on'");

// ambil tahun dari url
$id = $_GET['id'];

// ambil data dari tbl_truk sesuai tahun tadi
$query = "SELECT * FROM tbl_truk WHERE id_truk=$id";
$result = $conn->query($query);
$data = $result->fetch();

$nama = $data['nama_truk'];
$tahun = $data['tahun'];

if (isset($_POST['btn-tambah'])) {

	// utk cek apakah ada tahun yang sama
	$tahun2 = htmlspecialchars($_POST["tahun"]);
	$query = "SELECT * FROM truk WHERE tahun='$tahun2'";
	$result = $conn->query($query);

	// jika user malah memilih option paling atas dari combobox (tidak ada value)
	if ($_POST['muatan'] == "novalue" || $_POST['divisiwali'] == "novalue" || $result->rowcount() > 0 && $tahun !== $_POST['tahun']) {

		// cek apakah muatan dan divisi wali sudah dipilih
		if ($_POST['muatan'] == "novalue") {
			$muatankosong = true;
		} 

		if ($_POST['divisiwali'] == "novalue") {
			$divisikosong = true;
		}

		if ($result->rowcount() > 0 ) {
			$tahuninvalid = true;
			$pro = $_POST['muatan'];
			$dw = $_POST['divisiwali'];
		}

		$tahun = $_POST['tahun'];
		$nama= $_POST['nama'];

	} else {

		// pindahkan data dari $_POST ke variabel
		$data = $_POST;
		$tahun = htmlspecialchars($data['tahun']);
		$nama = htmlspecialchars($data["nama"]);
		$idmuatan = htmlspecialchars($data["muatan"]);
		$iddivisi = htmlspecialchars($data["divisiwali"]);

		// prepare sql dan bind parameters
		$pst = $conn->prepare("UPDATE truk SET id_muatan=:id_muatan, id_divisi=:id_divisi, tahun=:tahun, nama_truk=:nama_truk WHERE id_truk=:id_truk");
		$pst->bindParam(':id_muatan', $idmuatan);
		$pst->bindParam(':id_divisi', $iddivisi);
		$pst->bindParam(':tahun', $tahun);
		$pst->bindParam(':nama_truk', $nama);
		$pst->bindParam(':id_truk', $id);

		// execute query
		if ($pst->execute()) {
			echo "
			<script>
				alert('data berhasil diupdate!');
				document.location.href = 'index.php';
			</script>
			";
		} else {
			echo "
			<script>
				alert('data gagal diupdate!');
				document.location.href = 'ubah.php';
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
	<title>Halaman Truk</title>
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
				<div class="truk active">
					<a href="index.php">Truk</a>
				</div>
				<div class="muatan">
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
				<h2 class="datatruk">Ubah Data Truk</h2>
				
				<form action="" method="post">

					<div class="input">

						<div class="input-group">
							<label for="tahun">Tahun</label>
							<input type="text" name="tahun" id="tahun" required autocomplete="off" value="<?= $tahun; ?>" <?= (isset($tahuninvalid)) ? 'class="tahun-invalidborder"' : 'class=""' ?>>
							<?php if (isset($tahuninvalid)) : ?>
								<label class="tahun-invalid">Tahun sudah ada!</label>
							<?php endif; ?>
						</div>
						
						<div class="input-group">
							<label for="nama">Nama</label>
							<input type="text" name="nama" id="nama" required autocomplete="off" value="<?= $nama; ?>">
						</div>
						
						<div class="input-group">
							<label for="muatan">Muatan</label>
							<select name="muatan" id="muatan" required <?= (isset($muatankosong)) ? 'class="error"' : 'class=""' ?>
							onfocusout="myFunction1()">
								<option value="novalue">--Pilih muatan--</option>

								<!-- masukkan nama muatan ke combo box muatan -->
								<?php foreach ($muatan as $row) : ?>
									<option value="<?= $row['id_muatan']; ?>" <?= ($row['nama_muatan'] == $data['nama_muatan']) ? 'selected' : '' ?> <?= ($row['id_muatan'] == $pro) ? 'selected' : '' ?>><?= $row['nama_muatan']; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div class="input-group">
							<label for="divisiwali">Divisi</label>
							<select name="divisiwali" id="divisiwali" required <?= (isset($divisikosong)) ? 'class="error"' : 'class=""' ?>onfocusout="myFunction2()">
								<option value="novalue">--Pilih Divisi--</option>

								<!-- masukkan nama divisi ke combo box divisi -->
								<?php foreach ($divisi as $row) : ?>
									<option value="<?= $row['id_divisi']; ?>" <?= ($row['nama_divisi'] == $data['nama_divisi']) ? 'selected' : '' ?> <?= ($row['id_divisi'] == $dw) ? 'selected' : '' ?>><?= $row['nama_divisi']; ?></option>
								<?php endforeach; ?>
								
							</select>
						</div>
						
						<button type="submit" name="btn-tambah">Ubah Data</button>

					</div>
							
				</form>

				

			</article>

		</main>
	</div>

<!-- script untuk menghilangkan warna merah pada combobox -->
<script>
function myFunction1() {
  var muatan = document.getElementById("muatan");
  muatan.classList.add('lostfocus');
}

function myFunction2() {
  var divisiwali = document.getElementById("divisiwali");
  divisiwali.classList.add('lostfocus');
}
</script>
	
</body>
</html>