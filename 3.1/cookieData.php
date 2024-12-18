<?php
if (isset($_COOKIE['login']) && isset($_COOKIE['time'])) {
    echo "Hello, {$_COOKIE['login']}<br/>";
    echo "Час входу: {$_COOKIE['time']}<br/>";
}