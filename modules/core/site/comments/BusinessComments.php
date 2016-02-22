<?php
namespace modules\core\site\comments;

use modules\core\base\Controller;
use modules\departments\models\BusinessCommentary;
use modules\user\models\ProfileCommentary;
use yii\base\Component;
use yii;

class BusinessComments extends Component{

    public $text;
    public $user_id;


    public function addComment($text, $user_id){

        $model= new BusinessCommentary();
        $model->text = $text;
        $model->user_id = $user_id;
        $model->sender_id = Yii::$app->user->id;
        $model->time = time();
        $model->save();
    }

    public function render($id, $index = 0){
        $comments = BusinessCommentary::find()
            ->select('business_commentary.*, user_profile.avatar as ava, user_profile.first_name as fn, user_profile.last_name as ln, user_profile.user_id as uid')
            ->join('LEFT JOIN', 'user_profile', 'user_profile.user_id = business_commentary.sender_id')
            ->where(['business_commentary.user_id' => $id])
            ->orderBy(['business_commentary.time' => SORT_DESC])->limit(5)->offset(($index)*5)
            ->all();
        $count = $this->getCount($id);
        $html = Yii::$app->controller->renderPartial('@modules/departments/site/views/business/blocks/comments', ['comments' => $comments, 'count' => $count, 'user_id' => $id, 'index' => $index]);
        return $html;
    }

    public function getCount($id){
        $comm = $comments = BusinessCommentary::find()->where(['user_id' => $id])->all();
        return count($comm);
    }


}
?>