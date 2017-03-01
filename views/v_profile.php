        <nav id="profile">
            <section class="infos">
                <a href="profile.php"><img src="avatar_dark.png" alt="avatar" /></a>
                <span class="pseudo"><?php echo $_SESSION['user']['firstName'] . ' ' . $_SESSION['user']['lastName']; ?></span><br />
                <a href="logout.php">Se déconnecter</a>
            </section>
            <section class="events">
                <h2>Prochain événement</h2>
<?php
    if (!$nextEvent) {
?>
                <p>Vous n'avez pas d'événements à venir.</p>
<?php
    }
    else {
?>

                </p>
<?php
        foreach ($nextEvent as $info) {
?>
                    <?php echo $info; ?><br />
<?php
        }
?>
                </p>

                <a href="#">Voir tous les événements à venir</a>
<?php
    }
?>
                <form id="addEvent">
                    <input type="text" name="name" placeholder="Nom" required />
                    <input type="text" name="place" placeholder="Lieu" required />
                    <div><input type="date" name="startdate" /><input type="time" name="starttime" required /></div>
                    <div><input type="date" name="enddate" /><input type="time" name="endtime" required /></div>
                    <input type="submit" value="Créer" />
                </form>
            </section>
            <section class="Invitations">
                <h2>Dernière invitation<span class="sent">+<?php echo $counts['invits']['sent']; ?></span><span class="received">+<?php echo $counts['invits']['received']; ?></span></h2>
<?php
    if (!$lastInvit) {
?>
                <p>Vous n'avez pas reçu d'invitations dernièrement.</p>
<?php
    }
    else {
?>

                <p>
<?php
        foreach ($lastInvit as $info) {
?>
                    <?php echo $info; ?><br />
<?php
        }
?>
                </p>

                <form action="answer.php" method="POST">
                    <input type="submit" value="Accepter" />
                    <input type="submit" value="Décliner" />
                </form>

                <a href="#">Voir toutes les invitations</a>
<?php
    }
?>
            </section>
            <section class="contacts">
                <h2>Agendas partagés<span class="sent">+<?php echo $counts['contacts']['sent']; ?></span><span class="received">+<?php echo $counts['contacts']['received']; ?></span></h2>
<?php
    if (!$lastRequest) {
?>
                <p>Vous n'avez pas reçu de nouvelle demande de partage.</p>
<?php
    }
    else {
?>
                <p><?php echo $_SESSION['user']['firstName'] . ', ' . $lastRequest['name']; ?> souhaite vous ajouter à la liste de ses connaissances.</p>

                <form action="answer.php" method="POST">
                    <input type="submit" value="Accepter" />
                    <input type="submit" value="Décliner" />
                </form>
                
                <a href="#">Voir toutes les connaissances</a>
<?php
    }
?>
            </section>
        </nav>
