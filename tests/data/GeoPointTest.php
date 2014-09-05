<?php
/*
 * This file is part of the tinygeo package.
 *
 * (C) ITinance GmbH <https://github.com/itinance/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use tinygeo\data\GeoPoint;

class GeoPointTests extends PHPUnit_Framework_TestCase
{

    public function testGeoPointEqual()
    {
        $p1 = new GeoPoint(1.234, 2.3456);
        $p2 = new GeoPoint(1.234, '2.3456');

        $this->assertTrue($p1->isEqualTo($p2));
        $this->assertTrue($p2->isEqualTo($p1));
    }

    public function testGeoPointNotEqual()
    {
        $p1 = new GeoPoint(1.234, 2.3456);
        $p2 = new GeoPoint(1.234, 4.56);

        $this->assertFalse($p1->isEqualTo($p2));
        $this->assertFalse($p2->isEqualTo($p1));
    }

    public function testInitFromDegreeRepresentingString() {
        $p1 = new GeoPoint("48°07'31.5''", "011°32'23''");

        $this->assertEquals(48.125417, $p1->lat, '', 0.000001);
        $this->assertEquals(11.539722, $p1->lng, '', 0.000001);
    }

    public function testGetDegreeRepresentingString() {
        $p1 = new GeoPoint(48.125417, 11.539722);
        $this->assertEquals("48°07'31.5'',11°32'23''", $p1->getStringAsDegreeMinuteSecond());
    }

}