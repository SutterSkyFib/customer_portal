<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;
use SonarSoftware\CustomerPortalFramework\Models\Contact;

class ContractController extends Controller
{
    private $apiController;

    public function __construct()
    {
        $this->apiController = new \SonarSoftware\CustomerPortalFramework\Controllers\ContractController();
    }

    public function index(): View
    {
        /**
         * This is not cached, as signing a contract outside the portal cannot be detected, and so would create invalid information display here.
         */
        $contracts = $this->apiController->getContracts(get_user()->account_id, 1);
        $user = get_user();
        $contact = $this->getContact();

        return view('pages.contracts.index', compact('contracts', 'user', 'contact'));
    }

    public function downloadContractPdf($id): Response
    {
        $base64 = $this->apiController->getSignedContractAsBase64(get_user()->account_id, $id);

        return response()->make(base64_decode($base64), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename=contract.pdf',
        ]);
    }

    /**
     * Get contact information for the current user
     */
    private function getContact(): Contact
    {
        if (! Cache::tags('profile.details')->has(get_user()->contact_id)) {
            $contactController = new ContactController();
            $contact = $contactController->getContact(get_user()->contact_id, get_user()->account_id);
            Cache::tags('profile.details')->put(get_user()->contact_id, $contact, Carbon::now()->addMinutes(10));
        }

        return Cache::tags('profile.details')->get(get_user()->contact_id);
    }
}
