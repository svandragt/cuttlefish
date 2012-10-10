<?php

class CarbonTest extends PHPUnit_Framework_TestCase {
	
	public function test_path_info() {
		$empty = Carbon::path_info();
		$this->assertEquals(0, $empty);
	}
}