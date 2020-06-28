<?php 
    if (isset($_GET["idproduct"])) {
        $idproduct = $_GET["idproduct"];
        // $sql= "select* from tbl_product_detail inner join tbl_product_group on tbl_product_detail.IdGroupProduct = tbl_product_group.IdGroupProduct where IdProduct = '$idproduct' ";
        $sql= "select * from tbl_product 
                inner join tbl_group_detail on tbl_product.IdGroupDetail = tbl_group_detail.IdGroupDetail
                inner join tbl_product_group on tbl_group_detail.IdGroupProduct = tbl_product_group.IdGroupProduct
                where IdProduct = '$idproduct' ";
        // $sql= "select* from tbl_product_detail where IdProduct = '$idproduct' ";
        $result = sqlsrv_query($conn_sqlsrv, $sql);
        $row = sqlsrv_fetch_array($result);
        $idprovider = $row["IdProvider"];
        $idGroupProduct = $row["IdGroupProduct"];
    }
?>
<div class="container" style="margin-top: 50px"> <!-- detail start -->
    <div class="row">
        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
            <div class="detail_left">
                <img src="upload/<?php echo($row["UrlImage"]) ?>" class="img-responsive">
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6"  style="padding-left: 30px">
            <div class="detail_center">
              
                <h3><?php echo($row["NameProduct"]) ?></h3>
                <p>Nhà sản xuất: <span class="span_detail">
                <?php
                    $sql1= "select* from tbl_product INNER JOIN tbl_provider on tbl_product.IdProvider = tbl_provider.IdProvider WHERE tbl_provider.IdProvider = '$idprovider'";
                    $result1 = sqlsrv_query($conn_sqlsrv, $sql1);
                    $row1 = sqlsrv_fetch_array($result1); 
                    echo $row1["NameProvider"];
                ?>
                </span></p>
                <p>Dòng sản phẩm: <span class="span_detail"><?php echo($row["NameGroupProduct"]) ?></span></p>
                <p>Số lượng sản phẩm trong kho: <span class="span_detail">
                <!--  Vẫn còn hàng -->
                <?php 
                    if($row["Amount"] > 0){
                        echo ('Còn '.$row["Amount"].' sản phẩm');
                    } else {
                        echo '<i>Xin lỗi sản phẩm này đã hết hàng</i>';
                    }
                ?>
                </span></p>
                <div class="btn btn-primary"><?php echo(number_format($row["NewPrice"])."đ") ?></div>
                <p class="trichdan">- <?php echo($row["Description"]) ?></p>
                <form action="View/addcart.php?idproduct=<?php echo($idproduct) ?>" method="post">
                    <a href="#modal-id" class="btn_mua" data-toggle="modal"><p style=""><span class="fa fa-shopping-cart" style="font-size: 30px; margin-right: 5px" ></span>Mua ngay/Thêm vào giỏ hàng</p></a>
                    <div class="modal fade" id="modal-id">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title animated flash h4Detail" style="font-style: italic;font-size: 23px;text-align: center;color: red;"><span class="glyphicon glyphicon-hand-right" style="    margin-right: 10px;font-size: 25px;"></span>Bạn có muốn thêm sản phẩm này vào giỏ hàng</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <img src="upload/<?php echo($row["UrlImage"]) ?>" class="animated bounceInLeft img-responsive">
                                            </div>
                                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                <img src="upload/doraemon.png" width="100%" style="margin-top: 140px;" class="animated bounceInRight img-responsive">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger animated zoomIn" data-dismiss="modal">Hủy</button>
                                    <button type="submit" name="btn_buy" class="btn btn-success animated zoomIn">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- detail center end -->
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 detail_right">
            <img src="upload/img_giaohang.png" alt="">
        </div>
    </div>
</div> <!-- detail begin -->


<hr style="opacity: 0">
<div class="container"><!--  thongtinsp start -->
    <div class="row">
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
            <div class="thongtinsp" style="padding: 0px 10px">
                <h3>Chi tiết sản phẩm</h3>
                <img src="upload/<?php echo($row["UrlImage"]) ?>" class="img_detail_1 img-responsive" style="width: 50%; margin-left: auto; margin-right: auto;" >
                <?php echo($row["ProductContent"])?>
            </div>
        </div>
    </div>
</div><!--  thongtinsp begin -->

