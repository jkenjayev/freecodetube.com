<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%video}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m210728_094329_create_video_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%video}}', [
            'video_id' => $this->string(16)->notNull(),
            'title' => $this->string(512)->notNull(),
            'video_name' => $this->string(512),
            'has_thumbnail' => $this->boolean(),
            'created_at' => $this->integer(11),
            'updated_at' => $this->integer(11),
            'status' => $this->integer(1),
            'tags' => $this->string(512),
           'description' => $this->text(),
            'created_by' => $this->integer(11),
        ]);
    $this->addPrimaryKey('PK_videos_video_id', '{{%video}}', 'video_id');
        // creates index for column `created_by`
        $this->createIndex(
            '{{%idx-videos-created_by}}',
            '{{%video}}',
            'created_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-videos-created_by}}',
            '{{%video}}',
            'created_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-videos-created_by}}',
            '{{%video}}'
        );

        // drops index for column `created_by`
        $this->dropIndex(
            '{{%idx-videos-created_by}}',
            '{{%video}}'
        );

        $this->dropTable('{{%video}}');
    }
}
