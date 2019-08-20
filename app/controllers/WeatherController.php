<?php

use TestMaxLine\Helpers\OpenWeatherHelper;
use TestMaxLine\Helpers\RedisHelper;
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

        RedisHelper::getInstance()->getCityHistoryIndex()->drop();
    }

    public function searchAction()
    {
        $form = new SearchWeatherForm();
        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost())) {
                $name = $this->request->getPost('name');

                if ($id = CityHistory::saveInHistory($name)) {
                    RedisHelper::setCityHistory($id, $name);
                }

                $weather = OpenWeatherHelper::getWeather($name);

                $this->view->result = $weather;
            } else {
                $this->view->messages = $form->getMessages();
            }
        }


    }

    public function cityHistoryAction()
    {
        $this->view->dbHistory = CityHistory::find(['order' => 'name']);
    }
}