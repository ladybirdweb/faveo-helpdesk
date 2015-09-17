<?php
namespace Vsmoraes\Pdf;

interface Pdf
{
    /**
     * Loads the HTML to the DOMPDF class
     *
     * @param $html
     * @param string $size
     * @param string $orientation
     * @return mixed
     */
    public function load($html, $size = 'A4', $orientation = 'portrait');

    /**
     * Set the filename (full path) to where the file should be saved
     *
     * @param null $filename
     * @return mixed
     */
    public function filename($filename = null);

    /**
     * Set paper size
     *
     * @param $size
     * @param $orientation
     * @return mixed
     */
    public function setPaper($size, $orientation);

    /**
     * Render the pdf
     *
     * @return mixed
     */
    public function render();

    /**
     * Clear the pdf
     *
     * @return mixed
     */
    public function clear();

    /**
     * Render the pdf on the browser
     *
     * @param array $options
     * @return mixed
     */
    public function show($options = ['compress' => 1, 'Attachment' => 0]);

    /**
     * Forces the pdf to download
     *
     * @param array $options
     * @return mixed
     */
    public function download($options = ['compress' => 1, 'Attachment' => 0]);

    /**
     * Output the pdf the to file speficied on $this->filename()
     *
     * @param array $options
     * @return mixed
     */
    public function output($options = ['compress' => 1]);

}
