<?php

namespace Clevis\Geolocation;

use Clevis\Skeleton\Mapper;
use Orm;


/**
 *
 */
class GeocodingResultsMapper extends Mapper
{

	public function __construct(Orm\IRepository $repository)
	{
		parent::__construct($repository);

		$this->repository->getEvents()->addCallbackListener(Orm\Events::SERIALIZE_BEFORE, function (Orm\EventArguments $args) {
			$args->values['address'] = serialize($args->values['address']);
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
			$args->data['address'] = unserialize($args->data['address']);
			$args->data['position'] = new Position($args->data['latitude'], $args->data['longitude']);
		});
	}

}
