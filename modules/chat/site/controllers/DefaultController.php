<?php

namespace modules\chat\site\controllers;

use modules\core\site\base\Controller;
use Yii;
use yii\filters\AccessControl;
use modules\user\models\User;
use modules\chat\models\Message;
use modules\user\models\Online;
use modules\core\helpers\TextHelper;
use modules\chat\models\Group;
use modules\chat\models\MessageCommon;
use modules\chat\models\Group_members;
use modules\chat\models\Group_messages;
use modules\chat\models\GroupView;
use modules\chat\models\GroupAlternativeName;
use modules\chat\models\Friend;
use yii\helpers\StringHelper;
use yii\db\Query;

class DefaultController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => [
                            'search-friends',
                            'search-users',
                            'change-color',
                            'get-last-dialog',
                            'get-all-dialog',
                            'get-friends-dialog',
                            'make-friend-best',
                            'get-dialog-with-user',
                            'send-form',
                            'add-user-to-friend',
                            'delete-dialog',
                            'block-user',
                            'unblock-user',
                            'get-message-quantity',
                            'edit-group-name',
                            'add-new-group',
                            'delete-group-name',
                            'add-user-to-group',
                            'get-members-of-group',
                            'get-dialog-by-group',
                            'send-message-to-group',
                            'delete-user-from-group',
                            'refresh-group',
                            'refresh-group-dialog-by-gropname',
                            'common-chat',
                            'send-message-to-common-chat',
                            'is-my-group',
                            'send-letter-to-team-members',
                            'get-dialog-with-user-from-archive',
                            'get-dialog-with-group-from-archive',
                            'get-dialog-with-main-chat-archive'
                        ],
                        'roles' => ['@', '?']
                    ],
                    // архивирование
                    [
                        'allow' => true,
                        'actions' => ['add-to-archive'],
                        'roles' => ['@']
                    ]
                ],
            ],
        ];
    }

    /*
     * Поиск по имеющтмя друзьям
     */

    public function actionSearchFriends() {
        $exp = Yii::$app->request->post('expresion');
        if ($exp != '') {
            $model = Friend::find()->where(['like', 'name', $exp])->andWhere(['user_id' => Yii::$app->user->id, 'not_friend' => 0])->all();
//vd($model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderAjax('search-result-friends', ['model' => $model]);
        } else
            return false;
    }

    /*
     * Поиск по всем пользователям
     */

    public function actionSearchUsers() {
        $exp = Yii::$app->request->post('expresion');
        if ($exp != '') {
            $model = User::find()->where(['like', 'username', $exp])->all();
//vd($model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $this->renderAjax('search-result-users', ['model' => $model]);
        } else
            return false;
    }

    /*
     * Изменяет видимость пользователя
     */

    public function actionChangeColor() {
        $color = Yii::$app->request->post('color');
        $model = Friend::find()->where(['user_id' => Yii::$app->user->id])->one();
        if($model) {
            $model->is_visible = $color;
            $model->updateAttributes(['is_visible']);
        }
    }

    /*
     * вывести последние диалоги
     */

    public function actionGetLastDialog() {
        $quantityLastDialog = Yii::$app->params['quantityLastDialog'];
        //********************************************************
        $model = Friend::find()
                ->where(['user_id' => Yii::$app->user->id, 'kill_dialog' => 0])
                ->orderBy('created_at DESC')
                ->limit($quantityLastDialog)
                ->all();

        $userMod = Yii::$app->getModule('user');
        $i=0;
        foreach ($model as $friend) {
            $id = $friend->friend_id;
            $result['freand'][$id]['status'] = Online::getStatus($friend->friend_id);
            if($result['freand'][$id]['status'] == true){
                $i++;
            }
            $result['freand'][$id]['count_new_message'] = Message::getMessagesNotRediedYet($friend->friend_id);
            $result['freand'][$id]['user_name'] = StringHelper::truncate(User::getFullNameById($friend->friend_id), 20);
            $result['freand'][$id]['favorit'] = Friend::getFavorit($friend->friend_id);
            $result['freand'][$id]['img'] = $userMod->getAvatarUrl($friend->friend_id);
        }
        $result['status'] = $i;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
        //********************************************************
        /*
        $arrResult = [];
        $i = 0;

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arrResult['data'] = $this->renderAjax('search-result-dialog', ['model' => $model]);
        //Получить количество онлайн
        foreach ($model as $user) {
            $res = \common\modules\user\models\Online::getStatus($user->friend_id);
            if ($res == true) {
                $i++;
            }
        }
        $arrResult['countOnline'] = $i;
        return $arrResult;
        */
    }

    /*
     * вывести все диалоги
     */

    public function actionGetAllDialog() {
        /*$arrResult = [];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax('//layouts/_partial/_chat-all-friend');
        */

        // Выбираем всех друзей из базы
        $friend_model = Friend::getModelByUserId(Yii::$app->user->id);
        $i = 0;
        $nomer = 0;
        $userMod = Yii::$app->getModule('user');
        foreach ($friend_model as $friend) {
            $id = $friend->friend_id;
            $result['freand'][$nomer]['status'] = Online::getStatus($friend->friend_id);
            if($result['freand'][$nomer]['status'] == true){
                $i++;
            }
            $result['freand'][$nomer]['id'] = $id;
            $result['freand'][$nomer]['created_at'] = $friend->created_at;
            $result['freand'][$nomer]['count_new_message'] = Message::getMessagesNotRediedYet($friend->friend_id);
            $result['freand'][$nomer]['user_name'] = StringHelper::truncate(User::getFullNameById($friend->friend_id), 20);
            $result['freand'][$nomer]['favorit'] = Friend::getFavorit($friend->friend_id);
            $result['freand'][$nomer]['img'] = $userMod->getAvatarUrl($friend->friend_id);
            $nomer++;
        }
        $result['status'] = $i;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }

    /*
     * вывести все диалоги c друзьями
     */

    public function actionGetFriendsDialog() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax('//layouts/_partial/_chat-friends');
    }

    public function actionMakeFriendBest() {
        $result = [];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $val = Yii::$app->request->post('val');
//vd($id.$val);
        $model = Friend::find()->where(['user_id' => yii::$app->user->id, 'friend_id' => $id])->one();
        if (!empty($model)) {
            if ($val == 'yes') {
                $model->is_favorite = 1;
                $model->updateAttributes(['is_favorite']);
                $result['a'] = 'yes';
                return $result;
            } else {
                $model->is_favorite = 0;
                $model->updateAttributes(['is_favorite']);
                $result['a'] = 'no';
                return $result;
            }
        } else {
//'Этот польхователь не в друзьях , нужно его прописать в друзья со статусом еще не друг
            $model = new Friend;
            $model->user_id = Yii::$app->user->id;
            $model->friend_id = $id;
            $model->name = User::getFullNameById($id);
            $model->not_friend = 1;
            $model->is_favorite = 1;
            $model->save();
            $result['a'] = 'yes';
            return $result;
        }
    }

