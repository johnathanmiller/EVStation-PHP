<?php

/**
 *
 * PHP API wrapper for locating electric vehicle charging stations on NREL
 * National Renewable Energy Laboratory (NREL) API v1: https://developer.nrel.gov
 *
 * @author Johnathan Miller <hello@johnathanmiller.com>
 * @version 1.0.0
 *
 */

namespace JohnathanMiller\EVStation;

class EVStation {

	private $api_endpoint = 'https://developer.nrel.gov/api/alt-fuel-stations/v1';
	private $api_key;
	private $format;
	private $data;
	private $url;

	public function __construct($api_key, $format) {

		$this->api_key = $api_key;
		$this->format = $format;
		$this->data = [
			'api_key' => $this->api_key,
			'format' => $this->format
		];

	}

	/**
	 *
	 * Retrieve all stations
	 * Return a full list of electric charging stations that match your query.
	 *
	 * @param array $data
	 * @param int $limit
	 * @return array
	 *
	 */

	public function getAll($data, $limit = 20) {

		$this->data['fuel_type'] = 'ELEC';
		$this->data['limit'] = ($limit < 1) ? 1 : $limit;

		foreach ($data as $k => $v) {
			$this->data[$k] = $v;
		}

		$params = http_build_query($this->data);
		$this->url = $this->api_endpoint .'?'. $params;

		return $this->request('GET', $this->url);

	}

	/**
	 *
	 * Retrieve station directly by ID.
	 * Fetch the details of a specific electric charging station given the station's ID.
	 *
	 * @param int $id
	 * @return array
	 *
	 */

	public function get($id) {

		$params = http_build_query($this->data);
		$this->url = $this->api_endpoint .'/'. $id .'?'. $params;

		return $this->request('GET', $this->url);

	}

	/**
	 *
	 * Return the nearest electric charging stations within a distance of a given location.
	 *
	 * @param array $data
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 *
	 */

	public function nearest($data, $limit = 20, $offset = null) {

		$this->data['fuel_type'] = 'ELEC';
		$this->data['limit'] = ($limit < 1) ? 1 : $limit;

		if (!is_null($offset)) {
			$this->data['offset'] = $offset;
		}

		foreach ($data as $k => $v) {
			$this->data[$k] = $v;
		}

		$params = http_build_query($this->data);
		$this->url = $this->api_endpoint .'/nearest?'. $params;

		return $this->request('GET', $this->url);

	}

	/**
	 *
	 * Find electric charging stations within a distance of a driving route.
	 *
	 * @param array $data
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 *
	 */
	
	public function nearbyRoute($data, $limit = null, $offset = null) {

		$this->data['fuel_type'] = 'ELEC';

		if (!is_null($limit)) {
			$this->data['limit'] = $limit;
		}

		if (!is_null($offset)) {
			$this->data['offset'] = $offset;
		}

		foreach ($data as $k => $v) {
			$this->data[$k] = $v;
		}

		$params = http_build_query($this->data);
		$this->url = $this->api_endpoint .'/nearby-route?'. $params;

		return $this->request('GET', $this->url);

	}

	/**
	 *
	 * Retrieve the date when the alternative fuel stations data were last updated.
	 * @return array - Key 'last_updated' with datetime value in ISO 8601 format.
	 *
	 */
	
	public function lastUpdated() {

		$params = http_build_query($this->data);
		$this->url = $this->api_endpoint .'/last-updated?'. $params;

		return $this->request('GET', $this->url);

	}

	/**
	 *
	 * Method used to communicate with REST API server.
	 *
	 * @param string $method
	 * @param string $url
	 * @return array - Associative array containing 'status_code' and 'response'
	 *
	 */
	
	public function request($method, $url) {

		if ($method === 'GET') {

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$output = curl_exec($ch);
			$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
			$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
			$body = substr($output, $header_size);
			$body_decode = json_decode($body, true);

			curl_close($ch);

			return [
				'status_code' => $http_code,
				'response' => $body_decode
			];

		}

	}

}