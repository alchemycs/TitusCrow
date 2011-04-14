<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCUnionTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testSingleExpression() {
    $expression = new TCUnionTemporalExpression();
    $past = new TCDate('2 days ago');
    $present = new TCDate('today');
    $future = new TCDate('+2 days');
    $expression->add(new TCDateEqualsTemporalExpression($present));
    $this->assertFalse($expression->includes($past));
    $this->assertFalse($expression->includes($future));
    $this->assertTrue($expression->includes($present));
  }

  public function testTCoExpressions() {
    $expression = new TCUnionTemporalExpression();
    $past = new TCDate('2 days ago');
    $present = new TCDate('today');
    $future = new TCDate('+2 days');
    $expression->add(new TCDateEqualsTemporalExpression($past));
    $expression->add(new TCDateEqualsTemporalExpression($future));
    $this->assertTrue($expression->includes($past));
    $this->assertTrue($expression->includes($future));
    $this->assertFalse($expression->includes($present));
  }

  public function testClear() {
    $expression = new TCUnionTemporalExpression();
    $past = new TCDate('2 days ago');
    $present = new TCDate('today');
    $future = new TCDate('+2 days');
    $expression->add(new TCDateEqualsTemporalExpression($past));
    $expression->add(new TCDateEqualsTemporalExpression($future));
    $this->assertTrue($expression->includes($past));
    $this->assertTrue($expression->includes($future));
    $this->assertFalse($expression->includes($present));
    $expression->clear();
    $this->assertFalse($expression->includes($past));
    $this->assertFalse($expression->includes($future));
    $this->assertFalse($expression->includes($present));
  }

  public function testRemove() {
    $expression = new TCUnionTemporalExpression();
    $past = new TCDate('2 days ago');
    $present = new TCDate('today');
    $future = new TCDate('+2 days');
    $futureExpression = new TCDateEqualsTemporalExpression($future);
    $expression->add(new TCDateEqualsTemporalExpression($past));
    $expression->add($futureExpression);
    $this->assertTrue($expression->includes($past));
    $this->assertTrue($expression->includes($future));
    $this->assertFalse($expression->includes($present));
    $expression->remove($futureExpression);
    $this->assertTrue($expression->includes($past));
    $this->assertFalse($expression->includes($future));
    $this->assertFalse($expression->includes($present));
  }

}

?>