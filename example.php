<?php 
include 'Guild.php';



$guildId = 3;
$rawGuildData = "1,9zldr,2p,0";
$v1 = explode(',' , $rawGuildData)[0];		
$v2 = explode(',' , $rawGuildData)[1];		
$v3 = explode(',' , $rawGuildData)[2];		
$v4 = explode(',' , $rawGuildData)[3];	



$guild = new Guild($guildId, $v3, $v1, $v4, $v2);
$url = $guild->Render();

?>

<!-- On affiche l'emblem -->
<img src="<?= $url ?>">

			