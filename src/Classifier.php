<?php

namespace Tsuzukit\NaiveBayes;

use Tsuzukit\NaiveBayes\Data\Category;
use Tsuzukit\NaiveBayes\Mecab\MecabWrapper;
use Tsuzukit\NaiveBayes\Data\Word;

class Classifier
{

    private $wordData = null;
    private $categoryData = null;

    /**
     * NaiveBayes constructor.
     * @param $isTest
     */
    public function __construct($isTest = false)
    {
        if (!$isTest)
        {
            $this->wordData = new Word();
            $this->categoryData = new Category();
            return;
        }

        // pass mock model name
        $this->wordData = new Word(
            'Tsuzukit\NaiveBayes\Tests\MockModel\Category',
            'Tsuzukit\NaiveBayes\Tests\MockModel\Word'
        );
        $this->categoryData = new Category(
            'Tsuzukit\NaiveBayes\Tests\MockModel\Category',
            'Tsuzukit\NaiveBayes\Tests\MockModel\Word'
        );
    }

    public function explodeDocument($document)
    {
        $words = MecabWrapper::toWords($document);
        return $words;
    }

    /**
     * training method
     * @param $words
     * @param $categoryName
     */
    public function fit($words, $categoryName)
    {
        // first add category data as it is used in word archive
        $this->categoryData->count($categoryName);

        foreach ($words as $word)
        {
            $this->wordData->countWord($word, $categoryName);
        }
    }

    /**
     * classification
     * @param $words
     * @return null
     */
    public function predict($words)
    {
        $bestCategory = null;
        $maxProb = -INF;
        foreach ($this->categoryData->getCategories() as $category) {
            $prob = $this->score($words, $category);
            if ($prob > $maxProb) {
                $bestCategory = $category;
                $maxProb = $prob;
            }
        }
        return $bestCategory->name;
    }

    /**
     * bayesian algorithm
     * @param $words
     * @param $category
     * @return float|int
     */
    private function score($words, $category)
    {
        $score = log($this->categoryData->getPriorProbability($category));
        $score += $this->wordData->getWordsProbability($words, $category);
        return $score;
    }
}
