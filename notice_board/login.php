<!DOCTYPE html>
<html lang="ko">
<head>
    <!--한글 적용-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--브라우저 창 이름-->
    <title>로그인</title>
</head>
<body>
    <h2>PBL_4  JSH의 로그인화면</h2>
    <!--버튼 클릭시, login_process.php페이지로 이동하며 데이터 POST로 젼송-->
    <form action="login_process.php" method="POST">
        <label for="username">이름:</label>
        <!--required : 빈 칸을 무조건 채우게끔 함-->
        <input type="text" id="username" name="username" required><br>

        <label for="password">비밀번호:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">로그인</button>
    </form>
    <form action="register.php" method=GET>
        <button type="submit">회원가입</button>
    </form>
</body>
</html>
