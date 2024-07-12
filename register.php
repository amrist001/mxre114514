<?php
// 数据库配置信息
$servername = "localhost";
$username = "your_username";
$password = "your_password";
$dbname = "your_database";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

// 检测表单是否被提交
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 获取表单数据
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $email = $conn->real_escape_string($_POST['email']);

    // 验证数据
    if (empty($username) || empty($password) || empty($email)) {
        die("请填写所有字段！");
    }

    // 密码加密
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // 插入数据到数据库
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";

    // 预处理语句
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashed_password, $email);

    // 执行语句
    if ($stmt->execute()) {
        echo "新记录插入成功";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // 关闭语句和连接
    $stmt->close();
    $conn->close();
} else {
    // 如果不是POST请求，重定向回注册表单
    header('Location: register.html');
    exit();
}

?>