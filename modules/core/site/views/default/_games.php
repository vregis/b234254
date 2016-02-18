<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var frontend\modules\core\base\View $this
 * @var common\modules\dota\models\Game $games
 * @var common\modules\dota\models\Game $game
 */

$this->registerJsFile('/js/dota.js', [/*'depends' => JqueryAsset::className()*/]);

echo Html::hiddenInput('redirectUrl', Url::to(['/core/default/index']), ['id' => 'redirectUrl']);

?>

<?php foreach ($games as $game): ?>
    <div class="row">
        <div class="col">
            <?= $game->getCountCurrent() ?> / <?= $game->getCountTotal() ?>
        </div>
        <div class="col">
            <?= $game->count_one ?> x <?= $game->count_two ?>
        </div>
        <div class="col">
            <?= $game->getModesArray()[$game->mode] ?>
        </div>
        <div class="col">
            <?= $game->bid ?>
        </div>
        <div class="col wait">
            <?= $game->getStatusArray(true)[$game->status] ?>
        </div>
        <div class="col">
            <?= $this->render('//dota/views/default/_list_buttons', ['game' => $game]) ?>
        </div>
    </div>
<?php endforeach ?>