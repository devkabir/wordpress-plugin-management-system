<?php


use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

it('can store plugin information', function () {
    // Send a request with prepared data.
    $data = [
        'name' => 'test-plugin:1.0.0',
        'url' => 'https://example.com',
        'plugins' => array('test-plugin'),
        'server' => array('7.0.0'),
        'action' => 'activate'
    ];
    $response = postJson('/api/org/support', $data);
    $response->assertSuccessful();
    $response->assertSeeText('ok');
    assertDatabaseHas('plugin_users', array(
        'name' => 'test-plugin',
        'website' => 'https://example.com',
    ));
});
