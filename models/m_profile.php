<?php
    // Si l'utilisateur n'est pas connecté, on redirige vers la page de connexion
    if (!isset($_SESSION['user']))
        redirect('login');

    // On détermine à qui appartiennent les infos demandées
    $id = (isset($_GET['user'])) ? $_GET['user'] : $_SESSION['user']['id'];

    $today = new DateTime();
    $weekDay = intval($today->format('N')) - 1;
    $monday = $today->sub(new DateInterval('P' . $weekDay . 'D'))->format('Y-m-d 00:00:00');
    $sunday = $today->add(new DateInterval('P7D'))->format('Y-m-d 00:00:00');

    $query = "SELECT e.name, e.place, DATE_FORMAT(e.start, '%Y-%m-%d') AS startDate, DATE_FORMAT(e.start, '%H:%i') AS startTime, DATE_FORMAT(e.end, '%Y-%m-%d') AS endDate,"
        . " DATE_FORMAT(e.end, '%H:%i') AS endTime FROM events e LEFT JOIN invite i ON i.idEvent = e.id"
        . " WHERE (e.creator = :id OR (i.idGuest = :id AND i.accepted = 1)) AND e.start < :sunday AND e.end > :monday";

    try {
        $stmt = $db->prepare($query);
        $stmt->execute(array(
            ':sunday' => $sunday,
            ':monday' => $monday,
            ':id' => $id
        ));
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    $events = $stmt->fetchAll();
    $stmt->closeCursor();

    $queries = array(
        // Nombre d'invitations et de demandes de contacts non répondues
        "SELECT SUM(CASE idInviter WHEN :id THEN 1-accepted ELSE 0 END) AS sent, SUM(CASE idGuest WHEN :id THEN 1-accepted ELSE 0 END) AS received"
        . " FROM invite UNION ALL"
        . " SELECT SUM(CASE idApplicant WHEN :id THEN 1-accepted ELSE 0 END), SUM(CASE idRecipient WHEN :id THEN 1-accepted ELSE 0 END)"
        . " FROM shareRequests",
        // Infos du prochain événement
        "SELECT e.name, e.start, e.end, e.place FROM events e LEFT JOIN invite i ON i.idEvent = e.id"
        . " WHERE (e.creator = :id OR (i.idGuest = :id AND i.accepted = 1)) AND e.start > NOW() ORDER BY e.start LIMIT 1",
        // Infos dernière invitation reçue
        "SELECT e.name, e.start, e.end, e.place, CONCAT(u.lastName, ' ', u.firstName) AS creator FROM invite i INNER JOIN events e ON e.id = i.idEvent"
        . " INNER JOIN users u ON u.id = e.creator WHERE i.idGuest = :id AND i.accepted = 0 AND e.start > NOW() ORDER BY dateInvitation DESC LIMIT 1",
        // Infos dernière demande de partage des agendas
        "SELECT CONCAT(u.firstName, ' ', u.lastName) AS name FROM users u INNER JOIN shareRequests sr ON sr.idApplicant = u.id"
        . " WHERE sr.idRecipient = :id AND accepted = 0 ORDER BY dateRequest DESC LIMIT 1"
    );

    $results = array();

    // On execute les quatre requêtes à l'aide d'une boucle, puisque l'argument est le même
    try {
        foreach ($queries as $i => $query) {
            $stmt = $db->prepare($query);
            $stmt->execute(array(':id' => $id));
            $results[$i] = $stmt->fetchAll();
            $stmt->closeCursor();
        }
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    // Les différents résultats sont enregistrés dans des variables plus éloquentes
    $counts['invits'] = $results[0][0];
    $counts['contacts'] = $results[0][1];
    $nextEvent = isset($results[1][0]) ? $results[1][0] : NULL;
    $lastInvit = isset($results[2][0]) ? $results[2][0] : NULL;
    $lastRequest = isset($results[3][0]) ? $results[3][0] : NULL;

    // éléments à afficher
    $title = "Agenda - Profil";
    $views[] = 'profile';
    $views[] = 'calendar';
    $scripts[] = 'ajax';