<?php

class PostController extends Controller
{
    public function show(Post $post)
    {
        return tap(User::admins()->get(), 'logger');
    }
}
