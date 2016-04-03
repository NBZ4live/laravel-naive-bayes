<?php
/**
 * Created by PhpStorm.
 * User: tsuzukitomoaki
 * Date: 2016/03/17
 * Time: 23:17
 */

namespace Tsuzukit\NaiveBayes\Data;

class Word
{
    private $categoryModelName;
    private $wordModelName;

    public function __construct($categoryModelName = 'Tsuzukit\NaiveBayes\Model\Category',
                                $wordModelName = 'Tsuzukit\NaiveBayse\Model\Word')
    {
        $this->categoryModelName = $categoryModelName;
        $this->wordModelName = $wordModelName;
    }

    /**
     * count the word in category
     * @param $word
     * @param $categoryName
     */
    public function countWord($word, $categoryName)
    {
        $categoryModelName = $this->categoryModelName;
        $wordModelName = $this->wordModelName;

        $categoryModel = $categoryModelName::getByName($categoryName);
        $wordModelName::createOrIncrement($word, $categoryModel);
    }

    /**
     * calculate sum of probability for given words
     * @param $words
     * @param $category
     * @return float|int
     */
    public function getWordsProbability($words, $category)
    {
        $score = 0;
        foreach ($words as $word)
        {
            $score += log($this->getWordProbability($word, $category));
        }
        return $score;
    }

    /**
     * calculate probability of word
     * @param $word
     * @param $category
     * @return float
     */
    private function getWordProbability($word, $category)
    {
        $laplaceFilterCoefficient = 1;

        $numerator = $this->getWordCountInCategory($word, $category) + $laplaceFilterCoefficient;
        $denominator = $this->getTotalWordsInCategory($category) + $this->getDistinctWordCount() * $laplaceFilterCoefficient;
        $probability = $numerator / $denominator;
        return $probability;
    }

    /**
     * get number of words found in category
     * @param $category
     * @return int
     */
    public function getTotalWordsInCategory($category)
    {
        $categoryModelName = $this->categoryModelName;
        $wordModelName = $this->wordModelName;

        $categoryModel = $categoryModelName::getByName($category->name);
        $wordModels = $wordModelName::getByCategory($categoryModel);

        $result = 0;
        foreach ($wordModels as $model)
        {
            $result += $model->getCount();
        }
        return $result;
    }

    /**
     * distinct word count of all documents
     */
    public function getDistinctWordCount()
    {
        $wordModelName = $this->wordModelName;
        return $wordModelName::getDistinct();
    }

    /**
     * get cound of words in category
     * @param $word
     * @param $category
     * @return float
     */
    public function getWordCountInCategory($word, $category)
    {
        $wordModelName = $this->wordModelName;
        $model = $wordModelName::getByWordAndCategoryId($word, $category);
        if ($model != null)
        {
            return (float) $model->getCount();
        }
        return 0.0;
    }
}
