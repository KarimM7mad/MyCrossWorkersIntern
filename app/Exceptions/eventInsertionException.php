<?php namespace App\Exceptions;

class eventInsertionException extends \Exception{
    public function handle1(){
        return redirect("/")->with('error',"Exception ::: Can't insert Event");
    }
}