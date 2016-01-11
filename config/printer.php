<?php

return array(
	'printerName' => 'ticketprinter',
	'XSLTemplatePath' => storage_path() . '/xslTemplates/ticket_to_fo.xsl',
	'foOutputPath' => storage_path() . '/output/output.fo',
	'pdfOutputPath' => storage_path() . '/output/output.pdf',
	'imagePath' => array(
		'Bug' => storage_path() . '/images/bug.png',
		'Epic' => storage_path() . '/images/Batman.png',
		'MotherShip' => storage_path() . '/images/mothership.png'
	),
	'successMessage' => 'Your Tickets will be printed now',
	'errorMessage' => 'The following tickets could not be printed: '
);