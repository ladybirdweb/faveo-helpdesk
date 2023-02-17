<?php
namespace Vsmoraes\Pdf;

use Dompdf\Options;

interface Pdf
{
    const DEFAULT_SIZE = 'A4';
    const DEFAULT_ORIENTATION = 'portrait';

    /**
     * Loads the HTML to the DOMPDF class
     *
     * @param $html
     * @param string $size
     * @param string $orientation
     *
     * @return $this
     */
    public function load($html, $size = self::DEFAULT_SIZE, $orientation = self::DEFAULT_ORIENTATION);

    /**
     * Set the filename (full path) to where the file should be saved
     *
     * @param string $filename
     *
     * @return $this
     */
    public function filename($filename);

    /**
     * Set paper size
     *
     * @param string $size
     * @param string $orientation
     *
     * @return $this
     */
    public function setPaper($size, $orientation);

    /**
     * Renders the HTML to PDF
     *
     * @return $this
     */
    public function render();

    /**
     * Render the pdf on the browser
     *
     * @param bool $acceptRanges
     * @param bool $compress
     * @param bool $attachment
     *
     * @return void
     */
    public function show($acceptRanges = false, $compress = true, $attachment = true);

    /**
     * Forces the pdf to download
     *
     * @return mixed
     */
    public function download();

    /**
     * Output the pdf the to file speficied on $this->filename()
     *
     * @param bool $compress
     *
     * @return string
     */
    public function output($compress = true);

    /**
     * Define Dompdf Options
     * @see https://github.com/dompdf/dompdf/blob/master/src/Options.php
     *
     * @param Options $options
     *
     * @return $this
     */
    public function setOptions(Options $options);

    /**
     * Return the current Dompdf options
     * @see https://github.com/dompdf/dompdf/blob/master/src/Options.php
     *
     * @return Options
     */
    public function getOptions();
}
