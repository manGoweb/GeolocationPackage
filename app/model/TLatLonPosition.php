<?php

namespace Clevis\Geolocation;


/**
 * Get and set position of an entity
 *
 * Intended for Clevis\Skeleton\Entity with columns named 'latitude' and 'longitude'
 */
trait TLatLonPosition {

	/**
	 * @return Position
	 */
	public function getPosition()
	{
		return new Position($this->getValue('latitude'), $this->getValue('longitude'));
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
