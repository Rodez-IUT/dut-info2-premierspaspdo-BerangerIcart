<?php

function get($name) {
    return isset($_GET[$name]) ? $_GET[$name] : null;
}