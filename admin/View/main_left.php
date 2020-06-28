<div id="main">
    <div class="container-fluid left">
        <div class="row">
            <div class=" menu_left " style="z-index: 11" >
                <?php
                    if (isset($_SESSION["admin"])) {
                        $username = $_SESSION["admin"];
                        $sql = "SELECT * from tbl_admin WHERE UserName = '$username'";
                        $query = sqlsrv_query($conn_sqlsrv, $sql);
                        $row = sqlsrv_fetch_array($query);
                    }
                ?>
                <div class="list-group" style="height: 100%">
                    <div class="list-group-item">
                        <div id="drm_right" class="text-center">
                            <p><span style="font-weight: 700;color: #90f709;"><?php echo($user) ?></span></p>
                            <p><span><span class="glyphicon glyphicon-record" style="font-size: 10px;color: #12fd02;"></span>Online</span></p>
                        </div>
                    </div>
                    <a href="index.php?page=home" class="list-group-item"><span class="glyphicon glyphicon-home"></span>Trang chủ</a>
                    <a href="index.php?page=update_info" class="list-group-item"><span class="glyphicon glyphicon-pencil"></span>Thay đổi thông tin</a>
                    <?php
                        if ($row["Role"] == 5 || $row["Role"] == 4) {
                    ?>
                        <div class="list-group-item lgi_1"><span class="    glyphicon glyphicon-phone"></span>Quản lý sản phẩm <span class="glyphicon glyphicon-menu-right" style="margin-left: 30px"></span>
                            <div class="menu_hover">
                                <ul>
                                    <li><a href="index.php?page=manage_product"><span class="glyphicon glyphicon-flash" style="margin-right: 5px"></span> Quản lý sản phẩm</a></li>
                                    <li><a href="index.php?page=manage_group_product"><span class="glyphicon glyphicon-flash" style="margin-right: 5px"></span>Quản lý nhóm sản phẩm</a></li>
                                    <li><a href="index.php?page=manage_group_detail"><span class="glyphicon glyphicon-flash" style="margin-right: 5px"></span>Loại sản phẩm</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php
                        }
                        if ($row["Role"] == 5 || $row["Role"] == 2) {
                    ?>
                        <div  class="list-group-item lgi_1">
                            <span class="glyphicon glyphicon-subtitles"></span>Quản lý tin tức <span class="glyphicon glyphicon-menu-right" style="margin-left: 53px"></span>
                            <div class="menu_hover">
                                <ul>
                                    <li><a href="index.php?page=manage_news"><span class="glyphicon glyphicon-flash" style="margin-right: 5px"></span> Quản lý tin tức chi tiết</a></li>
                                    <li><a href="Index.php?page=manage_news_group"><span class="glyphicon glyphicon-flash" style="margin-right: 5px"></span>Quản lý nhóm tin tức</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php
                        }
                        if ($row["Role"] == 5 || $row["Role"] == 3) {
                    ?>
                        <a href="index.php?page=manage_bill" class="list-group-item"><span class="glyphicon glyphicon-list-alt"></span>Quản lý hóa đơn</a>
                        <a href="index.php?page=manage_order" class="list-group-item"><span class="glyphicon glyphicon-shopping-cart"></span>Quản lý đơn hàng</a>
                        <a href="index.php?page=manage_statistics" class="list-group-item"><span class="glyphicon glyphicon-usd"></span>Thống kê lợi nhuận</a>
                    <?php
                        }
                        if ($row["Role"] == 5 || $row["Role"] == 1) {
                    ?>
                        <a href="index.php?page=manage_customer" class="list-group-item"><span class="glyphicon glyphicon-user"></span>Quản lý khách hàng</a>
                    <?php
                        }
                        if ($row["Role"] == 5) {
                        // if ($row["IdBranch"] == 4) {
                    ?>
                    <a href="index.php?page=manage_admin" class="list-group-item"><span class="glyphicon glyphicon-plus"></span>Quản lí nhân viên</a>
                    <?php 
                        } 
                    ?>
                    <a href="#" class="list-group-item"></a>
                </div>
            </div>
        </div>
    </div>
</div>

