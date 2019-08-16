<?php

use Phalcon\Mvc\Controller;
//use TestMaxLine\Helpers\OpenWeatherHelper;

class IndexController extends Controller
{
    public function indexAction()
    {
        $weather = OpenWeatherHelper::getWeather('Minsk');

        echo '<pre>';
        print_r($weather);
        echo '</pre>';
    }
}