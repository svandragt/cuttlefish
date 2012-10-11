<?php

class CacheTest extends PHPUnit_Framework_TestCase {


	public function test_has_cacheable_page_request() {
		$request = Cache::has_cacheable_page_request();
		$this->assertEquals(false, $request);
		Cache::start();
		$request = Cache::has_cacheable_page_request();
		$this->assertEquals(true, $request);
		Cache::end();
	}

	public function test_cache_file_from_url() {
		$path = Cache::cache_file_from_url();
		$this->assertEquals(true, $path);
		$path = Cache::cache_file_from_url('/index');
		$this->assertEquals(true, $path);
	}

}