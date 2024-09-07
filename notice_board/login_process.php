<?php
$servername = "127.0.0.1";   // 루프백, 자기자신 IP
$username = "root";          // MySQL ID = root
$password = "";              // MySQL PW = 없음
$dbname = "login_db";        // DB table 이름

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// login.php에서 입력된 데이터 가져오기
// form의 name의 이름과 일치해야 함
$user = $_POST['username'];
$pass = $_POST['password'];

// SQL query: 사용자 이름에 해당하는 비밀번호 가져오기
// ? : 나중에 값으로 바인딩될 부분 지정
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user); // 타입 지정 (s:문자열, i:정수, d:실수, b:바이너리)
$stmt->execute();
$result = $stmt->get_result();

// 사용자 정보 확인
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc(); // query의 결과값 가져옴

    // 입력된 비밀번호와 저장된 해시된 비밀번호를 비교
    if (password_verify($pass, $row['password'])) {
        // htmlspecialchars: XSS 공격방지
        echo "로그인 성공! 환영합니다, " . htmlspecialchars($user) . "!";
    } else {
        echo "로그인 실패: 비밀번호가 올바르지 않습니다.";
    }
} else {
    echo "로그인 실패: 사용자 이름이 존재하지 않습니다.";
}

// 연결 종료
$conn->close();
?>
