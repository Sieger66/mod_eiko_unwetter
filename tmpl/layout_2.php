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



$link = 'http://www.wettergefahren.de/DWD/warnungen/warnapp/warnings.html';

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
//print_r ($lines);break;

									

	$pos = strpos($lines, '<h2>'.$kreis.'</h2>'); 
							   if($pos) :
									$lines = strstr($lines, '<h2>'.$kreis.'</h2>', false) ; 
									$lines = strstr($lines, '</table>', true) ; 
									
									$explode = explode("<td>",$lines);//print_r ($explode);break;
									
									$count_explode = count($explode);
									
									$warn_anzahl =(($count_explode-1)/4);
									$warn_kreis 	= $kreis;
?>
<table class="eiko_unwetter_table">
	<tr>
		<th class="eiko_unwetter_th"><?php echo $warn_anzahl;?> Wetterwarnung(en) f&uuml;r:</th>
	</tr>
	<tr>
		<td class="eiko_unwetter_td"><?php echo 'Kreis: '.$warn_kreis;?></td>
	</tr>
<?php									
									
									for($count = 1; $count < $count_explode; $count=$count+4) 
									{
										$warn_text		= $explode[$count];
										$warn_ab 		= $explode[$count+1].' Uhr';
										$warn_bis 		= $explode[$count+2].' Uhr';
										$warn_beschr 	= $explode[$count+3];
										$warn_quelle	= '<small><a href="http://www.dwd.de" target="_blank">Quelle: Deutsche Wetterdienst</a></small><br/><small>('.$letzte_akt.')</small>';
										
?>
	<tr>
		<td class="eiko_unwetter_td"><?php echo $warn_text;?></td>
	</tr>
	<tr>
		<td class="eiko_unwetter_td"><?php echo $warn_beschr;?></td>
	</tr>
										
<?php
									}
									
if ($warnkarte) :
echo '<tr><td class="eiko_unwetter_td"><a target="_BLANK" href="http://www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="http://www.dwd.de/DWD/warnungen/warnapp/json/warning_map.png" width="'.$width.'" border="0"></a></td></tr>';
endif;							
?>
	<tr>
		<td class="eiko_unwetter_td"><?php echo $warn_quelle;?></td>
	</tr>
</table>
<?php
									
								else:
									echo '<table class="eiko_unwetter_table"><tr><td class="eiko_unwetter_td">Es sind keine Wetterwarnungen im Kreis '.$kreis.' aktiv.</td></tr><tr><td class="eiko_unwetter_td">('.$letzte_akt.')</td></tr></table>';	 							
                                endif;




?>
