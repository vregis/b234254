<?php

use modules\core\widgets\IndexChat;
//use frontend\modules\news\widgets\LastNews;
use yii\helpers\Url;
//use yii\widgets\Pjax;

/**
 * @var frontend\modules\core\base\View $this
 * @var common\modules\dota\models\Game $games
 */

$this->title = Yii::t('core', 'Главная страница');

/** @var common\modules\user\models\User $identity */
$identity = Yii::$app->user->identity;

?>

    <!-- Content -->
    <!-- Head -->
    <div class="main-head-container">
        <div class="main-banner-div">
            <div class="head-background">
                <div class="left"></div>
            </div>
            <?= $this->slider(8) ?>
        </div>
        <script type="application/javascript">
            $(document).ready(function () {
                var carousel1Options = {
                    auto: true,
                    timeout: 5000,
                    pause: true,
                    visible: 1,
                    speed: 960,
                    pause: true,
                    btnPrev: function () {
                        return $(this).find('.prev');
                    },
                    btnNext: function () {
                        return $(this).find('.next');
                    },
                    beforeStart: function (a, direction) {

                    },
                    afterEnd: function () {
                        var data_logo = $('.slide.active div', this).attr('data-logo');
                        var data_title = $('.slide.active div', this).attr('data-title');
                        var data_url = $('.slide.active div', this).attr('data-url');
                        $('.img-banner a', this).attr('href', 'javascript:void(0)');
                        /*console.log(data_url)*/
                        $('.main-banner .main-banner-title tr td:nth-child(1) img').attr('src', data_logo);
                        $('.main-banner .main-banner-title tr td.title').html(data_title);
                        $('.slide.active .img-banner a', this).attr('href', data_url);
                    },
                    btnGo: $('.main-banner div.nav').find('a')
                };
                $('.main-banner').jCarouselLite(carousel1Options);
                $('.main-banner .slide.active .main-banner-title').animate({opacity: 1}, 500);

                /* Добавляем два div чтоб небыо дырки слева и справа */
                var img_first = $('.main-banner li:nth-child(3) .img-banner-img').attr('src'),
                    img_last = $('.main-banner li:nth-last-child(3) .img-banner-img').attr('src'),
                    main_banner_slider = $('.main-banner .slides');

                main_banner_slider.append($('<div>', {'class': 'last_dop_div'})
                        .append($('<img>', {'src': img_first, 'width': '960', 'height': '296'}))
                );
                main_banner_slider.prepend($('<div>', {'class': 'first_dop_div'})
                        .append($('<img>', {'src': img_last, 'width': '960', 'height': '296'}))
                );
            });
        </script>
    </div>
    <!-- Head END -->

    <!-- Main navigation -->
<!--    <div class="main-content-navigation">-->
<!--        <div class="content-title-background">-->
<!--            <div class="left"></div>-->
<!--        </div>-->
<!--        <table class="main-head">-->
<!--            <tr>-->
<!--                <td>-->
<!--                    --><?//=  Yii::t('mirprost', '') ?>
<!--                </td>-->
<!--                <td>-->
<!--                    <!--<a href="--><?// /*= Url::to(['/news/default/index']) */ ?><!--">-->
<!--                        <i class="icon-news"></i>-->
<!--                        --><?// /*= Yii::t('mirprost', 'Все новости') */ ?>
<!--                    </a>-->-->
<!--                </td>-->
<!--                <td>-->
<!--<!--                    -->--><?////= Yii::t('mirprost', 'Игры') ?>
<!--                </td>-->
<!--                <td>-->
<!--<!--                    <a href="-->--><?////= Url::to(['/dota/default/index']) ?><!--<!--">-->-->
<!--<!--                        <i class="icon-tyrnirs"></i>-->-->
<!--<!---->-->
<!--<!--                        <div>-->-->
<!--<!--<!--                            -->-->--><?//////= Yii::t('mirprost', 'Все игры') ?>
<!--<!--                        </div>-->-->
<!--<!--                    </a>-->-->
<!--                </td>-->
<!--            </tr>-->
<!--        </table>-->
<!--    </div>-->

    <!-- Main navigation END -->
    <!-- Main Content --> <div class="news-h1 container960" style="padding-top: -18px;padding-left:250px;">НОВОСТИ</div>
    <div class="main-content-container">


        <table class="main-page-content">
            <tr>
                <td class="left">
                    <?php /*
                    <?= IndexChat::widget([]) ?>

                    <div class="divider28px"></div>
                    <div
                        style="color: #999;font-size: 26px;line-height: 26px;padding-bottom: 8px;text-transform: uppercase;">
                        <?= Yii::t('mirprost', 'Новости') ?>
                    </div>
                    <?= LastNews::widget([]) ?>

                    <!--<a href="javascript:void(0);" class="banner320x94">
                        <img src="/image/banner2.jpg" width="320" height="94">
                    </a>
                    <a href="javascript:void(0);" class="banner320x94">
                        <img src="/image/banner2.jpg" width="320" height="94">
                    </a>-->
                    */
                    ?>

                    <div class="profile-left-side" style="padding: 0">
                        <?= $this->banner(6) ?>
                        <?= $this->banner(4) ?>
                    </div>
                </td>
                <td class="right">
