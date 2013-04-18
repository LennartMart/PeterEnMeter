<?php
    /**
     * User: Lennart
     * Date: 16-4-13
     * Time: 13:47
     */
    require_once(__DIR__ . '/../connect.php');
    class Peter
    {
        public $user_id;
        public $naam;

        function __construct()
        {
            $this->db = new ConnectionSettings();
            $this->db->connect();
        }

        public function get($user_id)
        {
            $user =& JFactory::getUser($user_id);
            $this->naam = $user->name;
            $this->user_id = $user->id;
            $this->user_id = $user->id;
        }

        public function get_aanwezigen($event_id)
        {
            $query = "SELECT * from petermeter_attendees where event_id = $event_id;";

            $resultaat = mysql_query($query);
            $aanwezigen = array();
            if($resultaat ==false) return $aanwezigen;
            while ($array_aanwezigen = mysql_fetch_array($resultaat)) {
                $aanwezige = new Peter();
                $aanwezige->vulop($array_aanwezigen);
                $aanwezigen[] = $aanwezige;
            }
            return $aanwezigen;

        }


        public function vulop($resultaat)
        {
            $this->user_id = $resultaat["user_id"];
            /* @var $user JUser */
            $this->naam = $resultaat["naam"];

        }

        public function add($user_id, $naam, $event_id)
        {
            $query = sprintf("
            INSERT INTO
                petermeter_attendees
            SET
              user_id = '%s',
              event_id = '%s',
              naam = '%s'
              ",
                mysql_real_escape_string($user_id),
                mysql_real_escape_string($event_id),
                mysql_real_escape_string($naam)
            );
            return mysql_query($query);
        }

        public function delete($user_id, $event_id)
        {
            if ($this->exists($user_id, $event_id)) {
                $query = sprintf("
              DELETE
              FROM petermeter_attendees
              WHERE user_id = '%s' AND event_id = '%s'
              ",
                    mysql_real_escape_string($user_id),
                    mysql_real_escape_string($event_id)
                );
                return mysql_query($query);
            }

            return true;

        }

        private function exists($user_id, $event_id)
        {
            $query = sprintf("
              SELECT
                user_id
              FROM petermeter_attendees
              WHERE user_id = '%s' AND event_id = '%s'
              ",
                mysql_real_escape_string($user_id),
                mysql_real_escape_string($event_id)
            );
            $result = mysql_query($query);
            $num_rows = mysql_num_rows($result);

            return $num_rows > 0;
        }


    }
