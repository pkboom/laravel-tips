<?php

Builder::macro('whereLike', function ($attributes, string $searchTerm) {
    $this->where(function (Builder $query) use ($attributes, $searchTerm) {
        foreach (array_wrap($attributes) as $attribute) {
            $query->when(
                str_contains($attribute, '.'),
                function (Builder $query) use ($attribute, $searchTerm) {
                    [$relationName, $relationAttribute] = explode('.', $attribute);

                    $query->orWhereHas($relationName, function (Builder $query) use ($relationAttribute, $searchTerm) {
                        $query->where($relationAttribute, 'LIKE', "%{$searchTerm}%");
                    });
                },
                function (Builder $query) use ($attribute, $searchTerm) {
                    $query->orWhere($attribute, 'LIKE', "%{$searchTerm}%");
                }
            );
        }
    });

    return $this;
});

// use
Post::whereLike(['name', 'text', 'author.name', 'tags.name'], $searchTerm)->get();
