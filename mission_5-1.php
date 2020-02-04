<html>
	<head>
		<meta charset = "UTF-8">
		<lang="ja">
		<title>WEB掲示板</title>
	</head>
	
	
	<body>
	<h1>旅行で行きたい場所はどこですか？</h1>
	例：草津温泉、沖縄、ハワイなど
	<br>


	<?php
	//データベースに接続
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password =  'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//テーブル作成
	$sql = "CREATE TABLE IF NOT EXISTS bbs2"
	."("
	."num INT AUTO_INCREMENT PRIMARY KEY,"//numが主キー
	."name char(32),"
	."comment TEXT,"
	."date DATETIME,"//DATETIMEのデータ型は日付、時間
	."password char(32)"
	.");";
	$stmt = $pdo->query($sql);
	?>
	
	<?php
	//編集したい投稿を入力フォームに表示
	
	if(!empty($_POST['editnum']) and !empty($_POST['editpass'])){
	//編集番号、編集パスワードに入力されている時
		
		$sql = 'SELECT * FROM bbs2';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		//データを取得
		
		foreach($results as $row){
			
			if($_POST['editnum'] == $row['num'] and $_POST['editpass'] == $row['password']){
			//パスワードが合致している時
				$editnum = $row['num'];
				$editname = $row['name'];
				$editcomment = $row['comment'];
				//$edit_に配列の中身を代入
				
			} elseif($_POST['editnum'] == $row['num'] and $_POST['editpass'] != $row['password']){
			//パスワードが合致していない時
				$editnum = "";
			 	$editname = "";
			 	$editcomment = "";
			 	//edit_には何も入れない
			 	echo "<br>パスワードが異なるため、編集できません<br>";
			 	
			 } else{
			 }
		}
	} else{
	}
		
	?>
	
	<br>
	【　投稿フォーム　】
	<br>
	<form action = "mission_5-1.php" method="post">
	<input type = "hidden" name = 'editnum' value = "<?php if(!empty($_POST['editnum']) and !empty($_POST['editpass'])){ echo $editnum;}?>">
	名前：　　　<input type = "text" name = 'name' value = "<?php if(!empty($_POST['editnum']) and !empty($_POST['editpass'])){ echo $editname;}?>" size = "40" placeholder = "名前を入力してください">
	<br>
	コメント：　<input type = "text" name = 'comment' value ="<?php if(!empty($_POST['editnum']) and !empty($_POST['editpass'])){ echo $editcomment;}?>" size="40" placeholder = "コメントを入力してください">
	<br>
	パスワード：<input type = "text" name = 'password' value ="" size = "40" placeholder = "パスワードを入力してください">
	<br>
	<input type = "submit" value= "送信">
	</form>
	<br>	

	【　削除フォーム　】
	<br>
	<form action = "mission_5-1.php" method = "post">
	投稿番号：　<input type = "text" name = 'delatenum' value = "" size = "40" placeholder = "削除する投稿番号を入力してください">
	<br>
	パスワード：<input type = "text" name = 'delatepass' value ="" size = "40" placeholder = "パスワードを入力してください">
	<br>
	<input type = "submit" value = "削除">
	</form>
	<br>
	
	【　編集フォーム　】
	<br>
	<form action = "mission_5-1.php" method = "post">
	投稿番号：　<input type = "text" name = 'editnum' value = "" size = "40" placeholder = "編集する投稿番号を入力してください">
	<br>
	パスワード：<input type = "text" name = 'editpass' value ="" size = "40" placeholder = "パスワードを入力してください">
	<br>
	<input type = "submit" value = "編集">
	</form>
	<br>	
	
	<?php
	//新規投稿欄
	if(!empty($_POST['comment']) and !empty($_POST['name']) and empty($_POST['editnum']) and !empty($_POST['password'])){
	//名前、コメント、パスワードが全て記入されていて、編集番号が空の時
	
		//作成したテーブルにinsertによって文字列を入力
		$sql = $pdo -> prepare("INSERT INTO bbs2 (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
	
		$sql -> bindParam(':name', $name, PDO::PARAM_STR);
		$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
		$sql -> bindParam(':date', $date, PDO::PARAM_STR);
		$sql -> bindParam(':password', $password, PDO::PARAM_STR);
	
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		$date = date('Y/m/d H:i:s');
		$password = $_POST['password'];

		$sql -> execute();
	}
	else{
	}
	?>
	
	<?php
	//削除機能欄
	if(!empty($_POST['delatenum']) and !empty($_POST['delatepass'])){
	//削除番号と削除パスワードが記入されている時
		
		$sql = 'SELECT * FROM bbs2';
		$stmt = $pdo->query($sql);
		$results = $stmt->fetchAll();
		
		foreach($results as $row){
			if($_POST['delatenum'] == $row['num'] and $_POST['delatepass'] == $row['password']){
			//パスワードが合致している時、delateによって削除
				$num = $_POST['delatenum'];
				$sql = 'delete from bbs2 where num=:num';
				$stmt = $pdo->prepare($sql);
				$stmt->bindParam(':num', $num, PDO::PARAM_INT);
				$stmt->execute();
				echo "投稿番号".$num."のコメントは削除されました<br><br>";
				
			} elseif($_POST['delatenum'] == $row['num'] and $_POST['delatepass'] != $row['password']){
			//パスワードが異なる時
				echo "パスワードが異なるため、削除できません<br><br>";
			} else{
			}
		}
	
	} else{
	}
	?>
	
	<?php
	//編集機能
	
	if(!empty($_POST['name']) and !empty($_POST['comment']) and !empty($_POST['editnum']) and !empty($_POST['password'])){
	//編集したい投稿番号、名前、コメント、パスワードが全て記入されている時
		
		$num = $_POST['editnum'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];
		$date = date('Y/m/d H:i:s');
		$password = $_POST['password'];
		
		//updateによって編集
		$sql = 'update bbs2 set name=:name, comment=:comment, date=:date, password=:password where num=:num';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindParam(':date', $date, PDO::PARAM_STR);
		$stmt->bindParam(':password', $password, PDO::PARAM_STR);
		$stmt->bindParam(':num', $num, PDO::PARAM_INT);
		$stmt->execute();
	} else{
	}
	?>
	
	<hr>
	【　投稿一覧　】
	<br>
	<br>

	<?php
	//投稿をフォーム下に表示
	$sql = 'SELECT * FROM bbs2';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	
	foreach($results as $row){
		echo $row['num'].' 名前：';
		echo $row['name'].' ：';
		echo $row['date'].'<br>';
		echo '　　　';
		echo $row['comment'].'<br>';
	}
	
	?>
	</body>
</html>
		
	