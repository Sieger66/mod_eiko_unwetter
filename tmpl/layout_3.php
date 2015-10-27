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
			if ($show_germany) :
			echo '<a target="_BLANK" href="http://www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="http://www.dwd.de/DWD/warnungen/warnapp/json/warning_map.png" class="img_wetterkarte_1" width="'.$width_karte.'" border="0"></a>';
			else:
			echo '<a target="_BLANK" href="http://www.dwd.de/DE/wetter/warnungen/warnWetter_node.html"><img src="http://www.dwd.de/DWD/warnungen/warnstatus/Schilder'.$schild.'.jpg"  class="img_wetterkarte_2" width="'.$width_karte.'" border="0"></a>';
		endif;
$col = $col+1;
}

echo '</td>';
echo '<td class="eiko_karte_td">';

if($waldbrandkarte == "1")
{
echo '<a href="http://www.dwd.de/DE/leistungen/waldbrandgef_bl/waldbrandgefbl.html?nn=16102&cl2Categories_Bundesland=wbh_'.$bundesland.'" target="_blank"><img src="http://www.dwd.de/DWD/warnungen/agrar/wbx/wbx_stationen.png" title="Waldbrandgefahrenindex" width="'.$width_karte.'" border="0"></a>';
$col = $col+1;
}

echo '</td>';
echo '<td class="eiko_karte_td">';

if($graslandkarte == "1")
{
echo '<a href="http://www.dwd.de/DE/leistungen/graslandfi_bl/graslandfibl.html?nn=16102&cl2Categories_Bundesland=glh_'.$bundesland.'" target="_blank"><img src="http://www.dwd.de/DWD/warnungen/agrar/glfi/glfi_stationen.png" title="Graslandfeuer-Index" width="'.$width_karte.'" border="0"></a>';
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

