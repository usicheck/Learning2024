<?php

class Address {
    public string $city;

    public function __construct(string $city) {
        $this->city = $city;
    }
}


class User {
    public function __construct(public Address $address, protected array $data = []) {}

    public function __get(string $login): string {
        if (isset($this->data[$login])) {
            return $this->data[$login];
        }
        return '';
    }

    public function __set(string $login, string $value): void {
        $this->data[$login] = $value;
    }

    public function __isset(string $login): bool {
        return isset($this->data[$login]);
    }

    public function __clone(): void
    {
        if (isset($this->address)) {
            $this->address = clone $this->address;
        }
    }
}



$myUser = new User(new Address('Dnipro'), [
    'login' => 'usicheck',
    'password' => 'password12345',
]);

$myUser->login; //приклад коду, який стає тригером для запуску методу __get

$myUser->password = 'pass123'; //приклад коду, який стає тригером для запуску методу __set

$myUser->password;

//магічний метод __isset() буде викликаний автоматично, але якщо потрібно отримати явну відповідь по властивості:
if (isset($myUser->login)){
    echo 'True' , PHP_EOL;
}
else {
    echo 'False' . PHP_EOL;
}


$myClonedUser = clone $myUser; //приклад коду, який стає тригером для запуску методу __clone

$myClonedUser->address->city = 'Lviv';

echo "Адреса об'єкта User: " . $myUser->address->city . PHP_EOL;
echo "Адреса склонованого об'єкта User: " . $myClonedUser->address->city . PHP_EOL;

