<?php

if ($_SESSION['role'] != 'user' && $_SESSION['role'] != 'admin') {
    header('Location: /401');
}