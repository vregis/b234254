<?php

/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 02.02.2016
 * Time: 17:06
 */

namespace modules\departments\tool\task_custom;

use modules\tasks\models\Task;
use Yii;
use yii\base\Component;

class TaskRoadmap extends TaskCustom
{
    public function __construct($task)
    {
        parent::__construct('roadmap',$task);
    }
    public function render($config = []) {

        $tasks = Task::find()->where(['milestone_id' => $this->m_task->milestone_id])->andWhere(['!=','id',$this->m_task->id])->orderBy('sort')->all();

        return parent::render(
            [
                'task' =>  $this->m_task,
                'tasks' => $tasks
            ]
        );
    }
}