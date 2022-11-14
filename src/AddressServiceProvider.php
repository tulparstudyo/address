<?php

namespace Tulparstudyo;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
class AddressServiceProvider extends ServiceProvider
{
	/**
	 * Register services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Bootstrap services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Route::get('/address/countries', [CountryController::class, 'list']);
		Route::get('/address/country', [CountryController::class, 'index']);
		Route::get('/address/country/{id}', [CountryController::class, 'get']);

		Route::get('/address/cities/{country_id}', [CityController::class, 'list']);
		Route::get('/address/city', [CityController::class, 'index']);
		Route::get('/address/city/{id}', [CityController::class, 'get']);

		Route::get('/address/districts', [DistrictController::class, 'list']);
		Route::get('/address/district', [DistrictController::class, 'index']);
		Route::get('/address/district/{id}', [DistrictController::class, 'get']);

		Route::group(['middleware' => ['auth:sanctum']], function(){
			Route::post('/address/country', [CountryController::class, 'post']);
			Route::put('/address/country/{id}', [CountryController::class, 'put']);
			Route::delete('/address/country/{id}', [CountryController::class, 'delete']);

			Route::post('/address/city', [CityController::class, 'post']);
			Route::put('/address/city/{id}', [CityController::class, 'put']);
			Route::delete('/address/city/{id}', [CityController::class, 'delete']);

			Route::post('/address/district', [DistrictController::class, 'post']);
			Route::put('/address/district/{id}', [DistrictController::class, 'put']);
			Route::delete('/address/district/{id}', [DistrictController::class, 'delete']);
		});
	}
}
