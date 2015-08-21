<?php
session_start();
require  dirname(__FILE__) . '/captcha.class.php';
$captcha = new Captcha();
$_SESSION['captcha'] = $captcha->getCode();
$captcha->doImg();
