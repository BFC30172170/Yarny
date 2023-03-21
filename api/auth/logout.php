
<?php
include_once('../../inc/inc_dbconnect.php');
include_once('../../inc/inc_session.php');
include_once('../../lib/auth.php');


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $auth = new Auth();
    $auth->userLogout();    
    header('Location: /fullstacksitetemplate/pages');
}