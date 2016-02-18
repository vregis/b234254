<?php

namespace modules\user\models;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;

/**
 * Class UserSearch
 *
 * @author MrArthur
 * @since 1.0.0
 */
class UserSearch extends User
{
    /**
     * @var string
     */
    public $email;

    /**
     * @var int
     */
    public $created_at;

    /**
     * @var string
     */
    public $registration_ip;

    /** @inheritdoc */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['email', 'registration_ip'], 'safe'],
        ];
    }

    /** @inheritdoc */
    public function attributeLabels()
    {
        return [
            'email' => Yii::t('user', 'E-mail'),
            'created_at' => Yii::t('user', 'Время регистрации'),
            'registration_ip' => Yii::t('user', 'Регистрационный IP'),
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $this->addCondition($query, 'email', true);
        $this->addCondition($query, 'created_at');
        $this->addCondition($query, 'registration_ip');

        return $dataProvider;
    }

    /**
     * @param Query $query
     * @param string $attribute
     * @param bool $partialMatch
     */
    protected function addCondition($query, $attribute, $partialMatch = false)
    {
        $value = $this->$attribute;
        if (trim($value) === '') {
            return;
        }
        if ($attribute == 'registration_ip') {
            $value = ip2long($value);
        }
        if ($partialMatch) {
            $query->andWhere(['like', $attribute, $value]);
        } else {
            $query->andWhere([$attribute => $value]);
        }
    }
}
