<?php
/**
 * Created by PhpStorm.
 * User: tsuzukitomoaki
 * Date: 2016/03/17
 * Time: 23:17
 */

namespace Tsuzukit\NaiveBayes\Data;

class Category
{
    private $categoryModelName;
    private $wordModelName;

    public function __construct($categoryModelName = 'Tsuzukit\NaiveBayes\Model\Category',
                                $wordModelName = 'Tsuzukit\NaiveBayes\Model\Word')
    {
        $this->categoryModelName = $categoryModelName;
        $this->wordModelName = $wordModelName;
    }

    /**
     * @param $categoryName
     */
    public function count($categoryName)
    {
        $modelName = $this->categoryModelName;
        $modelName::createOrIncrement($categoryName);
    }

    /**
     * get prior probability
     * @param $category
     * @return float
     */
    public function getPriorProbability($category)
    {
        $modelName = $this->categoryModelName;
        $model = $modelName::getByName($category->name);
        return $model->getCount() / $this->getTotal();
    }

    /**
     * get categories as string in array
     * @return array
     */
    public function getCategories()
    {
        $modelName = $this->categoryModelName;

        $categories = [];

        foreach ($modelName::all() as $model)
        {
            $categories[] = $model;
        }

        return $categories;
    }

    /**
     * get number of categories
     * @return int
     */
    private function getTotal()
    {
        $modelName = $this->categoryModelName;

        $result = 0;
        foreach ($modelName::all() as $model)
        {
            $result += $model->getCount();
        }
        return $result;
    }
}
