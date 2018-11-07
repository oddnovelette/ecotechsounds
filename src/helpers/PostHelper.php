<?php
namespace src\helpers;

use src\models\Blog\Post;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class PostHelper
 * @package src\helpers
 */
class PostHelper
{
    public static function languageList() : array
    {
        return [
            Post::POST_LANG_EN => 'ENG',
            Post::POST_LANG_RU => 'RU',
        ];
    }

    public static function statusList() : array
    {
        return [
            Post::STATUS_DRAFT => 'Draft',
            Post::STATUS_PUBLISHED => 'Published',
            Post::STATUS_DEACTIVATED_BY_ADMIN => 'Deactivated',
        ];
    }

    public static function languageName($language) : string
    {
        return ArrayHelper::getValue(self::languageList(), $language);
    }

    public static function statusName($status) : string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function languageLabel($language) : string
    {
        switch ($language) {
            case Post::POST_LANG_RU:
                $class = 'label label-default';
                break;
            case Post::POST_LANG_EN:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::languageList(), $language), [
            'class' => $class,
        ]);
    }

    public static function statusLabel($status) : string
    {
        switch ($status) {
            case Post::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case Post::STATUS_PUBLISHED:
                $class = 'label label-success';
                break;
            case Post::STATUS_DEACTIVATED_BY_ADMIN:
                $class = 'label label-warning';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}
