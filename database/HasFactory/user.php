<?php

use App\Model\User;

$user = User::factory()->count(5)->make();
