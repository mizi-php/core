<?php

/** Se a requisição foi feita via linha de comando */
define('IS_TERMINAL', !isset($_SERVER['HTTP_HOST']));