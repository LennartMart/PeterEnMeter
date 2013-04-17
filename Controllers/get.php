<?php
    require_once(__DIR__ . '/../Models/Event.php');
    require_once(__DIR__ . '/../Models/Peter.php');
    if (isset($_GET['action']) && !empty($_GET['action'])) {
        //Get the logged in user
        $user = JFactory::getUser();

        $action = $_GET['action'];
        switch ($action) {
            case 'viewEvents' :
                $event = new Event();
                $events = $event->get_all_from_now(1, 10);
                ob_start(); ?>
                <?php for ($i = 0, $n = count($events); $i <= $n; $i++) {
                 $event = $events[$i];
                 echo $event->event_datum;
                ?>

                <div id='<?php $events[$i]->event_id ?>'>
                    <p>Datum: <?php $events[$i]->event_datum ?></p>

                    <p>Commentaar:  <?php $events[$i]->commentaar ?> </p>

                    <p>Peters / Meters aanwezig:
                    <ul>
                        <?php $aanwezig = false;
                            for ($j = 0, $o = count($events[$i]->lijst_peters); $j < $o; $j++) {
                                if($events[$i]->lijst_peters[$j]->user_id == $user->id) $aanwezig = true;
                                ?>

                            <li><?php $events[$i]->lijst_peters[$j]->naam ?></li>
                        <?php } ?>
                    </ul>
                    </p>
                    <p>
                        <?php if(!$aanwezig){
                                ?>
                            <button class="btn btn-large btn-primary" onclick="addAttendee(<?php $events[$i]->event_id ?>)">Aanwezig!</button>
                        <?php } else { ?>
                            <button class="btn btn-large btn-primary" onclick="DeleteAttendee(<?php $events[$i]->event_id ?>)">Afwezig</button>
                        <?php } ?>
                    </p>
                </div>
            <?php
            }
                echo ob_get_clean();
        }

    }