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

if (urlspy($ssl.'www.dwd.de/DWD/warnungen/agrar/wbx/wbx_stationen.png')) :
$wlbi_url = $ssl.'www.dwd.de/DWD/warnungen/agrar/wbx/wbx_stationen.png';
else:
$wlbi_url = $ssl.'www.dwd.de/DE/leistungen/waldbrandgef/bild_leistungen_wbi.png;jsessionid=46BEA5B565D06CB6D7821D6067770260.live21074?__blob=normal&v=5';
endif;
if (urlspy($ssl.'www.dwd.de/DWD/warnungen/agrar/glfi/glfi_stationen.png')) :
$glfi_url = $ssl.'www.dwd.de/DWD/warnungen/agrar/glfi/glfi_stationen.png';
else:
$glfi_url = $ssl.'www.dwd.de/DE/leistungen/graslandfi/bild_leistungen_glfi.png;jsessionid=46BEA5B565D06CB6D7821D6067770260.live21074?__blob=normal&v=4';
endif;

?>
<style>
<?php echo $css; ?>
</style>
<?php


echo '<table width="'.$width_karte.'" class="eiko_karte_table">';


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
				echo '<tr><td class="eiko_unwetter_td"><a target="_BLANK" href="'.$ssl.'www.dwd.de/DE/wetter/warnungen_gemeinden/warnWetter_node.html"><img src="'.$ssl.'www.dwd.de/DWD/warnungen/warnapp/json/warning_map_'.$bdl.$unwetterkarte_kriterium.'.png" title="Warnkarte: '.$bundesland_name.'" width="'.$width_karte.'" border="0"></a></td></tr>';
echo '</td>';
echo '</tr>';
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de" target=_blank"><span style="font-size:9px; color:#969696;">&copy; Deutscher Wetterdienst, (DWD) </a></span>';
echo '</td>';
echo '</tr>';
echo '<tr><td class="eiko_space"></td></tr>';
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


if($waldbrandkarte == "1")
{
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';

if ($show_germany):
	echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/waldbrandgef/waldbrandgef.html" target="_blank"><img src="'.$wlbi_url.'" title="Waldbrandgefahrenindex" width="'.$width_karte.'" border="0"></a>';
endif;
if (!$show_germany):
	echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/waldbrandgef_bl/waldbrandgefbl.html?nn=16102&cl2Categories_Bundesland=wbh_'.$bundesland.'" target="_blank"><img src="'.$wlbi_url.'" title="Waldbrandgefahrenindex" width="'.$width_karte.'" border="0"></a>';
endif;

echo '</td>';
echo '</tr>';
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de" target=_blank"><span style="font-size:9px; color:#969696;">&copy; Deutscher Wetterdienst, (DWD) </a></span>';
echo '</td>';
echo '</tr>';
echo '<tr><td class="eiko_space"></td></tr>';
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

if($graslandkarte == "1")
{
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';

if ($show_germany):
	echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/graslandfi_bl/graslandfibl.html?nn=16102&cl2Categories_Bundesland=glh_'.$bundesland.'" target="_blank"><img src="'.$glfi_url.'" title="Graslandfeuer-Index" width="'.$width_karte.'" border="0"></a>';
endif;
if (!$show_germany):
	echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/graslandfi/graslandfi.html" target="_blank"><img src="'.$glfi_url.'" title="Graslandfeuer-Index" width="'.$width_karte.'" border="0"></a>';
endif;

echo '</td>';
echo '</tr>';
echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';
echo '<a href="'.$ssl.'www.dwd.de" target=_blank"><span style="font-size:9px; color:#969696;">&copy; Deutscher Wetterdienst, (DWD) </a></span>';
echo '</td>';
echo '</tr>';
echo '<tr><td class="eiko_space"></td></tr>';
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
      if($file) {
        return true;
        fclose($file);
      }

      // Wenn Datei nicht vorhanden ist
      else {
        return false;
      }
   }


?>

