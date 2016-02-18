<?php

use yii\web\View;

/**
 * @var frontend\modules\core\base\View $this
 * @var int $id
 */

/**
 * @var bool $open Открывать ли окно или оставить скрытым
 */
$open = isset($open) ? $open : true;

?>
<div class="backdr" style="z-index:555;position:fixed; width:100%; height:100%; top:0; left:0; background-color:rgba(0,0,0,0.9);"></div>
    <!-- Окно Окно Windows  -->
    <div class="text-center dialog-box light-box dialog-make_a_bet <?php if(isset($class_dialog)){echo $class_dialog;} ?>" data-index="555" id="<?= $id ?>" style="/*position: fixed;*/">
        <div class="head-dialog">
            <?php if(isset($icon) && !empty($icon)):?>
                <span class="icon"><img src="/images/<?php echo $icon?>" alt=""></span><!--verified email  -->
            <?php else:?>
                <span class="icon"><img src="/images/dialog-box-check.png" alt=""></span><!--verified email  -->
            <?php endif;?>
        </div>
        <div class="body-dialog">
            <div class="title"><?= $title ?></div>
            <p style="margin-top:0;"><?= $message ?></p>
            <div class="exit-submit ">
                <button class="btn btn-primary" style="width: 72px;" type="submit"
                        onclick="close_dialog('<?= $id ?>');"><?= Yii::t('mirprost', 'Close') ?></button>
            </div>
        </div>
    </div>
    <style>
        .dialog-box{
            padding: 43px 50px;
            margin:0 auto;
            border-radius:15px !important;
            background:#fff;
            position: absolute;
            top:50%;
            left:50%;
            font-family:"Open Sans",sans-serif;
            color:#7a7f82;
            width:382px;
        }
        .dialog-box .head-dialog{
            margin-bottom:35px;
            text-align:center;
        }
        .dialog-box .head-dialog img{
            margin:0 auto;
        }
        .dialog-box .title{
            font-size:24px;
            text-transform:uppercase;
        }
        .dialog-box .body-dialog p{
            font-size:14px;
        }
        .btn-primary,.btn-success,.btn-danger{
    border-radius: 20px;
    background: #fff;
    border-width: 1px;
    border-color: #818588;
    border-style: solid;
    color: #818588;
}
.btn:hover,.open > .btn-primary.dropdown-toggle{
    border-color:#fff !important;
    /*box-shadow: inset 0 0 10px 5px #fff !important;*/
    color:#fff !important;
}
.btn-primary,.btn-success, .btn-danger{
    position: relative;
}
.btn-danger:hover{
    background-color: #FF5252 !important;
}

.btn-primary:hover:before,.btn-success:hover:before,.btn-danger:hover:before,.open > .btn-primary.dropdown-toggle:before{
    opacity: 1;
}
.btn-primary.active:before,.btn-success.active:before,.btn-danger.active:hover:before{
    opacity: 1;
}
.btn-success.active, .btn-success:hover{
    border-color: #0f9d58 !important;
    background-color: #0f9d58 !important;
    color: #ffffff;
}
.btn-primary.active, .btn-primary:hover, .open > .btn-primary.dropdown-toggle {
    border-color: #5184f3 !important;
    background-color: #5184f3 !important;
    color: #ffffff !important;
}
.btn-danger.active, .btn-danger:hover {
    border-color: #FF5252 !important;
    background-color: #FF5252 !important;
    color: #ffffff !important;
}
.btn.active:hover,*.active > .btn:hover{
    box-shadow: none !important;
}
.btn.static:hover, .btn.static:focus{
    box-shadow: none !important;
    background: #fff !important;
    border-width: 1px !important;
    border-color: #818588 !important;
    border-style: solid !important;
    color: #818588 !important;
}
.btn.static:hover:before{
    opacity: 0;
}
.btn-success:focus, .btn-success.focus,.btn-primary:focus, .btn-primary.focus{
    background: none !important;
    border: 1px solid #818588 !important;
    color: #818588 !important;
}
        @media screen and (max-width:568px){
            .dialog-box{
                left:0;
                margin-left:0 !important;
                width:100%;
                padding:15px 60px;
            }
        }
    </style> 
    <!-- Окно Окно Windows end-->
<?php if ($open): ?>
    <?php $this->registerJs('open_dialog("' . $id . '");', View::POS_READY) ?>
<?php endif ?>