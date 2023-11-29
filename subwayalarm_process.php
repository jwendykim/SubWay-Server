<?php
// 데이터베이스 연결 정보
$host = 'localhost';
$db_name = 'subway';
$username = 'root';
$password = 'root';

// 사용자 입력 값 가져오기
$currentStation = $_POST['currentStation'];
$destinationStation = $_POST['destinationStation'];

// 고객 ID (예시: 회원 가입 시에 부여된 custid)
$custid = 1;

// 데이터베이스 연결
$conn = new mysqli($host, $username, $password, $db_name);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$query = "SELECT 
    CASE 
        WHEN s1_min.first_subwayid < s2_min.first_subwayid THEN s1_min.first_subwayid 
        ELSE s1_min.second_subwayid 
    END AS currentSubwayId, 
    CASE 
        WHEN s1_min.first_subwayid < s2_min.first_subwayid THEN s2_min.first_subwayid 
        ELSE s2_min.second_subwayid 
    END AS destinationSubwayId 
FROM 
    (SELECT 
         subwayid AS first_subwayid,
         (SELECT subwayid
          FROM subway
          WHERE subwayname = ?
          ORDER BY subwayid ASC
          LIMIT 1 OFFSET 1) AS second_subwayid
     FROM subway
     WHERE subwayname = ?
     ORDER BY subwayid ASC
     LIMIT 1) s1_min
JOIN
    (SELECT 
         subwayid AS first_subwayid,
         (SELECT subwayid
          FROM subway
          WHERE subwayname = ?
          ORDER BY subwayid ASC
          LIMIT 1 OFFSET 1) AS second_subwayid
     FROM subway
     WHERE subwayname = ?
     ORDER BY subwayid ASC
     LIMIT 1) s2_min
ON 1 = 1"; // Using JOIN to ensure both subqueries are always executed

$stmt = $conn->prepare($query);
$stmt->bind_param("ssss", $currentStation, $currentStation, $destinationStation, $destinationStation);
$stmt->execute();
$stmt->bind_result($currentSubwayId, $destinationSubwayId);
$stmt->fetch();


// Close the result set before preparing the next statements
$stmt->close();

// boarding 테이블에 레코드 추가
$insert_boarding_query = "INSERT INTO boarding (custid, subwayid,boardsubway) VALUES (?, ?, ?)";
$stmt_insert_boarding = $conn->prepare($insert_boarding_query);
$stmt_insert_boarding->bind_param("iis", $custid, $currentSubwayId,$currentStation);

$stmt_insert_boarding->execute();
$stmt_insert_boarding->close();

// getoff 테이블에 레코드 추가
$insert_getoff_query = "INSERT INTO getoff (custid, subwayid,getsubway) VALUES (?, ?, ?)";
$stmt_insert_getoff = $conn->prepare($insert_getoff_query);
$stmt_insert_getoff->bind_param("iis", $custid, $destinationSubwayId,$destinationStation);

$stmt_insert_getoff->execute();
$stmt_insert_getoff->close();

$time_query = "SELECT SUM(s.time) as total_time
FROM subway s
WHERE s.subwayid > (
    SELECT MIN(subwayid)
    FROM boarding
    WHERE custid = 1
) AND s.subwayid <= (
    SELECT MAX(subwayid)
    FROM getoff
    WHERE custid = 1
)";

// No need for bind_param in this query
$stmt_time = $conn->prepare($time_query);

// Execute the query directly
$stmt_time->execute();

$stmt_time->bind_result($total_time);
$stmt_time->fetch();

$stmt_time->close();

echo "<html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Subway Time</title>
        </head>
        <body>
            <h1>Subway Time</h1>
            <p>Total Time: $total_time minutes</p>
	    <p>Debug: Total Time Variable: " . $total_time . "</p>
        </body>
      </html>";

// Set SQL_SAFE_UPDATES to 0
$conn->query("SET SQL_SAFE_UPDATES = 0");

// Delete records from 'getoff' and 'boarding' tables
$conn->query("DELETE FROM subway.getoff");
$conn->query("DELETE FROM subway.boarding");

// 연결 종료
$conn->close();
?>

