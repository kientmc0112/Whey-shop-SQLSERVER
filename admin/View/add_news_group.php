<?php 
	if (isset($_POST["btn_add"])) {
        $sql="SELECT MAX(IdNewsGroup) as max FROM tbl_news_group";
        $query= mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($query);
		$idnewsgroup = $row["max"] + 1;
		$sql1="SELECT MAX(IdNews) as 'max' FROM LINK.webshop.dbo.tbl_news_group";
		$query1= sqlsrv_query($conn_sqlsrv, $sql1);
		$row1 = sqlsrv_fetch_array($query1);
		$idnewsgroup2 = $row1["max"] + 1;

		if ($idnewsgroup < $idnewsgroup2) {
			$idnewsgroup = $idnewsgroup2;
		}

		$idAdmin = $_SESSION['idAdmin'];
		$namenewsgroup = $_POST["txt_namenewsgroup"];
		$sql="INSERT INTO `tbl_news_group`(`IdNewsGroup`, `NameNewsGroup`, `IdAdmin`) VALUES ('$idnewsgroup','$namenewsgroup', '$idAdmin')";
		$query= mysqli_query($conn, $sql) or die("Thêm mới thất bại");
		echo '<script>swal({
              title: "Congratulation",
              text: "Thêm mới thành công thành công",
              icon: "success",
              button: "OK",
              });</script>';
	}
?>
<div class="container page_update ">
	<h3>Update danh sách nhóm tin tức</h3>

	<form action="" method="post">
	  	<div class="form-group">
	    	<label >Nhóm tin tức mới:</label>
	    	<input type="text" class="form-control" name="txt_namenewsgroup" value="" >
			<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
	  	</div>
	  	<button type="submit" class="btn btn-success" name="btn_add">Lưu</button>
	</form>
</div>