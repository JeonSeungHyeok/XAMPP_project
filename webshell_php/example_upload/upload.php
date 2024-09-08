<?
    header("Content-Type: text/html; charset=UTF-8");
    if(empty($_FILES["userfile"]["name"])) {
        echo "<script>alert('파일을 업로드 하세요');history.back(-1);</script>";
        exit();
    }
    $path = "./upload/";
    $filename = $_FILES["userfile"]["name"];

    if(!move_uploaded_file($_FILES["userfile"]["tmp_name"], $path.$filename)) {
        echo "<script>alert('파일 업로드에 실패하였습니다.');history.back(-1);</script>";
        exit();
    }
?>

<li>업로드 성공: <?=$path.$filename?></li>