<?php
namespace application\helpers;

use application\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/**
 * Class UserHelper
 * @package application\helpers
 */
class UserHelper
{
    public static function statusList() : array
    {
        return [
            User::STATUS_AWAIT => 'Non-confirmed',
            User::STATUS_ACTIVE => 'Active',
        ];
    }

    public static function statusName(int $status) : string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel(int $status) : string
    {
        switch ($status) {
            case User::STATUS_AWAIT:
                $class = 'label label-default';
                break;
            case User::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }
        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }
}
