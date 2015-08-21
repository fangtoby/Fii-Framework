<?php
header('Content-Type: text/html; charset=UTF-8');
require '../config.php';
require '../lib/Template/template.php';
include $template->getfile('sys/copy');
