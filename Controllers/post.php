<?php
/**
 * User: Lennart
 * Date: 16-4-13
 * Time: 14:16
 */
    require_once(__DIR__ . '/../Models/Event.php');
    require_once(__DIR__ . '/../Models/Peter.php');
    if(isset($_POST['action']) && !empty($_POST['action']))
    {

        $action = $_POST['action'];
        switch($action) {
            case 'addAttendee' :
                $data = array();
                //To Do: Check if current logged user = bclandegem user
                if(isset($_POST['event_id']) && !empty($_POST['event_id']))
                {
                    $user = JFactory::getUser();
                    $peter = new Peter();
                    $resultaat = $peter->add($user->id,$_POST['event_id']);
                    if($resultaat == true)
                    {
                        $peter->get($user->id);
                        $data["attendee_name"] = $peter->naam;
                        $data["attendee_id"] = $peter->user_id;
                        $data["success"] = true;

                    }
                    else
                    {
                        $data["success"] = false;
                        $data["error"] = mysql_error();
                    }
                }
                else
                {
                    $data["success"] = false;
                    $data["error"] = mysql_error();
                }

                echo json_encode($data);
                break;
            case 'deleteAttendee' :
                $data = array();
                //To Do: Check if current logged user = bclandegem user
                //OR SuperUser
                if(isset($_POST['event_id']) && !empty($_POST['event_id']))
                {
                    $user = JFactory::getUser();
                    $peter = new Peter();
                    $resultaat = $peter->delete($user->id,$_POST['event_id'] );
                    if($resultaat == true)
                    {
                        $data["success"] = true;
                        $data["attendee_id"] = $user->id;
                    }
                    else
                    {
                        $data["success"] = false;
                    }
                }
                else
                {
                    $data["success"] = false;
                }

                echo json_encode($data);
                break;
            case 'addEvent' :
                //Check if user = superuser
                $data = array();
                if(isset($_POST['event_date']) && !empty($_POST['event_date']))
                {
                    $comment = isset($_POST['comment']) && !empty($_POST['comment'])?$_POST['comment'] : '';
                    $event = new Event();
                    $resultaat = $event->add($_POST['event_date'], $comment );

                    if($resultaat == true)
                    {
                        $data["success"] = true;
                    }
                    else
                    {
                        $data["success"] = false;
                        $data["error"]  = "Error while inserting in Db. Detail: ".mysql_error();
                    }
                }
                else
                {
                    $data["success"] = false;
                    $data["error"]  = "No event date was found!";
                }
                echo json_encode($data);
                break;
            case 'deleteEvent' :
                //Check if user = superuser
                $data = array();
                if(isset($_POST['event_id']) && !empty($_POST['event_id']))
                {
                    $event = new Event();
                    $resultaat = $event->delete($_POST['event_id']);
                    if($resultaat == true)
                    {
                        $data["success"] = true;
                    }
                    else
                    {
                        $data["success"] = false;
                        $data["error"]  = "Could not delete event";
                    }
                }
                else
                {
                    $data["success"] = false;
                    $data["error"]  = "There wasn't any event id!";
                }
                echo json_encode($data);
                break;
            case 'updateEvent' : blah();break;
        }
    }

