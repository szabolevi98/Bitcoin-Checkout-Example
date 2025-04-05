<?php

namespace Controllers;

use Models\BitcoinPayment;

class FormController
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
    public function showForm(): void
    {
        $payment = new BitcoinPayment($this->config);
        $btcAmount = $payment->getBtcAmount();
        $btcAddress = $this->config['btc_address'];

        $qrData = urlencode("bitcoin:$btcAddress?amount=$btcAmount");
        $qrImageUrl = "https://quickchart.io/chart?cht=qr&chs=200x200&chl=$qrData";

        require __DIR__ . '/../views/Form.php';
    }
}
