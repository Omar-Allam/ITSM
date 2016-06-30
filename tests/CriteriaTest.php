<?php

use App\Sla;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CriteriaTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_saves_criteria_correctly()
    {
        $data =  [
            "name" => "Call center high", "description" => "",
            "criterions" => [
                ["field" => "category_id", "operator" => "is", "value" => "2", 'label' => 'Call Center'],
                ["field" => "urgency_id", "operator" => "is", "value" => "2", 'label' => 'High']
            ],
            "due_days" => "0", "due_hours" => "4", "due_minutes" => "0",
            "response_days" => "", "response_hours" => "1", "response_minutes" => "0",
            "critical" => ""
        ];

        $sla = Sla::create($data);
        $request = \Illuminate\Http\Request::create('/admin/sla/store', 'POST', [
            'criteria_type' => \App\Criteria::ALL,
            'criterions' => $data['criterions']
        ]);
        $sla->updateCriteria($request);

//        dd($sla->criteria);
        $this->assertEquals(1, $sla->criteria()->count());

        $this->assertEquals(2, $sla->criteria()->first()->criteria()->count());

        $this->assertNotNull($sla->criteria()->first()->criteria()->first()->label);
    }
}
