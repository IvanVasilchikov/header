<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<? IncludeTemplateLangFile(__FILE__); ?>
<?
#geoip block
use Bitrix\Main\Loader,
    Rover\GeoIp\Location;

CModule::IncludeModule("iblock");

if ($_COOKIE['CITY'] == NULL || $_COOKIE['RELOAD_CITY'] == NULL) {
    if (Loader::includeModule('rover.geoip')) {
        try {
            $location = Location::getInstance(Location::getCurIp());
            $loc = $location->getCityName();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    } else echo 'Ошибка модуля GeoIP';

    $res = new CIBlockElement;
    $arSelect = Array("ID", "NAME", "PROPERTY_PHONE", "PROPERTY_ADDRESS", "PROPERTY_COORDS", "PROPERTY_WORKTIME", "CODE", "PROPERTY_REGION_TITLE");

    $arFilter = Array("IBLOCK_ID" => 24, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "NAME" => $loc);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    while ($ob = $res->GetNextElement()) {
        $ob = $ob->GetFields();
        if ($loc == $ob['NAME']) {
            $setted_loc = $ob['NAME'];
            $setted_phone = $ob['PROPERTY_PHONE_VALUE'];
            $setted_addres = $ob['PROPERTY_ADDRESS_VALUE'];
            $setted_coords = $ob['PROPERTY_COORDS_VALUE'];
            $setted_worktime = $ob['PROPERTY_WORKTIME_VALUE'];
            $setted_region_title = $ob['PROPERTY_REGION_TITLE_VALUE'];
            $setted_codeName = $ob['CODE'];
            setcookie('CITY', $setted_loc, time() + 60 * 60 * 24, "/");
            setcookie('PHONE', $setted_phone, time() + 60 * 60 * 24, "/");
            setcookie('ADDRES', $setted_addres, time() + 60 * 60 * 24, "/");
            setcookie('COORDS', $setted_coords, time() + 60 * 60 * 24, "/");
            setcookie('WORKTIME', $setted_worktime, time() + 60 * 60 * 24, "/");
            setcookie('CODENAME', $setted_codeName, time() + 60 * 60 * 24, "/");
            setcookie('REGION_TITLE', $setted_region_title, time() + 60 * 60 * 24, "/");
        }
    }
    if ($setted_loc == NULL) {
        $res = new CIBlockElement;
        $arSelect = Array("ID", "NAME", "PROPERTY_PHONE", "PROPERTY_ADDRESS", "PROPERTY_COORDS", "PROPERTY_WORKTIME", "CODE", "PROPERTY_REGION_TITLE");
        $arFilter = Array("IBLOCK_ID" => 24, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "NAME" => "Москва");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize" => 50), $arSelect);
        while ($ob = $res->GetNextElement()) {
            $ob = $ob->GetFields();

            $setted_loc = $ob['NAME'];
            $setted_phone = $ob['PROPERTY_PHONE_VALUE'];
            $setted_addres = $ob['PROPERTY_ADDRESS_VALUE'];
            $setted_coords = $ob['PROPERTY_COORDS_VALUE'];
            $setted_worktime = $ob['PROPERTY_WORKTIME_VALUE'];
            $setted_region_title = $ob['PROPERTY_REGION_TITLE_VALUE'];
            $setted_codeName = $ob['CODE'];
            setcookie('CITY', $setted_loc, time() + 60 * 60 * 24, "/");
            setcookie('PHONE', $setted_phone, time() + 60 * 60 * 24, "/");
            setcookie('ADDRES', $setted_addres, time() + 60 * 60 * 24, "/");
            setcookie('COORDS', $setted_coords, time() + 60 * 60 * 24, "/");
            setcookie('WORKTIME', $setted_worktime, time() + 60 * 60 * 24, "/");
            setcookie('CODENAME', $setted_codeName, time() + 60 * 60 * 24, "/");
            setcookie('REGION_TITLE', $setted_region_title, time() + 60 * 60 * 24, "/");
        }
    }
} else {
    if ($_COOKIE['RELOAD_CITY']) {
        $loc = $_COOKIE['RELOAD_CITY'];

        $arSelect = Array("ID", "NAME", "PROPERTY_PHONE", "PROPERTY_ADDRESS", "PROPERTY_COORDS", "PROPERTY_WORKTIME", "CODE", "PROPERTY_REGION_TITLE");
        $arFilter = Array("IBLOCK_ID" => 24, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y", "NAME" => $loc);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
        while ($ob = $res->GetNextElement()) {
            $ob = $ob->GetFields();

            if ($loc == $ob['NAME']) {
                $setted_loc = $ob['NAME'];
                $setted_phone = $ob['PROPERTY_PHONE_VALUE'];
                $setted_addres = $ob['PROPERTY_ADDRESS_VALUE'];
                $setted_coords = $ob['PROPERTY_COORDS_VALUE'];
                $setted_worktime = $ob['PROPERTY_WORKTIME_VALUE'];
                $setted_region_title = $ob['PROPERTY_REGION_TITLE_VALUE'];
                $setted_codeName = $ob['CODE'];
                setcookie('CITY', $setted_loc, time() + 60 * 60 * 24, "/");
                setcookie('PHONE', $setted_phone, time() + 60 * 60 * 24, "/");
                setcookie('ADDRES', $setted_addres, time() + 60 * 60 * 24, "/");
                setcookie('COORDS', $setted_coords, time() + 60 * 60 * 24, "/");
                setcookie('WORKTIME', $setted_worktime, time() + 60 * 60 * 24, "/");
                setcookie('CODENAME', $setted_codeName, time() + 60 * 60 * 24, "/");
                setcookie('REGION_TITLE', $setted_region_title, time() + 60 * 60 * 24, "/");
            }
        }
    }
}

$GLOBALS['current_city'] = ($_COOKIE['CITY'] == $setted_loc) ? $_COOKIE['CITY'] : $setted_loc;
?>
<!doctype html>
<html lang="ru">

<head>
    <?$curURL = $_SERVER['REQUEST_URI'];
$urls = explode('/', $curURL);
//if($curURL == "/catalog/moskva/"){
//	header('Location: https://autofrant.ru/');
//}
//if($curURL == "/catalog/moskva/?clear_cache=Y"){
//	header('Location: https://autofrant.ru/');
//}
//if($urls[2] == "moskva"){header('Location: https://autofrant.ru/');}
//if($urls[3] == "moskva"){header('Location: https://autofrant.ru/');}

/*switch ($urls[2]) {
    case "penza":
        $verSubDomainChecker = "itstrue";
        break;
    case "spb":
        $verSubDomainChecker = "itstrue";
        break;
    case "novosibirsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "ekaterinburg":
        $verSubDomainChecker = "itstrue";
        break;
    case "nizhniy-novgorod":
        $verSubDomainChecker = "itstrue";
        break;
    case "kazan":
        $verSubDomainChecker = "itstrue";
        break;
    case "chelyabinsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "omsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "samara":
        $verSubDomainChecker = "itstrue";
        break;
    case "rostov-na-donu":
        $verSubDomainChecker = "itstrue";
        break;
    case "ufa":
        $verSubDomainChecker = "itstrue";
        break;
    case "krasnoyarsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "perm":
        $verSubDomainChecker = "itstrue";
        break;
    case "voronezh":
        $verSubDomainChecker = "itstrue";
        break;
    case "volgograd":
        $verSubDomainChecker = "itstrue";
        break;
    case "abakan":
        $verSubDomainChecker = "itstrue";
        break;
    case "anadyr":
        $verSubDomainChecker = "itstrue";
        break;
    case "astrakhan":
        $verSubDomainChecker = "itstrue";
        break;
    case "barnaul":
        $verSubDomainChecker = "itstrue";
        break;
    case "belgorod":
        $verSubDomainChecker = "itstrue";
        break;
    case "birobidzhan":
        $verSubDomainChecker = "itstrue";
        break;
    case "blagoveshchensk":
        $verSubDomainChecker = "itstrue";
        break;
    case "bryansk":
        $verSubDomainChecker = "itstrue";
        break;
    case "vladivostok":
		$verSubDomainChecker = "itstrue";
        break;
    case "vladikavkaz":
        $verSubDomainChecker = "itstrue";
        break;
    case "vladimir":
        $verSubDomainChecker = "itstrue";
        break;
    case "vologda":
        $verSubDomainChecker = "itstrue";
        break;
    case "groznyy":
        $verSubDomainChecker = "itstrue";
        break;
    case "ivanovo":
        $verSubDomainChecker = "itstrue";
        break;
    case "izhevsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "irkutsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "yoshkar-ola":
        $verSubDomainChecker = "itstrue";
        break;
    case "kaliningrad":
        $verSubDomainChecker = "itstrue";
        break;
    case "kaluga":
        $verSubDomainChecker = "itstrue";
        break;
    case "kemerovo":
        $verSubDomainChecker = "itstrue";
        break;
    case "kirov":
        $verSubDomainChecker = "itstrue";
        break;
    case "kostroma":
        $verSubDomainChecker = "itstrue";
        break;
    case "krasnodar":
        $verSubDomainChecker = "itstrue";
        break;
    case "kurgan":
        $verSubDomainChecker = "itstrue";
        break;
    case "kursk":
        $verSubDomainChecker = "itstrue";
        break;
    case "kyzyl":
        $verSubDomainChecker = "itstrue";
        break;
    case "lipetsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "magadan":
        $verSubDomainChecker = "itstrue";
        break;
    case "maykop":
        $verSubDomainChecker = "itstrue";
        break;
    case "makhachkala":
        $verSubDomainChecker = "itstrue";
        break;
    case "murmansk":
        $verSubDomainChecker = "itstrue";
        break;
    case "nalchik":
        $verSubDomainChecker = "itstrue";
        break;
    case "oryel":
        $verSubDomainChecker = "itstrue";
        break;
    case "orenburg":
        $verSubDomainChecker = "itstrue";
        break;
    case "petrozavodsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "petropavlovsk-kamchatskiy":
        $verSubDomainChecker = "itstrue";
        break;
    case "pskov":
        $verSubDomainChecker = "itstrue";
        break;
    case "ryazan":
        $verSubDomainChecker = "itstrue";
        break;
    case "salekhard":
		$verSubDomainChecker = "itstrue";
        break;
    case "saransk":
        $verSubDomainChecker = "itstrue";
        break;
    case "saratov":
        $verSubDomainChecker = "itstrue";
        break;
    case "smolensk":
        $verSubDomainChecker = "itstrue";
        break;
    case "stavropol":
        $verSubDomainChecker = "itstrue";
        break;
    case "syktyvkar":
        $verSubDomainChecker = "itstrue";
        break;
    case "tambov":
        $verSubDomainChecker = "itstrue";
        break;
    case "tver":
        $verSubDomainChecker = "itstrue";
        break;
    case "tomsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "tula":
        $verSubDomainChecker = "itstrue";
        break;
    case "tyumen":
        $verSubDomainChecker = "itstrue";
        break;
    case "ulan-ude":
        $verSubDomainChecker = "itstrue";
        break;
    case "ulyanovsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "khabarovsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "khanty-mansiysk":
        $verSubDomainChecker = "itstrue";
        break;
    case "cheboksary":
        $verSubDomainChecker = "itstrue";
        break;
    case "chita":
        $verSubDomainChecker = "itstrue";
        break;
    case "elista":
        $verSubDomainChecker = "itstrue";
        break;
    case "yuzhno-sakhalinsk":
		$verSubDomainChecker = "itstrue";
        break;
    case "yakutsk":
        $verSubDomainChecker = "itstrue";
        break;
    case "yaroslavl":
        $verSubDomainChecker = "itstrue";
        break;
    default:
       $verSubDomainChecker = "nottru";
}
*/
/*

if( $verSubDomainChecker == "nottru"){
	if($urls[2] == 'avtokovriki'){
		$arFilteraas = array(
    'IBLOCK_ID' => 2, #ID инфоблока
);

$resnnnnn = CIBlockSection::GetList(false, $arFilteraas
);
for ($i = 1; $i <= 10050; $i++) {
$arResultttpp = $resnnnnn->Fetch();
	if($verSubDomainChecker == "nottru"){
						if( $arResultttpp["CODE"] == $urls[4]){
						$liluzzv = $arResultttpp["NAME"];
						$i = 10050;
					}
	}else{
						if( $arResultttpp["CODE"] == $urls[5]){
						$liluzzv = $arResultttpp["NAME"];
						$i = 10050;
					}
}

}
for ($iz = 1; $iz <= 10050; $iz++) {
$arResultttppv = $resnnnnn->Fetch();
if($verSubDomainChecker == "nottru"){
					if( $arResultttppv["CODE"] == $urls[5]){
						$liluzzvb = $arResultttppv["NAME"];
						$iz = 10050;
					}
}else{
					if( $arResultttppv["CODE"] == $urls[6]){
						$liluzzvb = $arResultttppv["NAME"];
						$iz = 10050;
					}
}
}

for ($ize = 1; $ize <= 10050; $ize++) {
$arqResultttppv = $resnnnnn->Fetch();
if($verSubDomainChecker == "nottru"){
						if( $arqResultttppv["CODE"] == $urls[6]){
						$qliluzzvb = $arqResultttppv["NAME"];
						$ize = 10050;
					}
}else{
					if( $arqResultttppv["CODE"] == $urls[7]){
						$qliluzzvb = $arqResultttppv["NAME"];
						$ize = 10050;
					}
}
}
}}else{ if($urls[3] == 'avtokovriki'){
	$arFilteraas = array(
    'IBLOCK_ID' => 2, #ID инфоблока
);

$resnnnnn = CIBlockSection::GetList(false, $arFilteraas
);
   for ($i = 1; $i <= 10050; $i++) {
$arResultttpp = $resnnnnn->Fetch();
	if($verSubDomainChecker == "nottru"){
						if( $arResultttpp["CODE"] == $urls[4]){
						$liluzzv = $arResultttpp["NAME"];
						$i = 10050;
					}
	}else{
						if( $arResultttpp["CODE"] == $urls[5]){
						$liluzzv = $arResultttpp["NAME"];
						$i = 10050;
					}
}

}
for ($iz = 1; $iz <= 10050; $iz++) {
$arResultttppv = $resnnnnn->Fetch();
if($verSubDomainChecker == "nottru"){
					if( $arResultttppv["CODE"] == $urls[5]){
						$liluzzvb = $arResultttppv["NAME"];
						$iz = 10050;
					}
}else{
					if( $arResultttppv["CODE"] == $urls[6]){
						$liluzzvb = $arResultttppv["NAME"];
						$iz = 10050;
					}
}
}

for ($ize = 1; $ize <= 10050; $ize++) {
$arqResultttppv = $resnnnnn->Fetch();
if($verSubDomainChecker == "nottru"){
						if( $arqResultttppv["CODE"] == $urls[6]){
						$qliluzzvb = $arqResultttppv["NAME"];
						$ize = 10050;
					}
}else{
					if( $arqResultttppv["CODE"] == $urls[7]){
						$qliluzzvb = $arqResultttppv["NAME"];
						$ize = 10050;
					}
}
}
}
} */
$checkerheader = "no";
$bodytagag = str_ireplace(array ('?PAGEN_1=1', '?PAGEN_1=2', '?PAGEN_1=3','?PAGEN_1=4','?PAGEN_1=5','?PAGEN_1=6','?PAGEN_1=7','?PAGEN_1=8','?PAGEN_1=9','?PAGEN_1=10','?PAGEN_1=11','?PAGEN_1=12','?PAGEN_1=13','?PAGEN_1=14','?PAGEN_2=1', '?PAGEN_2=2', '?PAGEN_2=3','?PAGEN_2=4','?PAGEN_2=5','?PAGEN_2=6','?PAGEN_2=7','?PAGEN_2=8','?PAGEN_2=9','?PAGEN_2=10','?PAGEN_2=11','?PAGEN_2=12','?PAGEN_2=13','?PAGEN_2=14','?PAGEN_3=1', '?PAGEN_3=2', '?PAGEN_3=3','?PAGEN_3=4','?PAGEN_3=5','?PAGEN_3=6','?PAGEN_3=7','?PAGEN_3=8','?PAGEN_3=9','?PAGEN_3=10','?PAGEN_3=11','?PAGEN_3=12','?PAGEN_3=13','?PAGEN_3=14','?PAGEN_4=1', '?PAGEN_4=2', '?PAGEN_4=3','?PAGEN_4=4','?PAGEN_4=5','?PAGEN_4=6','?PAGEN_4=7','?PAGEN_4=8','?PAGEN_4=9','?PAGEN_4=10','?PAGEN_4=11','?PAGEN_4=12','?PAGEN_4=13','?PAGEN_4=14','?PAGEN_5=1', '?PAGEN_5=2', '?PAGEN_5=3','?PAGEN_5=4','?PAGEN_5=5','?PAGEN_5=6','?PAGEN_5=7','?PAGEN_5=8','?PAGEN_5=9','?PAGEN_5=10','?PAGEN_5=11','?PAGEN_5=12','?PAGEN_5=13','?PAGEN_5=14','?PAGEN_6=1', '?PAGEN_6=2', '?PAGEN_6=3','?PAGEN_6=4','?PAGEN_6=5','?PAGEN_6=6','?PAGEN_6=7','?PAGEN_6=8','?PAGEN_6=9','?PAGEN_6=10','?PAGEN_6=11','?PAGEN_6=12','?PAGEN_6=13','?PAGEN_6=14','?PAGEN_7=1', '?PAGEN_7=2', '?PAGEN_7=3','?PAGEN_7=4','?PAGEN_7=5','?PAGEN_7=6','?PAGEN_7=7','?PAGEN_7=8','?PAGEN_7=9','?PAGEN_7=10','?PAGEN_7=11','?PAGEN_7=12','?PAGEN_7=13','?PAGEN_7=14'), "", $_SERVER["REQUEST_URI"]);
if( $verSubDomainChecker == "nottru"){
	if($urls[2] == 'avtokovriki'){
		if($urls[3] == 'kovriki_eva'){
			if($urls[4] != null and $urls[5] == null){
		 $checkerheader = "yes";
		echo '<title>Купить автоковрики EVA на '. $liluzzv .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Автоковрики из EVA для машины '. $liluzzv .' в {RegionTitle}. Узнать цену и купить автомобильные коврики из EVA на '. $liluzzv .' в интернет-магазине «Автофрант».">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
			}
			if($urls[4] != null and $urls[5] != null and $urls[6] == null){
		 $checkerheader = "yes";
		echo '<title>Купить автоковрики EVA на '. $liluzzv .' '. $liluzzvb .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Автоковрики из EVA для машины '. $liluzzv .' '. $liluzzvb .' в {RegionTitle}. Узнать цену и купить автомобильные коврики из EVA на '. $liluzzv .' '. $liluzzvb .' в интернет-магазине «Автофрант». ">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
		}
						if($urls[4] != null and $urls[5] != null and $urls[6] != null){
		 $checkerheader = "yes";
		echo '<title>Купить Коврики EVA на '. $liluzzv .' '. $liluzzvb .' '. $qliluzzvb .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Коврики Eva на '. $liluzzv .' '. $liluzzvb .' '. $qliluzzvb .' по цене 2 300 руб. с доставкой по Москве от интернет-магазина «Автофрант». Автомобильные коврики из EVA в наличии — закажите сейчас.">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
			}
		}

		if($urls[3] == 'vorsovye_kovriki'){
			if($urls[4] != null and $urls[5] == null){
		 $checkerheader = "yes";
		echo '<title>Купить ворсовые автоковрики на '. $liluzzv .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Ворсовые автоковрики для машины '. $liluzzv .' в Москве. Узнать цену и купить автомобильные коврики из ворса на '. $liluzzv .' в интернет-магазине «Автофрант».">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
			}
			if($urls[4] != null and $urls[5] != null and $urls[6] == null){
		 $checkerheader = "yes";
		echo '<title>Купить ворсовые автоковрики на '. $liluzzv .' '. $liluzzvb .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Ворсовые автоковрики для машины '. $liluzzv .' '. $liluzzvb .' в Москве. Узнать цену и купить автомобильные коврики из ворса на '. $liluzzv .' '. $liluzzvb .' в интернет-магазине «Автофрант».">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
			}
						if($urls[4] != null and $urls[5] != null and $urls[6] != null){
		 $checkerheader = "yes";
		echo '<title>Купить ворсовые автоковрики на '. $liluzzv .' '. $liluzzvb .' '. $qliluzzvb .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Автоковрики '. $liluzzv .' '. $liluzzvb .' '. $qliluzzvb .' 2007-2014 по цене 3 990 руб. с доставкой по Москве от интернет-магазина «Автофрант». Ворсовые автомобильные коврики в наличии — закажите сейчас.">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
			}
		}
	}
}else{
	if($urls[3] == 'avtokovriki'){
		if($urls[4] == 'kovriki_eva'){
			if($urls[5] != null and $urls[6] == null){
		 $checkerheader = "yes";
		echo '<title>Купить автоковрики EVA на '. $liluzzv .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Автоковрики из EVA для машины '. $liluzzv .' в {RegionTitle}. Узнать цену и купить автомобильные коврики из EVA на {марка} в интернет-магазине «Автофрант».">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
			}
			if($urls[5] != null and $urls[6] != null and $urls[7] == null){
		 $checkerheader = "yes";
		echo '<title>Купить автоковрики EVA на '. $liluzzv .' '. $liluzzvb .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Автоковрики из EVA для машины '. $liluzzv .' '. $liluzzvb .' в {RegionTitle}. Узнать цену и купить автомобильные коврики из EVA на {марка + модель} в интернет-магазине «Автофрант». ">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
			}
						if($urls[5] != null and $urls[6] != null and $urls[7] != null){
		 $checkerheader = "yes";
		echo '<title>Купить Коврики EVA на '. $liluzzv .' '. $liluzzvb .' '. $qliluzzvb .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Коврики Eva на '. $liluzzv .' '. $liluzzvb .' '. $qliluzzvb .' по цене 2 300 руб. с доставкой по Москве от интернет-магазина «Автофрант». Автомобильные коврики из EVA в наличии — закажите сейчас.">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
		}
		}

		if($urls[4] == 'vorsovye_kovriki'){
			if($urls[5] != null and $urls[6] == null){
		 $checkerheader = "yes";
		echo '<title>Купить ворсовые автоковрики на '. $liluzzv .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Ворсовые автоковрики для машины '. $liluzzv .' в Москве. Узнать цену и купить автомобильные коврики из ворса на '. $liluzzv .' в интернет-магазине «Автофрант».">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
			}
			if($urls[5] != null and $urls[6] != null and $urls[7] == null){
		 $checkerheader = "yes";
		echo '<title>Купить ворсовые автоковрики на '. $liluzzv .' '. $liluzzvb .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Ворсовые автоковрики для машины '. $liluzzv .' '. $liluzzvb .' в Москве. Узнать цену и купить автомобильные коврики из ворса на '. $liluzzv .' '. $liluzzvb .' в интернет-магазине «Автофрант».">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
			}
						if($urls[5] != null and $urls[6] != null and $urls[7] != null){
		 $checkerheader = "yes";
		echo '<title>Купить ворсовые автоковрики на '. $liluzzv .' '. $liluzzvb .' '. $qliluzzvb .' в {RegionTitle}</title>';
		echo '<meta name="description" content="Автоковрики '. $liluzzv .' '. $liluzzvb .' '. $qliluzzvb .' 2007-2014 по цене 3 990 руб. с доставкой по Москве от интернет-магазина «Автофрант». Ворсовые автомобильные коврики в наличии — закажите сейчас.">';
		echo '<link rel="canonical" href="https://'.$_SERVER["SERVER_NAME"].''.$bodytagag.'" />';
		echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>';
		}
		}
	}
}
?>
    <? //echo $checkerheader;
        if ($checkerheader == "yes") {
            $APPLICATION->ShowCSS();
			$APPLICATION->ShowHeadScripts();
        }
        if ($checkerheader == "no") {
            $APPLICATION->ShowHead();
        }
        ?>
    <?
        if ($checkerheader == "yes") {
        } else {
            echo "<title>";
            $APPLICATION->ShowTitle();
            echo "</title>";
        } ?>
    <?$APPLICATION->ShowViewContent('meta_add');?>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH ?>/img/favicon.ico" type="image/x-icon">

    <?
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/bootstrap-grid.min.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/reset.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/slick.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/jquery.fancybox.min.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/ion.rangeSlider.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/perfect-scrollbar.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/animate.css");
        // $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/fonts.css@v=2.0.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/main.css@v=2.3.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/media.css@v=2.3.css");

        // $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/constructor/css/jquery-ui.css");
        // $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/constructor/css/js-offcanvas.min.css");
        // $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/constructor/fancybox/helpers/jquery.fancybox-thumbs.css");
        // $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/constructor/css/constructor.css");
        // $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/constructor/css/my-select-and-tooltip.css");
        $APPLICATION->SetAdditionalCSS("https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.0/css/swiper.min.css");

        $APPLICATION->SetAdditionalCSS("https://use.fontawesome.com/releases/v5.5.0/css/all.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/main-m.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/media.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/style-main.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/media-queres-main.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/custom.css");
        if (!isset($_SERVER['HTTP_USER_AGENT']) || stripos($_SERVER['HTTP_USER_AGENT'], 'Chrome-Lighthouse') === false):
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/lib/gallery.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/fonts/fonts.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/icons.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/core.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/header.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/articles.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/articles-detail.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/grid.css");
        $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH . "/css/newcss/basket.css");


        ?>
    <link rel="preload" href="<?= SITE_TEMPLATE_PATH ?>/css/newcss/fonts/Montserrat-Light.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= SITE_TEMPLATE_PATH ?>/css/newcss/fonts/Montserrat-SemiBold.woff" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= SITE_TEMPLATE_PATH ?>/css/newcss/fonts/Montserrat-Light.ttf" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="<?= SITE_TEMPLATE_PATH ?>/css/newcss/fonts/Montserrat-SemiBold.ttf" as="font" type="font/woff2" crossorigin>

    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery-3.3.1.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/slick.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.fancybox.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/ion.rangeSlider.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.animateNumber.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/ScrollMagic.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.ScrollMagic.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/debug.addIndicators.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.zoom.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/wow.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/main.js@v=2.3.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.cookie.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/jquery.lazyload.min.js');?>
    <?$APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH . '/js/newjs/jquery.tooltip.js');?>

    <?//$APPLICATION->AddHeadScript('/constructor/script/plugins.min.js');?>
    <?//$APPLICATION->AddHeadScript('/constructor/fancybox/helpers/jquery.fancybox-thumbs.js');?>
    <?//$APPLICATION->AddHeadScript('/constructor/fancybox/helpers/jquery.fancybox-media.js');?>
    <?//$APPLICATION->AddHeadScript('/constructor/script/extsrc.js');?>
    <?//$APPLICATION->AddHeadScript('/constructor/script/angu_prsl.js');?>
    <?//$APPLICATION->AddHeadScript('/constructor/script/modal.js');?>
    <?//$APPLICATION->AddHeadScript('/constructor/script/jquery.lazyload.js');?>
    <?//$APPLICATION->AddHeadScript('/constructor/off-canvas/js/is-offcanvas.min.js');?>
    <?//$APPLICATION->AddHeadScript('/constructor/off-canvas/js/js-offcanvas.pkgd.min.js');?>


    <script src="--><?= SITE_TEMPLATE_PATH ?><!--/js/newjs/main.js"></script>
    <script src="<?= SITE_TEMPLATE_PATH ?>/js/newjs/custom.js"></script>
    <script src="<?= SITE_TEMPLATE_PATH ?>/js/newjs/lib/gallery.js"></script>
    <script src="/constructor/js/constructor.js"></script>
    <script src="/constructor/js/html2canvas.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <meta name="yandex-verification" content="92926e17757dd6df" />
    <meta name="google-site-verification" content="8en8LH90hinWkvn3WGWbSOrxm5srpsB_zzQo08rE8Go" />


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-31710112-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'UA-31710112-3');
    </script>
    <?php endif; ?>
