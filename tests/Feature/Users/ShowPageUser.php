<?php

use App\Models\User;
use Livewire\Volt\Volt;

test('users screen can be rendered', function () {
    $this->actingAs(superAdmin());

    $response = $this->get('/users');
    $response
        ->assertOk()
        ->assertSeeVolt('pages.users.index');
});


test('search input', function () {
    $this->actingAs(superAdmin());

    $component = Volt::test('pages.users.index')
        ->set('search', 'test');

    $component->assertNoRedirect();
});