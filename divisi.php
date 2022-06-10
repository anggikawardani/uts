<?php 
session_start();
require 'include/function.php';

// cek apakah ada session
if (!isset($_SESSION['login'])) {
	header("Location: login.php");
}

// panggil fungsi tampil
$data = tampil("SELECT * FROM divisi WHERE status='on'");

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Halaman Divisi</title>
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
				<div class="muatan">
					<a href="muatan.php">Muatan</a>
				</div>
				<div class="divisi active">
					<a href="divisi.php">Divisi</a>
				</div>
				<div class="logout">
					<a href="logout.php">Keluar</a>
				</div>
			</nav>

			<article class="article">
				<h2 class="datatruk">Data Divisi</h2>
				<a href="tambahdivisi.php" class="tambah">Tambah Data</a>

				<table border="1" cellspacing="0" cellpadding="20">
		
					<tr>
						<th>No.</th>
						<th>Nama divisi</th>
						<th>NIP</th>
						<th>NIDN</th>
						<th>Jenis Roda</th>
						<th class="aksi">Aksi</th>
					</tr>

					<?php $nomor = 1; ?>
					<?php foreach ($data as $baris) : ?>
					<tr>
						<td><?= $nomor++; ?></td>
						<td><?= $baris['nama_divisi']; ?></td>
						<td><?= $baris['nip']; ?></td>
						<td><?= $baris['nidn']; ?></td>
						<td><?= $baris['jk']; ?></td>
						<td>
							<a href="ubahdivisi.php?id=<?= ($baris["id_divisi"]); ?>">Ubah</a> | 
							<a href="hapusdivisi.php?id=<?= ($baris["id_divisi"]); ?>" onclick="return confirm('Are you sure you want to delete this data?');" class="btn-hapus">Hapus</a>
						</td>
					</tr>
					<?php endforeach; ?>

				</table>

			</article>

		</main>
	</div>

	
</body>
</html>