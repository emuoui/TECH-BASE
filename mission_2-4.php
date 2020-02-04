<html>
	<head>
		<meta charset = "UTF-8">
		<lang="ja">
		<title>投稿フォーム</title>
	</head>
	
	
	<body>
		<form action="mission_2-4.php" method="post">
	
<!-- actionは「どこに」、つまりデータを受け取るプログラムを指定する
methodは「どうやって」、つまりデータの送信方法を指定する
getではデータがURLで引き渡され、postではURLで引き渡されないという違いがある -->
		
			<input type = "text" name = 'comment' value="" size="50" placeholder = "コメント">
			<input type="submit" value= "送信">
		</form>
		
		
<?php
if(!empty($_POST['comment'])){
$comment = $_POST['comment'];
	if($comment=="完成！ by 内沼萌"){
	echo "おめでとう！<br>";
	} else{
	echo "「".$comment."」を受け付けました。<br>";
	}	

$filename = "mission_2-4.txt";
$fp = fopen($filename, "a");
fwrite($fp, $comment."\n");
fclose($fp);
}

else{
}

$array = file('mission_2-4.txt');

foreach($array as $line){
echo $line."<br>";
}

?>
	
	</body>
</html>