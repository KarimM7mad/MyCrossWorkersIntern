<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Stand;
use App\Event;

class updateStandTest extends TestCase {

    use DatabaseTransactions;
    /*
     *          ADMIN MODIFICATIONS ( ModifyInStandAdmin )
     *          ------------------------------------------
     */

    //normal update success/fail test
    public function test0() {
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
            'company_id' => NULL,
            'code' => 'KKKL',
            'price' => 4444,
        ];
        $req = new Request($standData);
        $std = new Stand();
        $std->StoreInStand($req);
        //success Modify Stand
        $standModifiedData = [
            'event_id' => $evt->id,
            'code' => 'XXXl',
            'price' => 4555,
        ];
        $reqMod = new Request($standModifiedData);
        $this->assertTrue($std->ModifyInStandAdmin($reqMod));
        //failed Modify Stand
        $std->company_id = 2;
        $std->save();
        $standModifiedData2 = [
            'event_id' => $evt->id,
            'code' => 'YYYl',
            'price' => 4555,
        ];
        $reqMod = new Request($standModifiedData2);
        $this->assertFalse($std->ModifyInStandAdmin($reqMod));
    }
    //exception handling and Data Constraints
    public function test1() {
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
            'company_id' => NULL,
            'code' => 'KKKL',
            'price' => 4444,
        ];
        $req = new Request($standData);
        $std = new Stand();
        $std->StoreInStand($req);
        //exception (Price is defined as integer so save will throw an exception)
        $standModifiedData2 = [
            'event_id' => $evt->id,
            'code' => 'YYYl',
            'price' => "455l",
        ];
        $reqMod = new Request($standModifiedData2);
        $this->expectException(standUpdateException::class);
        $std->ModifyInStandAdmin($reqMod);
    }
    /*
     *          Company MODIFICATIONS ( ModifyInStandCompany )
     *          ------------------------------------------
     */

    //normal success reservation
    public function test2() {
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
            'company_id' => NULL,
            'code' => 'KKKL',
            'price' => 4444,
        ];
        $req = new Request($standData);
        $std = new Stand();
        $std->StoreInStand($req);
        //success Modify Stand
        $this->assertTrue($std->ModifyInStandCompany(2));
        $this->assertFalse($std->ModifyInStandCompany(3));
    }
    //Exception Handling Test
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
            'company_id' => NULL,
            'code' => 'KKKL',
            'price' => 4444,
        ];
        $req = new Request($standData);
        $std = new Stand();
        $std->StoreInStand($req);
        //check Exception Handling
        $this->expectException(standUpdateException::class);
        $std->ModifyInStandCompany("yes");
    }

}
