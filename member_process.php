<?php
    require_once('db.php');

    switch ($_GET['mode']){
        case 'register':
            $id = $_POST['id'];
            $userid = $_POST['userid'];
            $pw1 = $_POST['pw1'];
            $pw2 = $_POST['pw2'];
            $name = $_POST['name'];
            $sex = $_POST['sex'];
            $tel = $_POST['tel'];
            $email = $_POST['email'];
            
            $sql = $db->prepare('INSERT INTO register (id, userid, pw, name, sex, tel, email, redate) VALUES (:id, :userid, :pw, :name, :sex, :tel, :email, now())');

            $sql->bindParam(':id', $id);
            $sql->bindParam(':userid', $userid);
            $sql->bindParam(':pw', $pw1);
            $sql->bindParam(':name', $name);
            $sql->bindParam(':sex', $sex);
            $sql->bindParam(':tel', $tel);
            $sql->bindParam(':email', $email);

            $sql->execute();
            
            break;
    }
?>
