<?php

namespace Clevis\Geolocation;

use Nette\Object;


/**
 * Saves geocoding query results in database
 */
class OrmGecodingCache extends Object implements IGeocodingCache
{

	/** @var GeocodingPositionsRepository */
	private $positions;

	/** @var GeocodingQueriesRepository */
	private $queries;

	/** @var GeocodingResultsRepository */
	private $results;


	public function __construct(
		GeocodingPositionsRepository $positions,
		GeocodingQueriesRepository $queries,
		GeocodingResultsRepository $results)
	{
		$this->positions = $positions;
		$this->queries = $queries;
		$this->results = $results;
	}

	/**
	 * Get GPS position for given address
	 *
	 * @param Address|string
	 * @param array
	 * @return Position|NULL
	 */
	function getPosition($address, $options = array())
	{
		$query = (string) $address;

		/** @var GeocodingQuery $cached */
		$cached = $this->queries->getByQuery($query);
		if ($cached)
		{
			return $cached->result->getPosition();
		}

		return NULL;
	}

	/**
	 * Get address for given GPS position
	 *
	 * @param Position
	 * @param array
	 * @return Address|NULL
	 */
	function getAddress(Position $position, $options = array())
	{
		/** @var GeocodingPosition $cached */
		$cached = $this->positions->getByPosition($position);
		if ($cached)
		{
			return $cached->result->address;
		}

		return NULL;
	}

	/**
	 * Get both position and address for given query
	 *
	 * @param string|Address|Position
	 * @param array
	 * @return array (Position|NULL, Address|NULL)
	 */
	function getPositionAndAddress($query, $options = array())
	{
		if ($query instanceof Position)
		{
			$p = $this->positions->getByPosition($query);
			if ($p)
			{
				return array($p->result->getPosition(), $p->result->address);
			}
		}
		else
		{
			$query = (string) $query;
			$q = $this->queries->getByQuery($query);
			if ($q)
			{
				return array($q->result->getPosition(), $q->result->address);
			}
		}

		return array(NULL, NULL);
	}

	/**
	 * Save geocoding results
	 *
	 * @param Position
	 * @param Address
	 * @param string|Address|Position
	 * @param array
	 */
	function saveResult(Position $position, Address $address, $query, $options = array())
	{
		if ($query instanceof Address)
		{
			$query = (string) $query;
		}

		$result = $this->results->getByAddress($address);
		if (!$result)
		{
			// ukládá výsledek
			$result = new GeocodingResult;
			$result->address = $address;
			$result->setPosition($position);
			$this->results->persist($result);

			// a jeho vrácenou pozici
			$p = new GeocodingPosition;
			$p->setPosition($position);
			$p->result = $result;

			// a jeho vrácenou adresy jako query
			$q = new GeocodingQuery;
			$q->query = (string) $address;
			$q->result = $result;

			// a jeho původní query
			if ($query instanceof Position)
			{
				if ($query->latitude !== $position->latitude && $query->longitude !== $position->longitude)
				{
					$p = new GeocodingPosition;
					$p->setPosition($query);
					$p->result = $result;
				}
			}
			else
			{
				if ((string) $address !== $query)
				{
					$q = new GeocodingQuery;
					$q->query = $query;
					$q->result = $result;
				}
			}
		}
		elseif ($query instanceof Position)
		{
			// doplňuje novou pozici, která vede na adresu
			$p = $this->positions->getByPosition($query);
			if (!$p)
			{
				$p = new GeocodingPosition;
				$p->setPosition($query);
				$p->result = $result;
			}
		}
		else
		{
			// doplňuje novou query, která vede na adresu
			$q = $this->queries->getByQuery($query);
			if (!$q)
			{
				$q = new GeocodingQuery;
				$q->query = $query;
				$q->result = $result;
			}
		}
	}

}
