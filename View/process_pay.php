<?php 
	session_start();							/*Trang xử lý giao hàng và thanh toán*/
	date_default_timezone_set('Asia/Ho_Chi_Minh');
	include("../Lib/connection.php");
    if (isset($_SESSION["user"])) { 			/*Lấy ID khách hàng từ session*/ 
    	$user = $_SESSION["user"];
    	$sql="Select * from tbl_customer where Username = '$user'";
		$query= sqlsrv_query($conn_sqlsrv, $sql);
		$row = sqlsrv_fetch_array($query);
		$idcustomer = $row["IdCustomer"];
    } 
    if (isset($_SESSION["total_money"])) {		/*Lấy tổng tiền từ session cart*/
    	$total_money = $_SESSION["total_money"];   
    }

 	if (isset($_POST["btn_luu"])) {			/*Lấy dữ liệu vừa nhập từ form thanh toán*/
 		$name = $_POST["txt_name1"];
 		$phone = $_POST["txt_phone1"];
 		$hinhthucthanhtoan = $_POST["sl_hinhthucthanhtoan"];
 		$addr = $_POST["txt_addr1"];
 		
 		/*Truy vấn lấy ra tên tỉnh*/
 		if (isset($_POST["sl_tinhthanhpho"])) {
 			$tinhthanhpho = $_POST["sl_tinhthanhpho"];	
 		} else {
 			$tinhthanhpho = "";	
 		}
 		
 		/*Truy vấn lấy ra tên huyện*/
 		if (isset($_POST["sl_quanhuyen"])) {
	 		$quanhuyen = $_POST["sl_quanhuyen"];			
	 		$sql="Select * from devvn_quanhuyen where maqh = '$quanhuyen'";
			$query= sqlsrv_query($conn_sqlsrv1, $sql);
			$row = sqlsrv_fetch_array($query);
			$quanhuyen = ', ' . $row["name"];
		} else {
			$quanhuyen ="";
		}

		/*Truy vấn lấy ra tên xã*/
 		if (isset($_POST["sl_xaphuong"])) {			
 			$xaphuong = $_POST["sl_xaphuong"];
 			$sql="Select * from devvn_xaphuongthitran where xaid = '$xaphuong'";
			$query= sqlsrv_query($conn_sqlsrv1, $sql);
			$row = sqlsrv_fetch_array($query);
			$xaphuong = $row["name"];
 		} else {
 			$xaphuong ="";
 		}

		$trangthai = "Đang xử lý";

 		$AddressRecevier = $addr . $xaphuong. $quanhuyen .", $tinhthanhpho";
 		
 		$time = date('Y-m-d H:i:s');
 		/*INSERT dữ liệu vào bảng hóa đơn*/

 		$sql="SELECT MAX(IdOrder) as max FROM tbl_order";
		$query= sqlsrv_query($conn_sqlsrv, $sql);
		$row = sqlsrv_fetch_array($query);
		$idOrder = $row['max'] + 1;

		$sql1 = "SELECT max(IdOrder) as max From LINK.webshop.dbo.tbl_order";
        $query1= sqlsrv_query($conn_sqlsrv, $sql1 );
        $row1 = sqlsrv_fetch_array($query1);
        $idOrder2 = $row1["max"] + 1; 
        if($idOrder < $idOrder2) {
            $idOrder = $idOrder2;
        }

		if (sqlsrv_begin_transaction($conn_sqlsrv) === false) {
		    die( print_r( sqlsrv_errors(), true ));
		}

		/*INSERT dữ liệu vào bảng hóa đơn*/
 		$sql="INSERT INTO tbl_order(IdOrder, IdCustomer, NameRecevier, PhoneReceiver, AddressRecevier, Total, Pay, Time, Status, IdBranch) VALUES ('$idOrder','$idcustomer', N'$name', '$phone', N'$AddressRecevier', '$total_money', N'$hinhthucthanhtoan','$time', N'$trangthai', '2')";
		$query= sqlsrv_query($conn_sqlsrv, $sql) or die(print_r(sqlsrv_errors(), true));

		
		$sql0="SELECT MAX(IdOrderDetail) as max FROM tbl_order_detail";
		$query0= sqlsrv_query($conn_sqlsrv, $sql0);
		$row0 = sqlsrv_fetch_array($query0);
		$idorderdetail = $row0["max"] + 1; 

		$sql1 = "SELECT max(IdOrderDetail) as max From LINK.webshop.dbo.tbl_order_detail";
        $query1= sqlsrv_query($conn_sqlsrv, $sql1 );
        $row1 = sqlsrv_fetch_array($query1);
        $idorderdetail2 = $row1["max"] + 1; 

        if ($idorderdetail < $idorderdetail2) {
        	$idorderdetail = $idorderdetail2;
        }

		if (isset($_SESSION["cart"])) {
			foreach ($_SESSION["cart"] as $key => $val) {
				$number = $val["number"];
				$sql="INSERT INTO tbl_order_detail(IdOrderDetail, IdOrder, IdProduct, Number) VALUES ('$idorderdetail', '$idOrder','$key', '$number')";
		        $query= sqlsrv_query($conn_sqlsrv, $sql) or die(print_r(sqlsrv_errors(), true));
		        $sql1   ="select * from tbl_product where IdProduct = '$key' ";  
                $query1 = sqlsrv_query($conn_sqlsrv, $sql1);
                $row1 = sqlsrv_fetch_array($query1);
                if ($row1['AmountOriginal'] < $number) {
                	sqlsrv_rollback($conn_sqlsrv);
                	header("location: ../index.php?page=cart&&alert=payfail");
                } else {
                	$amount = $row1["AmountOriginal"] - $number;
                	$sql2   ="UPDATE tbl_product SET AmountOriginal='$amount' WHERE IdProduct='$key'";  
                	$query2 = sqlsrv_query($conn_sqlsrv, $sql2) or die("Trừ thất bại");
                	sqlsrv_commit($conn_sqlsrv);
                	header("location: ../index.php?page=cart&&alert=paysuccess");
                }
		        unset($_SESSION["cart"]);
				$idorderdetail++;
			}
		}
	} else header("location: ../index.php?page=cart&&alert=paysuccess");

?>