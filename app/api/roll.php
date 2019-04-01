<?php
/*
🦉 Justin Faler
🧪 https://github.com/Jfaler
🧠 Base 64: UHJvcGVydHkgb2YgQml0bGl0cy5jb20gLyBQbGVhc2UgY29udGFjdCBpbW1lZGlhdGVseSBpZiB0aGlzIHByb2R1Y3QgaXMgdW5saWNlbnNlZC4=
*/

cors();

$uuid = getVar('uuid');
$id = getVar('id');

$user = R::findOne('user', 'key = ?', array($key));

if(!is_object($user)){
	$user = R::dispense("user");
	$user->key = $key;
	$user->balance = 0;
	$user->updated = time();
	$user->created = time();
	$id = R::store($user);
	$user = R::load("user",$id);
}


$roll = R::dispense("roll");
$roll->uuid = $uuid;
$roll->first = rand(1,10);
$roll->second = rand(1,10);
$roll->third = rand(1,10);
$roll->fourth = rand(1,10);
$roll->fifth = rand(1,10);
$roll->time = time();
$roll->key = $key;
R::store($roll);

$data = array(
	"status"=>"success",
	"won"=>false,
	"numbers"=>array(
		$roll->first,
		$roll->second,
		$roll->third,
		$roll->fourth,
		$roll->fifth
		)
	);

$jackpotSlots = $altcoin->getbalance("slots")*.5;
if(strlen($user->address) > 0)
	$userBalance = $altcoin->getbalance($key);
else
	$userBalance = 0;

logger("$key balance is $userBalance");

if($userBalance > .1){
	$altcoin->move($key, "slots", .09);
	logger("Moved .09 to slots from ".$key);
	$altcoin->move($key, "site", .01);
	logger("Moved .01 to site from ".$key);

	if($roll->fifth==7 && $roll->fourth==7 && $roll->third==7 && $roll->second==7 && $roll->first==7){
		$altcoin->move("slots", $key, $jackpotSlots);
		logger("Moved $jackpotSlots to $key at ".date("F j, Y, g:i:s a"));
		$data["won"] = true;
		$data["amount"] = $jackpotSlots;
	}elseif(
		($roll->fifth==7 && $roll->fourth==7 && $roll->third==7 && $roll->second==7) ||
		($roll->fourth==7 && $roll->third==7 && $roll->second==7 && $roll->first==7)){
		$altcoin->move("slots", $key, 10);
		logger("Moved 10 to $key at ".date("F j, Y, g:i:s a"));
		$data["won"] = true;
		$data["amount"] = 10;
	}elseif(
		($roll->fifth==7 && $roll->fourth==7 && $roll->third==7) ||
		($roll->fourth==7 && $roll->third==7 && $roll->second==7) ||
		($roll->third==7 && $roll->second==7 && $roll->first==7)){
		$altcoin->move("slots", $key, 5);
		logger("Moved 5 to $key at ".date("F j, Y, g:i:s a"));
		$data["won"] = true;
		$data["amount"] = 5;
	}elseif(
		($roll->fifth==7 && $roll->fourth==7) ||
		($roll->fourth==7 && $roll->third==7) ||
		($roll->third==7 && $roll->second==7) ||
		($roll->second==7 && $roll->first==7)){
		$altcoin->move("slots", $key, 1);
		logger("Moved 1 to $key at ".date("F j, Y, g:i:s a"));
		$data["won"] = true;
		$data["amount"] = 1;
	}elseif($roll->fifth==7 || $roll->fourth==7 || $roll->third==7 || $roll->second==7 || $roll->first==7){
		$altcoin->move("slots", $key, .1);
		logger("Moved .1 to $key at ".date("F j, Y, g:i:s a"));
		$data["won"] = true;
		$data["amount"] = .1;
	}
}

$data["jackpot"] = $jackpotSlots;

echo json_encode($data);

?>
