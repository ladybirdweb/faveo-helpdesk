<?php
namespace Vsmoraes\Pdf;

use Illuminate\Support\ServiceProvider;
use Vsmoraes\Pdf\Dompdf as MyDompdf;

class PdfServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */

    /**
     * Register the classes on the IoC container
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('DOMPDF', function() {
            return new \DOMPDF();
        });

        $this->app->bind('Vsmoraes\Pdf\Pdf', function() {
            define('DOMPDF_ENABLE_AUTOLOAD', false);

            require_once base_path() . '/vendor/dompdf/dompdf/dompdf_config.inc.php';

            return new Dompdf(new \DOMPDF());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Vsmoraes\Pdf\Pdf'];
    }
}
