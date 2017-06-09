<?php

namespace GemPayment\Providers;

use GemPayment\PaymentGateway;
use Illuminate\Support\ServiceProvider;

class PaymentGatewayProvider extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		\App::bind('twitter', function () {
			return new PaymentGateway();
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{

	}
}
