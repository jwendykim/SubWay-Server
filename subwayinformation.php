<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subway Information</title>
</head>
<body>
    <h2>Subway Information</h2>
    
    <!-- Remove the startStation input -->
    
    <label for="destinationStation">도착역:</label>
    <input type="text" id="destinationStation" placeholder="도착역 이름"><br>

    <label for="direction">방향:</label>
    <button onclick="setDirection('상행')">상행</button>
    <button onclick="setDirection('하행')">하행</button>
    <input type="hidden" id="direction" name="direction" value=""><br>

    <button onclick="getSubwayInformation()">조회하기</button>

    <div id="result"></div>

    <script>
        function setDirection(directionValue) {
            document.getElementById("direction").value = directionValue;
        }

        function getSubwayInformation() {
            // Remove the startStation variable
            var destinationStation = document.getElementById("destinationStation").value;
            var direction = document.getElementById("direction").value;

            // Check if direction is selected
            if (direction === "") {
                alert("방향을 선택하세요.");
                return;
            }

            // AJAX를 사용하여 서버로 데이터를 전송
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "subwayinformation_process.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // 서버에서 받은 JSON 데이터를 파싱
                    var resultArray = JSON.parse(xhr.responseText);

                    // 결과를 HTML로 표시
                    var resultHtml = "";
                    for (var i = 0; i < resultArray.length; i++) {
                        // Check if the direction matches the selected direction
                        if (resultArray[i].direction === direction) {
                            resultHtml += "<p>도착역: " + resultArray[i].subwayname + "</p>";
                            resultHtml += "<p>방향: " + resultArray[i].direction + "</p>";
                            resultHtml += "<p>하차 방향: " + resultArray[i].descending + "</p>";
                            resultHtml += "<p>화장실 유무: " + resultArray[i].toilet + "</p>";

                            // Display all exit numbers
                            resultHtml += "<p>빠른 하차 정보:</p>";
                            if (resultArray[i].exitnumbers && resultArray[i].exitnumbers.length > 0) {
                                resultHtml += "<ul>";
                                for (var j = 0; j < resultArray[i].exitnumbers.length; j++) {
                                    resultHtml += "<li>" + resultArray[i].exitnumbers[j] + "</li>";
                                }
                                resultHtml += "</ul>";
                            } else {
                                resultHtml += "<p>하차 정보가 없습니다.</p>";
                            }

                            resultHtml += "<p>첫차 정보: " + resultArray[i].first + "</p>";
                            resultHtml += "<p>막차 정보: " + resultArray[i].last + "</p>";
                            resultHtml += "<hr>";
                        }
                    }

                    // 결과를 출력
                    document.getElementById("result").innerHTML = resultHtml;
                }
            };

            // 서버로 보낼 데이터 구성
            var data = "destinationStation=" + encodeURIComponent(destinationStation) +
                "&direction=" + encodeURIComponent(direction);

            // 데이터 전송
            xhr.send(data);
        }
    </script>
</body>
</html>
