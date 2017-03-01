<?php header('Content-type: text/javascript'); ?>
var results = {
<?php

    if (!isset($_GET['name']) || !isset($_GET['place']) || !isset($_GET['startdate']) || !isset($_GET['starttime'])
        || !isset($_GET['enddate']) || !isset($_GET['endtime']) || !isset($_GET['callback'])) {
?>
    "done" : "false",
    "error" : "Les données reçues n'étaient pas complètes"
};
<?php
        exit;
    }

    session_start();
    require_once('../includes/inc_dbConnection.php');

    try {
        $stmt = $db->prepare('INSERT INTO events (name, place, start, end, creator) VALUES (:name, :place, :start, :end, :creator)');
        $stmt->execute(array(
            ':name' => $_GET['name'],
            ':place' => $_GET['place'],
            ':start' => $_GET['startdate'] . ' ' . $_GET['starttime'],
            ':end' => $_GET['enddate'] . ' ' . $_GET['endtime'],
            ':creator' => $_SESSION['user']['id']
        ));
    }
    catch (PDOException $e) {
?>
    "done" : "false",
    "error" : "<?php die($e->getMessage()); ?>"
};
<?php
    }
?>
    "done" : "true",
    "name" : "<?php echo $_GET['name']; ?>",
    "place" : "<?php echo $_GET['place']; ?>",
    "start" : ["<?php echo $_GET['startdate'] . '", "' . $_GET['starttime']; ?>"],
    "end" : ["<?php echo $_GET['enddate'] . '", "' . $_GET['endtime']; ?>"]
};

<?php echo $_GET['callback']; ?>(results);