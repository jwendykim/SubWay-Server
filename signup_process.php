<?php
require_once('dbb.php');

switch ($_GET['mode']) {
    case 'register':
        $custname = $_POST['name'];
        $custphone = $_POST['tel'];
        $loginID = $_POST['userid'];
        $loginpassword = $_POST['pw1'];

        // 이제 customer 테이블에 데이터를 삽입하는 SQL 쿼리를 작성합니다.
        $sql = $db->prepare('INSERT INTO customer (custname, custphone, loginID, loginpassword) VALUES (:custname, :custphone, :loginID, :loginpassword)');

        $sql->bindParam(':custname', $custname);
        $sql->bindParam(':custphone', $custphone);
        $sql->bindParam(':loginID', $loginID);
        $sql->bindParam(':loginpassword', $loginpassword);

        // SQL 쿼리를 실행합니다.
        $sql->execute();

        // 등록이 성공하면 다른 작업을 수행할 수 있습니다.

        break;
}
?>

