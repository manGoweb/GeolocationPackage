<?php

namespace Clevis\Geolocation;

use Clevis\Skeleton\Entity;
use Clevis;
use Orm;
use DateTime;


/**
 * Cached result of a geotagging request
 *
 * @property Clevis\Geolocation\Address $address
 * @property-read string $addressHash
 * @property-read float $latitude
 * @property-read float $longitude
 * @property DateTime $insertedAt {default now}
 *
 * @property Orm\OneToMany $positions {1:m Clevis\Geolocation\GeocodingPositionsRepository $result}
 * @property Orm\OneToMany $queries {1:m Clevis\Geolocation\GeocodingQueriesRepository $result}
 */
class GeocodingResult extends Entity
{
	use TLatLonPosition;


	public function onBeforePersist(Orm\IRepository $repository)
	{
		if ($this->isChanged('address'))
		{
			$this->setValue('addressHash', md5(serialize($this->getValue('address'))));
		}
	}

}
