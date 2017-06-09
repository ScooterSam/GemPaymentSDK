<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 25/04/17
 * Time: 17:20
 */

namespace ScooterSam\GemPayment\Modules;


use ScooterSam\GemPayment\PaymentGateway;
use ScooterSam\GemPayment\Support\Http;

class Product
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
	 * Create a new product
	 *
	 * @param string $title       | The title of the product
	 * @param string $description | A description of the product
	 * @param float  $price       | The price of the product, minimum 2.00
	 *
	 * @param string $billingPeriod
	 * @param int    $billingFreq
	 * @param array  $meta
	 *
	 * @return \ScooterSam\GemPayment\Support\HttpResponse
	 * @internal param array $data
	 */
	public function create($title = '', $description = '', $price = 2.00, $billingPeriod = 'Month', $billingFreq = 1, $meta = [])
	{
		$data = [
			'title'             => $title,
			'description'       => $description,
			'price'             => $price,
			'billing_period'    => $billingPeriod,
			'billing_frequency' => $billingFreq,
		];
		if (count($meta))
			$data['meta'] = $meta;

		return $this->http->post('product', $data);
	}

	/**
	 * Get a specific product
	 *
	 * @param bool $subscriptionsAndPayments
	 *
	 * @return \ScooterSam\GemPayment\Support\HttpResponse
	 */
	public function get($subscriptionsAndPayments = false)
	{
		return $this->http->get("product/{$this->id}", [
			'extra_data' => $subscriptionsAndPayments,
		]);
	}

	/**
	 * Get a paginate-able list of products for the company.
	 *
	 * @param      $page
	 * @param      $perPage
	 *
	 * @param bool $subscriptionsAndPayments | Allows you to include subscriptions and payment information in the list.
	 *
	 * @return \ScooterSam\GemPayment\Support\HttpResponse
	 */
	public function list($page, $perPage, $subscriptionsAndPayments = false)
	{
		return $this->http->get("product/list", [
			'page'       => $page,
			'perPage'    => $perPage,
			'extra_data' => $subscriptionsAndPayments,
		]);
	}

	/**
	 * Gets a list of all the companies products.
	 * Allows for use in select boxes and such.
	 *
	 * @param bool $subscriptionsAndPayments
	 *
	 * @return \ScooterSam\GemPayment\Support\HttpResponse
	 */
	public function all($subscriptionsAndPayments = false)
	{
		return $this->http->get('product/all', [
			'extra_data' => $subscriptionsAndPayments,
		]);
	}

	/**
	 * Update a product
	 *
	 * @param $values
	 *
	 * @return \ScooterSam\GemPayment\Support\HttpResponse
	 */
	public function update($values)
	{
		return $this->http->put("product/{$this->id}", $values);
	}

	/**
	 * @param null $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

}