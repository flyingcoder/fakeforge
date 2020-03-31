<?php

use Illuminate\Support\Facades\Route;

Route::any('hooks/{hook_id}', function ($hook_id) {

    $output = shell_exec("sh sh/deploy/{$hook_id}-script.sh");

    echo "<pre>$output</pre>";

})->where('hook_id', 'backend|frontend')
  ->middleware('web');