<div class="container desktop"> <!-- san pham lien quan start -->
    <div class="splienquan">
        <h3><span class="glyphicon glyphicon-arrow-right" style="margin-right: 5px"></span>Sản phẩm liên quan</h3>
        <div class="row">
            <?php 
                // $sql= "SELECT TOP 6* FROM tbl_product_detail 
                // WHERE IdGroupProduct = (SELECT IdGroupProduct FROM tbl_product_detail WHERE IdProduct = $idproduct)";
                $sql= "SELECT TOP 6* FROM tbl_product
                WHERE IdProduct IN (SELECT IdGroupDetail FROM tbl_group_detail WHERE IdGroupProduct = '$idGroupProduct')";
                $result = sqlsrv_query($conn_sqlsrv, $sql);
                while ($row = sqlsrv_fetch_array($result)) {
            ?>
            <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
                <div class="thumbnail text-center">
                    <img src="upload/<?php echo($row["UrlImage"]) ?>">
                    <div class="caption">
                        <p style="color: #BDB5B5"><?php echo($row["Note"]) ?></p>
                        <p style="color:#EF5759; font-weight: bold; min-height: 65px"><?php echo($row["NameProduct"]) ?></p>
                        <p><span style="text-decoration: line-through; color: #BDB5B5">
                        <?php 
                            if ($row["OldPrice"]!=0) {
                                echo(number_format($row["OldPrice"])."đ");
                            } else {
                               echo '';
                            }
                        ?>
                        </span><span style="font-weight: bold;"><?php echo(number_format($row["NewPrice"])."đ") ?></span></p>
                        <a href="index.php?page=detail&&idproduct=<?php echo($row['IdProduct']) ?>" class="btn btn-primary">Chi tiết</a></p>
                    </div>
                </div>
                <?php  
                    if ($row["OldPrice"] != 0) {
                        $oldprice =  $row["OldPrice"];
                        $newprice =  $row["NewPrice"];
                        $km = 100- round(($newprice/$oldprice)*100);
                ?>
                <div class="khuyenmai_main">
                    <p><?php   echo("-".$km."%"); ?></p>
                </div>
                <?php
                    } 
                ?>
            </div>
            <?php 
                } 
            ?>
        </div>
    </div>
</div><!-- san pham lien quan begin -->

<div class="container didong"> <!-- san pham lien quan start -->
    <div class="splienquan">
        <h3><span class="glyphicon glyphicon-arrow-right" style="margin-right: 5px"></span>Sản phẩm liên quan</h3>
        <div class="row">
            <?php 
                $sql= "SELECT TOP 2* FROM tbl_product
                WHERE IdGroupProduct = (SELECT IdGroupProduct FROM tbl_product WHERE IdProduct = $idproduct)";
                $result = sqlsrv_query($conn_sqlsrv, $sql);
                while ($row = sqlsrv_fetch_array($result)) {
            ?>
            <div class="col-xs-6 col-sm-2 col-md-2 col-lg-2">
                <div class="thumbnail text-center">
                    <img src="upload/<?php echo($row["UrlImage"]) ?>">
                    <div class="caption">
                        <p style="color: #BDB5B5"><?php echo($row["Note"]) ?></p>
                        <p style="color:#EF5759; font-weight: bold; min-height: 65px"><?php echo($row["NameProduct"]) ?></p>
                        <p><span style="text-decoration: line-through; color: #BDB5B5">
                        <?php
                            if ($row["OldPrice"]!=0) {
                                echo(number_format($row["OldPrice"])."đ");
                            } else {
                                echo '';
                            }
                        ?>
                        </span><span style="font-weight: bold;"><?php echo(number_format($row["NewPrice"])."đ") ?></span></p>
                        <a href="index.php?page=detail&&idproduct=<?php echo($row['IdProduct']) ?>" class="btn btn-primary">Chi tiết</a></p>
                    </div>
                </div>
                <?php  
                    if ($row["OldPrice"] != 0) {
                        $oldprice =  $row["OldPrice"];
                        $newprice =  $row["NewPrice"];
                        $km = 100- round(($newprice/$oldprice)*100);
                ?>
                <div class="khuyenmai_main">
                    <p><?php   echo("-".$km."%"); ?></p>
                </div>
                <?php  
                    } 
                ?>
            </div>
            <?php 
                } 
            ?>
        </div>
    </div>
</div><!-- san pham lien quan begin -->
