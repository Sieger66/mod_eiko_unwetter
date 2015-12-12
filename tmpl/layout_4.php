<?php
/**
 * @version     1.00
 * @package     mod_eiko_unwetter
 * @copyright   Copyright (C) 2015 by Ralf Meyer. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Ralf Meyer <ralf.meyer@einsatzkomponente.de> - '.$ssl.'einsatzkomponente.de
 */

// no direct access
defined('_JEXEC') or die;


?>
<style>
<?php echo $css; ?>
</style>
<?php


echo '<table class="eiko_karte_table">';


if($titel_karte == "1")
{
if($unwetterkarte == "1")
{
echo '<tr class="eiko_karte_tr">';
echo '<th class="eiko_karte_th">';
echo 'Unwetterwarnkarte';
echo '</th>';
echo '</tr>';
}
}



if($unwetterkarte == "1")
{
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
			if ($show_germany) :
			echo '<tr><td class="eiko_unwetter_td"><a target="_BLANK" href="'.$ssl.'www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="'.$ssl.'www.dwd.de/DWD/warnungen/warnapp/json/warning_map.png" width="'.$width_karte.'" border="0"></a></td></tr>';
			else:
			echo '<tr><td class="eiko_unwetter_td"><a target="_BLANK" href="'.$ssl.'www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="'.$ssl.'www.dwd.de/DWD/warnungen/warnstatus/Schilder'.$schild.'.jpg" width="'.$width_karte.'" border="0"></a></td></tr>';
		endif;
echo '</td>';
echo '</tr>';
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de" target=_blank"><span style="font-size:9px; color:#969696;">&copy; Deutscher Wetterdienst, (DWD) </a></span>';
echo '</td>';
echo '</tr>';
}


if($titel_karte == "1")
{
if($waldbrandkarte == "1")
{
echo '<tr class="eiko_karte_tr">';
echo '<th class="eiko_karte_th">';
echo 'Waldbrandgefahrenindex';
echo '</th>';
echo '</tr>';
}
}


if($waldbrandkarte == "1" AND urlspy($ssl.'www.dwd.de/DWD/warnungen/agrar/wbx/wbx_stationen.png'))
{
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/waldbrandgef_bl/waldbrandgefbl.html?nn=16102&cl2Categories_Bundesland=wbh_'.$bundesland.'" target="_blank"><img src="'.$ssl.'www.dwd.de/DWD/warnungen/agrar/wbx/wbx_stationen.png" title="Waldbrandgefahrenindex" width="'.$width_karte.'" border="0"></a>';
echo '</td>';
echo '</tr>';
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de" target=_blank"><span style="font-size:9px; color:#969696;">&copy; Deutscher Wetterdienst, (DWD) </a></span>';
echo '</td>';
echo '</tr>';
}
else {
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/waldbrandgef_bl/waldbrandgefbl.html?nn=16102&cl2Categories_Bundesland=wbh_'.$bundesland.'" target="_blank"><img src="'.$ssl.'www.dwd.de/DE/leistungen/waldbrandgef/bild_leistungen_wbi.png;jsessionid=46BEA5B565D06CB6D7821D6067770260.live21074?__blob=normal&v=5" title="Waldbrandgefahrenindex" width="'.$width_karte.'" border="0"></a>';
echo '</td>';
echo '</tr>';
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de" target=_blank"><span style="font-size:9px; color:#969696;">&copy; Deutscher Wetterdienst, (DWD) </a></span>';
echo '</td>';
echo '</tr>';
	}



if($titel_karte == "1")
{
if($graslandkarte == "1")
{
echo '<tr class="eiko_karte_tr">';
echo '<th class="eiko_karte_th">';
echo 'Graslandfeuer-Index';
echo '</th>';
echo '</tr>';
}
}

if($graslandkarte == "1" AND urlspy($ssl.'www.dwd.de/DWD/warnungen/agrar/glfi/glfi_stationen.png'))
{
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/graslandfi_bl/graslandfibl.html?nn=16102&cl2Categories_Bundesland=glh_'.$bundesland.'" target="_blank"><img src="'.$ssl.'www.dwd.de/DWD/warnungen/agrar/glfi/glfi_stationen.png" title="Graslandfeuer-Index" width="'.$width_karte.'" border="0"></a>';
echo '</td>';
echo '</tr>';
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de" target=_blank"><span style="font-size:9px; color:#969696;">&copy; Deutscher Wetterdienst, (DWD) </a></span>';
echo '</td>';
echo '</tr>';
}
else {
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/graslandfi_bl/graslandfibl.html?nn=16102&cl2Categories_Bundesland=glh_'.$bundesland.'" target="_blank"><img src="'.$ssl.'www.dwd.de/DE/leistungen/graslandfi/bild_leistungen_glfi.png;jsessionid=46BEA5B565D06CB6D7821D6067770260.live21074?__blob=normal&v=4" title="Graslandfeuer-Index" width="'.$width_karte.'" border="0"></a>';
echo '</td>';
echo '</tr>';
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de" target=_blank"><span style="font-size:9px; color:#969696;">&copy; Deutscher Wetterdienst, (DWD) </a></span>';
echo '</td>';
echo '</tr>';
	}



echo '</table>';

?>
<?php
   function urlspy($adresse){
      if($adresse) {
        // Gesuchte Datei öffnen
        $file = @fopen ($adresse, "r");
      }
      // Prüfen ob die gewünschte Datei existiert
      if($file) {break;
        return true;
        fclose($file);
      }

      // Wenn Datei nicht vorhanden ist
      else {
        return false;
      }
   }


?>

