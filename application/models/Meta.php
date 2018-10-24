<?php
namespace application\models;

class Meta
{
    public $title, $description, $keywords;

    public function __construct($title, $description, $keywords)
    {
        $this->title = $title;
        $this->description = $description;
        $this->keywords = $keywords;
    }
}
