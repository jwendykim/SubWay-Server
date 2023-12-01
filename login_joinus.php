

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8"> 
<title>Login and Join us</title>

</head>
<body>
<form name="test1" method="POST"> 
 <h1>Test</h1>
 <input type="button" value="LOGIN" onclick="sub(1)"> //로그인 버튼을 누르면 sub(1)함수 실행
 <input type="button" value="JOINUS" onclick="sub(2)"> //JOINUS 버튼을 누르면 sub(2)함수 실행
</form>

  <script = "text/javascript">
        function sub(index){
		if(index == 1){
			document.test1.action="login_page.php"; //sub(1)은 로그인 기능을 하는 php로 연결
		}
		if(index == 2){
			document.test1.action="register.html"; //sub(2)은 회원가입 기능을 하는 php로 연결
		}
		document.test1.submit();
		
	}
  </script>

</body>
</html>