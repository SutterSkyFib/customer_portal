<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketReplyRequest;
use App\Http\Requests\TicketRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Factory;
use Illuminate\View\View;
use SonarSoftware\CustomerPortalFramework\Controllers\AccountTicketController;
use SonarSoftware\CustomerPortalFramework\Exceptions\ApiException;
use SonarSoftware\CustomerPortalFramework\Models\Ticket;
use SonarSoftware\CustomerPortalFramework\Models\Contact;

class TicketController extends Controller
{
    /**
     * Return ticket listing
     */
    public function index(): Factory|View
    {
        $tickets = $this->getTickets();
        $user = get_user();
        $contact = $this->getContact();

        return view('pages.tickets.index', compact('tickets', 'user', 'contact'));
    }

    /**
     * Show an individual ticket
     */
    public function show($id): Factory|View|RedirectResponse
    {
        //We need to ensure that this ticket belongs to this user
        $tickets = $this->getTickets();
        foreach ($tickets as $ticket) {
            try {
                if ($ticket->getTicketID() == $id) {
                    $user = get_user();
                    $contact = $this->getContact();
                    
                    $accountTicketController = new AccountTicketController();
                    $replies = $accountTicketController->getReplies($ticket, 1);
                    /*
                     * Clear the cache here, because you may see a ticket with ISP responses but the list may not show
                     * it yet.
                     */
                    $this->clearTicketCache();

                    return view('pages.tickets.show', compact('replies', 'ticket', 'user', 'contact'));
                }
            } catch (ApiException $e) {
                Log::error($e->getMessage());
                $this->clearTicketCache();

                return redirect()
                    ->action([TicketController::class, 'index'])
                    ->withErrors(utrans('errors.ticketNotFound'));
            }
        }

        return redirect()->action([TicketController::class, 'index'])->withErrors(utrans('errors.invalidTicketID'));
    }

    /**
     * Get contact information for the current user
     */
    protected function getContact(): Contact
    {
        if (! Cache::tags('profile.details')->has(get_user()->contact_id)) {
            $contactController = new ContactController();
            $contact = $contactController->getContact(get_user()->contact_id, get_user()->account_id);
            Cache::tags('profile.details')->put(get_user()->contact_id, $contact, Carbon::now()->addMinutes(10));
        }

        return Cache::tags('profile.details')->get(get_user()->contact_id);
    }

    /**
     * Show ticket creation page
     */
    public function create(): Factory|View|RedirectResponse
    {
        $emailAddress = get_user()->email_address;
        $user = get_user();
        $contact = $this->getContact();
        
        if ($emailAddress == null) {
            return redirect()
                ->action([ProfileController::class, 'show'])
                ->withErrors(utrans('errors.mustSetEmailAddress'));
        }

        return view('pages.tickets.create', compact('user', 'contact'));
    }

    /**
    * Create a new ticket
    */
    public function store(TicketRequest $request): RedirectResponse
    {
        try {
            // Create a new ticket instance with the input data
            $ticket = new Ticket([
                'account_id' => get_user()->account_id,
                'email_address' => get_user()->email_address,
                'subject' => $request->input('subject'),
                'description' => $request->input('description'),
                'ticket_group_id' => config('customer_portal.ticket_group_id'), 
                'priority' => config('customer_portal.ticket_priority'),
                'inbound_email_account_id' => config('customer_portal.inbound_email_account_id'),
            ]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(utrans('errors.failedToCreateTicket'))->withInput();
        }

        $accountTicketController = new AccountTicketController();
        try {
            // Create the ticket using the account ticket controller
            $accountTicketController->createTicket($ticket, get_user()->contact_name, get_user()->email_address);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors(utrans('errors.failedToCreateTicket'))->withInput();
        }

        $this->clearTicketCache();

        return redirect()
            ->action([TicketController::class, 'index'])
            ->with('success', utrans('tickets.ticketCreated'));
    }
     
    /**
     * Post a reply to a ticket
     */
    public function postReply($ticketID, TicketReplyRequest $request): RedirectResponse
    {
        $accountTicketController = new AccountTicketController();
        $tickets = $this->getTickets();
        foreach ($tickets as $ticket) {
            if ($ticket->getTicketID() == $ticketID) {
                try {
                    $accountTicketController->postReply(
                        $ticket,
                        $request->input('reply'),
                        get_user()->contact_name,
                        get_user()->email_address
                    );

                    return redirect()->back()->with('success', utrans('tickets.replyPosted'));
                } catch (Exception $e) {
                    return redirect()->back()->withErrors(utrans('errors.failedToPostReply'));
                }
            }
        }

        return redirect()->back()->withErrors(utrans('errors.invalidTicketID'));
    }

    /**
     * Clear the ticket cache
     */
    private function clearTicketCache(): void
    {
        Cache::tags('tickets')->forget(get_user()->account_id);
    }

    /**
     * Get tickets, cache them if currently uncached, otherwise return from cache
     */
    private function getTickets(): mixed
    {
        if (! Cache::tags('tickets')->has(get_user()->account_id)) {
            $accountTicketController = new AccountTicketController();
            $tickets = $accountTicketController->getTickets(get_user()->account_id);
            Cache::tags('tickets')->put(get_user()->account_id, $tickets, Carbon::now()->addMinutes(10));
        }

        return Cache::tags('tickets')->get(get_user()->account_id);
    }
}
