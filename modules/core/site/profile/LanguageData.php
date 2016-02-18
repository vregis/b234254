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
use modules\user\models\Language;
use modules\user\models\LanguageSkill;
use modules\user\models\Languages;
use modules\user\models\Skilllist;
use modules\user\models\UserSpecialization;
use Yii;

class LanguageData extends DynamicData
{
    public $main_class = 'language';
    public $main_title = 'Language';
    public $main_content = '';
    public $main_model = '\modules\user\models\Language';

    public $data_block_view = 'blocks/language_row_block';

    public $languages = null;
    public $language_skills = null;

    public function renderRow($model = null, $is_add = true)
    {
        $languages = Language::find()->where(['user_id' => Yii::$app->user->id])->all();
        $string = $this->getSqlString($languages);


        if($model) {
            $key = 'abc';
            $i = 0;
            foreach($languages as $lang){
                if($lang->language == $model->language){
                    $key = $i;
                }
                $i++;
            }
                unset($languages[$key]);

            $sqlstr = $this->getSqlString($languages);

            if($sqlstr == '') {
                $this->languages = Languages::findBySql("SELECT * FROM language GROUP BY Language ORDER BY language = 'English' DESC, language ASC ")->all();
            }else{
                $this->languages = Languages::findBySql("SELECT * FROM language WHERE language NOT IN (" . $sqlstr . ") GROUP BY Language ORDER BY language = 'English' DESC, language ASC ")->all();

            }
        }else{
            if($string == ''){
                $this->languages = Languages::findBySql("SELECT * FROM language GROUP BY Language ORDER BY language = 'English' DESC, language ASC ")->all();
            }else{
                $this->languages = Languages::findBySql("SELECT * FROM language WHERE language NOT IN (".$string.") GROUP BY Language ORDER BY language = 'English' DESC, language ASC ")->all();
            }

        }

        if ($this->language_skills == null) {
            $this->language_skills = LanguageSkill::find()->all();
        }
        return Yii::$app->controller->renderPartial(
            $this->data_block_view,
            [
                'model' => $model,
                'languages' => $this->languages,
                'language_skills' => $this->language_skills,
                'is_add' => $is_add,
            ]
        );
    }

    public function renderRows()
    {
        $main_model = $this->main_model;
        $result = '';
        $models = $main_model::find()->where(['user_id' => Yii::$app->user->id])->all();
        if (count($models) > 0) {
            $i = 0;
            foreach ($models as $model) {


                $result .= $this->renderRow($model, $i == count($models) - 1 && count($models) > 1);
                $i++;
            }
            if (count($models) == 1) {
                $result .= $this->renderRow();
            }
        } else {
            $result = $this->renderRow(null, false);
            $result .= $this->renderRow();
        }

        return $result;
    }

    protected function getSqlString($languages){
        $str = '';
        $i = 0;
        foreach($languages as $lang){
            $i++;
            if(count($languages) > $i) {
                $str .= '"'.$lang->language . '", ';
            }else{
                $str .= '"'.$lang->language.'"';
            }

        }
        return $str;
    }

    public function ajaxUpdate(){
        $main_model = $this->main_model;
        $id = $_POST['id'];
        $key = $_POST['update_key'];

        $response['error'] = false;
        if($id == 0) {
            $model = new $main_model();
            $model->user_id = Yii::$app->user->getId();
            $model->$key = $_POST['update_data'];
            $model->save();
        }
        else {
            $model = $main_model::find()->where(['id' => $_POST['id']])->one();
            if ($model) {
                $model->$key = $_POST['update_data'];
                $model->save();
            }
        }
        if ($model) {
            $response['id'] = $model->getPrimaryKey();
        }
        else {
            $response['error'] = true;
        }
        $response['html'] = $this->renderRows();
        return json_encode($response);
    }
}