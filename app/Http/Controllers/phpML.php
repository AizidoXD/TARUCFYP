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
    private $arr_text = [];
    private $arr_label = [];

    public function index() {
        // extract data from csv file and put into arr_text and arr_label
        if (($csvTrain = fopen("Excel/Train/Training.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($csvTrain, 500, ",")) !== FALSE) {
                array_push($this->arr_text, strtolower($data[0]));
                array_push($this->arr_label, $data[1]);
            }
            fclose($csvTrain);
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

        //initialize test set 
        $arr_testset = [];
        $filename = "Book1.csv";
        // extract data from csv file and put into $arr_testset
        if (($csvTest = fopen("Excel/Test/$filename", "r")) !== FALSE) {
            while (($data = fgetcsv($csvTest, 500, ",")) !== FALSE) {
                array_push($arr_testset, strtolower($data[0]));
            }
            fclose($csvTest);
        }

        $vectorizer->transform($arr_testset);
        $transformer->transform($arr_testset);
        $result = $classifier->predict($arr_testset);

        //Count the total good and bad result for each category
        $arr_bus = [0, 0, 1];
        $arr_wifi = [0, 0, 0];
        $arr_adminService = [0, 0, 0];
        $arr_food = [0, 0, 1];
        $arr_parking = [0, 0, 1];
        $arr_timeTable = [0, 0, 1];
        $arr_lecturer = [0, 0, 0];
        $arr_outdoor = [0, 0, 0];
        $arr_facility = [0, 0, 0];
        $categoryBad = [];

        //Count the duplicated array value
        $arr_count = array_count_values($result);

        //Fill up the category array with the bad and good comment number
        foreach ($arr_count as $key => $value) {
            if ($key === "BusG") {
                $arr_bus[0] = $value;
            }
            if ($key === "BusB") {
                $arr_bus[1] = $value;
                $categoryBad["Bus"] = $value;
            }
            if ($key === "WifiG") {
                $arr_wifi[0] = $value;
            }
            if ($key === "WifiB") {
                $arr_wifi[1] = $value;
                $categoryBad['Wifi'] = $arr_wifi[1];
            }
            if ($key === "AdminG") {
                $arr_adminService[0] = $value;
            }
            if ($key === "AdminB") {
                $arr_adminService[1] = $value;
                $categoryBad['AdminService'] = $arr_adminService[1];
            }

            if ($key === "FoodG") {
                $arr_food[0] = $value;
            }
            if ($key === "FoodB") {
                $arr_food[1] = $value;
                $categoryBad['Food'] = $arr_food[1];
            }
            if ($key === "ParkingG") {
                $arr_parking[0] = $value;
            }
            if ($key === "ParkingB") {
                $arr_parking[1] = $value;
                $categoryBad['Parking'] = $arr_parking[1];
            }
            if ($key === "TimetableG") {
                $arr_timeTable[0] = $value;
            }
            if ($key === "TimetableB") {
                $arr_timeTable[1] = $value;
                $categoryBad['TimeTable'] = $arr_timeTable[1];
            }

            if ($key === "LecturerG") {
                $arr_lecturer[0] = $value;
            }
            if ($key === "LecturerB") {
                $arr_lecturer[1] = $value;
                $categoryBad['Lecturer'] = $arr_lecturer[1];
            }
            if ($key === "OutdoorG") {
                $arr_outdoor[0] = $value;
            }
            if ($key === "OutdoorB") {
                $arr_outdoor[1] = $value;
                $categoryBad['Outdoor'] = $arr_outdoor[1];
            }
            if ($key === "FacilityG") {
                $arr_facility[0] = $value;
            }
            if ($key === "FacilityB") {
                $arr_facility[1] = $value;
                $categoryBad['Facility'] = $arr_facility[1];
            }
        }

        //sort the $categoryBad with the custom key value by descending order of the array value
        arsort($categoryBad);

        //Passing the array to test.blade view
        return view('test')
                        ->with('arr_bus', $arr_bus)
                        ->with('arr_wifi', $arr_wifi)
                        ->with('arr_adminService', $arr_adminService)
                        ->with('arr_food', $arr_food)
                        ->with('arr_parking', $arr_parking)
                        ->with('arr_timeTable', $arr_timeTable)
                        ->with('arr_lecturer', $arr_lecturer)
                        ->with('arr_outdoor', $arr_outdoor)
                        ->with('arr_facility', $arr_facility)
                        ->with('categoryBad', $categoryBad)
                        ->with('fileName', $filename);
    }

}
