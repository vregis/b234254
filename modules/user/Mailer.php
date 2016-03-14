<?php

namespace modules\user;

use modules\user\models\Token;
use modules\user\models\User;
use Yii;
use yii\base\Component;

/**
 * Класс для отправки почты, связанной с модулем [[user]]
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Mailer extends Component
{
    /** @var string */
    public $viewPath = 'user/views/emails';
    /** @var string|array */
    public $sender = 'admin@fuckyoustyle.com';

    /**
     * Модуль [[mail]]
     *
     * @return null|\common\modules\mail\Module
     */
    private function getMailModule()
    {
        return Yii::$app->getModule('mail');
    }

    /**
     * Sends an email to a user with credentials and confirmation link.
     *
     * @param  User $user
     * @return bool
     */
    public function sendWelcomeMessage(User $user)
    {
        $params['password'] = $user->password;

        return $this->getMailModule()->toQueue(
            $this->sender,
            $user->email,
            Yii::t('user', 'Добро пожаловать на {0}', Yii::$app->name),
            null,
            'welcome',
            $params,
            $this->viewPath
        );
    }

    /**
     * Sends an email to a user with confirmation link.
     *
     * @param  User $user
     * @param  Token $token
     * @return bool
     */
    public function sendConfirmationMessage(User $user, Token $token)
    {
        $params['tokenUrl'] = $token->getUrl();

        return $this->getMailModule()->toQueue(
            $this->sender,
            $user->email,
            Yii::t('user', 'Активируйте ваш аккаунт на {0}', Yii::$app->name),
            null,
            'confirmation',
            $params,
            $this->viewPath
        );
    }

    /**
     * Sends an email to a user with confirmation link immidiatly.
     *
     * @param  User $user
     * @param  Token $token
     * @return bool
     */
    public function sendConfirmationMessageImmidiatly($user)
    {
//vd($user->password_hash.'*'.$user->auth_key );
        Yii::$app->mailer->compose(['html' => 'confirmation-common'], ['hash'=> $user->password_hash,'key'=> $user->auth_key])
            ->setFrom(['support@bigsbusiness.com' => 'Big S Business'])
            ->setTo($user->email)
            ->setSubject(Yii::t('mail','Confirm your email'))
//            ->setTextBody('<b>HTML content</b>')
            ->send();
    }

    /**
     * Sends an email to a user with reconfirmation link.
     *
     * @param  Token $token
     * @param  User $user
     * @return bool
     */
    public function sendReconfirmationMessage(User $user, Token $token)
    {
        $params['tokenUrl'] = $token->getUrl();

        return $this->getMailModule()->toQueue(
            $this->sender,
            $user->unconfirmed_email,
            Yii::t('user', 'Подтвердите смену E-mail на {0}', Yii::$app->name),
            null,
            'reconfirmation',
            $params,
            $this->viewPath
        );
    }

    /**
     * Sends an email to a user with recovery link.
     *
     * @param  User $user
     * @param  Token $token
     * @return bool
     */
    public function sendRecoveryMessage(User $user, Token $token)
    {
        $params['tokenUrl'] = $token->getUrl();

        return $this->getMailModule()->toQueue(
            $this->sender,
            $user->email,
            Yii::t('user', 'Завершите сброс пароля на {0}', Yii::$app->name),
            null,
            'recovery',
            $params,
            $this->viewPath
        );
    }
}