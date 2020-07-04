<?php 
if (isset($_POST["btn_add"])) {
	$taikhoan = $_POST["txt_taikhoan"];
	$matkhau = md5($_POST["txt_matkhau"]);
	$role = $_POST['txt_role'];
	$name = $_POST['txt_name'];
	$sql="SELECT * FROM tbl_admin where Username = '$taikhoan' ";
	$params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $query = sqlsrv_query($conn_sqlsrv, $sql , $params, $options);

    $sql0="SELECT MAX(IdAdmin) as 'max' FROM tbl_admin";
	$query0= sqlsrv_query($conn_sqlsrv, $sql0);
	$row = sqlsrv_fetch_array($query0);
	$idAdmin = $row['max'] + 1;
	
	$sql1 = "SELECT max(IdAdmin) as max From LINK.webshop.dbo.tbl_admin";
    $query1= sqlsrv_query($conn_sqlsrv, $sql1 );
    $row1 = sqlsrv_fetch_array($query1);
    $idAdmin2 = $row1["max"] + 1; 

    if ($idAdmin < $idAdmin2) {
    	$idAdmin = $idAdmin2; 
    }
	
	if (sqlsrv_num_rows($query) != false) {
		echo '<script>swal({
			title: "Tên đăng nhập bị trùng",
			icon: "warning",
			button: "OK",
		});</script>';
	} else {
		$sql="INSERT INTO tbl_admin(IdAdmin, Username, Pass, NameAdmin, Email, Address, Phone, Role, IdBranch) VALUES ('$idAdmin','$taikhoan','$matkhau','$name','','', '', '$role', 2)";
		$query= sqlsrv_query($conn_sqlsrv, $sql) or die("Thêm mới thất bại");
		echo '<script>swal({
			title: "Congratulation",
			text: "Thêm mới thành công thành công",
			icon: "success",
			button: "OK",
		});</script>';
	}
}
?>
<div class="container page_update animated flash ">
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-lg-offset-3">
			<h3>Thêm nhân viên</h3>
			<form method="post">
				<div class="form-group">
					<label>Tên nhân viên</label>
					<input type="text" class="form-control" name="txt_name">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<div class="form-group">
					<label for="email">Tên tài khoản</label>
					<input type="text" class="form-control" name="txt_taikhoan">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<div class="form-group">
					<label for="pwd">Mật khẩu:</label>
					<input type="password" class="form-control" name="txt_matkhau">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<div class="form-group confirm_pass">
					<label for="pwd">Xác nhận mật khẩu:</label>
					<input type="password" class="form-control" name="txt_xacnhanmatkhau">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
					<div class="alert_confirm_pass"><span class="glyphicon glyphicon-remove"></span></div>
					<div class="vuong_confirm_pass"></div>
				</div>
				<div class="form-group">
					<label for="email">Vị trí làm việc</label>
					<select class="form-control" name="txt_role">
						<option disabled selected>Vị trí làm việc</option>
						<option value="4">Nhân viên quản lí sản phẩm</option>
						<option value="3">Nhân viên quản lí đơn hàng</option>
						<option value="2">Nhân viên quản lí tin tức</option>
						<option value="1">Nhân viên chăm sóc khách hàng</option>
					</select>
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<button type="submit" class="btn btn-success" name="btn_add">Lưu</button>
			</form>
		</div>
	</div>
</div>