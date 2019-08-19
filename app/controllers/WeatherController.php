<?php

use TestMaxLine\Helpers\OpenWeatherHelper;
use TestMaxLine\Forms\SearchWeatherForm;
use TestMaxLine\Models\CityHistory;

class WeatherController extends ControllerBase
{
    public function initialize()
    {
        $this->tag->setTitle('WeatherController');
    }

    public function indexAction()
    {
        $form = new SearchWeatherForm();

        $this->view->form = $form;
    }

    public function searchAction()
    {
        $form = new SearchWeatherForm();
        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost())) {
                $name = $this->request->getPost('name');

                CityHistory::saveInHistory($name);
                $weather = OpenWeatherHelper::getWeather($name);

                $this->view->result = $weather;
            } else {
                $this->view->messages = $form->getMessages();
            }
        }
    }
}