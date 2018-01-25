<?php
/**
 * Created by PhpStorm.
 * User: ninthDVEIL HUNSTER
 * Date: 2018/1/23
 * Time: 16:48
 */

$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = '';          // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if (!$conn) {
    die('Could not connect: ' . mysqli_error($conn));
}

//echo '数据库连接成功！';
mysqli_select_db($conn, "admin");
$password = $_POST['password'];
//echo md5($password);
$sql = "SELECT * FROM admin WHERE username = 'admin' and password = '" . md5($password) . "'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo 'flag is :' . "CTF{}";
} else {
    echo '密码错误!';
}
?>