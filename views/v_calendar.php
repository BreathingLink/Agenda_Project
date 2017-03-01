<?php $scripts[] = 'events'; ?>

        <div id="calendar">
            <ul class="hours">
                <li></li>
<?php
    for ($i = 0; $i < 24; $i++) {
?>
                <li><?php printf('%02d:00', $i); ?></li>
<?php
    }
?>
            </ul>
            <ul class="days">
<?php
    $early = new DateTime(substr($monday, 0, 10));
    $late = new DateTime(substr($monday, 0, 10) . ' 23:59:59');
    $oneDay = new DateInterval('P1D');
    $days = ['Mon', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

    for ($i = 0; $i < 7; $i++) {
?>
                <li>
                    <header><?php echo $days[$i]; ?></header>
<?php
        foreach ($events as $event) {
            if ($event['startDate'] <= $late->format('Y-m-d') && $event['endDate'] >= $early->format('Y-m-d')) {
?>
                    <article class="event" data-start="<?php echo (substr($event['startDate'], 8) == $early->format('d')) ? $event['startTime'] : '00:00'; ?>" data-end="<?php echo (substr($event['endDate'], 8) == $late->format('d')) ? $event['endTime'] : '23:59'; ?>">
                        <h3><?php echo $event['name']; ?></h3>
                        <p>
                            <span><?php echo $event['place']; ?></span><br />
                            <span><?php printf('%02d:00', $event['startTime']); ?></span> - <span><?php printf('%02d:00', $event['endTime']); ?></span>
                        </p>
                    </article>
<?php
            }
        }
?>
                </li>
<?php
        $early->add($oneDay);
        $late->add($oneDay);
    }
?>
            </ul>
        </div>
