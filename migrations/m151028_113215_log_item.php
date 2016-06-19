<?php

use yii\db\Migration;
use bariew\yii2Tools\helpers\MigrationHelper;

class m151028_113215_log_item extends Migration
{
    public function up()
    {
        $this->createTable(\bariew\logModule\models\Item::tableName(), [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'owner_id' => $this->integer(),
            'event' => $this->string(),
            'model_name' => $this->string(),
            'model_id' => $this->string(),
            'message' => $this->text(),
            'created_at' => $this->integer(),
        ]);
    }

    public function down()
    {
        $this->dropTable(bariew\logModule\models\Item::tableName());
    }
}
