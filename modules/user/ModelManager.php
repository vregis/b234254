<?php

namespace modules\user;

use modules\user\models\Profile;
use modules\user\models\SocialAccount;
use modules\user\models\User;
use Yii;
use yii\base\Component;
use yii\db\ActiveQuery;

/**
 * Компонент для создания моделей и поиска пользователей
 *
 * @method models\User                          createUser
 * @method models\Token                         createToken
 * @method models\Profile                       createProfile
 * @method models\SocialAccount                 createSocialAccount
 * @method models\UserSearch                    createUserSearch
 * @method models\forms\RegistrationForm        createRegistrationForm
 * @method models\forms\ResendForm              createResendForm
 * @method models\forms\LoginForm               createLoginForm
 * @method models\forms\RecoveryForm            createRecoveryForm
 * @method models\forms\RecoveryRequestForm     createRecoveryRequestForm
 * @method ActiveQuery                          createUserQuery
 * @method ActiveQuery                          createTokenQuery
 * @method ActiveQuery                          createProfileQuery
 * @method ActiveQuery                          createSocialAccountQuery
 *
 * @author MrArthur
 * @since 1.0.0
 */
class ModelManager extends Component
{
    /** @var string */
    public $userClass = 'modules\user\models\User';
    /** @var string */
    public $tokenClass = 'modules\user\models\Token';
    /** @var string */
    public $profileClass = 'modules\user\models\Profile';
    /** @var string */
    public $socialAccountClass = 'modules\user\models\SocialAccount';
    /** @var string */
    public $userSearchClass = 'modules\user\models\UserSearch';
    /** @var string */
    public $registrationFormClass = 'modules\user\models\forms\RegistrationForm';
    /** @var string */
    public $resendFormClass = 'modules\user\models\forms\ResendForm';
    /** @var string */
    public $loginFormClass = 'modules\user\models\forms\LoginForm';
    /** @var string */
    public $recoveryFormClass = 'modules\user\models\forms\RecoveryForm';
    /** @var string */
    public $recoveryRequestFormClass = 'modules\user\models\forms\RecoveryRequestForm';

    /**
     * Ищет пользователея по $id
     *
     * @param $id
     * @return array|null|User
     */
    public function findUserById($id)
    {
        return $this->findUser(['id' => $id])->one();
    }

    /**
     * Finds a user by the given username.
     *
     * @param  string $username Username to be used on search.
     * @return models\User
     */
    public function findUserByUsername($username)
    {
        return $this->findUser(['username' => $username])->one();
    }

    /**
     * Ищет пользователя по $email
     *
     * @param $email
     * @return array|null|User
     */
    public function findUserByEmail($email)
    {
        return $this->findUser(['email' => $email])->one();
    }

    /**
     * Finds a user by the given username or email.
     *
     * @param  string $usernameOrEmail Username or email to be used on search.
     * @return models\User
     */
    public function findUserByUsernameOrEmail($usernameOrEmail)
    {
        if (filter_var($usernameOrEmail, FILTER_VALIDATE_EMAIL)) {
            return $this->findUserByEmail($usernameOrEmail);
        }

        return $this->findUserByUsername($usernameOrEmail);
    }

    /**
     * Ищет пользователя по $address
     *
     * @param $address
     * @return array|null|User
     */
    public function findUserByAddress($address)
    {
        return $this->findUser(['address' => $address])->one();
    }

    /**
     * Finds a user by the given condition.
     *
     * @param  mixed $condition Condition to be used on search.
     * @return \yii\db\ActiveQuery
     */
    public function findUser($condition)
    {
        return $this->createUserQuery()->where($condition);
    }

    /**
     * Finds a token by user id and code.
     *
     * @param  int $userId
     * @param  string $code
     * @param  int $type
     * @return models\Token
     */
    public function findToken($userId, $code, $type)
    {
        return $this->createTokenQuery()->where(['user_id' => $userId, 'code' => $code, 'type' => $type])->one();
    }

    /**
     * Ищет профиль пользователя по $user_id
     *
     * @param $user_id
     * @return array|null|Profile
     */
    public function findProfileByUserId($user_id)
    {
        if (!Yii::$app->user->isGuest && $user_id === Yii::$app->user->id) {
            /** @var User $identity */
            $identity = Yii::$app->user->identity;
            return $identity->profile;
        } else {
            return $this->findProfile(['user_id' => $user_id])->one();
        }
    }

    /**
     * Ищет профиль по условию $condition
     *
     * @param $condition
     * @return ActiveQuery
     */
    public function findProfile($condition)
    {
        return $this->createProfileQuery()->where($condition);
    }

    /**
     * Ищет аккаунт соц. сети по $id
     *
     * @param $id
     * @return array|null|SocialAccount
     */
    public function findSocialAccountById($id)
    {
        $id = (int)$id;
        return $this->createSocialAccountQuery()->where(['id' => $id])->one();
    }

    /**
     * Ищет аккаунт соц. сети по $provider и $clientId
     *
     * @param $provider
     * @param $clientId
     * @return array|null|SocialAccount
     */
    public function findSocialAccount($provider, $clientId)
    {
        return $this->createSocialAccountQuery()->where(
            [
                'provider' => $provider,
                'client_id' => $clientId
            ]
        )->one();
    }

    /**
     * @param string $name
     * @param array $params
     * @return mixed|object
     */
    public function __call($name, $params)
    {
        $property = (false !== ($query = strpos($name, 'Query'))) ? mb_substr($name, 6, -5) : mb_substr($name, 6);
        $property = lcfirst($property) . 'Class';
        if ($query) {
            return forward_static_call([$this->$property, 'find']);
        }
        if (isset($this->$property)) {
            $config = [];
            if (isset($params[0]) && is_array($params[0])) {
                $config = $params[0];
            }
            $config['class'] = $this->$property;
            return \Yii::createObject($config);
        }

        return parent::__call($name, $params);
    }
}