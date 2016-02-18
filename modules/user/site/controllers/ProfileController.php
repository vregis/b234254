<?php

namespace modules\user\site\controllers;

use modules\departments\models\Specialization;
use modules\tasks\models\Task;
use modules\user\models\Education;
use modules\user\models\Language;
use modules\user\models\Profile;
use modules\user\models\Skills;
use modules\user\modules\media\models\PhotoAlbum;
use modules\user\modules\media\models\Video;
use modules\core\site\base\Controller;
use Yii;
use yii\caching\DbDependency;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Контроллер для страниц пользователей
 *
 * @property \frontend\modules\user\Module $module
 *
 * @author MrArthur
 * @since 1.0.0
 */
class ProfileController extends Controller
{
    public $layout = "@modules/user/layouts/login";
    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'index',
                            'profile',
                            'tasks',
                            'sortpriority',
                            'sortspec',
                            'checkprofile',
                        ],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }

    /**
     * Страница для редиректа на страницу текущего пользователя
     *
     * Чтобы не писать в ссылках на свою страницу "id" => Yii::$app->user->id
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect(['/user/profile/profile', 'id' => Yii::$app->user->id]);
    }

    /**
     * Главная страница профиля пользователя
     *
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionProfile($id)
    {
        $id = (int)$id;

        return $this->redirect(['/user_profile/default/index', 'id' => $id]);

        // модель
        $user = $this->module->manager->findUserById($id);

        // проверяем пользователя
        if ($user === null) {
            throw new NotFoundHttpException(Yii::t('user', 'Пользователь не найден'));
        }

        $isMy = $this->isMy($user->id);

        // количество друзей
        $countFriends = Contact::getFriendsCount($user->id);

        // количество сообщений
        $countMessages = $isMy ? Message::getMessagesCount($user->id) : null;

        // альбомы
        $albums = PhotoAlbum::getUserAlbums($user->id);

        // всего альбомов (кеш)
        $duration = 3600;
        $dependency = new DbDependency();
        $dependency->sql = "SELECT MAX(id) FROM {{%user_media_photo_album}} WHERE user_id=:user_id";
        $dependency->params = [':user_id' => $user->id];
        $totalAlbums = Yii::$app->db->cache(
            function () use ($user) {
                return PhotoAlbum::find()->where('user_id=:user_id', [':user_id' => $user->id])->count();
            },
            $duration,
            $dependency
        );

        // видео
        $videos = Video::getUserVideos($user->id);

        // всего видео (кеш)
        $duration = 3600;
        $dependency = new DbDependency();
        $dependency->sql = "SELECT MAX(id) FROM {{%user_media_video}} WHERE user_id=:user_id";
        $dependency->params = [':user_id' => $user->id];
        $totalVideos = Yii::$app->db->cache(
            function () use ($user) {
                return Video::find()->where('user_id=:user_id', [':user_id' => $user->id])->count();
            },
            $duration,
            $dependency
        );

        return $this->render(
            'index',
            [
                'isMy' => $isMy,
                'user' => $user,
                'profile' => $user->profile,
                'countFriends' => $countFriends,
                'countMessages' => $countMessages,
                'albums' => $albums,
                'totalAlbums' => $totalAlbums,
                'videos' => $videos,
                'totalVideos' => $totalVideos,
            ]
        );
    }

    public function actionTasks(){
        $this->layout = 'main';
        $tasks = Task::find()->where(['user_id' =>Yii::$app->user->getId()])->all();
        $specializations = Specialization::find()->all();
        return $this->render('tasks', ['tasks'=>$tasks, 'spec'=>$specializations]);
    }

    public static function checkprofile(){
        $check = true;
        $profile = Profile::find()->where(['user_id' => Yii::$app->user->getId()])->one();
        $education = Education::find()->where(['user_id' => Yii::$app->user->getId()])->one();
        $lang = Language::find()->where(['user_id' => Yii::$app->user->getId()])->one();
        $skils = Skills::find()->where(['user_id' => Yii::$app->user->getId()])->one();

        if($profile->first_name == NULL || $profile->first_name == '' || $profile->last_name == NULL || $profile->last_name == ''){
            $check = false;
        }

        if($profile->country_id == NULL || $profile->country_id == 0){
            $check = false;
        }

        if($profile->city_title == NULL || $profile->city_title == ''){
            $check = false;
        }

        if(!$education){
            $check = false;
        }

        if(!$lang){
            $check = false;
        }

        if(!$skils){
            $check = false;
        }

        return $check;

    }

}