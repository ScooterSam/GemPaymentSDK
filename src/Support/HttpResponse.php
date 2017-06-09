<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 25/04/17
 * Time: 17:23
 */

namespace ScooterSam\GemPayment\Support;


use Illuminate\Support\Collection;
use Psr\Http\Message\ResponseInterface;

class HttpResponse
{

	private $type;
	/**
	 * @var ResponseInterface
	 */
	private $response;

	public function __construct($type, ResponseInterface $response)
	{
		$this->type     = $type;
		$this->response = $response;
	}

	public function data()
	{
		$data = json_decode($this->response->getBody());
		//dd($data);
		if ($this->response()->getStatusCode() != 200 && !isset($data->message))
			throw new \Exception('Something went wrong with GemPayment Backend, please try again.', 500);

		return $data;
	}

	public function dataToArray() : array
	{
		$data = json_decode($this->response->getBody(), true);

		if ($this->response()->getStatusCode() != 200 && !isset($data['message']))
			throw new \Exception('Something went wrong with GemPayment Backend, please try again.', 500);

		return $data;
	}

	public function dataToCollection() : Collection
	{
		$data = json_decode($this->response->getBody(), false);

		if ($this->response()->getStatusCode() != 200 && !isset($data['message']))
			throw new \Exception('Something went wrong with GemPayment Backend, please try again.', 500);

		return collect($data);
	}

	public function response() : ResponseInterface
	{
		return $this->response;
	}

}