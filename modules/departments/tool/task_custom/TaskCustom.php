<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 03.02.2016
 * Time: 9:44
 */

namespace modules\departments\tool\task_custom;


use Yii;
use yii\base\Component;

class TaskCustom extends Component
{
    protected $m_task;
    protected $m_file_name;

    public function __construct($file_name, $task)
    {
        $this->m_task = $task;
        $this->m_file_name = $file_name;
        parent::__construct([]);
    }

    public function render($config = []) {
        if($config == []) {
            $config = ['task' =>  $this->m_task];
        }
        return Yii::$app->controller->renderPartial('blocks/task_custom/'.$this->m_file_name,
            $config
        );
    }
}