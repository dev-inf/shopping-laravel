<?php
namespace Underscore;

use Underscore\Types\Arrays;
use Underscore\Types\String;
use Underscore\Dummies\DummyClass;
use Underscore\Dummies\DummyDefault;

class UnderscoreTest extends UnderscoreTestCase
{
  // Tests --------------------------------------------------------- /

  public function testCanWrapObject()
  {
    $under1 = new Underscore($this->array);
    $under2 = Underscore::from($this->array);

    $this->assertInstanceOf('Underscore\Underscore', $under1);
    $this->assertInstanceOf('Underscore\Types\Arrays', $under2);
  }

  public function testCanRedirectToCorrectClass()
  {
    $under = Underscore::contains(array(1, 2, 3), 3);

    $this->assertEquals(2, $under);
  }

  public function testCanSwitchTypesMidCourse()
  {
    $stringToArray = String::from('FOO.BAR')->lower()->explode('.')->last()->title();

    $this->assertEquals('Bar', $stringToArray->obtain());
  }

  public function testCanWrapWithShortcutFunction()
  {
    // Skip if base function not present
    if (!function_exists('underscore')) return $this->assertTrue(true);

    $under = underscore($this->array);

    $this->assertInstanceOf('Underscore\Underscore', $under);
  }

  public function testCanHaveAliasesForMethods()
  {
    $under = Arrays::select($this->arrayNumbers, function ($value) {
      return $value == 1;
    });

    $this->assertEquals(array(1), $under);
  }

  public function testUserCanExtendWithCustomFunctions()
  {
    Arrays::extend('fooify', function ($array) {
      return 'bar';
    });
    $this->assertEquals('bar', Arrays::fooify(array('foo')));

    String::extend('unfooer', function ($string) {
      return String::replace($string, 'foo', 'bar');
    });
    $this->assertEquals('bar', String::unfooer('foo'));
  }

  public function testBreakersCantAlterTheOriginalValue()
  {
    $object = Arrays::from(array(1, 2, 3));
    $sum = $object->sum();

    $this->assertEquals(6, $sum);
    $this->assertEquals(array(1, 2, 3), $object->obtain());
  }

  public function testClassesCanExtendCoreTypes()
  {
    $class = new DummyClass();
    $class->set('foo', 'bar');

    $this->assertEquals('foobar', DummyDefault::create()->obtain());
    $this->assertEquals('{"foo":"bar"}', $class->toJSON());
  }

  public function testClassesCanUpdateSubject()
  {
    $class = new DummyClass();
    $class = $class->getUsers()->toJSON();
    $class2 = DummyClass::create()->getUsers()->toJSON();

    $this->assertEquals('[{"foo":"bar"},{"bar":"foo"}]', $class);
    $this->assertEquals($class, $class2);
  }

  public function testClassesCanOverwriteUnderscore()
  {
    $class = new DummyClass();
    $class = $class->map(3)->paddingLeft(3)->toJSON();

    $this->assertEquals('"009"', $class);
  }

  public function testMacrosCantConflictBetweenTypes()
  {
    String::extend('foobar', function () { return 'string'; });
    Arrays::extend('foobar', function () { return 'arrays'; });

    $this->assertEquals('string', String::foobar());
    $this->assertEquals('arrays', Arrays::foobar());
  }

  public function testCanCheckIfSubjectIsEmpty()
  {
    $array = Arrays::create();

    $this->assertTrue($array->isEmpty());
  }

  public function testCanParseToStringOnToString()
  {
    $array = Arrays::from($this->array);

    $this->assertEquals('{"foo":"bar","bis":"ter"}', $array->__toString());
  }

  public function testUnderscoreFindsRightClassToCall()
  {
    $numbers = array(3, 4, 5);
    $product = Underscore::reduce($numbers, function ($w, $v) {
        return $w * $v;
    }, 1);

    $this->assertEquals(60, $product);
  }
}
