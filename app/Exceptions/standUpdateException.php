<?php
namespace App\Exceptions;

class standUpdateException extends \Exception{
    public function handle4(){
       return redirect('/')->with('error',"Exception ::: can't Modify Stand");
   }
}