<?php
namespace Vsmoraes\Pdf;

use Illuminate\Http\Response;

class Dompdf implements Pdf
{
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
    protected $filename = 'dompdf_out.pdf';


    /**
     * Inject the DOMPDF object
     *
     * @param \DOMPDF $dompdf
     */
    public function __construct(\DOMPDF $dompdf)
    {
        $this->dompdfInstance = $dompdf;
    }


    /**
     * {@inheritdoc}
     */
    public function load($html, $size = 'A4', $orientation = 'portrait')
    {
        $this->dompdfInstance->load_html($html);
        $this->setPaper($size, $orientation);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function filename($filename = null)
    {
        if ($filename) {
            $this->filename = $filename;

            // chain when the filename is set
            return $this;
        }

        return $this->filename;
    }

    /**
     * {@inheritdoc}
     */
    public function setPaper($size, $orientation)
    {
        return $this->dompdfInstance->set_paper($size, $orientation);
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        return $this->dompdfInstance->render();
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        \Image_Cache::clear();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function show($options = ['compress' => 1, 'Attachment' => 0])
    {
        $this->render();
        $this->clear();

        return $this->dompdfInstance->stream($this->filename(), $options);
    }

    /**
     * {@inheritdoc}
     */
    public function download($options = ['compress' => 1, 'Attachment' => 1])
    {
        return new Response($this->show($options), 200, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function output($options = ['compress' => 1])
    {
        $this->render();

        return $this->dompdfInstance->output($options);
    }
}
