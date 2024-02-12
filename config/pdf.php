<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'margin_left'           => 5,
    'margin_right'          => 5,
    'margin_top'            => 5,
    'margin_bottom'         => 5,
    'margin_header'         => 5,
    'margin_footer'         => 5,
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => storage_path('tmp/'),
	'pdf_a'                 => false,
	'pdf_a_auto'            => false,
	'icc_profile_path'      => '',
	'font_path' => storage_path('fonts/'),
	'font_data' => [
		'iran' => [
			'R'  => 'light.ttf',    // regular font
			'B'  => 'iran.ttf',    // regular font
			'I'  => 'light.ttf',    // regular font
			'BI'  => 'iran.ttf',    // regular font
			'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
			'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
		]
		// ...add as many as you want.
	]
];
