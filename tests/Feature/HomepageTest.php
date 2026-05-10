<?php

test('homepage returns to dashboard', function (): void {
    test()
        ->get('/')
        ->assertRedirect('dashboard');
});
