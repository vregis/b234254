<?php

namespace modules\user\models;

use modules\core\base\ActiveRecord as ActiveRecord;
use modules\core\behaviors\PurifierBehavior;
use modules\core\helpers\DateHelper;
use modules\user\site\helpers\SocialHelper;
use Yii;

/**
 * Модель для таблицы "{{%user_profile}}"
 *
 * @property int $id
 * @property int $user_id
 * @property int $avatar_from_steam
 * @property string $first_name
 * @property string $last_name
 * @property int $gender
 * @property string $birth_date
 * @property string $phone
 * @property string $about
 * @property int $city_id
 * @property string $city_title
 * @property int $country_id
 * @property string $country_title
 * @property string $skype
 * @property string $social_vk
 * @property string $social_fb
 * @property string $social_gg
 * @property string $social_tw
 * @property string $social_yt
 * @property string $steam_id
 * @property int $team_id
 * @property string $player_status
 *
 * @property User $user
 *
 * @author MrArthur
 * @since 1.0.0
 */
class Profile extends ActiveRecord {

    use ModuleTrait;

    /** Пол */
    const GENDER_THING = 0;
    const GENDER_FEMALE = 1;
    const GENDER_MALE = 2;

    /**
     * @var int День рождения
     */
    public $birth_day;

    /** @var int Месяц рождения */
    public $birth_month;

    /** @var int Год рождения */
    public $birth_year;

    /** @var mixed Файл аватара */
    public $file;
    public $user;
    public $un;
    public $tool;
    public $country;

    public $email;

    /** @inheritdoc */
    public function behaviors() {
        return [
            // PurifierBehavior
            'purifierBehavior' => [
                'class' => PurifierBehavior::className(),
                'htmlAttributes' => ['about'],
                'textAttributes' => [
                    'first_name',
                    'last_name',
                    'phone',
                    'skype',
                    'social_vk',
                    'social_fb',
                    'social_gg',
                    'social_tw',
                    'social_yt',
                    'steam_id'
                ],
            ],
        ];
    }

