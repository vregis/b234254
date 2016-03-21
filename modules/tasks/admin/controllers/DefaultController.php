<?php

namespace modules\tasks\admin\controllers;

use modules\core\admin\base\Controller;
use modules\tasks\models\Task;
use modules\tasks\models\TaskVideoYoutube;
use modules\tasks\models\TaskLink;
use modules\tasks\models\TaskNote;
use modules\departments\models\Department;
use modules\departments\models\Specialization;
use modules\milestones\models\Milestone;
use Yii;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * Class DefaultController
 *
 * @author MrArthur
 * @since 1.0.0
 */
class DefaultController extends Controller
{
    public function actionIndex()
    {
        $tasks = Task::find()->all();

        $milestones = Milestone::find()->all();
        $milestonesArr = ArrayHelper::map($milestones, 'id' , 'name');
        $departments = Department::find()->all();
        $departmentsArr = ArrayHelper::map($departments, 'id' , 'name');

        return $this->render('index',[
            'tasks' => $tasks,
            'milestonesArr' => $milestonesArr,
            'departmentsArr' => $departmentsArr
        ]);
    }

    public function actionCreate($milestone_id = -1) {

        $task = new Task();
        $task->user_id = yii::$app->user->identity->id;
        $task->director_name = 'BSB';
        $task->priority = "2";
        if($milestone_id != -1) {
            $task->milestone_id = $milestone_id;
        }
        if (!isset(Yii::$app->request->cookies['temp_id'])) {
            $temp_id = ''.md5(uniqid());
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                        'name' => 'temp_id',
                        'value' => $task->temp_id
                    ]));
        }
        else {
            $temp_id = Yii::$app->request->cookies['temp_id']->value;
        }
        $preceding_tasks = [];
        $post = Yii::$app->request->post();
        if (count($post) != 0) {
            $preceding_tasks_array = json_decode($post['preceding-tasks']);
            foreach ($preceding_tasks_array as $preceding_task) {
                $preceding_tasks[] = Task::findOne(['id' => $preceding_task]);
            }
            $task->preceding_tasks = $post['preceding-tasks'];
        }

        if ($task->load($post)) {
            if(isset($post['temp_id'])) {
                $temp_id = $post['temp_id'];
            }

            $tasksInMilestone = Task::find()->where(['milestone_id' => $milestone_id])->orderBy('sort')->all();
            $task->sort = count($tasksInMilestone) + 1;
            $i = 1;
            foreach($tasksInMilestone as $t) {
                if($i == $task->sort) {
                    $i++;
                }
                if($t->id != $task->id) {
                    $t->sort = $i;
                    $t->save(false);
                    $i++;
                }
            }
            $task->create_date = ''.date('Y-m-d');
            if($task->save()) {
                $temp_folder_path = Yii::getAlias('@static').'/tasks/temp/'.$temp_id;
                $new_folder_path = Yii::getAlias('@static').'/tasks/'.$task->id;
                rename($temp_folder_path, $new_folder_path);
                $task_videos = TaskVideoYoutube::find()->where(['task_temp_id' => $temp_id])->all();
                foreach($task_videos as $task_video) {
                    $task_video->task_temp_id = null;
                    $task_video->task_id = $task->id;
                    $task_video->save();
                }
                $task_links = TaskLink::find()->where(['task_temp_id' => $temp_id])->all();
                foreach($task_links as $task_link) {
                    $task_link->task_temp_id = null;
                    $task_link->task_id = $task->id;
                    $task_link->save();
                }
                $task_notes = TaskNote::find()->where(['task_temp_id' => $temp_id])->all();
                foreach($task_notes as $task_note) {
                    $task_note->task_temp_id = null;
                    $task_note->task_id = $task->id;
                    $task_note->save();
                }

                Yii::$app->response->cookies->remove('temp_id');
                return $this->redirect(['/milestones/view', 'id' => $milestone_id]);
            }
        }

        $task_videos = TaskVideoYoutube::find()->where(['task_temp_id' => $temp_id])->all();
        $task_links = TaskLink::find()->where(['task_temp_id' => $temp_id])->all();
        $task_notes = TaskNote::find()->where(['task_temp_id' => $temp_id])->all();
        $departments = Department::find()->all();
        $departmentsArr = ArrayHelper::map($departments, 'id' , 'name');
        $specializationsArr = [];
        foreach($departmentsArr as $id => $name) {
            $specializationsArr[$id] = ArrayHelper::map(Specialization::find()->where(['department_id' => $id])->all(), 'id' , 'name');
        }
        $milestones = Milestone::find()->all();
        $milestonesArr = ArrayHelper::map($milestones, 'id' , 'name');

        return $this->render('form',[
            'task' => $task,
            'temp_id' => $temp_id,
            'task_videos' => $task_videos,
            'task_links' => $task_links,
            'task_notes' => $task_notes,
            'departments' => $departments,
            'departmentsArr' => $departmentsArr,
            'specializationsArr' => $specializationsArr,
            'milestonesArr' => $milestonesArr,
            'preceding_tasks' => $preceding_tasks,
            'tasksInMilestoneArr' => null,
            'is_create' => true
        ]);
    }
    public function actionUpdate($id) {

        $task = Task::findOne(['id' => $id]);

        $preceding_tasks = [];
        $preceding_tasksArr = (array)json_decode($task->preceding_tasks);
        foreach ($preceding_tasksArr as $preceding_taskArr) {
            $preceding_tasks[] = Task::findOne(['id' => $preceding_taskArr]);
        }

        $post = Yii::$app->request->post();

        if (count($post) != 0) {
            $preceding_tasks_array = json_decode($post['preceding-tasks']);
            foreach ($preceding_tasks_array as $preceding_task) {
                $preceding_tasks[] = Task::findOne(['id' => $preceding_task]);
            }
            $task->preceding_tasks = $post['preceding-tasks'];
        }

        $tasksInMilestone = Task::find()->where(['milestone_id' => $task->milestone_id])->orderBy('sort')->all();
        $tasksInMilestoneArr = ArrayHelper::map($tasksInMilestone, 'sort' , 'name');
        array_unshift($tasksInMilestoneArr,' - First - ');
        array_push($tasksInMilestoneArr,' - Last - ');

        $sort = $task->sort;
        if ($task->load(Yii::$app->request->post())) {
            $fixed_value = false;
            if($task->sort == 0) {
                $task->sort = 1;
                $fixed_value = true;
            }
            else if($task->sort == count($tasksInMilestone) + 1) {
                $task->sort = count($tasksInMilestone);
                $fixed_value = true;
            }
            if($sort != $task->sort && !$fixed_value) {
                $task->sort++;
            }
            $i = 1;
            foreach($tasksInMilestone as $t) {
                if($i == $task->sort) {
                    $i++;
                }
                if($t->id != $task->id) {
                    $t->sort = $i;
                    $t->save(false);
                    $i++;
                }
            }
            if($task->id == 37 || $task->id == 38 || $task->id == 39){
                $task->description_road = $_POST['Task']['description_road'];
            }

            if($task->save()) {
                return $this->redirect(['/milestones/view', 'id' => $task->milestone_id]);
            }
        }
        $task_videos = TaskVideoYoutube::find()->where(['task_id' => $id])->all();
        $task_links = TaskLink::find()->where(['task_id' => $id])->all();
        $task_notes = TaskNote::find()->where(['task_id' => $id])->all();
        $departments = Department::find()->all();
        $departmentsArr = ArrayHelper::map($departments, 'id' , 'name');
        $specializationsArr = [];
        foreach($departmentsArr as $id => $name) {
            $specializationsArr[$id] = ArrayHelper::map(Specialization::find()->where(['department_id' => $id])->all(), 'id' , 'name');
        }
        $milestones = Milestone::find()->all();
        $milestonesArr = ArrayHelper::map($milestones, 'id' , 'name');

        return $this->render('form',[
            'task' => $task,
            'task_videos' => $task_videos,
            'task_links' => $task_links,
            'task_notes' => $task_notes,
            'departments' => $departments,
            'departmentsArr' => $departmentsArr,
            'specializationsArr' => $specializationsArr,
            'milestonesArr' => $milestonesArr,
            'preceding_tasks' => $preceding_tasks,
            'tasksInMilestoneArr' => $tasksInMilestoneArr,
            'is_create' => false
        ]);
    }
    public function actionView($id) {

        $task = Task::findOne(['id' => $id]);
        $task_videos = TaskVideoYoutube::find()->where(['task_id' => $id])->all();
        $task_links = TaskLink::find()->where(['task_id' => $id])->all();
        $task_notes = TaskNote::find()->where(['task_id' => $id])->all();

        return $this->render('view',[
            'task' => $task,
            'task_videos' => $task_videos,
            'task_links' => $task_links,
            'task_notes' => $task_notes
        ]);
    }
    public function actionDelete($id) {

        $task = Task::find()->where(['id' => $id])->one();
        $tasksInMilestone = Task::find()->where(['milestone_id' => $task->milestone_id])->orderBy('sort')->all();
        $task->sort = count($tasksInMilestone) + 1;
        $i = 1;
        foreach($tasksInMilestone as $t) {
            if($t->id != $task->id) {
                $t->sort = $i;
                $t->save(false);
                $i++;
            }
        }
        $task->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    function isValidMd5($md5 ='')
    {
        return preg_match('/^[a-f0-9]{32}$/', $md5);
    }

    public function actionUpdate_video() {
        $post = Yii::$app->request->post();
        if (count($post) > 0) {
            $task_video = TaskVideoYoutube::find()->where(['task_id' => $post['id']])->offset($post['row'] - 1)->one();
            if(!$task_video) {
                $task_video = new TaskVideoYoutube();
                if($this->isValidMd5($post['id'])) {
                    $task_video->task_temp_id = $post['id'];
                }else {
                    $task_video->task_id = $post['id'];
                }
            }
            $task_video->name = $post['name'];
            $task_video->save();
        }

        return json_encode(['success' => true]);
    }
    public function actionDelete_video() {
        $post = Yii::$app->request->post();
        if (count($post) > 0) {
            $task_video = TaskVideoYoutube::find()->where(['task_id' => $post['id']])->offset($post['row'] - 1)->one();
            if($task_video) {
                $task_video->delete();
            }
        }

        return json_encode(['success' => true]);
    }

    public function actionUpdate_link() {
        $post = Yii::$app->request->post();
        if (count($post) > 0) {
            $task_link = TaskLink::find()->where(['task_id' => $post['id']])->offset($post['row'] - 1)->one();
            if(!$task_link) {
                $task_link = new TaskLink();
                if($this->isValidMd5($post['id'])) {
                    $task_link->task_temp_id = $post['id'];
                }else {
                    $task_link->task_id = $post['id'];
                }
            }
            $task_link->name = $post['name'];
            $task_link->save();
        }

        return json_encode(['success' => true]);
    }
    public function actionDelete_link() {
        $post = Yii::$app->request->post();
        if (count($post) > 0) {
            $task_link = TaskLink::find()->where(['task_id' => $post['id']])->offset($post['row'] - 1)->one();
            if($task_link) {
                $task_link->delete();
            }
        }

        return json_encode(['success' => true]);
    }

    public function actionUpdate_note() {
        $post = Yii::$app->request->post();
        if (count($post) > 0) {
            $task_note = TaskNote::find()->where(['task_id' => $post['id']])->offset($post['row'] - 1)->one();
            if(!$task_note) {
                $task_note = new TaskNote();
                if($this->isValidMd5($post['id'])) {
                    $task_note->task_temp_id = $post['id'];
                }else {
                    $task_note->task_id = $post['id'];
                }
            }
            $task_note->name = $post['name'];
            $task_note->save();
        }

        return json_encode(['success' => true]);
    }
    public function actionDelete_note() {
        $post = Yii::$app->request->post();
        if (count($post) > 0) {
            $task_note = TaskNote::find()->where(['task_id' => $post['id']])->offset($post['row'] - 1)->one();
            if($task_note) {
                $task_note->delete();
            }
        }

        return json_encode(['success' => true]);
    }

    function checkUnloadFiles($uploaddir, $info)
    {
        if (!is_dir($uploaddir)) mkdir($uploaddir, 0777, true);

        $error = false;
        if (move_uploaded_file($info['tmp_name'], $uploaddir . basename($info['name']))) {
            $file_name = $info['name'];
        } else {
            $error = true;
        }

        $data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('file' => $file_name);

        exit(json_encode($data));
    }
    function getUnloadFiles($uploaddir, $uploadassets)
    {
        if (!is_dir($uploaddir)) mkdir($uploaddir, 0777, true);
        $result  = array();

        $files = scandir($uploaddir);
        if ( false!==$files ) {
            foreach ( $files as $file ) {
                if ( '.'!=$file && '..'!=$file) {
                    $obj['name'] = $file;
                    $obj['size'] = filesize($uploaddir.$file);
                    $result[] = $obj;
                }
            }
        }
        $data['path'] = $uploadassets;
        $data['files'] = $result;
        header('Content-type: text/json');
        header('Content-type: application/json');
        echo json_encode($data);
    }
    function upload($category, $id)
    {
        $folder_path = Yii::getAlias('@static').'/tasks/'.$id.'/'.$category.'/';
        if (!empty($_FILES)) {
            foreach ($_FILES as $class => $info) {
                $this->checkUnloadFiles($folder_path, $info);
            }
        } else {
            $folder_assets = Yii::$app->params['staticDomain'] . 'tasks/' . $id.'/'.$category.'/';
            $this->getUnloadFiles($folder_path, $folder_assets);
        }
    }
    function delete($category)
    {
        $folder_path = Yii::getAlias('@static').'/tasks/'.Yii::$app->request->post('id').'/'.$category.'/';
        $file = $folder_path.Yii::$app->request->post('file');
        if(Yii::$app->request->post('file')) {
            if(file_exists($file)) {
                unlink($file);
            }
        }
    }

    public function actionUpload_audio() {
        $this->upload('audio', Yii::$app->request->post('id'));
    }
    public function actionDelete_audio() {
        $this->delete('audio', Yii::$app->request->post('id'));
    }
    public function actionUpload_photo() {
        $this->upload('photo', Yii::$app->request->post('id'));
    }
    public function actionDelete_photo() {
        $this->delete('photo', Yii::$app->request->post('id'));
    }
    public function actionUpload_archive() {
        $this->upload('archive', Yii::$app->request->post('id'));
    }
    public function actionDelete_archive() {
        $this->delete('archive', Yii::$app->request->post('id'));
    }
    public function actionUpload_document() {
        $this->upload('document', Yii::$app->request->post('id'));
    }
    public function actionDelete_document() {
        $this->delete('document', Yii::$app->request->post('id'));
    }
}