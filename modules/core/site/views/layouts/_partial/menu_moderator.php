<?php

use yii\widgets\Menu;
use common\modules\news\models\content\NewsContent;
use common\modules\discussion\models\content\DiscussionContent;

$this->registerJsFile('/content/js/moderator.js');
$moduleId = yii::$app->controller->module->id;
$actionId = yii::$app->controller->action->id;
$path = $moduleId . '/' . $actionId;
//vd($moduleId.'/'.$actionId);

$Modname = Yii::$app->controller->module->id;

if (!empty(Yii::$app->request->get()['id'])) {
    $id = (int) Yii::$app->request->get()['id'];

    //роут для разных модулей

    if($Modname == 'news') {
        $isContentPablished = NewsContent::isContentPablished($id);
        $isContentNotPublished = NewsContent::isContentNotPublished($id);
    }elseif($Modname == 'discussion') {
        $isContentPablished = DiscussionContent::isContentPablished($id);
        $isContentNotPublished = DiscussionContent::isContentNotPublished($id);
    }
}
if(!Yii::$app->user->isGuest){

if (Yii::$app->user->identity->role == 5 && $moduleId == 'user_profile' ||  Yii::$app->user->identity->role == 5 && $moduleId == 'news' || Yii::$app->user->identity->role == 5 && $moduleId == 'discussion') {
    echo '<div class="moderator">';
    echo '
    <style>
        .background-main-page{
            background-position:  center 134px;
        }
        .main-turnir-btn{
         top:315px;
        }
    </style>
    ';
    switch ($path) {
        case $Modname . "/content-view":
            if ($isContentPablished) {
                echo Menu::widget(
                        [
                            'items' => [
                                [
                                    'label' => Yii::t('mirprost', 'Отказать в публикации'),
                                    'url' => 'javascript:void(0);',
                                    'options' => ['onclick' => 'beforSendMessageCancel(' . $id . ')',
                                    ]
                                ],
                            ],
                        ]
                );
            } elseif ($isContentNotPublished) {
                echo Menu::widget(
                        [
                            'items' => [
                                [
                                    'label' => Yii::t('mirprost', 'Опубликовать'),
                                    'url' => 'javascript:void(0);',
                                    'options' => ['onclick' => 'publicThis(' . $id . ',"'.$Modname.'")', 'class' => 'public-button']
                                ]
                            ],
                        ]
                );
            } else {
                echo Menu::widget(
                        [
                            'items' => [
                                [
                                    'label' => Yii::t('mirprost', 'Опубликовать'),
                                    'url' => 'javascript:void(0);',
                                     'options' => ['onclick' => 'publicThis(' . $id . ',"'.$Modname.'")', 'class' => 'public-button']
                                ],
                                [
                                    'label' => Yii::t('mirprost', 'Отказать в публикации'),
                                    'url' => 'javascript:void(0);',
                                    'options' => ['onclick' => 'beforSendMessage(' . $id . ',' . yii::$app->user->id . ')']
                                ],
                            ],
                        ]
                );
            }
?>
            <?php

            break;
        default :
            $Modname_name = Yii::$app->controller->module->id;
            if($Modname == 'news'){$Modname_name = 'Новость:';}
            if($Modname == 'user_profile'){$Modname_name = 'Профиль:';}
            if($Modname == 'discussion'){$Modname_name = 'Обсуждения:';}
            echo Menu::widget(
                    [
                        'items' => [
                            [
                                'label' => Yii::t('mirprost', '{Modname}',['Modname' => $Modname_name]),
                                'url' => ['/' . $Modname . '/'],
                            ],
                            [
                                'label' => Yii::t('mirprost', 'Создать'),
                                 'url' => ['/' . $Modname . '/content-create'],
                            ],
                            [
                                'label' => Yii::t('mirprost', 'Список '),
                                'url' => ['/' . $Modname . '/index'],
                            ],
                            [
                                'label' => Yii::t('mirprost', 'Неопубликованный'),
                                'url' => ['/' . $Modname . '/content-unpublished?items=all'],
                            ],
                            [
                                'label' => Yii::t('mirprost', 'Модерация '),
                                'url' => ['/' . $Modname . '/admin-content-moderation'],
                            ],
                        ],
                    ]
            );
            ?>
            <?php break;
    }
            ?>
    <?php

    echo "         
        <style>
            .content-background{
                top:40px;
            }
            .container-main-navigation{
                top:40px;
            }
            .container{
                top:40px;
            }
            .header{
                top:40px;
            }
            .general-dialog-box{
                top: 40px;
            }
            .footer{
                top: 40px;
            }
        </style>
        ";
    echo '</div>';
}}