    /** @inheritdoc */
    public static function tableName() {
        return 'user_profile';
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [['file'], 'file'],
            [['status'], 'string'],
            // new variables

            ['avatar', 'string'],
            [['show_contacts', 'show_test_result', 'show_socials'], 'integer'],

            // first_name
            [['first_name'], 'trim', 'on' => ['profile', 'social']],
            [['first_name'], 'string', 'max' => 64, 'on' => ['profile', 'social']],
            // last_name
            [['last_name'], 'trim', 'on' => ['profile', 'social']],
            [['last_name'], 'string', 'max' => 64, 'on' => ['profile', 'social']],
            // gender
            [['gender'], 'integer', 'on' => ['profile', 'social']],
            [['gender'], 'in', 'range' => array_keys(self::getGenderArray()), 'on' => ['profile', 'social']],
            // birth_date
            [['birth_date'], 'required', 'on' => ['profile', 'complete']],
            [['birth_date'], 'date', 'format' => 'yyyy-M-d'],
            // birth_day
            [['birth_day'], 'required', 'on' => ['profile']],
            [['birth_day'], 'integer', 'on' => ['profile']],
            [['birth_day'], 'in', 'range' => DateHelper::getDayArray(), 'on' => ['profile']],
            // birth_month
            [['birth_month'], 'required', 'on' => ['profile']],
            [['birth_month'], 'integer', 'on' => ['profile']],
            [['birth_month'], 'in', 'range' => array_keys(DateHelper::getMonthArray()), 'on' => ['profile']],
            // birth_year
            [['birth_year'], 'required', 'on' => ['profile']],
            [['birth_year'], 'integer', 'on' => ['profile']],
            [['birth_year'], 'in', 'range' => DateHelper::getYearArray(), 'on' => ['profile']],
            // phone
            [['phone'], 'trim', 'on' => ['profile']],
            [['phone'], 'string', 'max' => 64, 'on' => ['profile']],
            //avatar_social
            [['avatar_social'], 'string', 'max' => 255],
            // about
            [['about'], 'string', 'on' => ['profile']],
            [['about'], 'string', 'max' => 1024, 'on' => ['profile']],
            // city_id
//            [['city_id'], 'required', 'on' => ['profile', 'complete']],
//            [['city_id'], 'integer', 'on' => ['profile', 'complete']],
//            [
//                ['city_id'],
//                'exist',
//                'targetClass' => City::className(),
//                'targetAttribute' => 'id',
//                'on' => ['profile', 'complete']
//            ],
            // city_title
            //[['city_title'], 'required', 'on' => ['profile', 'complete']],
            //[['city_title'], 'trim', 'on' => ['profile', 'complete']],
            //[['city_title'], 'string', 'max' => 64, 'on' => ['profile', 'complete']],
            // country_id
//            [['country_id'], 'required', 'on' => ['profile', 'complete']],
//            [['country_id'], 'integer', 'on' => ['profile', 'complete']],
//            [
//                ['country_id'],
//                'exist',
//                'targetClass' => Country::className(),
//                'targetAttribute' => 'id',
//                'on' => ['profile', 'complete']
//            ],
            // country_title
            //[['country_title'], 'required', 'on' => ['profile', 'complete']],
            //[['country_title'], 'trim', 'on' => ['profile', 'complete']],
            //[['country_title'], 'string', 'max' => 64, 'on' => ['profile', 'complete']],
            // skype
            [['skype'], 'trim', 'on' => ['profile']],
            [['skype'], 'string', 'max' => 128, 'on' => ['profile']],
            // social_vk
            [['social_vk'], 'trim', 'on' => ['profile-social']],
            [['social_vk'], 'string', 'max' => 255, 'on' => ['profile-social']],
            [['social_vk'], 'url', 'on' => ['profile-social']],
           /* [
                ['social_vk'],
                function ($attr) {
                    $isValid = SocialHelper::checkUrl($this->$attr, 'vk');
                    if (!$isValid) {
                        $this->addError($attr, Yii::t('user', 'Ссылка должна вести на сайт "vk.com"'));
                    }
                }
            ],*/
            // social_fb
            [['social_fb'], 'trim', 'on' => ['profile-social']],
            [['social_fb'], 'string', 'max' => 255, 'on' => ['profile-social']],
            /*[
                ['social_fb'],
                function ($attr) {
                    $isValid = SocialHelper::checkUrl($this->$attr, 'fb');
                    if (!$isValid) {
                        $this->addError($attr, Yii::t('user', 'Ссылка должна вести на сайт "facebook.com"'));
                    }
                }
            ],*/
            // social_gg
            [['social_gg'], 'trim', 'on' => ['profile-social']],
            [['social_gg'], 'string', 'max' => 255, 'on' => ['profile-social']],
            /*[
                ['social_gg'],
                function ($attr) {
                    $isValid = SocialHelper::checkUrl($this->$attr, 'gg');
                    if (!$isValid) {
                        $this->addError($attr, Yii::t('user', 'Ссылка должна вести на сайт "google.com"'));
                    }
                }
            ],*/
            // social_tw
            [['social_tw'], 'trim', 'on' => ['profile-social']],
            [['social_tw'], 'string', 'max' => 255, 'on' => ['profile-social']],
           /* [
                ['social_tw'],
                function ($attr) {
                    $isValid = SocialHelper::checkUrl($this->$attr, 'tw');
                    if (!$isValid) {
                        $this->addError($attr, Yii::t('user', 'Ссылка должна вести на сайт "twitter.com"'));
                    }
                }
            ],*/
            // social_yt
            [['social_yt'], 'trim', 'on' => ['profile-social']],
            [['social_yt'], 'string', 'max' => 255, 'on' => ['profile-social']],
            /*[
                ['social_yt'],
                function ($attr) {
                    $isValid = SocialHelper::checkUrl($this->$attr, 'yt');
                    if (!$isValid) {
                        $this->addError($attr, Yii::t('user', 'Ссылка должна вести на сайт "youtube.com"'));
                    }
                }
            ],*/
            // steam_id
            //[['steam_id'], 'trim'],
            //[['steam_id'], 'string', 'max' => 64],
            // avatar_from_steam
            //[['avatar_from_steam'], 'integer'],
            // avatar_file
            [
                'avatar_file',
                'image',
                'extensions' => ['png', 'jpg',' JPEG','jpeg','JPG','PNG'],
                'maxSize' => 1024 * 1024, // 1 мб
                'minWidth' => $this->module->minAvatarWidth,
                'minHeight' => $this->module->minAvatarHeight,
                'on' => ['avatar']
            ],
            [['team_id'], 'integer'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels() {
        return [
            'id' => Yii::t('user', 'ID'),
            'user_id' => Yii::t('user', 'ID пользователя'),
            'first_name' => Yii::t('user', 'Имя'),
            'last_name' => Yii::t('user', 'Фамилия'),
            'gender' => Yii::t('user', 'Пол'),
            'birth_date' => Yii::t('user', 'Дата рождения'),
            'birth_day' => Yii::t('user', 'День'),
            'birth_month' => Yii::t('user', 'Месяц'),
            'birth_year' => Yii::t('user', 'Год'),
            'phone' => Yii::t('user', 'Телефон'),
            'about' => Yii::t('user', 'О себе'),
            'city_id' => Yii::t('user', 'Город'),
            'city_title' => Yii::t('user', 'Город'),
            'country_id' => Yii::t('user', 'Страна'),
            'country_title' => Yii::t('user', 'Страна'),
            'avatar_from_steam' => Yii::t('user', 'Аватар из Steam'),
            'skype' => Yii::t('user', 'Скайп'),
            'social_vk' => Yii::t('user', 'Вконтакте'),
            'social_fb' => Yii::t('user', 'Facebook'),
            'social_gg' => Yii::t('user', 'Google+'),
            'social_tw' => Yii::t('user', 'Твиттер'),
            'social_yt' => Yii::t('user', 'Youtube'),
            'steam_id' => Yii::t('user', 'Steam ID'),
            'team_id' => Yii::t('user', 'Команда ID'),
            'player_status' => Yii::t('user', 'Должность в команде'),
            'email' => "Email",
        ];
    }

    /** @return \yii\db\ActiveQuery */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /** @return \yii\db\ActiveQuery */
    public function getContact() {
        return $this->hasOne(Contact::className(), ['user_id' => 'user_id']);
    }

    /**
     * Название формы
     *
     * @return string
     */
    public function formName() {
        return 'ProfileForm';
    }

    /** @inheritdoc */
    public function afterFind() {
        // разбиваем дату на день/месяц/год рождения для формы
        if ($this->birth_date !== null) {
            $birth_date = strtotime($this->birth_date);
            $this->birth_year = date('Y', $birth_date);
            $this->birth_month = date('m', $birth_date);
            $this->birth_day = date('d', $birth_date);
        }

        parent::afterFind();
    }

    /** @inheritdoc */
    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->birth_month = (int) $this->birth_month;
            $this->birth_day = (int) $this->birth_day;
            $this->birth_year = (int) $this->birth_year;
            $this->birth_date = checkdate(
                $this->birth_month, $this->birth_day, $this->birth_year
            ) ? $this->birth_date : null;
            $this->birth_date = $this->birth_year . '-' . $this->birth_month . '-' . $this->birth_day;
            $this->birth_date = empty($this->birth_date) ? null : date('Y-m-d', strtotime($this->birth_date));
            // vd($this->birth_date);
            // добавляем название города и страны
           /* if (empty($this->city_id) || ($cityModel = City::findOne($this->city_id)) === null) {
                $this->city_id = $this->country_id = $this->city_title = $this->country_title = null;
            } else {
                $this->city_title = $cityModel->title;
                $this->country_id = $cityModel->country_id;
                $this->country_title = $cityModel->country->title;
            }*/

            return true;
        } else {
            return false;
        }
    }