<?php  /*                    <div class="main-info-tab-block">
                        <?php if (empty($games)): ?>
<!--                            <div class="th row" style="font-size: 12px;padding: 10px;">-->
<!--                                --><?//= Yii::t('dota', 'Нет ни одной игры') ?>
<!--                            </div>-->
                        <?php else: ?>

                            <div class="th row">
                                <div class="col"><?= Yii::t('dota', 'ИГРОКИ') ?></div>
                                <div class="col"><?= Yii::t('dota', 'ТИП') ?></div>
                                <div class="col"><?= Yii::t('dota', 'МОД') ?></div>
                                <div class="col"><?= Yii::t('dota', 'СТАВКА') ?></div>
                                <div class="col"><?= Yii::t('dota', 'СТАТУС') ?></div>
                            </div>
                            <?php
/*                            // Обновление списка игр
                            $js = <<<JS
                        setInterval(function () {
                            $.pjax.reload({container:'#pjax_dota_games_list_index'});
                        }, 30000);
JS;
                            $this->registerJs($js);?>

                            <?php Pjax::begin(['id' => 'pjax_dota_games_list_index']) ?>
<!--                            --><?//= $this->render('_games', ['games' => $games]) ?>
                            <?php Pjax::end()  ?>

                        <?php endif ?>
                    </div>

<!--                    --><?php //if ($this->beginCache('index_dota_top', ['duration' => 60])): ?>
<!--                        <table class="top-gamers">-->
<!--                            <tr>-->
<!--                                <td class="left-bl">-->
<!--                                    <div class="title-bl">--><?//= Yii::t('dota', 'Топ богатейших') ?><!--</div>-->
<!--                                    --><?//= $this->render('_rechest', ['reachestMan' => $reachestMan]) ?>
<!--                                </td>-->
<!--                                <td class="right-bl">-->
<!--                                    <div class="title-bl">--><?//= Yii::t('dota', 'Топ по количеству игр') ?><!--</div>-->
<!--                                    --><?//= $this->render('_mostgamer', ['mostGamer' => $mostGamer]) ?>
<!--                                </td>-->
<!--                            </tr>-->
<!--                        </table>-->
<!--                        --><?php //$this->endCache() ?>
<!--                    --><?php //endif ?>
*/
?>

                    <?=  $this->render( 'news_content_list',$viewData); ?>

                </td>
            </tr>


        </table>
    </div>
    <!-- Content END-->

<?php /*if (!$this->isGuest && !$identity->getIsConfirmed()): ?>
    <?=
    $this->render(
        '//core/dialog/message',
        [
            'id' => 'email-confirmation-dialog',
            'title' => Yii::t('mirprost', 'Информация'),
            'message' => Yii::t('user', 'Необходимо подтвердить указанный E-mail'),
            'open' => true
        ]
    ) ?>
<?php endif */
?>