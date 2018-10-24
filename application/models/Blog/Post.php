<?php
namespace application\models\Blog;

use application\behaviors\MetaTagsBehavior;
use application\models\Meta;
use application\models\User;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;

use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Linkable;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * Class Post
 * @package application\models\Blog\Post
 *
 * @property integer $id
 * @property integer $category_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $title
 * @property string $slug
 * @property string $language
 * @property integer $views_counter
 * @property integer $likes_counter
 * @property integer $comments_counter
 * @property string $description
 * @property string $content
 * @property integer $user_id
 * @property string $photo
 * @property integer $status
 *
 * @property Meta $meta
 * @property Category $category
 * @property TagAssignment[] $tagAssignments
 * @property Tag[] $tags
 * @property Comment[] $comments
 * @property PostLike[] $postLikes
 *
 * @mixin ImageUploadBehavior
 */
class Post extends ActiveRecord implements Linkable
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_DEACTIVATED_BY_ADMIN = 2;

    const POST_LANG_RU = 'ru';
    const POST_LANG_EN = 'en';

    public $meta;

    public static function create($categoryId, $title, $slug, $description, $language, $content, Meta $meta) : self
    {
        $post = new self();
        $post->category_id = $categoryId;
        $post->title = $title;
        $post->slug = $slug;
        $post->description = $description;
        $post->language = $language;
        $post->content = $content;
        $post->meta = $meta;
        $post->comments_counter = 0;
        $post->views_counter = 0;
        $post->likes_counter = 0;
        $post->status = self::STATUS_DRAFT;
        return $post;
    }

    public function edit($categoryId, $title, $slug, $description, $language, $content, Meta $meta) : void
    {
        $this->category_id = $categoryId;
        $this->title = $title;
        $this->slug = $slug;
        $this->description = $description;
        $this->language = $language;
        $this->content = $content;
        $this->meta = $meta;
        return;
    }

    public static function getAll() : ActiveDataProvider
    {
        $query = Post::find()->published()->with('category');
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }

    public static function getAllByCategory(ActiveRecord $category) : ActiveDataProvider
    {
        $query = Post::find()
            ->published()
            ->andWhere(['category_id' => $category->id])->with('category');
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }

    public function processViewsCounter() : bool
    {
        $session = \Yii::$app->session;
        if (!isset($session['blog_post_view'])) {
            $session->set('blog_post_view', [$this->id]);
            $this->updateCounters(['views_counter' => 1]);
        } else {
            if (!ArrayHelper::isIn($this->id, $session['blog_post_view'])) {
                $array = $session['blog_post_view'];
                array_push($array, $this->id);
                $session->remove('blog_post_view');
                $session->set('blog_post_view', $array);
                $this->updateCounters(['views_counter' => 1]);
            }
        }
        return true;
    }

    public static function getLast($limit) : array
    {
        return Post::find()->published()->with('category')->orderBy(['id' => SORT_DESC])->limit($limit)->all();
    }

    public static function getPopular($limit) : array
    {
        return Post::find()->published()->with('category')->orderBy(['views_counter' => SORT_DESC])->limit($limit)->all();
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function publish() : void
    {
        if ($this->published()) {
            throw new \DomainException('Post is already published.');
        }

        $this->status = self::STATUS_PUBLISHED;
    }

    public function draft() : void
    {
        if ($this->isDraft()) {
            throw new \DomainException('Post is already draft.');
        }
        $this->status = self::STATUS_DRAFT;
    }

    public function published() : bool
    {
        return $this->status == self::STATUS_PUBLISHED;
    }

    public function isDeactivated() : bool
    {
        return $this->status == self::STATUS_DEACTIVATED_BY_ADMIN;
    }

    public function isDraft() : bool
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function getSeoTitle() : string
    {
        return $this->meta->title ?: $this->title;
    }

    // Tags
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

    public static function getAllByTag(Tag $tag) : ActiveDataProvider
    {
        $query = Post::find()->alias('p')->published('p')->with('category');
        $query->joinWith(['tagAssignments ta'], false);
        $query->andWhere(['ta.tag_id' => $tag->id]);
        $query->groupBy('p.id');

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
        ]);
    }

    public static function getLikeList($userId) : ActiveDataProvider
    {
        return new ActiveDataProvider([
            'query' => Post::find()
                ->alias('p')->published('p')
                ->joinWith('postLikes w', false, 'INNER JOIN')
                ->andWhere(['w.user_id' => $userId]),
            'sort' => false,
        ]);
    }

    public function revokeTags(): void
    {
        $this->tagAssignments = [];
    }

    public function getCategory() : ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getTagAssignments() : ActiveQuery
    {
        return $this->hasMany(TagAssignment::class, ['post_id' => 'id']);
    }

    public function getTags() : ActiveQuery
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])->via('tagAssignments');
    }

    ////////////////////// Comments ///////////////////////////////

    public function addComment($userId, $parentId, $text) : Comment
    {
        $parent = $parentId ? $this->getComment($parentId) : null;
        if ($parent && !$parent->isActive()) {
            throw new \DomainException('Cant add to invalid parent node.');
        }
        $comments = $this->comments;
        $comments[] = $comment = Comment::create($userId, $parent ? $parent->id : null, $text);
        $this->updateComments($comments);
        return $comment;
    }

    public function editComment($id, $parentId, $text) : void
    {
        $parent = $parentId ? $this->getComment($parentId) : null;
        $comments = $this->comments;
        foreach ($comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                $comment->edit($parent ? $parent->id : null, $text);
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Comment not found.');
    }

    public function activateComment($id) : void
    {
        $comments = $this->comments;
        foreach ($comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                $comment->activate();
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Comment not found.');
    }

    public function removeComment($id) : void
    {
        $comments = $this->comments;
        foreach ($comments as $i => $comment) {
            if ($comment->isIdEqualTo($id)) {
                if ($this->hasChildren($comment->id)) {
                    $comment->draft();
                } else {
                    unset($comments[$i]);
                }
                $this->updateComments($comments);
                return;
            }
        }
        throw new \DomainException('Comment not found.');
    }

    public function getComment($id) : Comment
    {
        foreach ($this->comments as $comment) {
            if ($comment->isIdEqualTo($id)) {
                return $comment;
            }
        }
        throw new \DomainException('Comment not found.');
    }

    private function hasChildren($id) : bool
    {
        foreach ($this->comments as $comment) {
            if ($comment->isChildOf($id)) {
                return true;
            }
        }
        return false;
    }

    private function updateComments(array $comments) : void
    {
        $this->comments = $comments;
        $this->comments_counter = count(array_filter($comments, function (Comment $comment) {
            return $comment->isActive();
        }));
    }

    public function getComments() : ActiveQuery
    {
        return $this->hasMany(Comment::class, ['post_id' => 'id']);
    }

    public function getPostLikes() : ActiveQuery
    {
        return $this->hasMany(PostLike::class, ['post_id' => 'id']);
    }

    public static function tableName() : string
    {
        return '{{%blog_posts}}';
    }

    public function setPhoto(UploadedFile $photo) : void
    {
        $this->photo = $photo;
    }

    public static function find() : PostQuery
    {
        return new PostQuery(static::class);
    }

    public function behaviors() : array
    {
        return [
            [
                'class' => 'yii\behaviors\SluggableBehavior',
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'immutable'=> false,
                'ensureUnique' => true
            ],
            'timestamp'=> [
                'class' => 'yii\behaviors\TimestampBehavior',
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at'
            ],
            [
                'class' => 'yii\behaviors\BlameableBehavior',
                'attributes' => [
                    BaseActiveRecord::EVENT_BEFORE_INSERT => 'user_id',
                ]
            ],
            MetaTagsBehavior::class,
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['tagAssignments', 'comments'],
            ],
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'photo',
                'createThumbsOnRequest' => true,
                'filePath' => '@uploadsRoot/origin/posts/[[id]].[[extension]]',
                'fileUrl' => '@uploads/origin/posts/[[id]].[[extension]]',
                'thumbPath' => '@uploadsRoot/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@uploads/cache/posts/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'blog_list' => ['width' => 1000, 'height' => 600],
                    'widget_list' => ['width' => 300, 'height' => 300],
                    'origin' => ['width' => 1000, 'height' => 600],
                    //'origin' => ['processor' => [new WatermarkingService(1024, 768, '@frontend/web/image/logo.png'), 'process']],
                ],
            ],
        ];
    }

    public function getLinks()
    {
        return [
            'self' => Url::to(['post/view', 'id' => $this->id], true),
        ];
    }

    public function extraFields() : array
    {
        return [
            'author' => 'user',
        ];
    }

    public function transactions() : array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }
}