// Вывожу диалог с пользователем по id
    public function actionGetDialogWithUser() {
        $id = Yii::$app->request->post('id');
        $status = Online::getStatus($id);
        $IsFiendOfMine = Friend::getIsFriendOfMine($id);
        $IsBloked = Friend::getIsBlokedUser($id);

        $model = Message::find()->where(['sender_id' => yii::$app->user->id, 'receiver_id' => $id])
                ->orWhere(['sender_id' => $id, 'receiver_id' => yii::$app->user->id])
                ->orderBy(['id' => SORT_DESC])
                ->limit(5)
                ->asArray()
                ->all();

//делаю сообщения просмотренными
        $this->MakeMessagesOfUserRead($id);

        $this->MakeUserMessasgesViewedByUserId($id);





        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax('get-dialog-with-user', ['model' => $model,
                    'id' => $id,
                    'status' => $status,
                    'IsFiendOfMine' => $IsFiendOfMine,
                    'IsBloked' => $IsBloked]);
    }

// Отправка сообщения пользователю по id получателя
    public function actionSendForm() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $message = Yii::$app->request->post('message');
        if ($message == '' || $message == ' ') {
            return false;
        }
        $id = Yii::$app->request->post('id');
//vd($id);
// проверка на блокировку
        $isBloked = Friend::getIsBlokedUser($id);
        $isIamBlokedByUser = Friend::isIamBlokedByUser($id);
