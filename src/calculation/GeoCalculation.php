<?php
/*
 * This file is part of the tinygeo package.
 *
 * (C) ITinance GmbH <http://https://github.com/itinance/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tinygeo\calculation;


use tinygeo\data\GeoPoint;
use tinygeo\data\GeoRectangle;

class GeoCalculation
{

    const UNIT_KILOMETERS = 'km';
    const UNIT_MILES = 'm';
    const UNIT_NAUTICAL_METERS = 'nm';

    /**
     * @param GeoPoint $p
     * @param float $distance
     * @return GeoRectangle
     */
    public static function getBoundingBox(GeoPoint $p, $distance)
    {
        return new GeoRectangle(
        /*'NW' => */
            self::getDestinationWithDistanceAndBearing($p, $distance, 315),
            /* 'NO' => */
            self::getDestinationWithDistanceAndBearing($p, $distance, 45),
            /* 'SO' => */
            self::getDestinationWithDistanceAndBearing($p, $distance, 135),
            /* 'SW' => */
            self::getDestinationWithDistanceAndBearing($p, $distance, 225)
        );

    }

    /**
     * @param GeoPoint $point
     * @param float $distance
     * @param float $bearing
     * @return GeoPoint
     */
    public static function getDestinationWithDistanceAndBearing(GeoPoint $point, $distance, $bearing)
    {
        $lat1 = self::toRad($point->lat);
        $lon1 = self::toRad($point->lng);
        $distance = $distance / 6371.01; //Earth's radius in km
        $bearing = self::toRad($bearing);

        $lat2 = asin(
            sin($lat1) * cos($distance) +
            cos($lat1) * sin($distance) * cos($bearing)
        );
        $lon2 = $lon1 + atan2(
                sin($bearing) * sin($distance) * cos($lat1),
                cos($distance) - sin($lat1) * sin($lat2)
            );
        $lon2 = fmod(($lon2 + 3 * pi()), (2 * pi())) - pi();

        return new GeoPoint(self::toDeg($lat2), self::toDeg($lon2));
    }

    /**
     * @param GeoPoint $startPoint
     * @param GeoPoint $endPoint
     * @param string $unit see UNIT_*** - constants
     * @return float
     * @throws \InvalidArgumentException
     */
    public static function getDistanceBetween(GeoPoint $startPoint, GeoPoint $endPoint, $unit = self::UNIT_KILOMETERS)
    {
        if (!in_array($unit, array(self::UNIT_KILOMETERS, self::UNIT_NAUTICAL_METERS, self::UNIT_NAUTICAL_METERS))) {
            throw new \InvalidArgumentException("Invalid unit");
        }

        $theta = $startPoint->lng - $endPoint->lng;
        $dist = sin(deg2rad($startPoint->lat)) * sin(deg2rad($endPoint->lat)) + cos(deg2rad($startPoint->lat)) * cos(
                deg2rad($endPoint->lat)
            ) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        switch ($unit) {
            case self::UNIT_KILOMETERS:
                return ($miles * 1.609344);
            case self::UNIT_NAUTICAL_METERS:
                return ($miles * 0.8684);
            default:
                return $miles;
        }
    }

    /**
     * @param GeoPoint $p
     * @param float $distance
     * @return GeoPoint
     */
    public static function movePointToRight(GeoPoint $p, $distance)
    {
        return self::getDestinationWithDistanceAndBearing($p, $distance, 270);
    }

    /**
     * @param GeoPoint $p
     * @param float $distance
     * @return GeoPoint
     */
    public static function movePointToLeft(GeoPoint $p, $distance)
    {
        return self::getDestinationWithDistanceAndBearing($p, $distance, 90);
    }

    /**
     * @param GeoPoint $p
     * @param float $distance
     * @return GeoPoint
     */
    public static function movePointUpwards(GeoPoint $p, $distance)
    {
        return self::getDestinationWithDistanceAndBearing($p, $distance, 0);
    }

    /**
     * @param GeoPoint $p
     * @param float $distance
     * @return GeoPoint
     */
    public static function movePointDownwards(GeoPoint $p, $distance)
    {
        return self::getDestinationWithDistanceAndBearing($p, $distance, 180);
    }

    /**
     * @param float $deg
     * @return float
     */
    public static function toRad($deg)
    {
        return $deg * pi() / 180;
    }

    /**
     * @param float $rad
     * @return float
     */
    public static function toDeg($rad)
    {
        return $rad * 180 / pi();
    }

} 