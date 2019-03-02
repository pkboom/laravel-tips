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

    const PER_PAGE = 25;

    protected $filters = [
        StatusFilter::class,
        ClientFileter::class,
    ];

    public function index2()
    {
        return view('invoices.index', [
            'invoices' => $this->queryBuilder(Invoice::query()),
        ]);
    }

    protected function queryBuilder($builder)
    {
        return app(Pipeline::class)->send(request())
                ->through($this->filters)
                ->then(function ($request) use ($builder) {
                    return $builder->paginate($request->perPage ?? 25);
                });
    }

    protected $filters2 = [
        StatusFilter::class,
        ClientFileter::class,
    ];

    public function index3()
    {
        return view('invoices.index', [
            'invoices' => $this->queryBuilder(Invoice::query()),
        ]);
    }

    protected function queryBuilder3($builder)
    {
        return app(Pipeline::class)->send($builder)
            ->through($this->filters2)
            ->then(function ($builder) {
                return $builder->paginate(request('perPage') ?? 25);
            });
    }
}

class StatusFilter
{
    public function handle($request, $next)
    {
        return $next($request)->when($request->status, function ($query) use ($request) {
            return $query->where('status', $request->status);
        });
    }
}

class ClientFilter
{
    public function handle($request, $next)
    {
        return $next($request)->when($request->client, function ($query) use ($request) {
            return $query->where('client', $request->client);
        });
    }
}

class StatusFilter2
{
    public function handle($builder, $next)
    {
        return $next($builder)->when(request('status'), function ($query) {
            return $query->where('status', request('status'));
        });
    }
}

class ClientFilter2
{
    public function handle($builder, $next)
    {
        return $next($builder)->when(request('client'), function ($query) {
            return $query->where('client', request('client'));
        });
    }
}
