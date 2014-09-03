<?php
/*
 * This file is part of the tinygeo package.
 *
 * (C) ITinance GmbH <http://https://github.com/itinance/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use tinygeo\calculation\GeoCalculation;
use tinygeo\data\GeoDegree;
use tinygeo\data\GeoPoint;

class GeoCalculationTests extends PHPUnit_Framework_TestCase
{

    public function testGetDestinationWithDistanceAndBearing45() {

        $p1 = new GeoPoint(48.135993, 11.539721);

        $destination = GeoCalculation::getDestinationWithDistanceAndBearing($p1, 1.200, 45);

        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(48, 8, 37), $destination->lat, '', 0.001 );
        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(11, 33, 04), $destination->lng, '', 0.001 );
    }

    public function testGetDestinationWithDistanceAndBearing270() {

        $p1 = new GeoPoint(48.135993, 11.539721);

        $destination = GeoCalculation::getDestinationWithDistanceAndBearing($p1, 1.200, 270);

        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(48, 8, 10), $destination->lat, '', 0.001 );
        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(11, 31, 25), $destination->lng, '', 0.001 );
    }

    public function testMoveLeft() {

        $p1 = new GeoPoint(48.135993, 11.539721);

        $destination = GeoCalculation::movePointToRight($p1, 1.200);

        // => 48°08′10″N, 011°31′25″E

        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(48, 8, 10), $destination->lat, '', 0.001 );
        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(11, 31, 25), $destination->lng, '', 0.001 );
    }

    public function testMoveRight() {

        $p1 = new GeoPoint(48.135993, 11.539721);

        $destination = GeoCalculation::movePointToLeft($p1, 1.200);

        // => 48°08′10″N, 011°33′21″E

        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(48, 8, 10), $destination->lat, '', 0.001 );
        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(11, 33, 21), $destination->lng, '', 0.001 );
    }

    public function testMoveUp() {

        $p1 = new GeoPoint(48.135993, 11.539721);

        $destination = GeoCalculation::movePointUpwards($p1, 1.200);

        // => 48°08′48″N, 011°32′23″E

        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(48, 8, 48), $destination->lat, '', 0.001 );
        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(11, 32, 23), $destination->lng, '', 0.001 );
    }

    public function testMoveDownwords() {

        $p1 = new GeoPoint(48.135993, 11.539721);

        $destination = GeoCalculation::movePointDownwards($p1, 1.200);

        // => 48°07′31″N, 011°32′23″E

        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(48, 7, 31), $destination->lat, '', 0.001 );
        $this->assertEquals( GeoDegree::decimalsFromDegreesMinutesAndSeconds(11, 32, 23), $destination->lng, '', 0.001 );
    }


}