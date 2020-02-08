<?php

// appel Model
require_once('../includes/connect_base.php');
require_once('../includes/constants.php');
require_once('../includes/functions.php');

$titre='Bienvenue sur le site ' . SITE_NAME;

// appel de Vue
require_once('views/index.php');