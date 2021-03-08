<?php

return [

    /**
     * List of coins supported by this market
     * Mapped in the implementations
     *
     * 'btc' => RPCWrapper
     * 'xmr' => Monero
     * 'stb' => Stub coin
     */
    'coin_list' => [
        'btc' => \App\Exchange\Payment\BitcoinPayment::class,
        'xmr' => \App\Exchange\Payment\MoneroPayment::class,


    ],

    /**
     * RPCWrapper settings
     *
     * Uses data from .env file
     */
    'bitcoin' => [
        'host' => env('BITCOIND_HOST', 'localhost'),
        'username' => env('BITCOIND_USERNAME', 'myuser'),
        'password' => env('BITCOIND_PASSWORD', 'mypassword'),
        'port' => env('BITCOIND_PORT', 18332),
        'minconfirmations' => env('BITCOIND_MINCONFIRMATIONS', 1),
    ],


    /**
     * Monero settings
     *
     * Uses data from .env file
     */

    'monero' => [
        'host' => env('MONERO_HOST','127.0.0.1'),
        'port' => intval(env('MONERO_PORT',28091)),
        'username' => env('MONERO_USERNAME','testwallet'),
        'password' => env('MONERO_PASSWORD','testwallet')


    ],


    'market_addresses' => [
        'btc' => [ // list of btc addresses
            '2NEige9aJPrmuNvyvAkZ9DCakeCcWGSmi3c'
        ],
        'xmr' => [ // list of xmr addresses
            '5H8hV8ipSZaNHRjo2AFsz6SfQxYobVqp56wbwdxnVVcnfyXWSNWGNKHbs5sKBo9LVE3PcN716kG83UG9xQtKyPX6SjKCg1i18ndAoC23Ke'
        ],
    ],


];
