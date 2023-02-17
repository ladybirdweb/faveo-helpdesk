<?php
namespace Vsmoraes\Pdf;

use Dompdf\Options;
use Illuminate\Http\Response;

class Dompdf implements Pdf
{
    CONST DOWNLOAD_FILENAME = 'dompdf_out.pdf';

    /**
     * DOMPDF instance
     *
     * @var \DOMPDF
     */
    protected $dompdfInstance;

    /**
     * Path to the PDF
     *
     * @var string
     */
    protected $filename;

    /**
     * Inject the DOMPDF object
     *
     * @param \Dompdf\Dompdf $dompdf
     */
    public function __construct(\Dompdf\Dompdf $dompdf)
    {
        $this->dompdfInstance = $dompdf;
    }

    /**
     * {@inheritdoc}
     */
    public function load($html, $size = Pdf::DEFAULT_SIZE, $orientation = Pdf::DEFAULT_ORIENTATION)
    {
        $this->dompdfInstance->loadHtml($html);
        $this->setPaper($size, $orientation);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function filename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setPaper($size, $orientation)
    {
        $this->dompdfInstance->setPaper($size, $orientation);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->dompdfInstance->render();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setOptions(Options $options)
    {
        $this->dompdfInstance->setOptions($options);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return $this->dompdfInstance->getOptions();
    }

    /**
     * {@inheritdoc}
     */
    public function show($acceptRanges = false, $compress = true, $attachment = true)
    {
        $options = [
            'Accept-Ranges' => (int) $acceptRanges,
            'compress' => (int) $compress,
            'Attachment' => (int) $attachment,
        ];

        $this->render();
        $filename = !is_null($this->filename) ? $this->filename : static::DOWNLOAD_FILENAME;

        $this->dompdfInstance->stream($filename, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function download()
    {
        return new Response($this->show(false, true, true), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function output($compress = true)
    {
        $options = [
            'compress' => (int) $compress,
        ];

        $this->render();
        $output = $this->dompdfInstance->output($options);

        if (!is_null($this->filename)) {
            file_put_contents($this->filename, $output);
        }

        return $output;
    }
}
