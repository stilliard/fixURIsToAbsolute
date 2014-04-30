<?php

require dirname(__FILE__) . '/../lib/fixURIs.php';

class fixURIsTest extends PHPUnit_Framework_TestCase
{

	function test_noQuotes()
	{
		$string = '<a href=home.html></a>';
		$expected = '<a href=/home.html></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<a href=/home.html></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href=home.html ></a>';
		$expected = '<a href=/home.html ></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<a href=home.html class="demo"></a>';
		$expected = '<a href=/home.html class="demo"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);
	}

	function test_singleQuotes()
	{
		$string = '<a href=\'home.html\'></a>';
		$expected = '<a href=\'/home.html\'></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<a href=\'/home.html\'></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href=\'home.html\' ></a>';
		$expected = '<a href=\'/home.html\' ></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<a href=\'home.html\' class="demo"></a>';
		$expected = '<a href=\'/home.html\' class="demo"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<img src=\'images/demo.png\'>';
		$expected = '<img src=\'/images/demo.png\'>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<img src=\'/images/demo.png\'>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
	}

	function test_doubleQuotes()
	{
		$string = '<a href="home.html"></a>';
		$expected = '<a href="/home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<a href="/home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="home.html" ></a>';
		$expected = '<a href="/home.html" ></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<a href="home.html" class="demo"></a>';
		$expected = '<a href="/home.html" class="demo"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<img src="images/demo.png">';
		$expected = '<img src="/images/demo.png">';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<img src="/images/demo.png">';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
	}

	function test_upLevels()
	{
		$string = '<img src="./images/demo.png">';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<img src="../images/demo.png">';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<img src="../../images/demo.png">';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
	}

	function test_anchors()
	{
		$string = '<a href="home.html#element"></a>';
		$expected = '<a href="/home.html#element"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<a href="#element"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="#"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
	}

	function test_queryParams()
	{
		$string = '<a href="home.html?q=test"></a>';
		$expected = '<a href="/home.html?q=test"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<a href="?q=test"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="?"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
	}

	function test_urlsStartingWithUnderscore()
	{
		$string = '<a href="_home.html"></a>';
		$expected = '<a href="/_home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);
	}

	function test_urlsStartingWithDash()
	{
		$string = '<a href="-home.html"></a>';
		$expected = '<a href="/-home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);
	}

	function test_blank()
	{
		$string = '<a href=""></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href=\'\'></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href=></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href= ></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="" class="demo"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href= class=demo></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href= class="demo"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
	}

	function test_externalLinks()
	{
		$string = '<a href="http://www.google.com"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
		$string = '<a href="http://www.google.com/search?q=test"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="https://www.google.com/search?q=test"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="//www.google.com/search?q=test"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<img src="http://domain.com/someimage.png"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<img src="https://domain.com/someimage.png"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<img src="//domain.com/someimage.png"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<script src="//domain.com/ajax/lib.js"></script>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="ftp://user:pass@host/demo"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
	}

	function test_protocols()
	{
		$string = '<a href="javascript:something"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="javascript:myfunc();another()"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="javascript:void(0)" onclick="myfunc()"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="mailto:my@email.com"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="random:something"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<img src="data:image/png;base64,iVBORw0KGgoAAAANSU">';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);

		$string = '<a href="share?url=http://www.site.com"></a>';
		$expected = '<a href="/share?url=http://www.site.com"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<a href="/share?url=http://www.site.com"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
	}

	function test_spaces()
	{
		$string = '<a href=" /home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
		
		$string = '<a href="	/home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
		
		$string = '<a href="	/home.html  "></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
		
		$string = '<a href="	home.html"></a>';
		$expected = '<a href="	/home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);
		
		$string = '<a href="	  home.html  "></a>';
		$expected = '<a href="	  /home.html  "></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);
	}

	function test_attributeElements()
	{
		$string = '<a href="home.html"></a>';
		$expected = '<a href="/home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<img src="images/someimage.png"></a>';
		$expected = '<img src="/images/someimage.png"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<script src="js/script.js"></script>';
		$expected = '<script src="/js/script.js"></script>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<iframe src="page.html"></iframe>';
		$expected = '<iframe src="/page.html"></iframe>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<link rel="stylesheet" href="css/style.css">';
		$expected = '<link rel="stylesheet" href="/css/style.css">';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '<form action="process.php" method="get">';
		$expected = '<form action="/process.php" method="get">';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);
	}

	function test_attributesNotChanged()
	{
		$string = '<a data-url="home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
		
		$string = '<a something="home.html"></a>';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($string, $actual);
	}

	function test_multilines()
	{
		$string = '
			<a href="home.html">
				<img src="logo.png" class="logo">
				<strong>ABC</strong>
			</a>
		';
		$expected = '
			<a href="/home.html">
				<img src="/logo.png" class="logo">
				<strong>ABC</strong>
			</a>
		';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);

		$string = '
			<a class="abc"
				href="
					home.html">
				<img src="logo.png" class="logo">
				<strong>ABC</strong>
			</a>
		';
		$expected = '
			<a class="abc"
				href="
					/home.html">
				<img src="/logo.png" class="logo">
				<strong>ABC</strong>
			</a>
		';
		$actual = fixURIsToAbsolute($string);
		$this->assertEquals($expected, $actual);
	}

}
