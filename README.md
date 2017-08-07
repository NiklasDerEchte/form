# Niklas/form
Render bootstrap 3.2 html forms

## Example

```php
$form = new ActionForm(null, "POST");
$form->addInput("name", "Name")->required("Please enter a name!");
$form->addInput("email", "Email", "email")->required("Please enter a valid email!");
$form->addInput("pass", "Password", "password")->required("Please enter a password!");
$form->setSubmit("Submit", "send");

$form->setData(@$_POST);

$form->onSubmit( "send",
        function ($fdata) {
            echo "DATA SEND";
        }
);

echo $form->render();
```

## Install

Niklas/Form is available at packagist.org.

insall it using composer: 

```
composer require niklas/form
```
