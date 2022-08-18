<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("PopUp ajax");

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Page\Asset;

CUtil::InitJSCore(array('ajax', 'popup', 'ls', 'sidepanel'));
Asset::getInstance()->addJs("/local/components/ui_modal_window/modal.window/templates/main_template/myscript.js");

?>

    <div id="hideBlock" style="display:none;">

        <form id="main-form" method="post" action="http://localhost/">
            <input class="person-field" name="name" type="text" placeholder="name"/><br>
            <input class="person-field" name="secondname" type="text" placeholder="secondname"/><br>
            <input class="person-field" name="email" type="text" placeholder="email"/>
        </form>

    </div>

    <script>
        BX.message({
            'CORRECT_EMAIL': '<?=Loc::getMessage("CORRECT_EMAIL");?>',
            'INCORRECT_EMAIL': '<?=Loc::getMessage("INCORRECT_EMAIL");?>'
        });
    </script>

    <div id="ajax-add-answer"></div>
    <button id="css_popup" class="css_popup">Open PopUp</button>
    <button id="show_panel" class="show_panel">Open Side-Panel</button>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>