<?php

namespace Tsuzukit\NaiveBayes\Tests\MockModel;

class Word
{
    public static $words;

    public $id;
    public $word;
    public $categoryId;
    public $count;

    public function __construct($id, $word, $categoryId, $count)
    {
        $this->id = $id;
        $this->word = $word;
        $this->categoryId = $categoryId;
        $this->count = $count;
    }

    public static function getByWordAndCategoryId($word, $category)
    {
        if (static::$words == null)
        {
            static::$words = [];
        }

        foreach (static::$words as $w)
        {
            if ($w->word == $word && $w->categoryId == $category->id)
            {
                return $w;
            }
        }
        return null;
    }

    public static function createOrIncrement($word, $category)
    {
        if (static::$words == null)
        {
            static::$words = [];
        }

        $w = static::getByWordAndCategoryId($word, $category);
        if ($w != null)
        {
            $w->incrementCount();
            return;
        }

        static::$words[$word] = new Word(
            count(static::$words),
            $word,
            $category->id,
            1
        );
    }

    public function incrementCount()
    {
        $this->count++;
    }

    public function getCount()
    {
        return $this->count;
    }

    public static function getByCategory($category)
    {
        $selectedWords = [];
        foreach (static::$words as $w)
        {
            if ($w->categoryId == $category->id)
            {
                $selectedWords[] = $w;
            }
        }

        return $selectedWords;
    }

    public static function getDistinct()
    {
        $countedWords = [];
        $selectedWords = [];
        foreach (static::$words as $w)
        {
            $counted = false;
            foreach ($countedWords as $countedWord)
            {
                if ($w == $countedWord)
                {
                    $counted = true;
                    break;
                }
            }
            if (!$counted)
            {
                $selectedWords[] = $w;
            }
        }

        return count($selectedWords);
    }
}