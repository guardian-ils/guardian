#!/usr/bin/env php
<?php

if (isset($_ENV['HHVM']) && $_ENV['HHVM'] == 1 && !in_array('pgsql', get_loaded_extensions())) {
    exec('bash extension.sh');
}