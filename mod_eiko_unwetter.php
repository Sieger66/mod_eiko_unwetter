<?php
/**
 * @copyright	@copyright	Copyright (c) 2015 einsatzkomponente.de (http://einsatzkomponente.de). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

// include the syndicate functions only once
require_once __DIR__ . '/helper.php';


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

require(JModuleHelper::getLayoutPath('mod_eiko_unwetter', $params->get('layout', 'layout_1')));