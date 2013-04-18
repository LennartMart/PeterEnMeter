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
                <?php for ($i = 0, $n = count($events); $i < $n; $i++) {
                 $event = $events[$i];
                ?>

                <div class="Event" style="overflow: hidden;" id='<?php echo $event->event_id ?>'>
                <div style="float: left; width: 50%">
                    <h3><?php echo $event->event_datum ?>
                    </h3>

                    <p><?php echo $event->commentaar ?> </p>

                    <p>Peters / Meters aanwezig:
                    <ul id='attendeeList'>
                        <?php $aanwezig = false;
                            $aantal = count($event->lijst_peters);
                            $aantalPercent = ($aantal / 8) *100;
                            for ($j = 0, $o = count($event->lijst_peters); $j < $o; $j++) {
                                $peters = $event->lijst_peters;
                                $peter = $peters[$j];
                                if($peter->user_id == $user->id) $aanwezig = true;
                                ?>

                            <li id='<?php echo $peter->user_id ?>'><?php echo $peter->naam ?></li>
                        <?php } ?>
                    </ul>
                    </p>
                    <?php if($user->id != null){ ?>
                    <p id="btnsAttendee">
                        <?php if(!$aanwezig){
                                ?>
                            <button id='btnAanwezig' class="btn btn-large btn btn-success" onclick="addAttendee(<?php echo $event->event_id ?>)" >Aanwezig!</button>
                            <button id='btnAfwezig' class="btn btn-large btn-danger" onclick="deleteAttendee(<?php echo $event->event_id ?>)" disabled>Afwezig</button>
                        <?php } else { ?>
                            <button id='btnAanwezig' class="btn btn-large btn btn-success" onclick="addAttendee(<?php echo $event->event_id ?>)"disabled >Aanwezig!</button>
                            <button id='btnAfwezig' class="btn btn-large btn-danger" onclick="deleteAttendee(<?php echo $event->event_id ?>)" >Afwezig</button>
                        <?php } ?>
                    </p>
                    <?php } ?>
                    </div>
                <div style="float: left;">
                    <h4>Aantal peters en meters:</h4>
                    <label id="requiredAttendees" ><?php echo $aantal ?> van de vereiste 8</label><div class="progress progress-success">
                        <div class="bar" style="width: <?php echo $aantalPercent ?>%"></div>
                    </div>
                </div>
                </div>

            <?php
            }
                echo ob_get_clean();
                break;
        }

    }