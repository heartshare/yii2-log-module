<?php

use yii\db\Migration;

class m151028_112214_log_error extends Migration
{
    public function up()
    {
        $table = \bariew\logModule\models\Error::tableName();
        $this->createTable($table, [
            'id' => $this->primaryKey(),
            'owner_id' => $this->integer(),
            'level' => $this->integer(),
            'category' => $this->string(),
            'log_time' => $this->integer(),
            'prefix' => $this->string(),
            'message' => $this->text(),
        ]);
        $this->createIndex('idx_log_level', $table, 'level');
        $this->createIndex('idx_log_category', $table, 'category');
        return true;
    }

    public function down()
    {
        return $this->dropTable(\bariew\logModule\models\Error::tableName());
    }
}
