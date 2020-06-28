<?php 	
if (isset($_POST["result"])) {
	$result = $_POST["result"];
}
?>

<div class="list-group">
	<?php
		include("../Lib/connection.php");
		$sql="SELECT * FROM tbl_product where NameProduct like '%$result%'";
		$params = array();
	    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	    $query = sqlsrv_query($conn_sqlsrv, $sql , $params, $options);
		if (sqlsrv_num_rows($query) > 0) {
			$number = sqlsrv_num_rows($query);
			echo "<h4>Tìm thấy $number sản phẩm</h4>";
			while ($row = sqlsrv_fetch_array($query)) { 
	?>
	<a href="index.php?page=detail&&idproduct=<?php echo($row['IdProduct']) ?>" class="list-group-item">
		<img src="upload/<?php echo($row["UrlImage"]) ?>" alt="" class="img-thumbnail">
		<p><?php echo($row["NameProduct"]) ?></p>
	</a>
	<?php 
			}
		} else {
	?>
		<p>Không tìm thấy sản phẩm nào</p>
	<?php 
		} 
	?>
</div>