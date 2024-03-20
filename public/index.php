<?php

interface Action
{
    public function action(string $operator);
}


class SimpleCalculator implements Action
{
    protected float $number1;
    protected float $number2;

    public function __construct(float $number1, float $number2)
    {
        $this->number1 = $number1;
        $this->number2 = $number2;
    }



    public function action(string $operator): mixed
    {
        switch ($operator) {
            case '+':
                $result = $this->number1 + $this->number2;
                break;
            case '-':
                $result = $this->number1 - $this->number2;
                break;
            case '*':
                $result = $this->number1 * $this->number2;
                break;
            case '/':
                if (($this->number2 != 0)) {
                    $result = $this->number1 / $this->number2;
                    break;
                } else {
                    throw new InvalidArgumentException("Сannot be divided by 0");
                }

            default:
                throw new InvalidArgumentException("Invalid operator");
        }
        echo round($result, 2, PHP_ROUND_HALF_UP) . PHP_EOL;
        return round($result, 2, PHP_ROUND_HALF_UP);
    }
}

$myCalc = new SimpleCalculator(1, 3);
$myCalc->action('+');

class FigureCalculation extends SimpleCalculator
{

    protected SimpleCalculator $simpleCalculator;

    public function __construct($simpleCalculator){
        $this->simpleCalculator = $simpleCalculator;
    }

    public function action($operator): mixed
    {
        switch ($operator) {
            case 'area':
                $result = $this->simpleCalculator->action('*');

                break;

            case 'perimeter':
                $result = $this->simpleCalculator->action('+')*2;
                break;
            default:
                throw new InvalidArgumentException("Invalid operator");
        }
        echo $result . PHP_EOL;
        return $result;

    }
}

$myNewCalc = new FigureCalculation(new SimpleCalculator(1,2));

$myNewCalc->action('area');
