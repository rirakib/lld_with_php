<?php


class Employee
{
    protected $id, $name, $salary = 0, $employee_type = "fulltime";
    protected $account;

    function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    function assignAccount(Account $account)
    {
        $this->account = $account;
    }

    function getAccount(): Account
    {
        return $this->account;
    }

    function getBaseSalary(): float
    {
        return $this->salary;
    }

    function getEmployeeType(): string
    {
        return $this->employee_type;
    }

    function getDetails(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'employee_type' => $this->employee_type,
            'salary' => $this->salary,
            'account_balance' => $this->account->getBalance(),
            'account_type' => $this->account->getAccountType()
        ];
    }

    function calculateSalary(): float
    {
        return $this->salary;
    }
}

class FullTimeEmployee extends Employee
{
    function __construct(string $id, string $name, float $salary)
    {
        parent::__construct($id, $name);
        $this->salary = $salary;
        $this->employee_type = "fulltime";
    }
}

class PartTimeEmployee extends Employee
{
    function __construct(string $id, string $name, float $perHourSalary, float $totalHour)
    {
        parent::__construct($id, $name);
        $this->salary = $perHourSalary * $totalHour;
        $this->employee_type = "parttime";
    }
}

class InternShipEmployee extends Employee
{
    function __construct(string $id, string $name, float $stipend)
    {
        parent::__construct($id, $name);
        $this->salary = $stipend;
        $this->employee_type = "internship";
    }
}


abstract class Account
{
    protected $accountNumber, $balance;

    function __construct(string $accountNumber, float $balance = 0)
    {
        $this->accountNumber = $accountNumber;
        $this->balance = $balance;
    }

    abstract function withdraw(float $amount): array;

    function deposit(float $amount): array
    {
        if ($amount <= 0) {
            return ['status' => 'error', 'message' => 'Deposit amount must be positive'];
        }
        $this->balance += $amount;
        return ['status' => 'success', 'message' => 'Deposit successful', 'balance' => $this->balance];
    }

    function getBalance(): float
    {
        return $this->balance;
    }

    function getAccountNumber(): string
    {
        return $this->accountNumber;
    }

    abstract function getAccountType(): string;
}

class SavingsAccount extends Account
{
    const MAX_WITHDRAW = 20000;

    function withdraw(float $amount): array
    {
        if ($amount > $this->balance) {
            return ['status' => 'error', 'message' => 'Insufficient balance'];
        }
        if ($amount > self::MAX_WITHDRAW) {
            return ['status' => 'error', 'message' => 'Exceeds withdraw limit'];
        }
        $this->balance -= $amount;
        return ['status' => 'success', 'message' => 'Withdraw successful', 'balance' => $this->balance];
    }

    function getAccountType(): string
    {
        return 'Savings';
    }
}

class CurrentAccount extends Account
{
    const MAX_OVERDRAFT = -5000;

    function withdraw(float $amount): array
    {
        $tempBalance = $this->balance - $amount;
        if ($tempBalance < self::MAX_OVERDRAFT) {
            return ['status' => 'error', 'message' => 'Overdraft limit exceeded'];
        }
        $this->balance -= $amount;
        return ['status' => 'success', 'message' => 'Withdraw successful', 'balance' => $this->balance];
    }

    function getAccountType(): string
    {
        return 'Current';
    }
}

class Bonus
{
    protected $employee;

    function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    function bonusGenerate(): float
    {
        $type = $this->employee->getEmployeeType();
        $baseSalary = $this->employee->getBaseSalary();

        switch ($type) {
            case 'fulltime':
                return $baseSalary > 50000 ? 0.1 * $baseSalary : 0;
            case 'parttime':
            case 'internship':
            default:
                return 0;
        }
    }
}


$employees = [
    new FullTimeEmployee("fte-001", "Rakib", 60000),
    new PartTimeEmployee("pte-001", "Riyad", 300, 40),
    new InternShipEmployee("ine-001", "Shanto", 8000),
    new InternShipEmployee("ine-002", "Sajib", 8000)
];


$employees[0]->assignAccount(new SavingsAccount("SA-001"));
$employees[1]->assignAccount(new CurrentAccount("CA-001"));
$employees[2]->assignAccount(new SavingsAccount("SA-002"));
$employees[3]->assignAccount(new CurrentAccount("CA-002"));


foreach ($employees as $emp) {

    $bonus = new Bonus($emp);
    $totalSalary = $emp->calculateSalary() + $bonus->bonusGenerate();

    $emp->getAccount()->deposit($totalSalary);

    $details = $emp->getDetails();
    echo "Employee: {$details['name']} ({$details['employee_type']})<br/>";
    echo "Base Salary: {$emp->calculateSalary()}<br/>";
    echo "Bonus: " . $bonus->bonusGenerate() . "<br/>";
    echo "Total Deposited Salary: $totalSalary<br/>";
    echo "Account Type: {$details['account_type']}<br/>";
    echo "Account Balance: {$details['account_balance']}<br/>";

    $withdrawAttempt = 15000;
    $withdrawResult = $emp->getAccount()->withdraw($withdrawAttempt);
    echo "Withdraw {$withdrawAttempt} → {$withdrawResult['message']}<br/><br/>";
}
