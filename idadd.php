<?php
try{
	//項目名iphoneidの値を格納
	$iphoneid = $_GET['iphoneid'];
	//データベース名とホスト名の情報を格納
	$dsn =  'mysql:dbname=u551671545_toku;host=mysql.miraiserver.com';
	//データベースのユーザー名
	$usr = 'u551671545_toku';
	//データベースのパスワード
	$password ='bizan07';
	//データベース名とホスト名の情報を格納
	$dbh = new PDO($dsn,$usr,$password);
	//使う文字コードをutf8に設定
	$dbh->query('SET NAMES utf8');
	//テーブルidtableからカラムiphoneidが変数$iphoneの値を一致する結果取得するSQL文の文字列を格納
	$sql = 'select * from idtable where iphoneid = \''.$iphoneid.'\'';
	//SQLを実行するための変数を生成
	$stmt = $dbh->prepare($sql);
	//SQLを実行
	$stmt->execute();
	//SQLの結果の一番上の行を取得
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	//行がないかどうか
	if($rec == false){
		//テーブルidtableに変数iphoneidをもとにidを追加するSQL文の文字列を生成
		$sql3 = 'insert into idtable (iphoneid)  values(\''.$iphoneid.'\')';
		//SQLを実行するための変数を生成
		$stmt3 = $dbh->prepare($sql3);
		//SQLを実行
		$stmt3->execute();
		echo '登録完了';
	}else{
		echo 'すでに登録';
	}
	//データベースとの接続切断
	$dbh = null;
}
catch(Exception $e){
	echo 'データベースにエラー';
}
?>