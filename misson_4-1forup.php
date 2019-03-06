<!DOCTYPE HTML>
<html lang="ja">
<head>
	<meta charset="UTF-8">
	<title>misson_4-1</title>
</head>
<body>
	<form method = "post" action = "">
	<input type = "text" name = "namae"placeholder="名前">
	<br/>
	<input type = "text" name = "kome" placeholder="コメント">
	<input type = "text" name = "pass" placeholder="編集用パスワード">
	<input type = "submit" value = "投稿">
	<br/>
	</form>

	<form method = "post" action = "">
	<p><input type="text" name="deleteNo" placeholder="削除対象番号">
	<input type = "text" name = "delpass" placeholder="指定したパスワードを入力してください">
	<input type="submit" name="delete" value="削除"></p>
	</form>

	<form method = "post" action = "">
	<p><input type="text" name="editNo" placeholder="編集対象番号">
	<input type = "text" name = "editkome" placeholder = "修正内容">
	<input type = "text" name = "editpass" placeholder="指定したパスワードを入力してください">
	<input type="submit" name="edit" value="編集"></p>
	</form>


<?php

$dsn = '******';
$user = '******';
$password = '*****';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE =>
PDO::ERRMODE_WARNING));

if(!empty($_POST['kome']) && (!empty($_POST['namae']))){

$sql = $pdo -> prepare("INSERT INTO alpha (id, name, comment, postedAt, pass) VALUES (:id, :name, :comment, :postedAt, :pass)");
$sql -> bindParam(':id', $num, PDO::PARAM_INT);
$sql -> bindParam(':name', $name, PDO::PARAM_STR);
$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
$sql -> bindParam(':postedAt', $postedAt, PDO::PARAM_STR);
$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$name = $_POST['namae'];
	$comment = $_POST['kome'];
	$postedAt = date("Y/m/d H:i:s");
	$pass = $_POST['pass'];

$sql -> execute();

$sql1 = 'SELECT * FROM alpha';
$stmt = $pdo->query($sql1);
$results = $stmt->fetchAll();
foreach ($results as $row){
 //$rowの中にはテーブルのカラム名が入る
 echo $row['id'].',';
 echo $row['name'].',';
 echo $row['comment'].',';
 echo $row['postedAt'].'<br>';
			}
}



//削除
if(!empty($_POST['deleteNo'])){

$id = $_POST['deleteNo'];
$delpass = $_POST['delpass'];



$sql2 = 'SELECT pass FROM alpha where id=:id';
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindParam(':id', $id, PDO::PARAM_INT);
$stmt2->execute();
$data = $stmt2->fetchAll();

if($data[0][0] == $delpass){


$comment = "[この投稿は撤回されました]";

$sql = 'update alpha set comment=:comment where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
}

//以下に3-6のselectを用いて表示させる

$sql1 = 'SELECT * FROM alpha';
$stmt1 = $pdo->query($sql1);
$results = $stmt1->fetchAll();
foreach ($results as $row){
 //$rowの中にはテーブルのカラム名が入る
 echo $row['id'].',';
 echo $row['name'].',';
 echo $row['comment'].',';
 echo $row['postedAt'].'<br>';
			}
}



// 編集
if (isset($_POST['editNo'])) {
$id = $_POST['editNo'];
$editpass = $_POST['editpass'];
$editkome = $_POST['editkome'];
$comment = $editkome."(編集済み)";

$sql2 = 'SELECT pass FROM alpha where id=:id';
$stmt2 = $pdo->prepare($sql2);
$stmt2->bindParam(':id', $id, PDO::PARAM_INT);
$stmt2->execute();
$data = $stmt2->fetchAll();

if($data[0][0] == $editpass){

$sql = 'update alpha set comment=:comment where id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
$stmt->execute();
//以下に3-6のselectを用いて表示させる
}

$sql1 = 'SELECT * FROM alpha';
$stmt1 = $pdo->query($sql1);
$results = $stmt1->fetchAll();
foreach ($results as $row){
 //$rowの中にはテーブルのカラム名が入る
 echo $row['id'].',';
 echo $row['name'].',';
 echo $row['comment'].',';
 echo $row['postedAt'].'<br>';
			}
}

?>
</body>
</html>