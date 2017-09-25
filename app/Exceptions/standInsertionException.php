<?php
namespace App\Exceptions;

class standInsertionException extends \Exception{
    public function handle3(){
    return redirect("/")->with('error',"Exception ::: Can't Create Stand"); 
   }
}