<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Event;
use App\Http\Controllers\myEventsController;
use IllumUpdateException;

class updateEventTest extends TestCase {

    use DatabaseTransactions;

    //normal update
    public function test0() {
        $data = [
            'name' => 'Ketab Event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $reqq = new Request($data);
        $event = new Event();
        $event->InsertInDataBase($reqq);
        $eventData = [
            'name' => 'Ketab Event',
            'location' => 'City Center , NeXis',
            'date' => '2017-09-06',
            'admin_id' => 1
        ];
        $req = new Request($eventData);
        $evt = Event::all()->where('name', '=', 'Ketab Event')->first();
        $evt->ModifyInDataBase($req);
        $this->assertDatabaseHas('events', $eventData);
    }

    //update by null for unnullable attribute and test Exception Exception Handling
    public function test1() {
        $data = [
            'name' => 'Ketab Event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $reqq = new Request($data);
        $event = new Event();
        $event->InsertInDataBase($reqq);


        $data2 = [
            'name' => null,
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $req2 = new Request($data2);
        $evt = Event::all()->where('name', '=', 'Ketab Event')->first();
        $this->expectException(eventUpdateException::class);
        $evt->ModifyInDataBase($req2);
    }

    //2 Test Protection against SQL injection 
    public function test2() {
        $data = [
            'name' => 'Ketab Event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $reqq = new Request($data);
        $event = new Event();
        $event->InsertInDataBase($reqq);
        $data2 = [
            'name' => 'SELECT * FROM `events`',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $req2 = new Request($data2);
        $evt = Event::all()->where('name', '=', 'Ketab Event')->first();
        $evt->ModifyInDataBase($req2);
        $this->assertDataBaseHas("events", $data2);
    }
    public function test3() {
        $data = [
            'name' => 'Ketab Event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $reqq = new Request($data);
        $event = new Event();
        $event->InsertInDataBase($reqq);
        
        $data3 = [
            'name' => 'SELECT * FROM `events`',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $req3 = new Request($data3);
        $evt = Event::all()->where('name', '=', 'Ketab Event')->first();
        $evt->ModifyInDataBase($req3);
        $this->assertDataBaseHas("events", $data3);
    }
    
    

}
