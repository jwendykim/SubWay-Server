<?php
@session_start();

$connect = mysqli_connect("127.0.0.1", "root", "root", "subway");

// 로그인 창에서 POST로 보낸 ID와 password 받기
$loginID = $_POST['loginID'];
$loginpassword = $_POST['loginpassword'];

$query = "SELECT loginpassword, custname FROM customer WHERE loginID=?";
$stmt = mysqli_prepare($connect, $query);
mysqli_stmt_bind_param($stmt, "s", $loginID);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

// result에 1줄이 있다면 내가 입력한 아이디와 같은 애가 데이터베이스 ID 칼럼에 하나 존재한다는 의미
if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    $custname = $row['custname'];
    $_SESSION['custname'] = $custname;

    // 비밀번호가 맞는지 검사 -> 데이터베이스에 md5로 암호화해서 저장했으므로 암호화한 게 같은지 봐야합니다.
    if (password_verify($loginpassword, $row['loginpassword'])) {
        $_SESSION['loginID'] = $loginID;
        ?>
        <script>
            alert("로그인에 성공했습니다.");
            location.replace("./login_page.php");
        </script>
        <?php
    } else {
        ?>
        <script>
            alert("아이디 혹은 비밀번호가 잘못되었습니다.");
            history.back();
        </script>
        <?php
    }
} else {
    ?>
    <script>
        alert("아이디 혹은 비밀번호가 잘못되었습니다.");
        history.back();
    </script>
    <?php
}

mysqli_close($connect);
?>
