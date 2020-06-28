<?php 
	/*Connect to localhost start	

	// $conn = mysqli_connect("localhost", "root","","webshop") or die("Kết nối thất bại");
	// mysqli_query($conn, "SET NAMES 'UTF8'");
	// $conn1 = mysqli_connect("localhost", "root","","don_vi_hanh_chinh") or die("Kết nối thất bại");
	// mysqli_query($conn1, "SET NAMES 'UTF8'");

	/*Connect to localhost end

	/*Ket noi voi sql server start*/
	$serverName = "DESKTOP-J7QF2T6"; //serverName\instanceName
	$connectionInfo = array( "Database"=>"webshop", "UID"=>"sa", "PWD"=>"123", "CharacterSet"=>"UTF-8");
	// $connectionInfo1 = array( "Database"=>"don_vi_hanh_chinh", "UID"=>"sa", "PWD"=>"123", "CharacterSet"=>"UTF-8");
	// $connectionInfo = array("Database"=>"webshop");
	$conn_sqlsrv = sqlsrv_connect($serverName, $connectionInfo);
	// $conn_sqlsrv1 = sqlsrv_connect($serverName, $connectionInfo1);
	sqlsrv_query($conn_sqlsrv, "SET NAMES 'UTF8'");
	ini_set('mssql.charset', 'UTF-8');
	if ($conn_sqlsrv) {
		/*echo 'Ket noi thanh cong';*/
	} else {
		echo 'Ket noi that bai';
		die(print_r(sqlsrv_errors(), true));
	}
	/*Ket noi voi sql server end*/
?>