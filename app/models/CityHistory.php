<?php

namespace TestMaxLine\Models;

class CityHistory extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $name;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("test_maxline");
        $this->setSource("city_history");
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'city_history';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return CityHistory[]|CityHistory|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return CityHistory|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function saveInHistory($name)
    {
        if (!static::findFirst('name = "' . addslashes($name) . '"')) {
            $city = new self();
            $city->name = $name;
            if ($city->save() !== false) {
                return $city->id;
            } else {
                return false;
            }
        }
    }
}
