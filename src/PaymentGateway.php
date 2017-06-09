<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 25/04/17
 * Time: 17:07
 */

namespace GemPayment;


use GemPayment\Modules\Company;
use GemPayment\Modules\Customer;
use GemPayment\Modules\Gateway;
use GemPayment\Modules\Payments;
use GemPayment\Modules\Product;
use GemPayment\Modules\Subscription;
use GemPayment\Support\Http;

class PaymentGateway
{
	private $http;
	public $baseUrl = "";

	public function __construct($accessToken = null)
	{
		$this->baseUrl = env('APP_ENV') == 'local' ? 'https://staging.gempayment.com/' : 'https://gempayment.com/';
		$this->http    = new Http($this);

		if ($accessToken != null) {
			$this->http->setAccessToken($accessToken);
		}
	}

	public function customers($id = null) : Customer
	{
		return new Customer($this, $this->http, $id);
	}

	public function products($id = null) : Product
	{
		return new Product($this, $this->http, $id);
	}

	public function subscriptions($id = null) : Subscription
	{
		return new Subscription($this, $this->http, $id);
	}

	public function company($id = null) : Company
	{
		return new Company($this, $this->http, $id);
	}

	public function payments($id = null) : Payments
	{
		return new Payments($this, $this->http, $id);
	}

	public function gateway() : Gateway
	{
		return new Gateway($this, $this->http);
	}

	public function http() : Http
	{
		return $this->http;
	}


}