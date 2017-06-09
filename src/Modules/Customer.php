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

class Customer
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
	 * Customer constructor.
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

	public function create($data = [])
	{
		return $this->http->post('customer', $data);
	}

	public function get()
	{
		return $this->http->get("customer/{$this->id}");
	}

	/**
	 * Check if a customer exists with an email address
	 *
	 * @param $email
	 *
	 * @return \GemPayment\Support\HttpResponse|bool
	 */
	public function exists($email)
	{
		$request = $this->http->post('customer/is_customer', ['email' => $email]);

		if ($request->response()->getStatusCode() == 200)
			return $request;

		return false;
	}

	/**
	 * Checks if the customer is a stripe customer also
	 *
	 * @return bool
	 */
	public function hasStripe()
	{
		$request = $this->http->post("customer/{$this->id}/stripe/has");

		if ($request->response()->getStatusCode() == 200)
			return (isset($request->data()->customer) && $request->data()->customer == true);

		return false;
	}

	/**
	 * Create the stripe customer instance for the customer
	 *
	 * @return \GemPayment\Support\HttpResponse
	 */
	public function createStripe()
	{
		return $this->http->post("customer/{$this->id}/stripe/create");
	}

	/**
	 * Assign a stripe payment source to the customer.
	 * Uses Stripe Elements to capture the card details.
	 *
	 * @param $source
	 *
	 * @return \GemPayment\Support\HttpResponse
	 */
	public function assignStripeSource($source)
	{
		return $this->http->post("customer/{$this->id}/stripe/source", ['source' => $source]);
	}

	/**
	 * Get a list of the customers subscriptions
	 *
	 * @param bool $includeProduct
	 * @param bool $includeProductCounts
	 *
	 * @return \GemPayment\Support\HttpResponse
	 */
	public function subscriptions($includeProduct = false, $includeProductCounts = false)
	{
		return $this->http->get("customer/{$this->id}/subscriptions", [
			'include_product'        => $includeProduct,
			'include_product_counts' => $includeProductCounts,
		]);
	}

	/**
	 * Get a paginate-able list of payments for a specific subscription
	 *
	 * @param $subscriptionId
	 *
	 * @return \GemPayment\Support\HttpResponse
	 */
	public function subscriptionPayments($subscriptionId)
	{
		return $this->http->get("customer/{$this->id}/subscriptions/{$subscriptionId}/payments");
	}

	/**
	 * @param null $id
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

}