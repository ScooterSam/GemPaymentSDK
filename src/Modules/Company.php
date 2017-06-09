<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 25/04/17
 * Time: 17:20
 */

namespace GemPayment\Modules;


use GemPayment\PaymentGateway;
use GemPayment\Support\Http;

class Company
{

	/**
	 * @var Http
	 */
	private $http;
	private $id;
	/**
	 * @var PaymentGateway
	 */
	private $paymentGateway;

	/**
	 * Product constructor.
	 *
	 * @param PaymentGateway $paymentGateway
	 * @param Http           $http
	 * @param null           $id
	 */
	public function __construct(PaymentGateway $paymentGateway, Http $http, $id = null)
	{
		$this->http           = $http;
		$this->id             = $id;
		$this->paymentGateway = $paymentGateway;
	}

	public function basicEarningsStatistics()
	{
		return $this->http->get('company/earnings/basic');
	}

	/**
	 * @param null $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

}