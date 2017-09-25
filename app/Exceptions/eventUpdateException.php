<?php namespace App\Exceptions;

class eventUpdateException extends \Exception {
    public function handle2() {
        return redirect("/")->with('error', "Exception ::: Can't Modify Event");
    }
}
