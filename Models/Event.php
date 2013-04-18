<?php
/**
 * User: Lennart
 * Date: 16-4-13
 * Time: 13:48
 */

    require_once(__DIR__ . '/../connect.php');
    require_once(__DIR__ . '/Peter.php');
class Event{
    public $event_id;
    public $event_datum;
    public $commentaar;
    public $lijst_peters;

    function __construct()
    {
        $this->db = new ConnectionSettings();
        $this->db->connect();
    }

    /**
     * Private functie om event op te halen.
     * @param event_id
     */
    private function get($event_id)
    {
        $query = sprintf("SELECT * FROM petermeter_events WHERE id= '%s';", $event_id);
        $resultaat = mysql_query($query);
        $this->vulop($resultaat);
    }

    public function vulop($resultaat)
    {
        $this->commentaar = $resultaat["commentaar"];
        $this->event_datum = $resultaat["event_datum"];
        $this->event_id = $resultaat["id"];

        $peter = new Peter();
        $this->lijst_peters = $peter->get_aanwezigen($this->event_id);
    }

    public function add($event_datum, $commentaar)
    {
        $query = sprintf("
            INSERT INTO
                petermeter_events
            SET
              event_datum = '%s',
              commentaar = '%s'
              ",
            mysql_real_escape_string($event_datum),
            mysql_real_escape_string($commentaar)
        );
        return mysql_query($query);

    }

    public function delete($event_id)
    {
        if ($this->exists( $event_id)) {
            $query = sprintf("
              DELETE
              FROM petermeter_events
              WHERE id = '%s'
              ",
                mysql_real_escape_string($event_id)
            );
            return mysql_query($query);
        }

        return true;

    }

    private function exists($event_id)
    {
        $query = sprintf("
              SELECT
                id
              FROM petermeter_events
              WHERE id = '%s'
              ",
            mysql_real_escape_string($event_id)
        );
        $result = mysql_query($query);
        $num_rows = mysql_num_rows($result);

        return $num_rows > 0;
    }

    public function get_all_from_now($page, $page_limit)
    {
        $query = "
              SELECT
                *
              FROM petermeter_events
              WHERE event_datum >= NOW()
              ORDER BY event_datum;
              ";
        $resultaat = mysql_query($query);
        $events = array();
        if($resultaat ==false) return $events;
        while ($array_events = mysql_fetch_array($resultaat)) {
            $event = new Event();
            $event->vulop($array_events);
            $events[] = $event;
        }
        return $events;
    }




}