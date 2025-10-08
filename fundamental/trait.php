<?php




/*
|-------------------------------------------------------
| 1 Basic Trait Use — এক class এ behavior যোগ করা
|-------------------------------------------------------
*/
trait Logger {
    function log($msg) {
        echo "[LOG] $msg\n";
    }
}

class User {
    use Logger;
}

echo "Basic Trait Example:\n";
$user = new User;
$user->log("User created");
echo "<br/>";


/*
|-------------------------------------------------------
|2. Multiple Trait Use — এক class এ অনেক trait যোগ করা যায়
|-------------------------------------------------------
*/
trait A {
    function sayA() { echo "A\n"; }
}

trait B {
    function sayB() { echo "B\n"; }
}

class Multi {
    use A, B;
}

echo " Multiple Trait Example:\n";
$m = new Multi;
$m->sayA();
$m->sayB();
echo "<br/>";


/*
|-------------------------------------------------------
| Trait Conflict Resolve — same method থাকলে insteadof/as use
|-------------------------------------------------------
*/
trait X { function talk() { echo "X talks\n"; } }
trait Y { function talk() { echo "Y talks\n"; } }

class Z {
    use X, Y {
        X::talk insteadOf Y;   // X এর method priority পাবে
        Y::talk as talkY;      // Y এর method আলাদা নামে রাখা
    }
}

echo "Trait Conflict Example:\n";
$z = new Z;
$z->talk();   // Output: X talks
$z->talkY();  // Output: Y talks
echo "\n";


/*
|-------------------------------------------------------
|  Abstract Method in Trait — class কে implement করতে হয়
|-------------------------------------------------------
*/
trait Greet {
    abstract function sayHello();

    function greetUser() {
        echo "Hi, " . $this->sayHello() . "\n";
    }
}

class Person {
    use Greet;

    function sayHello() {
        return "I'm Rakib";
    }
}

echo " Abstract Method in Trait Example:\n";
$p = new Person;
$p->greetUser(); // Hi, I'm Rakib
echo "<br/>";


/*
|-------------------------------------------------------
| Trait এ Static Property ও Static Method Use করা যায়
|-------------------------------------------------------
*/
trait Counter {
    public static $count = 0;

    static function increment() {
        self::$count++;
        echo "Count: " . self::$count . "\n";
    }
}

class Click {
    use Counter;
}

echo "5 Static Property Example:\n";
Click::increment();
Click::increment();
echo "<br/>";


/*
|-------------------------------------------------------
| Trait এ Constant Use করা যায়
|-------------------------------------------------------
*/
trait AppInfo {
    const VERSION = "1.0.0";
}

class System {
    use AppInfo;
}

echo " Trait Constant Example:\n";
echo System::VERSION . "\n\n";


/*
|-------------------------------------------------------
| Trait Method এর Access Modifier পরিবর্তন করা যায়
|-------------------------------------------------------
*/
trait T {
    function show() { echo "Visible\n"; }
}

class Demo {
    use T { show as private; }

    public function reveal() {
        $this->show();
    }
}

echo "7️⃣ Access Modifier Example:\n";
$d = new Demo;
$d->reveal(); // Visible
echo "<br/>";


/*
|-------------------------------------------------------
| Trait vs Parent Class Priority — Trait wins
|-------------------------------------------------------
*/
class ParentClass {
    function greet() { echo "Hello from Parent\n"; }
}

trait TraitGreet {
    function greet() { echo "Hello from Trait\n"; }
}

class Child extends ParentClass {
    use TraitGreet;
}

echo "Trait vs Parent Class Example:\n";
$c = new Child;
$c->greet(); // Hello from Trait
echo "<br/>";


/*
|-------------------------------------------------------
| Class Method Override করলে Trait override হয়
|-------------------------------------------------------
*/
trait Hello {
    function say() { echo "Hello from Trait\n"; }
}

class World {
    use Hello;

    function say() { echo "Hello from Class\n"; }
}

echo " Class Override Example:\n";
$w = new World;
$w->say(); // Hello from Class
echo "<br/>";


/*
|-------------------------------------------------------
| Nested Trait — Trait এর ভিতরে Trait use করা যায়
|-------------------------------------------------------
*/
trait Inner {
    function inner() { echo "Inner trait\n"; }
}

trait Outer {
    use Inner;
    function outer() { echo "Outer trait\n"; }
}

class Nest {
    use Outer;
}

echo "Nested Trait Example:\n";
$n = new Nest;
$n->inner();
$n->outer();
echo "<br/>";


/*
|-------------------------------------------------------
|
 Trait Property Example — Trait এ Property use করা যায়
|-------------------------------------------------------
*/
trait Author {
    public $name = "Rakib";
}

class Blog {
    use Author;
}

echo " Trait Property Example:\n";
$b = new Blog;
echo $b->name . "\n\n";


/*
|-------------------------------------------------------
| Real-life Example — Reusable Behavior (Logger + Validator)
|-------------------------------------------------------
*/
trait Validator {
    function validateEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}

class UserRegister {
    use Logger, Validator;

    function register($email) {
        if ($this->validateEmail($email)) {
            $this->log("User registered: $email");
        } else {
            $this->log("Invalid email address");
        }
    }
}

echo "Real-life Trait Example:\n";
$u = new UserRegister;
$u->register("rakib@example.com");
$u->register("invalid_email");
echo "<br/>";


/*
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Trait = Reusable behavior container.
| এক class এ multiple trait use করা যায়।
| conflict হলে insteadof/as দিয়ে resolve করতে হয়।
| trait এ abstract, static, property, constant — সব রাখা যায়।
| class method trait কে override করতে পারে।
| trait parent class কে override করে।
|--------------------------------------------------------------------------
*/

?>
