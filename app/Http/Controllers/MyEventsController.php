<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Stand;
use App\Exceptions\eventInsertionException;
use App\Exceptions\eventUpdateException;

class myEventsController extends Controller {

    public function __construct() {
        $this->middleware(['auth', 'RoleAndPermission']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (auth()->user()->hasRole('Admin')) {
            $x = auth()->user()->getAuthIdentifier();
            $allEvents = Event::all()->where('admin_id', '=', $x);
            return view('pages.myEvents')->with('allEvents', $allEvents);
        } else
            return redirect('/')->with('error', "Unauthorized access");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        if (auth()->user()->hasRole('Admin') && auth()->user()->hasPermissionTo('createEvent'))
            return view('pages.eventForm');
        else
            return redirect('/')->with('error', "Unauthorized access");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, ['name' => 'required', 'location' => 'required', 'date' => 'required']);
        if (auth()->user()->hasRole('Admin')) {
            $event = new Event();
            try {
                $event->InsertInDataBase($request,auth()->user()->getAuthIdentifier());
            } catch (\Exception $e) {
                throw new eventInsertionException($e->getMessage());
            }
            return redirect('/myEvents')->with('success', "Event Created Sucessfully");
        } 
        else
            return redirect('/')->with('error', "Can't create Event");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if (!auth()->user()->hasPermissionTo('reserveStand'))
            return redirect("/")->with('error', "Unauthorized access");
        if (auth()->user()->hasRole('normalUser')) {
            $stand = Stand::all()->where('event_id', '=', $id);
            return view('StandPages.reserveStandPage')->with('stand', $stand);
        } 
        else {
            return view('pages.eventEditForm')->with('event', Event::find($id));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $event = Event::find($id);
        if ((auth()->user()->getAuthIdentifier() != $event->admin_id) && !auth()->user()->hasPermissionTo('updateEvent'))
            return redirect('/')->with('error', "Admins Only");
        return view('pages.eventEditForm')->with('event', $event);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        if (auth()->user()->hasPermissionTo('updateEvent')) {
            $event = Event::find($id);
            try {
                $event->ModifyInDataBase($request);
            } 
            catch (\Exception $e) {
                throw new eventUpdateException();
            }
            return redirect('/myEvents')->with('success', 'Event Updated');
        } 
        else
            return redirect('/')->with('error', "Can't Update Event");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $event = Event::find($id);
        if (!auth()->user()->id == $event->admin_id) {
            return redirect('/myEvents')->with('error', "can't delete");
        }
        if (auth()->user()->hasPermissionTo('deleteEvent')) {
            $event->delete();
            return redirect('/myEvents')->with('success', 'Event Removed');
        } else
            return redirect('/')->with('error', "Can't delete Event");
    }

}
