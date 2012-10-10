<?php

class CacheTest extends PHPUnit_Framework_TestCase {


	public function test_has_cacheable_page_request_no_cache() {
		$this->assertEquals(false, Cache::has_cacheable_page_request());
	}

	public function test_has_cacheable_page_request_with_cache() {
		Cache::start();
		$this->assertEquals(true, Cache::has_cacheable_page_request());
		Cache::end();
	}

	public function test_cache_file_from_url_null() {
		$this->assertEquals(true, Cache::cache_file_from_url());
	}

	public function test_cache_file_from_url_path_info() {
		$path = Cache::cache_file_from_url('/index');
		$this->assertEquals(true, $path);
	}

}