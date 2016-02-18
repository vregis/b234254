<?php

/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 02.02.2016
 * Time: 17:06
 */

namespace modules\departments\tool\task_custom;

use modules\departments\models\Idea;
use modules\departments\models\Industry;
use modules\tasks\models\Task;
use Yii;
use yii\helpers\ArrayHelper;

class TaskIdeaMilestone extends TaskCustom
{
    protected $task_videos;
    protected $task_notes;
    protected $task_links;
    protected $files;
    public function __construct($file_name, $task, $task_videos, $task_notes, $task_links, $files)
    {
        $this->task_videos = $task_videos;
        $this->task_notes = $task_notes;
        $this->task_links = $task_links;
        $this->files = $files;
        parent::__construct($file_name,$task);
    }
    public function render($config = []) {

        return parent::render(
            [
                'task' =>  $this->m_task,
                'task_videos' => $this->task_videos,
                'task_notes' => $this->task_notes,
                'task_links' => $this->task_links,
                'files' => $this->files
            ] + $config
        );
    }
}