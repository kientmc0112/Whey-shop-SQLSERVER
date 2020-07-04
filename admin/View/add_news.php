<?php 
echo '..........' . $_SESSION['idAdmin'];
if (isset($_POST["btn_add"])) {
	$sql0="SELECT MAX(IdNews) as 'max' FROM tbl_news_detail";
	$query0= sqlsrv_query($conn_sqlsrv, $sql0);
	$row0 = sqlsrv_fetch_array($query0);
	$idnews = $row0["max"] + 1;

	$sql1="SELECT MAX(IdNews) as 'max' FROM LINK.webshop.dbo.tbl_news_detail";
	$query1= sqlsrv_query($conn_sqlsrv, $sql1);
	$row1 = sqlsrv_fetch_array($query1);
	$idnews2 = $row1["max"] + 1;

	if ($idnews < $idnews2) {
		$idnews = $idnews2;
	}

	$title = $_POST["txt_title"];
	$discreption = $_POST["txt_discreption"];
	$content = $_POST["txt_content"];
	$idnewsgroup = $_POST["sl_idnewsgroup"];
	//Xử lí upload ảnh start
	if ($_FILES['upload']['error']>0) {
		echo '<br> Co loi trong viec upload len serve';
	} else
	move_uploaded_file($_FILES['upload']['tmp_name'], '../upload/'.$_FILES['upload']['name']);
	$urlimage = $_FILES['upload']['name'];
	 //Xử lí upload ảnh end

	$sql="INSERT INTO tbl_news_detail(IdNews, Title, Discreption, Content, UrlImage, IdNewsGroup) VALUES ('$idnews',N'$title',N'$discreption',N'$content','$urlimage','$idnewsgroup')";
	$query= sqlsrv_query($conn_sqlsrv, $sql) or die("Thêm mới thất bại");
	header('location: index.php?page=add_news');
}
?>
<div class="container page_update ">
	<h3>Thêm danh sách chi tiết tin tức</h3>
	<form action="" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label>Tiêu đề:</label>
			<textarea class="form-control" rows="1" name="txt_title"></textarea>
			<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
		</div>
		<div class="form-group">
			<label>Mô tả:</label>
			<textarea class="form-control" rows="3" name="txt_discreption"></textarea>
			<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
		</div>
		<div class="form-group">
			<label>Nội dung:</label>
			<textarea class="form-control" rows="5" name="txt_content" id="editor3"></textarea>
			<script> 
				CKEDITOR.replace( 'editor3' );
			</script>
			<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
		</div>
		<div class="form-group">
			<label>Hình ảnh:</label>
			<input type="file" class="form-control check_error" name="upload" value="">
			<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
		</div>
		<!-- <div class="form-group">
			<label >UrlImage:</label>
			<input type="file" name="upload" class="form-control check_error" value="" >
			<span class="label label-warning lb_error"><span class="glyphicon glyphicon-remove" style="margin-right: 5px"></span>Không được để trống</span>
		</div> -->
		<div class="form-group">
			<label for="sel1">Nhóm tin tức</label>
			<select class="form-control" id="sel1" name="sl_idnewsgroup">
				<?php 
					$sql="SELECT * FROM tbl_news_group";
					$query= sqlsrv_query($conn_sqlsrv, $sql);
					while ($row = sqlsrv_fetch_array($query)) {
				?>
				<option value="<?php echo $row["IdNewsGroup"] ?>"><?php echo $row["NameNewsGroup"] ?></option>
				<?php 
					}  
				?>
			</select>
		</div>
		<button type="submit" class="btn btn-success" name="btn_add">Lưu</button>
	</form>
</div>