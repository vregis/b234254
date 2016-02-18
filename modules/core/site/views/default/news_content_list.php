<?php

/**
 * @var frontend\modules\core\base\View $this
 * @var common\modules\content\models\Content[] $contents
 * @var bool $hasNewPages
 * @var bool $isMy
 * @var int $totalPages
 * @var string $moduleName
 * @var array $userRlogsArray
 */

use common\modules\content\models\Content;
use common\modules\user\models\User;


// js

//$this->registerJsFile('/content/js/list.js');
$this->registerJsFile('/content/js/pager.js');
$this->registerJsFile('/content/js/rating.js');


//vd($hasNewPages);
?>
<?php $Modname = Yii::$app->controller->module->id; ?>



<? /*= $this->render('@viewsPath/content/_top_links') */ ?>



<?php if (empty($contents)): ?>
    <!--<div class="info-text-block" style="margin-top: 20px;">-->
    <p class="mrarthur-media-info-text">
        <?= Yii::t('content', 'Ничего не найдено') ?>
    </p>
    <!--</div>-->

<?php else: ?>

    <div class="content-spisok-page" id="content_spisok">

        <?php if ($isMy): ?>
            <!--<div class="content-spisok-sp count-img-0" id="sortable0" data-item="begin" data-new="0"></div>-->
        <?php endif ?>

        <?php $arrContents = Content::getSortedArray($contents) ?>

        <?php foreach ($arrContents as $posY => $v): ?>

            <?php $countInRow = count(array_keys($v)) ?>

            <div class="content-spisok-sp count-img-<?= $countInRow ?> content-spisok-photo">

                <?php foreach ($v as $posX => $content): ?>

                <?php

                    $role = User::getRoleByUserId($content->user_id);
                    $isAvtorModerator = $role == 5 || $role == 10 ? true : false;
                    //vd($isAvtorModerator);
                ?>
                    <?= $this->render('_news_content_item',
                        [
                            'content' => $content,
                            'count' => $countInRow,
                            'moduleName' => 'news',
                            'userRlogsArray' => $userRlogsArray,
                            'isAvtorModerator' => $isAvtorModerator
                        ]
                    ) ?>
                <?php endforeach; ?>
            </div>

        <?php endforeach; ?>

    </div>

<?php endif; ?>

<?php if ($hasNewPages): ?>

    <div class="content-spisok-page" style="" id="content_sort_pager">
        <div class="button-bl">
            <a class="button-white" href="javascript:void(0);" id="content_show_more"
               data-url="<?= $this->url(["/news"]) ?>"
               data-total="<?= $totalPages ?>"
               data-page="1">
                <i class="icon-next">icon</i>
                <?= Yii::t('content', 'ПОКАЗАТЬ ЕЩЕ') ?>
            </a>
        </div>
    </div>
    <div class="divider20px" id="content_sort_divider" style="display: none;"></div>
<?php endif ?>

