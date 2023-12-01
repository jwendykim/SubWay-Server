<?php
    // Check if form fields are set
    if(isset($_POST['user_id'], $_POST['user_pw'])) {
        $user_id = $_POST['user_id'];
        $user_pw = $_POST['user_pw'];

        // Database connection
        $conn = mysqli_connect('localhost', 'root', 'root', 'subway');

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM customer WHERE loginID=? AND loginpassword=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $user_id, $user_pw);
        mysqli_stmt_execute($stmt);

        $res = mysqli_fetch_array(mysqli_stmt_get_result($stmt));

        // Check if the query was successful
        if ($res) {
            session_start();
            $_SESSION['user_id'] = $res['login_id'];
            $_SESSION['user_name'] = $res['name'];
            echo "<script>alert('로그인에 성공했습니다!');";
            echo "window.location.replace('home.php');</script>";
            exit;
        } else {
            echo "<script>alert('아이디 혹은 비밀번호가 잘못되었습니다.');";
            echo "window.location.replace('login.php');</script>";
        }

        // Close statement and connection
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
        echo "Form fields not set.";
    }
?>
<meta http-equiv="refresh" content="0;url=home.php">
