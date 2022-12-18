<?php

namespace DeGraciaMathieu\SmellyCodeDetector;

class SignatureParser
{
    public static function parse(array $arguments): array
    {
        $booleans = $references = $nullables = 0;

        foreach ($arguments as $argument) {

            Argument::from($argument);

            if (Argument::itsBoolean()) {
                $booleans++;
            }

            if (Argument::itsReference()) {
                $references++;
            }

            if (Argument::itsNullable()) {
                $nullables++;
            }
        }

        return [
            'count' => count($arguments),
            'booleans' => $booleans,
            'references' => $references,
            'nullables' => $nullables,
        ];
    }
}
