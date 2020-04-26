<?php
/**
 * @author 		Bitlits <support@bitlits.com>
 * @copyright 	2013-2020 Bitlits.
 * @link 		https://github.com/bitlits/bitcoin-casino
*/
$content = array(
	"title" => $settings["name"],
	"slots" => true,
	"pagecss" => "slots",
	"slotsJackpot" => $altcoin->getbalance("slots") * .5
);

$content = array_merge($content,$settings,$user->export());
echo $m->render("pages/slots", $content);

?>