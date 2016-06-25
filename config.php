<?php
$html = new phpHtml();
$cssGlobalFiles = json_decode(file_get_contents(ROOTPATH . '/view/htmlscripts/css.json'), true);
$jsGlobalFiles = json_decode(file_get_contents(ROOTPATH . '/view/htmlscripts/js.json'), true);

foreach ($jsGlobalFiles['global'] as $jsGlobal) {
    $js['header'][] = $html->register_js($jsGlobal);
}
foreach ($cssGlobalFiles['global'] as $cssGlobal) {
    $css['header'][] = $html->register_css($cssGlobal);
}
if (isset($_SESSION['admin'])) {
    foreach ($cssGlobalFiles['admin'] as $cssGlobal) {
        $css['header'][] = $html->register_css($cssGlobal);
    }
    foreach ($jsGlobalFiles['dentista'] as $jsGlobal) {
        $js['header'][] = $html->register_js($jsGlobal);
    }
}