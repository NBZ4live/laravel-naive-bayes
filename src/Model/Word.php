<?php

namespace Tsuzukit\NaiveBayes\Model;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bayes_words';

    /**
     * fillable fields for a Action.
     *
     * @var array
     */
    protected $fillable = [
        'word',
        'count',
        'bayes_category_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->belongsTo('Tsuzukit\NaiveBayes\Model\Category');
    }

    public static function getByWordAndCategoryId($word, $category)
    {
        return Word::where([
            'word' => $word,
            'bayes_category_id' => $category->id,
        ])->first();
    }

    public static function createOrIncrement($word, $category)
    {
        $model = Word::getByWordAndCategoryId($word, $category);
        if ($model != null)
        {
            $model->update([
                'count' => $model->count + 1,
            ]);
            return;
        }


        Word::create([
            'word' => $word,
            'bayes_category_id' => $category->id,
            'count' => 1,
        ]);
    }

    public static function getByCategory($category)
    {
        return static::where([
            'bayes_category_id' => $category->id,
        ])->get();
    }

    public static function getDistinct()
    {
        return static::distinct()->select('word')->groupBy('word')->get()->count();
    }

    public function getCount()
    {
        return $this->count;
    }
}