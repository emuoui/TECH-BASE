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
		//編集したい投稿を入力フォームに表示
		
		if(!empty($_POST['editnum']) and !empty($_POST['editpass'])){
		//編集番号フォーム、パスワードが入力された場合
			
			 $filename = "mission_3-5.txt";
			 $editnum = $_POST['editnum'];
			 $editpass = $_POST['editpass'];
			 $array = file($filename);
			 			 
			 foreach($array as $line){
			 	$separate = explode('<>', $line);
			 	
			 	if($separate[0] == $editnum and $separate[4] == $editpass){
			 	//編集したい投稿番号と一致している配列を取り出し、またそのパスワードと合致している時
			 	
			 		$editnumber = $separate[0];
			 		$editname = $separate[1];
			 		$editcomment = $separate[2];
			 		
			 	}elseif($separate[0] == $editnum and $separate[4] != $editpass){
			 	//パスワードが違う時、何も表示させない
			 	
			 		$editnumber = "";
			 		$editname = "";
			 		$editcomment = "";
			 		echo "パスワードが異なるため、投稿番号".$editnum."のコメントは編集できません<br><br>";
			 		
			 	} else{
			 	}
			 }
		} else{
		}
		?>

			
		<br>
		【　投稿フォーム　】
		<br>
		<form action = "mission_3-5.php" method="post">
		<input type = "hidden" name = 'editnumber' value = "<?php if(!empty($_POST['editnum']) and !empty($_POST['editpass'])){ echo $editnumber;}?>">
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
		<form action = "mission_3-5.php" method = "post">
		投稿番号：　<input type = "text" name = 'delatenum' value = "" size = "40" placeholder = "削除する投稿番号を入力してください">
		<br>
		パスワード：<input type = "text" name = 'delatepass' value ="" size = "40" placeholder = "パスワードを入力してください">
		<br>
		<input type = "submit" value = "削除">
		</form>
		<br>
		
		
		【　編集フォーム　】
		<br>
		<form action = "mission_3-5.php" method = "post">
		投稿番号：　<input type = "text" name = 'editnum' value = "" size = "40" placeholder = "編集する投稿番号を入力してください">
		<br>
		パスワード：<input type = "text" name = 'editpass' value ="" size = "40" placeholder = "パスワードを入力してください">
		<br>
		<input type = "submit" value = "編集">
		</form>
		<br>
		
		
		<?php
		//新規投稿機能欄
		
		if(!empty($_POST['comment']) and !empty($_POST['name']) and empty($_POST['editnumber']) and !empty($_POST['password'])){
		//名前、コメント、パスワード全て記入されていて、編集番号欄が空の時
		
			$filename = "mission_3-5.txt";
		
			$name = $_POST['name'];
			$comment = $_POST['comment'];
			$password = $_POST['password'];
			$date = date('Y/m/d H:i:s');
			//日付時間を出力するための関数はdate
			
			if(file_exists($filename)){
			//投稿番号の設定
			//何らかの投稿がすでにされた時
				
				if(filesize('mission_3-5.txt')==0){
				//１の投稿を削除した時
					$postnumber = 1;
					
				} else{
				//すでに投稿されている時
				
					$array = file($filename);
					foreach($array as $line){
						$separate = explode('<>', $line);
					}
					$postnumber = $separate[0]+1;
				}
				
			} else{
			//何も投稿されていない時
				
				$postnumber = 1;
				//はじめの投稿番号1を指定
			}
				
			$post = $postnumber."<>".$name."<>".$comment."<>".$date."<>".$password."<>";
		
			$fp = fopen($filename, "a");
			fwrite($fp, $post."\n");
			fclose($fp);
		}
		else{
		}
		?>		
		
		
		<?php
		//削除機能欄
		
		if(!empty($_POST['delatenum']) and !empty($_POST['delatepass'])){
		//削除したい番号とパスワードが全て記入されている時
			
			$filename = "mission_3-5.txt";
			$array = file($filename);
			$delatenum = $_POST['delatenum'];
			$delatepass = $_POST['delatepass'];
			
			$fp = fopen($filename,  "w");
			
			foreach($array as $line){
				$separate = explode('<>', $line);
								
				if($separate[0] == $delatenum and $separate[4] == $delatepass){
				//削除したい投稿の配列を取り出し、パスワードが合致している時、削除
				
					echo "投稿番号".$delatenum."のコメントは削除されました。<br>";
					
				} elseif($separate[0] == $delatenum and $separate[4] != $delatepass){
				//パスワードが異なる時、そのまま投稿を書き込む
				
					fwrite($fp, $line);
					echo "パスワードが異なるため、投稿番号".$delatenum."のコメントは削除できませんでした<br><br>";
				
				} else{
				//削除したい投稿以外を書き込む
				
					fwrite($fp,$line);
				}
			}
			fclose($fp);
		} else{
		}
		?>
		
		
		<?php
		//編集処理機能欄
		
		if(!empty($_POST['name']) and !empty($_POST['comment']) and !empty($_POST['editnumber']) and !empty($_POST['password'])){
		//編集したい投稿番号、名前、コメント、パスワードが全て記入されている時
			
			$filename = "mission_3-5.txt";
			$array = file($filename);
			$editnum = $_POST['editnumber'];
			$password = $_POST['password'];
			
			$fp = fopen($filename, "w");
			
			foreach($array as $line){
				$separate = explode('<>', $line);
				
				if($separate[0] != $editnum){
				//編集したい投稿以外を書き込む
				
					fwrite($fp, $line);
				
				} else{
				//投稿を編集する
					
					$redate = date('Y/m/d H:i:s');
					$rename = $_POST['name'];
					$recomment = $_POST['comment'];
					$repass = $_POST['password'];
					
					$repost = $editnum."<>".$rename."<>".$recomment."<>".$redate."<>".$repass."<>";
					
					fwrite($fp, $repost."\n");
					echo "投稿番号".$editnum."のコメントは編集されました。<br>";
				}
			}
			fclose($fp);
		} else{
		}
		
		?>
				
		<hr>
		【　投稿一覧　】
		<br>
		<br>
		
		<?php
		//投稿をフォーム下に表示
		
		if(file_exists('mission_3-5.txt')){
			
				$array = file('mission_3-5.txt');
				foreach($array as $line){
				$separate = explode('<>', $line);
				//$lineに代入されている一列ずつの配列をさらに＜＞で分けて$separateに代入
				echo $separate[0].".　".$separate[1]."「".$separate[2]."」"."　".$separate[3]."<br>";
				}
			}else{
			echo "投稿がまだありません";
		}
		?>
		
	</body>
</html>