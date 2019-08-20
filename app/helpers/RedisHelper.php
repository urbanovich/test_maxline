<?php


namespace TestMaxLine\Helpers;

use Ehann\RedisRaw\PredisAdapter;
use Ehann\RediSearch\Index;
use Ehann\RediSearch\Fields\TextField;

class RedisHelper
{

    protected const REDIS_HOST = 'test-maxline-redisearch';

    protected const REDIS_POST = '6379';

    protected $redis;

    protected $cityHistoryIndex;

    protected static $instance;

    public function __construct()
    {
        $this->redis = (new PredisAdapter())->connect(static::REDIS_HOST, static::REDIS_POST);

        $this->cityHistoryIndex = new Index($this->redis);
        $this->cityHistoryIndex
            ->setIndexName('city_history');
        try {
            $this->cityHistoryIndex->info();
        } catch (\Ehann\RediSearch\Exceptions\UnknownIndexNameException $e) {
            //if index not exists will create it
            $this->cityHistoryIndex
                ->addTextField('name')
                ->create();
        }
    }

    public static function getInstance()
    {
        if (static::$instance == null) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    /**
     * @return \Ehann\RedisRaw\RedisRawClientInterface
     */
    public function getRedis(): \Ehann\RedisRaw\RedisRawClientInterface
    {
        return $this->redis;
    }

    /**
     * @return Index
     */
    public function getCityHistoryIndex(): Index
    {
        return $this->cityHistoryIndex;
    }

    /**
     * Saves name of city in city history
     *
     * @param $name
     */
    public static function setCityHistory($id, $name)
    {
        $result = static::getInstance()->getCityHistoryIndex()->search($name);
        if (!$result->getCount()) {
            $document = static::getInstance()->getCityHistoryIndex()->makeDocument($id);
            $document->name->setValue($name);
            static::getInstance()->getCityHistoryIndex()->add($document);
        }
    }

    /**
     * Return of city names from city history index
     *
     * @return mixed
     */
    public static function searchInCityHistory($search)
    {
        return static::getInstance()->getCityHistoryIndex()->search($search);
    }
}