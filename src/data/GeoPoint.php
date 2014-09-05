<?php

/*
 * This file is part of the tinygeo package.
 *
 * (C) ITinance GmbH <https://github.com/itinance/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tinygeo\data;

class GeoPoint
{

    /**
     * @var float
     */
    public $lat;

    /**
     * @var float
     */
    public $lng;

    /**
     * Initialize latitude and longitude with decimal values or as degree-minute-second-representing string
     * @param float|string $lat
     * @param float|string $lng
     */
    public function __construct($lat, $lng)
    {

        if(is_string($lat) && is_string($lng)) {
            $degLat = GeoDegree::fromString($lat);
            if($degLat) {
                $degLng = GeoDegree::fromString($lng);
                if($degLng) {
                    $this->lat = $degLat->toDecimals();
                    $this->lng = $degLng->toDecimals();
                    return;
                }
            }
        }

        $this->lat = (float)$lat;
        $this->lng = (float)$lng;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%0.5g,%0.5g', $this->lat, $this->lng);
    }

    /**
     * @param int $precision
     * @param bool $fixedPrecisionLength
     * @return string
     */
    public function getString($precision, $fixedPrecisionLength = false)
    {
        $fmtChar = $fixedPrecisionLength ? 'f' : 'g';
        $fmt = sprintf('%%0.%u%s', $precision, $fmtChar);

        return sprintf("$fmt,$fmt", $this->lat, $this->lng);
    }

    /**
     * @return string
     */
    public function getStringAsDegreeMinuteSecond() {
        $degLat = GeoDegree::degreeFromDecimals($this->lat);
        $defLng = GeoDegree::degreeFromDecimals($this->lng);

        return sprintf("%s,%s", $degLat, $defLng);
    }

    /**
     * @param GeoPoint $another
     * @param int $precision
     * @return bool
     */
    public function isEqualTo(GeoPoint $another, $precision = 5)
    {
        $round = function ($value) use ($precision) {
            return round($value, $precision);
        };

        return $round($this->lat) === $round($another->lat) && $round($this->lng) === $round($another->lng);
    }

}