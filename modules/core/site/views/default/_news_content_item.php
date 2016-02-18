<?php

/**
 * @var frontend\modules\core\base\View $this
 * @var common\modules\content\models\Content $content
 * @var string $moduleName
 * @var bool $isSmall
 * @var array $userRlogsArray
 */
use common\modules\content\models\base\BaseRlog;

/** @var common\modules\user\Module $userMod */
$userMod = Yii::$app->getModule('user');

// подсветка элементов за которые текущий пользователь уже голосовал
$likeActive = $dislikeActive = false;
if (isset($userRlogsArray[$content->id])):
    $likeActive = $userRlogsArray[$content->id] == BaseRlog::VOTE_LIKE ? true : false;
    $dislikeActive = $userRlogsArray[$content->id] == BaseRlog::VOTE_DISLIKE ? true : false;
endif;

// ссылка на голосование для текущего элемента
$likeUrl = $this->url(['/news/rating-vote', 'object' => 'content', 'id' => $content->id, 'value' => BaseRlog::VOTE_LIKE]);
$dislikeUrl = $this->url(['/news/rating-vote', 'object' => 'content', 'id' => $content->id, 'value' => BaseRlog::VOTE_DISLIKE]);

?>

<div class="content-spisok-bl" id="content_<?= $content->id ?>"
     data-content_id="<?= $content->id ?>">
    <div class="content-info-bl">
        <div class="ava-bl">
            <div class="td-bl">
                <?php if(!$isAvtorModerator ){ ?>
                <a class="ava-img" href="/user_profile/<?= $content->user_id ?>">
                    <img width="30" height="30" src="<?= $userMod->getAvatarUrl($content->user_id) ?>" alt="">
                </a>
                <?php } else { ?>
                    <a class="ava-img" href="javascript:void(0);">
                        <img width="30" height="30" src="/style/main/img/logo-red.png" alt="">
                    </a>
                <?php } ?>
            </div>
            <div class="td-bl">
                <?php if(!$isAvtorModerator ){ ?>
                <a href="/user_profile/<?= $content->user_id ?>" class="name-bl">
                    <?= $this->encode($content->user->username) ?>
                </a>
                <?php } else { ?>
                    <a href="javascript:void(0);" class="name-bl">
                        <?= 'Mirprost'; ?>
                    </a>
                <?php } ?>
                <div class="title-bl">
                    <?= $this->formatDate($content->created_at, '{0, date, dd MMMM YYYY}') ?>
                    <?= Yii::t('content', 'г.') ?>
                </div>
            </div>
            <div class="td-bl">
                <a class="btn-expand" href="<?= $this->url('/news/content-view/'.$content->id) ?>">

                    <i class="icon-btn-expand">icon</i>
                </a>
            </div>
        </div>
        <div class="content-spisok-title">
            <div class="td-bl">
                <div class="title-bl">
                    <?= $this->encode($content->title) ?>
                </div>
            </div>
            <div class="td-bl">
                <div class="option-bl">
                    <i class="icon-spisok-info i-video">icon</i> <?= $content->total_videos ?>
                </div>
                <div class="option-bl">
                    <i class="icon-spisok-info i-foto">icon</i> <?= $content->total_photos ?>
                </div>
                <div class="option-bl">
                    <i class="icon-spisok-info i-text">icon</i> <?= $content->total_texts ?>
                </div>
            </div>
        </div>
 <!--   Если моя статья -->
            <?php if ($content->user_id == Yii::$app->user->id) { ?>
        
        <div class="content-lick-bl">
            <div class="lick-sp">
                <a href="javascript:void(0);" class="lick-bl repost">
                    <i class="icon-lick i-repost-def">icon</i>

                    <div class="title-bl">
                        -
                    </div>
                </a>
                <a href="javascript:void(0)" data-url="<?= $likeUrl ?>"
                   class="lick-bl lick-up content-rating-button non ">
                    <i class="icon-lick  i-lick-def">icon</i>

                    <div class="title-bl content-rating-count-likes">
                        <?= $content->rating_like ?>
                    </div>
                </a>
                <a href="javascript:void(0)" data-url="<?= $dislikeUrl ?>"
                   class="lick-bl lick-down content-rating-button non">
                    <i class="icon-lick i-nolick-def">icon</i>

                    <div class="title-bl content-rating-count-dislikes">
                        <?= $content->rating_dislike ?>
                    </div>
                </a>
            </div>
        </div>
            <?php }else{ ?>
                      <div class="content-lick-bl">
            <div class="lick-sp">
                <a href="javascript:void(0)" class="lick-bl repost" onclick="RepostContent('<?= $moduleName ?>', '<?= $content->id ?>')">
                    <i class="icon-lick i-repost">icon</i>

                    <div class="title-bl">
                        -
                    </div>
                </a>
                <a href="javascript:void(0)" data-url="<?= $likeUrl ?>"
                   class="lick-bl lick-up content-rating-button <?= $likeActive ? 'active' : '' ?>">
                    <i class="icon-lick i-lick">icon</i>

                    <div class="title-bl content-rating-count-likes">
                        <?= $content->rating_like ?>
                    </div>
                </a>
                <a href="javascript:void(0)" data-url="<?= $dislikeUrl ?>"
                   class="lick-bl lick-down content-rating-button <?= $dislikeActive ? 'active' : '' ?>">
                    <i class="icon-lick i-nolick">icon</i>

                    <div class="title-bl content-rating-count-dislikes">
                        <?= $content->rating_dislike ?>
                    </div>
                </a>
            </div>
        </div>
 
            <?php } ?>
        
    </div>
    <div class="media-bl">
        <a href="<?= $this->url('/news/content-view/'.$content->id) ?>"  class="layout-clickeble"></a>
        <div style="background: url('<?= $content->findTileUrl($moduleName, $count) ?>');background-size: cover;"
             class="img-bl">
        </div>
    </div>
</div>