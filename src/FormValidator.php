<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.08.17
 * Time: 17:05
 */

namespace Niklas\Form;


class FormValidator
{
    private $mInputName;

    private $mRequired = false;

    private $mCheckPreg = null;

    private $msg;

    public function __construct($inputName)
    {
        $this->mInputName = $inputName;
    }

    public function required($msg = "Required field!") : self {
        $this->mRequired = true;
        $this->msg = $msg;
        return $this;
    }


    public function match($preg) : self {
        $this->mCheckPreg = $preg;
        return $this;
    }

    public function validateInputValue($value) {
        if ($this->mRequired)
            if (empty($value))
                throw new FormDataException($this->mInputName, $this->msg);
    }

}