    /**
     * Массив с полами
     *
     * @return array
     */
    public static function getGenderArray() {
        return [
            self::GENDER_THING => Yii::t('user', 'Не указан'),
            self::GENDER_MALE => Yii::t('user', 'Мужской'),
            self::GENDER_FEMALE => Yii::t('user', 'Женский')
        ];
    }

    /**
     * Получаем строковое значение половой принадлежности пользователя
     *
     * @return string
     */
    public function getGender() {
        $data = self::getGenderArray();
        return isset($data[$this->gender]) ? $data[$this->gender] : $data[self::GENDER_THING];
    }

    /**
     * Заполняет пустые поля профиля доступными данными из подключенной соц. сети
     *
     * @param SocialAccount $account
     * @return \yii\web\Response
     */
    public static function fillFromSocial(SocialAccount $account) {
        /** @var \common\modules\user\Module $userMod */
        $userMod = Yii::$app->getModule('user');

        /**
         * @var \common\modules\user\models\Profile $profile
         */
        $profile = $userMod->manager->findProfileByUserId($account->user_id);

        if ($profile === null) {
            Yii::$app->session->setFlash('error', Yii::t('user', 'Профиль не найден'));
            return Yii::$app->controller->goHome();
        }

        // Steam ID
        if ($account->provider == 'st') {
            $profile->steam_id = (string) $account->client_id;
            if (!empty($profile->steam_id)) {
                $profile->updateAttributes(['steam_id']);
            } else {
                Yii::$app->session->setFlash('error', Yii::t('user', 'Не удалось получить Steam ID'));
                return Yii::$app->controller->goHome();
            }
        }

        $profileData = SocialHelper::normalizeProfileData($account->provider, $account->data);

        $profileChanged = $needUpdate = false;
        $attributeNames = [];
        // в цикле проходим по всем аттрибутам и если нет значения, пытаемся заполнить из соц. сети
        foreach ($profile->attributes as $attribute => $value) {
            // если поле профлия пустое и есть значение в поле из соц. сети
            if (empty($value) && !empty($profileData[$attribute])) {
                $profile->{$attribute} = $profileData[$attribute];
                $attributeNames[] = $attribute;
                $needUpdate = true;
            }
        }

        // если есть заполненные поля, сохраняем модель
        if ($needUpdate) {
            $profile->scenario = 'social';

            if (!empty($profile->birth_date)) {
                $profile->birth_date = date('Y-m-d', strtotime($profile->birth_date));
                $profile->birth_year = date('Y', strtotime($profile->birth_date));
                $profile->birth_month = date('m', strtotime($profile->birth_date));
                $profile->birth_day = date('d', strtotime($profile->birth_date));
            }

            // если есть город, добавляем в обновляемые аттрибуты 'city_title', 'country_id', 'country_title'
            if (in_array('city_id', $attributeNames)) {
                $attributeNames[] = 'city_title';
                $attributeNames[] = 'country_id';
                $attributeNames[] = 'country_title';
            }

            $profileChanged = $profile->save(true, $attributeNames) ? true : false;
        }

        return $profileChanged ? true : null;
    }

