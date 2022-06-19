<?php

namespace App\Command\Provider;

use Exception;

class Format
{

    /**
     * Allows to convert the number of memory channel in letter to int
     * @param string $search
     * @return int|null
     */
    public function convertLetterChannelToInt(string $search): ?int
    {
        $new = preg_replace('/\W-/', '', $search);
        $ref = [
            'Dual-channel' => 2,
            'Quad-channel' => 4,
            'Hexa-channel' => 6,
            'Hepta-channel' => 7,
            'Octa-channel' => 8
        ];
        return $ref[$new] ?? null;
    }

    /**
     * Allows to convert a string to a bool
     * @param String $search
     * @return int|null
     */
    public function convertYesNoToBool(string $search): ?int

    {
        $new = preg_replace('/\W/', '', $search);
        $ref = [
            'Oui' => 1,
            'Non' => 0
        ];
        if(isset($ref[$new])){
            return $ref[$new];
        }
        return null;
    }

    public function removeSpaces(String $string): string
    {
        setlocale(LC_ALL, 'fr_FR@euro');
        $string = utf8_decode($string);

        // Spaces are identified with characters at the beginning and end
        preg_match_all('/\w\s\w/', $string, $spaceWithLetter);

        foreach ($spaceWithLetter as $element) {
            $string = str_replace($element, preg_replace('/\s/', '-', $element), $string);
        }

        // We delete all spaces in the string
        preg_match_all('/\s/', $string, $output);
        foreach ($output[0] as $element) {
            $string = str_replace($element, '', $string);
        }

        return utf8_encode($string);
    }

    /**
     * Allows to return the product availability in int
     * @param string $availability
     * @return int
     */
    public function convertAvaiability(string $availability): int
    {
        $new_val = explode(' ', $this->removeSpaces($availability))[0];
        return (str_contains($new_val, '-')) ? intval(explode('-', $new_val)[0]) : intval($new_val);
    }

    /**
     * Allows to convert a month in French to English
     * @param String $month
     * @return string
     * @throws Exception
     */
    public function convertMonthEnglish(String $month): string
    {
        $month = lcfirst($month); // convert to lower
        $month = str_replace(array('é', 'û'), array('e', 'u'), $month); // Delete Space character
        $month = $this->removeSpaces($month); // remove space(s)
        $temp = [
            'janvier' => 'jan',
            'fevrier' => 'feb',
            'mars' => 'mar',
            'avril' => 'apr',
            'mai' => 'may',
            'juin'=> 'jun',
            'juillet' => 'jul',
            'aout' => 'aug',
            'septembre' => 'sep',
            'octobre' => 'oct',
            'novembre' => 'nov',
            'decembre' => 'dec'
        ];
        if (isset($temp[$month])){
            return $temp[$month];
        }else{
            throw new Exception('No month found: '. $month);
        }

    }

    /**
     * Allows to convert a day in French to English
     * @param String $day
     * @return string
     * @throws Exception
     */
    public function convertDayEnglish(String $day): string
    {
        $day = lcfirst($day); // convert to lower
        $day = $this->removeSpaces($day); // remove space(s)

        $temp = [
            'lundi' => 'monday',
            'mardi' => 'tuesday',
            'mercredi' => 'wednesday',
            'jeudi' => 'thursday',
            'vendredi' => 'friday',
            'samedi' => 'saturday',
            'dimanche' => 'sunday'
        ];

        if (isset($temp[$day])) {
            return $temp[$day];
        } else {
            throw new Exception('No day found: ' . $day);
        }
    }

    /**
     * Allows to convert an out-of-stock string to int
     * @param string $word
     * @return null
     * @throws Exception
     */
    public function convertOutOfStock(string $word)
    {
        if ($word == 'En rupture de stock') {
            return null;
        }
        throw new Exception('Error with Format\convertOutOfStock method');
    }
}