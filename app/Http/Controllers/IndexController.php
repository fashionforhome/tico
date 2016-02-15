<?php

namespace App\Http\Controllers;

use App\Model\Adapter\JiraAdapter;
use App\Model\Project;
use App\Model\Ticket;
use App\Model\TicketPrinter;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;
use Session;

class IndexController extends Controller
{

	/**
	 *
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		/** @var Project $projects */
		$projects = Project::lists('name', 'id');

		return view('pages.index')->with('projects', $projects);
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function confirmation(Request $request)
	{
		$ticketIds = array_filter(array_unique(preg_split('/(\s|,)/', $request['tickets'])), 'is_numeric');

		if (empty($ticketIds)) {
			return redirect('/');
		}

		$projectId = $request['project'];

		// no leading zeros
		$ticketIds = array_map(function ($value) {
			return ltrim($value, '0 ');
		}, $ticketIds);


		/** @var \Illuminate\Database\Eloquent\Collection $doubledTickets */
		$doubledTickets = Ticket::whereIn('id', $ticketIds)
			->where('project_id', $projectId)
			->get();

		// in case there are no doubled tickets we will directly print all tickets
		if ($doubledTickets->isEmpty()) {
			/** @var Request $request */
			$request = Request::create('/printAction', 'POST', ['tickets' => implode(',', $this->buildTicketNames($ticketIds, $projectId))]);

			return $this->printAction($request);

		} else {
			// to reprint doubled Tickets we need a confirmation
			$freshTicketIds = array_diff($ticketIds, $doubledTickets->lists('id')->toArray());
			$freshTicketIds = $this->buildTicketNames($freshTicketIds, $projectId);

			return view('pages.confirmation')
				->with('doubledTickets', $doubledTickets)
				->with('freshTicketIds', implode(',', $freshTicketIds))
				->with('project', $projectId);
		}
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function printAction(Request $request)
	{
		if (empty($request['tickets'])) {
			return redirect('/');
		}

		$freshTickets = explode(',', $request['tickets']);

		foreach ($request->all() as $key => $value) {
			if (preg_match('/^doubledTicket_[\d]*/', $key)) {
				$freshTickets[] = $value;
			}
		}

		$freshTickets = array_filter($freshTickets);

		$jiraAdapter = new JiraAdapter();
		$result      = $jiraAdapter->getIssuesByKeys($freshTickets);

		/** @var TicketPrinter $ticketPrinter */
		$ticketPrinter = new TicketPrinter($result['tickets']);
		$ticketPrinter->printTickets();

		if (empty($result['errors']) == false) {
			Session::flash('error_message', $this->buildErrorString($result['errors']));
		}

		Session::flash('flash_message', config('printer.successMessage'));

		return redirect('/');
	}


	/**
	 * @param array $ticketIds
	 * @param $projectId
	 * @return array
	 */
	private function buildTicketNames($ticketIds, $projectId)
	{
		$project     = Project::find($projectId);
		$projectName = $project->name;
		$result      = array();

		foreach ($ticketIds as $ticketId) {
			$result[] = $projectName . '-' . $ticketId;
			$this->saveNewTicket($ticketId, $project->id);
		}

		return $result;
	}

	/**
	 * @todo: this should be done by Javascript
	 * @param $errors
	 * @return mixed|string
	 */
	private function buildErrorString($errors)
	{
		$errorString = '';

		foreach ($errors as $error) {
			$errorString .= $error . ', ';
		}

		return $errorString;
	}

	/**
	 * @param $ticketId
	 * @param $projectId
	 */
	private function saveNewTicket($ticketId, $projectId)
	{
		$ticket             = new Ticket;
		$ticket->id         = $ticketId;
		$ticket->project_id = $projectId;
		$ticket->save();
	}
} 