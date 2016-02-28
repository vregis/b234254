<?php

namespace modules\departments\site\controllers;

use DateTime;
use modules\core\site\base\Controller;
use modules\departments\models\Goal;
use modules\departments\tool\task_custom\TaskBenefit;
use modules\departments\tool\task_custom\TaskCustom;
use modules\departments\tool\task_custom\TaskIdea;
use modules\departments\tool\task_custom\TaskIdeaMilestone;
use modules\departments\tool\task_custom\TaskPersonGoal;
use modules\departments\tool\task_custom\TaskRoadmap;
use modules\departments\tool\task_custom\TaskShare;
use modules\departments\tool\TaskComponent;
use modules\tasks\models\DelegateTask;
use modules\tasks\models\TaskLink;
use modules\tasks\models\TaskNote;
use modules\tasks\models\TaskUser;
use modules\tasks\models\TaskUserLog;
use modules\tasks\models\TaskUserMessage;
use modules\tasks\models\TaskVideoYoutube;
use modules\tasks\site\controllers\NoteController;
use modules\user\models\Country;
use modules\user\models\Skilllist;
use modules\user\models\User;
use modules\user\models\UserTaskHelpful;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\filters\AccessControl;
use modules\departments\models\Department;
use modules\tasks\models\Task;
use modules\departments\models\Specialization;
use modules\milestones\models\Milestone;
use modules\tasks\models\UserTool;
use modules\user\models\Profile;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends Controller
{
    public $layout = "@modules/core/site/views/layouts/main";
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
                            'person-goal-save',
                            'task',
                            'sortpriority',
                            'sortspec',
                            'staticbg',
                            'user-self',
                            'user-sort',
                            'sort',
                            'getpopupdata',
                            'getpopuptask',
                            'unsetsession',
                            'updategant',
                            'get-milestone-from-task-id',
                            'get-new-tasks-id',
                            'tool-ajax',
                            'get-new-task-number',
                            'get-new-logs',
                            'get-count-by-tool',
                            'get-count-by-business',
                            'team',
                            'team-steve',
                            'get-task'
                        ],
                        'roles' => ['@'],

                    ]
                ]
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'my-method') {
            Yii::$app->controller->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
    function dateTimeToMilliseconds(\DateTime $dateTime)
    {
        $secs = $dateTime->getTimestamp(); // Gets the seconds
        $millisecs = $secs*1000; // Converted to milliseconds
        $millisecs += $dateTime->format("u")/1000; // Microseconds converted to seconds
        return $millisecs;
    }
    function get_milestones($userTool) {
        $milestones = Milestone::find() // SELECT * FROM milestone m INNER JOIN task t WHERE t.milestone_id = m.id GROUP BY m.id
            ->orderBy('is_pay')
            ->where(['is_hidden' => 0])
            ->all();
        array_unshift($milestones, Milestone::getAllMilestone());
        $departments = Department::find()->all();
        $avatar = Profile::find()->where(['user_id' => $userTool->user_id])->one();

        return $this->renderPartial('blocks/milestone', [
            'milestones' =>$milestones,
            'departments' => $departments,
            'avatar' => $avatar,
            'userTool' => $userTool
        ]);
    }

    public function actionIndex($task_id = 0) {
        $userTool = UserTool::getCurrentUserTool();
        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        if($user->user_type == User::TYPE_EMPLOYER) {
            if (!$userTool) {
                $userTool = UserTool::createUserTool();
            }
            if ($userTool->user_id == Yii::$app->user->id) {
                if ($user->user_status == User::STATUS_CREATION) {
                    $user->user_status = User::STATUS_ROADMAP_PASSED;
                    $user->save(false);
                    $task_id = Task::$task_roadmap_personal_id;
                } else {
                    if ($user->user_status == User::STATUS_ROADMAP_PASSED) {
                        $task_id = Task::$task_bussiness_role_id;
                    } else {
                        if ($user->user_status ==  User::STATUS_TEST_PASSED) {
                            $task_id = Task::$task_comfort_place_id;
                        }
                    }
                }
            }
        }
        else {
            if (!$userTool) {
                $userTool = UserTool::createUserTool();
            }
            if ($userTool->user_id == Yii::$app->user->id) {
                if ($user->user_status == User::STATUS_CREATION) {
                    $user->user_status = User::STATUS_ROADMAP_PASSED;
                    $user->save(false);
                    $task_id = Task::$task_steve_roadmap_personal_id;
                } else {
                    if ($user->user_status == User::STATUS_ROADMAP_PASSED) {
                        $task_id = Task::$task_steve_bussiness_role_id;
                    } else {
                        if ($user->user_status ==  User::STATUS_TEST_PASSED) {
                            $task_id = Task::$task_steve_comfort_place_id;
                        }
                    }
                }
            }
        }
        //var_dump($user);
        if($task_id == 0) {
            if ($userTool->status == UserTool::STATUS_CREATION) {
                $task_id = Task::$task_idea_id;
            } else {
                if ($userTool->status == UserTool::STATUS_IDEA_FILLED) {
                    $task_id = Task::$task_idea_benefits_id;
                } else {
                    if ($userTool->status == UserTool::STATUS_IDEA_BENEFITS_FILLED) {
                        $task_id = Task::$task_idea_share_id;
                    }
                }
            }
        }

        if($task_id != 0) {
            return $this->redirect(['/departments/task', 'id' => $task_id, 'first' => 1]);
        }
        return $this->render('index', [
            'ml' => $this->get_milestones($userTool),
            'task_open_id' => $task_id
        ]);
    }

    public function actionStaticbg($id = 1, $milestone_id = 1){
        $department = Department::find()->where(['id' => $id])->one();

        $tasks = Task::find()->where(['department_id' => $id]);
        if($milestone_id != -1) {
            $tasks->andWhere(['milestone_id' => $milestone_id]);
        }
        $tasks = $tasks->all();
        $specializations = [];
        $specializationsAll = Specialization::find()->where(['department_id'=>$id])->all();
        foreach($specializationsAll as $specialization) {
            $tasks_qeury = Task::find()->where(['department_id' => $id,'specialization_id' => $specialization->id]);
            if($milestone_id != -1) {
                $tasks_qeury->andWhere(['milestone_id' => $milestone_id]);
            }
            if($tasks_qeury->count() > 0) {
                $specializations[] = $specialization;
            }
        }
        $milestones = Milestone::find()->all();
        $html =  $this->renderPartial('@modules/departments/site/views/default/index_static', [
            'department' => $department,
            'spec'=>$specializations,
            'tasks' => $tasks,
            'milestones' => $milestones,
            'milestone_id' => $milestone_id
        ], true);
        return $html;
    }

    public function actionUserSelf(){
        $current_userTool = UserTool::getCurrentUserTool(true);
        return $this->redirect(['/departments/business/select-tool','id' => $current_userTool->id]);
    }
    public function actionUserSort($id){
        Yii::$app->session['tool_id'] = $id;
        return $this->redirect(['/departments']);
    }

    public function sort($milestone = null, $is_filters = true, $userTool = null, $avatar = null) {

        if($milestone == null){
            if($_POST['milestone_id'] != 'All') {
                $milestone = Milestone::find()->where(['id' => $_POST['milestone_id']])->one();
            }
            else {
                $milestone = Milestone::getAllMilestone();
            }
        }

        $tasks_request = Task::find()->select(
            'task.*, specialization.name as task, task_user.start as start, task_user.end as end, task_user.status as status, task_user.id task_user, milestone.is_pay is_pay'
        )
            ->join('JOIN', 'milestone', 'milestone.id = task.milestone_id')
            ->join('LEFT OUTER JOIN', 'specialization', 'specialization.id = task.specialization_id')
            ->join(
                'LEFT OUTER JOIN',
                'task_user',
                'task_user.task_id = task.id and task_user.user_tool_id = ' . $userTool->id
            )
            ->join('LEFT OUTER JOIN', 'delegate_task', 'delegate_task.task_user_id = task_user.id');

        $tasks_request->orderBy('sort');

        if($milestone->id != -1) {
            $tasks_request->where(
                [
                    'task.milestone_id' => $milestone->id
                ]
            );
        }
        else {
            $tasks_request
                ->join('JOIN', 'department', 'department.id = task.department_id');
            $tasks_request->where(
                [
                    'task.is_roadmap' => 0,
                    'milestone.is_hidden' => 0,
                    'department.is_additional' => 0,
                ]
            );
            $tasks_request->orderBy('task.milestone_id');
        }

        $is_my = $userTool->user_id == Yii::$app->user->id;



        if (!$is_my) {
            $tasks_request->andWhere(
                [
                    'task_user.user_tool_id' => $userTool->id
                ]
            );
            $tasks_request->andWhere(
                [
                    'delegate_task.delegate_user_id' => Yii::$app->user->id
                ]
            );
            $tasks_request->andWhere(['!=', 'delegate_task.status', DelegateTask::$status_cancel]);
        }

        //var_dump(count($tasks_request->all()));


        $tasks = [];
        $delegate_tasks = [];
        $specializations = [];
        if($milestone->is_pay == 0) {
            $tasks = $tasks_request->all();
            $specialization_ids_key = [];
            foreach ($tasks as $task) {
                if ($task->specialization_id > 0) {
                    $specialization_ids_key[$task->specialization_id] = '';
                }
            }
            $specialization_ids = [];
            foreach ($specialization_ids_key as $key => $value) {
                array_push($specialization_ids, $key);
            }
            $specializations_all = Specialization::find()
                ->where(['id' => $specialization_ids])
                ->all();
            $specializations = [];
            foreach ($specializations_all as $spec) {
                foreach ($tasks as $task) {
                    if ($task->specialization_id == $spec->id) {
                        $specializations[$task->department_id][$spec->id] = $spec;
                    }
                }
            }

            if($is_filters) {
                $tasks_temp = $tasks;
                foreach ($tasks_temp as $key => $task_temp) {
                    if (isset($_POST['spec'])) {
                        $is_find = false;
                        foreach ($_POST['spec'] as $spec) {
                            if (!$task_temp->specialization_id || $task_temp->specialization_id == $spec) {
                                $is_find = true;
                            }
                        }
                        if(!$is_find) {
                            unset($tasks_temp[$key]);
                            continue;
                        }
                    }
                    if (isset($_POST['status'])) {
                        if ($_POST['status'] != 'all' && $_POST['status'] != null) {
                            if ($task_temp->status != ($_POST['status'] ? $_POST['status'] : 0)) {
                                unset($tasks_temp[$key]);
                                continue;
                            }
                        }
                    }
                }
                $tasks = $tasks_temp;
            }
            $task_users = [];
            foreach ($tasks as $task) {
                if ($task->task_user) {
                    array_push($task_users, $task->task_user);
                }
            }

            if ($is_my) {
                $delegate_tasks = User::find()->select(
                    'delegate_task.*, user.id id, user_profile.avatar ava, task_user.id task_user'
                )
                    ->join('JOIN', 'delegate_task', 'delegate_task.delegate_user_id = user.id')
                    ->join('JOIN', 'user_profile', 'user_profile.user_id = user.id')
                    ->join('JOIN', 'task_user', 'task_user.id = delegate_task.task_user_id')
                    ->where(
                        [
                            'task_user.id' => $task_users,
                        ]
                    )
                    ->andWhere(['!=', 'delegate_task.status', DelegateTask::$status_inactive])
                    ->andWhere(['!=', 'delegate_task.status', DelegateTask::$status_offer])
                    ->andWhere(['!=', 'delegate_task.status', DelegateTask::$status_cancel])
                    ->all();

                if ($is_filters) {
                    $tasks_temp = $tasks;
                    foreach ($tasks_temp as $key => $task_temp) {
                        if (isset($_POST['users'])) {
                            $is_find = false;
                            foreach ($_POST['users'] as $user) {
                                if ($user == 0) {
                                    $is_find = true;
                                } else {
                                    foreach ($delegate_tasks as $d_task) {
                                        if ($d_task->task_user == $task_temp->task_user && $d_task->id == $user) {
                                            $is_find = true;
                                            break;
                                        }
                                    }
                                }
                            }
                            if (!$is_find) {
                                unset($tasks_temp[$key]);
                                continue;
                            }
                        }
                    }
                    $tasks = $tasks_temp;
                }
            }

            $tables['table'] = $this->renderPartial('blocks/table', [
                'tasks' => $tasks,
                'delegate_tasks' => $delegate_tasks,
                'userTool' => $userTool
            ], true);
            $tables['gant'] = $this->renderPartial('blocks/gantt', [
                'tasks' => $tasks,
                'id' => $milestone->id,
                'delegate_tasks' => $delegate_tasks,
                'userTool' => $userTool
            ], true);

        }else {
            $tasks_count = $tasks_request->count();
            for($i=0; $i< $tasks_count; $i++) {
                $tasks[] = new Task();
            }
            $tables['table'] = '';
            $tables['gant'] = '';
        }

        $tables['tasks'] = $tasks;
        $tables['delegate_tasks'] = $delegate_tasks;
        $tables['specializations'] = $specializations;
        $tables['milestones_users'] = $this->renderPartial('blocks/milestones-users', [
            'delegate_tasks' => $delegate_tasks,
            'avatar' => $avatar
        ]);
        return $tables;
    }

    public function actionSort(){
        $userTool = UserTool::getCurrentUserTool();
        $avatar = Profile::find()->where(['user_id' => $userTool->user_id])->one();
        $tables = $this->sort(null,true,$userTool,$avatar);
        $response['id'] = $_POST['milestone_id'];
        $response['table'] = $tables['table'];
        $response['gant'] = $tables['gant'];
        $response['milestones_users'] = $tables['milestones_users'];
        die(json_encode($response));
    }

    private function setDataInSession($post){
        if(isset($post['dep'])){
            Yii::$app->session['departments'] = $post['dep'];
        }
        if(isset($post['spec'])){
            Yii::$app->session['spec'] = $post['spec'];
        }
        if(isset($post['status'])){
            Yii::$app->session['status'] = $post['status'];
        }
        if(isset($post['milestone_id'])){
            Yii::$app->session['milestone_id'] = $post['milestone_id'];
        }

    }

    public function actionGetpopupdata(){
        $response = [];
        $task = Task::find()->select('task_id, task.name, task.specialization_id, task_user.status as status, specialization.name as task')
            ->join('JOIN', 'specialization', 'task.specialization_id = specialization.id')
            ->join('JOIN', 'task_user', 'task_user.task_id = task.id')
            ->where(['task_id' => $_POST['id']])->one();
        if(isset($task->status)) {
            if ($task->status == 0) {
                $status = 'New';
            } elseif ($task->status == 1) {
                $status = 'Active';
            } else {
                $status = 'Complete';
            }
        }else{
            $status = "New";
        }
        /*$response['name'] = $task->name;
        $response['spec'] = $task->task;
        $response['status'] = $status;*/
        die(json_encode($response));
    }

    public function actionUnsetsession(){
        unset(Yii::$app->session['departments']);
        unset(Yii::$app->session['spec']);
        unset(Yii::$app->session['status']);
        unset(Yii::$app->session['milestone_id']);
    }
    public function getTaskHtml($tool,$task,$task_user,$is_my,$is_custom){
        if($task_user) {
            if ($task_user->status == TaskUser::$status_new) {
                $task_user->status = TaskUser::$status_active;
                TaskUserLog::sendLog($task_user->id, TaskUserLog::$log_start);
                $task_user->save(false);
            }
        }

        $hide = 0;

        $user_task_helpful = UserTaskHelpful::getUserTaskHelpful($task->id);

        $files['archive'] = $this->getFiles($task->id, 'archive');
        $files['audio'] = $this->getFiles($task->id, 'audio');
        $files['document'] = $this->getFiles($task->id, 'document');
        $files['photo'] = $this->getFiles($task->id, 'photo');

        $task_videos = [];
        $task_videosYoutube = TaskVideoYoutube::find()->where(['task_id' => $task->id])->all();
        foreach($task_videosYoutube as $task_videoYoutube) {
            $link = $task_videoYoutube->name;
            if(preg_match('/.*watch\?v=(.*)$/',$link,$matches)) {
                $task_videos[] = $matches[1];
            }
        }
        $task_links = TaskLink::find()->where(['task_id' => $task->id])->all();
        $task_notes = TaskNote::find()->where(['task_id' => $task->id])->all();

        $delegate_task = null;
        if($task_user) {
            $delegate_task = DelegateTask::getCurrentDelegateTask($task_user->id, $is_my);
        }

        $noteController = new NoteController('note', Yii::$app->getModule('tasks'));

        $taskUserNotes = null;
        if($task_user) {
            $taskUserNotes = $noteController->getNotesRender($task_user->id);
        }

        $delegate_tasks = [];
        $counter_offers = [];
        $delegate_user = null;

        if($is_my) {
            if($task_user) {
                $delegate_tasks = DelegateTask::getCurrentDelegateTasks($task_user->id, $is_my);
                $counter_offers = DelegateTask::getCurrentCounterOffers($task_user->id);
            }
        }
        else {
            $delegate_user = User::find()->select('*,user_profile.first_name fname,user_profile.last_name lname,user_profile.avatar ava')
                ->join('JOIN', 'user_profile', 'user_profile.user_id = user.id')
                /*->where(['user.id' => $tool->user_id])*/
                ->one();
        }

        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        $countrylist = Country::findBySql('SELECT * FROM geo_country gc ORDER BY id=1 DESC, title_en ASC')->all();
        $skill_list = Skilllist::find()->all();

        $task_component = new TaskComponent();
        $taskUserLogs = [];
        $html_cancel_delegate_users = '';
        if($task_user) {
            $taskUserLogs = $task_component->get_task_user_logs($task_user->id);
            $html_cancel_delegate_users = $task_component->get_cancel_delegate_users($task_user->id);
        }
        if($html_cancel_delegate_users == 'none') {
            $html_cancel_delegate_users = '';
            $hide = 1;
        }

        $custom = null;
        $task_view = 'blocks/task';
        if($is_custom) {
            $task_view = 'blocks/task_custom';
            if($task->id == Task::$task_roadmap_personal_id) $customObject = new TaskCustom('simply_start',$task);
            else if($task->id == Task::$task_bussiness_role_id) $customObject = new TaskCustom('bussiness_role',$task);
            else if($task->id == Task::$task_comfort_place_id) $customObject = new TaskCustom('comfort_place',$task);
            else if($task->id == Task::$task_steve_roadmap_personal_id) $customObject = new TaskCustom('simply_start_steve',$task);
            else if($task->id == Task::$task_steve_bussiness_role_id) $customObject = new TaskCustom('bussiness_role_steve',$task);
            else if($task->id == Task::$task_steve_comfort_place_id) $customObject = new TaskCustom('comfort_place_steve',$task);
            else if($task->id == Task::$task_person_goal_id) $customObject = new TaskPersonGoal($task);
            else if($task->id == Task::$task_idea_id) $customObject = new TaskIdea('idea',$task,$task_videos,$task_notes,$task_links,$files);
            else if($task->id == Task::$task_idea_benefits_id) $customObject = new TaskBenefit($tool->id,'idea_benefits',$task,$task_videos,$task_notes,$task_links,$files);
            else if($task->id == Task::$task_idea_share_id) $customObject = new TaskShare($tool->id,'idea_share',$task,$task_videos,$task_notes,$task_links,$files);
            else if($task->is_roadmap) $customObject = new TaskRoadmap($task);
            $custom = $customObject->render();

            if($task->id == Task::$task_idea_share_id && $tool->status == UserTool::STATUS_IDEA_BENEFITS_FILLED) {
                $tool->status = UserTool::STATUS_IDEA_SHARED;
                $tool->save(false);
            }
        }
        return $this->renderPartial($task_view, [
            'task' => $task,
            'task_user' => $task_user,
            'user_task_helpful' => $user_task_helpful,
            'task_videos' =>$task_videos,
            'task_notes' => $task_notes,
            'task_links' => $task_links,
            'files'=>$files,
            'taskUserNotes' => $taskUserNotes,
            'taskUserLogs' => $taskUserLogs,
            'delegate_tasks' => $delegate_tasks,
            'delegate_task' => $delegate_task,
            'delegate_user' => $delegate_user,
            'counter_offers' => $counter_offers,
            'profile' => $profile,
            'countrylist' => $countrylist,
            'skill_list' => $skill_list,
            'html_cancel_delegate_users' => $html_cancel_delegate_users,
            'custom' => $custom,
            'is_my' => $is_my,
            'hide' => $hide
        ]);
    }

    public function getTaskHtmlFromPage($tool,$task,$task_user,$is_my,$is_custom){
        if($task_user) {
            if ($task_user->status == TaskUser::$status_new) {
                $task_user->status = TaskUser::$status_active;
                TaskUserLog::sendLog($task_user->id, TaskUserLog::$log_start);
                $task_user->save(false);
            }
        }

        $user_task_helpful = UserTaskHelpful::getUserTaskHelpful($task->id);

        $files['archive'] = $this->getFiles($task->id, 'archive');
        $files['audio'] = $this->getFiles($task->id, 'audio');
        $files['document'] = $this->getFiles($task->id, 'document');
        $files['photo'] = $this->getFiles($task->id, 'photo');

        $task_videos = [];
        $task_videosYoutube = TaskVideoYoutube::find()->where(['task_id' => $task->id])->all();
        foreach($task_videosYoutube as $task_videoYoutube) {
            $link = $task_videoYoutube->name;
            if(preg_match('/.*watch\?v=(.*)$/',$link,$matches)) {
                $task_videos[] = $matches[1];
            }
        }
        $task_links = TaskLink::find()->where(['task_id' => $task->id])->all();
        $task_notes = TaskNote::find()->where(['task_id' => $task->id])->all();

        $delegate_task = null;
        if($task_user) {
            $delegate_task = DelegateTask::getCurrentDelegateTask($task_user->id, $is_my);
        }

        $noteController = new NoteController('note', Yii::$app->getModule('tasks'));

        $taskUserNotes = null;
        if($task_user) {
            $taskUserNotes = $noteController->getNotesRender($task_user->id);
        }

        $delegate_tasks = [];
        $counter_offers = [];
        $delegate_user = null;

        if($is_my) {
            if($task_user) {
                $delegate_tasks = DelegateTask::getCurrentDelegateTasks($task_user->id, $is_my);
                $counter_offers = DelegateTask::getCurrentCounterOffers($task_user->id);
            }
        }
        else {
            $delegate_user = User::find()->select('*,user_profile.first_name fname,user_profile.last_name lname,user_profile.avatar ava')
                ->join('JOIN', 'user_profile', 'user_profile.user_id = user.id')
                /*->where(['user.id' => $tool->user_id])*/
                ->one();
        }

        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        $countrylist = Country::findBySql('SELECT * FROM geo_country gc ORDER BY id=1 DESC, title_en ASC')->all();
        $skill_list = Skilllist::find()->all();

        $task_component = new TaskComponent();
        $taskUserLogs = [];
        $html_cancel_delegate_users = '';
        if($task_user) {
            $taskUserLogs = $task_component->get_task_user_logs($task_user->id);
            $html_cancel_delegate_users = $task_component->get_cancel_delegate_users($task_user->id);
        }
        if($html_cancel_delegate_users == 'none') {
            $html_cancel_delegate_users = '';
        }

        $custom = null;
        $task_view = 'blocks/task_window';
        if($is_custom) {
            $task_view = 'blocks/task_custom';
            if($task->id == Task::$task_roadmap_personal_id) $customObject = new TaskCustom('simply_start',$task);
            else if($task->id == Task::$task_bussiness_role_id) $customObject = new TaskCustom('bussiness_role',$task);
            else if($task->id == Task::$task_comfort_place_id) $customObject = new TaskCustom('comfort_place',$task);
            else if($task->id == Task::$task_person_goal_id) $customObject = new TaskPersonGoal($task);
            else if($task->id == Task::$task_idea_id) $customObject = new TaskIdea('idea',$task,$task_videos,$task_notes,$task_links,$files);
            else if($task->id == Task::$task_idea_benefits_id) $customObject = new TaskBenefit($tool->id,'idea_benefits',$task,$task_videos,$task_notes,$task_links,$files);
            else if($task->id == Task::$task_idea_share_id) $customObject = new TaskShare($tool->id,'idea_share',$task,$task_videos,$task_notes,$task_links,$files);
            else if($task->is_roadmap) $customObject = new TaskRoadmap($task);
            $custom = $customObject->render();

            if($task->id == Task::$task_idea_share_id && $tool->status == UserTool::STATUS_IDEA_BENEFITS_FILLED) {
                $tool->status = UserTool::STATUS_IDEA_SHARED;
                $tool->save(false);
            }
        }
        return $this->render($task_view, [
            'task' => $task,
            'task_user' => $task_user,
            'user_task_helpful' => $user_task_helpful,
            'task_videos' =>$task_videos,
            'task_notes' => $task_notes,
            'task_links' => $task_links,
            'files'=>$files,
            'taskUserNotes' => $taskUserNotes,
            'taskUserLogs' => $taskUserLogs,
            'delegate_tasks' => $delegate_tasks,
            'delegate_task' => $delegate_task,
            'delegate_user' => $delegate_user,
            'counter_offers' => $counter_offers,
            'profile' => $profile,
            'countrylist' => $countrylist,
            'skill_list' => $skill_list,
            'html_cancel_delegate_users' => $html_cancel_delegate_users,
            'custom' => $custom,
            'is_my' => $is_my
        ]);
    }

    public function actionGetpopuptask(){
        $response = [];

        $is_custom = filter_var($_POST['is_custom'], FILTER_VALIDATE_BOOLEAN);
        $task = Task::find()
            ->select('task.*, specialization.name as spec, milestone.is_pay is_pay')
            ->join('JOIN', 'milestone', 'milestone.id = task.milestone_id')
            ->join('LEFT OUTER JOIN', 'specialization', 'task.specialization_id = specialization.id')
            ->where(['task.id' => $_POST['id']])
            ->one();

        if(Yii::$app->user->can('admin') || $task->is_pay == 0) {
            $tool = UserTool::getCurrentUserTool();
            $task_user = TaskUser::getTaskUser($tool->id, $task->id, $task);
            $is_my = $tool->user_id == Yii::$app->user->id;

            $response['html'] = $this->getTaskHtml($tool,$task,$task_user,$is_my,$is_custom);
            $response['task_user_id'] = $task_user->id;
            $response['is_my'] = $is_my;
            $response['error'] = false;
        }else {
            $response['error'] = true;
        }
        return json_encode($response);
    }


    public function actionGetTask($id){
        $response = [];

        //$is_custom = filter_var($_POST['is_custom'], FILTER_VALIDATE_BOOLEAN);
        $task = Task::find()
            ->select('task.*, specialization.name as spec, milestone.is_pay is_pay')
            ->join('JOIN', 'milestone', 'milestone.id = task.milestone_id')
            ->join('LEFT OUTER JOIN', 'specialization', 'task.specialization_id = specialization.id')
            ->where(['task.id' => $id])
            ->one();

        if(Yii::$app->user->can('admin') || $task->is_pay == 0) {
            $tool = UserTool::getCurrentUserTool();
            $task_user = TaskUser::getTaskUser($tool->id, $task->id, $task);
            $is_my = $tool->user_id == Yii::$app->user->id;

            $response['html'] = $this->getTaskHtml($tool,$task,$task_user,$is_my, false);
            $response['task_user_id'] = $task_user->id;
            $response['is_my'] = $is_my;
            $response['error'] = false;
        }else {
            $response['error'] = true;
        }
        $tool = UserTool::getCurrentUserTool();
        $task_user = TaskUser::getTaskUser($tool->id, $task->id, $task);
        $is_my = $tool->user_id == Yii::$app->user->id;
        return $this->getTaskHtmlFromPage($tool,$task,$task_user,$is_my, false);
    }



    public function actionTask($id){
        $is_custom = true;
        $task = Task::find()
            ->select('task.*, specialization.name as spec')
            ->join('LEFT OUTER JOIN', 'specialization', 'task.specialization_id = specialization.id')
            ->where(['task.id' => $id])
            ->one();

        $tool = UserTool::getCurrentUserTool();
        if(isset($tool->user_id)) {  // ASC TO VASYA
            $is_my = $tool->user_id == Yii::$app->user->id;
        }else{
            $is_my = false;
        }

        return $this->render('task_page', [
            'task' => $this->getTaskHtml($tool,$task,null,$is_my,$is_custom)
        ]);
    }

    function getFiles($id, $category) {
        $uploaddir = Yii::getAlias('@static').'/tasks/'.$id.'/'.$category.'/';
        if (!is_dir($uploaddir)) mkdir($uploaddir, 0777, true);
        $result  = array();
        $files = scandir($uploaddir);
        if ( false!==$files ) {
            foreach ( $files as $file ) {
                if ( '.'!=$file && '..'!=$file) {
                    $obj['name'] = $file;
                    $obj['path'] = Yii::$app->params['staticDomain'].'tasks/'.$id.'/'.$category.'/'.$file;
                    $obj['size'] = filesize($uploaddir.$file);
                    $result[] = $obj;
                }
            }
        }
        return $result;
    }

    public function actionToolAjax(){
        $tool = new TaskComponent();
        return $tool->ajax();
    }

    public function actionUpdategant(){

        $task = Task::find()->where(['id' => $_POST['id']])->one();
        $userTool = UserTool::getCurrentUserTool();
        $avatar = Profile::find()->where(['user_id' => Yii::$app->user->getId()])->one();
        $milestone = Milestone::find()->where(['id' => $task->milestone_id])->one();
        $tables = $this->sort($milestone,true,$userTool,$avatar);
        return json_encode($tables);
    }

    public function actionGetMilestoneFromTaskId(){
        $task = Task::find()->where(['id' => $_POST['id']])->one();
        $response['id'] = $task->milestone_id;
        return(json_encode($response));
    }

    public function actionGetNewTaskNumber(){
        $tool = UserTool::getCurrentUserTool();
        $milestones = TaskUserMessage::find()
            ->select('*, delegate_task.*, task_user.*, task.*, task.id as ava')
            ->join('LEFT JOIN', 'delegate_task', 'delegate_task.id = task_user_message.delegate_task_id')
            ->join('LEFT JOIN', 'task_user', 'task_user.id = delegate_task.task_user_id')
            ->join('LEFT JOIN', 'task_user_log', 'task_user_log.task_user_id = delegate_task.task_user_id')
            ->join('LEFT OUTER JOIN', 'task', 'task_user.task_id = task.id')
            ->where(['!=', 'task_user_message.user_id', Yii::$app->user->id]);
        $milestones->orWhere(['task_user_log.is_read' => 0]);
        if($tool) {
            $milestones->andWhere([
                'delegate_task.delegate_user_id' => Yii::$app->user->id,
                'task_user_message.is_read' => 0,
                'task_user.user_tool_id' => $tool->id
            ])
                ->all();
        }else{
            $milestones->andWhere([
                'delegate_task.delegate_user_id' => Yii::$app->user->id,
                'task_user_message.is_read' => 0
            ])
                ->all();
        }
        $response['milestones'] = $milestones;
        if($tool) {
            if ($tool->user_id == Yii::$app->user->id) {
                $response['ismy'] = true;
            } else {
                $response['ismy'] = false;
            }
        }
        return (json_encode($response));
    }

    public function actionGetNewTasksId(){
        $milestones = TaskUserMessage::find()
            ->select('*, delegate_task.*, task_user.*, task.*, task_user.user_tool_id as tool_id')
            ->join('LEFT JOIN', 'delegate_task', 'delegate_task.id = task_user_message.delegate_task_id')
            ->join('LEFT JOIN', 'task_user', 'task_user.id = delegate_task.task_user_id')
            ->join('LEFT JOIN', 'task_user_log', 'task_user_log.task_user_id = delegate_task.task_user_id')
            ->join('LEFT OUTER JOIN', 'task', 'task_user.task_id = task.id')
            ->where(['!=', 'task_user_message.user_id', Yii::$app->user->id])
            ->orWhere(['task_user_log.is_read' => 0])
            ->andWhere([
                'delegate_task.delegate_user_id' => Yii::$app->user->id,
                'task_user_message.is_read' => 0,
            ])
            ->groupBy('task_user.user_tool_id, task.milestone_id')
            ->all();

    }

    public function actionGetNewLogs(){
        if(isset($_POST['id']) && !empty($_POST['id'])){
            $logs = TaskUserLog::find()
                ->where(['!=', 'user_id', Yii::$app->user->id])
                ->andWhere(['task_user_id' => $_POST['id']])
                ->andWhere(['is_read' => 0])
                ->all();
        }
        $response['number'] = count($logs);
        return json_encode($response);
    }

    public function actionGetCountByTool(){
        $milestones = TaskUserMessage::find()
            ->select('*, delegate_task.*, task_user.*, task.*, task_user.user_tool_id as tool_id')
            ->join('LEFT JOIN', 'delegate_task', 'delegate_task.id = task_user_message.delegate_task_id')
            ->join('LEFT JOIN', 'task_user', 'task_user.id = delegate_task.task_user_id')
            ->join('LEFT JOIN', 'task_user_log', 'task_user_log.task_user_id = delegate_task.task_user_id')
            ->join('LEFT OUTER JOIN', 'task', 'task_user.task_id = task.id')
            ->where(['!=', 'task_user_message.user_id', Yii::$app->user->id])
            ->orWhere(['task_user_log.is_read' => 0])
            ->andWhere([
                'delegate_task.delegate_user_id' => Yii::$app->user->id,
                'task_user_message.is_read' => 0,
            ])
            ->groupBy('task_user.user_tool_id, task.milestone_id')
            ->all();

        $response['milestones'] = $milestones;
        return json_encode($response);
    }

    public function actionGetCountByBusiness(){
        $tools = TaskUserMessage::find()
            ->select('*, delegate_task.*, task_user.*, task.*, task_user.user_tool_id as tool_id')
            ->join('LEFT JOIN', 'delegate_task', 'delegate_task.id = task_user_message.delegate_task_id')
            ->join('LEFT JOIN', 'task_user', 'task_user.id = delegate_task.task_user_id')
            ->join('LEFT JOIN', 'task_user_log', 'task_user_log.task_user_id = delegate_task.task_user_id')
            ->join('LEFT OUTER JOIN', 'task', 'task_user.task_id = task.id')
            ->where(['!=', 'task_user_message.user_id', Yii::$app->user->id])
            ->orWhere(['task_user_log.is_read' => 0])
            ->andWhere([
                'delegate_task.delegate_user_id' => Yii::$app->user->id,
                'task_user_message.is_read' => 0,
            ])
            ->groupBy('task_user.user_tool_id')
            ->all();

        $response['tools'] = count($tools);
        return json_encode($response);
    }

    public function actionTeam(){
        return $this->render('team');
    }

    public function actionTeamSteve(){
        return $this->render('team-steve');
    }
}