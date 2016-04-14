<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 13.01.2016
 * Time: 15:33
 */

namespace modules\core\site\profile;

use modules\core\ajaxModel\DynamicData;
use modules\departments\models\Department;
use modules\departments\models\Specialization;
use modules\tasks\models\Task;
use modules\user\models\Skilllist;
use modules\user\models\UserSpecialization;
use Yii;

class ServiceData extends DynamicData
{
    public $main_class = 'service';
    public $main_title = 'Services';
    public $main_model = '\modules\user\models\UserSpecialization';

    public $data_block_view = 'blocks/service_row_block';
    public $specials_block_view = 'blocks/service_specials_block';
    public $specials_tasks_view = 'blocks/service_tasks_block';

    public $departments = null;
    public $sklist = null;
    public $curdep = null;

    function __construct($departments = null, $sklist = null, $curdep = null) {
        $this->departments = $departments;
        $this->sklist = $sklist;
        $this->curdep = $curdep;
    }

    function renderTasks($taskfromspec, $service = null, $is_add = true) {
        return  Yii::$app->controller->renderPartial(
            $this->specials_tasks_view,
            [
                'service' => $service,
                'tasklist' => $taskfromspec,
                'is_add' => $is_add
            ]
        );
    }
    function renderRow($specfromdep = null, $taskfromspec = null, $service = null, $dep = null, $is_add = true, $last = null) {

        $type = 'update';
        if($this->departments == null) {
            $this->departments = Department::find()->all();
        }
        if($this->sklist == null) {
            $this->sklist = Skilllist::find()->orderBy(['id' => SORT_DESC])->all();
        }
        $tasks = '';

        if($specfromdep == null){
            $type = 'add';
            $existing_spec = [];
            $services = UserSpecialization::find()
                ->select('*, user_specialization.*')
                ->join('LEFT JOIN', 'specialization', 'specialization.id = user_specialization.specialization_id')
                ->where(['user_id'=>Yii::$app->user->id, 'specialization.department_id' => $this->curdep])->orderBy(['user_specialization.task_id' => SORT_DESC])->all();
            foreach ($services as $service) {
                $existing_spec[$service->specialization_id] = $service->specialization_id;
            }
            $specfromdep = Specialization::find()->where(['not in', 'id', $existing_spec])
                ->andWhere(['department_id'=>$this->curdep])
                ->orderBy('name')
                ->all();
        }

        return Yii::$app->controller->renderPartial(
            $this->data_block_view,
            [
                'service' => $service,
                'departments' => $this->departments,
                'speclist' => $specfromdep,
                'tasks' => $tasks,
                'sklist' => $this->sklist,
                'result' => $dep,
                'is_add' => $is_add,
                'type' => $type,
                'last' => $last
            ]
        );
    }
    public function renderRows() {
        $result = '';
        $services = UserSpecialization::find()
            ->select('*, user_specialization.*')
            ->join('LEFT JOIN', 'specialization', 'specialization.id = user_specialization.specialization_id')
            ->where(['user_id'=>Yii::$app->user->id, 'specialization.department_id' => $this->curdep])->orderBy(['user_specialization.task_id' => SORT_DESC])->all();

        if(count($services) > 0) {

            $countSpecializationFromDep = Specialization::find()->where(['department_id' => $this->curdep])->all();
            if(count($services) == count($countSpecializationFromDep)){
                $last = true;
            }else{
                $last = null;
            }

            $i = 0;
            $j = 0;
            $existing_spec = [];
            foreach ($services as $service) {
                $existing_spec[$service->specialization_id] = $service->specialization_id;
            }
            foreach ($services as $service) {
                $temp = [];
                $temp = $existing_spec;
                if(isset($temp[$service->specialization_id])){
                    unset($temp[$service->specialization_id]);
                }
                $dep = Specialization::find()->select('*, department.id idd')->join('RIGHT JOIN', 'department', '`department`.`id` = `specialization`.`department_id`')->where(['specialization.id'=>$service->specialization_id])->one();
                $specfromdep = Specialization::find()->where(['not in', 'id', $temp])
                    ->andWhere(['department_id'=>$this->curdep])
                    ->orderBy('name')
                    ->all();
                $taskfromspec = Task::find()->where(['specialization_id'=>$service->specialization_id])->all();

                $result .= $this->renderRow($specfromdep, $taskfromspec, $service, $dep, $i == count($services) - 1, $last);
                $i++;
            }
        }
        else {
            $result = $this->renderRow();
        }
        return $result;
    }

    function render() {
        return $this->renderRows();
    }

    public function ajaxUpdate(){
        $response = (array)json_decode(parent::ajaxUpdate());
        if($_POST['update_key'] == 'specialization_id') {
            $model = UserSpecialization::find()->where(['id' => $response['id']])->one();
            $model->task_id = 0;
            $model->save();
            $taskfromspec = Task::find()->where(['specialization_id' => $_POST['update_data']])->all();
            $response['html'] = $this->renderTasks($taskfromspec);
        }
        return json_encode($response);
    }

    public function addSpecialization($post){
        if(isset($post['spec'])) {
            foreach ($post['spec'] as $spec) {
                $us = new UserSpecialization();
                $us->specialization_id = $spec;
                $us->user_id = Yii::$app->user->id;
                $us->exp_type = 4;
                if (!$us->save()) {
                    var_dump($us->getErrors());
                }
            }
        }
        $html = $this->renderRows();
        return $html;

    }

    public function addTask($post){
        if(isset($post['tasks'])){
            foreach($post['tasks'] as $t){
                if($t != ''){
                    $us = new UserSpecialization();
                    $us->task_id = $t;
                    $us->specialization_id = $post['spec'];
                    $us->user_id = Yii::$app->user->id;
                    if (!$us->save()) {
                        var_dump($us->getErrors());
                    }
                }
            }
        }
        $html = $this->renderRows();
        return $html;
    }

    public function ajaxDelete() {
        if($_POST['id'] != 0){
            $main_model = $this->main_model;
            $model = $main_model::find()->where(['id'=>$_POST['id']])->one();
            if($model) {
                $model->delete();
            }
        }
        $response['dep'] = $_POST['dep'];
        $response['html2'] = $this->renderRows();
        return json_encode($response);
    }

    public function ajaxAdd() {
        $response['error'] = false;
        $response['html'] = $this->renderRow();
        return (json_encode($response));
    }




}