    /**
     * Проверяет, есть ли у пользователя хотя бы одна соц. сеть в профиле
     *
     * @return bool
     */
    public function haveSocial() {
        $result = false;
        if (!empty($this->social_fb) ||
            !empty($this->social_yt) ||
            !empty($this->social_vk) ||
            !empty($this->social_tw) ||
            !empty($this->social_gg)
        ) {
            return true;
        }
        return $result;
    }

    /**
     * Возвращает текущее местоположение пользователя: ("Город, Страна")
     *
     * @return null|string
     */
    public function getLocation() {
        if (!empty($this->city_title) && !empty($this->country_title)) {
            return $this->city_title . ', ' . $this->country_title;
        }
        return null;
    }

    /**
     * Проверяет, завершил ли пользователь регистрацию
     *
     * @return bool
     */
    public function getIsComplete() {
        if (!empty($this->birth_date) && !empty($this->city_id) && !empty($this->user->email)) {
            return true;
        }
        return false;
    }


    public static function getUserAvatar($id){

        $avatar = Profile::find()->where(['user_id' => $id])->one();
        if($avatar){
            if($avatar->avatar){
                $url = Yii::$app->params['staticDomain'] .'avatars/'.$avatar->avatar;
            }else{
                $url = '/images/avatar/nophoto.png';
            }
        }

        return $url;

    }

    /*
     * Return model 
     * Выводит всех членов команды


    public static function getMembersOfTeamByTeamId($team_id) {

        $model = self::find()->where(['team_id' => $team_id])->all();
        if (!empty($model)) {
            return $model;
        } else {
            return false;
        }
    }
    */
    /*
     * 
     * Выводит страну
     */

   /* public static function getCountry($user_id) {

        $model = self::find()->where(['user_id' => $user_id])->one();
        if (!empty($model)) {
            return $model->country_id;
        } else {
            return false;
        }
    }*/

}
