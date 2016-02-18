<?php

use common\modules\core\widgets\Flash;
use yii\helpers\Url;

/**
 * @var frontend\modules\core\base\View $this
 */
?>

    <!-- FOOTER -->
    <table class="footer">
        <tr>
            <td class="left">&nbsp;</td>
            <td class="center">
                <div class="contact-side">
                    <div class="logo-footer">
                        <a href="<?= Url::to(['/core/default/index']) ?>" title="Chess">
                            <i class="icon icon-logo-footer"></i>
                        </a>
                    </div>
                    <div class="copyright-block">
                        &copy; 2013 - <?= date('Y') ?> chess<br>
                        <span class="law"><?= Yii::t('mirprost', 'Все права защищены') ?></span>
                    </div>
                </div>
                <div class="footer-menu">
                    <?= $this->render('//layouts/_partial/menu_footer') ?>
                    <div class="navigation">
                        <div class="navigation-title">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </td>
            <td class="right">&nbsp;</td>
        </tr>
    </table>
    <!-- FOOTER END -->



<?php if (YII_ENV == 'prod'): ?>
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
        ga('create', 'UA-56909820-1', 'auto');
        ga('send', 'pageview');
    </script>
<?php endif ?>

<?php $this->endBody() ?>
    </body>
    </html>

<?php $this->endPage() ?>
