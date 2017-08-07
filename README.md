# Niklas/form
Render bootstrap 3.2 html forms

## Example

```php
$form = new ActionForm(null, "POST");
$form->addInput("name", "Name")->required("Bitte Name angeben!");
$form->addInput("email", "Email", "email")->required("Bitte eine gültige Email angeben!");
$form->addInput("pass", "Passwort", "password")->required("Bitte Passwort eingeben!");
$form->setSubmit("Absenden", "senden");

$form->setData(@$_POST);

$form->onSubmit( "senden",
        function ($fdata) {
            echo "DATEN GESENDET!";
        }
);

echo $form->render();
```

## Install

Niklas/Form ist available at packagist.org.

insall it using composer: 

```
composer require niklas/form
```
