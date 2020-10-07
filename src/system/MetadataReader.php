<?php

namespace Cuttlefish;

class MetadataReader
{
    /**
     * @param $subject
     *
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
            [ $key, $value ] = explode(':', $line, 2);
            $data[$key] = $value;

            $line = strtok($separator);
        }

        return $data;
    }
}
