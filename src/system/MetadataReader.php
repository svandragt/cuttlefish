<?php

namespace Cuttlefish;


class MetadataReader
{
    public function __construct()
    {
    }

    public function loadString($subject) {
        $data = [];

        $separator = "\r\n";
        $line = strtok($subject, $separator);

        while ($line !== false) {
            # do something with $line
            list($key,$value) = explode(':', $line,2);
            $data[$key] = $value;

            $line = strtok( $separator );
        }

        return $data;
    }
}
