<?php
/**
 * Created by PhpStorm.
 * User: toozzapc2
 * Date: 13.01.2016
 * Time: 15:09
 */

namespace modules\core\ajaxModel;

use Yii;
use yii\base\Component;

class DynamicData extends Component
{
    public $main_class = 'dynamic_data';
    public $main_title = 'Dynamic Data';
    public $main_model = '';
    public $data_block_view = '';

    public function renderRow($model = null,$is_add = true) {

        return Yii::$app->controller->renderPartial(
            $this->data_block_view,
            [
                'model' => $model,
                'is_add' => $is_add
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
                $result .= $this->renderRow($model, $i == count($models) - 1);
                $i++;
            }
        }
        else {
            $result = $this->renderRow();
        }

        return $result;
    }
    function render() {
        return $this->renderPartial('form_group',[
            'main_class' => $this->main_class,
            'main_title' => $this->main_title,
            'main_content' => $this->renderRows()
        ]);
    }

    public function ajaxAdd() {
        $response['error'] = false;
        $response['html'] = $this->renderRow();
        return (json_encode($response));
    }
    public function ajaxDelete() {
        if($_POST['id'] != 0){
            $main_model = $this->main_model;
            $model = $main_model::find()->where(['id'=>$_POST['id']])->one();
            if($model) {
                $model->delete();
            }
        }
        return json_encode($_POST);
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
        return json_encode($response);
    }
    public function ajax() {
        $command = 'ajax'.ucfirst(Yii::$app->request->post('command'));
        return $this->$command();
    }

    function renderPartial($view, $data = []){
        extract($data);
        ob_start();
        include Yii::getAlias('@modules').'/core/ajaxModel/views/'.$view.'.php';
        return ob_get_clean();
    }
}