<?php
namespace Vsmoraes\Pdf;

use PHPUnit\Framework\TestCase;

class DompdfTest extends TestCase
{

    public function testLoadHtml()
    {
        $html = '<html><head></head><body></body></html>';
        $size = Pdf::DEFAULT_SIZE;
        $orientation = Pdf::DEFAULT_ORIENTATION;

        $stub = $this->getMockBuilder(\Dompdf\Dompdf::class)
            ->setMethods(['loadHtml', 'setPaper'])
            ->getMock();

        $stub->expects($this->once())
            ->method('loadHtml')
            ->with($html);

        $stub->expects($this->once())
            ->method('setPaper')
            ->with($size, $orientation);

        $pdf = new Dompdf($stub);
        $result = $pdf->load($html);

        $this->assertEquals($pdf, $result);
    }

    public function testShowHtml()
    {
        $html = '<html><head></head><body></body></html>';
        $size = Pdf::DEFAULT_SIZE;
        $orientation = Pdf::DEFAULT_ORIENTATION;

        $stub = $this->getMockBuilder(\Dompdf\Dompdf::class)
            ->setMethods(['setPaper', 'stream'])
            ->getMock();

        $stub->expects($this->once())
            ->method('stream');

        $stub->expects($this->once())
            ->method('setPaper')
            ->with($size, $orientation);

        $pdf = new Dompdf($stub);
        $pdf->load($html);
        $pdf->show();
    }
}
