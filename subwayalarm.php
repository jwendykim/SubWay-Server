    <section>
        <div class="mainCon">
            <div class="alarmTitle">지하철 알림 설정</div>
            <div class="alarmBox">
                <form action="subwayalarm_process.php" method="post">
                    <!-- 현재 역 입력 -->
                    <label for="currentStation">현재 역 입력:</label>
                    <input type="text" id="currentStation" name="currentStation" required>

                    <!-- 도착 역 입력 -->
                    <label for="destinationStation">도착 역 입력:</label>
                    <input type="text" id="destinationStation" name="destinationStation" required>

                    <!-- 알림 설정 버튼 -->
                    <input type="submit" value="알림 설정"></input>
                </form>
            </div>
        </div>
    </section>