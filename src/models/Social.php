<?php
namespace src\models;

use yii\db\ActiveRecord;

/**
 * Class Network
 * @property integer $user_id
 * @property string $client_id
 * @property string $network
 * @package src\models
 */
class Social extends ActiveRecord
{
    /**
     * @param $network
     * @param $client_id
     * @throws \DomainException
     * @return Social
     */
    public static function create($network, $client_id) : self
    {
        if (!empty($network && $client_id)) {
            $item = new self();
            $item->network = $network;
            $item->client_id = $client_id;
            return $item;
        } else {
            throw new \DomainException('Client not reached or empty');
        }

    }

    public static function tableName() : string
    {
        return '{{%user_socials}}';
    }
}
