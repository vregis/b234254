<?php

namespace modules\departments\site\controllers;

use modules\core\site\base\Controller;
use modules\departments\models\BenefitLike;
use modules\departments\models\Department;
use modules\departments\models\IdeaLike;
use modules\departments\models\Specialization;
use modules\departments\models\UserDo;
use modules\departments\tool\TaskComponent;
use modules\tasks\models\DelegateTask;
use modules\tasks\models\Task;
use modules\tasks\models\TaskUser;
use modules\tasks\models\UserTool;
use modules\tasks\models\TaskUserLog;
use modules\departments\models\Benefit;
use modules\departments\models\Idea;
use modules\departments\models\Goal;
use modules\departments\models\Industry;
use modules\tasks\models\UserToolComment;
use modules\user\models\Country;
use modules\user\models\Profile;
use modules\user\models\Skilllist;
use modules\user\models\User;
use modules\user\models\UserSpecialization;
use Yii;
use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class BusinessController extends Controller
{
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
                            'user-task',
                            'user-request',
                            'request',
                            'reject',
                            'get-specials',
                            'get-specials-filter',
                            'create',
                            'delete',
                            'edit-idea',
                            'delete-idea',
                            'edit-goal',
                            'delete-goal',
                            'accept-tasks',
                            'accept',
                            'decline',
                            'select-tool',
                            'dashboard-editing',
                            'dashboard-save',
                            'shared-business'
                        ],
                        'roles' => ['@']
                    ],
                    [
                        'allow' => true,
                        'actions' => [
                            'dashboard',
                            'idea-like',
                            'benefit-like',
                        ],
                        'roles' => ['@','?']
                    ]
                ]
            ],
        ];
    }

    public function actionIndex()
    {
        $self_userTools = UserTool::find()->select('user_tool.*,idea.name name')
            ->join('LEFT OUTER JOIN', 'idea', 'idea.user_tool_id = user_tool.id')
            ->where(['user_id' => Yii::$app->user->id])->all();

        $delegated_businesses = $this->render_delegated_businesses();

        $profile = Profile::find()->where(['user_id' => Yii::$app->user->id])->one();
        $countrylist = Country::findBySql('SELECT * FROM geo_country gc ORDER BY id=1 DESC, title_en ASC')->all();
        $skill_list = Skilllist::find()->all();

        $post['country'] = $profile->country_id;
        $user_task = $this->render_user_task($post);

        $users_request = $this->get_user_request();
        $user_request = $this->render_user_request($users_request);

        $spec_pending = [];
        $i = 0;
        foreach($users_request as $ur){
            $spec_pending[$i] = $ur->spec_id;
            $i++;
        }

        $spec_pending = array_unique($spec_pending);

        $user_special_pending = $this->get_user_specials_pending($spec_pending);

        $user = User::find()->where(['id' => Yii::$app->user->id])->one();
        $user_specials = $this->get_user_specials();
        $departments = ArrayHelper::map($user_specials, 'dep_id', 'dname');


        $deps_filter = $this->render_deps_filter($post, $user_specials);
        $specials_filter = $this->render_specials_filter($post, $user_specials);

        $deps_filter_pending = $this->render_deps_filter_pending($post, $user_special_pending);
        $specials_filter_pending = $this->render_specials_filter($post, $user_specials);

        $users_special_request = $user_specials;
        foreach($users_special_request as $key => $user_special) {
            $is_find = false;
            foreach($users_request as $request) {
                if($request->spec_id == $user_special->specialization_id) {
                    $is_find = true;
                    break;
                }
            }
            if(!$is_find) {
                unset($users_special_request[$key]);
                continue;
            }
        }
        $deps_request_filter = $this->render_deps_filter($post, $users_special_request);
        $specials_request_filter = $this->render_specials_filter($post, $users_special_request);

        return $this->render('index',[
            'self_userTools' => $self_userTools,
            'delegated_businesses' => $delegated_businesses,
            'profile' => $profile,
            'countrylist' => $countrylist,
            'skill_list' => $skill_list,
            'departments' => $departments,
            'user_task' => $user_task,
            'user_request' => $user_request,
            'user' => $user,
            'user_specials' => $user_specials,
            'deps_filter' => $deps_filter,
            'deps_filter_pending' => $deps_filter_pending,
            'specials_filter' => $specials_filter,
            'specials_filter_pending' => $specials_filter_pending,
            'deps_request_filter' => $deps_request_filter,
            'specials_request_filter' => $specials_request_filter
        ]);
    }

    private function findUsersCondition(&$users, &$exclude_user_ids, $task, $where = null) {
        $users_find = User::find()->select(
            'user.*,user_profile.first_name fname,user_profile.last_name lname,user_profile.avatar ava,skill_list.name level,user_profile.rate rate_h,geo_country.title_en country,user_profile.city_title city, delegate_task.delegate_user_id delegate_user_id, task_user.is_delegate is_delegate, user_tool.id tool, task_user.time task_user_time, task_user.price task_user_price, user_profile.user_id uid'
        )
            ->join('JOIN','user_profile', 'user_profile.user_id = user.id')
            ->join('JOIN','user_tool', 'user_tool.user_id = user.id')
            ->join('LEFT OUTER JOIN','task_user', 'task_user.user_tool_id = user_tool.id and task_user.task_id = '.$task->id)
            ->join('LEFT OUTER JOIN','delegate_task', 'delegate_task.task_user_id = task_user.id and delegate_task.delegate_user_id = '.Yii::$app->user->id)
            ->join('LEFT OUTER JOIN','user_specialization', 'user_specialization.user_id = user.id')
            ->join('LEFT OUTER JOIN','skill_list', 'skill_list.id = user_specialization.exp_type')
            ->join('LEFT OUTER JOIN','geo_country', 'geo_country.id = user_profile.country_id')
            ->join('LEFT OUTER JOIN','user_skills', 'user_skills.user_id = user_profile.user_id');
        foreach($exclude_user_ids as $exclude_user_id)
            $users_find->where(['not in','user.id',$exclude_user_ids]);
        if($where) {
            $users_find->andWhere($where);
        }

        $users_find->limit(25 - count($users));
        $users_find = $users_find->all();

        foreach($users_find as $key => $user) {
            $user->task_id = $task->id;
            $user->task_name = $task->name;
            $user->task_special = $task->spec_name;
            $user->task_desc = $task->description;
            $user->dname = $task->dname;
            if($user->task_user_time && $user->task_user_price) {
                $user->task_rate = intval($user->task_user_price/$user->task_user_time);
            }
            if($user->delegate_user_id && $user->delegate_user_id == Yii::$app->user->id ||
                $user->is_delegate == 1
            ) {
                unset($users_find[$key]);
                continue;
            }
        }
        $users = array_merge($users,$users_find);
        foreach($users_find as $user) {
            array_push($exclude_user_ids, $user->id);
        }
    }
    private function findUsersByTask(&$users, &$exclude_user_ids, $task, $post) {
        if (isset($post['rate_start']) && $post['rate_start'] != '' && isset($post['rate_end']) && $post['rate_end'] != '') {
            $this->findUsersCondition($users, $exclude_user_ids, $task,['between', 'task_user.rate', $post['rate_start'], $post['rate_end']]);
        }
        if(isset($post['country'])) {
            $this->findUsersCondition($users, $exclude_user_ids, $task,['geo_country.id' => $post['country']]);
        }
        $this->findUsersCondition($users, $exclude_user_ids, $task);
    }

    private function render_delegated_businesses() {
        $userTools = UserTool::find()->select('user_tool.*,idea.name name')
            ->join('JOIN', 'task_user', 'task_user.user_tool_id = user_tool.id')
            ->join('JOIN', 'delegate_task', 'delegate_task.task_user_id = task_user.id')
            ->join('LEFT OUTER JOIN', 'idea', 'idea.user_tool_id = user_tool.id')
            ->where(['delegate_task.delegate_user_id' => Yii::$app->user->id])
            ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel])
            ->all();
        return $this->renderPartial('blocks/delegated_businesses',
            [
                'userTools' => $userTools
            ]);
    }
    private function get_user_specials() {
        $user_do = UserDo::find()->where(['user_id' => Yii::$app->user->id])->all();
        $user_specials = UserSpecialization::find()->select('user_specialization.*, specialization.name name, specialization.department_id dep_id,department.name dname')
            ->join('JOIN','specialization','specialization.id = user_specialization.specialization_id')
            ->join('JOIN','department','department.id = specialization.department_id')
            ->join('JOIN','task','task.specialization_id = specialization.id')
            ->where(['user_specialization.user_id' => Yii::$app->user->id])->all();

        foreach($user_specials as $key => $user_special) {
            $is_find = false;
            foreach($user_do as $do) {
                if($do->status_sell == 1 && $user_special->dep_id == $do->department_id && $user_special->dep_hide == 0) {
                    $is_find = true;
                    break;
                }
            }
            if(!$is_find) {
                unset($user_specials[$key]);
                continue;
            }
        }
        return $user_specials;
    }


    private function get_user_specials_pending($spec) {
        $user_do = UserDo::find()->where(['user_id' => Yii::$app->user->id])->all();
        $user_specials = Specialization::find()->select('specialization.name name, specialization.department_id dep_id,department.name dname')
            ->join('JOIN','department','department.id = specialization.department_id')
            ->where(['specialization.id' => $spec])->all();
         foreach($user_specials as $key => $user_special) {
             $is_find = false;
             foreach($user_do as $do) {
                 if($do->status_sell == 1 && $user_special->dep_id == $do->department_id && $user_special->dep_hide == 0) {
                     $is_find = true;
                     break;
                 }
             }
             if(!$is_find) {
                 unset($user_specials[$key]);
                 continue;
             }
         }
        return $user_specials;
    }

    public function actionGetSpecials() {
        $user_specials = $this->get_user_specials();
        $department_id = $_POST['department'];
        foreach($user_specials as $key => $special) {
            if($special->dep_id != $department_id) {
                unset($user_specials[$key]);
                continue;
            }
        }
        $response['error'] = false;
        $response['html'] = $this->renderPartial('blocks/specials',[
            'user_specials' => $user_specials
        ]);
        return json_encode($response);
    }
    private function apply_filters(&$user_specials,$post = [], $is_hide = true, $is_dep = false) {
        if(isset($post['department']) && $post['department'] != 0) {
            $department_id = $post['department'];
            foreach($user_specials as $key => $user_special) {
                if($user_special->dep_id != $department_id) {
                    unset($user_specials[$key]);
                    continue;
                }
            }
        }
        if(isset($post['special']) && $post['special'] != 0) {
            $special_id = $post['special'];
            foreach($user_specials as $key => $user_special) {
                if($user_special->id != $special_id) {
                    unset($user_specials[$key]);
                    continue;
                }
            }
        }
        if(isset($post['deps'])) {
            $deps_filter = $post['deps'];
            foreach($user_specials as $key => $user_special) {
                $is_find = false;
                foreach($deps_filter as $dep) {
                    if($user_special->dep_id == $dep) {
                        $is_find = true;
                        break;
                    }
                }
                if(!$is_find) {
                    if(!$is_hide) {
                        $user_special->dep_hide = 1;
                    }
                    else {
                        unset($user_specials[$key]);
                        continue;
                    }
                }
            }
        }
        if(isset($post['spec'])) {
            $spec_filter = $post['spec'];
            foreach($user_specials as $key => $user_special) {
                $is_find = false;
                foreach($spec_filter as $spec) {
                    if($user_special->id == $spec) {
                        $is_find = true;
                        break;
                    }
                }
                if(!$is_find) {
                    if(!$is_dep) {
                        $user_special->spec_hide = 1;
                    }
                }
            }
        }
    }
    private function render_user_task($post = [], $is_dep = false) {
        $user_specials = $this->get_user_specials();
        $this->apply_filters($user_specials, $post);
        if($is_dep != true) {
            foreach ($user_specials as $key => $user_special) {
                if ($user_special->dep_hide == 1 || $user_special->spec_hide == 1) {
                    unset($user_specials[$key]);
                    continue;
                }
            }
        }

        $special_ids = [];
        foreach($user_specials as $user_special) {
            array_push($special_ids,$user_special->specialization_id);
        }

        $users = [];
        $task_find = Task::find()->select('task.*,specialization.id spec,specialization.name spec_name,department.name dname')
            ->join('JOIN','milestone','milestone.id = task.milestone_id')
            ->join('JOIN', 'department', 'department.id = task.department_id')
            ->join('JOIN', 'specialization', 'specialization.id = task.specialization_id')
            ->orderBy('task.id')
            ->where([
                'is_hidden' => '0',
                'department.is_additional' => 0
            ])
            ->andWhere(['specialization.id' => $special_ids])
            ->all();

        foreach($task_find as $task) {
            $exclude_user_ids = [Yii::$app->user->id];
            if(count($users) < 25)
            {
                $this->findUsersByTask($users,$exclude_user_ids, $task, $post);
            }
            else {
                break;
            }
        }
        return $this->renderPartial('blocks/user_task',[
            'users' => $users,
        ]);
    }
    private function get_user_request() {
        return DelegateTask::find()->select(
            'delegate_task.*,user_profile.first_name fname,user_profile.last_name lname,user.email email,user_profile.avatar user_avatar,skill_list.name level,user_profile.rate rate_h,geo_country.title_en country,user_profile.city_title city,task.name task_name,specialization.name task_special,task.market_rate task_rate, task_user.time task_user_time, task_user.price task_user_price, task.description task_desc,task.department_id dep_id,department.name dname,specialization.id spec_id, user_profile.user_id uid'
        )
            ->join('JOIN','task_user', 'task_user.id = delegate_task.task_user_id')
            ->join('JOIN','task', 'task.id = task_user.task_id')
            ->join('JOIN','department', 'department.id = task.department_id')
            ->join('JOIN','specialization', 'specialization.id = task.specialization_id')
            ->join('JOIN','user_tool', 'user_tool.id = task_user.user_tool_id')
            ->join('JOIN','user', 'user.id = user_tool.user_id')
            ->join('JOIN','user_profile', 'user_profile.user_id = user.id')
            ->join('LEFT OUTER JOIN','user_specialization', 'user_specialization.user_id = user.id')
            ->join('LEFT OUTER JOIN','skill_list', 'skill_list.id = user_specialization.exp_type')
            ->join('LEFT OUTER JOIN','geo_country', 'geo_country.id = user_profile.country_id')
            ->join('LEFT OUTER JOIN','user_skills', 'user_skills.user_id = user_profile.user_id')
            ->where([
                'delegate_task.delegate_user_id' => Yii::$app->user->id,
                'delegate_task.status' => DelegateTask::$status_inactive
            ])->all();
    }
    private function render_user_request($users = null) {
        if(!$users) {
            $users = $this->get_user_request();
        }

        return $this->renderPartial('blocks/user_request',
            [
                'users' => $users
            ]);
    }

    private function render_deps_filter($post = [],$user_specials = null) {
        if(!$user_specials) {
            $user_specials = $this->get_user_specials();
        }
        $this->apply_filters($user_specials, $post, false);
        $departments = [];
        foreach($user_specials as $special) {
            $departments[$special->dep_id] = ['id' => $special->dep_id,'name' => $special->dname,'is_hide'=>$special->dep_hide];
        }
        return $this->renderPartial('blocks/deps_filter',
            [
                'departments' => $departments
            ]);
    }

    private function render_deps_filter_pending($post = [],$user_specials = null) {
        if(!$user_specials) {
            $user_specials = $this->get_user_specials();
        }
        $this->apply_filters($user_specials, $post, false);
        $departments = [];
        foreach($user_specials as $special) {
            $departments[$special->dep_id] = ['id' => $special->dep_id,'name' => $special->dname,'is_hide'=>$special->dep_hide];
        }
        return $this->renderPartial('blocks/deps_filter',
            [
                'departments' => $departments
            ]);
    }




    private function render_specials_filter($post = [],$user_specials = null,$is_dep = false) {
        if(!$user_specials) {
            $user_specials = $this->get_user_specials();
        }
        $this->apply_filters($user_specials, $post, true,$is_dep);
        return $this->renderPartial('blocks/specials_filter',
            [
                'user_specials' => $user_specials
            ]);
    }
    public function actionUserTask($post = null)
    {
        if($post == null) {
            $post = Yii::$app->request->post();
        }
        $is_dep = filter_var($post['is_dep'], FILTER_VALIDATE_BOOLEAN);

        $response['html_user_task'] = $this->render_user_task($post, $is_dep);
        $response['html_user_request'] = $this->render_user_request();
        $response['html_delegated_businesses'] = $this->render_delegated_businesses();
        $response['html_deps_filter'] = $this->render_deps_filter($post);

        $response['html_specials_filter'] = $this->render_specials_filter($post,null, $is_dep);
        $response['error'] = false;
        return json_encode($response);
    }
    public function actionUserRequest($post = null) {
        if($post == null) {
            $post = Yii::$app->request->post();
        }

        $users_request = $this->get_user_request();

        $user_specials = $this->get_user_specials();
        $is_dep = filter_var($post['is_dep'], FILTER_VALIDATE_BOOLEAN);

        $users_special_request = $user_specials;
        foreach($users_special_request as $key => $user_special) {
            $is_find = false;
            foreach($users_request as $request) {
                if($request->spec_id == $user_special->specialization_id) {
                    $is_find = true;
                    break;
                }
            }
            if(!$is_find) {
                unset($users_special_request[$key]);
                continue;
            }
        }
        foreach($users_request as $key => $request) {
            $is_find = false;
            foreach($users_special_request as $user_special) {
                if($request->spec_id == $user_special->specialization_id) {
                    $is_find = true;
                    break;
                }
            }
            if(!$is_find) {
                unset($users_request[$key]);
                continue;
            }
        }
        $deps_request_filter = $this->render_deps_filter($post, $users_special_request);
        $is_dep = filter_var($post['is_dep'], FILTER_VALIDATE_BOOLEAN);
        $specials_request_filter = $this->render_specials_filter($post, $users_special_request, $is_dep);

        $user_request = $this->render_user_request($users_request);
        $response['html_user_request'] = $user_request;
        $response['html_delegated_businesses'] = $this->render_delegated_businesses();


        $response['html_deps_filter'] = $deps_request_filter;
        $response['html_specials_filter'] = $specials_request_filter;
        $response['error'] = false;
        return json_encode($response);
    }

    public function actionRequest($post = null) {
        if($post == null) {
            $post = Yii::$app->request->post();
        }
        if(isset($post['user_ids'])) {
            $i = 0;
            foreach ($post['user_ids'] as $user_id) {
                $task_id = $post['user_task_ids'][$i];
                $user_tool = UserTool::find()->where(['id' => $user_id])->one();
                $task_user = TaskUser::getTaskUser($user_tool->id,$task_id);

                $delegateTask = DelegateTask::find()->where(
                    [
                        'task_user_id' => $task_user->id,
                        'delegate_user_id' => Yii::$app->user->id
                    ]
                )->andWhere(['!=','status',DelegateTask::$status_done])
                    ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel])
                    ->one();
                if (is_null($delegateTask)) {
                    $delegateTask = new DelegateTask();
                    $delegateTask->task_user_id = $task_user->id;
                    $delegateTask->delegate_user_id = Yii::$app->user->id;
                    $delegateTask->start = $task_user->start;
                    $delegateTask->end = $task_user->end;
                    $delegateTask->time = $task_user->time;
                    $delegateTask->price = $task_user->price;
                    $delegateTask->date = '' . date('Y-m-d h:i:s');
                    $delegateTask->is_request = 1;
                    $delegateTask->save();
                }
                $i++;
            }
            $response['error'] = false;
            $response['html_user_task'] = $this->render_user_task($post);
            $response['html_user_request'] = $this->render_user_request();
            $response['html_delegated_businesses'] = $this->render_delegated_businesses();
            $response['html_deps_filter'] = $this->render_deps_filter($post);
            $response['html_specials_filter'] = $this->render_specials_filter($post);
        }
        else {
            $response['error'] = true;
        }
        return json_encode($response);
    }
    public function actionReject($post = null) {
        if($post == null) {
            $post = Yii::$app->request->post();
        }
        if(isset($post['user_ids'])) {
            foreach ($post['user_ids'] as $delegate_task_id) {

                $delegateTask = DelegateTask::find()->where(['id' => $delegate_task_id])->one();
                if ($delegateTask) {
                    $delegateTask->delete();
                }
            }
            $response['error'] = false;
            $response['html_user_task'] = $this->render_user_task($post);
            $response['html_user_request'] = $this->render_user_request();
            $response['html_delegated_businesses'] = $this->render_delegated_businesses();
            $response['html_deps_filter'] = $this->render_deps_filter($post);
            $response['html_specials_filter'] = $this->render_specials_filter($post);
        }
        else {
            $response['error'] = true;
        }
        return json_encode($response);
    }

    public function actionCreate()
    {
        return $this->redirect(['/departments/task','id' => Task::$task_idea_id ]);
    }
    public function actionDelete($id)
    {
        $tool = UserTool::find()->where(['id' => $id])->one();
        if($tool) {
            $tool->delete();
        }
        return $this->redirect(['/departments/business#my']);
    }
    public function actionAcceptTasks($id)
    {
        $userTool = UserTool::find()->where(['id' => $id])->one();

        $tasks = DelegateTask::find()->select('*,delegate_task.id id,task.name name,task.id task,user_profile.avatar avatar')
            ->join('JOIN', 'task_user', 'task_user.id = delegate_task.task_user_id')
            ->join('JOIN', 'task', 'task.id = task_user.task_id')
            ->join('JOIN', 'user_tool', 'user_tool.id = task_user.user_tool_id')
            ->join('JOIN', 'user', 'user.id = user_tool.user_id')
            ->join('JOIN', 'user_profile', 'user_profile.user_id = user.id')
            ->where([
                'user_tool.id' => $id,
                'delegate_task.status' => 0,
                'delegate_task.delegate_user_id' => Yii::$app->user->id,
            ])->andWhere(['!=','delegate_task.status',DelegateTask::$status_done])
            ->andWhere(['!=','delegate_task.status',DelegateTask::$status_cancel])
            ->all();

        return $this->render('accept-tasks',[
            'userTool' => $userTool,
            'tasks' => $tasks
        ]);
    }

    function get_redirect($tool_id) {
        $userTool = UserTool::find()->where(['id' => $tool_id])->one();
        $tasks = TaskUser::find()
            ->select('*,task_user.id id, task.name name')
            ->join('RIGHT JOIN', 'task', '`task_user`.task_id = `task`.`id`')
            ->where([
                'task_user.user_id' => Yii::$app->user->identity->id,
                'task_user.user_tool_id' => $userTool->id,
                'task_user.is_accept' => 0,
            ])->all();
        if(count($tasks) > 0) {
            return $this->redirect(['/departments/business/accept-tasks', 'id' => $userTool->id]);
        }
        else {
            return $this->redirect(['/departments/business']);
        }
    }

    public function actionAccept($id)
    {
        $task = TaskUser::find()
            ->where([
                'id' => $id
            ])->one();

        $task->is_accept = 1;
        $task->save(false);
        return $this->get_redirect($task->user_tool_id);
    }
    public function actionDecline($id)
    {
        $task = TaskUser::find()
            ->where([
                'id' => $id
            ])->one();
        $tool_id = $task->user_tool_id;

        $task->delete();
        return $this->get_redirect($tool_id);
    }

    public function actionEditIdea($id)
    {
        $idea = Idea::findOne(
            [
                'id' => $id
            ]
        );
        $industries = Industry::find()->all();
        $industries = ArrayHelper::map($industries, 'id', 'name');

        if ($idea->load(Yii::$app->request->post())) {
            if($idea->save()) {
                return $this->redirect(['/departments/business']);
            }
        }

        return $this->render('form-idea',[
            'idea' => $idea,
            'industries' => $industries
        ]);
    }
    public function actionDeleteIdea($id)
    {
        $user_id = Yii::$app->user->identity->id;
        $idea = Idea::findOne(
            [
                'id' => $id
            ]
        );
        if($idea) {
            $idea->delete();
        }

        $task = TaskComponent::find()->where([
            'id' => 38
        ])->one();
        $task_user = TaskUser::find()->where([
            'task_id' => $task->id,
            'user_id' => $user_id
        ])->one();
        if($task_user) {
            $task_user->status = 1;
            $task_user->save();
        }
        return $this->redirect(['/departments','id' => $task->department_id]);
    }
    public function actionEditGoal($id)
    {
        $goal = Goal::findOne(
            [
                'id' => $id
            ]
        );

        if ($goal->load(Yii::$app->request->post())) {
            if($goal->save()) {
                return $this->redirect(['/departments/business']);
            }
        }

        return $this->render('form-goal',[
            'goal' => $goal
        ]);
    }
    public function actionDeleteGoal($id)
    {
        $user_id = Yii::$app->user->identity->id;
        $goal = Goal::findOne(
            [
                'id' => $id
            ]
        );
        if($goal) {
            $goal->delete();
        }

        $task = TaskComponent::find()->where([
            'id' => 168
        ])->one();
        $task_user = TaskUser::find()->where([
            'task_id' => $task->id,
            'user_id' => $user_id
        ])->one();
        if($task_user) {
            $task_user->status = 1;
            $task_user->save();
        }
        return $this->redirect(['/departments','id' => $task->department_id]);
    }

    public function actionSelectTool($id)
    {
        Yii::$app->session['tool_id'] = $id;
        return $this->redirect(['/departments']);
    }

    public function actionDashboardEditing($id) {
        $tool = UserTool::find()->where(['id' => $id])->one();

        $idea = Idea::find()->where(['user_tool_id' => $tool->id])->one();
        $industries = Industry::find()->all();
        $benefit = Benefit::find()->where(['user_tool_id' => $tool->id])->one();
        if(!$benefit) {
            $benefit = new Benefit();
        }

        return $this->render('dashboard_editing',[
            'tool' => $tool,
            'idea' => $idea,
            'industries' => $industries,
            'benefit' => $benefit
        ]);
    }
    public function actionDashboardSave() {
        $tool = UserTool::find()->where(['id' => $_POST['tool_id']])->one();
        $response['error'] = true;
        if($tool) {
            $matches = [];
            if(preg_match("/(^.*)\[(.*)\]$/", $_POST['name'], $matches)) {
                $model_name = "\\modules\\departments\\models\\".$matches[1];
                $model_key = $matches[2];
                $model = $model_name::find()->where(['user_tool_id' => $tool->id])->one();
                if(!$model) {
                    $model = new $model_name();
                    $model->user_tool_id = $tool->id;
                }
                $model->$model_key = $_POST['text'];
                if($model->validate([$model_key])) {
                    $model->save(false);
                    $response['error'] = false;
                }
            }
        }
        return json_encode($response);
    }

    public function actionDashboard($id)
    {
        if(Yii::$app->user->isGuest) {
            $this->layout = 'dashboard';
        }

        $tool = UserTool::find()->where(['id' => $id])->one();
        if($tool) {
            $idea = Idea::find()->where(['user_tool_id' => $tool->id])->one();
            $benefit = Benefit::find()->where(['user_tool_id' => $tool->id])->one();
            $user = User::find()->where(['id' => $tool->user_id])->one();
            $profile = Profile::find()->select('user_profile.*, geo_country.title_en country')
                ->join('LEFT OUTER JOIN','geo_country','geo_country.id = user_profile.country_id')
                ->where(['user_profile.user_id' => Yii::$app->user->id])->one();

            $idea_like = IdeaLike::find()->where(['idea_id' => $idea->id,'ip_address' => $_SERVER['REMOTE_ADDR']])->one();
            if(!$idea_like) {
                $idea_like = new IdeaLike();
            }
            $benefit_like = BenefitLike::find()->where(['benefit_id' => $benefit->id,'ip_address' => $_SERVER['REMOTE_ADDR']])->one();
            if(!$benefit_like) {
                $benefit_like = new BenefitLike();
            }
            $min_points = 10000;
            $max_points = -1;
            $controller = new \modules\tests\site\controllers\DefaultController('default',Yii::$app->getModule('tests'));
            $test_result_inform = $controller->getResultInform($min_points,$max_points);

            $comments = null;
            if(!Yii::$app->user->isGuest) {
                $comments = UserToolComment::find()->where(['user_tool_id' => $tool->id])->all();
            }

            return $this->render('dashboard',[
                'tool' => $tool,
                'idea' => $idea,
                'benefit' => $benefit,
                'user' => $user,
                'profile' => $profile,
                'idea_like' => $idea_like,
                'benefit_like' => $benefit_like,
                'test_result_inform' => $test_result_inform,
                'comments' => $comments
            ]);
        }
        return $this->redirect(['/']);
    }
    public function actionIdeaLike() {
        $idea = Idea::find()->where(['user_tool_id' => $_POST['tool_id']])->one();
        $idea_like = IdeaLike::find()->where(['idea_id' => $idea->id,'ip_address' => $_SERVER['REMOTE_ADDR']])->one();
        if(!$idea_like) {
            $idea_like = new IdeaLike();
            $idea_like->idea_id = $idea->id;
            $idea_like->ip_address = $_SERVER['REMOTE_ADDR'];
        }
        $idea_like->like = $_POST['like'];
        $idea_like->save();

        $response['error'] = false;
        return json_encode($response);
    }
    public function actionBenefitLike() {
        $benefit = Benefit::find()->where(['user_tool_id' => $_POST['tool_id']])->one();
        $benefit_like = BenefitLike::find()->where(['benefit_id' => $benefit->id,'ip_address' => $_SERVER['REMOTE_ADDR']])->one();
        if(!$benefit_like) {
            $benefit_like = new BenefitLike();
            $benefit_like->benefit_id = $benefit->id;
            $benefit_like->ip_address = $_SERVER['REMOTE_ADDR'];
        }
        $benefit_like->like = $_POST['like'];
        $benefit_like->save();

        $response['error'] = false;
        return json_encode($response);
    }

    public function actionSharedBusiness($id){
        $this->layout = false;
        return $this->render('shared_business', []);
    }

}