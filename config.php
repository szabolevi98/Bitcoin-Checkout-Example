<?php

return [
    'btc_address' => '1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa', // Test transaction hash: 05fd3701beb9158927de4ff168fa7a30b2a19b2e0e865f8a59f8ad275de999a5
    'currency' => 'EUR',
    'amount' => 5,
    'threshold' => 0.98, // We are accepting 98%+ of the current amount since price is dynamic
    'required_confirmations' => 3,
    'db' => [
        'host' => '127.0.0.1',
        'user' => 'root',
        'pass' => '',
        'name' => 'bitcoin',
    ],
];
