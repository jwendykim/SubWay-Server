<?php
@session_start();
 
if (isset($_SESSION['loginID'])) {	
    echo $_SESSION['loginID'];?>님 안녕하세요
    <br/>
    <input type="submit" value="LOGOUT" onclick='location.replace("./logout_action.php")'>
<?php
} else { 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
    <title>Join Us</title>
</head>
<body>
    <form name="login" method="post" action='login_action.php'>
        <h1>LOGIN</h1>
        <table border="1">
            <tr>
                <td>ID</td>
                <td><input type="text" size="30" name="loginID"></td>
            </tr>
            <tr>
                <td>PASSWORD</td>
                <td><input type="password" size="30" name="loginpassword"></td>
            </tr>
        </table>
        <input type="submit" value="LOGIN"><input type="reset" value="REWRITE">
    </form>
    <br />
</body>
</html>
