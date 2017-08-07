<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.08.17
 * Time: 16:45
 */

namespace Niklas\Form;


class ActionForm extends Form
{


    public function isValid() {
        $valid = true;
        foreach ($this->mValidators as $inputName => $validator) {
            try {
                $validator->validateInputValue($_POST[$inputName]);
            } catch (FormDataException $e) {
                $this->setError($inputName, $e->getMessage());
                $valid = false;
            }
        }
        return $valid;
    }


    public function onSubmit($btnInputname ,callable $function) {
        if($_SERVER['REQUEST_METHOD'] != $this->mMethod) {
            return;
        }
        if($btnInputname !== null && !isset($_POST[$btnInputname])) {
            return;
        }
        if( ! $this->isValid())
            return;
        try {
            $function($_POST);
        } catch(FormDataException $e) {
            $this->setError($e->getInputName(),$e->getMessage());
        }
    }
}
