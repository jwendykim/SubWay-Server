<?php

        $destinationStation = $_GET['destinationStation'];
        $direction=$_GET['direction'];

      //  $output=array();
  //    echo 'My name is: '.$direction;
  //  <button onclick='getSubwayInformation()'>조회하기</button>
  echo "<html lang='en'>
<?php  header('Content-Type: application/json');/>
<body>

      <div id='result'></div>

<script type='text/javascript'>


        function getSubwayInformation() {
 var output = {};
            var destinationStation = '{$destinationStation}';
              var direction = '{$direction}; ?>';


            // Check if direction is selected
            if ('{$direction}' === '') {

                return;
            }

            // AJAX를 사용하여 서버로 데이터를 전송
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'subwayinformation_process.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {

                if (xhr.readyState == 4 && xhr.status == 200) {
                    // 서버에서 받은 JSON 데이터를 파싱
                    var resultArray = JSON.parse(xhr.responseText);

                    // 결과를 HTML로 표시
                    var resultHtml = '';
                    for (var i = 0; i < resultArray.length; i++) {
                        // Check if the direction matches the selected direction
                        if (resultArray[i].direction === '{$direction}') {
                           output['response']='true';
                           output['dochakyeo']=resultArray[i].subwayname;
                           output['direction']=resultArray[i].direction;
                           output['hachabanghyang']=resultArray[i].descending;
                           output['hwajangsilyumu']=resultArray[i].toilet;


                         if (resultArray[i].exitnumbers && resultArray[i].exitnumbers.length > 0) {

                              for (var j = 0; j < resultArray[i].exitnumbers.length; j++) {
                                output['hachajungbo']=resultArray[i].exitnumbers[j];

                              }

                          } else {
                            output['hachajungbo']='noinfo';

                          }
                            output['chutcha']=resultArray[i].first;
                        output['makcha']=resultArray[i].last;

                          document.getElementById('result').textContent = JSON.stringify(output)

                            // Display all exit numbers


                        }
                    }


                }
            };

            // 서버로 보낼 데이터 구성
            var data = 'destinationStation=' + encodeURIComponent(destinationStation) +
                '&direction=' + encodeURIComponent(direction);

            // 데이터 전송
            xhr.send(data);
        }
        getSubwayInformation()
    </script></body></html>";

?>
