<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.08.17
 * Time: 11:34
 */

namespace Niklas\Form;

class Form
{
    public $mMethod;
    private $mAction;
    public $mRowData = [];
    public $mSubmit = [];
    private $mError = [];
    private $mData = [];
    private $mStructure;
    private $mTypes = [];
    private $mRadio = [];
    private $mCheckBox = [];
    private $mSelect = [];
    private $mCheckedRadio;
    /**
     * @var FormValidator[]
     */
    protected $mValidators = [];

    public function __construct($action, $method)
    {
        if($action === null) {
            $action = $_SERVER['PHP_SELF'];
        }

        $this->mMethod = $method;
        $this->mAction = $action;
    }


    public function addInput ($inputName, $labelName = null, $type = null) : FormValidator {
        $this->mRowData[$inputName] = $labelName;
        if($type !== null) {
            if ($type === "email") {
                $formType = new FormType($inputName);
                $formType->setEmail();
                $this->mTypes[$inputName] = $formType;
            } else if ($type === "password") {
                $formType = new FormType($inputName);
                $formType->setPassword();
                $this->mTypes[$inputName] = $formType;
            }
        }
        return $this->mValidators[$inputName] = new FormValidator($inputName);
    }

    public function setSubmit($btnName = null, $inputName) {
        if($btnName === null) {
            $btnName = "Submit";
        }
        $this->mSubmit[$inputName] = $btnName;
    }

    public function setData(array $input) {
        foreach ($input as $key => $value) {
            $this->mData[$key] = $input[$key];
        }
    }

    public function setError($inputName, $errorMsg) {
        $this->mError[$inputName] = $errorMsg;
    }

    public function addSelect($id, array $options, $text) {
        $tempAr = [];
        $tempAr["text"] = $text;
        foreach ($options as $key => $value) {
            $tempAr[$key] = $value;
        }
        $this->mSelect[$id] = $tempAr;
    }

    public function radioDefaultChecked($inputName){
        $this->mCheckedRadio = $inputName;
    }

    public function addRadio($inputName, array $values, $text) {
        $tempAr = [];
        $tempAr["text"] = $text;
        foreach ($values as $key => $value) {
            $tempAr[$key] = $value;
        }
        $this->mRadio[$inputName] = $tempAr;
    }

    public function addCheckbox($inputName,array $values , $text) {
        $tempAr = [];
        $tempAr["text"] = $text;
        foreach ($values as $key => $value) {
            $tempAr[$key] = $value;
        }
        $this->mCheckBox[$inputName] = $tempAr;
    }

    public function render() {
        $this->mStructure[] = "<div class='well bs-component'><form class='form-horizontal' method='{$this->mMethod}'><fieldset>";
        foreach ($this->mRowData as $key => $value) {
            if(array_key_exists($key, $this->mError)) {

                $line = "<div class='form-group has-error'>";
                $line .= "<label for='input{" . htmlspecialchars($key) . "}' class='col-sm-2 control-label'>" . htmlspecialchars($value) . "</label>";
                $line .= "<div class='col-sm-10'>";
                $line .= "<input type='text' class='form-control' value='' name='" . htmlspecialchars($key) . "' id='input" . htmlspecialchars($key) . "' placeholder='" . htmlspecialchars($value) . "' aria-describedby=''>";
                if (array_key_exists($key, $this->mData)) {
                    $item = $this->mData[$key];
                    $line = str_replace("value=''", "value='$item'", $line);
                }
                if(array_key_exists($key, $this->mTypes)) {
                    $formType = $this->mTypes[$key];
                    if($formType->mEmail === true) {
                        $line = str_replace("type='text'", "type='email'", $line);
                    }
                    else if($formType->mPassword === true) {
                        $line = str_replace("type='text'", "type='password'", $line);
                    }

                }
                $line .= "</span><span class='help-inline'>{$this->mError[$key]}</span>";
                $line .= "</div></div>";
                $this->mStructure[] = $line;
                continue;
            }

            $line = "<div class='form-group'>";
            $line .= "<label for='input" . htmlspecialchars($key) . "' class='col-sm-2 control-label'>" . htmlspecialchars($value) . "</label>";
            $line .= "<div class='col-sm-10'>";
            $line .= "<input type='text' class='form-control' value='' name='" . htmlspecialchars($key) . "' id='input" . htmlspecialchars($key) . "' placeholder='" . htmlspecialchars($value) . "' aria-describedby=''>";
            if (array_key_exists($key, $this->mData)) {
                $item = $this->mData[$key];
                $line = str_replace("value=''", "value='" . htmlspecialchars($item) . "'", $line);
            }
            if(array_key_exists($key, $this->mTypes)) {
                $formType = $this->mTypes[$key];
                if($formType->mEmail === true) {
                    $line = str_replace("type='text'", "type='email'", $line);
                }
                else if($formType->mPassword === true) {
                    $line = str_replace("type='text'", "type='password'", $line);
                }

            }
            $line .= "</div></div>";
            $this->mStructure[] = $line;
        }

        foreach ($this->mSelect as $item => $index) {
            $line = "";
            foreach ($index as $key => $value) {
                if($key === "text") {
                    $line .= "<div class='form-group'><label for='" . htmlspecialchars("$item") . "' class='col-sm-2 control-label'>$value</label><div class='col-sm-10'><select class='form-control' id='" . htmlspecialchars("$item") . "' name='" . htmlspecialchars("$item") . "'>";
                    continue;
                }
                $line .= "<option>" . htmlspecialchars("$value") . "</option>";
            }
            $line .= "</select></div></div>";
            $this->mStructure[] = $line;
        }

        foreach ($this->mRadio as $item => $index) {
            $line = "";
            foreach ($index as $key => $value) {
                if($key === "text") {
                    $line .= "<div class='form-group'><label class='col-sm-2 control-label'>" . htmlspecialchars($value) . "</label><div class='col-sm-10'>";
                    continue;
                }
                if($this->mCheckedRadio == $key) {
                    $line .= "<div class='radio'><label><input type=" . htmlspecialchars("radio") . " name=" . htmlspecialchars($item) . " checked='checked' value=" . htmlspecialchars($key) . ">$value</label></div>";
                    continue;
                }
                $line .= "<div class='radio'><label><input type=" . htmlspecialchars("radio") . " name=" . htmlspecialchars($item) . " value=" . htmlspecialchars($key) . ">$value</label></div>";
            }
            $line .= "</div></div>";
            $this->mStructure[] = $line;
        }

        foreach ($this->mCheckBox as $item => $index) {
            $line = "";
            foreach ($index as $key => $value) {
                if($key === "text") {
                    $line .= "<div class='form-group'><label class='col-sm-2 control-label'>" . htmlspecialchars($value) . "</label><div class='col-sm-10'>";
                    continue;
                }
                $line .= "<div class='checkbox'><label><input type=" . htmlspecialchars("checkbox") . " name=" . htmlspecialchars($item) . " value=" . htmlspecialchars($key) . ">" . htmlspecialchars($value) . "</label></div>";
            }
            $line .= "</div></div>";
            $this->mStructure[] = $line;
        }




        foreach ($this->mSubmit as $key => $value) {
            $line = "<div class='form-group'><div class='col-sm-offset-2 col-sm-10'><button type='submit' name='" . htmlspecialchars($key) . "' class='btn btn-default'>" . htmlspecialchars($value) . "</button></div></div>";
            $this->mStructure[] = $line;
        }

        $this->mStructure[] = "</div></fieldset></form>";
        $finalForm = "";
        foreach($this->mStructure as $key) {
            $finalForm .= $key;
        }

        return $finalForm;
    }
}