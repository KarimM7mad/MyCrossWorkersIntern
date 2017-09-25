<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\eventInsertionException;
use App\Exceptions\eventUpdateException;

class Event extends Model {

    protected $table = 'events';
    protected $guardName = 'web';

    public function stands() {
        return $this->hasMany('App\Stand');
    }

    public function user() {
        return $this->belongsTo('App\User', 'admin_id');
    }

    public function InsertInDataBase(Request $request, $id = 1) {
        try {
            $this->name = $request->input('name');
            $this->location = $request->input('location');
            $this->date = $request->input('date');
            $this->admin_id = $id;
            $this->save();
        } 
        catch (\Exception $e) {
            throw new eventInsertionException($e->getMessage());
        }
    }

    public function ModifyInDataBase(Request $request) {
        try {
            $this->name = $request->input('name');
            $this->location = $request->input('location');
            $this->date = $request->input('date');
            $this->save();
        } 
        catch (\Exception $e) {
            throw new eventUpdateException($e->getMessage());
        }
    }

}
