<?php
// Login
if (isset($_POST["bt_dangnhap"])) {
    $user = $_POST["txt_user"];
    $pass = md5($_POST["txt_pass"]);
    $sql= "SELECT * FROM tbl_customer where Username='$user' and Pass='$pass'";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $query = sqlsrv_query($conn_sqlsrv, $sql , $params, $options);
    if (sqlsrv_num_rows($query)  != false){
        $_SESSION["user"]=$user;
        $row = sqlsrv_fetch_array($query);
        $_SESSION["idcustomer"] = $row['IdCustomer'];
        echo '<script>swal({
            title: "Congratulation",
            text: "Bạn đã đăng nhập thành công",
            icon: "success",
            button: "OK",
          });</script>';
    } else {
        echo '<script>swal({
            text: "Tên tài khoản hoặc mật khẩu không chính xác",
            icon: "warning",
            button: "OK",
          });</script>';
    }
}

// Register
if (isset($_POST["bt_dangky"])){
    $user = $_POST["txt_user_dk"];
    $pass = md5($_POST["txt_pass_dk"]);
    $email = $_POST["txt_email"];
    $name = $_POST["txt_name"];
    $phone = $_POST["txt_phone"];
    $addr = $_POST["txt_addr"];
    
    $sql= "SELECT * FROM tbl_customer where Username='$user' or Email='$email'";
    $query = sqlsrv_query($conn_sqlsrv, $sql);
    if (sqlsrv_num_rows($query) >0){
        echo '<script>swal({
            title: "Tên đăng nhập hoặc email đã tồn tại",
            icon: "warning",
            button: "OK",
          });</script>';
    } else {
        $sql = "SELECT max(IdCustomer) as max From tbl_customer";
        $query = sqlsrv_query($conn_sqlsrv, $sql);
        $row = sqlsrv_fetch_array($query);
        $idCustomer = $row["max"] + 1;

        $sql1 = "SELECT max(IdCustomer) as max From LINK.webshop.dbo.tbl_customer";
        $query1= sqlsrv_query($conn_sqlsrv, $sql1 );
        $row1 = sqlsrv_fetch_array($query1);
        $idCustomer2 = $row1["max"] + 1; // id khach hang site 2

        if($idCustomer < $idCustomer2){
            $idCustomer = $idCustomer2;
        }
        
        $sql="INSERT INTO tbl_customer (IdCustomer, Username, Pass, NameCustomer, Email, Address, Phone) VALUES ('$idCustomer ',  '$user', '$pass', N'$name', '$email', N'$addr', '$phone')";
        $query = sqlsrv_query($conn_sqlsrv, $sql);
        echo '<script>swal({
            title: "Đăng ký thành công",
            icon: "success",
            button: "OK",
          });</script>';
    }
}

// Update
if (isset($_POST["bt_update"])){
    $email = $_POST["txt_email"];
    $name = $_POST["txt_name"];
    $phone = $_POST["txt_phone"];
    $addr = $_POST["txt_addr"];
    $idcustomer = $_SESSION["idcustomer"]; 
    $sql0 = "SELECT * FROM tbl_customer WHERE IdCustomer = '$idcustomer'";
    $query0 = sqlsrv_query($conn_sqlsrv, $sql0);
    $row = sqlsrv_fetch_array($query0);
    $sql= "SELECT COUNT(*) FROM tbl_customer WHERE Email=N'$email'";
    $query = sqlsrv_query($conn_sqlsrv, $sql);
    if (sqlsrv_fetch_array($query) >= 1 && $email != $row['Email']){
        echo '<script>swal({
            title: "Email đã tồn tại",
            icon: "warning",
            button: "OK",
          });</script>';
    } else {
        $sql = "UPDATE tbl_customer SET Email='$email', NameCustomer=N'$name', Address=N'$addr', Phone='$phone' WHERE IdCustomer='$idcustomer'";
        $query = sqlsrv_query($conn_sqlsrv, $sql);
        echo '<script>swal({
            title: "Cập nhật thành công",
            icon: "success",
            button: "OK",
          });</script>';
    }
}

