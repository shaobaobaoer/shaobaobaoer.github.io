<?php
/**
 * Created by PhpStorm.
 * User: ninthDVEIL HUNSTER
 * Date: 2018/1/24
 * Time: 11:02
 */
define("SECRET_KEY", '***********');
define("METHOD", "aes-128-cbc");
error_reporting(0);
//include('conn.php');
function sqliCheck($str)
{
    if (preg_match("/\\\|,|-|#|=|~|union|like|procedure/i", $str)) {
        return 1;
    }
    return 0;
}

function get_random_iv()
{
    $random_iv = '';
    for ($i = 0; $i < 16; $i++) {
        $random_iv .= chr(rand(1, 255));
    }
    return $random_iv;
}x

function login($info)
{
    $iv = get_random_iv();
    $plain = serialize($info);
    $cipher = openssl_encrypt($plain, METHOD, SECRET_KEY, OPENSSL_RAW_DATA, $iv);
    setcookie("iv", base64_encode($iv));
    setcookie("cipher", base64_encode($cipher));
}

function show_homepage()
{
    global $link;
    if (isset($_COOKIE['cipher']) && isset($_COOKIE['iv'])) {
        $cipher = base64_decode($_COOKIE['cipher']);
        $iv = base64_decode($_COOKIE["iv"]);
        if ($plain = openssl_decrypt($cipher, METHOD, SECRET_KEY, OPENSSL_RAW_DATA, $iv)) {
            $info = unserialize($plain) or die("base64_decode('" . base64_encode($plain) . "') can't unserialize");
            $sql = "select * from users limit " . $info['id'] . ",0";
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) > 0 or die(mysqli_error($link))) {
                $rows = mysqli_fetch_array($result);
                echo 'Hello!' . $rows['username'] . '';
            } else {echo "Hello!";}
        } else {
            die("ERROR!");
        }
    }
}

if (isset($_POST['id'])) {
    $id = (string)$_POST['id'];
    if (sqliCheck($id)) die("sql inject detected!");
    $info = array('id' => $id);
    login($info);
    echo 'Hello!';
} else {
    if (isset($_COOKIE["iv"]) && isset($_COOKIE['cipher'])) {
        show_homepage();
    } else {
        echo "login";
    }

}

?>