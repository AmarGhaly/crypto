<?php

namespace App\Http\Controllers;

use App\Coins\Rates;
use App\Trade\TradeDirection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $defaultDirection;
    protected  $validDirections;
    public function __construct()
    {
        $this->defaultDirection = TradeDirection::getDefaultDirection();
        $this->validDirections = TradeDirection::getValidDirections();
    }

    public function index($direction = 'btcxmr')
    {
        if (!TradeDirection::isValidDirection($direction)){
            $direction = $this->defaultDirection;
        }
        $otherDirection = TradeDirection::getOtherDirection($direction);
        $rates = Rates::getRatesIncludingFee();
        return view('welcome')->with([
            'rates' => $rates,
            'direction' => $direction,
            'otherDirection' => $otherDirection
        ]);
    }
}
