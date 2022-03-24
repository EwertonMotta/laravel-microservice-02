<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Evaluation;
use Illuminate\Support\Str;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EvaluationTest extends TestCase
{
    public function testGetEvaluationsEmpty()
    {
        $response = $this->getJson('/evaluations/fake-company');

        $response->assertStatus(200)->assertJsonCount(0, 'data');
    }

    public function testGetEvaluationsCompany()
    {
        $company = (string) Str::uuid();
        Evaluation::factory()->count(6)->create([
            'company' => $company
        ]);
        $response = $this->getJson("/evaluations/{$company}");

        $response->assertStatus(200)->assertJsonCount(6, 'data');
    }

    public function testErrorStoreEvaluation()
    {
        $company = 'fake-company';
        $response = $this->postJson("/evaluations/{$company}");

        $response->assertStatus(422);
    }

    public function testStoreEvaluation()
    {
        $company = 'fake-company';
        $response = $this->postJson("/evaluations/{$company}",[
            'company' => (string) Str::uuid(),
            'comment' => 'New Comment',
            'stars' => 5
        ]);

        $response->assertStatus(404);
    }
}
