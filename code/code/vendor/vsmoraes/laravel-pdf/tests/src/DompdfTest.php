<?php

class DompdfTest extends PHPUnit_Framework_TestCase
{

    public function testLoadHtml()
    {
        $stub = $this->getMockBuilder('\DOMPDF')
            ->setMethods(['load_html'])
            ->getMock();

        $pdf = new \Vsmoraes\Pdf\Dompdf($stub);

        $stub->expects($this->once())
            ->method('load_html');

        $pdf->load('<html><head></head><body></body></html>');
    }

    public function testShowHtml()
    {
        $stub = $this->getMockBuilder('\DOMPDF')
            ->getMock();

        $pdf = new \Vsmoraes\Pdf\Dompdf($stub);

        $stub->expects($this->once())
            ->method('stream');

        $pdf->load('<html><head></head><body></body></html>');
        $pdf->show();
    }

}
