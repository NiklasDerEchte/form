<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 04.08.17
 * Time: 12:56
 */

namespace Niklas\Form;


use Throwable;

class FormDataException extends \Exception
{
    protected $mInputName;

    public function __construct($inputName, $msg, $code = 0) {
       $this->mInputName = $inputName;
       parent::__construct($msg, $code);
    }

    public function getInputName() {
        return $this->mInputName;
    }
}