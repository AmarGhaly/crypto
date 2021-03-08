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

class ConfirmTradeRequest extends FormRequest
{
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
            'direction' => [Rule::in(TradeDirection::getValidDirections())]
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Trade amount is required',
            'amount.gt' => 'Amount must be a number greater than 0'
        ];
    }

    /**
     * @throws AmountNotWithinLimitsException
     */
    public function persist()
    {
        $details = new TradeDetails([
            'required_payment' => $this->amount,
            'direction' => $this->direction,
        ]);
        $limits = Limits::getLimits();
        $inputLimit = $limits[$details->direction];
        if (!Limits::isWithinLimits($details)){
            $min = $inputLimit['min'];
            $max = $inputLimit['max'];
            if ($details->baseCoin == 'btc'){
                $min = Converter::satoshiToBtc($min);
                $max = Converter::satoshiToBtc($max);
            }
            if ($details->baseCoin == 'xmr'){
                $min = Converter::toXmr($min);
                $max = Converter::toXmr($max);
            }
            $baseCoin = strtoupper($details->baseCoin);
            $message = "Amount not valid. Minimum: {$min} {$baseCoin} Maximum: {$max} {$baseCoin}";
            throw new AmountNotWithinLimitsException($message);
        }


        $details->putIntoSession();


    }
}
