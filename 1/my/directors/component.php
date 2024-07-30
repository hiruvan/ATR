<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

\Bitrix\Main\Loader::includeModule('iblock');

$entity = \Bitrix\Iblock\Model\Section::compileEntityByIblock(3);

$rsSection = $entity::getList(array(
	"filter" => array(
		"ACTIVE" => "Y"
	),
	"select" => array("UF_HEAD"),
));

while ($arSection=$rsSection->fetch()) 
{
	if (!$arSection["UF_HEAD"]) {
		continue;
	}
	$arHeads[] = $arSection["UF_HEAD"];
}

$arFilter = array(
	'ID' => $arHeads,
);

$arNavParams = array('nTopCount' => $arParams['NUM_USERS']);

$arRequiredFields = array('ID', 'PERSONAL_BIRTHDAY');
$arSelectFields = !empty($arParams['SELECT_FIELDS']) && is_array($arParams['SELECT_FIELDS'])
	? array_merge($arRequiredFields, $arParams['SELECT_FIELDS'])
	: array('*', 'UF_*');

$result = \Bitrix\Main\UserTable::getList(array(
    'select' => $arSelectFields,
    'order' => array('NAME'=>'ASC'),
    'filter' => $arFilter
));

while ($arUser = $result->fetch()) {
	$arUser['DETAIL_URL'] = str_replace(array('#ID#', '#USER_ID#'), $arUser['ID'], $arParams['DETAIL_URL']);
	$arResult['USERS'][$arUser['ID']] = $arUser;
}

$this->IncludeComponentTemplate();
?>