<?php

class Employee
{
    protected $id, $name, $salary = 0;

    function __construct(
        string $id,
        string $name
    ) {
        $this->id = $id;
        $this->name = $name;
    }

    function getDetails(): array
    {
        return [
            'status' => 'success',
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'salary' => $this->salary
            ]
        ];
    }

    function calculateSalary(): array
    {
        return [
            'status' => 'success',
            'name' => $this->name,
            'salary' => $this->salary
        ];
    }
}


class FullTimeEmployee extends Employee
{

    function __construct(
        string $id,
        string $name,
        float $salary
    ) {
        parent::__construct($id,$name);
        $this->salary = $salary;
    }
}

class PartTimeEmployee extends Employee
{

    function __construct(
        string $id,
        string $name,
        float $hourlySalary,
        float $totalHour
    ) {
        parent::__construct($id,$name);
        $this->salary = $hourlySalary * $totalHour;
    }
}

class Intern extends Employee
{
    function __construct(
        string $id,
        string $name,
        float $stipend
    ) {
        parent::__construct($id,$name);
        $this->salary = $stipend;
    }
}


$employees = [
    new FullTimeEmployee("fte-001", "Rakib", 60000),
    new PartTimeEmployee("pte-001", "Riyad", 300, 40),
    new Intern("ine-001", "Shanto", 8000)
];

foreach ($employees as $emp) {
    print_r($emp->calculateSalary());
    echo "<br/>";
}
