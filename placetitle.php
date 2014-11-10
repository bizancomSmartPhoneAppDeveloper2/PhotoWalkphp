<?php
try{
	//データベース名とホスト名の情報を格納
	$dsn = 'mysql:dbname=u551671545_toku;host=mysql.miraiserver.com';
	//データベースのユーザー名
	$usr = 'u551671545_toku';
	//データベースのパスワード
	$password ='bizan07';
	//データベースと接続する変数を生成
	$dbh = new PDO($dsn,$usr,$password);
	//使う文字コードをutf8に設定
	$dbh->query('SET NAMES utf8');
	//テーブルplaceinfoからすべての行を取得するSQL文の文字列を格納
	$sql = 'select id, title, subtitle, lat, lng from placeinfo';
	//SQLを実行するための変数を生成
	$stmt = $dbh->prepare($sql);
	//SQLを実行
	$stmt->execute();
	//配列の初期化
	$array = array();
	//配列を値を格納するため繰り返し処理を実行
	while(1){
		//SQLの結果の一番上の行を取得
		$rec = $stmt->fetch(PDO::FETCH_ASSOC);
		//行がないかどうか
		if($rec == false){
			//繰り返し処理を終了させる
			break;
		}
		//配列に行のデータを追加
		$array[] = $rec;
	}
	//配列をもとにJSON形式で出力
	echo json_encode($array);
	//データベースとの接続を切断
	$dbh = null;
}
catch(Exception $e){
	echo 'データベースに障害';
}
?>