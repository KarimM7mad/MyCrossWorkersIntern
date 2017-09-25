<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Stand;
use App\Event;
use App\Exceptions\standInsertionException;
use App\Exceptions\standUpdateException;

class standController extends Controller {

    protected $guard_name = "web";

    public function __construct() {
        $this->middleware(['auth', 'RoleAndPermission']);
    }

    public function index() {
        return view('error')->with('message', 'Nothing to show here');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $events = Event::all()->where('admin_id', '=', auth()->user()->getAuthIdentifier());
        if (auth()->user()->hasRole('Admin')) {
            return view('StandPages.createStandPage')->with('events', $events);
        } else {
            return redirect('/')->with('message', 'Admin ONLY have access');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, ['code' => 'required', 'price' => 'required']);
        if (Auth::user()->hasRole('Admin') && Auth::user()->hasPermissionTo('createStand')) {
            $stand = new Stand();
            try {
                if ($stand->StoreInStand($request)) {
                    return redirect('/')->with('success', 'Stand Created successfully');
                } 
                else {
                    return redirect('/')->with('error', 'Stand Already exist');
                }
            } 
            catch (\Exception $e) {
                throw new standInsertionException();
            }
        } 
        else {
            return redirect('/')->with('success', 'Admin ONLY have access');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        if (Auth::user()->hasRole('Admin')) {
            $event = Event::find($id);
            $stands = $event->stands()->get();
            return view('StandPages.standList')->with('stands', $stands);
        } else if (Auth::user()->hasRole('normalUser')) {
            $stand = Stand::find($id);
            return view('StandPages.showStandPage')->with('stand', $stand);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $stand = Stand::find($id);
        if (Auth::user()->hasRole('Admin')) {
            $x = $stand->events->admin_id;
            if (Auth::user()->getAuthIdentifier() != $x) {
                return view('pages.myEvents')->with('error', "Can't Edit Stand");
            } else {
                return view('StandPages.ModifyStand')->with('stand', $stand);
            }
        } else if (Auth::user()->hasRole('normalUser')) {
            if ((auth()->user()->getAuthIdentifier() != $stand->company_id) && !(auth()->user()->hasPermissionTo('updateStand'))) {
                return view('pages.myEvents')->with('error', "Can't Edit Stand");
            }
            return view('StandPages.showStandPage')->with('stand', $stand);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $stand = Stand::find($id);
        if (Auth::user()->hasRole('Admin')) {
            try {
                $this->validate($request, ['code' => 'required', 'price' => 'required']);
                if ($stand->ModifyInStandAdmin($request)) {
                    return redirect('/')->with('success', 'Stand Modified Successfully');
                } 
                else {
                    return redirect('/')->with('error', "Stand can't be Modified(error or reserved)");
                }
            } catch (\Exception $exc) {
                throw new standUpdateException();
            }
        } else if (Auth::user()->hasRole('normalUser')) {

            try {
                if ($stand->ModifyInStandCompany(auth()->user()->id)) {
                    return redirect('/')->with('success', 'Stand Reserved Successfully');
                } else {
                    return redirect('/')->with('error', 'Sorry, Stand Already Reserved');
                }
            } catch (\Exception $exc) {
                throw new standUpdateException();
            }
        } else {
            return redirect('/')->with('success', 'ERROR! Unauthorized User');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $stand = Stand::find($id);
        if (auth()->user()->hasPermissionTo('deleteStand') && $stand->company_id == NULL) {
            $stand->delete();
            return redirect('/')->with('success', 'Stand Removed');
        } else {
            return redirect('/')->with('error', "Can't delete Stand(Error or reserved)");
        }
    }

}
