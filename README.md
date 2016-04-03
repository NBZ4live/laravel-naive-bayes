# Laravel naive bayes

Naive bayes classifier for laravel 5.2

# Install

```
$ composer require tsuzukit/laravel-naive-bayes:0.0.1
```

# Setup

Since word counts are store in DB, corresponding migration files nees to be published

```
$ php artisan vendor:publish --provider="Tsuzukit\NaiveBayes\NaiveBayesServiceProvider"
$ php artisan migrate
```

Next, you will need to add the service provider to the providers array in your `app.php` config as follows:

```
Tsuzukit\NaiveBayes\NaiveBayesServiceProvider::class,
```

Finally, set up Facade under the aliases array in `app.php` in config as follows:

```
'NaiveBayes' => Tsuzukit\NaiveBayes\Facade\NaiveBayes::class,
```

# How to use

## Training

```
$trainData = [
    'PHP'    => '（ピー・エイチ・ピー ハイパーテキスト プリプロセッサー）とは、動的にHTMLデータを生成することによって、動的なウェブページを実現することを主な目的としたプログラミング言語、およびその言語処理系である。一般的には PHP と省略して用いられており、これは「個人的なホームページ」を意味する英語の "Personal Home Page" に由来する[2]。',
    'Python' => 'Python（パイソン）は，オランダ人のグイド・ヴァンロッサムが作ったオープンソースのプログラミング言語。
             オブジェクト指向スクリプト言語の一種であり，Perlとともに欧米で広く普及している。イギリスのテレビ局 BBC が製作したコメディ番組『空飛ぶモンティパイソン』にちなんで名付けられた。
             Python は英語で爬虫類のニシキヘビの意味で，Python言語のマスコットやアイコンとして使われることがある。Pythonは汎用の高水準言語である。プログラマの生産性とコードの信頼性を重視して設計されており，核となるシンタックスおよびセマンティクスは必要最小限に抑えられている反面，利便性の高い大規模な標準ライブラリを備えている。
             Unicode による文字列操作をサポートしており，日本語処理も標準で可能である。多くのプラットフォームをサポートしており（動作するプラットフォーム），また，豊富なドキュメント，豊富なライブラリがあることから，産業界でも利用が増えつつある。',
    'Snake'  => 'ヘビ（蛇）は、爬虫綱有鱗目ヘビ亜目（Serpentes）に分類される爬虫類の総称。
             体が細長く、四肢がないのが特徴。ただし、同様の形の動物は他群にも存在する。',
    'Gem'    => 'ルビー（英: Ruby、紅玉）は、コランダム（鋼玉）の変種である。赤色が特徴的な宝石である。
             天然ルビーは産地がアジアに偏っていて欧米では採れないうえに、
             産地においても宝石にできる美しい石が採れる場所は極めて限定されており、
             3カラットを超える大きな石は産出量も少ない。',
];
foreach ($trainData as $key => $value)
{
    $words = NaiveBayes::explodeDocument($value);
    NaiveBayes::fit($words, $key);
}
```

## Prediction

```
// $document is the text that you want to classify
$words = NaiveBayes::explodeDocument($document);
NaiveBayes::predict($words)
```

# Important notes

Mecab php must be installed to run this library correctly.

See [Example Project Recipe](https://github.com/tsuzukit/laravel-naive-bayes-example/blob/master/chef/site-cookbooks/mecab/recipes/default.rb)

# Licence

The MIT License (MIT)

Copyright (c) 2016 Tomoaki Tsuzuki

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.