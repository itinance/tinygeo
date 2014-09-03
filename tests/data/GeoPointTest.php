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

}