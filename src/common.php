<?php
$connect = mysqli_connect("", "", "");
$mysql = mysqli_select_db($connect, "");

function sql_query($query) {
	global $connect;

	return mysqli_query($connect, $query);
}

function sql_fetch($query) {
	$result = sql_query($query);
	return mysqli_fetch_assoc($result);
}

function sql_fetch_all($query) {
	$query = sql_query($query);
	$result = array();
	while($tmp = mysqli_fetch_assoc($query)) {
		$result[] = $tmp;
	}
	return $result;
}

sql_query("SET charset UTF8");
