<?php

namespace Tsuzukit\NaiveBayes\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bayes_categories';

    /**
     * fillable fields for a Action.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'count',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function words()
    {
        return $this->hasMany('Tsuzukit\NaiveBayes\Model\Word', 'bayes_category_id');
    }

    public static function getByName($name)
    {
        return Category::where([
            'name' => $name,
        ])->first();
    }

    public static function createOrIncrement($name)
    {
        $category = Category::getByName($name);
        if ($category != null)
        {
            $category->update([
                'count' => $category->value + 1
            ]);
            return;
        }

        Category::create([
            'name' => $name,
            'count' => 1
        ]);
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