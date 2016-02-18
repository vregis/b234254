<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 10.12.2015
 * Time: 10:36
 */
use yii\web\View;

//BEGIN GLOBAL MANDATORY STYLES
$this->registerCssFile("/fonts/Open Sans/OpenSans.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/font-awesome/css/font-awesome.min.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/simple-line-icons/simple-line-icons.min.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap/css/bootstrap.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/uniform/css/uniform.default.css");
$this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css");

//BEGIN THEME GLOBAL STYLES
$this->registerCssFile("/metronic/theme/assets/global/css/components.css");
$this->registerCssFile("/metronic/theme/assets/global/css/plugins.css");

//BEGIN PLUGINS STYLES
$this->registerCssFile("/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.css");

//BEGIN THEME LAYOUT STYLES
//$this->registerCssFile("/metronic/theme/assets/layouts/layout/css/layout.min.css");
$this->registerCssFile("/metronic/theme/assets/layouts/layout/css/themes/darkblue.min.css");
$this->registerCssFile("/metronic/theme/assets/layouts/layout/css/custom.css");


$pos = ['position' => View::POS_HEAD];
$this->registerJsFile("/metronic/theme/assets/global/plugins/respond.min.js", $pos);
$this->registerJsFile("/metronic/theme/assets/global/plugins/excanvas.min.js", $pos);

//BEGIN CORE PLUGINS
$this->registerJsFile("/metronic/theme/assets/global/plugins/jquery.min.js", $pos);
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap/js/bootstrap.min.js", $pos);
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js", $pos);
$this->registerJsFile("/metronic/theme/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js", $pos);
$this->registerJsFile("/metronic/theme/assets/global/plugins/jquery.blockui.min.js", $pos);
$this->registerJsFile("/metronic/theme/assets/global/plugins/uniform/jquery.uniform.min.js", $pos);
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js", $pos);

//BEGIN PLUGINS STYLES
$this->registerJsFile("/metronic/theme/assets/global/plugins/bootstrap-toastr/toastr.min.js", $pos);

//BEGIN THEME GLOBAL SCRIPTS
$this->registerJsFile("/metronic/theme/assets/global/scripts/app.min.js", $pos);

//BEGIN THEME LAYOUT SCRIPTS
$this->registerJsFile("/metronic/theme/assets/layouts/layout/scripts/layout.min.js", $pos);
$this->registerJsFile("/metronic/theme/assets/layouts/layout/scripts/demo.min.js", $pos);
$this->registerJsFile("/metronic/theme/assets/layouts/global/scripts/quick-sidebar.min.js", $pos);
?>
