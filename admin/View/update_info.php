<?php 
$idadmin = $_SESSION["idAdmin"];
$sql0 = "SELECT * FROM tbl_admin WHERE IdAdmin = '$idadmin'";
$query0 = sqlsrv_query($conn_sqlsrv, $sql0);
$row = sqlsrv_fetch_array($query0);
if (isset($_POST["btn_update"])) {
	$name = $_POST['txt_name'];
	$email = $_POST['txt_email'];
	$address = $_POST['txt_address'];
	$phone = $_POST['txt_phone'];
	$sql= "SELECT COUNT(*) FROM tbl_admin WHERE Email=N'$email'";
    $query = sqlsrv_query($conn_sqlsrv, $sql);
    if (sqlsrv_fetch_array($query) >= 1 && $email != $row['Email']){
		echo '<script>swal({
			title: "Email bị trùng",
			icon: "warning",
			button: "OK",
		});</script>';
	} else {
		$sql1 = "UPDATE tbl_admin SET Email='$email', NameAdmin=N'$name', Address=N'$address', Phone='$phone' WHERE IdAdmin='$idadmin'";
		$query= sqlsrv_query($conn_sqlsrv, $sql1) or die("Thêm mới thất bại");
		header('location: index.php?page=update_info');
	}
}
if (isset($_POST["btn_updatePass"])) {
	$idadmin =  $_SESSION["idAdmin"];
	$oldPass = md5($_POST["txt_old_pass"]);
	$newPass = md5($_POST['txt_new_pass']);
	$confirmPass = md5($_POST['txt_confirm_pass']);
	if ($newPass == $confirmPass && $oldPass == $row['Pass']) {
		$sql = "UPDATE tbl_admin SET Pass='$newPass' WHERE IdAdmin='$idadmin'";
		$query= sqlsrv_query($conn_sqlsrv, $sql) or die("Thêm mới thất bại");
		echo '<script>swal({
            title: "Congratulation",
            text: "Cập nhật thành công",
            icon: "success",
            button: "OK",
          });</script>';
	} else {
		echo '<script>swal({
			title: "Cập nhật không thành công",
			icon: "warning",
			button: "OK",
		});</script>';
	}
}
?>
<div class="container page_update animated flash ">
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-lg-offset-3">
			<h3>Thay đổi thông tin</h3>
			<form method="post">
				<div class="form-group">
					<label>Tên</label>
					<input type="text" class="form-control" name="txt_name" value="<?php echo $row['NameAdmin'] ?>">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<div class="form-group">
					<label>Email:</label>
					<input type="text" class="form-control" name="txt_email" value="<?php echo $row['Email'] ?>">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<div class="form-group">
					<label>Địa chỉ:</label>
					<input type="text" class="form-control" name="txt_address" value="<?php echo $row['Address'] ?>">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<div class="form-group">
					<label for="email">Số điện thoại:</label>
					<input type="text" class="form-control" name="txt_phone" value="<?php echo $row['Phone'] ?>">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<button type="submit" class="btn btn-success" name="btn_update">Lưu</button>
			</form>
			<h3>Thay đổi mật khẩu</h3>
			<form method="post">
				<div class="form-group">
					<label for="pwd">Mật khẩu hiện tại:</label>
					<input type="password" class="form-control" name="txt_old_pass">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<div class="form-group">
					<label for="pwd">Mật khẩu mới:</label>
					<input type="password" class="form-control" name="txt_new_pass">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
				</div>
				<div class="form-group confirm_pass">
					<label for="pwd">Xác nhận mật khẩu:</label>
					<input type="password" class="form-control" name="txt_confirm_pass">
					<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
					<div class="alert_confirm_pass"><span class="glyphicon glyphicon-remove"></span></div>
					<div class="vuong_confirm_pass"></div>
				</div>
				<button type="submit" class="btn btn-success" name="btn_updatePass">Lưu</button>
			</form>
		</div>
	</div>
</div>