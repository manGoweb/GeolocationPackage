<?php

namespace Clevis\Geolocation;

use Clevis\Skeleton\Mapper;
use Orm;


/**
 *
 */
class GeocodingPositionsMapper extends Mapper
{

	public function __construct(Orm\IRepository $repository)
	{
		parent::__construct($repository);

		$this->repository->getEvents()->addCallbackListener(Orm\Events::SERIALIZE_BEFORE, function (Orm\EventArguments $args) {
			if ($args->params['position'])
			{
				$args->values['latitude'] = $args->values['position']->latitude;
				$args->values['longitude'] = $args->values['position']->longitude;
				$args->params['latitude'] = TRUE;
				$args->params['longitude'] = TRUE;
				unset($args->values['position']);
				unset($args->params['position']);
			}
		});

		$this->repository->getEvents()->addCallbackListener(Orm\Events::HYDRATE_BEFORE, function (Orm\EventArguments $args) {
			$args->data['position'] = new Position($args->data['latitude'], $args->data['longitude']);
		});
	}

	/**
	 * @param Position
	 * @return GeocodingPosition
	 */
	public function getByPosition(Position $position)
	{
		return $this->dataSource(
			"SELECT * FROM [geocoding_positions]
			WHERE [latitude] BETWEEN %f AND %f", $position->latitude - 1e-6, $position->latitude + 1e-6, "
				AND [longitude] BETWEEN %f AND %f", $position->longitude - 1e-6, $position->longitude + 1e-6
		)->fetch();
	}

}
