<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Exceptions\standInsertionException;
use App\Exceptions\standUpdateException;

class Stand extends Model {

    protected $table = 'stands';
    protected $guardName = 'web';

    public function user() {
        return $this->belongsTo('App\User', 'company_id');
    }

    public function events() {
        return $this->belongsTo('App\Event', 'event_id');
    }

    public function StoreInStand(Request $request) {
        $stand = Stand::all()->where('code', '=', $request->input('code'));
        if (count($stand) == 0) {
            $this->event_id = $request->input('event_id');
            $this->code = $request->input('code');
            $this->price = $request->input('price');
            $this->company_id = NULL;
            try {
                $this->save();
            } 
            catch (\Exception $e) {
                throw new standInsertionException();
            }
            return true;
        } 
        else
            return false;
    }

    public function ModifyInStandAdmin(Request $request) {
        try {
            if ($this->company_id != NULL)
                return false;
            else {
                $this->code = $request->input('code');
                $this->price = $request->input('price');
                $this->save();
                return true;
            }
        } 
        catch (\Exception $e) {
            throw new standUpdateException();
        }
    }

    public function ModifyInStandCompany($id) {
        try {
            if ($this->company_id != NULL) {
                return false;
            } 
            else {
                $this->company_id = $id;
                $this->save();
                return true;
            }
        } 
        catch (\Exception $e) {
            throw new standUpdateException();
        }
    }

}
