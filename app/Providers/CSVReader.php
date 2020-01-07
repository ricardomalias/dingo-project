<?php
    namespace App\Providers;

    Class CSVReader
    {
        private static function detectDelimiter($file)
        {
            $delimiters = array(
                ';' => 0,
                ',' => 0,
                "\t" => 0,
                "|" => 0
            );

            $handle = fopen($file, "r");
            $firstLine = fgets($handle);
            fclose($handle);

            foreach ($delimiters as $delimiter => &$count) {
                $count = count(str_getcsv($firstLine, $delimiter));
            }

            return array_search(max($delimiters), $delimiters);
        }

        public static function read($file)
        {
            $delimiter = self::detectDelimiter($file);
            $data = array_map(function($v) use ($delimiter){
                return str_getcsv($v, $delimiter);
            }, file($file));

            return $data;
        }
    }