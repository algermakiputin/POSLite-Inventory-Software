<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

// file: application/libraries/Env.php
class Env
{
    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::create(FCPATH);
        $dotenv->load();
    }
    
}
