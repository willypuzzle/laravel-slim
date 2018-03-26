<?php
namespace Idsign\Slim;
use Illuminate\Http\Request;

class LaravelSlim extends Slim {

    public static function getImages($inputName = 'slim') {

        $values = LaravelSlim::getPostData($inputName);
        // test for errors
        if ($values === false) {
            return false;
        }

        // determine if contains multiple input values, if is singular, put in array
        $data = array();
        if (!is_array($values)) {
            $values = array($values);
        }

        // handle all posted fields
        foreach ($values as $value) {
            $inputValue = LaravelSlim::parseInput($value);
            if ($inputValue) {
                array_push($data, $inputValue);
            }
        }

        // return the data collected from the fields
        return $data;

    }
    protected static function getPostData($inputName) {

        $request = Request::capture();
        $values = array();
        if ($request->has($inputName)) {
            $values = $request->get($inputName);
        }
        else if (isset($_POST[$inputName])) {
            $values = $_POST[$inputName];
        }
        else if (isset($_FILES[$inputName])) {
            // Slim was not used to upload this file
            return false;
        }
        return $values;
    }

}