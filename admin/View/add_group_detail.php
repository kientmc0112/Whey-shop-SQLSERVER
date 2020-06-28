<?php 
	if (isset($_POST["btn_add"])) {
		$namegroupdetail = $_POST["txt_namegroupdetail"];
		$idgroup = $_POST["sl_idgroup"];
		// $sql="SELECT MAX(IdGroupDetail) as max FROM tbl_group_detail";
		// $query= sqlsrv_query($conn_sqlsrv, $sql);
		// $row = sqlsrv_fetch_array($query);
		// $idgroupdetail = $row["max"] + 1;
		$sql="INSERT INTO tbl_group_detail(NameGroupDetail, IdGroupProduct) VALUES (N'$namegroupdetail','$idgroup')";
		$query= sqlsrv_query($conn_sqlsrv, $sql) or die('Thêm mới thất bại');
		echo '<script>swal({
              title: "Congratulation",
              text: "Thêm mới thành công thành công",
              icon: "success",
              button: "OK",
              });</script>';
	}
?>
<div class="container page_update ">
	<h3>Thêm danh sách nhóm sản phẩm chi tiết</h3>
	<form action="" method="post">
	  	<div class="form-group">
		    <label>Tên nhóm chi tiết:</label>
		    <input type="text" class="form-control check_error" name="txt_namegroupdetail" value="" placeholder="Nhập tên nhóm chi tiết">
		    <span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
	  	</div>
	  	<div class="form-group">
	    	<label for="sel1">Nhóm sản phẩm</label>
	      	<select class="form-control" id="sel1" name="sl_idgroup">
	      	<option disabled selected>Nhóm sản phẩm</option>
	        <?php
	      		$sql="SELECT * FROM tbl_product_group";
				$query= sqlsrv_query($conn_sqlsrv, $sql);
				while ($row = sqlsrv_fetch_array($query)) {
	      	?>
	      	<option value="<?php echo $row["IdGroupProduct"] ?>"><?php echo $row["NameGroupProduct"] ?></option>
	        <?php 
	    		}  
	    	?>
	      	</select>
	  	</div>
	  	<button type="submit" class="btn btn-success" name="btn_add">Lưu</button>
	</form>
</div>