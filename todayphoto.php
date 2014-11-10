<?php
try{
	//時間を東京の時間に指定
	date_default_timezone_set('Asia/Tokyo');
	//項目名iphoneidの値を格納
	$iphoneid = $_GET['iphoneid'];
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
	//テーブルidtableからカラムiphoneidが変数$iphoneidの値を一致する結果取得するSQL文の文字列を格納
	$sql = 'select * from idtable where iphoneid = \''.$iphoneid.'\'';
	//SQLを実行するための変数を生成
	$stmt = $dbh->prepare($sql);
	//SQLを実行
	$stmt->execute();
	//SQLの結果の一番上の行を取得
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	//カラム名idの値を取得
	$id = $rec['id'];
	//現在の年-月-日と並んだ文字列
	$date = date('Y-m-d');
	//テーブルimagetableからカラムiphoneidが変数$idの値を一致しカラムdateが現在の年月日と一致する結果取得するSQL文の文字列を格納
	$sql2 = 'select * from imagetable where id = \''.$id.'\' and date like \''.$date.'%\'';
	//SQLを実行するための変数を生成
	$stmt2 = $dbh->prepare($sql2);
	//SQLを実行
	$stmt2->execute();
	//配列の初期化
	$array = array();
	//配列を値を格納するため繰り返し処理を実行
	while(1){
		//SQLの結果の一番上の行を取得
		$rec2 = $stmt2->fetch(PDO::FETCH_ASSOC);
		//行がないかどうか
		if($rec2 == false){
			//繰り返し処理を終了させる
			break;
		}
		//取得した行のカラムdateの値をもとにDateTimeの変数を生成
		$date = new DateTime($rec2['date']);
		//年月日時分秒と並んだ文字列を生成
		$datestr = $date->format('YmdHis');
		//カラムidの値を格納
		$str = $rec2['id'];
		//配列に変数strとdatestrを結合した文字列を追加
		$array[] = $str.$datestr;
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