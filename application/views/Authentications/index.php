<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Authentication</title>
</head>
<body>
    <form action="register" method="post">
<?php
        $errors = $this->session->flashdata('errors');
        if($errors && $errors["type"] === "register"){
        foreach($errors as $key=>$error){
            if($key !== "type"){
?>
        <p><?= $error ?></p>
<?php
                }
            }
        }
?>
        <fieldset>
            <legend>Register</legend>
            <label>First name:
                <input type="text" name="first_name">
            </label>
            <label>Last name:
                <input type="text" name="last_name">
            </label>
            <label>Contact number:
                <input type="text" name="contact">
            </label>
            <label>Password
                <input type="password" name="password">
            </label>
            <label>Confirm Password
                <input type="password" name="passwordconf">
            </label>
            <input type="submit" value="Register">
        </fieldset>
    </form>
    <form action="login" method="post">
<?php
        $errors = $this->session->flashdata('errors');
        if($errors && $errors["type"] === "login"){
        foreach($errors as $key=>$error){
            if($key !== "type"){
?>
        <p><?= $error ?></p>
<?php
                }
            }
        }
?>
        <fieldset>
            <legend>Login</legend>
            <label>Contact number:
                <input type="text" name="contact">
            </label>
            <label>Password
                <input type="password" name="password">
            </label>
            <input type="submit" value="Login">
        </fieldset>
    </form>
</body>
</html>