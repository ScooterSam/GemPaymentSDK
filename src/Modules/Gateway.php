<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 25/04/17
 * Time: 18:54
 */

namespace ScooterSam\GemPayment\Modules;


use ScooterSam\GemPayment\PaymentGateway;
use ScooterSam\GemPayment\Support\Http;

class Gateway
{

	/**
	 * @var Http
	 */
	private $http;
	/**
	 * @var PaymentGateway
	 */
	private $paymentGateway;

	public function __construct(PaymentGateway $paymentGateway, Http $http)
	{
		$this->http           = $http;
		$this->paymentGateway = $paymentGateway;
	}

	/**
	 * Generates a token that is used to checkout with
	 *
	 * @param       $customerId  | The customer that is purchasing
	 * @param       $productId   | The product the customer is purchasing
	 * @param       $redirectUrl | Where they will be redirected after they completed the purchase
	 * @param array $meta        | Will hold any extra information, for example, stripeToken
	 *
	 * @return \ScooterSam\GemPayment\Support\HttpResponse
	 */
	public function generateToken($customerId, $productId, $redirectUrl, $meta = [])
	{
		return $this->http->post('gateway/token', [
			'customer_id'  => $customerId,
			'product_id'   => $productId,
			'redirect_url' => $redirectUrl,
			'meta'         => $meta,
		]);
	}

	/**
	 * Allows us to validate the token
	 * Ensures that its a correct token
	 *
	 * @param $token
	 *
	 * @return \ScooterSam\GemPayment\Support\HttpResponse|null
	 */
	public function validateToken($token)
	{
		$request = $this->http->post('gateway/verify_token', ['token' => $token]);
		if ($request->response()->getStatusCode() == 200)
			return $request;

		return null;
	}

	/**
	 * Verify that a webhook is from the payment gateway
	 *
	 * @param $token
	 *
	 * @return \ScooterSam\GemPayment\Support\HttpResponse|null
	 */
	public function validateWebHookToken($token)
	{
		$request = $this->http->post('gateway/verify_webhook_token', ['token' => $token]);
		if ($request->response()->getStatusCode() == 200)
			return $request;

		return null;
	}

	/**
	 * Validate a redirect token, mainly used on the /complete endpoint
	 * Prevents a vulnerability allowing users to gain a free subscription
	 *
	 * @param $token
	 *
	 * @return bool
	 */
	public function validateRedirectToken($token)
	{
		$request = $this->http->post('gateway/verify_redirect_token', ['token' => $token]);
		if ($request->response()->getStatusCode() == 200)
			return $request->data()->valid;

		return false;
	}

	public function redirectUrl($token)
	{
		return "{$this->paymentGateway->baseUrl}gateway/redirect/{$token}";
	}

}