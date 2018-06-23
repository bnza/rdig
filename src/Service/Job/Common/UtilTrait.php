<?php

namespace App\Service\Job\Common;


trait UtilTrait
{
    /**
     * Extracts area code from name
     * @param $name
     * @return string
     */
    function getAreaCodeFromName($name): string
    {
        /**
         * @var bool|int
         */
        $baseCodeIndex = false;
        /**
         * @var string
         */
        $code = '';
        /**
         * The code pieces
         * @var array
         */
        $codes = [];
        // split every word from name
        preg_match_all("/\w+/i", $name, $matches);

        // extract base code 'A', 'A1' etc and pieces
        foreach ($matches[0] as $match) {
            if (preg_match('/^[[:upper:]]?\d?$/', $match)) {
                $baseCodeIndex = count($codes);
                $codes[] = $match;
            } else if (preg_match('/^\d[[:alpha:]]?$/', $match)) {
                $codes[] = strtoupper($match);
            } else if (strtolower($match) !== 'area') {
                $length = count($matches[0]) === 1 ? 3 : 1;
                $codes[] = strtoupper(substr($match, 0, $length));
            }
        }


        $length = $baseCodeIndex === false ? 0 : strlen($codes[$baseCodeIndex]);

        // iterate up to 3 char length code
        for ($i = 0; strlen($code) + $length < 3; $i++) {
            if (array_key_exists($i, $codes)) {
                if ($i !== $baseCodeIndex) {
                    $code .= $codes[$i];
                }
            } else {
                break;
            }
        }

        if ($baseCodeIndex === false) {
            // No base code
            if (count($codes) === 1) {
                // 1 word
                $code = strtoupper(substr($codes[0], 0, 3));
            } else {
                // more words
                $code = implode("", $codes);
            }
        } else if ($baseCodeIndex === 0) {
            // prepend base code
            $code = $codes[$baseCodeIndex] . $code;
        } else {
            // append base code
            $code .= $codes[$baseCodeIndex];
        }

        return $code;
    }
}