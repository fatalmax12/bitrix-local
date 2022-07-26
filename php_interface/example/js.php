<?php
$arJsConfig = array( 
    'myjs' => array( 
        'js' => '/local/js/myjs/myjs.js', 
        'rel' => array('ajax', 'popup'), 
    ) 
); 

foreach ($arJsConfig as $ext => $arExt) { 
    \CJSCore::RegisterExt($ext, $arExt); 
}

CUtil::InitJSCore(array('myjs'));
