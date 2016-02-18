<?
use yii\helpers\Url;
?>
<!-- BEGIN HEADER -->
<div class="page-header">
    <!-- BEGIN HEADER TOP -->
    <div class="page-header-top">
        <div class="page-container">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/"><img src="/images/logo-default.png" alt="logo" class="logo-default"></a>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
<!--            <a href="javascript:;" class="menu-toggler"></a>-->
            <!-- END RESPONSIVE MENU TOGGLER -->
        </div>
    </div>
    <!-- END HEADER TOP -->
    <!-- BEGIN HEADER MENU -->
    <div class="depart-nav">
        <ul class="pager">
            <li class="previous">

                <a class="btn blue-dark <? if($departments[0]->id == $department->id) echo 'disabled' ?>" href="<?= Url::toRoute(['/departments/questionary/progress', 'step' => $step - 1]) ?>">
                    <i class="fa fa-chevron-left"></i>


                </a>
            </li>
            <div class="custom-depart-name"><?= $department->name ?></div>
            <li class="next">

                <a class="btn blue-dark <? if(isset($departments[$open_step]) && $departments[$open_step]->id == $department->id) echo 'disabled' ?>" href="<?= Url::toRoute(['/departments/questionary/progress', 'step' => $step + 1]) ?>">
                    <i class="fa fa-chevron-right"></i>

                </a>
            </li>
        </ul>
    </div>
    <div class="page-header-menu">
        <div class="page-container">
            <!-- BEGIN MEGA MENU -->
            <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
            <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->

            <div class="hor-menu ">
                <ul class="nav navbar-nav">
                    <? $i = 0; ?>
                    <? foreach($departments as $dep) : ?>
                        <li class="nav-<?= $dep->icons ?> <? if($department->id == $dep->id):?>active<? endif; ?>">
                            <a href="<?= Url::toRoute(['/departments/questionary/progress', 'step' => $i]) ?>"><i class="ico-<?= $dep->icons ?>"></i><?= $dep->name ?></a>
                        </li>
                        <? if($i == $open_step) break; ?>
                        <? $i++; ?>
                    <? endforeach; ?>
                </ul>



            </div>
            <!-- END MEGA MENU -->
        </div>
    </div>
    <!-- END HEADER MENU -->
</div>
<!-- END HEADER -->