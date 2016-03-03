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
$wlbi_url = $ssl.'www.dwd.de/DE/leistungen/waldbrandgef/bild_leistungen_wbi.png?__blob=normal&v=5';
endif;

if (urlspy($ssl.'www.dwd.de/DWD/warnungen/agrar/glfi/glfi_stationen.png')) :
$glfi_url = $ssl.'www.dwd.de/DWD/warnungen/agrar/glfi/glfi_stationen.png';
else:
$glfi_url = $ssl.'www.dwd.de/DE/leistungen/graslandfi/bild_leistungen_glfi.png?__blob=normal&v=4';
endif;

?>
<style>
<?php echo $css; ?>
</style>
<?php


echo '<table class="eiko_karte_table">';

if($titel_karte == "1")
{
echo '<tr class="eiko_karte_tr">';
if($unwetterkarte == "1")
{
echo '<th class="eiko_karte_th">';
echo 'Unwetterwarnkarte';
echo '</th>';
}
if($waldbrandkarte == "1")
{
echo '<th class="eiko_karte_th">';
echo 'Waldbrandgefahrenindex';
echo '</th>';
}
if($graslandkarte == "1")
{
echo '<th class="eiko_karte_th">';
echo 'Graslandfeuer-Index';
echo '</th>';
}
echo '</tr>';
}


echo '<tr class="eiko_karte_tr">';
echo '<td class="eiko_karte_td">';

$col = '';

if($unwetterkarte == "1")
{
				echo '<a target="_BLANK" href="'.$ssl.'www.dwd.de/DE/wetter/warnungen/Warnkarten/warnWetter_'.$bdl.'_node.html?bundesland='.$bdl.'"><img src="'.$ssl.'www.dwd.de/DWD/warnungen/warnapp/json/warning_map_'.$bdl.$unwetterkarte_kriterium.'.png" title="Warnkarte: '.$bundesland_name.'" width="'.$width_karte.'" border="0"></a>';
$col = $col+1;
}

echo '</td>';
echo '<td class="eiko_karte_td">';

if($waldbrandkarte == "1")
{
echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/waldbrandgef_bl/waldbrandgefbl.html?nn=16102&cl2Categories_Bundesland=wbh_'.$bundesland.'" target="_blank"><img src="'.$wlbi_url.'" title="Waldbrandgefahrenindex" width="'.$width_karte.'" border="0"></a>';
$col = $col+1;
}
echo '</td>';
echo '<td class="eiko_karte_td">';

if($graslandkarte == "1")
{
echo '<a href="'.$ssl.'www.dwd.de/DE/leistungen/graslandfi_bl/graslandfibl.html?nn=16102&cl2Categories_Bundesland=glh_'.$bundesland.'" target="_blank"><img src="'.$glfi_url.'" title="Graslandfeuer-Index" width="'.$width_karte.'" border="0"></a>';
$col = $col+1;
}
echo '</td>';
echo '</tr>';
echo '<tr class="eiko_karte_tr">';

echo '<td class="eiko_karte_td" colspan ="'.$col.'">';

echo '<span style="font-size:9px; color:#969696;">&nbsp;&nbsp;&nbsp;&copy; Deutscher Wetterdienst, (DWD) </a></span>';
echo '</td>';
echo '</tr>';


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


