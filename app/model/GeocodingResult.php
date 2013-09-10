<?php

namespace Clevis\Geolocation;

use Clevis\Skeleton\Entity;
use Clevis;
use Orm;
use DateTime;


/**
 * Cached result of a geotagging request
 *
 * @property Clevis\Geolocation\Position $position
 * @property Clevis\Geolocation\Address $address
 * @property-read string $addressHash
 * @property DateTime $insertedAt {default now}
 *
 * @property Orm\OneToMany $positions {1:m Clevis\Geolocation\GeocodingPositionsRepository $result}
 * @property Orm\OneToMany $queries {1:m Clevis\Geolocation\GeocodingQueriesRepository $result}
 */
class GeocodingResult extends Entity
{

	public function onBeforePersist(Orm\IRepository $repository)
	{
		parent::onBeforePersist($repository);

		if ($this->isChanged('address'))
		{
			$this->setReadonlyValue('addressHash', md5(serialize($this->getValue('address'))));
		}
	}

}
