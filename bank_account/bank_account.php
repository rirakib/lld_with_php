<?php

class Account
{
    protected $balance;
    private $accountNumber;

    function __construct(string $accountNumber, float $balance = 0)
    {
        $this->balance = $balance;
        $this->accountNumber = $accountNumber;
    }

    function deposit(float $amount): array
    {
        if ($amount <= 0) {
            return ['status' => 'error', 'message' => 'Deposit amount must be positive'];
        }

        $this->balance += $amount;
        return ['status' => 'success', 'message' => 'Balance deposit successful'];
    }

    function withdraw(float $amount): array
    {
        if ($amount > $this->balance) {
            return ['status' => 'error', 'message' => 'You have not enough balance'];
        }

        return $this->withdrawProcess($amount);
    }

    protected function withdrawProcess(float $amount): array
    {
        $this->balance -= $amount;
        return ['status' => 'success', 'message' => 'Successfully withdraw'];
    }

    function getBalance(): array
    {
        return ['status' => 'success', 'balance' => $this->balance];
    }

    function getAccountNumber(): array
    {
        return ['status' => 'success', 'account_number' => $this->accountNumber];
    }
}

class SavingsAccount extends Account
{

    const MAX_WITHDRAW_PER_TRANSACTION = 20000;

    function withdraw(float $amount) : array
    {
        if ($amount > $this->balance) {
            return ['status' => 'error', 'message' => 'You have not enough balance'];
        } else {
            if ($amount > SELF::MAX_WITHDRAW_PER_TRANSACTION) {
                return ['status' => 'error', 'message' => 'Exceeds withdraw limit'];
            } else {
                return $this->withdrawProcess($amount);
            }
        }
    }
}

class CurrentAccount extends Account
{
    const MAX_OVER_DRAFT = -5000;

    function withdraw(float $amount) : array
    {
        if ($amount > $this->balance) {
            $tempBalance = $this->balance - $amount;

            if ($tempBalance < self::MAX_OVER_DRAFT) {
                return ['status' => 'error', 'message' => 'Overdraft limit exceeded'];
            }

            return $this->withdrawProcess($amount);
        }

        return $this->withdrawProcess($amount);
    }
}

$sa = new SavingsAccount("sa-001");
$sa->deposit(20000);
$sa->deposit(30000);
$sa->getBalance();
$sa->withdraw(15000);
$sa->getBalance();
$sa->withdraw(20001);

$ca = new CurrentAccount("ca-001");
$ca->getBalance();
$ca->withdraw(3000);
$ca->getBalance();
$ca->withdraw(2200);
