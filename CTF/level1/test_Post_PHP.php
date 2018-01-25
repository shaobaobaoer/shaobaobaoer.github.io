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
    die('Could not connect: ' . mysqli_error());
}
//echo '数据库连接成功！';
mysqli_query($conn, "set names utf8");
mysqli_select_db($conn, "test1");
#DVWA LOW 等级的代码
if( isset( $_REQUEST[ 'Submit' ] ) ) {
    // Get input
    $id = $_REQUEST[ 'id' ];
    echo "1";
    // Check database
    $query  = "SELECT id,password FROM userdata WHERE id = '$id';";
    $result = mysqli_query($conn,$query);
    // Get results
    while( $row = mysqli_fetch_assoc( $result ) ) {
                // Feedback for end user
            echo "<pre>ID: {$id}<br /></pre>";
    }
}
?>