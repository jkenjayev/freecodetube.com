<?php

namespace common\models;

use common\models\query\VideoQuery;
use Imagine\Image\Box;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $video_name
 * @property int|null $has_thumbnail
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $status
 * @property string|null $tags
 * @property string|null $description
 * @property int|null $created_by
 *
 * @property User $createdBy
 */
class Video extends ActiveRecord
{
    const STATUS_UNLISTED = 0;
    const STATUS_PUBLISHED = 1;


    /**
     * @var UploadedFile
     */
    public $video;

    /**
     * @var UploadedFile
     */
    public $thumbnail;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'title'], 'required'],
            [['has_thumbnail', 'created_at', 'updated_at', 'status', 'created_by'], 'integer'],
            [['description'], 'string'],
            [['video_id'], 'string', 'max' => 16],
            [['title', 'video_name', 'tags'], 'string', 'max' => 512],
            [['video_id'], 'unique'],
            ['thumbnail', 'image', 'minWidth' => 1280],
            ['video', 'file', 'extensions' => ['mp4']],
            ['has_thumbnail', 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_UNLISTED],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    public function getStatusLabels() {
        return [
            self::STATUS_UNLISTED => 'unlisted',
            self::STATUS_PUBLISHED => 'published'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'video_name' => 'Video Name',
            'has_thumbnail' => 'Has Thumbnail',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'tags' => 'Tags',
            'description' => 'Description',
            'created_by' => 'Created By',
            'thumbnail' => 'Thumbnail'
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /* @return ActiveQuery */
    public function getViews() {
        return  $this->hasMany(VideoView::class, ['video_id' => 'video_id']);
    }

    /**
     * {@inheritdoc}
     * @return VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VideoQuery(get_called_class());
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $insert = $this->isNewRecord;
        if($insert) {
            $this->video_id = Yii::$app->security->generateRandomString(8);
            $this->title = $this->video->name;
            $this->video_name = $this->video->name;

        }
        if($this->thumbnail) {
            $this->has_thumbnail = 1;

        }

        $saved = parent::save($runValidation, $attributeNames);
        if(!$saved) {
            return false;
        }

        if($insert) {
            $videoPath = Yii::getAlias('@frontend/web/storage/videos/'.$this->video_id.'.mp4');
            if(!is_dir($videoPath)) {
                FileHelper::createDirectory(dirname($videoPath));
            }

            $this->video->saveAs($videoPath);
        }

        if($this->thumbnail) {
            $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbnails/'.$this->video_id.'.jpg');
            if(!is_dir($thumbnailPath)) {
                FileHelper::createDirectory(dirname($thumbnailPath));
            }

            $this->thumbnail->saveAs($thumbnailPath);
            Image::getImagine()
                ->open($thumbnailPath)
                ->thumbnail(new Box(1280, 1280))
                ->save();
        }

        return true;
    }

    public function getVideoLink() {
        return Yii::$app->params['frontendUrl'].'storage/videos/'.$this->video_id.'.mp4';
    }

    public function getThumbnailLink() {
        return $this->has_thumbnail ?
            Yii::$app->params['frontendUrl'].'storage/thumbnails/'.$this->video_id.'.jpg'
            : '';
    }

    public function afterDelete()
    {
        parent::afterDelete();
        $thumbnailPath = Yii::getAlias('@frontend/web/storage/thumbnails/'.$this->video_id.'.jpg');
        $videoPath = Yii::getAlias('@frontend/web/storage/videos/'.$this->video_id.'.mp4');
        unlink($videoPath);
        if(file_exists($thumbnailPath)) {
            unlink($thumbnailPath);
        }
    }
}
