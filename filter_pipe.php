<?php

class InvoiceController extends Controller
{
    public function indexSimple()
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

    // ----------------------------------------------------------------------

    const PER_PAGE = 25;

    protected $filters = [
        StatusFilter::class,
        ClientFileter::class,
    ];

    public function index()
    {
        return view('invoices.index', [
            'invoices' => $this->queryBuilder(Invoice::query()),
        ]);
    }

    protected function queryBuilder($builder)
    {
        return app(Pipeline::class)
                ->send(request())
                ->through($this->filters)
                ->then(function ($request) use ($builder) {
                    return $builder->paginate($request->perPage ?? 25);
                });
    }

    protected function queryBuilder($builder)
    {
        return pipe(request())
                ->through($this->filters)
                ->then(function ($request) use ($builder) {
                    return $builder->paginate($request->perPage ?? 25);
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
/**
 * @param mixed $passable
 * @return \Illuminate\Pipeline\Pipeline
 */
function pipe($passable)
{
    return app(Pipeline::class)->send($passable);
}
