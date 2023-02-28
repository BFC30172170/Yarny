
<?php
    session_start();
    echo session_id();
    echo session_name();
    echo ini_get('session.cookie_domain');
?>