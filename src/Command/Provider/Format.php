<?php

namespace App\Command\Provider;

class Format
{

    /**
     * Allows to convert the number of memory channel in letter to int
     * @param string $search
     * @return int|null
     */
    public function convertLetterChannelToInt(string $search): ?int
    {
        $new = $this->removeSpaces($search);
        $ref = [
            'Dual-channel' => 2,
            'Quad-channel' => 4,
            'Hexa-channel' => 6,
            'Hepta-channel' => 7,
            'Octa-channel' => 8
        ];
        if (isset($ref[$new])){
            return $ref[$new];
        }else{
            return null;
        }
    }

    /**
     * Allows to convert a string to a bool
     * @param String $search
     * @return int|null
     */
    public function convertYesNoToBool(string $search): ?int

    {
        $new = $this->removeSpaces($search);
        $ref = [
            'Oui' => 1,
            'Non' => 0
        ];
        if(isset($ref[$new])){
            return $ref[$new];
        }
        return null;
    }

    /**
     * Allows deleting spaces at the end of string
     * @param String $string
     * @return string
     */
    public function removeSpaces(String $string): string
    {
        // Let's check if there are spaces in the string
        if (preg_match_all('/\s+/', $string) != 0){

            // Instruction to delete spaces
            $temp = [];
            $string = $this->removeAccents($string);
            $arr1 = preg_split('/[^a-zA-Z_0-9().,-]+/', $string);

            foreach ($arr1 as $element){
                (preg_match('/[a-zA-Z_0-9().,-]+/', $element) == 1) ? array_push($temp, $element) : false;
            }

            return implode(' ', array_unique($temp));
        }

        return $string;
    }

    /**
     * Allows to convert an accent into a letter
     * @param String $word
     * @return array|string
     */
    private function removeAccents(String $word): array|string
    {
        $word = str_replace('à', 'a', $word);
        $word = str_replace('â', 'a', $word);
        $word = str_replace('é', 'e', $word);
        $word = str_replace('è', 'e', $word);
        $word = str_replace('ê', 'e', $word);
        $word = str_replace('ë', 'e', $word);
        $word = str_replace('î', 'i', $word);
        $word = str_replace('ï', 'i', $word);
        $word = str_replace('ô', 'o', $word);
        $word = str_replace('ù', 'u', $word);
        return str_replace('û', 'u', $word);
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

        if(isset($temp[$day])){
            return $temp[$day];
        }else{
            throw new Exception('No day found: '. $day);
        }
    }
}