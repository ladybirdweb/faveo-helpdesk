<?php
namespace Vsmoraes\Pdf;

use Dompdf\Dompdf;
use Illuminate\Support\ServiceProvider;
use Vsmoraes\Pdf\Dompdf as MyDompdf;

class PdfServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the classes on the IoC container
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Dompdf::class, function() {
            return new Dompdf();
        });

        $this->app->bind(Pdf::class, function() {
            return new MyDompdf(new Dompdf());
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            Pdf::class,
        ];
    }
}
