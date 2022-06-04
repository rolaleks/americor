<?php

use app\models\Event;
use yii\db\Migration;

class m220604_101341_create_events_table extends Migration
{

    public $events = [
        ['created_task', 'Task created'],
        ['updated_task', 'Task updated'],
        ['completed_task', 'Task completed'],
        ['outgoing_sms', 'Incoming message'],
        ['incoming_sms', 'Outgoing message'],
        ['customer_change_type', 'Type changed'],
        ['customer_change_quality', 'Property changed'],
        ['outgoing_call', 'Outgoing call'],
        ['incoming_call', 'Incoming call'],
        ['incoming_fax', 'Incoming fax'],
        ['outgoing_fax', 'Outgoing fax'],
    ];

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%event}}', [
            'id' => $this->primaryKey(),
            'event' => $this->string()->notNull()->unique(),
            'title' => $this->string()->notNull(),
        ], $tableOptions);

        $this->dropColumn('{{%history}}', 'event');
        $this->addColumn('{{%history}}', 'event_id', $this->integer()->notNull());
        Yii::$app->db->createCommand()->batchInsert(Event::tableName(), ['event', 'title'], $this->events)->execute();

        $this->addForeignKey('fk_history__user_id', 'history', 'event_id', 'event', 'id', 'RESTRICT', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_history__user_id', 'history');
        $this->dropColumn('{{%history}}', 'event_id');
        $this->dropTable('{{%event}}');
    }

}