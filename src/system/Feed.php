<?php

namespace VanDragt\Carbon;

if ( ! defined( 'BASE_FILEPATH' ) ) {
	exit( 'No direct script access allowed' );
}

class Feed {

	private $xml;

	/**
	 * Feed constructor.
	 *
	 * @param $posts
	 */
	function __construct( $posts ) {
		$PageUrl = new Url( $_SERVER['PATH_INFO'] );
		$Xml     = new \SimpleXMLElement( '<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom"></rss>' );
		$Channel = $Xml->addChild( 'channel' );

		$Channel->addChild( 'title', \Configuration::SITE_TITLE );
		$Channel->addChild( 'link', $PageUrl->url_absolute );
		$Channel->addChild( 'description', strip_tags( \Configuration::SITE_MOTTO ) );

		$Channel->addChild( 'pubDate', date( DATE_RSS ) );

		$Atom = $Channel->addChild( 'link', '', 'http://www.w3.org/2005/Atom' );
		$Atom->addAttribute( 'href', $PageUrl->url_relative );
		$Atom->addAttribute( 'rel', 'self' );
		$Atom->addAttribute( 'type', 'application/rss+xml' );

		foreach ( $posts as $post ) {
			$Item = $Channel->addChild( 'item' );
			$Item->addChild( 'title', $post->content->title );
			$Item->addChild( 'link', $post->link );
			$Item->addChild( 'guid', $post->link );
			$Item->addChild( 'description', $post->content->main );
			$Item->addChild( 'pubDate', date( DATE_RSS, strtotime( $post->metadata->Published ) ) );
		}
		$this->xml = $Xml;
		$this->render();
	}

	function render() {
		header( 'Content-type: application/xml' );
		echo $this->xml->asXML();
	}
}