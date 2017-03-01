<?php
    // La liste des vues et scripts de la page. Ils seront implémentés par le modèle
    // Les variables title et redirect prennent leurs valeurs par défaut
    $views = array();
    $scripts = array();
    $errors = array();
    $title = 'Agenda';

    // On crée une fonction de redirection
    function redirect($page, $error = '') {
        if ($error != '')
            $_SESSION['errors'][] = $error;

        header('Location: ' . $page . '.php');
        exit;
    }

    session_start();

    $defaultPage = (isset($_SESSION['user'])) ? 'profile' : 'login';
    $file = 'models/m_' . ((isset($_GET['m'])) ? $_GET['m'] : $defaultPage) . '.php';

    if (file_exists($file) && is_readable($file)) {
        require_once('includes/inc_dbConnection.php');
        require_once($file);
        $db = NULL;
    }
    else
        require_once('admin/404.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="common.css" />
<?php
    // A chaque vue sa feuille de style, on les inclue
    foreach ($views as $view) {
?>
        <link rel="stylesheet" href="<?php echo $view; ?>.css" />
<?php
    }

    //require_once('views/v_debug.php'); // Affiche les variables GET, POST, SESSION et COOKIE.
?>
    </head>

    <body>
<?php
    // On appelle chaque vue
    foreach ($views as $view)
        require_once('./views/v_' . $view . '.php');

    // On inclue chaque script
    foreach ($scripts as $script) {
?>
        <script type="text/javascript" src="<?php echo $script; ?>.js"></script>
<?php
    }

    unset($_SESSION['errors']);
    unset($_SESSION['post']);
?>
    </body>
</html>