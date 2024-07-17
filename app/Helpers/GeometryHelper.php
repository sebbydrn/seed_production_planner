<?php

namespace App\Helpers;

class GeometryHelper
{
    public static function textToPolygon($text)
    {
        $points = explode(';', $text);
        $polygon = [];
        foreach ($points as $point) {
            list($lat, $lng) = explode(',', trim($point));
            $polygon[] = ['lat' => (float) $lat, 'lng' => (float) $lng];
        }
        return $polygon;
    }

    public static function polygonsOverlap($poly1, $poly2)
    {
        foreach ($poly1 as $p1) {
            if (self::pointInPolygon($p1, $poly2)) {
                return true;
            }
        }
        foreach ($poly2 as $p2) {
            if (self::pointInPolygon($p2, $poly1)) {
                return true;
            }
        }
        return false;
    }

    public static function pointInPolygon($point, $polygon)
    {
        $x = $point['lat'];
        $y = $point['lng'];
        $inside = false;
        for ($i = 0, $j = count($polygon) - 1; $i < count($polygon); $j = $i++) {
            $xi = $polygon[$i]['lat'];
            $yi = $polygon[$i]['lng'];
            $xj = $polygon[$j]['lat'];
            $yj = $polygon[$j]['lng'];

            $intersect = (($yi > $y) != ($yj > $y)) && ($x < ($xj - $xi) * ($y - $yi) / ($yj - $yi) + $xi);
            if ($intersect) $inside = !$inside;
        }
        return $inside;
    }
}
