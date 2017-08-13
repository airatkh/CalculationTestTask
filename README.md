Yii 2 Calc Test Task
====================

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.


DEMO PAGE
---------------------

[Demo Page Calc Test Task](http://uremont.zizlab.com/)


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

INSTALL
----------------

1. Create DB 

~~~
CREATE SCHEMA `uremont` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
~~~

2. Apply the migration

~~~
No migration has been done before.
airatkh@webdev uremont  % ./yii migrate
Yii Migration Tool (based on Yii v2.0.12)

Total 1 new migration to be applied:
	m170812_210951_InitCalculationCodes

Apply the above migration? (yes|no) [no]:yes
*** applying m170812_210951_InitCalculationCodes
    > create table calculation ... done (time: 0.022s)
    > create table code ... done (time: 0.023s)
    > create table calculation_code ... done (time: 0.020s)
    > add foreign key fk_calculation_code_calculation: calculation_code (calculation_id) references {{%calculation}} (id) ... done (time: 0.032s)
    > add foreign key fk_calculation_code_code1: calculation_code (code_id) references {{%code}} (id) ... done (time: 0.031s)
*** applied m170812_210951_InitCalculationCodes (time: 0.133s)


1 migration was applied.

Migrated up successfully.
airatkh@webdev uremont  %
~~~



~~~
Тестовое задание
Разработать приложение на Yii 2, позволяющее выполнять crud операции над расчетами. 
Расчет представляет собой произвольные данные в текстовом виде и может включать определенные коды.
Код  — это обычные целые числа (положительные и отрицательные), заключенные в фигурные скобки.
Таким образом, если в расчете встречаются фигурные скобки и между ними находятся только цифры или цифры со знаком "+" или "-" в начале, то это  код.
Вот пример такого расчета:
-------------- начало ----------------
demis
4
lala-}blab{la ! =))
:(
{457}7775 {-1.000001 }
32
{+98}
{2} {+3.14} {12637} 9812 {89123789}
1
O O1 01
1O
1}OO
{zer}o!
{df1000 ggg...
{5-}
105}
{-2010}
wass{auupp!!
--------------- конец ----------------
В этом расчете присутствуют следующие  коды по порядку: 457, 98, 2, 12637, 89123789, -2010.
"3.14", "-1.000001", "5-"  кодами не являются, так как в них присутствуют лишние символы.
У каждого расчета может быть название, например, "расчет от 10 сентября".
Люди, которые будут пользоваться вашим приложением, хотят получить следующий функционал:
— Добавление и сохранение расчета в БД. При добавлении расчета пользователь указывает его название и в большое текстовое поле вставляет сам расчет. Приложение должно сохранить введенные пользователем данные в БД, разобрать расчет на  коды, записать полученные  коды в БД, связав их с добавленным расчетом.
— Просмотр списка сохраненных ранее расчетов. Пользователь должен видеть название каждого расчета, дату создания и список  кодов этого расчета.
— Выбор расчетных данных по  кодам. Приложение должно позволять пользователю выбирать расчеты с определенными  кодами. Например, пользователь может захотеть увидеть расчеты:
— в которых есть  коды больше 2000
— в которых есть  код 2
— в которых присутствуют  коды меньше 50000
Примечания.
Результат должен быть в виде архива, включающим в себя код на PHP и SQL таблиц для СУБД MySQL и без дополнительных настроек запускаться при распаковке в www-директорию веб-сервера.

~~~