<?php 
session_start();
include("../../Lib/connection.php");
if (isset($_POST["year"]) && isset($_POST["month"]) && isset($_SESSION["admin"])) {
	$year = $_POST["year"];
	$month = $_POST["month"];
	
	$username = $_SESSION["admin"];
	$sql = "SELECT * from tbl_admin WHERE UserName = '$username'";
	$query = sqlsrv_query($conn_sqlsrv, $sql) or die(print_r(sqlsrv_errors(), true));
	$row = sqlsrv_fetch_array($query);
	// $idbranch = $row['IdBranch'];

	/*$sql = "SELECT DISTINCT tbl_order_detail.IdProduct, tbl_product.NameProduct,tbl_order_detail.Number,tbl_product.NewPrice,tbl_product.OriginalPrice FROM tbl_order INNER JOIN tbl_order_detail on tbl_order.IdBill = tbl_order_detail.IdBill INNER JOIN tbl_product ON tbl_order_detail.IdProduct = tbl_product.IdProduct WHERE tbl_order.IdBranch = '$idbranch' AND YEAR(Time) = $year AND MONTH(Time) = $month ORDER BY Number DESC";*/

	// $sql = "SELECT IdProduct FROM tbl_order INNER JOIN tbl_order_detail on tbl_order.IdBill = tbl_order_detail.IdBill WHERE tbl_order.IdBranch = '$idbranch' AND YEAR(Time) = $year AND MONTH(Time) = $month GROUP BY IdProduct";

	$sql = "SELECT IdProduct FROM tbl_order INNER JOIN tbl_order_detail on tbl_order.IdOrder = tbl_order_detail.IdOrder WHERE YEAR(Time) = $year AND MONTH(Time) = $month AND tbl_order.Status = N'Hoàn Tất' GROUP BY IdProduct";

	$params = array(); 
	$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	$query = sqlsrv_query($conn_sqlsrv, $sql , $params, $options) or die(print_r(sqlsrv_errors(), true));
	if (sqlsrv_num_rows($query) != false) {
?>
<p>Thống kê doanh thu tháng <?php echo($month) ?> năm <?php echo($year) ?></p>
<table class="table table-bordered">
<thead>
	<tr class="danger">
		<th>STT</th>
		<th>Tên sản phẩm</th>
		<th>Số lượng</th>
		<th>Đơn giá</th>
		<th>Số hóa đơn</th>
		<th>Tổng tiền</th>
		<th>Tiền lãi</th>
	</tr>
</thead>
<tbody>
	<?php 
	$stt = 0;
	$soluongban = 0;
	$soluongnguoimua = 0;
	$tongtienthuve = 0;
	$tongtienlai=0;
	while($row = sqlsrv_fetch_array($query)){ 
		$stt++;
		$idproduct = $row["IdProduct"];
		?>
		<tr>
			<td><?php echo($stt) ?></td>
			<td>
				<?php 
				$sql0 = "SELECT * FROM tbl_product WHERE IdProduct = '$idproduct'";
				$query0 = sqlsrv_query($conn_sqlsrv, $sql0) or die(print_r(sqlsrv_errors(), true));
				$row0 = sqlsrv_fetch_array($query0);
				echo($row0["NameProduct"]) 
				?>	
			</td>
			<td>
				<?php 
				$sql1 = "SELECT SUM(Number) as 'soluongban' FROM tbl_order_detail WHERE IdProduct = '$idproduct'";
				$query1 = sqlsrv_query($conn_sqlsrv, $sql1) or die(print_r(sqlsrv_errors(), true));
				$row1 = sqlsrv_fetch_array($query1);
				echo($row1["soluongban"]);
				$soluongban += $row1["soluongban"];
				?>	
			</td>
			<td><?php 
			$sql0 = "SELECT * FROM tbl_product WHERE IdProduct = '$idproduct'";
			$query0 = sqlsrv_query($conn_sqlsrv, $sql0) or die(print_r(sqlsrv_errors(), true));
			$row0 = sqlsrv_fetch_array($query0);
			echo number_format($row0['NewPrice']).'đ'; 
			?></td>
			<td>
				<?php 
				$sql2 = "SELECT COUNT(IdProduct) as 'songuoimua' FROM tbl_order_detail WHERE IdProduct = '$idproduct'";
				$query2 = sqlsrv_query($conn_sqlsrv, $sql2) or die(print_r(sqlsrv_errors(), true));
				$row2 = sqlsrv_fetch_array($query2);
				echo($row2["songuoimua"]);
				$soluongnguoimua += $row2["songuoimua"];
				?>
			</td>
			<td>
				<?php 
				echo(number_format($row0["NewPrice"]*$row1["soluongban"])."đ");
				$tongtienthuve += $row0["NewPrice"]*$row1["soluongban"];
				?>
			</td>
			<td>
				<?php 
				echo(number_format(($row0["NewPrice"]-$row0["OriginalPrice"])*$row1["soluongban"])."đ");
				$tongtienlai += ($row0["NewPrice"]-$row0["OriginalPrice"])*$row1["soluongban"];
				?>
			</td>
		</tr>
	<?php } ?>
</tbody>
</table> 
<div class="container thongketq">
	<div class="row">
		<h4>Tổng quan</h4>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<table class="table table-bordered">
				<tbody>
					<tr>
						<th>Tổng sản phẩm bán ra:</th>
						<td><?php echo($soluongban); ?></td>
					</tr>
					<tr>
						<th>Tổng số hóa đơn: </th>
						<td><?php 
						$sql0 = "SELECT COUNT(*) as 'tongsohoadon' FROM tbl_order WHERE Status=N'Hoàn tất'";
						$query0 = sqlsrv_query($conn_sqlsrv, $sql0) or die(print_r(sqlsrv_errors(), true));
						$row0 = sqlsrv_fetch_array($query0);
						echo($row0['tongsohoadon']); 
						?></td>
					</tr>
					<tr>
						<th>Tổng tiền thu về:</th>
						<td><?php echo(number_format($tongtienthuve)."đ"); ?></td>
					</tr>
					<tr>
						<th>Tổng tiền lãi:</th>
						<td><?php echo(number_format($tongtienlai)."đ"); ?></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>       

<?php 
	} else { 
?>
<h3>Chưa có số liệu thống kê cho tháng <?php echo($month) ?> năm <?php echo($year) ?></h3>
<?php 
	}
}
?>