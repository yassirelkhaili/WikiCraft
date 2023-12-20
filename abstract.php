<?php

//This file was written during a live coding session I hosted to teach my classmates about supers, abstract functions, php oop override and method overload.

namespace random;

class Car {
    public function __call($method_name, $arguments) {
        $argumentCount = count($arguments);
        if ($method_name === "sayName") {
            switch ($argumentCount) {
                case 0;
                echo "no arguments";
                break;
                case 1;
                $this->sayOneName($arguments[0]);
                break;
                case 2;
                $this->sayTwoNames($arguments[0], $arguments[1]);
                break;
                default:
                echo "incorrect num of args";
                break;
            }
        }
    }
    protected function sayOneName ($name) {
        echo $name;
    }
    private function sayTwoNames ($name1, $name2) {
        echo $name1 . " " . $name2;
    }
}

class Audi extends Car {
    public function callParentMethod () {
        echo parent::sayOneName("Yassir");
    }
}

$car = new Car();
$car->sayName("Yassine", "Fatim zahra");
