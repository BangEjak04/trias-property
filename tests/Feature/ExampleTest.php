<?php

use App\Models\ProductKnowledge;

test('the application returns a successful response', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

test('welcome page displays active product knowledges and hides inactive ones', function () {
    $active = ProductKnowledge::factory()->create([
        'name' => 'Active Product Link',
        'url' => 'https://example.com/active',
        'is_active' => true,
        'order' => 1,
    ]);

    $inactive = ProductKnowledge::factory()->create([
        'name' => 'Inactive Product Link',
        'url' => 'https://example.com/inactive',
        'is_active' => false,
        'order' => 2,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
    $response->assertSee('Active Product Link');
    $response->assertDontSee('Inactive Product Link');
});
