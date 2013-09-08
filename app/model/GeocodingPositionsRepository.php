<?php

namespace Clevis\Geolocation;

use Clevis\Skeleton\Repository;


/**
 *
 */
class GeocodingPositionsRepository extends Repository
{

	/**
	 * @param Position
	 * @return GeocodingPosition
	 */
	public function getByPosition(Position $position)
	{
		return $this->mapper->getByLatitudeAndLongitude($position->latitude, $position->longitude);
	}

}
