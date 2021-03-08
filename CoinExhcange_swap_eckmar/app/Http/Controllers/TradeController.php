<?php

namespace App\Http\Controllers;

use App\Exceptions\AmountNotWithinLimitsException;
use App\Exceptions\InvalidAddressException;
use App\Http\Requests\Trade\ConfirmTradeRequest;
use App\Http\Requests\Trade\CreateTradeRequest;
use App\Trade;
use App\Trade\TradeDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TradeController extends Controller
{
    public function confirmPost(ConfirmTradeRequest $request)
    {
        try {
            $request->persist();
            return redirect()->route('trade.confirm.show');
        } catch (AmountNotWithinLimitsException $exception) {
            session()->flash('error', $exception->getMessage());
            return redirect()->back();
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('error', 'Could not create trade, please try again later');
            return redirect()->back();
        }
    }

    public function confirmShow()
    {
        $details = TradeDetails::getFromSession();
        if ($details == null){
            return redirect()->route('home');
        }
        return view('confirm')->with([
            'details' => $details
        ]);
    }

    public function create(CreateTradeRequest $request)
    {
        try {
            $trade = $request->persist();
            return redirect()->route('trade', $trade);
        } catch (\Exception $exception) {
            Log::error($exception);
            $message = 'Could not create trade, please try again later';
            if ($exception instanceof InvalidAddressException) {
                $message = $exception->getMessage();
            }
            session()->flash('error', $message);
            return redirect()->back();
        }
    }

    public function showTrade(Trade $trade)
    {

        $tradeWithRelations = Trade::where('id', $trade->id)->with('morphTrade')->first();

        return view('trade')->with([
            'trade' => $tradeWithRelations
        ]);

    }
}
