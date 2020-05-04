<?php

/**
* @package     JohnCMS
* @link        http://johncms.com
* @copyright   Copyright (C) 2008-2011 JohnCMS Community
* @license     LICENSE.txt (see attached file)
* @version     VERSION.txt (see attached file)
* @author      http://johncms.com/about
*/

 define('_IN_JOHNCMS', 1); 




$rootpath = ''; // Внимание! Если файл находится в корневой папке, нужно указать $rootpath = '';
 require('incfiles/core.php');
	use PHPImageWorkshop\ImageWorkshop;
	require_once($phpbb_root_path.'PHPImageWorkshop/ImageWorkshop.php');

$base = ImageWorkshop::initFromPath($rootpath.'avatar/images/blank.png'); //tao anh trong
if($_GET['khac']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/khac/'.$_GET['khac'].'.png');

$base->addLayerOnTop($canh, 0, 0, "LB");
//////
}
// them canh
if($_GET['canh']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/canh/'.$_GET['canh'].'.png');
$base->addLayerOnTop($canh, 0, 0, "LB");
}

// them ao
if($_GET['ao']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/ao/'.$_GET['ao'].'.png'); // kiem tra gioi tinh
$base->addLayerOnTop($canh, 0, 0, "LB");
} else { // neu ko co quan ao thi dung mac dinh
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/ao/0.png');
$base->addLayerOnTop($canh, 0, 0, "LB");}

// them quan
if($_GET['quan']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/quan/'.$_GET['quan'].'.png'); // kiem tra gioi tinh
$base->addLayerOnTop($canh, 0, 0, "LB");
} else { // neu ko co quan ao thi dung mac dinh
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/quan/0.png');
$base->addLayerOnTop($canh, 0, 0, "LB");}

// khuôn mặt
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/khuonmat.png');
$base->addLayerOnTop($canh, 0, 0, "LB");

// them toc
if($_GET['toc']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/toc/'.$_GET['toc'].'.png');
$base->addLayerOnTop($canh, 0, 0, "LB");
} else {
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/toc/0.png');
$base->addLayerOnTop($canh, 0, 0, "LB");}


// thêm mặt nạ
if($_GET['matna']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/matna/'.$_GET['matna'].'.png');
$base->addLayerOnTop($canh, 0, 0, "LB");
}

// thêm nón
if($_GET['non']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/non/'.$_GET['non'].'.png');
$base->addLayerOnTop($canh, 0, 0, "LB");
}

// thêm phụ kiện
if($_GET['docamtay']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/docamtay/'.$_GET['docamtay'].'.png');
$base->addLayerOnTop($canh, 0, 0, "LB");
}

// thêm thú cưng
if($_GET['thucung']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/thucung/'.$_GET['thucung'].'.png');
$base->addLayerOnTop($canh, 0, 0, "LB");
}

// thêm tâm trạng
if($_GET['mat']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/mat/'.$_GET['mat'].'.png');
$base->addLayerOnTop($canh, 0, 0, "LB");
}else {
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/mat/0.png');
$base->addLayerOnTop($canh, 0, 0, "LB");
}
//////
if($_GET['kinh']){
$canh=ImageWorkshop::initFromPath($rootpath.'avatar/images/kinh/'.$_GET['kinh'].'.png');
$base->addLayerOnTop($canh, 0, 0, "LB");
}
//////



$desiredWidth = 50;
$desiredHeight = 60;
$image = $base->getResult();
header('Content-type: image/png');
imagepng($image, null);
exit;
?>