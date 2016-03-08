<?php

namespace modules\core\site\controllers;

use modules\core\site\profile\EducationData;
use modules\core\site\profile\LanguageData;
use modules\core\site\profile\ServiceData;
use modules\core\site\profile\SkillData;
use modules\departments\models\Department;
use modules\departments\models\Goal;
use modules\departments\models\Specialization;
use modules\departments\models\UserDo;
use modules\tasks\models\Task;
use modules\tasks\models\UserTool;
use modules\tests\models\TestResult;
use modules\tests\models\TestUser;
use modules\tests\models\TestUserResult;
use modules\user\models\Avatar;
use modules\user\models\Country;
use modules\core\helpers\DateHelper;
use modules\core\models\IndexChat;
use modules\user\models\Education;
use modules\user\models\Language;
use modules\user\models\Languagelist;
use modules\user\models\Languages;
use modules\user\models\Online;
use modules\tests\models\Test;
use modules\core\site\base\Controller as CommonController;
use modules\user\models\Profile;
use modules\user\models\Skilllist;
use modules\user\models\Skills;
use modules\user\models\SkillTag;
use modules\user\models\User;
use modules\user\models\UserSpecialization;
use modules\user\models\UserServise;
use Yii;
use yii\filters\AccessControl;
use modules\core\models\CoreScenario;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\helpers\BaseFileHelper;
use yii\base\Security;
use modules\core\actions\DataTable;
use modules\user\ModelManager;
use modules\user\helpers\PasswordHelper;


