<?php
// MySQL 데이터베이스 연결 정보
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login_db";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("연결 실패: " . $conn->connect_error);
}

// 폼에서 입력된 데이터 가져오기
$user = $_POST['username'];
$pass = $_POST['password'];

// 사용자 이름 중복 확인
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "회원가입 실패: 이미 존재하는 사용자 이름입니다.";
    // register.php로 이동하는 버튼
    echo '<br><br><form action="register.php" method="GET">
    <button type="submit">다시</button>
    </form>';
} else {
    // 비밀번호 암호화
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // 새로운 사용자 정보 삽입
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $hashed_password);

    if ($stmt->execute()) {
        echo "회원가입 성공! 환영합니다, " . htmlspecialchars($user) . "!";
        // login.php로 이동하는 버튼을 추가
        echo '<br><br><form action="login.php" method="GET">
        <button type="submit">로그인</button>
        </form>';
    } else {
        echo "회원가입 실패: 데이터베이스 오류가 발생했습니다.";
        // 로그인 페이지로 이동하는 버튼을 추가
        echo '<br><br><form action="register.php" method="GET">
        <button type="submit">다시</button>
        </form>';
    }
}

// 연결 종료
$conn->close();
?>

