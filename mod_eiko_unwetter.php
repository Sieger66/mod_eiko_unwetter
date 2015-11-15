<?php
/**
 * @copyright	@copyright	Copyright (c) 2015 einsatzkomponente.de (http://einsatzkomponente.de). All rights reserved.
 * @license		http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;


$regionName = '';
$altitudeEnd = '';
$start = '';  
$headline = '';
$event = '';
$instruction = ''; 
$description = '';
$end = '';
$type = '';
$level = '';
$state = '';
$link = '';

//$link = 'http://www.wettergefahren.de/DWD/warnungen/warnapp/warnings.html';
//$link = 'http://www.dwd.de/DWD/warnungen/warnapp/json/warnings.html';
$link = 'http://www.wettergefahren.de/DWD/warnungen/warnapp/warnings.json';

$show_level_type = $params->get('show_level_type','0');
$show_instruction = $params->get('show_instruction','0');
$show_description = $params->get('show_description','1');
$show_event = $params->get('show_event','0');
$show_state = $params->get('show_state','0');
$hide_on_action = $params->get('hide_on_action','0');
$show_warn_image = $params->get('show_warn_image','1');


$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$class_sfx = htmlspecialchars($params->get('class_sfx'));

$curl = $params->get( 'curl','1' );
$kreis = $params->get( 'kreis','903457001' );
$kreis = $params->get( 'kreis_name_first',$kreis );
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

switch ($kreis)
{
case '101001000' : $kreis_name='Stadt Flensburg';$kennung='FLX';break;
case '101002000' : $kreis_name='Stadt Kiel';$kennung='KIX';break;
case '101003000' : $kreis_name='Hansestadt Lübeck';$kennung='HLX';break;
case '101004000' : $kreis_name='Stadt Neumünster';$kennung='NMS';break;
case '101053000' : $kreis_name='kreis_name Herzogtum Lauenburg';$kennung='RZX';break;
case '101060000' : $kreis_name='Kreis Segeberg';$kennung='SEX';break;
case '101061000' : $kreis_name='Kreis Steinburg';$kennung='IZX';break;
case '101062000' : $kreis_name='Kreis Stormarn';$kennung='ODX';break;
case '102000000' : $kreis_name='Hansestadt Hamburg';$kennung='HHX';break;
case '103101000' : $kreis_name='Stadt Braunschweig';$kennung='BSX';break;
case '103102000' : $kreis_name='Stadt Salzgitter';$kennung='SZX';break;
case '103103000' : $kreis_name='Stadt Wolfsburg';$kennung='WOB';break;
case '103151000' : $kreis_name='Kreis Gifhorn';$kennung='GIF';break;
case '103152000' : $kreis_name='Kreis und Stadt Göttingen';$kennung='GOE';break;
case '103153000' : $kreis_name='Kreis Goslar';$kennung='GSX';break;
case '103154000' : $kreis_name='Kreis Helmstedt';$kennung='HEX';break;
case '103155000' : $kreis_name='Kreis Northeim';$kennung='NOM';break;
case '103156000' : $kreis_name='Kreis Osterode am Harz';$kennung='OHA';break;
case '103157000' : $kreis_name='Kreis Peine';$kennung='PEX';break;
case '103158000' : $kreis_name='Kreis Wolfenbüttel';$kennung='WFX';break;
case '103241000' : $kreis_name='Region Hannover';$kennung='HAN';break;
case '103251000' : $kreis_name='Kreis Diepholz';$kennung='DHX';break;
case '103252000' : $kreis_name='Kreis Hameln-Pyrmont';$kennung='HMX';break;
case '103254000' : $kreis_name='Kreis Hildesheim';$kennung='HIX';break;
case '103255000' : $kreis_name='Kreis Holzminden';$kennung='HOL';break;
case '103256000' : $kreis_name='Kreis Nienburg';$kennung='NIX';break;
case '103257000' : $kreis_name='Kreis Schaumburg';$kennung='SHG';break;
case '103351000' : $kreis_name='Kreis Celle';$kennung='CEL';break;
case '103353000' : $kreis_name='Kreis Harburg';$kennung='WLX';break;
case '103354000' : $kreis_name='Kreis Lüchow-Dannenberg';$kennung='DAN';break;
case '103355000' : $kreis_name='Kreis Lüneburg';$kennung='LGX';break;
case '103356000' : $kreis_name='Kreis Osterholz';$kennung='OHZ';break;
case '103357000' : $kreis_name='Kreis Rotenburg (Wümme)';$kennung='ROW';break;
case '103358000' : $kreis_name='Heidekreis';$kennung='SFA';break;
case '103359000' : $kreis_name='Kreis Stade';$kennung='STD';break;
case '103360000' : $kreis_name='Kreis Uelzen';$kennung='UEL';break;
case '103361000' : $kreis_name='Kreis Verden';$kennung='VER';break;
case '103401000' : $kreis_name='Stadt Delmenhorst';$kennung='DEL';break;
case '103402000' : $kreis_name='Stadt Emden';$kennung='EMD';break;
case '103405000' : $kreis_name='Stadt Wilhelmshaven';$kennung='WHV';break;
case '103451000' : $kreis_name='Kreis Ammerland';$kennung='WST';break;
case '103453000' : $kreis_name='Kreis Cloppenburg';$kennung='CLP';break;
case '103454000' : $kreis_name='Kreis Emsland';$kennung='ELX';break;
case '103456000' : $kreis_name='Kreis Grafschaft Bentheim';$kennung='NOH';break;
case '903458999' : $kreis_name='Kreis und Stadt Oldenburg';$kennung='OLX';break;
case '903459999' : $kreis_name='Kreis und Stadt Osnabrück';$kennung='OSX';break;
case '103460000' : $kreis_name='Kreis Vechta';$kennung='VEC';break;
case '104011000' : $kreis_name='Hansestadt Bremen';$kennung='HBX';break;
case '104012000' : $kreis_name='Stadt Bremerhaven';$kennung='BHV';break;
case '105111000' : $kreis_name='Stadt Düsseldorf';$kennung='DXX';break;
case '105112000' : $kreis_name='Stadt Duisburg';$kennung='DUX';break;
case '105113000' : $kreis_name='Stadt Essen';$kennung='EXX';break;
case '105114000' : $kreis_name='Stadt Krefeld';$kennung='KRX';break;
case '105116000' : $kreis_name='Stadt Mönchengladbach';$kennung='MGX';break;
case '105117000' : $kreis_name='Stadt Mülheim an der Ruhr';$kennung='MHX';break;
case '105119000' : $kreis_name='Stadt Oberhausen';$kennung='OBX';break;
case '105120000' : $kreis_name='Stadt Remscheid';$kennung='RSX';break;
case '105122000' : $kreis_name='Stadt Solingen';$kennung='SGX';break;
case '105124000' : $kreis_name='Stadt Wuppertal';$kennung='WXX';break;
case '105154000' : $kreis_name='Kreis Kleve';$kennung='KLE';break;
case '105158000' : $kreis_name='Kreis Mettmann';$kennung='MEX';break;
case '105162000' : $kreis_name='Rhein-Kreis Neuss';$kennung='NEX';break;
case '105166000' : $kreis_name='Kreis Viersen';$kennung='VIE';break;
case '105170000' : $kreis_name='Kreis Wesel';$kennung='WES';break;
case '105314000' : $kreis_name='Bundesstadt Bonn';$kennung='BNX';break;
case '105315000' : $kreis_name='Stadt Köln';$kennung='KXX';break;
case '105316000' : $kreis_name='Stadt Leverkusen';$kennung='LEV';break;
case '105354000' : $kreis_name='StädteRegion Aachen';$kennung='ACX';break;
case '105358000' : $kreis_name='Kreis Düren';$kennung='DNX';break;
case '105362000' : $kreis_name='Rhein-Erft-Kreis';$kennung='BMX';break;
case '105366000' : $kreis_name='Kreis Euskirchen';$kennung='EUS';break;
case '105370000' : $kreis_name='Kreis Heinsberg';$kennung='HSX';break;
case '105374000' : $kreis_name='Oberbergischer Kreis';$kennung='GMX';break;
case '105378000' : $kreis_name='Rheinisch-Bergischer Kreis';$kennung='GLX';break;
case '105382000' : $kreis_name='Rhein-Sieg-Kreis';$kennung='SUX';break;
case '105512000' : $kreis_name='Stadt Bottrop';$kennung='BOT';break;
case '105513000' : $kreis_name='Stadt Gelsenkirchen';$kennung='GEX';break;
case '105515000' : $kreis_name='Stadt Münster';$kennung='MSX';break;
case '105554000' : $kreis_name='Kreis Borken';$kennung='BOR';break;
case '105558000' : $kreis_name='Kreis Coesfeld';$kennung='COE';break;
case '105562000' : $kreis_name='Kreis Recklinghausen';$kennung='REX';break;
case '105566000' : $kreis_name='Kreis Steinfurt';$kennung='STX';break;
case '105570000' : $kreis_name='Kreis Warendorf';$kennung='WAF';break;
case '105711000' : $kreis_name='Stadt Bielefeld';$kennung='BIX';break;
case '105754000' : $kreis_name='Kreis Gütersloh';$kennung='GTX';break;
case '105758000' : $kreis_name='Kreis Herford';$kennung='HFX';break;
case '105762000' : $kreis_name='Kreis Höxter';$kennung='HXX';break;
case '105766000' : $kreis_name='Kreis Lippe';$kennung='LIP';break;
case '105770000' : $kreis_name='Kreis Minden-Lübbecke';$kennung='MIX';break;
case '105774000' : $kreis_name='Kreis Paderborn';$kennung='PBX';break;
case '105911000' : $kreis_name='Stadt Bochum';$kennung='BOX';break;
case '105913000' : $kreis_name='Stadt Dortmund';$kennung='DOX';break;
case '105914000' : $kreis_name='Stadt Hagen';$kennung='HAX';break;
case '105915000' : $kreis_name='Kreis Hamm';$kennung='HAM';break;
case '105916000' : $kreis_name='Stadt Herne';$kennung='HER';break;
case '105954000' : $kreis_name='Ennepe-Ruhr-Kreis';$kennung='ENX';break;
case '105958000' : $kreis_name='Hochsauerlandkreis';$kennung='HSK';break;
case '105962000' : $kreis_name='Märkischer Kreis';$kennung='MKX';break;
case '105966000' : $kreis_name='Kreis Olpe';$kennung='OEX';break;
case '105970000' : $kreis_name='Kreis Siegen-Wittgenstein';$kennung='SIX';break;
case '105974000' : $kreis_name='Kreis Soest';$kennung='SOX';break;
case '105978000' : $kreis_name='Kreis Unna';$kennung='UNX';break;
case '106412000' : $kreis_name='Stadt Frankfurt am Main';$kennung='FXX';break;
case '106414000' : $kreis_name='Stadt Wiesbaden';$kennung='WIX';break;
case '106431000' : $kreis_name='Kreis Bergstraße';$kennung='HPX';break;
case '906432999' : $kreis_name='Kreis Darmstadt-Dieburg und Stadt Darmstadt';$kennung='DAX';break;
case '106433000' : $kreis_name='Kreis Groß-Gerau';$kennung='GGX';break;
case '106434000' : $kreis_name='Hochtaunuskreis';$kennung='HGX';break;
case '106435000' : $kreis_name='Main-Kinzig-Kreis und Stadt Hanau';$kennung='HUX';break;
case '106436000' : $kreis_name='Main-Taunus-Kreis';$kennung='MTK';break;
case '106437000' : $kreis_name='Odenwaldkreis';$kennung='ERB';break;
case '906438999' : $kreis_name='Kreis und Stadt Offenbach';$kennung='OFX';break;
case '106439000' : $kreis_name='Rheingau-Taunus-Kreis';$kennung='RUD';break;
case '106440000' : $kreis_name='Wetteraukreis';$kennung='FBX';break;
case '106531000' : $kreis_name='Kreis Gießen';$kennung='GIX';break;
case '106532000' : $kreis_name='Lahn-Dill-Kreis';$kennung='LDK';break;
case '106533000' : $kreis_name='Kreis Limburg-Weilburg';$kennung='LMX';break;
case '106534000' : $kreis_name='Kreis Marburg-Biedenkopf';$kennung='MRX';break;
case '106535000' : $kreis_name='Vogelsbergkreis';$kennung='VBX';break;
case '106631000' : $kreis_name='Kreis Fulda';$kennung='FDX';break;
case '106632000' : $kreis_name='Kreis Hersfeld-Rotenburg';$kennung='HEF';break;
case '906633999' : $kreis_name='Kreis und Stadt Kassel';$kennung='KSX';break;
case '106634000' : $kreis_name='Schwalm-Eder-Kreis';$kennung='HRX';break;
case '106635000' : $kreis_name='Kreis Waldeck-Frankenberg';$kennung='KBX';break;
case '106636000' : $kreis_name='Werra-Meissner-Kreis';$kennung='ESW';break;
case '107111000' : $kreis_name='Stadt Koblenz';$kennung='KOX';break;
case '107131000' : $kreis_name='Kreis Ahrweiler';$kennung='AWX';break;
case '107132000' : $kreis_name='Kreis Altenkirchen';$kennung='AKX';break;
case '107133000' : $kreis_name='Kreis Bad Kreuznach';$kennung='KHX';break;
case '107134000' : $kreis_name='Kreis Birkenfeld';$kennung='BIR';break;
case '107135000' : $kreis_name='Kreis Cochem-Zell';$kennung='COC';break;
case '107137000' : $kreis_name='Kreis Mayen-Koblenz';$kennung='MYK';break;
case '107138000' : $kreis_name='Kreis Neuwied';$kennung='NRX';break;
case '107140000' : $kreis_name='Rhein-Hunsrück-Kreis';$kennung='SIM';break;
case '107141000' : $kreis_name='Rhein-Lahn-Kreis';$kennung='EMS';break;
case '107143000' : $kreis_name='Westerwaldkreis';$kennung='WWX';break;
case '107231000' : $kreis_name='Kreis Bernkastel-Wittlich';$kennung='WIL';break;
case '107232000' : $kreis_name='Eifelkreis Bitburg-Prüm';$kennung='BIT';break;
case '107233000' : $kreis_name='Kreis Vulkaneifel';$kennung='DAU';break;
case '907235999' : $kreis_name='Kreis Trier-Saarburg und Stadt Trier';$kennung='TRX';break;
case '107311000' : $kreis_name='Stadt Frankenthal';$kennung='FTX';break;
case '107313000' : $kreis_name='Stadt Landau in der Pfalz';$kennung='LDX';break;
case '107316000' : $kreis_name='Stadt Neustadt an der Weinstraße';$kennung='NWX';break;
case '107318000' : $kreis_name='Stadt Speyer';$kennung='SPX';break;
case '107319000' : $kreis_name='Stadt Worms';$kennung='WOX';break;
case '107320000' : $kreis_name='Stadt Zweibrücken';$kennung='ZWX';break;
case '107331000' : $kreis_name='Kreis Alzey-Worms';$kennung='AZX';break;
case '107332000' : $kreis_name='Kreis Bad Dürkheim';$kennung='DUW';break;
case '107333000' : $kreis_name='Donnersbergkreis';$kennung='KIB';break;
case '107334000' : $kreis_name='Kreis Germersheim';$kennung='GER';break;
case '907335999' : $kreis_name='Kreis und Stadt Kaiserslautern';$kennung='KLX';break;
case '107336000' : $kreis_name='Kreis Kusel';$kennung='KUS';break;
case '107337000' : $kreis_name='Kreis Südliche Weinstraße';$kennung='SUW';break;
case '907338999' : $kreis_name='Rhein-Pfalz-Kreis und Stadt Ludwigshafen';$kennung='LUX';break;
case '907339999' : $kreis_name='Kreis Mainz-Bingen und Stadt Mainz';$kennung='MZX';break;
case '907340999' : $kreis_name='Kreis Südwestpfalz und Stadt Pirmasens';$kennung='PSX';break;
case '108111000' : $kreis_name='Stadt Stuttgart';$kennung='SXX';break;
case '108115000' : $kreis_name='Kreis Böblingen';$kennung='BBX';break;
case '108116000' : $kreis_name='Kreis Esslingen';$kennung='ESX';break;
case '108117000' : $kreis_name='Kreis Göppingen';$kennung='GPX';break;
case '108118000' : $kreis_name='Kreis Ludwigsburg';$kennung='LBX';break;
case '108119000' : $kreis_name='Rems-Murr-Kreis';$kennung='WNX';break;
case '908125999' : $kreis_name='Kreis und Stadt Heilbronn';$kennung='HNX';break;
case '108126000' : $kreis_name='Hohenlohekreis';$kennung='KUN';break;
case '108127000' : $kreis_name='Kreis Schwäbisch Hall';$kennung='SHA';break;
case '108128000' : $kreis_name='Main-Tauber-Kreis';$kennung='TBB';break;
case '108135000' : $kreis_name='Kreis Heidenheim';$kennung='HDH';break;
case '108136000' : $kreis_name='Ostalbkreis';$kennung='AAX';break;
case '108211000' : $kreis_name='Stadt Baden-Baden';$kennung='BAD';break;
case '908215999' : $kreis_name='Kreis und Stadt Karlsruhe';$kennung='KAX';break;
case '108216000' : $kreis_name='Kreis Rastatt';$kennung='RAX';break;
case '108222000' : $kreis_name='Stadt Mannheim';$kennung='MAX';break;
case '108225000' : $kreis_name='Neckar-Odenwald-Kreis';$kennung='MOS';break;
case '908226999' : $kreis_name='Rhein-Neckar-Kreis und Stadt Heidelberg';$kennung='HDX';break;
case '108235000' : $kreis_name='Kreis Calw';$kennung='CWX';break;
case '908236999' : $kreis_name='Enzkreis und Stadt Pforzheim';$kennung='PFX';break;
case '108237000' : $kreis_name='Kreis Freudenstadt';$kennung='FDS';break;
case '908315999' : $kreis_name='Kreis Breisgau-Hochschwarzwald und Stadt Freiburg';$kennung='FRX';break;
case '108316000' : $kreis_name='Kreis Emmendingen';$kennung='EMX';break;
case '108317000' : $kreis_name='Ortenaukreis';$kennung='OGX';break;
case '108325000' : $kreis_name='Kreis Rottweil';$kennung='RWX';break;
case '108326000' : $kreis_name='Schwarzwald-Baar-Kreis';$kennung='VSX';break;
case '108327000' : $kreis_name='Kreis Tuttlingen';$kennung='TUT';break;
case '108335000' : $kreis_name='Kreis Konstanz';$kennung='KNX';break;
case '108336000' : $kreis_name='Kreis Lörrach';$kennung='LOE';break;
case '108337000' : $kreis_name='Kreis Waldshut';$kennung='WTX';break;
case '108415000' : $kreis_name='Kreis Reutlingen';$kennung='RTX';break;
case '108416000' : $kreis_name='Kreis Tübingen';$kennung='TUE';break;
case '108417000' : $kreis_name='Zollernalbkreis';$kennung='BLX';break;
case '908425999' : $kreis_name='Alb-Donau-kreis und Stadt Ulm';$kennung='ULX';break;
case '108426000' : $kreis_name='Kreis Biberach';$kennung='BCX';break;
case '108435000' : $kreis_name='Bodenseekreis';$kennung='FNX';break;
case '108436000' : $kreis_name='Kreis Ravensburg';$kennung='RVX';break;
case '108437000' : $kreis_name='Kreis Sigmaringen';$kennung='SIG';break;
case '109161000' : $kreis_name='Stadt Ingolstadt';$kennung='INX';break;
case '109171000' : $kreis_name='Kreis Altötting';$kennung='AOX';break;
case '109172000' : $kreis_name='Kreis Berchtesgadener Land';$kennung='BGL';break;
case '109173000' : $kreis_name='Kreis Bad Tölz-Wolfratshausen';$kennung='TOL';break;
case '109174000' : $kreis_name='Kreis Dachau';$kennung='DAH';break;
case '109175000' : $kreis_name='Kreis Ebersberg';$kennung='EBE';break;
case '109176000' : $kreis_name='Kreis Eichstätt';$kennung='EIX';break;
case '109177000' : $kreis_name='Kreis Erding';$kennung='EDX';break;
case '109178000' : $kreis_name='Kreis Freising';$kennung='FSX';break;
case '109179000' : $kreis_name='Kreis Fürstenfeldbruck';$kennung='FFB';break;
case '109180000' : $kreis_name='Kreis Garmisch-Partenkirchen';$kennung='GAP';break;
case '109181000' : $kreis_name='Kreis Landsberg am Lech';$kennung='LLX';break;
case '109182000' : $kreis_name='Kreis Miesbach';$kennung='MBX';break;
case '109183000' : $kreis_name='Kreis Mühldorf a. Inn';$kennung='MUE';break;
case '909184999' : $kreis_name='Kreis und Stadt München';$kennung='MXX';break;
case '109185000' : $kreis_name='Kreis Neuburg-Schrobenhausen';$kennung='NDX';break;
case '109186000' : $kreis_name='Kreis Pfaffenhofen a.d. Ilm';$kennung='PAF';break;
case '909187999' : $kreis_name='Kreis und Stadt Rosenheim';$kennung='ROX';break;
case '109188000' : $kreis_name='Kreis Starnberg';$kennung='STA';break;
case '109189000' : $kreis_name='Kreis Traunstein';$kennung='TSX';break;
case '109190000' : $kreis_name='Kreis Weilheim-Schongau';$kennung='WMX';break;
case '109271000' : $kreis_name='Kreis Deggendorf';$kennung='DEG';break;
case '109272000' : $kreis_name='Kreis Freyung-Grafenau';$kennung='FRG';break;
case '109273000' : $kreis_name='Kreis Kelheim';$kennung='KEH';break;
case '909274999' : $kreis_name='Kreis und Stadt Landshut';$kennung='LAX';break;
case '909275999' : $kreis_name='Kreis und Stadt Passau';$kennung='PAX';break;
case '109276000' : $kreis_name='Kreis Regen';$kennung='REG';break;
case '109277000' : $kreis_name='Kreis Rottal-Inn';$kennung='PAN';break;
case '909278999' : $kreis_name='Kreis Straubing-Bogen und Stadt Straubing';$kennung='SRX';break;
case '109279000' : $kreis_name='Kreis Dingolfing-Landau';$kennung='DGF';break;
case '109361000' : $kreis_name='Stadt Amberg';$kennung='AMX';break;
case '109363000' : $kreis_name='Stadt Weiden in der Oberpfalz';$kennung='WEN';break;
case '109371000' : $kreis_name='Kreis Amberg-Sulzbach';$kennung='ASX';break;
case '109372000' : $kreis_name='Kreis Cham';$kennung='CHA';break;
case '109373000' : $kreis_name='Kreis Neumarkt i.d. OPf.';$kennung='NMX';break;
case '109374000' : $kreis_name='Kreis Neustadt a.d. Waldnaab';$kennung='NEW';break;
case '909375999' : $kreis_name='Kreis und Stadt Regensburg';$kennung='RXX';break;
case '109376000' : $kreis_name='Kreis Schwandorf';$kennung='SAD';break;
case '109377000' : $kreis_name='Kreis Tirschenreuth';$kennung='TIR';break;
case '909471999' : $kreis_name='Kreis und Stadt Bamberg';$kennung='BAX';break;
case '909472999' : $kreis_name='Kreis und Stadt Bayreuth';$kennung='BTX';break;
case '909473999' : $kreis_name='Kreis und Stadt Coburg';$kennung='COX';break;
case '109474000' : $kreis_name='Kreis Forchheim';$kennung='FOX';break;
case '909475999' : $kreis_name='Kreis und Stadt Hof';$kennung='HOX';break;
case '109476000' : $kreis_name='Kreis Kronach';$kennung='KCX';break;
case '109477000' : $kreis_name='Kreis Kulmbach';$kennung='KUX';break;
case '109478000' : $kreis_name='Kreis Lichtenfels';$kennung='LIF';break;
case '109479000' : $kreis_name='Kreis Wunsiedel';$kennung='WUN';break;
case '109562000' : $kreis_name='Stadt Erlangen';$kennung='ERX';break;
case '109564000' : $kreis_name='Stadt Nürnberg';$kennung='NXX';break;
case '109565000' : $kreis_name='Stadt Schwabach';$kennung='SCX';break;
case '909571999' : $kreis_name='Kreis und Stadt Ansbach';$kennung='ANX';break;
case '109572000' : $kreis_name='Kreis Erlangen-Höchstadt';$kennung='ERH';break;
case '909573999' : $kreis_name='Kreis und Stadt Fürth';$kennung='FUE';break;
case '109574000' : $kreis_name='Kreis Nürnberger Land';$kennung='LAU';break;
case '109575000' : $kreis_name='Kreis Neustadt a.d. Aisch - Bad Windsheim';$kennung='NEA';break;
case '109576000' : $kreis_name='Kreis Roth';$kennung='RHX';break;
case '109577000' : $kreis_name='Kreis Weißenburg-Gunzenhausen';$kennung='WUG';break;
case '909671999' : $kreis_name='Kreis und Stadt Aschaffenburg';$kennung='ABX';break;
case '109672000' : $kreis_name='Kreis Bad Kissingen';$kennung='KGX';break;
case '109673000' : $kreis_name='Kreis Rhön-Grabfeld';$kennung='NES';break;
case '109674000' : $kreis_name='Kreis Haßberge';$kennung='HAS';break;
case '109675000' : $kreis_name='Kreis Kitzingen';$kennung='KTX';break;
case '109676000' : $kreis_name='Kreis Miltenberg';$kennung='MIL';break;
case '109677000' : $kreis_name='Kreis Main-Spessart';$kennung='MSP';break;
case '909678999' : $kreis_name='Kreis und Stadt Schweinfurt';$kennung='SWX';break;
case '909679999' : $kreis_name='Kreis und Stadt Würzburg';$kennung='WUE';break;
case '109762000' : $kreis_name='Stadt Kaufbeuren';$kennung='KFX';break;
case '109763000' : $kreis_name='Stadt Kempten (Allgäu)';$kennung='KEX';break;
case '109764000' : $kreis_name='Stadt Memmingen';$kennung='MMX';break;
case '109771000' : $kreis_name='Kreis Aichach-Friedberg';$kennung='AIC';break;
case '109772000' : $kreis_name='Kreis und Stadt Augsburg';$kennung='AXX';break;
case '109773000' : $kreis_name='Kreis Dillingen a.d. Donau';$kennung='DLG';break;
case '109774000' : $kreis_name='Kreis Günzburg';$kennung='GZX';break;
case '109775000' : $kreis_name='Kreis Neu-Ulm';$kennung='NUX';break;
case '109776000' : $kreis_name='Kreis Lindau';$kennung='LIX';break;
case '109777000' : $kreis_name='Kreis Ostallgäu';$kennung='OAL';break;
case '109778000' : $kreis_name='Kreis Unterallgäu';$kennung='MNX';break;
case '109779000' : $kreis_name='Kreis Donau-Ries';$kennung='DON';break;
case '109780000' : $kreis_name='Kreis Oberallgäu';$kennung='OAX';break;
case '110041000' : $kreis_name='Regionalverband Saarbrücken';$kennung='SBX';break;
case '110042000' : $kreis_name='Kreis Merzig-Wadern';$kennung='MZG';break;
case '110043000' : $kreis_name='Kreis Neunkirchen';$kennung='NKX';break;
case '110044000' : $kreis_name='Kreis Saarlouis';$kennung='SLS';break;
case '110045000' : $kreis_name='Saarpfalz-kreis';$kennung='HOM';break;
case '110046000' : $kreis_name='Kreis St. Wendel';$kennung='WND';break;
case '111000000' : $kreis_name='Land Berlin';$kennung='BXX';break;
case '112051000' : $kreis_name='Stadt Brandenburg';$kennung='BRB';break;
case '112052000' : $kreis_name='Stadt Cottbus';$kennung='CBX';break;
case '112053000' : $kreis_name='Stadt Frankfurt (Oder)';$kennung='FFX';break;
case '112054000' : $kreis_name='Stadt Potsdam';$kennung='PXX';break;
case '112060000' : $kreis_name='Kreis Barnim';$kennung='BAR';break;
case '112061000' : $kreis_name='Kreis Dahme-Spreewald';$kennung='LDS';break;
case '112062000' : $kreis_name='Kreis Elbe-Elster';$kennung='EEX';break;
case '112063000' : $kreis_name='Kreis Havelland';$kennung='HVL';break;
case '112064000' : $kreis_name='Kreis Märkisch-Oderland';$kennung='MOL';break;
case '112065000' : $kreis_name='Kreis Oberhavel';$kennung='OHV';break;
case '112066000' : $kreis_name='Kreis Oberspreewald-Lausitz';$kennung='OSL';break;
case '112067000' : $kreis_name='Kreis Oder-Spree';$kennung='LOS';break;
case '112068000' : $kreis_name='Kreis Ostprignitz-Ruppin';$kennung='OPR';break;
case '112069000' : $kreis_name='Kreis Potsdam-Mittelmark';$kennung='PMX';break;
case '112070000' : $kreis_name='Kreis Prignitz';$kennung='PRX';break;
case '112071000' : $kreis_name='Kreis Spree-Neiße';$kennung='SPN';break;
case '112072000' : $kreis_name='Kreis Teltow-Fläming';$kennung='TFX';break;
case '112073000' : $kreis_name='Kreis Uckermark';$kennung='UMX';break;
case '113003000' : $kreis_name='Hansestadt Rostock';$kennung='HRO';break;
case '113004000' : $kreis_name='Stadt Schwerin';$kennung='SNX';break;
case '114511000' : $kreis_name='Stadt Chemnitz';$kennung='CXX';break;
case '114521000' : $kreis_name='Erzgebirgskreis';$kennung='EKX';break;
case '114612000' : $kreis_name='Stadt Dresden';$kennung='DDX';break;
case '114627000' : $kreis_name='Kreis Meißen';$kennung='MEI';break;
case '114713000' : $kreis_name='Stadt Leipzig';$kennung='LXX';break;
case '114729000' : $kreis_name='Kreis Leipzig';$kennung='LLK';break;
case '115001000' : $kreis_name='Stadt Dessau-Roßlau';$kennung='DEX';break;
case '115002000' : $kreis_name='Stadt Halle (Saale)';$kennung='HAL';break;
case '115003000' : $kreis_name='Stadt Magdeburg';$kennung='MDX';break;
case '115081000' : $kreis_name='Altmarkkreis Salzwedel';$kennung='SAW';break;
case '115082000' : $kreis_name='Kreis Anhalt-Bitterfeld';$kennung='ABI';break;
case '115083000' : $kreis_name='Kreis Börde';$kennung='BOE';break;
case '115084000' : $kreis_name='Burgenlandkreis';$kennung='BLK';break;
case '115086000' : $kreis_name='Kreis Jerichower Land';$kennung='JLX';break;
case '115087000' : $kreis_name='Kreis Mansfeld-Südharz';$kennung='MSH';break;
case '115088000' : $kreis_name='Saalekreis';$kennung='SKX';break;
case '115089000' : $kreis_name='Salzlandkreis';$kennung='SAL';break;
case '115090000' : $kreis_name='Kreis Stendal';$kennung='SDL';break;
case '115091000' : $kreis_name='Kreis Wittenberg';$kennung='WBX';break;
case '116051000' : $kreis_name='Stadt Erfurt';$kennung='EFX';break;
case '116052000' : $kreis_name='Stadt Gera';$kennung='GXX';break;
case '116053000' : $kreis_name='Stadt Jena';$kennung='JXX';break;
case '116054000' : $kreis_name='Stadt Suhl';$kennung='SHL';break;
case '116055000' : $kreis_name='Stadt Weimar';$kennung='WEX';break;
case '116056000' : $kreis_name='Stadt Eisenach';$kennung='EAX';break;
case '116061000' : $kreis_name='Kreis Eichsfeld';$kennung='EIC';break;
case '116062000' : $kreis_name='Kreis Nordhausen';$kennung='NDH';break;
case '116063000' : $kreis_name='Wartburgkreis';$kennung='WAK';break;
case '116064000' : $kreis_name='Unstrut-Hainich-Kreis';$kennung='UHX';break;
case '116065000' : $kreis_name='Kyffhäuserkreis';$kennung='KYF';break;
case '116066000' : $kreis_name='Kreis Schmalkalden-Meiningen';$kennung='SMX';break;
case '116067000' : $kreis_name='Kreis Gotha';$kennung='GTH';break;
case '116068000' : $kreis_name='Kreis Sömmerda';$kennung='SOM';break;
case '116069000' : $kreis_name='Kreis Hildburghausen';$kennung='HBN';break;
case '116070000' : $kreis_name='Ilm-Kreis';$kennung='IKX';break;
case '116071000' : $kreis_name='Kreis Weimarer Land';$kennung='APX';break;
case '116072000' : $kreis_name='Kreis Sonneberg';$kennung='SON';break;
case '116073000' : $kreis_name='Kreis Saalfeld-Rudolstadt';$kennung='SLF';break;
case '116074000' : $kreis_name='Saale-Holzland-Kreis';$kennung='SHK';break;
case '116075000' : $kreis_name='Saale-Orla-Kreis';$kennung='SOK';break;
case '116076000' : $kreis_name='Kreis Greiz';$kennung='GRZ';break;
case '116077000' : $kreis_name='Kreis Altenburger Land';$kennung='ABG';break;
case '201068000' : $kreis_name='Ostholsteinische Seen';$kennung='HOS';break;
case '202006000' : $kreis_name='Alster';$kennung='HAR';break;
case '203159000' : $kreis_name='Northeimer Seenplatte';$kennung='HZM';break;
case '203258000' : $kreis_name='Dümmer See';$kennung='DSH';break;
case '203259000' : $kreis_name='Steinhuder Meer';$kennung='HSM';break;
case '203464000' : $kreis_name='Zwischenahner Meer';$kennung='HZM';break;
case '208438000' : $kreis_name='Bodensee - Mitte';$kennung='BMT';break;
case '208439000' : $kreis_name='Bodensee - West';$kennung='BWT';break;
case '208440000' : $kreis_name='Bodensee - Ost';$kennung='BST';break;
case '209901000' : $kreis_name='Altmühlsee/Brombachsee/Igelsbachsee';$kennung='ALT';break;
case '209902000' : $kreis_name='Rothsee';$kennung='ROT';break;
case '209903000' : $kreis_name='Forggensee';$kennung='FOR';break;
case '209904000' : $kreis_name='Starnberger See';$kennung='STB';break;
case '209905000' : $kreis_name='Ammersee';$kennung='LLA';break;
case '209906000' : $kreis_name='Pilsen-/Wörthsee';$kennung='LLP';break;
case '209908000' : $kreis_name='Walchensee';$kennung='TOW';break;
case '209909000' : $kreis_name='Staffel-/Riegsee';$kennung='STR';break;
case '209910000' : $kreis_name='Tegernsee';$kennung='MBT';break;
case '209911000' : $kreis_name='Schliersee';$kennung='BSS';break;
case '209912000' : $kreis_name='Simssee';$kennung='ROS';break;
case '209913000' : $kreis_name='Chiemsee';$kennung='TSC';break;
case '209914000' : $kreis_name='Waginger/Tachinger See';$kennung='TSW';break;
case '213010000' : $kreis_name='Müritz';$kennung='MUR';break;
case '901051001' : $kreis_name='Kreis Dithmarschen - Binnenland';$kennung='HEB';break;
case '901051002' : $kreis_name='Kreis Dithmarschen - Küste';$kennung='HEK';break;
case '901054001' : $kreis_name='Kreis Nordfriesland - Binnenland';$kennung='NFI';break;
case '901054002' : $kreis_name='Kreis Nordfriesland - Küste';$kennung='NFK';break;
case '901055001' : $kreis_name='Kreis Ostholstein - Binnenland';$kennung='OHI';break;
case '901055002' : $kreis_name='Kreis Ostholstein - Küste';$kennung='OHK';break;
case '901056001' : $kreis_name='Kreis Pinneberg';$kennung='PIX';break;
case '901056002' : $kreis_name='Insel Helgoland';$kennung='PIH';break;
case '901057001' : $kreis_name='Kreis Plön - Binnenland';$kennung='PLI';break;
case '901057002' : $kreis_name='Kreis Plön - Küste';$kennung='PLK';break;
case '901058001' : $kreis_name='Kreis Rendsburg-Eckernförde - Binnenland';$kennung='RDI';break;
case '901058002' : $kreis_name='Kreis Rendsburg-Eckernförde - Küste';$kennung='RDK';break;
case '901059001' : $kreis_name='Kreis Schleswig-Flensburg - Binnenland';$kennung='SLI';break;
case '901059002' : $kreis_name='Kreis Schleswig-Flensburg - Küste';$kennung='SLK';break;
case '903352001' : $kreis_name='Kreis Cuxhaven - Binnenland';$kennung='CUI';break;
case '903352002' : $kreis_name='Kreis Cuxhaven - Küste';$kennung='CUK';break;
case '903452001' : $kreis_name='Kreis Aurich - Binnenland';$kennung='AUI';break;
case '903452002' : $kreis_name='Kreis Aurich - Küste';$kennung='AUK';break;
case '903455001' : $kreis_name='Kreis Friesland - Binnenland';$kennung='FRB';break;
case '903455002' : $kreis_name='Kreis Friesland - Küste';$kennung='FRK';break;
case '903457001' : $kreis_name='Kreis Leer';$kennung='LER';break;
case '903457002' : $kreis_name='Insel Borkum';$kennung='HBO';break;
case '903461001' : $kreis_name='Kreis Wesermarsch - Binnenland';$kennung='BRI';break;
case '903461002' : $kreis_name='Kreis Wesermarsch - Küste';$kennung='BRK';break;
case '903462001' : $kreis_name='Kreis Wittmund - Binnenland';$kennung='WTI';break;
case '903462002' : $kreis_name='Kreis Wittmund - Küste';$kennung='WTK';break;
case '913071001' : $kreis_name='Kreis Mecklenburgische Seenplatte - Nord';$kennung='VON';break;
case '913071002' : $kreis_name='Kreis Mecklenburgische Seenplatte - West';$kennung='VOW';break;
case '913071003' : $kreis_name='Kreis Mecklenburgische Seenplatte - Südost';$kennung='VOS';break;
case '913072001' : $kreis_name='Kreis Rostock - Binnenland Nord';$kennung='GDN';break;
case '913072002' : $kreis_name='Kreis Rostock - Küste';$kennung='GDK';break;
case '913072003' : $kreis_name='Kreis Rostock - Binnenland Süd';$kennung='GDS';break;
case '913073001' : $kreis_name='Kreis Vorpommern-Rügen - Binnenland';$kennung='VRB';break;
case '913073002' : $kreis_name='Kreis Vorpommern-Rügen - Küste';$kennung='VRK';break;
case '913073003' : $kreis_name='Kreis Vorpommern-Rügen - Insel Rügen';$kennung='VRR';break;
case '913074001' : $kreis_name='Kreis Nordwestmecklenburg - Binnenland';$kennung='OWB';break;
case '913074002' : $kreis_name='Kreis Nordwestmecklenburg - Küste';$kennung='OWK';break;
case '913075001' : $kreis_name='Kreis Vorpommern-Greifswald - Binnenland Nord';$kennung='VGN';break;
case '913075002' : $kreis_name='Kreis Vorpommern-Greifswald - Küste Nord';$kennung='VGK';break;
case '913075003' : $kreis_name='Kreis Vorpommern-Greifswald - Binnenland Süd';$kennung='VGS';break;
case '913075004' : $kreis_name='Kreis Vorpommern-Greifswald - Küste Süd';$kennung='VGO';break;
case '913076001' : $kreis_name='Kreis Ludwigslust-Parchim - West';$kennung='LPW';break;
case '913076002' : $kreis_name='Kreis Ludwigslust-Parchim - Ost';$kennung='LPO';break;
case '914522001' : $kreis_name='Kreis Mittelsachsen - Tiefland';$kennung='FGF';break;
case '914522002' : $kreis_name='Kreis Mittelsachsen - Bergland';$kennung='FGH';break;
case '914523001' : $kreis_name='Vogtlandkreis - Tiefland';$kennung='VXF';break;
case '914523002' : $kreis_name='Vogtlandkreis - Bergland';$kennung='VXH';break;
case '914524001' : $kreis_name='Kreis Zwickau - Tiefland';$kennung='ZXF';break;
case '914524002' : $kreis_name='Kreis Zwickau - Bergland';$kennung='ZXH';break;
case '914625001' : $kreis_name='Kreis Bautzen - Tiefland';$kennung='BZF';break;
case '914625002' : $kreis_name='Kreis Bautzen - Bergland';$kennung='BZH';break;
case '914626001' : $kreis_name='Kreis Görlitz - Tiefland';$kennung='GRF';break;
case '914626002' : $kreis_name='Kreis Görlitz - Bergland';$kennung='GRH';break;
case '914628001' : $kreis_name='Kreis Sächsische Schweiz-Osterzgebirge - Tiefland';$kennung='PIF';break;
case '914628002' : $kreis_name='Kreis Sächsische Schweiz-Osterzgebirge - westelbisches Bergland';$kennung='PIW';break;
case '914628003' : $kreis_name='Kreis Sächsische Schweiz-Osterzgebirge - ostelbisches Bergland';$kennung='PIO';break;
case '914730001' : $kreis_name='Kreis Nordsachsen - Nord';$kennung='TON';break;
case '914730002' : $kreis_name='Kreis Nordsachsen - Süd';$kennung='TOS';break;
case '915085001' : $kreis_name='Kreis Harz - Tiefland';$kennung='HZX';break;
case '915085002' : $kreis_name='Kreis Harz - Bergland (Oberharz)';$kennung='HZH';break;	
default: $kreis_name='Kreis Leer';$kennung='LER';break;
}

// DWD Warnstatus (Farbcodierung)
	$DEFCON = array();
	// gelb:    Wetterwarnungen
	$DEFCON[1]['color']     				= 'background-color: #ffeb3b !important;color:#000000 !important;';     
	$DEFCON[1]['status']    				= 'Wetterwarnungen';
	// gelb:    Wetterwarnungen
	$DEFCON[2]['color']     				= 'background-color: #ffeb3b !important;color:#000000 !important;';    
	$DEFCON[2]['status']    				= 'Wetterwarnungen';
	// orange:  Warnungen vor markantem Wetter	
	$DEFCON[3]['color']     				= 'background-color: #fb8c00 !important;color:#000000 !important;';    
	$DEFCON[3]['status']    				= 'Warnungen vor markantem Wetter';
	// rot:     Unwetterwarnungen
	$DEFCON[4]['color']     				= 'background-color: #e53935 !important;color:#ffffff !important;border-color:#ffffff !important;';    
	$DEFCON[4]['status']    				= 'Unwetterwarnungen';
	//violett: Warnungen vor extremen Unwetter
	$DEFCON[5]['color']     				= 'background-color: #880e4f  !important;color:#ffffff !important;border-color:#ffffff !important;'; 
	$DEFCON[5]['status']    				= 'Warnungen vor extremen Unwetter';

	
	$trans = array(
    'Monday'    => 'Montag',
    'Tuesday'   => 'Dienstag',
    'Wednesday' => 'Mittwoch',
    'Thursday'  => 'Donnerstag',
    'Friday'    => 'Freitag',
    'Saturday'  => 'Samstag',
    'Sunday'    => 'Sonntag',
    'Mon'       => 'Mo',
    'Tue'       => 'Di',
    'Wed'       => 'Mi',
    'Thu'       => 'Do',
    'Fri'       => 'Fr',
    'Sat'       => 'Sa',
    'Sun'       => 'So',
    'January'   => 'Januar',
    'February'  => 'Februar',
    'March'     => 'März',
    'May'       => 'Mai',
    'June'      => 'Juni',
    'July'      => 'Juli',
    'October'   => 'Oktober',
    'December'  => 'Dezember'
);


if ($letzte_akt) :


					require(JModuleHelper::getLayoutPath('mod_eiko_unwetter', $params->get('layout', 'layout_1')));

else: 
					echo '<span style="background-color:#ff0000;color:#ffffff;padding:2px;font-weight:bold;">mod_eiko_unwetter Fehler:</span><br /><span style="background-color:#ff0000;color:#ffffff;padding:2px;">Die Wetterdaten konnten nicht korrekt geladen werden !!</span><br /><span style="background-color:#ff0000;color:#ffffff;padding:2px;font-size:8px;">Bitte informieren Sie den Webmaster.</span>';
endif;