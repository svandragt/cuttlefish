<?php

use VanDragt\Carbon;

class CacheTest extends PHPUnit_Framework_TestCase {


	public function test_has_cacheable_page_request() {
		$request = Carbon\Cache::has_cacheable_page_request();
		$this->assertEquals(false, $request);
		Carbon\Cache::start();
		$request = Carbon\Cache::has_cacheable_page_request();
		$this->assertEquals(true, $request);
		Carbon\Cache::end();
	}

	public function test_cache_file_from_url() {
		$path = Carbon\Cache::cache_file_from_url();
		$this->assertEquals(true, $path);
		$path = Carbon\Cache::cache_file_from_url('/index');
		$this->assertEquals(true, $path);
	}

}