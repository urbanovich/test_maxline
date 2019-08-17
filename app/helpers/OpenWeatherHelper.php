<?php

//namespace TestMaxLine\Helpers;

use Cmfcmf\OpenWeatherMap;
use Cmfcmf\OpenWeatherMap\Exception as OWMException;
use Http\Factory\Guzzle\RequestFactory;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;

class OpenWeatherHelper
{

    protected CONST API_KEY = '8a6c277e8da64f08c199f761d30fabce';

    /**
     * Returns the current weather at the place you specified.
     *
     * There are four ways to specify the place to get weather information for:
     * - Use the city name: $query must be a string containing the city name.
     * - Use the city id: $query must be an integer containing the city id.
     * - Use the coordinates: $query must be an associative array containing the 'lat' and 'lon' values.
     * - Use the zip code: $query must be a string, prefixed with "zip:"
     *
     * Zip code may specify country. e.g., "zip:77070" (Houston, TX, US) or "zip:500001,IN" (Hyderabad, India)
     *
     * @param $data
     * @param string $lang
     * @param string $units
     * @return array
     */
    public static function getWeather($data, $lang = 'ru', $units = 'metric')
    {
        $httpRequestFactory = new RequestFactory();
        $httpClient = GuzzleAdapter::createWithConfig([]);

        // Create OpenWeatherMap object.
        $owm = new OpenWeatherMap(static::API_KEY, $httpClient, $httpRequestFactory);

        try {
            $weather = $owm->getWeather($data, $units, $lang);
        } catch (OWMException $e) {
            echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        } catch (\Exception $e) {
            echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        }

        return static::objectToArray($weather);
    }

    /**
     * Method convert object to array
     *
     * @param $object
     * @return array
     */
    protected static function objectToArray($object)
    {
        $result = [];
        foreach ($object as $key => $item) {
            if (is_object($item)) {
                if ($item instanceof Cmfcmf\OpenWeatherMap\Util\Unit) {
                    $result[$key] = $item->getFormatted();
                } else {
                    $result[$key] = static::objectToArray($item);
                }
            } else {
                $result[$key] = $item;
            }
        }

        return $result;
    }
}