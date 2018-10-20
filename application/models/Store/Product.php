<?php
namespace application\models\Store;

use application\behaviors\MetaTagsBehavior;
use application\models\Meta;
use application\forms\Store\Product\TagAssignment;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\{ActiveQuery, ActiveRecord};
use yii\web\UploadedFile;

/**
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $category_id
 * @property integer $label_id
 * @property integer $price
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $main_photo_id
 *
 * @property Meta $meta
 * @property Label $label
 * @property Photo[] $photos
 * @property TagAssignment[] $tagAssignments
 * @property Category $category
 */
class Product extends ActiveRecord
{
    public $meta;

    public static function tableName() : string
    {
        return '{{%store_products}}';
    }

    public static function create($labelId, $categoryId, $code, $name, $description, $price, Meta $meta) : self
    {
        $product = new self();
        $product->label_id = $labelId;
        $product->category_id = $categoryId;
        $product->code = $code;
        $product->name = $name;
        $product->description = $description;
        $product->price = $price;
        $product->meta = $meta;
        $product->created_at = time();
        return $product;
    }

    public function edit($labelId, $categoryId, $code, $name, $description, $price, Meta $meta) : void
    {
        $this->label_id = $labelId;
        $this->category_id = $categoryId;
        $this->code = $code;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->meta = $meta;
        $this->updated_at = time();
        return;
    }

    public function getLabel() : ActiveQuery
    {
        return $this->hasOne(Label::class, ['id' => 'label_id']);
    }

    public function getCategory() : ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function behaviors() : array
    {
        return [
            MetaTagsBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['photos', 'tagAssignments'],
            ],
        ];
    }

    /////////////////// Photos ///////////////////////

    public function addPhoto(UploadedFile $file) : void
    {
        $photos = $this->photos;
        $photos[] = Photo::create($file);
        $this->updatePhotos($photos);
    }

    public function removePhoto($id) : void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                unset($photos[$i]);
                $this->updatePhotos($photos);
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function removePhotos() : void
    {
        $this->updatePhotos([]);
    }

    public function movePhotoUp($id) : void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($prev = $photos[$i - 1] ?? null) {
                    $photos[$i - 1] = $photo;
                    $photos[$i] = $prev;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    public function movePhotoDown($id) : void
    {
        $photos = $this->photos;
        foreach ($photos as $i => $photo) {
            if ($photo->isIdEqualTo($id)) {
                if ($next = $photos[$i + 1] ?? null) {
                    $photos[$i] = $next;
                    $photos[$i + 1] = $photo;
                    $this->updatePhotos($photos);
                }
                return;
            }
        }
        throw new \DomainException('Photo is not found.');
    }

    private function updatePhotos(array $photos) : void
    {
        foreach ($photos as $i => $photo) {
            $photo->setSort($i);
        }

        $this->photos = $photos;
        $this->populateRelation('mainPhoto', reset($photos));
    }

    public function getPhotos() : ActiveQuery
    {
        return $this->hasMany(Photo::class, ['product_id' => 'id'])->orderBy('sort');
    }

    public function getMainPhoto() : ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'main_photo_id']);
    }


    /////////////////// Tags ////////////////////////

    public function assignTag($id) : void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $assignment) {
            if ($assignment->isForTag($id)) {
                return;
            }
        }
        $assignments[] = TagAssignment::create($id);
        $this->tagAssignments = $assignments;
    }

    public function revokeTag($id) : void
    {
        $assignments = $this->tagAssignments;
        foreach ($assignments as $i => $assignment) {
            if ($assignment->isForTag($id)) {
                unset($assignments[$i]);
                $this->tagAssignments = $assignments;
                return;
            }
        }
        throw new \DomainException('Assignment is not found.');
    }

    public function revokeTags() : void
    {
        $this->tagAssignments = [];
    }

    public function getTagAssignments() : ActiveQuery
    {
        return $this->hasMany(TagAssignment::class, ['product_id' => 'id']);
    }

    public function getTags() : ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function beforeDelete() : bool
    {
        if (parent::beforeDelete()) {
            foreach ($this->photos as $photo) {
                $photo->delete();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes) : void
    {
        $related = $this->getRelatedRecords();
        parent::afterSave($insert, $changedAttributes);

        if (array_key_exists('mainPhoto', $related)) {
            $this->updateAttributes(['main_photo_id' => $related['mainPhoto'] ? $related['mainPhoto']->id : null]);
        }
    }

}