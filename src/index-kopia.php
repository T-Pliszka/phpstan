<?php

$zmienna1 = 'test';

if ($zmienna1 === 'test') {
  // OK: warunek prawidłowy, gałąź else jest osiągalna (nie błąd)
  echo "Zmienna ma wartość 'test'.";
} else {
  echo "Zmienna ma inną wartość.";
}

/**
 * BŁĘDY PODSTAWOWE (niezdefiniowane zmienne, dzielenie przez zero)
 */

// ❌ Niezdefiniowana zmienna $zmienna2
//    (PHPStan: Undefined variable: $zmienna2)
$t = $zmienna1 . $zmienna2;

// ❌ Ewidentne dzielenie przez zero
//    (PHPStan: Division by zero)
$test = 5 / 0;

// ❌ Możliwe dzielenie przez niezdefiniowaną zmienną
//    (PHPStan: Undefined variable: $zmienna3)
$test = 5 / $zmienna3;


/**
 * BŁĘDY TYPOWANIA I NULLABILITY
 */

// Funkcja z adnotacją typu wejścia/wyjścia
/**
 * @param int $n
 */
function square(int $n): int {
  return $n * $n;
}

// ❌ Zły typ argumentu: string zamiast int
//    (PHPStan: Parameter #1 $n of function square expects int, string given)
$result = square('abc');

// Klasa pomocnicza
class User {
  public function getId(): int {
    return 1;
  }
}

// ❌ Możliwe wywołanie metody na null
//    (PHPStan: Calling method getId() on null)
$user = null;
echo $user->getId();


/**
 * BŁĘDY DOT. TABLIC/STRUCTUR DANYCH
 */

// Tablica asocjacyjna ze zdefiniowanymi typami
/** @var array<string, int> $map */
$map = ['a' => 1];

// ❌ Dostęp do nieistniejącego klucza 'b'
//    (PHPStan: Offset 'b' does not exist on array('a' => int))
// ❌ Dodatkowo: próba dostępu do właściwości na int
//    (PHPStan: Access to an undefined property on int)
echo $map['b']->foo;

// ❌ count() na wartości niebędącej tablicą/Countable
//    (PHPStan: Argument of type string|int is not countable)
echo count($zmienna1);


/**
 * BŁĘDY W KONTROLACH PRZEPŁYWU
 */

// ❌ Nieprawidłowe użycie foreach na int
//    (PHPStan: Invalid argument foreach() provided: int)
$number = 1;
foreach ($number as $n) {
  echo $n;
}

// ❌ Kod po return w funkcji – unreachable
function alwaysReturn(): int {
  return 42;
  // (PHPStan: Unreachable statement - kod poniżej nigdy się nie wykona)
  $x = 1 + 1;
  return $x;
}


/**
 * INNE TYPOWE POTKNIĘCIA
 */

// ❌ Wywołanie nieistniejącej funkcji
//    (PHPStan: Function notAFunction() not found)
notAFunction();


notAFunction2();

notAFunction3();

// ❌ Użycie niezdefiniowanej stałej (w PHP traktowane jak string, ale PHPStan flaguje)
//    (PHPStan: Undefined constant UNDEFINED_CONST)
echo UNDEFINED_CONST;

// 11
// test main


$test();
