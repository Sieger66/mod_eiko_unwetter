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
                                	//$lines = strip_tags($lines);echo $lines;break;
									$lines = strstr($lines, '<h2>'.$kreis.'</h2>', false) ; 
									$lines = strstr($lines, '</table>', true) ; 
									$lines = $lines.'<tr><td colspan="4"><small><a href="http://www.dwd.de" target="_blank">Quelle: Deutsche Wetterdienst</a></small> <small>('.$letzte_akt.')</small></td></tr></table>';
									$lines = str_replace('<colgroup><col class="firstColumn"</col><col class="colorColumn"></col><col class="colorColumn"></col><col class="colorColumn"></col>', '', $lines);
									$lines = str_replace($kreis, 'Wetterwarnungen f&uuml;r '.$kreis.'', $lines);
									$lines = str_replace('<h2>', '<h2 class="eiko_unwetter_h2">', $lines);
									$lines = str_replace('<table>', '<table class="eiko_unwetter_table">', $lines);
									$lines = str_replace('<th>', '<th class="eiko_unwetter_th">', $lines);
									$lines = str_replace('<td>', '<td class="eiko_unwetter_td">', $lines); 
									echo $lines;
								else:
									echo '<table class="eiko_unwetter_table"><tr><td class="eiko_unwetter_td"><span class ="eiko_unwetter_span"><small>Es sind keine Wetterwarnungen f&uuml; '.$kreis.' aktiv.</small> <small>('.$letzte_akt.')</small></span></td></tr></table>';	 							
                                endif;




?>