</head>

<body ng-app="wh_module" ng-controller="wh_Controller">


    <div id="panel">
        <? $APPLICATION->ShowPanel(); ?>
    </div>

    <div class="body-wrapper">

        <header class="header">
            <div class="header-top">
                <div class="wrapper">
                    <div class="inner">
                        <? $APPLICATION->IncludeComponent(
	"bitrix:menu",
	"top_menu",
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"COMPONENT_TEMPLATE" => "top_menu",
		"DELAY" => "N",
		"MAX_LEVEL" => "1",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "Y",
		"MENU_CACHE_USE_GROUPS" => "N",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
); ?>
                       <ul class="social-profile">
                             <li><a target="_blank" href="<?$APPLICATION->IncludeComponent(" bitrix:main.include", "" , Array( "AREA_FILE_SHOW"=> "file", "PATH" => "/include/mainpage/vklink.php",
                                "EDIT_TEMPLATE" => ""
                                ),
                                false
                                );?>"><img class="vkheader" src="/newindex/svg/ic_vk.svg"></a>
                             </li>
                             <li>
                                 <a target="_blank" href="<?$APPLICATION->IncludeComponent(
                                    " bitrix:main.include", "" , Array( "AREA_FILE_SHOW"=> "file",
                                "PATH" => "/include/mainpage/instlink.php",
                                "EDIT_TEMPLATE" => ""
                                ),
                                false
                                );?>"><img class="instheader" src="/newindex//svg/ic_inst.svg"></a>
                             </li>
                             <li>
                                 <a target="_blank" href="<?$APPLICATION->IncludeComponent(
                                    " bitrix:main.include", "" , Array( "AREA_FILE_SHOW"=> "file",
                                "PATH" => "/include/mainpage/youtubelink.php",
                                "EDIT_TEMPLATE" => ""
                                ),
                                false
                                );?>"><img class="ytheader" src="/newindex/svg/ic_youtube.svg"></a>
                             </li>
                        </ul>
                        <div class="header-top-callback-button">
                            <a href="" class="btn btn-normal" id="button_header_callback" data-fancybox data-src="#callback-popup">Заказать звонок</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-info">
                <div class="wrapper">
                    <div class="inner">
                        <div class="box-header-info">
                            <div class="header-logo">
                                <a href="/"><img src="<?= SITE_TEMPLATE_PATH ?>/img/logo.png" alt=""></a>
                            </div>

                            <? \Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("header-contact"); ?>
                            <div class="header-our-region">
                                <div class="header-region-wrap">
                                    <div class="header-region-icon"></div>
                                    <div class="header-region-desc">
                                        <div class="header-region-title">Ваш регион</div>
                                        <div class="header-region-text">
                                            <a data-fancybox data-src="#city-popup"><?= ($_COOKIE['CITY'] == $setted_loc) ? $_COOKIE['CITY'] : $setted_loc ?></a>
                                        </div>

                                        <div class="select-region <?= ($_COOKIE['CITY_SELECTED'] === 'true') ? '' : 'open' ?>">
                                            <div class="select-region-title">Ваш регион:</div>
                                            <div class="select-region-type"><?= ($_COOKIE['CITY'] == $setted_loc) ? $_COOKIE['CITY'] : $setted_loc ?>
                                                ?
                                            </div>
                                            <div class="select-region-action">
                                                <div class="region-action-yes"><a href="" class="btn btn-normal" data-selected>Да</a></div>
                                                <div class="region-action-no"><a href="" class="btn btn-normal btn-black" data-fancybox data-src="#city-popup">Нет</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="header__timework">
                                    <div class="header__mail">info@autofrant.ru</div>

                                    <div class="headerwindow">пн-вс 9:00 - 21:00<img src="/newindex/arrow.jpg"></div>
                                </div>

                                <div class="headerwindowsfix">

                                    <div class="headerwindow-title">Адрес в Москве</div>
                                    <div class="headerwindow-subtitle">г. Москва, Ленинградский <br> проспект, д. 2</div>

                                    <hr>

                                    <div class="headerwindow-titled">Время работы</div>
                                    <div class="headerwindow-subtitle">Ежедневно с 9:00 - 21:00<br> В любое время вы можете оставить <br> заявку на сайте и указать удобное <br> для вас время и средство связи</div>

                                    <hr>

                                    <div class="headerwindow-titled">Реквизиты</div>
                                    <div class="headerwindow-subtitle">Индивидуальный предприниматель<br> Голенков Андрей Владимирович<br> ИНН 583502131600</div>
                                </div>

                            </div>
                            <? \Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("header-contact", ""); ?>
                            <style>
                                @media (min-width: 1020px) {
                                    .fixationheaderblock {
                                        height: 54px;
                                        border-right: 1px solid #D8D8D8;
                                    }
                                }

                                @media (max-width: 1020px) {
                                    .fixationheaderblock {
                                        height: 54px;
                                    }

                                    .fixationheaderblocks {
                                        margin-left: -23px;
                                    }
                                }
                            </style>
                            <div class="header-number-phone fixationheaderblock">
                            <div class=" header-number">
                                <ul>
                                    <li>
                                        <a href="tel:8 (495) 646-70-45">8 (495) 646-70-45</a><br>
                                        <a href="tel:8 (800) 333-40-55">8 (800) 333-40-55</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="header-number-phone fixationheaderblocks">
                            <div class="header-number">
                                <ul>
                                    <li class="el-viber"><a href="viber://chat?number=+79875147170"><span class="ic_viber"></span></a></li>
                                    <li class="el-ws"><a href="https://api.whatsapp.com/send?phone=79875147170"><span class="ic_whatsapp"></span></a></li>
                                    <li class="el-tg"><a href="tg://resolve?domain=autofrant"><span class="ic_telegram"></span></a></li>
                                </ul>
                            </div>
                            <div class="header-number-phone" style="height: 54px;border-left: 1px solid #D8D8D8;">
                                <div class="header-number">
                                    <ul>
                                        <li>
                                            <a href="#"><img src="/newindex/userimg.png"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <? \Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("header-cart"); ?>
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:sale.basket.basket.line",
                                "new_basket",
                                array(
                                    "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                                    "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                                    "SHOW_PERSONAL_LINK" => "N",
                                    "SHOW_NUM_PRODUCTS" => "Y",
                                    "SHOW_TOTAL_PRICE" => "Y",
                                    "SHOW_PRODUCTS" => "N",
                                    "SHOW_EMPTY_VALUES" => 'N',
                                    "POSITION_FIXED" => "N",
                                    "SHOW_AUTHOR" => "Y",
                                    "PATH_TO_REGISTER" => SITE_DIR . "login/",
                                    "PATH_TO_PROFILE" => SITE_DIR . "personal/"
                                ),
                                false,
                                array()
                            ); ?>
                            <? \Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("header-cart", ""); ?>

                            <div class="m-menu">
                                <span class="fas fa-bars"> </span>
                            </div>
                        </div>
                        <div class="mobile-panel">
                            <div class="mobile-panel-inner">
                                <nav class="main-menu-mobile">
                                    <ul>
                                        <li class="has-submenu">
                                            <a>О компании</a>
                                            <?$APPLICATION->IncludeComponent(
                                            "bitrix:menu",
                                            "mobile_menu",
                                            Array(
                                                "ALLOW_MULTI_SELECT" => "N",
                                                "CHILD_MENU_TYPE" => "",
                                                "DELAY" => "N",
                                                "MAX_LEVEL" => "1",
                                                "MENU_CACHE_GET_VARS" => array(),
                                                "MENU_CACHE_TIME" => "3600",
                                                "MENU_CACHE_TYPE" => "A",
                                                "MENU_CACHE_USE_GROUPS" => "Y",
                                                "ROOT_MENU_TYPE" => "footer_company",
                                                "USE_EXT" => "N"
                                                    )
                                                );?>
                                        </li>

                                    </ul>
                                </nav>
                                <nav class="cat-menu-mobile">
                                    <ul>
                                        <li class="has-submenu">
                                            <a href="/catalog/">Каталог</a>
                                            <? $APPLICATION->IncludeComponent(
                                                "bitrix:menu",
                                                "mobile",
                                                Array(
                                                    "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                                                    "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                                                    "DELAY" => "N",    // Откладывать выполнение шаблона меню
                                                    "MAX_LEVEL" => "3",    // Уровень вложенности меню
                                                    "MENU_CACHE_GET_VARS" => "",    // Значимые переменные запроса
                                                    "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                                                    "MENU_CACHE_TYPE" => "Y",    // Тип кеширования
                                                    "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
                                                    "ROOT_MENU_TYPE" => "main",    // Тип меню для первого уровня
                                                    "USE_EXT" => "Y",    // paПодключать файлы с именами вида .тип_меню.menu_ext.php
                                                    "COMPONENT_TEMPLATE" => ""
                                                ),
                                                false
                                            ); ?>
                                        </li>
                                    </ul>
                                </nav>
                                <nav class="footer-menu-mobile">
                                    <ul>
                                        <li class="has-submenu">
                                            <a>Клиенту</a>
                                            <?$APPLICATION->IncludeComponent(
                                                "bitrix:menu",
                                                "mobile_menu",
                                                Array(
                                                    "ALLOW_MULTI_SELECT" => "N",
                                                    "CHILD_MENU_TYPE" => "",
                                                    "DELAY" => "N",
                                                    "MAX_LEVEL" => "1",
                                                    "MENU_CACHE_GET_VARS" => array(),
                                                    "MENU_CACHE_TIME" => "3600",
                                                    "MENU_CACHE_TYPE" => "A",
                                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                                    "ROOT_MENU_TYPE" => "footer_client",
                                                    "USE_EXT" => "N"
                                                )
                                            );?>
                                        </li>
                                    </ul>
                                </nav>

                                <script>
                                    $(".m-menu").on("click", function () {
                                        $(this).toggleClass("open");
                                        $(".mobile-panel").toggleClass("active");
                                        $(".body-wrapper").toggleClass("m-panel");

                                        if ($(this).hasClass("open")) {
                                            $(".m-menu > span")
                                                .removeClass("fa-bars")
                                                .addClass("fa-times");
                                        } else {
                                            $(".m-menu > span")
                                                .removeClass("fa-times")
                                                .addClass("fa-bars");
                                        }
                                    });
                                </script>


                                <? \Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("header-contact2"); ?>
                                <div class="header-contact">
                                    <div class="header-contact-item header-contact-address">
                                        <div class="header-contact-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="header-contact-title">
                                            <p>Ваш регион</p>
                                        </div>
                                        <div class="header-contact-value">
                                            <a class="city-picker" data-fancybox data-src="#city-popup"><?= ($_COOKIE['CITY'] == $setted_loc) ? $_COOKIE['CITY'] : $setted_loc ?></a>
                                        </div>
                                    </div>
                                    <div class="header-contact-item header-contact-phone">
                                        <div class="header-contact-icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="header-contact-title">
                                            <p><?= ($setted_worktime == $_COOKIE['WORKTIME']) ? $_COOKIE['WORKTIME'] : $setted_worktime ?></p>
                                        </div>
                                        <div class="header-contact-value">
                                            <a href="tel:<?= ($setted_phone == $_COOKIE['PHONE']) ? $_COOKIE['PHONE'] : $setted_phone ?>">
                                                <?= ($setted_phone == $_COOKIE['PHONE']) ? $_COOKIE['PHONE'] : $setted_phone ?></a>
                                        </div>
                                    </div>
                                </div>
                                <? \Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("header-contact2", ""); ?>


                                <div class="mobile-panel-footer">
                                    <?
                                    $staticHTMLCache = \Bitrix\Main\Data\StaticHTMLCache::getInstance();
                                    $staticHTMLCache->disableVoting();
                                    ?>
                                    <? $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.line", "", array(
                                        "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                                        "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                                        "SHOW_PERSONAL_LINK" => "N",
                                        "SHOW_NUM_PRODUCTS" => "Y",
                                        "SHOW_TOTAL_PRICE" => "Y",
                                        "SHOW_PRODUCTS" => "N",
                                        "SHOW_EMPTY_VALUES" => 'N',
                                        "POSITION_FIXED" => "N",
                                        "SHOW_AUTHOR" => "Y",
                                        "PATH_TO_REGISTER" => SITE_DIR . "login/",
                                        "PATH_TO_PROFILE" => SITE_DIR . "personal/"
                                    ),
                                        false,
                                        array()
                                    ); ?>
                                    <? $staticHTMLCache->enableVoting(); ?>
                                    <div class="header-social">
                                        <a href="viber://chat?number=+79875147170"><i class="fab fa-viber"></i></a>
                                        <a href="https://api.whatsapp.com/send?phone=+79875147170"><i class="fab fa-whatsapp"></i></a>
                                        <a href="https://telegram.me/nickname"><i class="fab fa-telegram-plane"></i></a>
                                    </div>
                                    <div class="header-callback">
                                        <a href="" class="btn btn-small" data-fancybox data-src="#callback-popup">Перезвоните
                                            мне!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="header-menu">
        <div class="wrapper">
            <div class="inner">
                <div class="button-catalog">
                    <div class="button-catalog-icon"></div>
                    <div class="button-catalog-text">
                        <? \Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("catalog_link"); ?>
                        <a href="/catalog/">Каталог товаров</a>
                        <? \Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("catalog_link", ""); ?>
                    </div>
                </div>

                <div class="main-menu-wrapper">
                    <?
                        $staticHTMLCache = \Bitrix\Main\Data\StaticHTMLCache::getInstance();
                        $staticHTMLCache->disableVoting();
                        ?>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "new_main_menu",
                        array(
                            "ALLOW_MULTI_SELECT" => "N",
                            "CHILD_MENU_TYPE" => "left",
                            "DELAY" => "N",
                            "MAX_LEVEL" => "3",
                            "MENU_CACHE_GET_VARS" => array(),
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_TYPE" => "A",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "USE_EXT" => "Y",
                            "COMPONENT_TEMPLATE" => "new_main_menu",
                            "COMPOSITE_FRAME_MODE" => "A",
                            "COMPOSITE_FRAME_TYPE" => "AUTO"
                        ),
                        false
                    ); ?>
                    <? $staticHTMLCache->enableVoting(); ?>

                    <? \Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("header-contact-bottom"); ?>
                    <a href="tel:<?= ($setted_phone == $_COOKIE['PHONE']) ? $_COOKIE['PHONE'] : $setted_phone ?>" class="header-bottom-phone phone">
                        <span class="header-bottom-phone-icon"></span>
                        <?= ($setted_phone == $_COOKIE['PHONE']) ? $_COOKIE['PHONE'] : $setted_phone ?>
                    </a>
                    <? \Bitrix\Main\Page\Frame::getInstance()->finishDynamicWithID("header-contact-bottom", ""); ?>

                    <span class="ic_search header-search-btn"></span>
                </div>

                <span class="firexmenutosite">
                    <div class="constructor_icon">
                        <img src="/newindex/constructfixmenu.png">
                    </div>
                    <div class="constructor_link">
                        <a href="/constructor/" class="noreffal"> <span class="ttellefon">конструкторы</span> </a>
                    </div>

                    <div class="topmenuleftclass">
                        <div class="topmenuleftclass_number" >
                            <a class="ttellefon" href="tel:8 (800) 333-40-55">8 (800) 333-40-55</a>
                        </div>
                        <? \Bitrix\Main\Page\Frame::getInstance()->startDynamicWithID("header-cart"); ?>
                        <? $APPLICATION->IncludeComponent(
                        "bitrix:sale.basket.basket.line",
                        "new_basket",
                        array(
                            "PATH_TO_BASKET" => SITE_DIR . "personal/cart/",
                            "PATH_TO_PERSONAL" => SITE_DIR . "personal/",
                            "SHOW_PERSONAL_LINK" => "N",
                            "SHOW_NUM_PRODUCTS" => "Y",
                            "SHOW_TOTAL_PRICE" => "Y",
                            "SHOW_PRODUCTS" => "N",
                            "SHOW_EMPTY_VALUES" => 'N',
                            "POSITION_FIXED" => "N",
                            "SHOW_AUTHOR" => "Y",
                            "PATH_TO_REGISTER" => SITE_DIR . "login/",
                            "PATH_TO_PROFILE" => SITE_DIR . "personal/"
                        ),
                        false,
                        array()
                    ); ?>
                        <div class="header-top-callback-button">
                            <a href="" class="btn btn-normal" id="button_header_callback" data-fancybox data-src="#callback-popup">Заказать звонок</a>
                        </div>
                    </div>
                </span>










                <div class="header-search">
                    <form action="/search/" class="form header-search-form" method="GET">
                        <input type="search" name="q" id="search" placeholder="Что ищем?">
                        <button class="btn btn-small">Поиск</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="catalog-catig">
            <div class="wrapper">
                <? $APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list",
                        "dropdown_main_menu",
                        Array(
                            "ADD_SECTIONS_CHAIN" => "Y",
                            "CACHE_GROUPS" => "Y",
                            "CACHE_TIME" => "36000000",
                            "CACHE_TYPE" => "A",
                            "COUNT_ELEMENTS" => "N",
                            "HIDE_SECTION_NAME" => "N",
                            "IBLOCK_ID" => "2",
                            "IBLOCK_TYPE" => "catalog",
                            "SECTION_CODE" => "",
                            "SECTION_FIELDS" => array(),
                            "SECTION_ID" => $_REQUEST["SECTION_ID"],
                            "SECTION_URL" => "",
                            "SECTION_USER_FIELDS" => array(),
                            "SHOW_PARENT_NAME" => "Y",
                            "TOP_DEPTH" => "2"
                        )
                    ); ?>
            </div>
        </div>
    </div>
    </header>
    <script>
        var path = window.location.pathname;
        var host = window.location.host;
        var pathArray = path.split("/");
    </script>
    <?
