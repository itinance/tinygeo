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


class GeoDegree
{

    /**
     * @var int
     */
    public $degrees;

    /**
     * @var int
     */
    public $minutes;

    /**
     * @var float
     */
    public $seconds;

    /**
     * @param int $degrees
     * @param int $minutes
     * @param float $seconds
     */
    public function __construct($degrees, $minutes, $seconds)
    {
        $this->degrees = (int)$degrees;
        $this->minutes = (int)$minutes;
        $this->seconds = (float)$seconds;
    }

    /**
     * creates a GeoDegree instance by passing a representing string containing degrees, minutes and seconds.
     *
     * $d = GeoDegree::fromString("48° 08' 10''");
     * $d = GeoDegree::fromString("48°08'10''");
     *
     * @param string $str
     * @return GeoDegree
     */
    public static function fromString($str)
    {
        if (preg_match('/(?<degrees>\d+)°\s*(?<minutes>\d+)\'\s*(?<seconds>\d+(\.\d+)?)\'\'/', $str, $matches)) {
            return new GeoDegree($matches['degrees'], $matches['minutes'], $matches['seconds']);
        }
        return null;
    }

    /**
     * @param float $value
     * @return GeoDegree
     */
    public static function degreeFromDecimals($value)
    {
        $degrees = (int)$value;
        $minutes = intval(($value - $degrees) * 60);
        $seconds = (($value - $degrees) * 60 - $minutes) * 60;

        return new GeoDegree($degrees, $minutes, $seconds);
    }

    /**
     * @return float
     */
    public function toDecimals()
    {
        return (($this->seconds / 60) + $this->minutes) / 60 + $this->degrees;
    }

    /**
     * @param int $degrees
     * @param int $minutes
     * @param int $seconds
     * @return float
     */
    public static function decimalsFromDegreesMinutesAndSeconds($degrees, $minutes, $seconds)
    {
        $d = new GeoDegree($degrees, $minutes, $seconds);
        return $d->toDecimals();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf("%d°%02d'%0.4g''", $this->degrees, $this->minutes, $this->seconds);
    }

} 