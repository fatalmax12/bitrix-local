<? if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
      echo $arResult['DATE'];
//\Bitrix\Main\UI\Extension::load("module_test.helloworld");
?>

<div id="application"></div>
<script type="text/javascript">
    const taskManager = new BX.TaskManager('#application');
    taskManager.start();
</script>
