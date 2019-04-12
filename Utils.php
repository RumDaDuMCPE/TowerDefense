<?php

namespace TowerDefense;

class Utils {

    public static generateID(array &$pSource): string {
        do {
			    $id = implode("-", array_values(array_map(function ($el) {
				    return implode("", $el);
			    }, array_chunk(str_split(md5(mt_rand(0, PHP_INT_MAX)) . md5(mt_rand(0, PHP_INT_MAX))), 4))));
		    } while (isset($pSource[$id]));
		    return substr($id, 0, 4 * 4 + 3);
    }
}
