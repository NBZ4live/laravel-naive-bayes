<?php

namespace Tsuzukit\NaiveBayse\Tests;

use Tsuzukit\NaiveBayes\Classifier;
use Tsuzukit\NaiveBayes\Data\Category;
use Tsuzukit\NaiveBayes\Data\Word;

class NaiveBayesTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        \Tsuzukit\NaiveBayes\Tests\MockModel\Category::$categories = [];
        \Tsuzukit\NaiveBayes\Tests\MockModel\Word::$words = [];
    }

    public function testPriorProbability()
    {
        $categoryData = new Category(
            'Tsuzukit\NaiveBayes\Tests\MockModel\Category',
            'Tsuzukit\NaiveBayes\Tests\MockModel\Word'
        );

        $categoryData->count('php');
        $categoryData->count('php');
        $categoryData->count('python');
        $categoryData->count('python');
        $categoryData->count('python');
        $categoryData->count('python');
        $categoryData->count('ruby');
        $categoryData->count('ruby');

        $this->assertEquals(2/8, $categoryData->getPriorProbability(
            new \Tsuzukit\NaiveBayes\Tests\MockModel\Category(0, 'php', 0)
        ));
    }

    public function testTotalWords()
    {
        $categoryData = new Category(
            'Tsuzukit\NaiveBayes\Tests\MockModel\Category',
            'Tsuzukit\NaiveBayes\Tests\MockModel\Word'
        );
        $categoryData->count('php');
        $categoryData->count('python');
        $categoryData->count('ruby');

        $wordData = new Word(
            'Tsuzukit\NaiveBayes\Tests\MockModel\Category',
            'Tsuzukit\NaiveBayes\Tests\MockModel\Word'
        );

        $wordData->countWord('Hyper', 'php');
        $wordData->countWord('Protocol', 'php');
        $wordData->countWord('Hyper', 'php');

        $wordData->countWord('Monty', 'python');
        $wordData->countWord('Python', 'python');

        $wordData->countWord('Gem', 'ruby');
        $wordData->countWord('renv', 'ruby');
        $wordData->countWord('renv', 'ruby');
        $wordData->countWord('rails', 'ruby');

        $this->assertEquals(3, $wordData->getTotalWordsInCategory(
            new \Tsuzukit\NaiveBayes\Tests\MockModel\Category(0, 'php', 0)
        ));
        $this->assertEquals(2, $wordData->getTotalWordsInCategory(
            new \Tsuzukit\NaiveBayes\Tests\MockModel\Category(0, 'python', 0)
        ));
        $this->assertEquals(4, $wordData->getTotalWordsInCategory(
            new \Tsuzukit\NaiveBayes\Tests\MockModel\Category(0, 'ruby', 0)
        ));
    }

    public function testDistinctWordCount()
    {
        $categoryData = new Category(
            'Tsuzukit\NaiveBayes\Tests\MockModel\Category',
            'Tsuzukit\NaiveBayes\Tests\MockModel\Word'
        );
        $categoryData->count('php');
        $categoryData->count('python');
        $categoryData->count('ruby');

        $wordData = new Word(
            'Tsuzukit\NaiveBayes\Tests\MockModel\Category',
            'Tsuzukit\NaiveBayes\Tests\MockModel\Word'
        );

        $wordData->countWord('Hyper', 'php');
        $wordData->countWord('Protocol', 'php');
        $wordData->countWord('Hyper', 'php');

        $wordData->countWord('Monty', 'python');
        $wordData->countWord('Python', 'python');

        $wordData->countWord('Gem', 'ruby');
        $wordData->countWord('renv', 'ruby');
        $wordData->countWord('renv', 'ruby');
        $wordData->countWord('rails', 'ruby');

        $this->assertEquals(7, $wordData->getDistinctWordCount());
    }

    public function testWordCountInCategory()
    {
        $categoryData = new Category(
            'Tsuzukit\NaiveBayes\Tests\MockModel\Category',
            'Tsuzukit\NaiveBayes\Tests\MockModel\Word'
        );
        $categoryData->count('php');
        $categoryData->count('python');
        $categoryData->count('ruby');

        $wordData = new Word(
            'Tsuzukit\NaiveBayes\Tests\MockModel\Category',
            'Tsuzukit\NaiveBayes\Tests\MockModel\Word'
        );

        $wordData->countWord('Hyper', 'php');
        $wordData->countWord('Protocol', 'php');
        $wordData->countWord('Hyper', 'php');

        $wordData->countWord('Monty', 'python');
        $wordData->countWord('Python', 'python');

        $wordData->countWord('Gem', 'ruby');
        $wordData->countWord('renv', 'ruby');
        $wordData->countWord('renv', 'ruby');
        $wordData->countWord('rails', 'ruby');

        $this->assertEquals(2, $wordData->getWordCountInCategory('Hyper',
            new \Tsuzukit\NaiveBayes\Tests\MockModel\Category(0, 'php', 0)
        ));
    }

    public function testPredict()
    {
        $clf = new Classifier(true);

        // train for php
        $clf->fit(
            explode(' ', 'PHP is a server-side scripting language designed for web development but also used as a general-purpose programming language. Originally created by Rasmus Lerdorf in 1994,[3] the PHP reference implementation is now produced by The PHP Group.[4] PHP originally stood for Personal Home Page,[3] but it now stands for the recursive backronym PHP: Hypertext Preprocessor'),
            'php'
        );

        $clf->fit(
            explode(' ', 'Python is a widely used high-level, general-purpose, interpreted, dynamic programming language.[23][24] Its design philosophy emphasizes code readability, and its syntax allows programmers to express concepts in fewer lines of code than would be possible in languages such as C++ or Java.[25][26] The language provides constructs intended to enable clear programs on both a small and large scale'),
            'python'
        );

        $category = $clf->predict(['Hypertext', 'Preprocessor']);
        $this->assertEquals('php', $category);

        $category = $clf->predict(['few', 'line', 'of', 'code']);
        $this->assertEquals('python', $category);
    }

}

