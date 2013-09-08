<?php

namespace Clevis\Geolocation;

use Clevis\Skeleton\Entity;
use Clevis;


/**
 * Position used for geotagging request
 *
 * @property-read float $latitude
 * @property-read float $longitude
 *
 * @property Clevis\Geolocation\GeocodingResult $result {m:1 Clevis\Geolocation\GeocodingResultsRepository $positions}
 */
class GeocodingPosition extends Entity
{
	use TLatLonPosition;

	//
}
