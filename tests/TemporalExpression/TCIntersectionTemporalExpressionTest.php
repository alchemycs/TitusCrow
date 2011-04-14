<?php

require_once(dirname(__FILE__).'/../../src/TitusCrow.php');

class TCIntersectionTemporalExpressionTest extends PHPUnit_Framework_TestCase {

  public function testSingleExpression() {
    $expression = new TCIntersectionTemporalExpression();
    $past = new TCDate('2 days ago');
    $present = new TCDate('today');
    $future = new TCDate('+2 days');
    $expression->add(new TCDateEqualsTemporalExpression($present));
    $this->assertFalse($expression->includes($past));
    $this->assertFalse($expression->includes($future));
    $this->assertTrue($expression->includes($present));
  }

  public function testMutualExclusion() {
    $expression = new TCIntersectionTemporalExpression();
    $past = new TCDate('2 days ago');
    $present = new TCDate('today');
    $future = new TCDate('+2 days');
    $expression->add(new TCDateEqualsTemporalExpression($past));
    $expression->add(new TCDateEqualsTemporalExpression($future));
    $this->assertFalse($expression->includes($past));
    $this->assertFalse($expression->includes($future));
    $this->assertFalse($expression->includes($present));
  }

  public function testOverlap() {
    $expression = new TCIntersectionTemporalExpression();
    $past = new TCDate('yesterday');
    $present = new TCDate('today');
    $future = new TCDate('tomorrow');

    $pastExpression = new TCDateBetweenTemporalExpression($past, $present);
    $futureExpression = new TCDateBetweenTemporalExpression($present, $future);

    $expression->add($pastExpression);
    $expression->add($futureExpression);

    $this->assertTrue($pastExpression->includes($past));
    $this->assertTrue($pastExpression->includes($present));
    $this->assertTrue($futureExpression->includes($present));
    $this->assertTrue($futureExpression->includes($future));

    $this->assertFalse($expression->includes($past));
    $this->assertFalse($expression->includes($future));
    $this->assertTrue($expression->includes($present));

  }

  public function testClear() {
    $expression = new TCIntersectionTemporalExpression();
    $past = new TCDate('yesterday');
    $present = new TCDate('today');
    $future = new TCDate('tomorrow');

    $pastExpression = new TCDateBetweenTemporalExpression($past, $present);
    $futureExpression = new TCDateBetweenTemporalExpression($present, $future);

    $expression->add($pastExpression);
    $expression->add($futureExpression);

    $this->assertTrue($pastExpression->includes($past));
    $this->assertTrue($pastExpression->includes($present));
    $this->assertTrue($futureExpression->includes($present));
    $this->assertTrue($futureExpression->includes($future));

    $this->assertFalse($expression->includes($past));
    $this->assertFalse($expression->includes($future));
    $this->assertTrue($expression->includes($present));

    $expression->clear();
    $this->assertTrue($expression->includes($past));
  }

  public function testRemove() {
    $expression = new TCIntersectionTemporalExpression();
    $past = new TCDate('yesterday');
    $present = new TCDate('today');
    $future = new TCDate('tomorrow');

    $pastExpression = new TCDateBetweenTemporalExpression($past, $present);
    $futureExpression = new TCDateBetweenTemporalExpression($present, $future);

    $expression->add($pastExpression);
    $expression->add($futureExpression);

    $this->assertTrue($pastExpression->includes($past));
    $this->assertTrue($pastExpression->includes($present));
    $this->assertTrue($futureExpression->includes($present));
    $this->assertTrue($futureExpression->includes($future));

    $this->assertFalse($expression->includes($past));
    $this->assertFalse($expression->includes($future));
    $this->assertTrue($expression->includes($present));

    $expression->remove($futureExpression);
    $this->assertTrue($expression->includes($past));
    $this->assertFalse($expression->includes($future));
    $this->assertTrue($expression->includes($present));
  }

}

?>