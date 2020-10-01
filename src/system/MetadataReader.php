<?php

namespace Cuttlefish;

class MetadataReader
{
	/**
	 * @param $subject
	 *
	 * @return array
	 */
	public function loadString($subject): array {
        $data = [];

        $separator = "\r\n";
        $line = strtok($subject, $separator);

        while ($line !== false) {
            # do something with $line
            [ $key, $value ] = explode( ':', $line, 2 );
            $data[$key] = $value;

            $line = strtok($separator);
        }

        return $data;
    }
}
