<?php

class InvoiceController extends Controller
{
    protected $filters = [
        StatusFilter::class,
        ClientFileter::class,
    ];

    protected function queryBuilder($builder)
    {
        return pipe(request())
                ->through($this->filters)
                ->then(function ($request) use ($builder) {
                    return $builder->paginate($request->perPage ?? 25);
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
