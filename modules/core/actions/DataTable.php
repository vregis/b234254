<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 01.12.2015
 * Time: 17:18
 */

namespace modules\core\actions;

use modules\departments\models\Department;
use modules\departments\models\Specialization;
use modules\milestones\models\Milestone;
use yii\base\Action as YiiAction;
use Yii;
use yii\helpers\Url;
use modules\tasks\models\TaskUser;

class DataTable extends YiiAction
{
    static $id_index = 0;
    static $status_index = 0;
    static function compare_priority($a, $b)
    {
        $a_i = $a[DataTable::$status_index] == 2 ? 1 : 0;
        $b_i = $b[DataTable::$status_index] == 2 ? 1 : 0;
        if($a_i == $b_i) {
            return $a[DataTable::$id_index] > $b[DataTable::$id_index];
        }
        return $a_i > $b_i ? 1 : -1;
    }
    public function run() {

        $post = Yii::$app->request->post();

        $keys = json_decode($post['keys']);

        $model_name = $post['model'];
        $models_find = $model_name::find();

        if(Yii::$app->params['id'] == 'app-site' && $model_name == '\modules\tasks\models\Task') {
            $models_find->join('LEFT JOIN', 'milestone', '`task`.milestone_id = `milestone`.`id`')->where(['milestone.is_pay'=>0]);
        }

        if(isset($post['where'])) {
            $wheres = json_decode($post['where'], true);
            $models_find->andWhere($wheres);
        }
        if(isset($post['whereNo'])) {
            $wheres = json_decode($post['whereNo'], true);
            foreach($wheres as $where) {
                $models_find->andWhere(["!=", "id", $where]);
            }
        }

        foreach($keys as $key) {
            $filter = 'filter_'.$key;
            if(isset($post[$filter]) && $post[$filter] != '') {
                $models_find->andWhere([$key => $post[$filter]]);
            }
        }
        $search_status = '';
        foreach($post['columns'] as $key => $value) {
            $search = $value['search']['value'];
            if($search != '') {
                if($model_name == '\modules\tasks\models\Task' && $key == '4') {
                    $search_status = $search;
                }
                else {
                    $models_find->andWhere([$keys[$key] => $value['search']['value']]);
                }
            }
        }

        $iTotalRecords = $models_find->count();

        if(isset($post['order'])) {
            $models_find->orderBy(
                [$keys[$post['order'][0]['column']] => $post['order'][0]['dir'] == 'asc' ? SORT_ASC : SORT_DESC]
            );
        }

        $iDisplayLength = $post['length'];
        $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength;
        $iDisplayStart = intval($post['start']);
        $sEcho = intval($post['draw']);

        $records = array();
        $records["data"] = array();

        $end = $iDisplayStart + $iDisplayLength;
        $end = $end > $iTotalRecords ? $iTotalRecords : $end;

        $models = $models_find->limit($iDisplayLength)->offset($iDisplayStart)->asArray()->all();
        foreach($models as $model) {
            $array_value = [];
            $is_add = true;
            foreach($keys as $q_key) {
                if($model_name == '\modules\tasks\models\Task' && $q_key == 'market_rate') {
                    if(isset($model['specialization_id'])) {
                        $spec = Specialization::find()->where(['id' => $model['specialization_id']])->one();
                        $array_value[] = $spec->market_rate_min . '$ - ' . $spec->market_rate_max . '$';
                    }else {
                        $array_value[] = '';
                    }
                }
                else if($model_name == '\modules\tasks\models\Task' && $q_key == 'status') {
                    $status = 0;
                    $task_user = TaskUser::find()->where(['task_id' => $model['id'],'user_id' => Yii::$app->user->identity->id])->one();
                    if(!is_null($task_user)) {
                        $status = $task_user->status;
                    }
                    if($search_status != '' && $status != $search_status) {
                        $is_add = false;
                        break;
                    }
                    else {
                        $array_value[] = $status;
                    }
                }
                else {
                    foreach ($model as $key => $value) {
                        if ($key == $q_key) {
                            if ($key == 'department_id') {
                                $array_value[] = Department::find()->where(['id' => $value])->one()->name;
                            } else {
                                if ($key == 'milestone_id') {
                                    $array_value[] = Milestone::find()->where(['id' => $value])->one()->name;
                                } else {
                                    if ($key == 'specialization_id') {
                                        $spec = Specialization::find()->where(['id' => $value])->one();
                                        if (!is_null($spec)) {
                                            $array_value[] = $spec->name;
                                        } else {
                                            $array_value[] = 'Without specialization';
                                        }
                                    } else {
                                        $array_value[] = $value;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if($is_add) {
                $records["data"][] = $array_value;
            }
        }
        if(Yii::$app->params['id'] == 'app-site' && $model_name == '\modules\tasks\models\Task') {
            DataTable::$status_index = 0;
            foreach($keys as $key) {
                if($key == 'status') {
                    break;
                }
                DataTable::$status_index++;
            }
            DataTable::$id_index = 0;
            foreach($keys as $key) {
                if($key == 'id') {
                    break;
                }
                DataTable::$id_index++;
            }
            usort($records["data"], [$this->className(), 'compare_priority']);
        }

        $records["draw"] = $sEcho;
        $records["recordsTotal"] = $iTotalRecords;
        $records["recordsFiltered"] = $iTotalRecords;

        echo json_encode($records);
    }
}