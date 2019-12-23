<?php

namespace App\Http\Controllers;

use Phpml\Metric\Accuracy;
//require_once __DIR__ . '/vendor/autoload.php';
use Phpml\Classification\NaiveBayes;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;
use Phpml\Tokenization\WordTokenizer;
use Phpml\FeatureExtraction\TfIdfTransformer;
use Phpml\Preprocessing\Imputer;
use Phpml\Preprocessing\Imputer\Strategy\MeanStrategy;
use Illuminate\Http\Request;

class phpML extends Controller {

    //initialize 2 array for training ( text and label ) 
    //private $arr_text = ["Bus is old, bumpy.", "We couldn't find a place to sit.", "The bus is bad.", "Clean bus. Great driver.", "Excellent driver!", "Driver was professional and on time ! Would use them again.", "The bus driver is professional"];
    //private $arr_label = ["BusB", "BusB", "BusB", "BusG", "BusG", "BusG", "BusG"];

    private $arr_text = [];
    private $arr_label = [];

    public function index() {
        // extract data from csv file and put into arr_text and arr_label
        //$filePath = public_path('/Excel/')."Bus.csv";
        if (($csvFile = fopen("Excel/Bus.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($csvFile, 1000, ",")) !== FALSE) {
                array_push($this->arr_text, strtolower($data[0]));
                array_push($this->arr_label, $data[1]);
            }
            fclose($csvFile);
        }
        
        // tokenize the sentence
        $tokenize = new WordTokenizer();
        $vectorizer = new TokenCountVectorizer($tokenize);

        //vectorization
        $vectorizer->fit($this->arr_text);
        $vocabulary = $vectorizer->getVocabulary();

        $arr_transform = $this->arr_text;
        $vectorizer->transform($arr_transform);

        // lemmetization
        $imputer = new Imputer(null, new MeanStrategy(null), Imputer::AXIS_COLUMN, $arr_transform);
        $imputer->transform($arr_transform);

        //feature extraction
        $transformer = new TfIdfTransformer($arr_transform);
        $transformer->transform($arr_transform);

        //train the training set with the label 
        $classifier = new NaiveBayes();
        $classifier->train($arr_transform, $this->arr_label);

        // initialize test set 
        $arr_testset = [
            'Great driver',
            'worst driver',
            'The driver professional',
            'dirty bus',
            'The bus is professional',
            'I woul highly recomend this bus'
        ];

        $vectorizer->transform($arr_testset);
        $transformer->transform($arr_testset);
        $result = $classifier->predict($arr_testset);

//        foreach ($arr_testset as $a) {
//            echo $a . '</br>';
//        }

        foreach ($result as $value) {
            echo $value . '</br>';
        }
    }

}
