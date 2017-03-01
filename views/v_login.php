<?php 
    if (isset($_SESSION['errors'])) {
?>
        <ul id="errors">
<?php
        foreach ($_SESSION['errors'] as $error) {
?>
            <li><?php echo $error; ?></li>
<?php
        }
?>
        </ul>

<?php
    }
?>
        <div id="main">
            <form action="subscribe.php" method="POST" id="signIn">
                <input type="text" id="lName" name="lName" value="<?php echoIfPosted('lname'); ?>" placeholder="Votre Nom :" />
                <input type="text" id="fName" name="fName" value="<?php echoIfPosted('fName'); ?>" placeholder="Votre Prénom :" required />
                <input type="mail" id="s_mail" name="mail" value="<?php echoIfPosted('mail'); ?>" placeholder="Votre E-mail :" required />
                <input type="password" id="s_pass" name="pass" placeholder="Votre Mot de passe :" required />
                <input type="password" id="confirm" placeholder="Confirmation du Mot de passe :" required />
                <input type="submit" value="S'inscrire" />
            </form>
            <form action="login.php" method="POST" id="logIn">
                <input type="mail" id="l_mail" name="mail" value="<?php echoIfPosted('mail'); ?>" placeholder="E-mail :" required />
                <input type="password" id="l_pass" name="pass" placeholder="Mot de passe :" required />
                <input type="submit" value="Se connecter" />
            </form>
        </div>
