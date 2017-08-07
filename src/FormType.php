<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 07.08.17
 * Time: 10:32
 */

namespace Niklas\Form;


class FormType
{
    public $mEmail = false;
    public $mPassword = false;
    private $mInputName;


    public function __construct($inputName)
    {
        $this->mInputName = $inputName;
    }

    public function setEmail() {
        $this->mEmail = true;
    }

    public function setPassword() {
        $this->mPassword = true;
    }


}