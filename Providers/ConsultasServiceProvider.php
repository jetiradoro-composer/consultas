<?php

namespace Modules\Consultas\Providers;

use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class ConsultasServiceProvider extends ServiceProvider {
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Boot the application events.
	 *
	 * @return void
	 */
	public function boot() {
		$this->registerTranslations();
		$this->registerConfig();
		$this->registerViews();
		$this->registerFactories();
		$this->loadMigrationsFrom(__DIR__ .'/../Database/Migrations');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		//
	}

	/**
	 * Register config.
	 *
	 * @return void
	 */
	protected function registerConfig() {
		$this->publishes([
				__DIR__ .'/../Config/config.php' => config_path('consultas.php'),
			], 'config');
		$this->mergeConfigFrom(
			__DIR__ .'/../Config/config.php', 'consultas'
		);
	}

	/**
	 * Register views.
	 *
	 * @return void
	 */
	public function registerViews() {
		$viewPath = resource_path('views/modules/consultas');

		$sourcePath = __DIR__ .'/../Resources/views';

		$this->publishes([
				$sourcePath => $viewPath
			], 'views');

		$this->loadViewsFrom(array_merge(array_map(function ($path) {
						return $path.'/modules/consultas';
					}, \Config::get('view.paths')), [$sourcePath]), 'consultas');
	}

	/**
	 * Register translations.
	 *
	 * @return void
	 */
	public function registerTranslations() {
		$langPath = resource_path('lang/modules/consultas');

		if (is_dir($langPath)) {
			$this->loadTranslationsFrom($langPath, 'consultas');
		} else {
			$this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'consultas');
		}
	}

	/**
	 * Register an additional directory of factories.
	 * @source https://github.com/sebastiaanluca/laravel-resource-flow/blob/develop/src/Modules/ModuleServiceProvider.php#L66
	 */
	public function registerFactories() {
		if (!app()           ->environment('production')) {
			app(Factory::class )->load(__DIR__ .'/../Database/factories');
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {

		return [
			Maatwebsite\Excel\ExcelServiceProvider::class ,
		];
	}
}
