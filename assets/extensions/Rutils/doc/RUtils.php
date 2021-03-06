<?php
if(IN_MANAGER_MODE!="true") die("<b>INCLUDE_ORDERING_ERROR</b><br /><br />Please use the MODX Content Manager instead of accessing this file directly.");
?>

<div class="sectionHeader">RUtils</div><div class="sectionBody">
    <p>
        <b>PHP RUtils</b>&nbsp;&mdash; порт <a href="https://github.com/j2a/pytils">Pytils</a> на PHP.
        Утилиты разделены на следующие модули (классы):
    </p>
    <ul>
        <li><a href="#numeral">Numeral</a> - работа с числами,</li>
        <li><a href="#dt">Dt</a> - работа с датами,</li>
        <li><a href="#translit">Translit</a> - транслитерация,</li>
        <li><a href="#typo">Typo</a> - небольшой набор правил типографики простого текста.</li>
    </ul>
</div>

<div class="sectionHeader">Возможности Numeral</div>
<div class="sectionBody">
<h3>Выбор формы множественного числа</h3>
<pre>
$variants = array(
    'гвоздь', //1
    'гвоздя', //2
    'гвоздей' //5
);
echo $amount, ' ', RUtils::numeral()->choosePlural(15, $variants);
//Result: 15 гвоздей

echo RUtils::numeral()->getPlural(2, $variants);
//Result: 2 гвоздя
</pre>

        <h3>Выбор формы и вывод прописью</h3>
<pre>
echo RUtils::numeral()->sumString(1234, RUtils::MALE, $variants);
//Result: одна тысяча двести тридцать четыре гвоздя
</pre>

        <h3>Вывод числа прописью</h3>
<pre>
$numeral = RUtils::numeral();
echo $numeral->getInWordsInt(100);
//Result: сто

echo $numeral->getInWordsFloat(100.025);
//Result: сто целых двадцать пять тысячных

echo $numeral->getInWords(100.0);
//Result: сто
</pre>

        <h3>Вывод суммы денег в рублях</h3>
<pre>
echo RUtils::numeral()->getRubles(100.25);
//Result: сто рублей двадцать пять копеек
</pre>

        <h2 id="dt">Возможности Dt</h2>

        <h3>Сегодняшняя дата</h3>
        <p>
            Параметры передаются в качестве инстанса класса
            <code>\php_rutils\struct\TimeParams</code>,
            так же возможно передавать их в виде массива
        </p>
<pre>
$params = new TimeParams();
$params->date = null; //это значение по умолчанию
$params->format = 'сегодня d F Y года';
$params->monthInflected = true;
echo RUtils::dt()->ruStrFTime($params);
//Result: сегодня 22 октября 2013 года
</pre>


        <h3>Историческая дата</h3>
        <p>
            Параметры передаются в качестве массива,
            поля такие же как в классе <code>TimeParams</code>.
        </p>
        <p>
            Дата передается как строка в свободном формате. Так же возможно передавать дату
            как Unix timestamp или как инстанс класса <code>\DateTime</code>.
        </p>
<pre>
$params = array(
    'date' => '09-05-1945',
    'format' => 'l d F Y была одержана победа над немецко-фашистскими захватчиками',
    'monthInflected' => true,
    'preposition' => true,
);
echo RUtils::dt()->ruStrFTime($params);
//Result: в среду 9 мая 1945 была одержана победа над немецко-фашистскими захватчиками
</pre>


        <h3>Временной период до фиксированной даты в прошлом</h3>
        <p>Форматы времени для данной функции аналогичны форматам для <code>ruStrFTime</code>.</p>
        <p>Параметр <code>$accuracy</code> отвечает за подробность информации.</p>

<pre>
$toTime = new \DateTime('05-06-1945'); //Unix timestamp and string also available
echo RUtils::dt()->distanceOfTimeInWords($toTime), PHP_EOL;
//Result: 68 лет назад

$toTime = strtotime('05-06-1945');
$fromTime = null; //now
$accuracy = RUtils::ACCURACY_MINUTE; //years, months, days, hours, minutes
echo RUtils::dt()->distanceOfTimeInWords($toTime, $fromTime, $accuracy), PHP_EOL;
//Result: 68 лет, 4 месяца, 21 день, 19 часов, 12 минут назад
</pre>


        <h3>Временной период между фиксированными датами</h3>
<pre>
$fromTime = '1988-01-01 11:40';
$toTime = '2088-01-01 12:35';
$accuracy = RUtils::ACCURACY_MINUTE; //years, months, days, hours, minutes
echo RUtils::dt()->distanceOfTimeInWords($toTime, $fromTime, $accuracy), PHP_EOL;
//Result: через 100 лет, 55 минут
</pre>

        <h3>Возраст</h3>
<pre>
$birthDate = strtotime('today - 25 years');
echo RUtils::dt()->getAge($birthDate);
//Result: 25
</pre>

        <h2 id="translit">Возможности Translit</h2>
<pre>
//Транслитерация
echo RUtils::translit()->translify('Муха - это маленькая птичка');
//Result: Muxa - e`to malen`kaya ptichka

//Обратное преобразование
echo RUtils::translit()->detranslify("Muxa - e`to malen`kaya ptichka");
//Result: Муха - это маленькая птичка

//Подготовка для использования в URL'ях или путях
echo RUtils::translit()->slugify('Муха — это маленькая птичка');
//Result: muha-eto-malenkaya-ptichka
</pre>

        <h2 id="typo">Возможности Typo</h2>
<pre>
$text = &lt;&lt;&lt;TEXT
...Когда В. И. Пупкин увидел в газете ( это была "Сермяжная правда" № 45) рубрику Weather Forecast (r),
он не поверил своим глазам - температуру обещали +-451F.
TEXT;

//Стандартные правила
echo RUtils::typo()->typography($text);
/**
 * Result:
 * ...Когда В. И. Пупкин увидел в газете (это была «Сермяжная правда» №45) рубрику Weather Forecast®,
 * он не поверил своим глазам — температуру обещали ±451°F.
 */


//Правила из набора "extended"
echo RUtils::typo()->typography($text, TypoRules::$EXTENDED_RULES);
/**
 * Result:
 * …Когда В. И. Пупкин увидел в газете (это была «Сермяжная правда» №45) рубрику Weather Forecast®,
 * он не поверил своим глазам — температуру обещали ±451 °F.
 */

//Пользовательские правила
echo RUtils::typo()->typography($text, array(TypoRules::DASHES, TypoRules::CLEAN_SPACES));
/**
 * Result:
 * ...Когда В. И. Пупкин увидел в газете (это была "Сермяжная правда" № 45) рубрику Weather Forecast (r),
 * он не поверил своим глазам — температуру обещали +-451F.
 */
</pre>
</div>
