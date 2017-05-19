<?php

/**
 *
 * EVStation test class
 *
 * PHP API wrapper for locating electric vehicle charging stations on NREL
 * National Renewable Energy Laboratory (NREL) API v1: https://developer.nrel.gov
 *
 * @author Johnathan Miller <hello@johnathanmiller.com>
 * @version 1.0.0
 *
 */

use \JohnathanMiller\EVStation\EVStation;

class EVStationTest extends PHPUnit_Framework_TestCase {

	private $evStation;

	protected function setUp() {
		$this->evStation = new EVStation('DEMO_KEY', 'json');
	}

	public function testGetAll() {
		$result = $this->evStation->getAll([]);
		$this->assertEquals(200, $result['status_code']);
		$this->assertNotEmpty($result['response']);
		$this->assertArrayHasKey('total_results', $result['response']);
		$this->assertArrayHasKey('fuel_stations', $result['response']);
	}

	public function testGetAllWithZip() {
		$result = $this->evStation->getAll(['zip' => 98004]);
		$this->assertEquals(200, $result['status_code']);
		$this->assertNotEmpty($result['response']);
		$this->assertArrayHasKey('total_results', $result['response']);
		$this->assertArrayHasKey('fuel_stations', $result['response']);
	}

	public function testGetAllWithState() {
		$result = $this->evStation->getAll(['state' => 'WA']);
		$this->assertEquals(200, $result['status_code']);
		$this->assertNotEmpty($result['response']);
		$this->assertArrayHasKey('total_results', $result['response']);
		$this->assertArrayHasKey('fuel_stations', $result['response']);
	}

	public function testGet() {
		$result = $this->evStation->get(1000);
		$this->assertEquals(200, $result['status_code']);
		$this->assertNotEmpty($result['response']);
		$this->assertArrayHasKey('alt_fuel_station', $result['response']);
	}

	public function testNearest() {
		$result = $this->evStation->nearest(['location' => 'Bellevue, WA'], 10, 0);
		$this->assertEquals(200, $result['status_code']);
		$this->assertNotEmpty($result['response']);
		$this->assertArrayHasKey('total_results', $result['response']);
		$this->assertArrayHasKey('fuel_stations', $result['response']);
	}

	public function testNearbyRoute() {
		$result = $this->evStation->nearbyRoute(['route' => 'LINESTRING(-74.0 40.7, -87.63 41.87, -104.98 39.76)']);
		$this->assertEquals(200, $result['status_code']);
		$this->assertNotEmpty($result['response']);
		$this->assertArrayHasKey('total_results', $result['response']);
		$this->assertArrayHasKey('fuel_stations', $result['response']);
	}

	public function testLastUpdated() {
		$result = $this->evStation->lastUpdated();
		$this->assertEquals(200, $result['status_code']);
		$this->assertNotEmpty($result['response']);
		$this->assertArrayHasKey('last_updated', $result['response']);
	}

}