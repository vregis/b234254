<?php

use common\modules\core\base\Migration;
use yii\db\Schema;

/**
 * Class m141015_133500_queue
 *
 * @author MrArthur
 * @since 1.0.0
 */
class m141015_133500_queue extends Migration
{
    /** @inheritdoc */
    protected $tableName = '{{%mail_queue}}';

    /** @inheritdoc */
    public function up()
    {
        // create table
        $this->createTable(
            $this->tableName,
            [
                'id' => Schema::TYPE_PK,
                'date_send' => Schema::TYPE_INTEGER,
                'sender' => Schema::TYPE_STRING . ' NOT NULL',
                'receiver' => Schema::TYPE_STRING . ' NOT NULL',
                'subject' => Schema::TYPE_STRING . ' NOT NULL',
                'body' => Schema::TYPE_TEXT,
                'viewPath' => Schema::TYPE_STRING,
                'view' => Schema::TYPE_STRING,
                'params' => Schema::TYPE_TEXT . ' COMMENT "Массив параметров для вьюшки"',
                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
                'status' => 'tinyint(3) NOT NULL DEFAULT 0',
            ],
            $this->tableOptions . ' COMMENT="Очередь писем для крона"'
        );

        // indexes
        $this->createIndex('i_status', $this->tableName, 'status');
    }

    /** @inheritdoc */
    public function down()
    {
        echo "m141015_133500_queue cannot be reverted.\n";
        return false;
    }
}