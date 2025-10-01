# Problem 1 – Bank Accounts (PHP OOP)

This exercise implements a **Bank Account System** using **OOP concepts** in PHP.  
It demonstrates **inheritance**, **method overriding**, and **business rules enforcement**.

---

## Requirement

1. **Class Design**  
   Base Class: `Account`  

   **Properties:**  
   - `accountNumber`  
   - `balance`  

   **Methods:**  
   - `deposit($amount)`  
   - `withdraw($amount)`  
   - `getBalance()`  

2. **Child Classes:**  

   **SavingsAccount**  
   - Max withdraw per transaction = 20,000  

   **CurrentAccount**  
   - Overdraft allowed, balance can go negative up to -5,000  

---

## Solution Approach

1. Created a **base class `Account`** with `accountNumber` and `balance`.  
2. Added **deposit**, **withdraw**, and **getBalance** methods in the base class.  
3. Created **SavingsAccount** and **CurrentAccount** classes extending `Account`.  
4. **Overrode `withdraw()`** method in child classes to enforce specific rules:  
   - SavingsAccount → max 20,000 per transaction  
   - CurrentAccount → overdraft limit -5,000  

---

## Example Implementation

```php
$sa = new SavingsAccount("sa-001");
$sa->deposit(20000);
$sa->deposit(30000);
$sa->withdraw(15000);
$sa->withdraw(20001);

$ca = new CurrentAccount("ca-001");
$ca->withdraw(3000);
$ca->withdraw(2200);
