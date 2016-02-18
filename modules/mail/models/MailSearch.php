<?php

namespace common\modules\mail\models;

use Yii;
use yii\data\ActiveDataProvider;

/**
 * Class MailSearch
 *
 * @author MrArthur
 * @since 1.0.0
 */
class MailSearch extends Queue
{
    /** @inheritdoc */
    public function rules()
    {
        return [
            [['id', 'created_at', 'date_send', 'status'], 'integer'],
            [['sender', 'receiver', 'subject', 'body', 'view'], 'safe'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Queue::find()->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(
            [
                'id' => $this->id,
                'created_at' => $this->created_at,
                'date_send' => $this->date_send,
                'status' => $this->status,
            ]
        );

        $query->andFilterWhere(['like', 'sender', $this->sender])
            ->andFilterWhere(['like', 'receiver', $this->receiver])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'view', $this->view]);

        return $dataProvider;
    }
}
