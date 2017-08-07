<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 03.08.17
 * Time: 11:35
 */
namespace Niklas\Form;
ini_set("display_errors",1);
require __DIR__ . "/../vendor/autoload.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>formTest</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <?php
        //print_r($_SERVER);

        $form = new ActionForm(null, "POST");

        $form->addInput("name", "Name")->required("Bitte Name angeben!");

        $form->addInput("email", "Email", "email")->required("Bitte eine gültige Email angeben!");

        $form->addInput("firma", "Unternehmen");

        $form->addInput("pass", "Passwort", "password")->required("Bitte Passwort eingeben!");

        $form->setSubmit("Absenden", "senden");

        $form->setData(@$_POST);
        
        $form->onSubmit( "senden",
                function ($fdata) {
                    echo "DATEN GESENDET!";
                }
        );

        echo $form->render();

        ?>
</div>

</body>
</html>
