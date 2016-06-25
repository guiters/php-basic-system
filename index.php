<?php
session_start();
//error_reporting(~E_ALL);
define('ROOTPATH', __DIR__);
define('dominio', 'mysqlwebservice');

include ROOTPATH . '/control/load.model.php';

$request = new phpapijson();
$form = new form();
$page = new pagecontrol();
$html = new phpHtml();

$pageStart = $page->start();

if ($pageStart['pages'][1] == 'sair') {
    session_destroy();
    $html->redirect('/', 1);
    die();
}
if (isset($_SESSION['admin'])) {
    $usuario = $_SESSION['admin'];
    $html->sethtml($js, $css['header'], 'GUI - Mysql WebService', 'top');
    include ROOTPATH . '/control/forms/admin.php';
    $page->setPageStruct(ROOTPATH, ['admin/header'], 'admin/footer', 'admin');
    $html->sethtml($js, '', null, 'bottom');
} else{
    $html->sethtml($js, $css['header'], 'GUI - Mysql WebService', 'top');
    include ROOTPATH . '/control/forms/guest.php';
    $page->setPageStruct(ROOTPATH, ['guest/header'], 'guest/footer', 'guest');
    $html->sethtml($js, '', null, 'bottom');
}