<?php 

require 'include/function.php';

$id = $_GET["id"];

$query = "UPDATE muatan SET status='off' WHERE id_muatan=$id";
if (hapus($id, $query) > 0) { // jika data berhasil dihapus
	echo "
		<script>
			alert('data berhasil dihapus!');
			document.location.href = 'muatan.php';
		</script>
		";
} else {
	echo "
		<script>
			alert('data gagal dihapus!');
			document.location.href = 'muatan.php';
		</script>
		";
}

?>