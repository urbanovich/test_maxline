<?php


namespace TestMaxLine\Helpers;

use Ehann\RedisRaw\PredisAdapter;
use Ehann\RediSearch\Index;

class RedisHelper
{

    protected const REDIS_HOST = 'test-maxline-redis';

    protected const REDIS_POST = '6379';

    protected $redis;

    protected $cityHistoryIndex;

    protected static $instance;

    public function __construct()
    {
        $this->redis = (new PredisAdapter())->connect(static::REDIS_HOST, static::REDIS_POST);

        $this->cityHistoryIndex = new Index($this->redis);

        $this->cityHistoryIndex
            ->addTextField('name')
            ->create();
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

    public static function setCityHistory($name)
    {
        $result = static::getInstance()->getCityHistoryIndex()->search($name);

        if (!$result->count()) {
            static::getInstance()->getCityHistoryIndex()->add([
                new TextField('name', $name),
            ]);
        }
    }
}