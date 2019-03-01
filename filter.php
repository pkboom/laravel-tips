<?php

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoices.index', [
            'invoices' => $this->invoices(),
        ]);
    }

    private function invoices()
    {
        $invoice = Invoice::query();

        if (request('status')) {
            $invoice->where('status', request('status'));
        }

        if (request('client')) {
            $invoice->where('client', request('client'));
        }

        return $invoice->paginate(request('perPage', 25));
    }
}
