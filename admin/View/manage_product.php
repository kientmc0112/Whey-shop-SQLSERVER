<style>
img {
    width: 70px;
    height: 70px;
}
</style>
<div class="container" style="position: relative;">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  animated zoomIn quanlysanpham" >
            <h3>Danh sách chi tiết sản phẩm </h3>
            <a href="index.php?page=add_product" class="btn btn-success btn_add"><span class="glyphicon glyphicon-plus" style="margin-right: 5px"></span>Thêm mới</a>
            <div class="row">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <input class="form-control" id="myInput" type="text" placeholder="Search..">
              </div>
            </div>
            <table class="table table-bordered "  >
                <thead>
                    <tr class="danger">
                        <th>Mã</th>
                        <th>Tên</th>
                        <th>Giá gốc</th>
                        <th>Giá cũ</th>
                        <th>Giá mới</th>
                        <th>Hỉnh ảnh</th>
                        <th>Số lượng nhập</th>
                        <th>Số lượng còn</th>
                        <th>Nhóm</th>
                        <th>Nhóm chi tiết</th>
                        <th>Mã NSX</th>
 			            <th>Chi Nhánh</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <!-- $news_onepage = 10;
                    $sql = "select *  from tbl_product";
                    $params = array();
                    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                    $query = sqlsrv_query($conn_sqlsrv, $sql , $params, $options);
                    $total_record =  sqlsrv_num_rows($query)*2; ;
                    $total_page = ceil($total_record/(2*$news_onepage));
                    if (isset($_GET["PageNo"])) {
                      $page = $_GET["PageNo"];
                    } else $page = 1;
                    $first_record = $total_record-($page-1)*$news_onepage;
                    $last_record = ($first_record - $news_onepage*2 + 1);
                    $sql = "Select * from tbl_product where IdProduct between '$last_record' and '$first_record' order by IdProduct DESC";
                    $query= sqlsrv_query($conn_sqlsrv, $sql) or die(print_r(sqlsrv_errors(), true));
                    while($row = sqlsrv_fetch_array($query)){ -->
                <?php
                    $sql = "Select * from tbl_product order by IdProduct DESC";
                    $query= sqlsrv_query($conn_sqlsrv, $sql) or die(print_r(sqlsrv_errors(), true));
                    while($row = sqlsrv_fetch_array($query)){
                ?>
                <tr style="max-height: 300px; overflow: hidden;">
                    <td><?php echo($row["IdProduct"]) ?></td>
                    <td><?php echo($row["NameProduct"]) ?></td>
                    <td><?php echo(number_format($row["OriginalPrice"])."đ") ?></td>
                    <td><?php echo(number_format($row["OldPrice"])."đ") ?></td>
                    <td><?php  echo(number_format($row["NewPrice"])."đ") ?></td>
                    <td><img src="../upload/<?php echo($row["UrlImage"]) ?>" alt=""></td>
                    <td><?php echo($row["Amount"]) ?></td>
		            <td><?php echo($row["AmountOriginal"]) ?></td>
                    <td>
                    <?php
                        // $idProductGroup = $row["IdGroupProduct"];
                        // $sql1 = "SELECT * FROM tbl_product_group WHERE IdGroupProduct = '$idProductGroup'";
                        $idGroupDetail = $row["IdGroupDetail"];
                        $sql1 = "SELECT * FROM tbl_product_group WHERE IdGroupProduct = (select IdGroupProduct from tbl_group_detail where IdGroupDetail = '$idGroupDetail')";
                        $query1 = sqlsrv_query($conn_sqlsrv, $sql1);
                        $row1 = sqlsrv_fetch_array($query1);
                        // print_r($row1);
                        echo $row1["NameGroupProduct"];
                    ?>
                    </td>
                    <td>
                    <?php
                        $idGroupDetail = $row["IdGroupDetail"];
                        $sql2 = "SELECT * FROM tbl_group_detail WHERE IdGroupDetail = '$idGroupDetail'";
                        $query2 = sqlsrv_query($conn_sqlsrv, $sql2);
                        $row2 = sqlsrv_fetch_array($query2); 
                        echo $row2["NameGroupDetail"];
                    ?>
                    </td>
                    <td>
                    <?php 
                        $idProvider = $row["IdProvider"];
                        $sql3 = "SELECT * FROM tbl_provider WHERE IdProvider = '$idProvider'";
                        $query3 = sqlsrv_query($conn_sqlsrv, $sql3);
                        $row3 = sqlsrv_fetch_array($query3);
                        echo $row3["NameProvider"]; 
                    ?>
                    </td>

        			<td>
        			<?php 
            			if ($row["IdBranch"] == 1){
            				echo( "Hà Nội");
            			} else {
            				echo ("Đà Nẵng");
            			}                       
                    ?>
                    </td>

                    <td class="td_bill">
                        <a href="index.php?page=update_product&&id=<?php echo($row["IdProduct"]) ?>" class="btn btn-success btn-xs " ><span class="fa fa-wrench" style=" margin-right: 5px"></span>Sửa</a>
                        <a href="View/delete.php?idproduct=<?php echo($row["IdProduct"]) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Bạn có chắc chắn muốn xóa')"><span class="fa fa-trash-alt" style=" margin-right: 5px"></span>Xóa</a>
                    </td>
                </tr>
                <?php 
                    } 
                ?>
                </tbody>
            </table>
            <!-- <ul class="pagination">
                <?php
                if ($page>1) {
                    $prev=$page-1;
                    echo "<li class=''><a href='index.php?page=manage_product&&PageNo=$prev'>Trước</a></li>";
                }
                for ($i=1; $i <= $total_page; $i++) {
                    if ($i!=$page) {
                        echo "<li><a href='index.php?page=manage_product&&PageNo=$i'>$i</a></li>";
                    } else echo "<li class='active'><a href='index.php?page=manage_product&&PageNo=$i'>$i</a></li>";
                }
                if ($page<$total_page) {
                    $next=$page+1;
                    echo "<li class=''><a href='index.php?page=manage_product&&PageNo=$next'>Sau...</a></li>";
                }
                ?>
            </ul> -->
        </div>
    </div>
</div>