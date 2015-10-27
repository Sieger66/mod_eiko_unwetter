<?php
/**
 * @version     1.00
 * @package     mod_eiko_unwetter
 * @copyright   Copyright (C) 2015 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@einsatzkomponente.de> - http://einsatzkomponente.de
 */

// no direct access
defined('_JEXEC') or die;


?>
<style>
<?php echo $css; ?>
</style>
<?php



$link = 'http://www.wettergefahren.de/DWD/warnungen/warnapp/warnings.json';

if ($curl == '2') : $lines = file_get_contents($link); endif;
if ($curl == '1') : 
  $ch = curl_init();
  $timeout = 5;
  curl_setopt($ch, CURLOPT_URL, $link);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
  $lines = curl_exec($ch);
  curl_close($ch);
  endif;

$letzte_akt = strstr($lines, '<strong>Letzte Aktualisierung:', false) ; 
$letzte_akt = strstr($letzte_akt, '</strong>', true) ; 
$letzte_akt = $letzte_akt.'</strong> Uhr';
$letzte_akt = strip_tags($letzte_akt);
//echo $letzte_akt;

//$lines = str_replace('warnWetter.loadWarnings(', '', $lines);
$lines = substr($lines, 24, -2); 

$jsondata = $lines;
$json = json_decode($jsondata, true);

$time = date('d/m/Y', substr($json['time'], 0, -3)).' - '.date('H:i', substr($json['time'], 0, -3)).' Uhr'; 
$copyright = $json['copyright'];
$arr = $json['warnings'];

	echo '<table class="eiko_unwetter_table">';
		echo '<tr>';
		echo '<th class="eiko_unwetter_th">';
	    echo $kreis;
		echo '</th>';

foreach ($arr as $k=>$v){
    $regionName = htmlentities($v[0]['regionName'], ENT_QUOTES, 'UTF-8');
	$altitudeStart = $v[0]['altitudeStart'];  
	$altitudeEnd = $v[0]['altitudeEnd']; 
	$start = date('d.m.Y', substr($v[0]['start'], 0, -3)).' - '.date('H:i', substr($v[0]['start'], 0, -3)).' Uhr';  
	$headline = htmlentities($v[0]['headline'], ENT_QUOTES, 'UTF-8'); 
	$event = htmlentities($v[0]['event'], ENT_QUOTES, 'UTF-8');
	$instruction = htmlentities($v[0]['instruction'], ENT_QUOTES, 'UTF-8'); 
	$description = htmlentities($v[0]['description'], ENT_QUOTES, 'UTF-8'); 
	$end = date('d.m.Y', substr($v[0]['end'], 0, -3)).' - '.date('H:i', substr($v[0]['end'], 0, -3)).' Uhr';
	$type = $v[0]['type']; 
	$level = $v[0]['level']; 
	$state = htmlentities($v[0]['state'], ENT_QUOTES, 'UTF-8'); 
	
	if ($regionName==$kreis) : 
		echo '</tr>';
		echo '<tr>';
							
			if (strpos($headline, 'Amtliche WARNUNG') !== false) :
	  	    echo '<td class="eiko_unwetter_td" style="background-color: #ffeb3b !important;color:#000000 !important;">';
			else:
			echo '<td class="eiko_unwetter_td">';
			endif;
		echo $headline; 
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="eiko_unwetter_td">';
		echo $description;
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td class="eiko_unwetter_td">';
		echo 'von '.$start.'<br/>bis '.$end;
		echo '</td>';
		echo '</tr>';
    endif;
}	

									if ($warnkarte) :
									
									echo '<tr><td class="eiko_unwetter_td"><a target="_BLANK" href="http://www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="http://www.dwd.de/DWD/warnungen/warnstatus/Schilder'.$schild.'.jpg" width="'.$width.'" border="0"></a></td></tr>';
									endif;	
		echo '<td class="eiko_unwetter_td">';
		echo '<small><a href="http://www.dwd.de" target="_blank">Quelle: Deutsche Wetterdienst</a></small> <small>('.$time.')</small>';
		echo '</td>';
		echo '</tr>';
	echo '</table>';
									

									



?>
