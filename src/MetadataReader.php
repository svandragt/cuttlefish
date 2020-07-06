<?php

namespace Cuttlefish;

class MetadataReader
{
    public function __construct()
    {
    }

    /**
     * @return string[]
     *
     * @psalm-return array<string, string>
     */
    public function loadString(string $subject): array
    {
        $data = [];

        $separator = "\r\n";
        $line = strtok($subject, $separator);

        while ($line !== false) {
            # do something with $line
            list($key,$value) = explode(':', $line, 2);
            $data[$key] = $value;

            $line = strtok($separator);
        }

        return $data;
    }
}