// Change password
if (isset($_POST["bt_updatePass"])){
    $oldpass = md5($_POST["txt_old_pass_dk"]);
    $newPass = md5($_POST["txt_new_pass_dk"]);
    $confirmPass = md5($_POST["txt_confirm_pass_dk"]);
    $idcustomer = $_SESSION["idcustomer"]; 
    $sql= "SELECT * FROM tbl_customer WHERE IdCustomer='$idcustomer'";
    $query = sqlsrv_query($conn_sqlsrv, $sql);
    $row = sqlsrv_fetch_array($query);
    if ($row['Pass'] == $oldpass && $newPass == $confirmPass) {
        $sql1 = "UPDATE tbl_customer SET Pass='$newPass' WHERE IdCustomer='$idcustomer'";
        $query1 = sqlsrv_query($conn_sqlsrv, $sql1);
        echo '<script>swal({
            title: "Cập nhật thành công",
            icon: "success",
            button: "OK",
          });</script>';
    } else {
        echo '<script>swal({
            title: "Mật khẩu không hợp lệ",
            icon: "warning",
            button: "OK",
          });</script>';
    }
}

?>

<div id="form">
    <div class="form_dangnhap ">
        <h2 style="text-align: center; margin-bottom: 25px">Đăng nhập</h2>
        <div class="thoat glyphicon glyphicon-remove "></div>
        <form method="post" data-toggle="validator" role="form">
            <!-- form start -->
            <div class="form-group" style="position: relative;">
                <label for="inputName" class="control-label">Username:</label>
                <input type="text" class="form-control" id="inputName" name="txt_user" placeholder="Nhập tài khoản..." required>
                <span class="glyphicon glyphicon-user" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group">
                <label for="inputPassword" class="control-label">Password:</label>
                    <input type="password" data-minlength="8" class="form-control" id="inputPassword" name="txt_pass" placeholder="Nhập mật khẩu..." required style="">
                    <span class="glyphicon glyphicon-lock" style="font-size: 12px;color: #c5b9b9;position: absolute;top: 9px;"></span>
                <div class="form-group">
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> Nhớ mật khẩu
                    </label>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-block" name="bt_dangnhap">Đăng nhập</button>
                </div>
                <p>Bạn chưa có tài khoản: <span class="glyphicon glyphicon-share-alt" style="margin-left: 8px;
      font-size: 20px;"></span><span id="click_dangky" style="color: #83ff00; font-size: 20px; cursor: pointer; margin-left: 10px; text-decoration: none; font-style: italic;">Đăng ký tại đây</span></p>
            </div>
        </form>
        <!-- form-begin -->
    </div>

    <div class="form_dangky">
        <div class="thoat glyphicon glyphicon-remove "></div>
        <h2 style="text-align: center; margin-bottom: 25px;">Đăng ký</h2>
        <form method="post">
            <div class="form-group" style="position: relative;">
                <label for="Username">Username:</label>
                <input type="text" class="form-control" id="txt_user_dk" placeholder="Nhập tên tài khoản..." name="txt_user_dk">
                <span class="label label-danger pull-right" id="lb_user"></span>
                <span class="glyphicon glyphicon-user" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" id="txt_pass_dk" placeholder="Nhập mật khẩu..." name="txt_pass_dk">
                <span class="label label-danger pull-right" id="lb_pass"></span>
                <span class="glyphicon glyphicon-lock" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="txt_email" placeholder="Nhập Email..." name="txt_email">
                <span class="label label-danger pull-right" id="lb_email"></span>
                <span class="glyphicon glyphicon-envelope" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="Email">Tên:</label>
                <input type="text" class="form-control" placeholder="Nhập tên của bạn..." name="txt_name">
                <span class="label label-danger pull-right" id="lb_name"></span>
                <span class="glyphicon glyphicon-envelope" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="Email">Số điện thoại:</label>
                <input type="text" class="form-control" placeholder="Nhập số điện thoại của bạn..." name="txt_phone">
                <span class="label label-danger pull-right" id="lb_phone"></span>
                <span class="glyphicon glyphicon-envelope" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="Email">Địa chỉ:</label>
                <input type="text" class="form-control" placeholder="Nhập địa chỉ của bạn..." name="txt_addr">
                <span class="label label-danger pull-right" id="lb_addr"></span>
                <span class="glyphicon glyphicon-envelope" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <button type="submit" class="btn btn-block" name="bt_dangky">Đăng ký</button>
        </form>
    </div>

    <div class="form_update">
        <?php
            $idCustomer = $_SESSION["idcustomer"];
            $sql = "SELECT * FROM tbl_customer WHERE IdCustomer = '$idCustomer'";
            $query = sqlsrv_query($conn_sqlsrv, $sql);
            $row = sqlsrv_fetch_array($query);
        ?>
        <div class="thoat glyphicon glyphicon-remove "></div>
        <h3 style="text-align: center">Thay đổi thông tin</h3>
        <form method="post">
            <div class="form-group" style="position: relative;">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" id="txt_email" placeholder="Nhập Email..." name="txt_email" value="<?php echo $row['Email'] ?>">
                <span class="label label-danger pull-right" id="lb_email"></span>
                <span class="glyphicon glyphicon-envelope" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="Email">Tên:</label>
                <input type="text" class="form-control" placeholder="Nhập tên của bạn..." name="txt_name" value="<?php echo $row['NameCustomer'] ?>">
                <span class="label label-danger pull-right" id="lb_name"></span>
                <span class="glyphicon glyphicon-envelope" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="Email">Số điện thoại:</label>
                <input type="text" class="form-control" placeholder="Nhập số điện thoại của bạn..." name="txt_phone" value="<?php echo $row['Phone'] ?>">
                <span class="label label-danger pull-right" id="lb_phone"></span>
                <span class="glyphicon glyphicon-envelope" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="Email">Địa chỉ:</label>
                <input type="text" class="form-control" placeholder="Nhập địa chỉ của bạn..." name="txt_addr" value="<?php echo $row['Address'] ?>">
                <span class="label label-danger pull-right" id="lb_addr"></span>
                <span class="glyphicon glyphicon-envelope" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <button type="submit" class="btn btn-block" name="bt_update">Lưu</button>
            <p style="text-align: center; margin-top: 20px"><span class="glyphicon glyphicon-share-alt" style="font-size: 20px;"></span><span id="changePass" style="color: #83ff00; font-size: 20px; cursor: pointer; margin-left: 10px; text-decoration: none; font-style: italic;">Thay đổi mật khẩu</span></p>
        </form>
    </div>

    <div class="form_changepass">
        <div class="thoat glyphicon glyphicon-remove "></div>
        <h3 style="text-align: center">Thay đổi mật khẩu</h3>
        <form method="post">
            <div class="form-group" style="position: relative;">
                <label for="pwd">Old Password:</label>
                <input type="password" class="form-control" id="txt_old_pass_dk" placeholder="Nhập mật khẩu hiện tại..." name="txt_old_pass_dk">
                <span class="label label-danger pull-right" id="lb_pass"></span>
                <span class="glyphicon glyphicon-lock" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="pwd">New Password:</label>
                <input type="password" class="form-control" id="txt_new_pass_dk" placeholder="Nhập mật khẩu mới..." name="txt_new_pass_dk">
                <span class="label label-danger pull-right" id="lb_pass"></span>
                <span class="glyphicon glyphicon-lock" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <div class="form-group" style="position: relative;">
                <label for="pwd">Re-type Password:</label>
                <input type="password" class="form-control" id="txt_confirm_pass_dk" placeholder="Nhập lại mật khẩu..." name="txt_confirm_pass_dk">
                <span class="label label-danger pull-right" id="lb_pass"></span>
                <span class="glyphicon glyphicon-lock" style="font-size: 12px;font-weight: bold;position: absolute;top: 36px;color: #c5b9b9;"></span>
            </div>
            <button type="submit" class="btn btn-block" name="bt_updatePass">Lưu</button>
        </form>
    </div>
