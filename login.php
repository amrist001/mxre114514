<?php
session_start(); // 开始会话

// 连接数据库
$server = 'localhost';
$username = 'f12841bb';
$password = 'BgX5m7Z1Hhs8AL2f';
$database = 'f12841bb';

// 创建连接
$conn = new mysqli($server, $username, $password, $database);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 接收表单数据
$username = $_POST['username'];
$password = $_POST['password'];

// 防止SQL注入，密码加密
$safeusername = $conn->real_escape_string($username);
$safepassword = $conn->real_escape_string(password_hash($password, PASSWORD_DEFAULT));

// 查询用户信息
$sql = "SELECT password FROM users WHERE username = '$safeusername'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出每行数据的pass内容
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // 密码匹配，登录成功
        $_SESSION['username'] = $username; // 存储用户信息到会话
        header("Location: welcome.php"); // 跳转到欢迎页面
    } else {
        echo "密码错误！";
    }
} else {
    echo "用户名不存在！";
}

$conn->close();
?>