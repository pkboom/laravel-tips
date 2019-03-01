<?php

class UserController extends Controller
{
    public function show()
    {
        return User::whereToken($token)->firstOr(function () {
            return ['message' => 'Sorry, no user found with that token'];
        });
    }
}
