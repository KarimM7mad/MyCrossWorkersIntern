<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Event;
use Illuminate\Http\Request;
use App\Exceptions\eventInsertionException;

class storeEventTest extends TestCase {

    use DatabaseTransactions;
    
    //normal data insertion
    public function test0() {
        $eventData = [
            'name' => 'Lola event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 1,
        ];
        $req = new Request($eventData);
        $evt = new Event();
        $evt->InsertInDataBase($req);
        $this->assertDatabaseHas('events', $eventData);
    }

    //Test1: to check foreign keys constraints and it should break before assertion        
    public function test1() {
        $eventData1 = [
            'name' => 'City Stars Event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 41,
        ];
        $req = new Request($eventData1);
        $evt = new Event();
        $this->expectException(eventInsertionException::class);
        $evt->InsertInDataBase($req, 41);
    }

    //Test2: test against SQL injection  RECHECK LATER
    public function test2() {
        //if this assertion is true , then the sql injection is not done 
        $eventData = [
            'name' => 'SELECT * FROM `events`',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-06',
            'admin_id' => 41,
        ];
        $req = new Request($eventData);
        $evt = new Event();
        $evt->InsertInDataBase($req, 1);
        $this->assertDatabaseHas('events', ['name' => 'SELECT * FROM `events`']);
        $evt->delete();
    }

    //Test3: check exception handling 
    public function test3() {
        $eventData = [
            'name' => 'Lola event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-0sss6',
            'admin_id' => 1,
        ];
        $req = new Request($eventData);
        $evt = new Event();
        $this->expectException(eventInsertionException::class);
        $evt->InsertInDataBase($req, 1);
    }

    //Test4 insert null value in unnullable value
    public function test4() {
        $eventData = [
            'name' => 'Lola event',
            'location' => 'City Stars , Helioplis',
            'date' => '2017-09-0sss6',
            'admin_id' => null,
        ];
        $req = new Request($eventData);
        $evt = new Event();
        $this->expectException(eventInsertionException::class);
        $evt->InsertInDataBase($req, null);
    }

}
