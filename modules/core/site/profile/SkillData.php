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
use modules\user\models\LanguageSkill;
use modules\user\models\Languages;
use modules\user\models\Skilllist;
use modules\user\models\Skills;
use modules\user\models\SkillTag;
use modules\user\models\UserSpecialization;
use Yii;

class SkillData extends DynamicData
{
    public $main_class = 'skill';
    public $main_title = 'Skills';
    public $main_content = '';
    public $main_model = '\modules\user\models\Skills';

    public $data_block_view = 'blocks/skill_row_block';

    public $sklist = null;

    function __construct($sklist = null) {
        $this->sklist = $sklist;
    }

    public function renderRow($model = null,$is_add = true) {

        if($this->sklist == null) {
            $this->sklist = Skilllist::find()->all();
        }
        return Yii::$app->controller->renderPartial(
            $this->data_block_view,
            [
                'model' => $model,
                'skill_list' => $this->sklist,
                'is_add' => $is_add,
            ]
        );
    }

    public function renderRows() {
        $main_model = $this->main_model;
        $result = '';
        $models = $main_model::find()->where(['user_id'=>Yii::$app->user->id])->all();
        if(count($models) > 0) {
            $i = 0;
            foreach ($models as $model) {


                $result .= $this->renderRow($model, $i == count($models) - 1 && count($models) > 1);
                $i++;
            }
            if(count($models) == 1) {
                $result .= $this->renderRow();
            }
        }
        else {
            $result = $this->renderRow(null,false);
            $result .= $this->renderRow();
        }

        return $result;
    }

    function getCheckDeleteTag($name) {
        $tag = SkillTag::find()->where(['name' => $name])->one();
        if($tag) {
            $skills_count = Skills::find()->where(['skill_tag' => $tag->id])->count();
            if($skills_count == 0) {
                $tag->delete();
            }
        }
    }
    function getTagFromName($name) {
        $tag = SkillTag::find()->where(['name' => $name])->one();
        if(!$tag) {
            $tag = new SkillTag();
            $tag->name = $name;
            $tag->save();
        }
        return $tag;
    }
    function getTagFromId($id) {
        $tag = SkillTag::find()->where(['id' => $id])->one();
        return $tag;
    }

    public function ajaxDelete() {
        if($_POST['id'] != 0){
            $main_model = $this->main_model;
            $model = $main_model::find()->where(['id'=>$_POST['id']])->one();
            if($model) {
                $old_tag = $this->getTagFromId($model->skill_tag)->name;
                $model->delete();
                $this->getCheckDeleteTag($old_tag);
            }
        }
        return json_encode($_POST);
    }

    public function ajaxUpdate(){
        $main_model = $this->main_model;
        $key = $_POST['update_key'];
        if($key == 'skill_tag') {
            $id = $_POST['id'];
            $response['error'] = false;
            if($id == 0) {
                $model = new $main_model();
                $model->user_id = Yii::$app->user->getId();
                if(isset($_POST['update_data']) && $_POST['update_data'] && $_POST['update_data'] != '') {
                    $model->$key = $this->getTagFromName($_POST['update_data'])->id;
                    $model->save();
                }
            }
            else {
                $model = $main_model::find()->where(['id' => $_POST['id']])->one();
                if ($model) {
                    $old_tag = $this->getTagFromId($model->$key)->name;
                    if(isset($_POST['update_data']) && $_POST['update_data'] && $_POST['update_data'] != '') {
                        $new_tag = $_POST['update_data'];
                        if ($old_tag != $new_tag) {
                            $model->$key = $this->getTagFromName($new_tag)->id;
                            $model->save();
                            $this->getCheckDeleteTag($old_tag);
                        }
                    }
                }
            }
            if ($model) {
                $response['id'] = $model->getPrimaryKey();
            }
            else {
                $response['error'] = true;
            }
            return json_encode($response);
        }
        else {
            return parent::ajaxUpdate();
        }
    }
}