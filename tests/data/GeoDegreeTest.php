<?php
/*
 * This file is part of the tinygeo package.
 *
 * (C) ITinance GmbH <http://https://github.com/itinance/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use tinygeo\data\GeoDegree;

class GeoDegreeTests extends PHPUnit_Framework_TestCase {

    public function testDegreeToString() {
        $d = new GeoDegree(16, 30, 1.234);
        $this->assertEquals("16° 30' 1.234''", (string) $d);
    }

    public function testDegreesFromDecimal() {
        $d = GeoDegree::degreeFromDecimals(16.324525);
        $this->assertEquals((string)$d, "16° 19' 28.29''");

    }

    public function testDegreesToDecimal() {
        $d = new GeoDegree(16, 19, 28.29);
        $this->assertEquals(16.324525, $d->toDecimals());
    }

    public function testDegreesToDecimal2() {
        $d = new GeoDegree(48, 8, 37);
        $this->assertEquals(48.14361, $d->toDecimals(), '', 0.0001);
    }

    public function testDegreesToDecimal3() {
        $d = new GeoDegree(11, 33, 4);
        $this->assertEquals(11.5511, $d->toDecimals(), '', 0.0001);
    }

    public function testDegreesFromString() {
        $d = GeoDegree::fromString("48° 08' 10''");
        $this->assertEquals( 48, $d->degrees );
        $this->assertEquals( 8, $d->minutes );
        $this->assertEquals( 10, $d->seconds);
    }

}