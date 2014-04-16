<?php

namespace HieuLe\WordpressXmlrpcClientTest;

/**
 * Test media API
 * 
 * @link http://codex.wordpress.org/XML-RPC_WordPress_API/Media
 *
 * @author TrungHieu
 */
class WordpressClientMediaComponentTest extends TestCase
{
	/**
	 * @vcr media/test-get-media-item-vcr.yml
	 */
	public function testGetMediaItem()
	{
		$media = $this->client->getMediaItem(229);
		$this->assertNotEmpty($media);
		$this->assertSame('http://WP_DOMAIN/wp-content/uploads/2014/03/Penthouse-sea-view.jpg', $media['link']);
	}
	
	/**
	 * @vcr media/test-get-media-item-no-privilege-vcr.yml
	 */
	public function testGetMediaItemNoPrivilege()
	{
		$media = $this->guestClient->getMediaItem(229);
		$this->assertFalse($media);
		$this->assertSame('xmlrpc: You do not have permission to upload files. (403)', $this->guestClient->getErrorMessage());
	}
	
	/**
	 * @vcr media/test-get-media-item-no-exist-vcr.yml
	 */
	public function testGetMediaItemNoExist()
	{
		$media = $this->client->getMediaItem(999);
		$this->assertFalse($media);
		$this->assertSame('xmlrpc: Invalid attachment ID. (404)', $this->client->getErrorMessage());
	}
	
	/**
	 * @vcr media/test-get-media-library-vcr.yml
	 */
	public function testGetMediaLibrary()
	{
		$medias = $this->client->getMediaLibrary();
		$this->assertCount(10, $medias);
		$this->assertArrayHasKey('link', $medias[0]);
	}
	
	/**
	 * @vcr media/test-get-media-library-with-filter-vcr.yml
	 */
	public function testGetMediaLibraryWithFilter()
	{
		$medias = $this->client->getMediaLibrary(array('number' => 5));
		$this->assertCount(5, $medias);
		$this->assertArrayHasKey('link', $medias[0]);
	}
	
	/**
	 * @vcr media/test-get-media-library-no-privilege-vcr.yml
	 */
	public function testGetMediaLibraryNoPrivilege()
	{
		$medias = $this->guestClient->getMediaLibrary();
		$this->assertFalse($medias);
		$this->assertSame('xmlrpc: You do not have permission to upload files. (401)', $this->guestClient->getErrorMessage());
	}
}