<?php 

// abstract class instance create direct kora jayna
// abstract class a obossoi akta abstract method thakte hobe , without body
// abstract class extends korte hoy
// abstract class ar reserve key abstract
// abstract class tar child class k force kore method use koraite jeta abstract method a thake
//abstract class a amra abstract method chara normal method o likhte pari
//abstract ar method gulo public or protected hoy

abstract class Car 
{
    protected $name;
    function __construct(string $name)
    {
        $this->name = $name;
    }

    abstract function intro();
}

class Audi extends Car
{
    function intro()
    {
        echo "This is $this->name";
    }
}


$audi = new Audi("Audi");
$audi->intro();