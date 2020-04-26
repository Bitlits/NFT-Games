<?php
/**
 * @author 		Bitlits <support@bitlits.com>
 * @copyright 	2013-2020 Bitlits.
 * @link 		https://github.com/bitlits/bitcoin-casino
*/
$content = array(
	"title" => $settings["name"],
	"profile" => true,
	"genAddress"=>true
);

$user = R::findOne('user', 'key = ?', array($key));

if(is_object($user)){
	if($user->address!="")
		$content["genAddress"]=false;

	if($user->address!=""){
		$user->balance = $altcoin->getbalance($key);
	}
	$user->updated = time();
	R::store($user);
	$content["user"]=$user->export();
}

$content = array_merge($content,$settings);
echo $m->render("pages/profile", $content);

?>