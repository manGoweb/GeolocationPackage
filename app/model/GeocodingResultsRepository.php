<?php

namespace Clevis\Geolocation;

use Clevis\Skeleton\Repository;


/**
 *
 */
class GeocodingResultsRepository extends Repository
{

	/**
	 * @param Address
	 * @return GeocodingResult
	 */
	public function getByAddress(Address $address)
	{
		$hash = md5(serialize($address));
		return $this->mapper->getByAddressHash($hash);
	}

}
