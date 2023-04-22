<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Inertia\Testing\AssertableInertia as Assert;

class DecisionMakerControllerTest extends TestCase
{
    public function test_show_form(): void
    {
        $response = $this->get('/');

        $response->assertInertia(fn (Assert $inertia) => $inertia
            ->component('DecisionMaker/QuestionForm')
        );
    }

    public function test_get_answer()
    {
        $inputs = [
            'question' => 'Should I go?',
            'count' => 2,
            'choices' => ['Yes', 'No'],
        ];

        $response = $this->postJson('/', $inputs);
        $response->assertOk();
        $response->assertJsonStructure(['question', 'answer']);
    }
}
