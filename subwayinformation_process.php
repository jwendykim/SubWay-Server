<?php
// 사용자로부터 도착역을 입력받습니다.
$destinationStation = isset($_POST['destinationStation']) ? $_POST['destinationStation'] : "";

$servername = "localhost";
$username = "root";  // 사용자명
$password = "root";  // 비밀번호
$dbname = "subway";

// 데이터베이스 연결 생성
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 문자 인코딩 설정 추가
$conn->set_charset("utf8");

// 쿼리 작성
$query = "SELECT
    subway.toilet,
    subway.subwayid,
    subway.subwayname,
    subway.direction,
    subway.descending,
    GROUP_CONCAT(fastexit.exitnumber) AS exitnumbers,
    subway.first,
    subway.last
FROM
    fastexit
JOIN
    subway ON fastexit.subwayid = subway.subwayid
WHERE
    subway.subwayname = ?
GROUP BY
    subway.subwayid;";

// 쿼리 실행
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $destinationStation);
$stmt->execute();

// 에러 핸들링
if ($stmt->errno) {
    die("Query execution failed: " . $stmt->error);
}

$stmt->bind_result($toilet, $subwayid, $subwayname, $direction, $descending, $exitnumbers, $first, $last);

// 결과 배열 생성
$resultArray = array();

while ($stmt->fetch()) {
    // 결과를 배열에 저장
    $resultArray[] = array(
        "subwayname" => $subwayname,
        "direction" => $direction,
        "descending" => $descending,
        "toilet" => $toilet,
        "exitnumbers" => explode(",", $exitnumbers),
        "first" => $first,
        "last" => $last
    );
}

// 연결 종료
$stmt->close();
$conn->close();

// 결과를 JSON 형식으로 출력
echo json_encode($resultArray);
?>
