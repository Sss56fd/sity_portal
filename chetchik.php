<?php
include 'config.php';
session_start();
$select_colvo_sql=$sql->query("SELECT * FROM `quests`");
$select_complete=0;
$select_new=0;
while ($select_colvo_res=$select_colvo_sql->fetch_array()) {
	if ($select_colvo_res['статус']=='Решена') {
		$select_complete++;
	}
	else if($select_colvo_res['статус']=='Новая'){
		$select_new++;
	}
}


header("Content-Type: text/json; charset=utf-8");
echo json_encode(array(
		'chK' =>$select_complete,
		'chN' =>$select_new

));
?>