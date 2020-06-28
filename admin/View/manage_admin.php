<style>
img {
    width: 70px;
    height: 70px;
}
</style>
<div class="container" style="position: relative;">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12  animated zoomIn quanlysanpham" >
            <h3>Danh sách nhân viên</h3>
            <a href="index.php?page=add_admin" class="btn btn-success btn_add"><span class="glyphicon glyphicon-plus" style="margin-right: 5px"></span>Thêm mới</a>
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
                        <th>Username</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Vị trí làm việc</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                <?php 
                    //phan trang start
                    $news_onepage = 10;//Xác định số bản tin trong một trang
                    $sql = "select *  from tbl_admin";
                    $params = array();
                    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                    $query = sqlsrv_query($conn_sqlsrv, $sql , $params, $options);
                    $total_record =  sqlsrv_num_rows($query) ;//xác định tổng số bản ghi có trong database
                    $total_page = ceil($total_record/$news_onepage);//Xác định tổng số trang
                    if (isset($_GET["PageNo"])) {//XĐ trang hiện tại
                      $page = $_GET["PageNo"];
                    } else $page = 1;
                    //$first_record = ($page-1)*$news_onepage;//xác định stt bản ghi bắt đầu của 1 trang
                    $first_record = $total_record-($page-1)*$news_onepage;
                    //phan trang end
                    // $sql="SELECT TOP $news_onepage *
                    // FROM tbl_product
                    // WHERE IdProduct NOT IN (SELECT TOP $first_record IdProduct FROM tbl_product)
                    // ORDER BY IdProduct DESC";

                    // $last_record = $first_record - $news_onepage + 1;
                    // $sql = "Select * from tbl_admin where IdAdmin between '$last_record' and '$first_record' order by IdAdmin DESC";
                    // $query= sqlsrv_query($conn_sqlsrv, $sql) or die(print_r(sqlsrv_errors(), true));
                    while($row = sqlsrv_fetch_array($query)){
                ?>
                <tr style="max-height: 300px; overflow: hidden;">
                    <td><?php echo($row["IdAdmin"]) ?></td>
                    <td><?php echo($row["NameAdmin"]) ?></td>
                    <td><?php echo($row["Username"]) ?></td>
                    <td><?php echo($row["Email"]) ?></td>
                    <td><?php echo($row["Address"]) ?></td>
                    <td><?php echo($row["Phone"]) ?></td>
                    <td>
                        <?php
                            switch ($row["Role"]) {
                                case 1:
                                    echo "Nhân viên chăm sóc khách hàng";
                                    break;
                                 
                                case 2:
                                    echo "Nhân viên quản lí tin tức";
                                    break;

                                case 3:
                                    echo "Nhân viên quản lí đơn hàng";
                                    break;

                                case 4:
                                    echo "Nhân viên quản lí sản phẩm";
                                    break;  

                                case 5: 
                                    echo "Quản lí";
                                    break;
                            } 
                        ?>
                    </td>
                    <td class="td_bill">
                        <!-- <a href="index.php?page=update_product&&id=<?php echo($row["IdProduct"]) ?>" class="btn btn-success btn-xs " ><span class="fa fa-wrench" style=" margin-right: 5px"></span>Sửa</a> -->
                        <?php
                            if ($_SESSION["role"] == 5 & $row["Role"] != 5) {
                        ?>
                        <a href="View/delete.php?idadmin=<?php echo($row["IdAdmin"]) ?>" class="btn btn-danger btn-xs" onclick="return confirm('Bạn có chắc chắn muốn xóa')"><span class="fa fa-trash-alt" style=" margin-right: 5px"></span>Xóa</a>
                        <?php
                            }
                        ?>
                    </td>
                </tr>
                <?php 
                    } 
                ?>
                </tbody>
            </table>
            <ul class="pagination">
                <?php
                //Tạo nút prev
                if ($page>1) {
                    $prev=$page-1;
                    echo "<li class=''><a href='index.php?page=manage_admin&&PageNo=$prev'>Trước</a></li>";
                }
                //Tạo nút số thứ tự trang
                for ($i=1; $i <= $total_page; $i++) {
                    if ($i!=$page) {
                        echo "<li><a href='index.php?page=manage_admin&&PageNo=$i'>$i</a></li>";
                    } else echo "<li class='active'><a href='index.php?page=manage_admin&&PageNo=$i'>$i</a></li>";
                }
                //Tạo nút next
                if ($page<$total_page) {
                    $next=$page+1;
                    echo "<li class=''><a href='index.php?page=manage_admin&&PageNo=$next'>Sau...</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>



