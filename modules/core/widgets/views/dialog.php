<?php

/**
 * @var frontend\modules\core\base\View $this
 */

use yii\helpers\Html;

$flashes = Yii::$app->session->getAllFlashes();



if (count($flashes)):

    $message = '';

    foreach ($flashes as $key => $msg) {
        $message .= $msg . Html::tag('br');
    }

    $title = Yii::t('mirprost', 'Информация');
    $icon = 'dialog-box-info.png';


        if(array_key_exists('verified', $flashes)){
            $title = 'CONGRATULATIONS!';
            $icon = 'dialog-box-check.png';
            $message = 'Your account has been successfully created.';
        }elseif(array_key_exists('confirm_link', $flashes)){
            $title = 'Thank you!';
            $icon = 'dialog-box-mail.png';
            $message = 'A confirmation link was sent to your email.  <br>
Give it up to 5 min.<br>
(keep in mind the Spam/Junk folder)';
        }elseif(array_key_exists('already', $flashes)){
            $title = 'INFORMATION!';
            $icon = 'dialog-box-info.png';
            $message = 'This email has been already confirmed.';
        }




    echo $this->render(
        'dialog/message',
        [
            'id' => 'dialog_flash_message',
            'title' => $title,
            'message' => $message,
            'options' => $options,
            'icon' => $icon
        ]
    );

    // $this->registerJs("open_dialog('dialog_flash_message');", View::POS_READY);

endif;