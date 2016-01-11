<?php

namespace App\Model\Converter;

use Log;

class FoToPDFTicketConverter
{
	/**
	 * Convert Ticket to pdf using apache FOP
	 */
	public function convertTicket()
	{
		try {
			exec('sh ' . env('FOP_PATH') . ' ' . config('printer.foOutputPath') . ' ' . config('printer.pdfOutputPath'));
		} catch (\Exception $e) {
			Log::error($e->getMessage());
		}
	}
}