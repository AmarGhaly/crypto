<?php

namespace App\Http\Requests\Trade;

use App\Coins\Converter;
use App\Exceptions\AmountNotWithinLimitsException;
use App\Trade\Calculator;
use App\Trade\Limits;
use App\Trade\TradeDetails;
use App\Trade\TradeDirection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Http\Controllers\TradeController;

class ConfirmTradeRequest extends FormRequest
{
    public function confirmTrade($order_id){
        $tradecontroller = new TradeController();
        $orderStatus= $tradecontroller->checkOrder($order_id);
        return $orderStatus;
    }

    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|gt:0',
            // 'amount_receive' => 'required|gt:0',
            'direction' => [Rule::in(TradeDirection::getValidDirections())]
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Enter an amount to send',
            // 'amount_receive.required' => 'Enter an amount to receive',
            // 'amount_receive.gt' => 'Amount must be a number greater than 0',
            'amount.gt' => 'Amount must be a number greater than 0'
        ];
    }

    /**
     * @throws AmountNotWithinLimitsException
     */
    public function persist()
    {
        $details = new TradeDetails([
            'amount_send' => $this->amount_send,
            'amount_receive' => $this->amount_receive,
            'direction' => $this->direction,
        ]);
        $limits = Limits::getLimits();
        $inputLimit = $limits[$details->direction];
        if (!Limits::isWithinLimits($details)){
            $min = 0;
            $max = 500;
            if ($details->coinSend == 'btc'){
                $min = Converter::satoshiToBtc($min);
                $max = Converter::satoshiToBtc($max);
            }
            if ($details->coinReceive == 'xmr'){
                $min = Converter::toXmr($min);
                $max = Converter::toXmr($max);
            }
            $coinSend = strtoupper($details->coinSend);
            $message = "Amount not valid. Minimum: {$min} {$coinSend} Maximum: {$max} {$coinSend}";
            throw new AmountNotWithinLimitsException($message);
        }

        // $details->putIntoSession();


    }
}
