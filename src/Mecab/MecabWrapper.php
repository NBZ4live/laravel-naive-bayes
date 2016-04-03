<?php
/**
 * Created by PhpStorm.
 * User: tsuzukitomoaki
 * Date: 2016/03/17
 * Time: 23:17
 */

namespace Tsuzukit\NaiveBayes\Mecab;

class MecabWrapper
{

    const ILLEGAL_CHARS = "#$%^&*()+=-[]';,./{}|:<>?~";

    private static $INVALID_WORDS = [
        'a',
        'the',
        'in'
    ];

    /**
     * mecab classifier
     * @param $document
     * @return array|void
     */
    public static function toWords($document)
    {
        if (!extension_loaded('mecab')) {
            Log::error('mecab extension not loaded');
            return;
        }

        $mecab = new \MeCab\Tagger();
        $nodes = $mecab->parseToNode($document);

        $words = [];
        foreach ($nodes as $n) {
            $word = $n->getSurface();

            if (static::isInvalidWord($word))
            {
                continue;
            }

            if (strpos($n->getFeature(), '名詞') !== false)
            {
                $words[] = $word;
            }

            if (strpos($n->getFeature(), '動詞') !== false)
            {
                $words[] = $word;
            }

            if (strpos($n->getFeature(), '助動詞') !== false)
            {
                $words[] = $word;
            }

            if (strpos($n->getFeature(), '形容詞') !== false)
            {
                $words[] = $word;
            }
        }

        return $words;
    }

    /**
     * check invalid word
     * @param $word
     * @return bool|void
     */
    private static function isInvalidWord($word)
    {
        if (strpbrk($word, MecabWrapper::ILLEGAL_CHARS) !== false)
        {
            return;
        }

        foreach (static::$INVALID_WORDS as $invalidWord)
        {
            if ($word == $invalidWord)
            {
                return true;
            }
        }
        return false;
    }
}
