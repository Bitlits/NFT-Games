<?php
/**
 * @author 		Bitlits <support@bitlits.com>
 * @copyright 	2013-2020
 * @link 		https://github.com/bitlits/bitcoin-casino
*/

if(isset($_SERVER["HTTP_HOST"]))
	$domain = $_SERVER['HTTP_HOST'];
	$sub = array_shift(explode(".",$_SERVER['HTTP_HOST']));
if(isset($_SERVER["REQUEST_URI"])){
	$path = explode("?",$_SERVER['REQUEST_URI']);
	$var = explode("/",$path[0]);
}

$settings = array(
	"name" => "Bitcoin Casino",
	"url" => "http://bitlits.com",
	"rate" => ".9",
	"altcoin" => "Bitcoin",
	"altcoinl" => "bitcoin",
	"identifier" => "bitcoinrpc",
	"password" => "Password",
	"port" => "8332",
	"altc" => "BTC",
);

require_once(VENDOR."/Mustache/Autoloader.php");
require_once(VENDOR."/jsonRPC/jsonRPCClient.php");
require_once(VENDOR."/storage/rb.php");
require_once(VENDOR."/ssh/Net/SSH2.php");

R::setup('sqlite:'.BASE.'/data.sqlite','root','password');

Mustache_Autoloader::register();
$m = new Mustache_Engine(
	array(
		'loader' => new Mustache_Loader_FilesystemLoader(VIEWS),
		'partials_loader' => new Mustache_Loader_FilesystemLoader(VIEWS."/partials")
	)
);

$altcoin = new jsonRPCClient('http://'.$settings["identifier"].':'.$settings["password"].'@localhost:'.$settings["port"]);

require_once(BASE."/functions.php");
require_once(BASE."/user.php");
?>