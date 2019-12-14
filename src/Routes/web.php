<?php

Route::middleware(['web', 'auth'])->group(function() {
    Route::get('/twofactor', [\MabenDev\TwoFactor\Controllers\TwoFactorController::class, 'index'])->name('2fa-form');
    Route::post('/twofactor', [\MabenDev\TwoFactor\Controllers\TwoFactorController::class, 'verify'])->name('2fa-verify');
});
