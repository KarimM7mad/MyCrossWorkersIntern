<?php
namespace App\Http\Controllers;
use App\Event;

class navigationController extends Controller {
    
    public function index() {
        return view('pages.home');
    }
    
    public function event() {
        $allEvents = Event::all();
        return view('pages.events')->with('allEvents',$allEvents);
    }
    
}
