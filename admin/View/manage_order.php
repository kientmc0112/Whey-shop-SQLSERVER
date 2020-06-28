<div class="container" >
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 quanlysanpham animated zoomIn" >
            <h3>Danh sách đơn hàng</h3>
            <input class="form-control" id="myInput" type="text" placeholder="Search..">
            <table class="table table-bordered " >
                <thead style="text-align: center;">
                    <tr class="danger">
                        <th>Id</th>
                        <th>Tên khách hàng</th>
                        <th>Tên người nhận</th>
                        <th>Số điện thoại</th>
                        <th>Địa chỉ nhận</th>
                        <th>Tổng</th>
                        <th>Phương thức thanh toán</th>
                        <th>Thời gian</th>
                        <th>Trạng thái</th>
                        <th>Option</th>
                    </tr>
                </thead>
                <tbody id="myTable">
                    <?php 
                        $sql="SELECT * FROM tbl_order WHERE Status=N'Đang xử lý' order by IdOrder DESC";
                        $query= sqlsrv_query($conn_sqlsrv, $sql);
                        while ($row = sqlsrv_fetch_array($query)) {
                            $idcustomer = $row["IdCustomer"];
                    ?>
                    <tr>
                        <td><?php echo($row["IdOrder"]) ?></td>
                        <td>
                        <?php 
                            $sql1   ="SELECT * FROM tbl_customer where IdCustomer = '$idcustomer'";
                            $query1 = sqlsrv_query($conn_sqlsrv, $sql1);
                            $row1 = sqlsrv_fetch_array($query1);
                            echo $row1["NameCustomer"]; 
                        ?>
                        </td>
                        <td><?php echo($row["NameRecevier"]) ?></td>
                        <td><?php echo("+84".$row["PhoneReceiver"]) ?></td>
                        <td><?php echo($row["AddressRecevier"]) ?></td>
                        <td><?php echo(number_format($row["Total"])."VNĐ") ?></td>
                        <td><?php echo($row["Pay"]) ?></td>
                        <td><?php echo $row["Time"]->format('h:i:s d/m/Y'); ?></td>
                        <td class="td_status">
                        <?php
                            $stt = $row["Status"]; 
                            if($stt == "Hoàn tất") {
                        ?>     
                        <a class="btn btn-primary btn-xs btn_trangthai"  style="background: red; color: yellow" idbill="<?php echo($row["IdOrder"]) ?>"><span class="fa fa-check" style="margin-right: 5px"></span><?php echo($row["Status"]); ?></a>
                        <?php 
                            } else { 
                        ?>
                        <a class="btn btn-primary btn-xs btn_trangthai" idbill="<?php echo($row["IdOrder"]) ?>"><?php echo($row["Status"]."..."); ?></a>
                        <?php 
                            } 
                        ?>
                        <div class="to">
                            <select class="form-control sl_trangthai" >
                                <option value="Đang xử lý" <?php if($row["Status"] == 'Đang xử lý') echo 'selected'; ?>>Đang xử lý</option>
                                <option value="Hoàn tất" <?php if($row["Status"] == 'Hoàn tất') echo 'selected'; ?>>Hoàn tất</option>
                                <option value="Hoàn tất" <?php if($row["Status"] == 'Hủy đơn') echo 'selected'; ?>>Hoàn tất</option>
                            </select>
                            <a href="#" class="fa fa-check-circle"></a>
                        </div>
                        <div class="nho"></div>
                        </td>
                        <td class="td_bill"><a href="#" class="btn btn-success btn-xs xemhoadon " idbill="<?php echo($row["IdOrder"]) ?>" ><span class="fa fa-eye " style=" margin-right: 5px"></span>Xem</a></td>
                    </tr>
                    <?php 
                        } 
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="bill_detail">
</div>
