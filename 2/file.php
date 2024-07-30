$idDeal = 15;

\Bitrix\Main\Loader::includeModule("crm");
$factory = \Bitrix\Crm\Service\Container::getInstance()->getFactory(\CCrmOwnerType::Deal);

$item = $factory->getItem($idDeal);
$item->setStageId("C2:PREPARATION"); 
$item->setTitle("Тестовая сделка");

$context = new \Bitrix\Crm\Service\Context();
$context->setUserId(1);
$operation = $factory->getUpdateOperation($item, $context);
$result = $operation->launch();

if ($result->isSuccess()) {
  echo "Сделка успешно обновлена";
} else {
  echo "Ошибка обновления:".$result->errors();
}
