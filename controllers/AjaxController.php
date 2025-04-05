<?php

namespace Controllers;

use Models\BitcoinPayment;

class AjaxController
{
    /**
     * @var array
     */
    private array $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return void
     */
    public function checkTransaction(): void
    {
        header('Content-Type: application/json');
        $transactionHash = $_POST['hashName'] ?? '';
        if (empty($transactionHash)) {
            echo json_encode(['success' => false, 'message' => 'Missing transaction hash!']);
            return;
        }

        $payment = new BitcoinPayment($this->config);
        $result = $payment->validateTransaction($transactionHash);

        echo json_encode($result);
    }
}
