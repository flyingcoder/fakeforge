<?php 

Route::get('/fake-hooks/{hook_id}', function ($hook_id) {
	echo $hook_id;
})->where('hook_id', 'backend|frontend');
