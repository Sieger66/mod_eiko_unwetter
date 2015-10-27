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

//echo $letzte_akt;
//print_r ($lines);break;

									

	$pos = strpos($lines, '<h2>'.$kreis.'</h2>');  
	$warn_quelle	= '<small><a href="http://www.dwd.de" target="_blank">Quelle: Deutsche Wetterdienst</a></small><br/><small>('.$letzte_akt.')</small>';
if($pos) :
			$lines = strstr($lines, '<h2>'.$kreis.'</h2>', false) ; 
			$lines = strstr($lines, '</table>', true) ; 
			$explode = explode("<td>",$lines);//print_r ($explode);break;
			$count_explode = count($explode);
			$warn_anzahl =(($count_explode-1)/4);
			$warn_kreis 	= $kreis;

			echo '<table class="eiko_unwetter_table">';
			echo '<tr>';
			echo '<th class="eiko_unwetter_th">'.$warn_anzahl.' Wetterwarnung(en) f&uuml;r:</th>';
			echo '</tr>';
			echo '<tr>';
			echo '<td class="eiko_unwetter_td">'.$warn_kreis.'</td>';
			echo '</tr>';
									
				for($count = 1; $count < $count_explode; $count=$count+4) 
					{
					$warn_text		= $explode[$count];
					$warn_ab 		= $explode[$count+1].' Uhr';
					$warn_bis 		= $explode[$count+2].' Uhr';
					$warn_beschr 	= $explode[$count+3];
	
					echo '<tr>';
					if (strpos($warn_text, 'Amtliche WARNUNG vor NEBEL') !== false) :
						echo '<td class="eiko_unwetter_td" style="background-color: #ffeb3b !important;color:#000000 !important;">';
						elseif 
							(strpos($warn_text, 'Amtliche WARNUNG vor STURMB&Ouml;EN') !== false) :
							echo '<td class="eiko_unwetter_td" style="background-color: #fb8c00 !important;color:#000000 !important;">';
						else:
							echo '<td class="eiko_unwetter_td" style="background-color: #c5e566  !important;color:#000000 !important;">';
						endif;
					echo $warn_text;
					echo'</td>';
					echo '</tr>';
					echo '<tr>';
					echo '<td class="eiko_unwetter_td">';
					echo $warn_beschr;
					echo '</td>';
					echo '</tr>';
									}		
		if ($warnkarte) :
			if ($show_germany) :
			echo '<tr><td class="eiko_unwetter_td"><a target="_BLANK" href="http://www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="http://www.dwd.de/DWD/warnungen/warnapp/json/warning_map.png" width="'.$width.'" border="0"></a></td></tr>';
			else:
			echo '<tr><td class="eiko_unwetter_td"><a target="_BLANK" href="http://www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="http://www.dwd.de/DWD/warnungen/warnstatus/Schilder'.$schild.'.jpg" width="'.$width.'" border="0"></a></td></tr>';
			endif;
		endif;
				
					echo '<tr>';
					echo '<td class="eiko_unwetter_td">'.$warn_quelle.'</td>';  
					echo '</tr>';
					echo '</table>';
									
else:
	echo '<table class="eiko_unwetter_table"><tr><td class="eiko_unwetter_td" style="background-color: #c5e566  !important;color:#000000 !important;">Es sind keine Wetterwarnungen f&uuml;r '.$kreis.' aktiv.</td></tr><tr><td class="eiko_unwetter_td"></td></tr>';	
		if ($warnkarte) :
			if ($show_germany) :
			echo '<tr><td class="eiko_unwetter_td"><a target="_BLANK" href="http://www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="http://www.dwd.de/DWD/warnungen/warnapp/json/warning_map.png" width="'.$width.'" border="0"></a></td></tr>';
			else:
			echo '<tr><td class="eiko_unwetter_td"><a target="_BLANK" href="http://www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="http://www.dwd.de/DWD/warnungen/warnstatus/Schilder'.$schild.'.jpg" width="'.$width.'" border="0"></a></td></tr>';
		endif;
	endif;	
	echo '<tr>';
	echo '<td class="eiko_unwetter_td">'.$warn_quelle.'</td>';  
	echo '</tr>';
	
	
	echo '</table>';
endif;


?>
