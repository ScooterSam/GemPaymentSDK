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

class Subscription
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

	/**
	 * Get a specific subscription
	 *
	 * @param bool $includeProduct
	 * @param bool $includeProductCounts
	 *
	 * @return \GemPayment\Support\HttpResponse
	 * @internal param bool $subscriptionsAndPayments
	 *
	 */
	public function get($includeProduct = false, $includeProductCounts = false)
	{
		return $this->http->get("subscription/{$this->id}", [
			'include_product'        => $includeProduct,
			'include_product_counts' => $includeProductCounts,
		]);
	}

	/**
	 * Get a paginate-able list of subscriptions for the company.
	 *
	 * @param      $page
	 * @param      $perPage
	 *
	 *
	 * @return \GemPayment\Support\HttpResponse
	 */
	public function list($page, $perPage, $status = 'active')
	{
		return $this->http->get("subscription/list", [
			'page'    => $page,
			'perPage' => $perPage,
			'status'  => $status,
		]);
	}

	/**
	 * @param null $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

}