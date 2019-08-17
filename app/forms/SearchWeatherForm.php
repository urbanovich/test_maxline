<?php

namespace TestMaxLine\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Select;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class SearchWeatherForm extends Form
{
    public function initialize()
    {
        $name = new Text('name');

        $name->addValidator(
            new PresenceOf(
                [
                    'message' => 'The name is required',
                ]
            )
        );

        $name->addValidator(
            new StringLength(
                [
                    'min'            => 3,
                    'messageMinimum' => 'The name is too short',
                ]
            )
        );

        $this->add($name);
    }
}