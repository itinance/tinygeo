<?php

/*
 * This file is part of the tinygeo package.
 *
 * (C) ITinance GmbH <http://https://github.com/itinance/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace tinygeo\data;


class GeoRectangle
{

    /**
     * @var GeoPoint
     */
    protected $northWest;

    /**
     * @var GeoPoint
     */
    protected $northEast;

    /**
     * @var GeoPoint
     */
    protected $southWest;

    /**
     * @var GeoPoint
     */
    protected $southEast;

    /**
     * @param GeoPoint $northWest
     * @param GeoPoint $northEast
     * @param GeoPoint $southEast
     * @param GeoPoint $southWest
     */
    public function __construct(GeoPoint $northWest, GeoPoint $northEast, GeoPoint $southEast, GeoPoint $southWest)
    {
        $this->northWest = $northWest;
        $this->northEast = $northEast;
        $this->southWest = $southWest;
        $this->southEast = $southEast;
    }

    /**
     * @return float
     */
    public function getWidth()
    {
        return GeoCalculation::getDistanceBetween($this->northWest, $this->northEast);
    }

    /**
     * @return float
     */
    public function getHeight()
    {
        return GeoCalculation::getDistanceBetween($this->northWest, $this->southWest);
    }

    /**
     * @param int $precision
     * @param bool $fixedPrecisionLength
     * @return string
     */
    public function getString($precision, $fixedPrecisionLength = false)
    {
        return sprintf(
            "%s:%s - %s:%s",
            $this->northWest->getString($precision, $fixedPrecisionLength),
            $this->southWest->getString($precision, $fixedPrecisionLength)
        );
    }

    public function __toString()
    {
        return $this->getString(5, false);
    }

    /**
     * @return GeoPoint
     */
    public function getNorthWest()
    {
        return $this->northWest;
    }

    /**
     * @return GeoPoint
     */
    public function getNorthEast()
    {
        return $this->northEast;
    }

    /**
     * @return GeoPoint
     */
    public function getSouthWest()
    {
        return $this->southWest;
    }

    /**
     * @return GeoPoint
     */
    public function getSouthEast()
    {
        return $this->southEast;
    }
} 