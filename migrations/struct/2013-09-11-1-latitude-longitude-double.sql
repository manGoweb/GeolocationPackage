ALTER TABLE `geocoding_results`
	MODIFY `latitude` double NOT NULL COMMENT 'zeměpisná šířka',
	MODIFY `longitude` double NOT NULL COMMENT 'zeměpisná délka';

ALTER TABLE `geocoding_positions`
	MODIFY `latitude` double NOT NULL COMMENT 'zeměpisná šířka',
	MODIFY `longitude` double NOT NULL COMMENT 'zeměpisná délka';
