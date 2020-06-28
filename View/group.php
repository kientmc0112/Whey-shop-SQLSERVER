<?php 
    if (isset($_GET["idgroupdetail"]) && isset($_GET["idgroupproduct"])) {
        $idgroupdetail = $_GET["idgroupdetail"];
        $idgroupproduct = $_GET["idgroupproduct"];
    } elseif (isset($_GET["idprovider"])) {
        $idprovider = $_GET["idprovider"];
    }
?>
<div class="group" > <!-- group start -->
    <div class="container">
        <div class="row">
            <div id="group_left"> <!-- group_left start -->
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 desktop">
                    <h3>Sản phẩm mới cập nhật</h3>
                    <ul>
                        <?php 
                            if (isset($_GET["idgroupdetail"]) && isset($_GET["idgroupproduct"])) {
                                $sql= "select TOP 6* from tbl_product where IdGroupDetail = '$idgroupdetail' order by IdProduct DESC";
                            } else {
                                $sql="select TOP 6* from tbl_product where IdProvider = '$idprovider' order by IdProduct DESC";
                            }
                            $result = sqlsrv_query($conn_sqlsrv, $sql);
                            while ($row = sqlsrv_fetch_array($result)) {
                        ?>
                        <li>
                            <img src="upload/<?PHP echo($row["UrlImage"]) ?>">
                            <p><a href="index.php?page=detail&&idproduct=<?php echo($row['IdProduct']) ?>" style="color: #03564f;"><?PHP echo($row["NameProduct"]) ?></a></p>
                        </li>
                        <?php 
                            } 
                        ?>
                    </ul>
                    <img src="upload/img_group_left.jpg" class="img-responsive" alt="">
                </div>
            </div> <!-- group_left begin -->
            <div id="group_right">
                <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                    <h3>
                        <?php 
                            if (isset($_GET["idgroupdetail"]) && isset($_GET["idgroupproduct"])) {
                                $sql = "SELECT * FROM tbl_product_group WHERE IdGroupProduct = $idgroupproduct ";
                            } else {
                                $sql = "select* from tbl_product INNER JOIN tbl_provider on tbl_product.IdProvider = tbl_provider.IdProvider WHERE tbl_provider.IdProvider = '$idprovider'";
                            }
                            $query = sqlsrv_query($conn_sqlsrv,$sql);
                            $row = sqlsrv_fetch_array($query);
                            if (isset($_GET["idgroupdetail"]) && isset($_GET["idgroupproduct"])) {
                                echo($row["NameGroupProduct"]);
                            } else {
                                echo($row["NameProvider"]);
                            }
                        ?>
                        <span id="spppp">
                        <?php
                            if (isset($_GET["idgroupdetail"]) && isset($_GET["idgroupproduct"])) {
                                $sql = "SELECT COUNT(*) as number FROM tbl_product WHERE IdGroupDetail='$idgroupdetail'";
                            } else {
                                $sql = "SELECT COUNT(*) as number FROM tbl_product WHERE IdProvider='$idprovider'";
                            }
                            $query = sqlsrv_query($conn_sqlsrv,$sql);
                            $row = sqlsrv_fetch_array($query);
                        ?>
                        Đang hiển thị <?PHP echo($row["number"]);?> kết quả</span>
                    </h3>
                    <div class="container-fluid">
                        <div class="row">
                            <?php 
                                if ((isset($_GET["idgroupdetail"]) && isset($_GET["idgroupproduct"]))) {
                                    $sql= "select* from tbl_product where IdGroupDetail = '$idgroupdetail' ";
                                } else {
                                    $sql= "select* from tbl_product INNER JOIN tbl_provider on tbl_product.IdProvider = tbl_provider.IdProvider WHERE tbl_provider.IdProvider = '$idprovider'";
                                }
                                $result = sqlsrv_query($conn_sqlsrv, $sql);
                                while ($row = sqlsrv_fetch_array($result)) {
                            ?>
                            <div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
                                <div class="thumbnail text-center">
                                    <img src="upload/<?PHP echo($row["UrlImage"]) ?>">
                                    <div class="caption">
                                        <p class="p_1" style="height: 36px">
                                        <?php
                                            if (isset($_GET["idgroupdetail"]) && isset($_GET["idgroupproduct"])) {
                                                echo($row["Note"]);
                                            } else {
                                                echo $row["NameProvider"];
                                            } 
                                        ?>
                                        </p>
                                        <h5 style="color: #CB070A; font-weight: bold; height: 50px"><?PHP echo($row["NameProduct"]) ?></h5>
                                        <div id="sao">
                                        <?php 
                                            $a=rand(3,5);
                                            for ($i=0; $i < $a ; $i++) { 
                                        ?>
                                        <p class="glyphicon glyphicon-star" style="color: red"></p>
                                        <?php 
                                            } 
                                        ?>
                                        </div>
                                        <p class="p_1">
                                            <span style="text-decoration: line-through;">
                                              <?php
                                                  if ($row["OldPrice"]!=0) {
                                                      echo(number_format($row["OldPrice"])."đ");
                                                  } else echo '';
                                              ?>
                                            </span><br>
                                            <span style="font-weight: bold; color: black; text-decoration: none;"><?php echo(number_format($row["NewPrice"])."đ") ?></span>
                                        </p>
                                        <p><a href="index.php?page=detail&&idproduct=<?php echo($row['IdProduct']) ?>" class="btn btn-default"><b>Chi tiết</b></a></p>
                                    </div>
                                    <?php  
                                    if ($row["OldPrice"] != 0) {
                                        $oldprice =  $row["OldPrice"];
                                        $newprice =  $row["NewPrice"];
                                        $km = 100- round(($newprice/$oldprice)*100);
                                    ?>
                                    <div class="khuyenmai_main">
                                        <p><?php echo("-".$km."%"); ?></p>
                                    </div>
                                    <?php
                                        } 
                                    ?>
                                </div>
                            </div>
                            <?php 
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div> <!-- group_right begin -->
        </div>
    </div>
</div> <!-- group begin -->



