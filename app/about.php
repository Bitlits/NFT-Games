<?php
/**
 * @author 		Bitlits <support@bitlits.com>
 * @copyright 	2013-2020 Bitlits.
 * @link 		https://github.com/bitlits/bitcoin-casino
*/
$content = array(
	"title" => $settings["name"],
	"about" => true,
	"pagecss" => "about",
);

$content = array_merge($content,$settings);
echo $m->render("pages/about", $content);
?>