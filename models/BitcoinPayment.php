<?php

namespace Models;

class BitcoinPayment
{
    /**
     * @var \mysqli
     */
    private \mysqli $conn;
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
        $this->conn = new \mysqli(
            $this->config['db']['host'],
            $this->config['db']['user'],
            $this->config['db']['pass'],
            $this->config['db']['name']
        );
    }

    /**
     * @return string
     */
    public function getBtcAmount(): string
    {
        $value = $this->config['amount'];
        $currency = $this->config['currency'];
        $btc = @file_get_contents("https://blockchain.info/tobtc?currency=$currency&value=$value");
        return $btc ?? "0.0";
    }

    /**
     * @param string $hash
     * @return array
     */
    public function validateTransaction(string $hash): array
    {
        $hash = $this->conn->real_escape_string($hash);
        $query = $this->conn->query("SELECT * FROM bitcoin_log WHERE transaction = '$hash'");
        if ($query->num_rows > 0) {
            return ['success' => false, 'message' => 'Transaction already used! Please contact support.'];
        }

        $recvSatoshi = @file_get_contents("https://blockchain.info/q/txresult/$hash/{$this->config['btc_address']}");
        if (!$recvSatoshi || $recvSatoshi < (($this->getBtcAmount() * 100000000) * $this->config['threshold'])) {
            return ['success' => false, 'message' => 'Low or invalid transaction amount.'];
        }

        $json = @file_get_contents("https://blockchain.info/tx/$hash?show_adv=false&format=json");
        $data = json_decode($json, true);
        if (empty($data['block_height'])) {
            return ['success' => false, 'message' => 'Transaction not yet confirmed.'];
        }

        $blockHeight = $data['block_height'];
        $currentCount = @file_get_contents("https://blockchain.info/q/getblockcount");
        $confirmations = $currentCount - $blockHeight + 1;

        if ($confirmations < $this->config['required_confirmations']) {
            return ['success' => false, 'message' => 'Not enough confirmations!'];
        }

        $this->conn->query("INSERT INTO bitcoin_log (transaction, created) VALUES ('$hash', NOW())");
        return ['success' => true, 'message' => 'Payment verified successfully!'];
    }
}
