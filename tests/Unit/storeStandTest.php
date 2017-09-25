<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Stand;
use App\Event;
use App\Http\Controllers\myEventsController;
use IllumInsertionException;

class storeStandTest extends TestCase {
    use DatabaseTransactions;
    //normal data insertion
    public function test0() {
        $eventData = [
            'name' => 'Ketab event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $Eventreq = new Request($eventData);
        $evt = new Event();
        $evt->InsertInDataBase($Eventreq);
        $standData = [
            'event_id' => $evt->id,
            'code' => 'KKKL',
            'price' => 4444,
        ];
        $req = new Request($standData);
        $std = new Stand();
        $std->StoreInStand($req);
        $this->assertDatabaseHas('stands', $standData);
    }
    //null in unnullable attributes and foreign key constraint
    public function test1() {
        $standData = [
            'event_id' => NULL,
            'code' => 'KKKL',
            'price' => 4444,
        ];
        $req = new Request($standData);
        $std = new Stand();
        $this->expectException(standInsertionException::class);
        $std->StoreInStand($req);
    }
    //SQL injection protection
    public function test2() {
        $eventData = [
            'name' => 'Ketab event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $Eventreq = new Request($eventData);
        $evt = new Event();
        $evt->InsertInDataBase($Eventreq);

        $standData = [
            'event_id' => $evt->id,
            'code' => 'SELECT * FROM `events`',
            'price' => 4444,
        ];
        $req = new Request($standData);
        $std = new Stand();
        $std->StoreInStand($req);
        $this->assertDatabaseHas('stands', $standData);
    }
    //database constraints test
    public function test3() {
    //create Event
        $eventData = [
            'name' => 'Ketab event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $Eventreq = new Request($eventData);
        $evt = new Event();
        $evt->InsertInDataBase($Eventreq);
    //create Stand
        $standData = [
            'event_id' => $evt->id,
            'company_id'=> NULL,
            'code' => 'KKKL',
            'price' => 4444,
        ];
        $req = new Request($standData);
        $std = new Stand();
        $std->StoreInStand($req);
    //check foreign keys
        $evt->delete();
        $this->assertDatabaseMissing('stands', $standData);
    }
}
