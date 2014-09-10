<?php

require_once __DIR__ . '/../init.php';

class exceptionTest extends PHPUnit_Framework_TestCase
{
  function testGetNamePlain()
  {
    $this->assertEquals('Текст ошибки номер один', TestException::GetNameForCode(TestException::ERR_ONE), 'Ошибка №1');

    $this->assertFalse(TestException::GetNameForCode(3), 'Несуществующий код ошибки');
  }

  function testGetNameSprintf()
  {
    $exp = 'Текст ошибки #2 с подстановкой значений';

    $this->assertEquals(
      $exp,
      TestException::GetNameForCode(TestException::ERR_TWO, '#2', 'значений'),
      'Подстановка аргументов функции'
    );

    $this->assertEquals(
      $exp,
      TestException::GetNameForCode(TestException::ERR_TWO, array('#2', 'значений'), 'игнорируемое значение'),
      'Подстановка значений из массива'
    );

    $this->assertEquals(
      'Текст ошибки 0 с подстановкой значений',
      TestException::GetNameForCode(TestException::ERR_TWO, 0, 'значений'),
      'Можно указанть логическое false значение - проверка аргумента на is_null'
    );

    $this->assertFalse(TestException::GetNameForCode(3, 'ololo'), 'Несуществующий код ошибки');
  }

  function testThrowError()
  {
    try {
      TestException::ThrowError(TestException::ERR_ONE);

      $this->fail('Исключение №1 не было выброшено');
    } catch (TestException $e) {
      $this->assertEquals(TestException::ERR_ONE, $e->getCode(), 'Код ошибки №1');
      $this->assertEquals('Текст ошибки номер один', $e->getMessage(), 'Текст ошибки №1');
    }

    $exp = 'Текст ошибки #2 с подстановкой значений';

    try {
      TestException::ThrowError(TestException::ERR_TWO, '#2', 'значений');

      $this->fail('Исключение №2 не было выброшено');
    } catch (TestException $e) {
      $this->assertEquals(TestException::ERR_TWO, $e->getCode(), 'Код ошибки №2');
      $this->assertEquals($exp, $e->getMessage(), 'Текст ошибки №2 из аргументов функции');
    }

    try {
      TestException::ThrowError(TestException::ERR_TWO, array('#2', 'значений'));

      $this->fail('Исключение №3 не было выброшено');
    } catch (TestException $e) {
      $this->assertEquals($exp, $e->getMessage(), 'Текст ошибки №2 с значениями из массива');
    }
  }
}


/** Класс для тестирования с примерами ошибок */
class TestException extends \SQRT\Exception
{
  const ERR_ONE = 1;
  const ERR_TWO = 2;

  protected static $errors_arr = array(
    self::ERR_ONE => 'Текст ошибки номер один',
    self::ERR_TWO => 'Текст ошибки %s с подстановкой %s',
  );
}