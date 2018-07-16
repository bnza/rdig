SELECT
        `finding`.`id` AS `id`,
        `finding`.`bucket` AS `bucket`,
        `finding`.`num` AS `num`,
        `finding`.`remarks` AS `remarks`,
        `finding`.`discr` AS `discr`,
        `finding`.`chronology` AS `chronology`,
        CASE `finding`.`discr`
			WHEN 'O' THEN `object`.`no`
            WHEN 'S' THEN `sample`.`no`
            ELSE `finding`.`num`
		END AS `no`
    FROM
        `finding`
	LEFT JOIN `object` ON `finding`.`id` = `object`.`id`
    LEFT JOIN `sample` ON `finding`.`id` = `sample`.`id`