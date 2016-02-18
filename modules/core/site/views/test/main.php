<?php

//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Url;
//use yii\widgets\Pjax;

/**
 * @var modules\core\site\base\View $this
 */

$this->title = 'Главная страница';

?>

<div class="hor-menu ">
    <ul class="nav navbar-nav">
        <li class="nav-strategy <? if($col==0) : ?>active<? endif; ?>">

            <a href="<?= Url::toRoute(['/core/page','id' => '0']) ?>"><span class="ico-strategy"></span>Strategy</a>
        </li>
        <li class="menu-dropdown classic-menu-dropdown nav-customers <? if($col==1) : ?>active<? endif; ?>">
            <a data-hover="megamenu-dropdown" data-close-others="true" data-toggle="dropdown" href="/core/page/1" class="" aria-expanded="false">
                <span class="ico-customers"></span>Customers <i class="fa fa-angle-down"></i>
            </a>
            <ul class="dropdown-menu pull-left" style="min-width: 250px">
                <li>
                    <a href="<?= Url::toRoute(['/core/page','id' => '1']) ?>">Customers</a>
                </li>
                <li class=" ">
                    <a href="table_basic.html">
                        Basic Datatables </a>
                </li>
                <li class=" ">
                    <a href="table_tree.html">
                        Tree Datatables </a>
                </li>
                <li class=" ">
                    <a href="table_responsive.html">
                        Responsive Datatables </a>
                </li>
                <li class=" ">
                    <a href="table_managed.html">
                        Managed Datatables </a>
                </li>
                <li class=" ">
                    <a href="table_editable.html">
                        Editable Datatables </a>
                </li>
                <li class=" ">
                    <a href="table_advanced.html">
                        Advanced Datatables </a>
                </li>
                <li class=" ">
                    <a href="table_ajax.html">
                        Ajax Datatables </a>
                </li>
            </ul>
        </li>
        <li class="nav-documents <? if($col==2) : ?>active<? endif; ?>">
            <a href="<?= Url::toRoute(['/core/page','id' => '2']) ?>"><span class="ico-documents"></span>Documents</a>
        </li>
        <li class="nav-product <? if($col==3) : ?>active<? endif; ?>">
            <a href="<?= Url::toRoute(['/core/page','id' => '3']) ?>"><span class="ico-products"></span>Product</a>
        </li>
        <li class="nav-numbers <? if($col==4) : ?>active<? endif; ?>">
            <a href="<?= Url::toRoute(['/core/page','id' => '4']) ?>"><span class="ico-numbers"></span>Numbers</a>
        </li>
        <li class="nav-it <? if($col==5) : ?>active<? endif; ?>">
            <a href="<?= Url::toRoute(['/core/page','id' => '5']) ?>"><span class="ico-computers"></span>IT</a>
        </li>
        <li class="nav-people <? if($col==6) : ?>active<? endif; ?>">
            <a href="<?= Url::toRoute(['/core/page','id' => '6']) ?>"><span class="ico-people"></span>People</a>
        </li>
        <li class="nav-idea <? if($col==7) : ?>active<? endif; ?>">
            <a href="<?= Url::toRoute(['/core/page','id' => '7']) ?>"><span class="ico-idea"></span>Idea</a>
        </li>

    </ul>
</div>