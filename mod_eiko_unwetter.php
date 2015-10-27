<?php
/**
 * @copyright	@copyright	Copyright (c) 2015 einsatzkomponente.de (http://einsatzkomponente.de). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$link = 'http://www.wettergefahren.de/DWD/warnungen/warnapp/warnings.html';
//$link = 'http://www.dwd.de/DWD/warnungen/warnapp/json/warnings.html';


$class_sfx = htmlspecialchars($params->get('class_sfx'));
$curl = $params->get( 'curl','1' );
$kreis = $params->get( 'kreis','Kreis Leer' );
$kreis = $params->get( 'kreis_first',$kreis );
$css = $params->get( 'eiko_unwetter_css','.eiko_unwetter_h2 { color:#ffffff; } 
.eiko_unwetter_th { background-color:#324A92; color:#E2E9FD; height: 23px; border: solid 1px #808080;  }
.eiko_unwetter_td { text-align: left; font-weight: normal; padding: 5px; background-color: #E2E9FD; border: solid 1px #808080; }
.eiko_unwetter_table { border-collapse: collapse; }
.eiko_unwetter_span {} 
' );
$layout = $params->get( 'layout','layout_1' );
$width = $params->get( 'width','100%' );
$bundesland = $params->get('bl','bl09');
$warnkarte = $params->get('warnkarte','1');
$unwetter = $params->get('unwetter','0');


$unwetterkarte = $params->get('unwetterkarte','1');
$waldbrandkarte = $params->get('waldbrandkarte','1');
$graslandkarte = $params->get('graslandkarte','1');
$titel_karte = $params->get('titel_karte','1');
$width_karte = $params->get('width_karte');



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
  
  
  $show_germany = false;
  
switch ($bundesland)
{
	case 'bl01': $bundesland_name = 'Baden-Württemberg'; $schild = 'SU';break;
	case 'bl02': $bundesland_name = 'Bayern'; $schild = 'MS';break;
	case 'bl03': $bundesland_name = 'Berlin'; $schild = 'PD';break;
	case 'bl04': $bundesland_name = 'Brandenburg'; $schild = 'PD';break;
	case 'bl05': $bundesland_name = 'Bremen'; $schild = 'HA';break;
	case 'bl06': $bundesland_name = 'Hamburg'; $schild = 'HA';break;
	case 'bl07': $bundesland_name = 'Hessen'; $schild = 'OF';break;
	case 'bl08': $bundesland_name = 'Mecklenburg-Vorpommern'; $schild = 'PD';break;
	case 'bl09': $bundesland_name = 'Niedersachsen'; $schild = 'HA';break;
	case 'bl10': $bundesland_name = 'Nordrhein-Westfalen'; $schild = 'EM';break;
	case 'bl11': $bundesland_name = 'Rheinland-Pfalz'; $schild = 'OF';break;
	case 'bl12': $bundesland_name = 'Saarland'; $schild = 'OF';break;
	case 'bl13': $bundesland_name = 'Sachsen'; $schild = 'LZ';break;
	case 'bl14': $bundesland_name = 'Sachsen-Anhalt'; $schild = 'LZ';break;
	case 'bl15': $bundesland_name = 'Schleswig-Holstein'; $schild = 'HA';break;
	case 'bl16': $bundesland_name = 'Thüringen'; $schild = 'LZ';break;
	case 'gesamt': $bundesland_name = 'Deutschland'; $show_germany=true;break;
	default: $bundesland_name = 'Niedersachsen'; $schild = 'HA';break;
}

$letzte_akt = strstr($lines, '<strong>Letzte Aktualisierung:', false) ; 

if ($letzte_akt) :

					$letzte_akt = strstr($letzte_akt, '</strong>', true) ; 
					$letzte_akt = $letzte_akt.'</strong> Uhr';
					$letzte_akt = strip_tags($letzte_akt);

					require(JModuleHelper::getLayoutPath('mod_eiko_unwetter', $params->get('layout', 'layout_1')));

else: 
					echo '<span style="background-color:#ff0000;color:#ffffff;padding:2px;font-weight:bold;">mod_eiko_unwetter Fehler:</span><br /><span style="background-color:#ff0000;color:#ffffff;padding:2px;">Die Wetterdaten konnten nicht korrekt geladen werden !!</span><br /><span style="background-color:#ff0000;color:#ffffff;padding:2px;font-size:8px;">Bitte informieren Sie den Webmaster.</span>';
endif;