<?php
	/**
    This file is part of WideImage.
		
    WideImage is free software; you can redistribute it and/or modify
    it under the terms of the GNU Lesser General Public License as published by
    the Free Software Foundation; either version 2.1 of the License, or
    (at your option) any later version.
		
    WideImage is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU Lesser General Public License for more details.
		
    You should have received a copy of the GNU Lesser General Public License
    along with WideImage; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  **/
	
	/**
	 * @package Tests
	 */
	class WideImage_Coordinate_Test extends WideImage_TestCase
	{
		function testEvaluate()
		{
			$this->assertSame(400, WideImage_Coordinate::evaluate('+200%', 200));
			$this->assertSame(-1, WideImage_Coordinate::evaluate('-1', 200));
			$this->assertSame(10, WideImage_Coordinate::evaluate('+10', 200));
			$this->assertSame(40, WideImage_Coordinate::evaluate('+20%', 200));
			$this->assertSame(-11, WideImage_Coordinate::evaluate('-11.23', 200));
			$this->assertSame(-30, WideImage_Coordinate::evaluate('-15%', 200));
		}
		
		function testFix()
		{
			$this->assertSame(10, WideImage_Coordinate::fix('10%', 100));
			$this->assertSame(10, WideImage_Coordinate::fix('10', 100));
			
			$this->assertSame(-10, WideImage_Coordinate::fix('-10%', 100));
			$this->assertSame(-1, WideImage_Coordinate::fix('-1', 100));
			$this->assertSame(-50, WideImage_Coordinate::fix('-50%', 100));
			$this->assertSame(-100, WideImage_Coordinate::fix('-100%', 100));
			$this->assertSame(-1, WideImage_Coordinate::fix('-5%', 20));
			
			$this->assertSame(300, WideImage_Coordinate::fix('150.12%', 200));
			$this->assertSame(150, WideImage_Coordinate::fix('150', 200));
			
			$this->assertSame(100, WideImage_Coordinate::fix('100%-50%', 200));
			$this->assertSame(200, WideImage_Coordinate::fix('100%', 200));
			
			$this->assertSame(130, WideImage_Coordinate::fix('50%     -20', 300));
			$this->assertSame(12, WideImage_Coordinate::fix(' 12 - 0', 300));
			
			$this->assertSame(15, WideImage_Coordinate::fix('50%', 30));
			$this->assertSame(15, WideImage_Coordinate::fix('50%-0', 30));
			$this->assertSame(15, WideImage_Coordinate::fix('50%+0', 30));
			$this->assertSame(0, WideImage_Coordinate::fix(' -  50%  +   50%', 30));
			$this->assertSame(30, WideImage_Coordinate::fix(' 50%  + 49.6666%', 30));
		}
		
		function testAlign()
		{
			$this->assertSame(0, WideImage_Coordinate::fix('left', 300, 120));
			$this->assertSame(90, WideImage_Coordinate::fix('center', 300, 120));
			$this->assertSame(180, WideImage_Coordinate::fix('right', 300, 120));
			$this->assertSame(0, WideImage_Coordinate::fix('top', 300, 120));
			$this->assertSame(90, WideImage_Coordinate::fix('middle', 300, 120));
			$this->assertSame(180, WideImage_Coordinate::fix('bottom', 300, 120));
			
			$this->assertSame(200, WideImage_Coordinate::fix('bottom+20', 300, 120));
			$this->assertSame(178, WideImage_Coordinate::fix('-2 + right', 300, 120));
			$this->assertSame(90, WideImage_Coordinate::fix('right - center', 300, 120));
		}
		
		function testAlignWithoutSecondaryCoordinate()
		{
			$this->assertSame(0, WideImage_Coordinate::fix('left', 300));
			$this->assertSame(150, WideImage_Coordinate::fix('center', 300));
			$this->assertSame(300, WideImage_Coordinate::fix('right', 300));
			$this->assertSame(0, WideImage_Coordinate::fix('top', 300));
			$this->assertSame(150, WideImage_Coordinate::fix('middle', 300));
			$this->assertSame(300, WideImage_Coordinate::fix('bottom', 300));
			
			$this->assertSame(320, WideImage_Coordinate::fix('bottom+20', 300));
			$this->assertSame(280, WideImage_Coordinate::fix('-20 + right', 300));
			$this->assertSame(150, WideImage_Coordinate::fix('right - center', 300));
		}
				
		function testMultipleOperands()
		{
			$this->assertSame(6, WideImage_Coordinate::fix('100%-100+1     + 5', 100));
			$this->assertSame(1, WideImage_Coordinate::fix('right      +1-   100     - 50%', 200));
			$this->assertSame(200, WideImage_Coordinate::fix('-right+right +100%', 200));
			$this->assertSame(90, WideImage_Coordinate::fix('100--++++-10', 200));
		}
		
		/**
		 * @expectedException WideImage_InvalidCoordinateException
		 */
		function testInvalidSyntaxEndsWithOperator()
		{
			WideImage_Coordinate::fix('5+2+', 10);
		}
	}
