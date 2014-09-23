<?php
/*
 * This file is part of the tinygeo package.
 *
 * (C) ITinance GmbH <https://github.com/itinance/>
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

    public function testBoundingBox() {
        $center = new GeoPoint(48.135993, 11.539721);

        $box = GeoCalculation::getBoundingBox($center, 0.7); // 700m
        $this->assertEquals( new GeoPoint( 48.1404443, 11.54637187 ),  $box->getNorthEast(), '', 0.001 );
        $this->assertEquals( new GeoPoint( 48.1404443, 11.53307013 ),  $box->getNorthWest(), '', 0.001 );
        $this->assertEquals( new GeoPoint( 48.13154, 11.53307013 ),  $box->getSouthWest(), '', 0.001 );
        $this->assertEquals( new GeoPoint( 48.13154, 11.54637187 ),  $box->getSouthEast(), '', 0.001 );
    }

    public function testSpecialCaseTicket0001() {
        $p = new GeoPoint(48.0644576, 11.3480854);
        $destination = GeoCalculation::getDestinationWithDistanceAndBearing($p, 1.0, 45);

        $this->assertEquals(48.07081656, $destination->lat, '', 0.0001);
        $this->assertEquals(11.35757382, $destination->lng, '', 0.0001);
    }

    public function testSpecialCaseTicket0001WithBoundingBox() {
        $p = new GeoPoint(48.0644576, 11.3480854);

        $rect = GeoCalculation::getBoundingBox($p, 1.0);


        $this->assertEquals(48.07081656, $rect->getNorthEast()->lat, '', 0.0001);
        $this->assertEquals(11.35757382, $rect->getNorthEast()->lng, '', 0.0001);

        $this->assertEquals(48.07081656, $rect->getNorthWest()->lat, '', 0.0001);
        $this->assertEquals(11.33859698, $rect->getNorthWest()->lng, '', 0.0001);

        $this->assertEquals(48.05809785, $rect->getSouthWest()->lat, '', 0.0001);
        $this->assertEquals(11.33859932, $rect->getSouthWest()->lng, '', 0.0001);

        $this->assertEquals(48.05809785, $rect->getSouthEast()->lat, '', 0.0001);
        $this->assertEquals(11.35757148, $rect->getSouthEast()->lng, '', 0.0001);

    }

}