//vd($isIamBlokedByUser);
//vd('I block him: '. $isBloked .'  /  '.' he block Me: '. $isIamBlokedByUser);
// Если он меня заблокировал 
        if ($isIamBlokedByUser == true) {
            Yii::$app->session->setFlash(
                    'error', Yii::t('message', 'Диалога с пользователем {username} невозможен, пользователь заблокировал вам эту возможность', ['username' => User::getFullNameById($id)])
            );
            $arr = [];
            $arr['sender_id'] = $id;
            return $this->renderAjax('you-blocked-by-user', ['model' => $arr]);
        }
// Если я его заблокировал 
        if ($isBloked == true) {
            Yii::$app->session->setFlash(
                    'error', Yii::t('message', 'Диалога с пользователем {username} невозможен, <a href="javascript:void(0);" onclick="Chat.UnblockUser(' . $id . ')">Разблокировать</a>', ['username' => User::getFullNameById($id)])
            );
            $arr = [];
            $arr['sender_id'] = $id;
            return $this->renderAjax('you-block-him', ['model' => $arr]);
        }
        $model = new Message();
        $model->receiver_id = $id;
        $model->sender_id = Yii::$app->user->id;
        $model->message = htmlspecialchars(TextHelper::smartWordwrap($message));
        $model->status = '0';
//$model->validate();
//vd($model->getErrors());   
        $model->save();



        $this->addDataToFriends(Yii::$app->user->id, $id);

        return $this->renderAjax('append-one-message', ['model' => $model]);
    }

// Добавление пользователя в друзья
    public function actionAddUserToFriend() {
        $id = Yii::$app->request->post('id');
//Поиск дубликата
        $model = Friend::find()->where(['user_id' => Yii::$app->user->id, 'friend_id' => $id])->one();
        if (!empty($model)) {
//вывести эексептион
            $model->kill_dialog = 0;
            $model->updateAttributes(['kill_dialog']);
        } else {
            $model = new Friend();
            $model->user_id = Yii::$app->user->id;
            $model->friend_id = $id;
            $model->name = User::getFullNameById($id);
//$model->validate();
//vd($model->getErrors());
            $model->save();
        }

        $model = Friend::find()->where(['user_id' => $id, 'friend_id' => Yii::$app->user->id])->one();
        if (!empty($model)) {

        } else {
            $model = new Friend();
            $model->not_friend = 1;
            $model->user_id = $id;
            $model->friend_id = Yii::$app->user->id;
            $model->name = User::getFullNameById($id);
            $model->save();
        }


        /*   Yii::$app->session->setFlash(
                   'error', Yii::t('message', 'Пользователь {username} добавлен в список друзей', ['username' => User::getFullNameById($id)]));
        */
    }

// Удаление диалога с пользователем
    public function actionDeleteDialog() {
        $id = trim(Yii::$app->request->post('id'));
//vd($id);
        $model = Friend::find()
                ->where(['user_id' => Yii::$app->user->id, 'friend_id' => $id])
                ->one();
        if (!empty($model)) {
            $model->kill_dialog = 1;
            $model->updateAttributes(['kill_dialog']);
           /* Yii::$app->session->setFlash(
                    'error', Yii::t('message', 'Диалога с пользователем {username} удален', ['username' => User::getFullNameById($id)])
            );*/
        } else {
            /*Yii::$app->session->setFlash(
                    'error', Yii::t('message', 'Диалога с пользователем {username} пуст', ['username' => User::getFullNameById($id)])
            );*/
        }
    }

// Блокировка пользователя
    public function actionBlockUser() {
        $id = trim(Yii::$app->request->post('id'));
        $model = Friend::find()->where(['user_id' => Yii::$app->user->id, 'friend_id' => $id])->one();
        $model->is_blocked = 1;
        $model->save();
        $arrResult['status'] =1;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $arrResult;
        /*Yii::$app->session->setFlash(
                'error', Yii::t('message', 'Вы заблокировали возможность пользователю {username} отправлять вам сообщения', ['username' => User::getFullNameById($id)])
        );*/
    }

