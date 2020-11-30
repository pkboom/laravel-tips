<?php

class SomeController
{
    public function index()
    {
        if ($someCondition) {
            return redirect('someplace');
        }
    }

    public function someNonTopLevelMethod()
    {
        if ($someCondition) {
            abort(redirect('someplace'));
            // Also works with the "back" helper: abort(back(' someplace'));
        }
    }

    // This is from a real project.
    // It's a method on the controller that is called
    // by the controller's 'store method:
    protected function getDonation()
    {
        return tap(session('donation-data'), function ($data) {
            if (is_null($data)) {
                abort(back()->withErrors("Missing donation")->withInput());
            }
        });
    }
}
