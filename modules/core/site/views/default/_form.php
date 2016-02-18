<?php

use yii\helpers\Html;

/**
 * @var frontend\modules\core\base\View $this
 * @var int $id
 */

?>

<div style="width: 100%;margin: 0 auto;text-align: center;">

    <?php

    echo Html::beginForm('/core/steam', 'GET');
    echo Html::input('text', 'id', $id, ['placeholder' => 'Steam ID', 'style' => 'width: 400px;line-height: 20px;']);
    echo Html::button('Получить информацию',
        ['style' => 'width: 200px;line-height: 20px;cursor:pointer;margin-left: 5px;']);
    echo '&nbsp;&nbsp;&nbsp;';
    echo Html::a('сбросить', '/core/steam');
    echo Html::endForm();

    ?>

</div>