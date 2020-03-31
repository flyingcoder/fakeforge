<?php

return [
	'repo_provider' => env('REPO_PROVIDER', 'bitbucket'),

	'path' => [
		'backend' => env('BACKEND_PATH', '/var/www/backend'),
		'frontend' => env('FRONTEND_PATH', '/var/www/frontend')
	]
];