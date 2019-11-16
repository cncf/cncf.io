<?php

namespace AdvancedPantheon\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;

class Test_Assert extends TestCase {
	protected function setUp() {
		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown() {
		Monkey\tearDown();
		parent::tearDown();
	}

	public function test_sample() {
		$this->assertTrue( true );
	}
}