/**
 * Основной контроллер frontend-модуля [[core]]
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends CommonController
{
    public $layout = 'main2';
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
                            'error',
                            'captcha',
                            'page',
                            'need_test',
                            'the_seven',
                            'supportform',

                        ],
                        'roles' => ['@','?']
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'main',
                            'mrarthur-get-count-online',
                            'mrarthur-get-chat',
                            'profile',
                            'saveprofile',
                            'changeavatar',
                            'changepass',
                            'updstatus',
                            'updrate',
                            'show',
                            'getimage',
                            'data-table',
                            'sendmailfrommainpage',
                            'service-ajax',
                            'language-ajax',
                            'education-ajax',
                            'skill-ajax',
                            'skills',
                            'set-department-session',
                            'delegatebyemail',
                            'add-multi-specialization',
                            'add-multi-task',
                            'update-specialization',
                            'change-do-department',
                            'change-sell-department',
                            'change-show-department',
                            'privacy-settings',
                            'del-specialization'
                        ],
                        'roles' => ['@']
                    ],
                ]
            ],
        ];
    }

    /** @inheritdoc */
    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'modules\core\actions\CaptchaAction',
                'minLength' => 4,
                'maxLength' => 5,
                'onlyNumbers' => true,
            ],
            'data-table' => [
                'class' => DataTable::className()
            ],
        ];
    }

    /**
     * Главная страница сайта.
     *
     * @return string
     */

    public function beforeAction($action) {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
    /*    $scenario = CoreScenario::findOne(['is_active' => true]);
        if($scenario->controller != 'default') {
            return $this->redirect('/core/'.$scenario->controller.'/index');
        }*/

     /*   if (!$this->isGuest) {
            return $this->redirect('/tests/start');
        }*/
        //$this->layout = 'index';

        /*if(!Yii::$app->user->isGuest){
            $this->redirect(['/tests/start']);
        }*/

        if(isset($_SERVER['HTTP_REFERER']) && !Yii::$app->user->isGuest && strstr($_SERVER['HTTP_REFERER'], '?service=') != false){
            $this->redirect(['/tests/progress']);
        }


        $this->layout = false;
        $mm = new ModelManager();
        $model = $mm->createLoginForm();
        return $this->render('index', ['model'=>$model]);
    }
    public function actionMain()
    {
        return $this->redirect('/departments');
    }
    public function actionThe_seven()
    {
        $this->layout = 'the_seven';
        $col = 0;
        return $this->render('the_seven', ['col' => $col]);
    }

    public function actionNeed_test()
    {
        if (!Yii::$app->user->identity->is_need_test) {
            return $this->redirect('/core/main');
        }
        $this->layout = 'main2';
        $tests = Test::find()->all();
        return $this->render('need_test',
            [
                'tests' => $tests
            ]);
    }
    /**
     * Страница с ошибкой
     */
    public function actionError()
    {
        $errorHandler = Yii::$app->errorHandler->exception;

        $error = [];
        $error['code'] = $errorHandler->getCode() ? $errorHandler->getCode() : 404;
        $error['message'] = $errorHandler->getMessage();

        echo $this->renderPartial('error', ['error' => $error]);
    }

    /**
     * Количество пользователей онлайн
     */
    public function actionMrarthurGetCountOnline()
    {
        $total = Online::getTotalUsers();
        $online = Online::getTotalOnline();
        $gamesOnline = count(Game::find()->where(['status' => Game::STATUS_PLAY])->all());
        $gamesNotReady = count(Game::find()->where(['status' => Game::STATUS_RECRUITING])->all());
        /*$usersRegistredToday = count(User::find()->where('created_at = CURDATE()')->all());
        $usersRegistredYestarday= count(User::find()->where('created_at = CURDATE()-1')->all());*/

        echo <<<HTML
        <!DOCTYPE HTML><html><head><meta charset="utf-8"></head><body>
        Пользователей всего: {$total}<br>
        Пользователей онлайн: {$online}<br><br>
        Идет игр(а): {$gamesOnline}<br>
        Идет набор игроков: {$gamesNotReady}<br>
        </body></html>
HTML;
    }

    /**
     * Сообщения чата
     */
    public function actionMrarthurGetChat()
    {
        $messages = IndexChat::find()
            ->select(['message', 'username', 'created_at'])
            ->asArray()
            ->orderBy(['id' => SORT_ASC])
            ->all();
        echo '<style>body{background: #f8f8f8}table{border-collapse:collapse;}td{padding:10px;border: 1px solid #ccc;}</style>';
        echo '<table style="width: 100%;">';
        foreach ($messages as $message) {
            echo '<tr>';
            echo "<td width=\"200px\">" . DateHelper::formatDate($message['created_at']) . "</td>
            <td width=\"200px\">{$message['username']}:</td>
            <td>{$message['message']}</td>";
            echo '</tr>';
        }
        echo '</table>';
    }

    public function actionProfile(){

        $this->layout = 'main';
        $id = Yii::$app->user->getId();

        $min_points = 10000;
        $max_points = -1;
        $controller = new \modules\tests\site\controllers\DefaultController('default',Yii::$app->getModule('tests'));
        $test_result_inform = $controller->getResultInform($min_points,$max_points);

        $departments = Department::find()->all();
        $sk = Skilllist::find()->all();

        $profile = Profile::find()->where(['user_id' => $id])->one();
        $email = User::find()->where(['id'=>$id])->one();

        $profile->email = $email->email;

        $serviceData = new ServiceData($departments, $sk);
        $languageData = new LanguageData();
        $educationData = new EducationData();
        $skillData = new SkillData($sk);

        $goal = Goal::find()->where(['user_id' => Yii::$app->user->id])->one();
        if (is_null($goal)) {
            $goal = new Goal();
            $goal->count_money = 1000000;
            $goal->user_id = Yii::$app->user->id;
        }

        $user = User::find()->where(['id' => Yii::$app->user->getId()])->one();
        if(count($_POST) > 0) {
            if(array_key_exists('fname', $_POST)) {
                $profile->first_name = $_POST['fname'];
            }
            if(array_key_exists('lname', $_POST)) {
                $profile->last_name = $_POST['lname'];
            }
            if(array_key_exists('status', $_POST)) {
                $profile->status = $_POST['status'];
            }
            if(array_key_exists('rate', $_POST)) {
                $profile->rate = $_POST['rate'];
            }
            if(array_key_exists('country', $_POST)) {
                $profile->country_id = $_POST['country'];
            }
            if(array_key_exists('city', $_POST)) {
                $profile->city_title = $_POST['city'];
            }
            if(array_key_exists('about', $_POST)) {
                $profile->about = $_POST['about'];
            }
            if(array_key_exists('tw', $_POST)) {
                $profile->social_tw = $_POST['tw'];
            }
            if(array_key_exists('fb', $_POST)) {
                $profile->social_fb = $_POST['fb'];
            }
            if(array_key_exists('gg', $_POST)) {
                $profile->social_gg = $_POST['gg'];
            }
            if(array_key_exists('ln', $_POST)) {
                $profile->social_ln = $_POST['ln'];
            }
            if(array_key_exists('inst', $_POST)) {
                $profile->social_in = $_POST['inst'];
            }
            if(array_key_exists('zip', $_POST)) {
                $profile->zip = $_POST['zip'];
            }
            if(array_key_exists('skype', $_POST)) {
                $profile->skype = $_POST['skype'];
            }
            if(array_key_exists('phone', $_POST)) {
                $profile->phone = $_POST['phone'];
            }

            if(array_key_exists('skype', $_POST)) {
                $profile->skype = $_POST['skype'];
            }
            if(array_key_exists('count_money', $_POST) && array_key_exists('date', $_POST)) {
                $goal->count_money = (int)$_POST['count_money'];
                $goal->date = $_POST['date'];
                $goal->save();
            }

            $user->email = $_POST['email']; //TODO think about this if email = '' user can't enter

            $user->save();
            if($profile->save(false)){
                if($user->user_type == User::TYPE_EMPLOYER) {
                    if ($user->user_status == User::STATUS_TEST_PASSED) {
                        $user->user_status = User::STATUS_PROFILE_FILLED;
                        $user->save(false);
                    }
                }
                else {
                    if ($user->user_status == User::STATUS_CREATION) {
                        $user->user_status = User::STATUS_PROFILE_FILLED;
                        $user->save(false);
                    }
                }

                if($user->user_type == User::TYPE_EMPLOYER && $_POST['is_first'] == 1){
                    return $this->redirect(['/departments']);
                }

                if($user->user_type == 1){
                    return $this->redirect(['/departments/business#delegated']);
                }

                return $this->redirect(['/departments/business']);
            }else{
                $response['error'] = true;
                var_dump($profile->getErrors());
            }
        }

        return $this->render('profile', [
            'model'=>$profile,
            'departments'=>$departments,
            'serviceData' => $serviceData,
            'languageData' => $languageData,
            'educationData' => $educationData,
            'skillData' => $skillData,
            'testData' => $test_result_inform,
            'goal' => $goal
        ]);
    }
    public function actionEducationAjax(){
        $educationData = new EducationData();
        return $educationData->ajax();
    }
    public function actionLanguageAjax(){
        $languageData = new LanguageData();
        return $languageData->ajax();
    }
    public function actionServiceAjax(){
        if(!isset($_POST['dep'])){
            $_POST['dep'] = null;
        }
        $serviceData = new ServiceData(null, null, $_POST['dep']);
        if($_POST['command'] == 'delete') {
            return $serviceData->ajaxDelete();
        }else{
            return $serviceData->ajax();
        }
    }
    public function actionSkillAjax(){
        $skillData = new SkillData();
        return $skillData->ajax();
    }
    public function actionSkills(){
        $query = (!empty($_POST['q'])) ? strtolower($_POST['q']) : null;

        if (!isset($query)) {
            die('Invalid query.');
        }

        $status = true;


        $skills = SkillTag::find()->all();
        $databaseUsers = ArrayHelper::map($skills, 'id', 'name');

        $resultUsers = [];
        foreach ($databaseUsers as $key => $oneUser) {
            if (strpos(strtolower($oneUser), $query) !== false ||
                strpos(str_replace('-', '', strtolower($oneUser)), $query) !== false ||
                strpos(strtolower($key), $query) !== false) {
                $resultUsers[] = ['id' => $key, 'name' => $oneUser];
            }
        }

// Means no result were found
        if (empty($resultUsers) && empty($resultProjects)) {
            $status = false;
        }

        header('Content-Type: application/json');

        echo json_encode(array(
            "status" => $status,
            "error"  => null,
            "data"   => $resultUsers
        ));
    }

    public function actionChangeavatar(){

        $response = [];
        $response['error'] = false;
        $test = Yii::getAlias('@static');
        if(!is_dir($test.'/avatars')) {
            BaseFileHelper::createDirectory($test . '/avatars/', $mode = 0777);
        }

        $model = new Avatar();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file->size > 2000000 || $model->file->size == 0){
                $response['error'] = true;
                $response['msg'] = 'Photo size should not exceed 2 megabytes';
            }
        }

        if ($model->file && $model->validate()) {
            $model->file->saveAs($test.'/avatars/' . time().$model->file->baseName . '.' . $model->file->extension);
            $user = Profile::find()->where(['user_id'=>Yii::$app->user->getId()])->one();
            $user->avatar = time().$model->file->baseName . '.' . $model->file->extension;
            $user->save();
            if(!$user->save()){
                var_dump($user->getErrors());
                die();
            }
        }
        die(json_encode($response));

    }


    public function actionChangepass(){

        $response['error'] = false;
        $pass = User::find()->where(['id'=>Yii::$app->user->getId()])->one();
        $mdpass =  PasswordHelper::hash($_POST['newpass']);

        if(PasswordHelper::validate($_POST['oldpass'], $pass->password_hash)){
            $pass->password_hash = $mdpass;
            $pass->save();
        }else{
            $response['error'] = true;
        }

        return json_encode($response);

    }

    public function actionUpdstatus(){

        $model = Profile::find()->where(['user_id' => Yii::$app->user->getId()])->one();
        $model->status = $_POST['status'];
        $model->save();
        die(json_encode($_POST));
    }
    public function actionUpdrate(){

        $model = Profile::find()->where(['user_id' => Yii::$app->user->getId()])->one();
        $model->rate = $_POST['rate'];
        $model->save();
        die(json_encode($_POST));
    }

    public function actionGetimage(){
        $user = Profile::find()->where(['user_id' => Yii::$app->user->getId()])->one();
        $response['image'] = $user->avatar;
        die(json_encode($response));
    }

    public function actionSendmailfrommainpage(){
        include('/subscribe.php');
    }

    public function actionShow(){
        $model = Profile::find()->where(['user_id' => Yii::$app->user->getId()])->one();
        if($_POST['value'] == 'true'){
            $model->$_POST['name'] = 1;
        }else{
            $model->$_POST['name'] = 0;
        }
        $model->save();
        die(json_encode($_POST));
    }

    public function actionSupportform(){

        $msg = '';

        $msg .= '
        <p>First Name: '.$_POST["first_name"].'</p>
        <p>Last Name: '.$_POST["last_name"].'</p>
        <p>Email: '.$_POST["email"].'</p>
        <p>Phone: '.$_POST["phone"].'</p>
        <p>Description: '.$_POST["desc"].'</p>
        ';

        $response = [];
        Yii::$app->mailer->compose()
            ->setFrom(['support@bigsbusiness.com' => 'Bigsbusiness'])
            ->setTo('countent@bsb.com')
            ->setSubject(Yii::t('mail', $_POST['theme']))
            ->setHtmlBody($msg)
            ->send();
        $response['error'] = false;
        die(json_encode($response));
    }
    public function actionDelegatebyemail() {
        $response = [];
        Yii::$app->mailer->compose()
            ->setFrom(['support@bigsbusiness.com' => 'Bigsbusiness'])
            ->setTo($_POST['email'])
            ->setSubject('Delegate task from Big S Business')
            ->setHtmlBody($_POST['offer'].'<br><a href="'.$_SERVER['SERVER_NAME'].'/departments/business">Begin use Big S Business</a>')
            ->send();
        $response['error'] = false;
        die(json_encode($response));
    }

    public function actionSetDepartmentSession(){
        //Yii::$app->session['current_department'] = $_POST['dep'];
        $service_data = new ServiceData(null, null, $_POST['dep']);
        $response['html'] = $service_data->render();
        return json_encode($response);
    }

    public function actionAddMultiSpecialization(){
        $serv = new ServiceData(null, null, $_POST['dep']);
        $response['html'] = $serv->addSpecialization($_POST);
        return json_encode($response);
    }

    public function actionAddMultiTask(){
        $task_data = new ServiceData(null, null, $_POST['dep']);
        $response['html'] = $task_data->addTask($_POST);
        return json_encode($response);
    }

    public function actionUpdateSpecialization(){
        if($_POST['type'] == 'add'){
            $us = new UserSpecialization();
            $us->user_id = Yii::$app->user->id;
        }else{
            $us = UserSpecialization::find()->where(['id' => $_POST['tu_id']])->one();
        }
        if($us){
            $us->specialization_id = $_POST['spec_id'];
            $existing = UserSpecialization::find()->where(['user_id' => Yii::$app->user->id, 'specialization_id' => $_POST['spec_id']])->one();
            if(!$existing) {
                if (!$us->save()) {
                    var_dump($us->getErrors());
                }
            }
        }
        $service_data = new ServiceData(null, null, $_POST['dep']);
        $response['html'] = $service_data->render();
        die(json_encode($response));
    }

    public function actionChangeDoDepartment(){
        $model = UserDo::find()->where(['department_id' => $_POST['dep'], 'user_id' => Yii::$app->user->id])->one();
        if($model){
            $model->status_do = $_POST['check'];
        }else{
            $model = new UserDo();
            $model->status_do = $_POST['check'];
            $model->user_id = Yii::$app->user->id;
            $model->department_id = $_POST['dep'];
        }
        $model->save();
        return json_encode($_POST);
    }

    public function actionChangeSellDepartment(){
        $model = UserDo::find()->where(['department_id' => $_POST['dep'], 'user_id' => Yii::$app->user->id])->one();
        if($model){
            if($_POST['check'] == 0){
                $model->status_show = 0;
            }
            $model->status_sell = $_POST['check'];
        }else{
            $model = new UserDo();
            if($_POST['check'] == 0){
                $model->status_show = 0;
            }
            $model->status_sell = $_POST['check'];
            $model->user_id = Yii::$app->user->id;
            $model->department_id = $_POST['dep'];
        }
        $model->save();
        return json_encode($_POST);
    }

    public function actionChangeShowDepartment(){

        $model = UserDo::find()->where(['department_id' => $_POST['dep'], 'user_id' => Yii::$app->user->id])->one();
        if($model){
            if($model->status_sell == 0){
                $model->status_show = 0;
            }else {
                $model->status_show = $_POST['show'];
            }
        }else{
            $model = new UserDo();
            $model->status_show = 0;
            $model->user_id = Yii::$app->user->id;
            $model->department_id = $_POST['dep'];
        }
        $model->save();
        return json_encode($_POST);
    }

    public function actionPrivacySettings(){
        $model = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        if($model){
            if($_POST['value'] == 'true'){
                $val = 1;
            }else{
                $val = 2;
            }
            $model->$_POST['field'] = $val;
            $model->save();
            //$model->save();
        }
    }

    public function actionDelSpecialization(){
        $response['error'] = false;
        if($_POST){
            $spec = UserSpecialization::find()->where(['id' => $_POST['id']])->one();
            if($spec){
                $spec->delete();
            }else{
                $response['error'] = true;
            }
        }else{
            $response['error'] = true;
        }
        return(json_encode($response));
    }

}