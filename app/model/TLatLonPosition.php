<?php

namespace Clevis\Geolocation;


/**
 * Get and set position of an entity
 *
 * Intended for Clevis\Skeleton\Entity with columns named 'latitude' and 'longitude'
 */
trait TLatLonPosition {

	/**
	 * @return Position|NULL
	 */
	public function getPosition()
	{
		$lon = $this->getValue('latitude');
		$lat = $this->getValue('longitude');
		if ($lon === NULL || $lat === NULL)
		{
			return NULL;
		}
		return new Position($lon, $lat);
	}

	/**
	 * @param Position
	 */
	public function setPosition(Position $position)
	{
		$this->setValue('latitude', $position->latitude);
		$this->setValue('longitude', $position->longitude);
	}

}