// Разблокировка пользователя
    public function actionUnblockUser() {
        $id = trim(Yii::$app->request->post('id'));
//vd($id);
        $model = Friend::find()->where(['user_id' => Yii::$app->user->id, 'friend_id' => $id])->one();
//vd($model);
        $model->is_blocked = 0;
        $model->updateAttributes(['is_blocked']);
        $arrResult['status'] =1;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $arrResult;
       /* Yii::$app->session->setFlash(
                'error', Yii::t('message', 'Вы дали возможность пользователю {username} отправлять вам сообщения', ['username' => User::getFullNameById($id)])
        );*/
    }

// Редактировать имя группы
    public function actionEditGroupName() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $arrResult = [];
        $id = trim(Yii::$app->request->post('id'));
        $name = trim(Yii::$app->request->post('name'));

//*********************************************************************************
////если это чужая группа то создать альтернативное имя
//1 узнать чья это группа
        $result = Group::Is_my($id);
        if ($result == false) {
//чужая
//Если есть имя . то перезаписать
            $model = GroupAlternativeName::find()->where(['group_id' => $id, 'user_id' => Yii::$app->user->id])->one();
            if (!empty($model)) {
                $model->alternative_name = $name;
                $model->updateAttributes(['alternative_name']);
            }
            else {
// если еще нет альтернативного имени
                $model = new GroupAlternativeName();
                $model->group_id = $id;
                $model->alternative_name = $name;
                $model->user_id = Yii::$app->user->id;
                $model->save();
            }
        } else {
//*********************************************************************************
            $model = Group::find()->where(['id' => $id])->one();
            $model->name = $name;
            $model->save();
        }
        $arrResult['name'] = $name;
        $arrResult['id'] = $id;
        return $arrResult;
    }

// Создать имя группы
    public function actionAddNewGroup() {
        $arrResult = [];
        $quant = (int) Group_members::find()->where(['member_id' => Yii::$app->user->id])->count();
//vd($quant);
        $name = User::getFullNameById(Yii::$app->user->id) . '-' . ($quant + 1);
        $model = new Group;
        $model->name = $name;
        $model->author_id = Yii::$app->user->id;

//$model->validate();
//vd($model->getErrors());
        $model->save();

        $_model = new Group_members;
        $_model->group_id = $model->id;
        $_model->member_id = Yii::$app->user->id;
        $_model->is_deleted = 0;
//$model->validate();
//vd($model->getErrors());
        $_model->save();
        $arrResult['name'] = $name;
        $arrResult['group_id'] = $model->id;
        $arrResult['append'] = $this->renderAjax('append-new-group', ['group' => $model]);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $arrResult;
    }

