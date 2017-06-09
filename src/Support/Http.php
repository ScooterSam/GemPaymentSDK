<?php

namespace ScooterSam\GemPayment\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use ScooterSam\GemPayment\PaymentGateway;

class Http
{

	private $client;
	private $accessToken;

	public function __construct(PaymentGateway $paymentGateway)
	{
		$this->client = new Client([
			'base_uri' => $paymentGateway->baseUrl . 'api/',
		]);
	}

	public function get($endpoint, $parameters = []) : HttpResponse
	{
		$options = [];

		if (!empty($parameters)) {
			$options['query'] = $parameters;
		}

		$options['headers'] = [
			'Accept' => 'application/json',
		];

		if ($this->getAccessToken() != null) {
			$options['headers']['Authorization'] = 'Bearer ' . $this->accessToken;
		}

		try {
			$response = $this->client->get($endpoint, $options);

			return new HttpResponse('GET', $response);
		} catch (BadResponseException $exception) {
			return new HttpResponse('GET', $exception->getResponse());
		}
	}

	public function post($endpoint, $parameters = []) : HttpResponse
	{
		$options = [];

		if (!empty($parameters)) {
			$options['form_params'] = $parameters;
		}

		$options['headers'] = [
			'Accept' => 'application/json',
		];

		if ($this->getAccessToken() != null) {
			$options['headers']['Authorization'] = 'Bearer ' . $this->accessToken;
		}

		try {
			$response = $this->client->post($endpoint, $options);

			return new HttpResponse('POST', $response);
		} catch (BadResponseException $exception) {
			return new HttpResponse('POST', $exception->getResponse());
		}
	}

	public function put($endpoint, $parameters = []) : HttpResponse
	{
		$options = [];

		if (!empty($parameters)) {
			$options['form_params'] = $parameters;
		}

		$options['headers'] = [
			'Accept' => 'application/json',
		];

		if ($this->getAccessToken() != null) {
			$options['headers']['Authorization'] = 'Bearer ' . $this->accessToken;
		}

		try {
			$response = $this->client->put($endpoint, $options);

			return new HttpResponse('PUT', $response);
		} catch (BadResponseException $exception) {
			return new HttpResponse('PUT', $exception->getResponse());
		}
	}

	/**
	 * @return mixed
	 */
	public function getAccessToken()
	{
		return $this->accessToken;
	}

	/**
	 * @param mixed $accessToken
	 */
	public function setAccessToken($accessToken)
	{
		$this->accessToken = $accessToken;
	}

}
