<?php

use Mizi\Env;

Env::loadFile('./.env');

Env::default('TERMINAL_COLOR', true);