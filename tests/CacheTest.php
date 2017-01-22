<?php

use VanDragt\Carbon;

class CacheTest extends PHPUnit_Framework_TestCase {


	public function test_has_cacheable_page_request() {
		$cache = new Carbon\Cache($this);
		$request = $cache->has_cacheable_page_request();
		$this->assertEquals(false, $request);
		$cache->start();
		$request = $cache->has_cacheable_page_request();
		$this->assertEquals(true, $request);
		$cache->end();
	}

	public function test_cache_file_from_url() {
		$cache = new Carbon\Cache($this);
		$path = $cache->cache_file_from_url();
		$this->assertEquals(true, $path);
		$path = $cache->cache_file_from_url('/index');
		$this->assertEquals(false, $path);
	}

}