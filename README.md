x-evo
=====

Механизм расширения для MODX Evolution / Clipper CMS

Краткое введение
----------------

При запуске modx стартует плагин, который запускает автолоадер. Сравнительно небольшие соглашения по размещению файлов с библиотеками позволяют в этом же плагине через пространства имен подключать практически любые сторонние библиотеки. Управляет этим всем очень простой код, который я пока приводить и комментировать не буду; скорее всего все это еще будет меняться, так как есть желание в будущем прикрутить под него нормальный механизм установки/обновления. 

В качестве примера работы механизма расширений выбран проект [[RUtils|https://github.com/Andre-487/php_rutils]] - небольшая библиотека, которая позволяет работать с русским текстом в датах, временных интервалах, переводить числа в пропись и немного типографировать. После несложной регистрации в плагине:

```
$loader->addNamespace('Modx\Ext\Rutils', MODX_BASE_PATH.'assets/extensions/Rutils/lib');
```

становится возможным в любом сниппете написать следующее:

```
<?php
use Modx\Ext\Rutils\RUtils;
use Modx\Ext\Rutils\TypoRules;

echo $numeral->getInWordsFloat(100.025),'<br><br>';

//Result: сто целых двадцать пять тысячных
```

В планах (собственно, сейчас идет разработка) инструментарий для управления каталогами.
