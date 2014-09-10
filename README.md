SQRT\Exception
==============

Класс **SQRT\Exception** позволяет удобно работать с текстами ошибок в исключениях, используя подстановку по коду ошибки и функционал шаблонов sprintf.

Например, создадим класс-наследник содержащий тексты и шаблоны ошибок:

        class TestException extends \SQRT\Exception
        {
          const ERR_ONE = 1;
          const ERR_TWO = 2;

          protected static $errors_arr = array(
            self::ERR_ONE => 'Текст ошибки номер один',
            self::ERR_TWO => 'Текст ошибки %s с подстановкой %s',
          );
        }

Теперь можно формировать тексты ошибок по коду исключения:

        echo TestException::GetNameForCode(TestException::ERR_ONE);
        // Вывод: Текст ошибки номер один

        echo TestException::GetNameForCode(TestException::ERR_TWO, array('#2', 'значений');
        echo TestException::GetNameForCode(TestException::ERR_TWO, '#2', 'значений');
        // Оба вызова дадут вывод: Текст ошибки #2 с подстановкой значений

Или сразу выбрасывать Exception с нужными свойствами:

        try {
            TestException::ThrowError(TestException::ERR_TWO, '#2', 'значений');
        } catch (TestException $e) {
            echo $e->getMessage(); // Текст ошибки #2 с подстановкой значений
            echo $e->getCode(); // 2 (Значение TestException::ERR_TWO)
        }
