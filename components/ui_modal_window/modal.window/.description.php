<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentDescription = array(
    "NAME" => GetMessage("Модальное окно"),
    "DESCRIPTION" => GetMessage("Выводим модальное окно"),
    "PATH" => array(
        "ID" => "modal_components",
        "CHILD" => array(
            "ID" => "curtext",
            "NAME" => "Текст"
        )
    ),
    "ICON" => "/images/icon.gif",
);