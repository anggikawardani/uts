<?php 

require 'include/function.php';

$id = $_GET["id"];

$query = "DELETE FROM truk WHERE id_truk='$id'";
if (hapus($id, $query) > 0) { // jika data berhasil dihapus
	echo "
		<script>
			alert('data berhasil dihapus!');
			document.location.href = 'index.php';
		</script>
		";
} else {
	echo "
		<script>
			alert('data gagal dihapus!');
			document.location.href = 'index.php';
		</script>
		";
}

?>