// Удалить себя из группы 
    public function actionDeleteGroupName() {
        $id = trim(Yii::$app->request->post('id'));
//vd($id);
// Псевдо удаление из группы
        $model = Group_members::find()->where(['group_id' => $id, 'member_id' => Yii::$app->user->id])->one();
//vd();
        if($model){
        $model->is_deleted = 1;
//$model->validate();
//vd($model->getErrors());
        $model->updateAttributes(['is_deleted']);
            $result['status'] = TRUE;
        }else{
            $result['status'] = FALSE;
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;

// Простое удаление группы
//Group::deleteAll(['id' => $id]);
//Group_members::deleteAll(['group_id' => $id]);
//Group_messages::deleteAll(['group_id' => $id]);
//vd($name);
    }

// Добавление пользователя в группу
    public function actionAddUserToGroup() {
        $arrResult = [];
        $id = Yii::$app->request->post('id');
        $group_id = trim(Yii::$app->request->post('group_id'));
//$model = Group::find()->where(['id' => $group_id])->one();
//$group_name = $model->name;
//vd($group_id);
// Проверка на дубликаты
        $model = Group_members::find()->where(['group_id' => $group_id, 'member_id' => $id])->all();
        if (count($model) > 0) {
            $arrResult['status'] = 'bad';
        } else {
            $model = new Group_members;
            $model->group_id = $group_id;
            $model->member_id = $id;
//$model->validate();
//vd($model->getErrors());
            $model->save();
            $arrResult['status'] = 'ok';
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $arrResult;
    }

// Вывести список членов группы
    public function actionGetMembersOfGroup() {
        $id = Yii::$app->request->post('id');
        $model = Group_members::find()->where(['group_id' => $id, 'is_deleted' => 0])->all();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax('get-members-of-group', ['model' => $model, 'id' => $id]);
    }

// Вывести диалог группы
    public function actionGetDialogByGroup() {
        $id = Yii::$app->request->post('id');

        $model = Group_messages::find()
                ->where(['group_id' => $id])
                ->orderBy(['id' => SORT_DESC])
                ->limit(20)
                ->asArray()
                ->all();

//******************** количество сообщений в группе *****************************************  
        $count_all_message = Group::find()->where(['id' => $id])->one();
        $groupQuantityMessage = $count_all_message->count_message;

//******************** проверка о наличии группы *****************************************
        $modelView = GroupView::find()->where(['group_id' => $id, 'user_id' => Yii::$app->user->id])->one();
        if (empty($modelView)) {
            $modelView = new GroupView();
            $modelView->group_id = $id;
            $modelView->user_id = Yii::$app->user->id;
            $modelView->view = $groupQuantityMessage;
            $modelView->save();
        } else {
            $modelView->view = $groupQuantityMessage;
            $modelView->updateAttributes(['view']);
        }
        // Вывести диалог группы
        $group_dialog = $this->renderAjax('get-dialog', ['model' => $model]);

        // Вывести список группы
        $model = Group_members::find()->where(['group_id' => $id, 'is_deleted' => 0])->all();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $grooups_spisok = $this->renderAjax('get-members-of-group', ['model' => $model, 'id' => $id]);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $result['ismygroups'] = Group::Is_my($id);
        $result['groups_spisok'] =$grooups_spisok;
        $result['dialog'] =$group_dialog;
        $result['name'] = Group::getGroupNameById($id);
        return $result;
    }

// Добавить сообщение группе
    public function actionSendMessageToGroup() {

        $group_id = trim(Yii::$app->request->post('group_id'));
        $message = trim(Yii::$app->request->post('message'));



        // 1 УЗНАТЬ ТЕКУЩЕЕ КОЛИЧЕСТВО СООБЩЕНИЙ
        $model = Group::find()->where(['id' => $group_id])->one();
        $q = $model->count_message;
        $count_all_message = $q + 1;
        $model->count_message = $count_all_message;
        $model->updateAttributes(['count_message']);

        $modelView = GroupView::find()->where(['group_id' => $group_id, 'user_id' => Yii::$app->user->id])->one();
        if ($modelView) {
            $modelView->view = $count_all_message;
        } else {
            $modelView = new GroupView();
            $modelView->group_id = $group_id;
            $modelView->user_id = Yii::$app->user->id;
            $modelView->view = $count_all_message;

            $modelView->save();
        }
        $model = new Group_messages;
        $model->group_id = $group_id;
        $model->sender_id = Yii::$app->user->id;
        $model->message = $message;
        $model->save();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax('append-one-message', ['model' => $model]);
    }

    // Удаление пользователя из группы
    public function actionDeleteUserFromGroup() {
        $group_id = trim(Yii::$app->request->post('group_id'));
        $user_id = trim(Yii::$app->request->post('id'));
        $_model = Group_members::find()->where(['member_id' => $user_id, 'group_id' => $group_id])->one();
        if (!empty($_model)) {
            $_model->delete();
        }
    }

    // Обновить список групп
    public function actionRefreshGroup() {
        // Выбираем всех друзей из базы
        $result =false;
        $model_group = Group_members::getGroupsById(Yii::$app->user->id);

        foreach ($model_group as $group) {
            $id = $group->group_id;
            $result['group'][$id]['count_new_message'] = GroupView::getMessageQuantityByGroupId($group->group_id);
            $result['group'][$id]['img'] = '/images/group.jpg';
            $result['group'][$id]['group_name'] = Group::getGroupNameById($group->group_id);
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $result;
    }

// Обновить диалг группы 
    public function actionRefreshGroupDialogByGropname() {
        $arr = [];
        $group_id = trim(Yii::$app->request->post('group'));

// Записывает в базе сколько он прочитал сообщений
        $model = Group::find()->where(['id' => $group_id])->one();
        $count_all_message = $model->count_message;
        $model = GroupView::find()->where(['group_id' => $group_id, 'user_id' => Yii::$app->user->id])->one();
        $q = $model->view;
        $model->view = $count_all_message;
        $model->updateAttributes(['view']);

//vd($group_name);
        $model = Group_messages::find()
                ->where(['group_id' => $group_id])
                ->orderBy('created_at ASC')
                ->all();
//vd($model);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $arr['code'] = $this->renderAjax('get-dialog', ['model' => $model]);
        $arr['group_id'] = $group_id;

        return $arr;
    }

    public static function MakeMessagesOfUserRead($id) {
        Message::updateAll(['status' => 1], ['receiver_id' => Yii::$app->user->id, 'sender_id' => $id, 'status' => 0]);
        return false;
    }

// Возвращает количество сообщений каждые 3 сек
    public function actionGetMessageQuantity() {
        $arrResult = [];
        $arrResult['messageQuantity'] = Message::getMessageQuantity();
        $arrResult['messageGroupQuantity'] = Message::getGroupMessageQuantity();
        $arrResult['messageСommon'] = Message::getMessageCommonQuantity();
        $arrResult['totalMembersQuantity'] = Group_members::getTotalMembers();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $arrResult;
    }

// Возвращает общий чат
    public function actionCommonChat() {
        $model = MessageCommon::find()
                ->orderBy(['id' => SORT_DESC])
                ->limit(20)
                ->asArray()
                ->all();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax('get-common-chat', ['model' => $model]);
    }

// Отправка сообщения в общий чат
    public function actionSendMessageToCommonChat() {
        $message = Yii::$app->request->post('message');
        $model = new MessageCommon;
        $model->sender_id = Yii::$app->user->id;
        $model->message = $message;
        $model->status = 0;
        $model->save();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $this->renderAjax('append-one-message-to-common-chat', ['model' => $model]);
    }

// Проверка чья группа
    public function actionIsMyGroup() {
        $arr = [];
        $group_id = Yii::$app->request->post('id');

        $result = Group::Is_my($group_id);
        $arr['result'] = $result;
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $arr;
    }

    /*
     * Отправка письма всем членам команды 
     */

    public function actionSendLetterToTeamMembers() {
        $team_id = Yii::$app->request->post('team_id');
        $message = Yii::$app->request->post('message');
//vd($subject . $message . $team_id);
        $group_id = Team::getGroupIdByTeamId($team_id);
        $model = new Group_messages();
        $model->group_id = $group_id;
        $model->sender_id = Yii::$app->user->id;
        $model->message = $message;
        $model->status = 0;
        $model->save();

// 1 УЗНАТЬ ТЕКУЩЕЕ КОЛИЧЕСТВО СООБЩЕНИЙ
        $model = Group::find()->where(['id' => $group_id])->one();
        $q = $model->count_message;
        $q = $q + 1;
        $model->count_message = $q;
        $model->updateAttributes(['count_message']);

//2 олег мутит
        $model = GroupView::find()->where(['group_id' => $group_id, 'user_id' => Yii::$app->user->id])->one();
//$q = $model->view;
//$q = $q + 1;
        $model->view = $q;
        $model->updateAttributes(['view']);



        Yii::$app->session->setFlash('error', Yii::t('message', ' Ваша собщение успешно отправленно'));
        return $this->redirect('/team/index');
    }

//Добавление даты в Friend при отправки сообщения
    public function addDataToFriends($sender_id, $receiver_id) {
//vd($sender_id . ' | '.$receiver_id);
//
        // Занесение +1 в Friend -> COUNT_MESSAGE               

        $model = Friend::find()
                ->where(['user_id' => $sender_id, 'friend_id' => $receiver_id])
                ->orWhere(['user_id' => $receiver_id, 'friend_id' => $sender_id])
                ->all();
        if ($model) {
            foreach ($model as $row) {
                $row->count_message_all = $row->count_message_all + 1;
                $row->created_at = time();
                $row->updateAttributes(['created_at', 'count_message_all']);
            }
        } else {
            //Создать двух друзей со статусои еще не друзья
            $time = time();
            $model = new Friend();
            $model->user_id = $sender_id;
            $model->friend_id = $receiver_id;
            $model->name = User::getFullNameById($receiver_id);
            $model->not_friend = 1;
            $model->created_at = $time;
            $model->count_message_all = 1;
            $model->save();

            $model = new Friend();
            $model->user_id = $receiver_id;
            $model->friend_id = $sender_id;
            $model->name = User::getFullNameById($sender_id);
            $model->not_friend = 1;
            $model->created_at = $time;
            $model->count_message_all = 1;
            $model->save();
        }
        $this->MakeUserMessasgesViewedByUserId($receiver_id);
    }

    // Делаю сообщения просмотренными  
    public function MakeUserMessasgesViewedByUserId($friend_id) {
        $model = Friend::find()
                ->where(['user_id' => Yii::$app->user->id, 'friend_id' => $friend_id])
                ->one();
        if ($model) {
            $count_message_all = $model->count_message_all;
            $model->count_message_view = $count_message_all;
            $model->updateAttributes(['count_message_view']);
        }
        return false;
    }

    public function actionAddToArchive() {
        $model = Message::find()->where(['created_at ='])->all();
        vd('archive');
    }

    // Подгружаю в диалог с пользователем дополнительные сообщения из архива по use_id time
    public function actionGetDialogWithUserFromArchive() {
        $arrResult=[];
        $user_id = Yii::$app->request->post('user_id');
        $time = Yii::$app->request->post('time');
        //vd($user_id. ' | '.$time );
        if ($user_id && $time){
            $sql = '`created_at` < '.$time.' AND `sender_id` = ' . $user_id . '  AND `receiver_id` = ' . Yii::$app->user->id
             . ' OR `created_at` < '.$time.' AND  `sender_id` = ' . Yii::$app->user->id . ' AND  `receiver_id` = ' . $user_id . ' ORDER BY `created_at` DESC  limit 15';
            $model = Message::find()
                    ->where($sql)
                    ->asArray()
                    ->all();
            //vd($model);
            asort($model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $arrResult['html'] = $this->renderAjax('add-user-dialog-from-archive',['model' => $model]);
            $arrResult['count'] = count($model);
            return $arrResult;
           
        } 
            return false;
    }

    // Подгружаю в диалог с группой дополнительные сообщения из архива по group_id time
    public function actionGetDialogWithGroupFromArchive() {
        $arrResult=[];
        $group_id = Yii::$app->request->post('group_id');
        $time = Yii::$app->request->post('time');

        if ($group_id){
            $sql = '`group_id` = '.$group_id.'  AND `created_at` < '.$time.' ORDER BY `id` DESC  limit 15';
            $model = Group_messages::find()
                ->where($sql)
                ->asArray()
                ->all();
            //vd($model);
            asort($model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $arrResult['html'] = $this->renderAjax('get-dialog-arxive',['model' => $model]);
            $arrResult['count'] = count($model);
            return $arrResult;
        }
        return false;
    }

    // Подгружаю в диалог с пользователем дополнительные сообщения из архива по time
    public function actionGetDialogWithMainChatArchive() {
        $arrResult=[];
        $time = Yii::$app->request->post('time');

        if ($time){
            $sql = '`created_at` < '.$time.' ORDER BY `id` DESC  limit 30';
            $model = MessageCommon::find()
                ->where($sql)
                ->asArray()
                ->all();
            //vd($model);
            asort($model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $arrResult['html'] = $this->renderAjax('get-common-chat-arxive',['model' => $model]);
            $arrResult['count'] = count($model);
            return $arrResult;

        }
        return false;
    }
}