if ($APPLICATION->GetCurPage() != '/' && !defined("ERROR_404")) {
    ?>
    <div class="wrapper">
    <?php
   $APPLICATION->IncludeComponent(
        "bitrix:breadcrumb",
        "",
        Array(
            "PATH" => "",
            "SITE_ID" => "s1",
            "START_FROM" => "0"
        )
    );
    ?>
    </div>
    <?php

}
if ($subDomainCheckers == "penza") {
    ?>
    <script>
        if (pathArray[2] == 'penza') {
            if ($.cookie('CODENAME') != 'penza') {
                $.cookie('RELOAD_CITY', 'Пензазлзлд', {
                    path: '/'
                });
                $.cookie('CODENAME', 'penza', {
                    path: '/'
                });
                $.cookie('CITY_NAME', 'true', {
                    path: '/'
                });
                location.reload();
            }
        }
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "spb") { ?>
    <script>
        if (pathArray[2] == 'spb') {
            if ($.cookie('CODENAME') != 'spb') {
                $.cookie('RELOAD_CITY', 'Санкт-Петербург', {
                    path: '/'
                });
                $.cookie('CODENAME', 'spb', {
                    path: '/'
                });
                $.cookie('CITY_NAME', 'true', {
                    path: '/'
                });
                location.reload();
            }
        }
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "novosibirsk") { ?>
    <script>
        if (pathArray[2] == 'novosibirsk') {
            if ($.cookie('CODENAME') != 'novosibirsk') {
                $.cookie('RELOAD_CITY', 'Новосибирск', {
                    path: '/'
                });
                $.cookie('CODENAME', 'novosibirsk', {
                    path: '/'
                });
                $.cookie('CITY_NAME', 'true', {
                    path: '/'
                });
                location.reload();
            }
        }
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "ekaterinburg") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Екатеринбург', {
            path: '/'
        });
        $.cookie('CODENAME', 'ekaterinburg', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "nizhniy-novgorod") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Нижний Новгород', {
            path: '/'
        });
        $.cookie('CODENAME', 'nizhniy-novgorod', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "kazan") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Казань', {
            path: '/'
        });
        $.cookie('CODENAME', 'kazan', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "chelyabinsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Челябинск', {
            path: '/'
        });
        $.cookie('CODENAME', 'chelyabinsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "omsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Омск', {
            path: '/'
        });
        $.cookie('CODENAME', 'omsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "samara") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Самара', {
            path: '/'
        });
        $.cookie('CODENAME', 'samara', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "ufa") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Уфа', {
            path: '/'
        });
        $.cookie('CODENAME', 'ufa', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "krasnoyarsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Красноярск', {
            path: '/'
        });
        $.cookie('CODENAME', 'krasnoyarsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "perm") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Пермь', {
            path: '/'
        });
        $.cookie('CODENAME', 'perm', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "voronezh") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Воронеж', {
            path: '/'
        });
        $.cookie('CODENAME', 'voronezh', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "volgograd") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Волгоград', {
            path: '/'
        });
        $.cookie('CODENAME', 'volgograd', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "abakan") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Абакан', {
            path: '/'
        });
        $.cookie('CODENAME', 'abakan', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "anadyr") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Анадырь', {
            path: '/'
        });
        $.cookie('CODENAME', 'anadyr', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "astrakhan") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Астрахань', {
            path: '/'
        });
        $.cookie('CODENAME', 'astrakhan', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "belgorod") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Белгород', {
            path: '/'
        });
        $.cookie('CODENAME', 'belgorod', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "birobidzhan") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Биробиджан', {
            path: '/'
        });
        $.cookie('CODENAME', 'birobidzhan', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "blagoveshchensk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Благовещенск', {
            path: '/'
        });
        $.cookie('CODENAME', 'blagoveshchensk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "bryansk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Брянск', {
            path: '/'
        });
        $.cookie('CODENAME', 'bryansk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "vladivostok") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Владивосток', {
            path: '/'
        });
        $.cookie('CODENAME', 'vladivostok', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "vladikavkaz") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Владикавказ', {
            path: '/'
        });
        $.cookie('CODENAME', 'vladikavkaz', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "vladimir") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Владимир', {
            path: '/'
        });
        $.cookie('CODENAME', 'vladimir', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "vologda") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Вологда', {
            path: '/'
        });
        $.cookie('CODENAME', 'vologda', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "groznyy") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Грозный', {
            path: '/'
        });
        $.cookie('CODENAME', 'groznyy', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "ivanovo") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Иваново', {
            path: '/'
        });
        $.cookie('CODENAME', 'ivanovo', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "izhevsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Ижевск', {
            path: '/'
        });
        $.cookie('CODENAME', 'izhevsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "irkutsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Иркутск', {
            path: '/'
        });
        $.cookie('CODENAME', 'irkutsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "yoshkar-ola") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Йошкар-Ола', {
            path: '/'
        });
        $.cookie('CODENAME', 'yoshkar-ola', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "kaluga") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Калуга', {
            path: '/'
        });
        $.cookie('CODENAME', 'kaluga', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "kemerovo") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Кемерово', {
            path: '/'
        });
        $.cookie('CODENAME', 'kemerovo', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "kirov") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Киров', {
            path: '/'
        });
        $.cookie('CODENAME', 'kirov', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "kostroma") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Космтрома', {
            path: '/'
        });
        $.cookie('CODENAME', 'kostroma', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "krasnodar") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Краснодар', {
            path: '/'
        });
        $.cookie('CODENAME', 'krasnodar', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "kurgan") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Курган', {
            path: '/'
        });
        $.cookie('CODENAME', 'kurgan', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "kursk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Курск', {
            path: '/'
        });
        $.cookie('CODENAME', 'kursk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "kyzyl") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Кызыл', {
            path: '/'
        });
        $.cookie('CODENAME', 'kyzyl', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "lipetsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Липецк', {
            path: '/'
        });
        $.cookie('CODENAME', 'lipetsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "magadan") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Магадан', {
            path: '/'
        });
        $.cookie('CODENAME', 'magadan', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "maykop") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Майкоп', {
            path: '/'
        });
        $.cookie('CODENAME', 'maykop', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "makhachkala") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Махачкала', {
            path: '/'
        });
        $.cookie('CODENAME', 'makhachkala', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "murmansk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Мурманск', {
            path: '/'
        });
        $.cookie('CODENAME', 'murmansk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "nalchik") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Нальчик', {
            path: '/'
        });
        $.cookie('CODENAME', 'nalchik', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "oryel") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Орёл', {
            path: '/'
        });
        $.cookie('CODENAME', 'oryel', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "orenburg") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Оринбург', {
            path: '/'
        });
        $.cookie('CODENAME', 'orenburg', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "petrozavodsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Петрозаводск', {
            path: '/'
        });
        $.cookie('CODENAME', 'petrozavodsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "petropavlovsk-kamchatskiy") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Петропавловск-Камчатский', {
            path: '/'
        });
        $.cookie('CODENAME', 'petropavlovsk-kamchatskiy', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "pskov") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Псков', {
            path: '/'
        });
        $.cookie('CODENAME', 'pskov', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "ryazan") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Рязань', {
            path: '/'
        });
        $.cookie('CODENAME', 'ryazan', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "salekhard") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Салехард', {
            path: '/'
        });
        $.cookie('CODENAME', 'salekhard', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "saransk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Саранск', {
            path: '/'
        });
        $.cookie('CODENAME', 'saransk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "saratov") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Саратов', {
            path: '/'
        });
        $.cookie('CODENAME', 'saratov', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "smolensk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Смоленск', {
            path: '/'
        });
        $.cookie('CODENAME', 'smolensk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "stavropol") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Ставрополь', {
            path: '/'
        });
        $.cookie('CODENAME', 'stavropol', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "syktyvkar") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Сыктывкар', {
            path: '/'
        });
        $.cookie('CODENAME', 'syktyvkar', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "tambov") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Тамбов', {
            path: '/'
        });
        $.cookie('CODENAME', 'tambov', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "tver") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Тверь', {
            path: '/'
        });
        $.cookie('CODENAME', 'tver', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "tomsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Томск', {
            path: '/'
        });
        $.cookie('CODENAME', 'tomsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "tula") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Тула', {
            path: '/'
        });
        $.cookie('CODENAME', 'tula', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "tyumen") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Тюмень', {
            path: '/'
        });
        $.cookie('CODENAME', 'tyumen', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "ulan-ude") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Улан-Удэ', {
            path: '/'
        });
        $.cookie('CODENAME', 'ulan-ude', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "ulyanovsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Ульяновск', {
            path: '/'
        });
        $.cookie('CODENAME', 'ulyanovsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "khabarovsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Хабаровск', {
            path: '/'
        });
        $.cookie('CODENAME', 'khabarovsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "khanty-mansiysk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Ханты-Мансийск', {
            path: '/'
        });
        $.cookie('CODENAME', 'khanty-mansiysk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "cheboksary") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Чебоксары', {
            path: '/'
        });
        $.cookie('CODENAME', 'cheboksary', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "chita") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Чита', {
            path: '/'
        });
        $.cookie('CODENAME', 'chita', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "elista") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Элиста', {
            path: '/'
        });
        $.cookie('CODENAME', 'elista', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "yuzhno-sakhalinsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Южно-Сахалинск', {
            path: '/'
        });
        $.cookie('CODENAME', 'yuzhno-sakhalinsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "yakutsk") { ?>
    <script>
        $.cookie('RELOAD_CITY', 'Якутск', {
            path: '/'
        });
        $.cookie('CODENAME', 'yakutsk', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <? } ?>
    <? if ($subDomainCheckers == "yaroslavl"){?>
    <script>
        $.cookie('RELOAD_CITY', 'Ярославль', {
            path: '/'
        });
        $.cookie('CODENAME', 'yaroslavl', {
            path: '/'
        });
        $.cookie('CITY_NAME', 'true', {
            path: '/'
        });
    </script>
    <?} ?>
