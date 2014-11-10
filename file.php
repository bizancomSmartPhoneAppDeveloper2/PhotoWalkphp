<?php
try{
	//時間を東京の時間に指定
	date_default_timezone_set('Asia/Tokyo');
	//画像ファイルを移動するフォルダの文字列格納
	$updir = "./image/";
	//項目名iphoneidの値を格納
	$iphoneid = $_POST['iphoneid'];
	//項目名latの値を格納
	$lat = $_POST['lat'];
	//項目名lngの値を格納
	$lng = $_POST['lng'];
	$tag = $_POST['tag'];
	$tagarray = array();
	if(!empty($tag)){
		$tagarray = explode("\n",$tag);
	}
	//現在の年月日時分秒と並んだ文字列
	$datestr = date("YmdHis");
	//データベース名とホスト名の情報を格納
	$dsn = 'mysql:dbname=u551671545_toku;host=mysql.miraiserver.com';
	//データベースのユーザー名
	$usr = 'u551671545_toku';
	//データベースのパスワード
	$password ='bizan07';
	//データベースと接続する変数を生成
	$dbh = new PDO($dsn,$usr,$password);
	//使う文字コードをutf8に設定
	$dbh->query('SET NAMES utf8');
	//カラムiphoneidが変数$iphoneidの値を一致する結果取得するSQL文の文字列を格納
	$sql = 'select * from idtable where iphoneid = \''.$iphoneid.'\'';
	//SQLを実行するための変数を生成
	$stmt = $dbh->prepare($sql);
	//SQLを実行
	$stmt->execute();
	//SQLの結果の一番上の行を取得
	$rec = $stmt->fetch(PDO::FETCH_ASSOC);
	//カラム名idの値を取得
	$id = $rec['id'];
	//is_uploaded_file でファイルがアップロードされたかどうか
	if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
 
    	//move_uploaded_file を使って一時的な保存先から指定のフォルダに移動させるかどうか
	//移動するときのファイル名はid名現在の年月日時.jpgにする
    		if (move_uploaded_file($_FILES["image"]["tmp_name"], $updir.$id.$datestr.'.jpg')) {
		//テーブルimagetableに写真送った人のidと緯度と経度と現在の日時の情報を追加するためのSQL文の文字列を生成
		$sql2 = 'insert into imagetable values('.$id.',\''.$lat.'\',\''.$lng.'\',\''.$datestr.'\') ';
		//SQLを実行するための変数を生成
		$stmt2 = $dbh->prepare($sql2);
		//SQLを実行
		$stmt2->execute();
		for($i = 0;$i < count($tagarray);$i++){
			//テーブルimagetableに写真送った人のidと緯度と経度と現在の日時の情報を追加するためのSQL文の文字列を生成
		$sql3 = 'insert into tagtable  values('.$id.',\''.$datestr.'\',\''.$tagarray[$i].'\') ';
		//SQLを実行するための変数を生成
		$stmt3 = $dbh->prepare($sql3);
		//SQLを実行
		$stmt3->execute();
		}
    		echo '{"result":"1"}';
    		} else {
        		echo '{"result":"0"}';
    		}
	} else {
		echo '{"result":"-1"}';
	}
	//データベースとの接続を切断
	$dbh = null;
}
catch(Exception $e){
	echo '{"result":"-2"}';
}
?>