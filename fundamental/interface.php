<?php

//interface direct instance create kora jayna 
// interface implements korte hoy
// multiple interface aksathe akta class a implements kora jay
// interface amader direction day asole kon class a ki ki method implement korte hobe
// interface polymorphism behaviour kore
// interface a method ar body dite hoyna just signeture part thake 
// interface ar kono property nai but abstract ar property ase
// interface er sokol method public hoy but abstract ar public and protected hoy
// 

interface Animal
{
    public function makeSound();
}

class Cat implements Animal
{
    public function makeSound()
    {
        echo "Meow";
    }
}

$animal = new Cat();
$animal->makeSound();
