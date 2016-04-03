<?php

namespace Tsuzukit\NaiveBayes\Tests\MockModel;

class Category
{

    public static $categories;

    public $id;
    public $name;
    public $count;

    public function __construct($id, $name, $count)
    {
        $this->id = $id;
        $this->name = $name;
        $this->count = $count;
    }

    public static function getByName($name)
    {
        if (static::$categories == null)
        {
            static::$categories = [];
        }

        $category = static::$categories[$name];
        return $category;
    }

    public static function createOrIncrement($name)
    {
        if (static::$categories == null)
        {
            static::$categories = [];
        }

        if (array_key_exists($name, static::$categories))
        {
            $category = static::$categories[$name];
            $category->incrementCount();
            return;
        }

        static::$categories[$name] = new Category(
            count(static::$categories),
            $name,
            1
        );
    }

    public static function all()
    {
        if (static::$categories == null)
        {
            static::$categories = [];
        }

        return static::$categories;
    }

    public function incrementCount()
    {
        $this->count++;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function getName()
    {
        return $this->name;
    }
}