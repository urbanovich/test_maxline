<?php

use Phalcon\Mvc\Controller;
use TestMaxLine\Helpers\OpenWeatherHelper;

class WeatherController extends Controller
{
    public function initialize()
    {
        $this->tag->setTitle('WeatherController');
    }

    public function indexAction()
    {
        /*$weather = OpenWeatherHelper::getWeather('Minsk');

        echo '<pre>';
        print_r($weather);
        echo '</pre>';*/
    }
}