<?php
namespace Vsmoraes\Pdf;

use Illuminate\Support\Facades\Facade;

class PdfFacade extends Facade
{
    /**
     * Return the facade name accessor
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Vsmoraes\Pdf\Pdf';
    }
}
