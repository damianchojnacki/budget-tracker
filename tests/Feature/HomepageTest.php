<?php

test('homepage returns to dashboard', function () {
    test()
        ->get('/')
        ->assertRedirect('dashboard');
});
