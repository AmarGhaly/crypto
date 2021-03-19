<?php

namespace App\Http\Requests\Trade;

use App\Exceptions\AddressGenerationException;
use App\Exceptions\CouldNotCreateTradeException;
use App\Exceptions\InvalidAddressException;
use App\Exceptions\InvalidRequestException;
use App\TradeModel;
use App\Trade;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\SwapController;

class CreateTradeRequest extends FormRequest
{
    public function createTrade($coin_send, $coin_receive, $rate_type, $amount_send, $recipient){
        $swapcontroller = new SwapController();
        $trade = $swapcontroller->makeOrder($coin_send, $coin_receive, $rate_type, $amount_send,$recipient);
        return $trade;
    }

    // /**
    //  * Determine if the user is authorized to make this request.
    //  *
    //  * @return bool
    //  */
    // public function authorize()
    // {
    //     $details = Trade\TradeDetails::getFromSession();
    //     if ($details !== null) {
    //         return true;
    //     }
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount_send'=> 'required',
            'amount_receive' => 'required',
            'recipient' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'amount_send.required' => 'Amount send is required',
            'amount_receive.required' => 'Amount receive is required',
            'recipient.required' => 'ETH wallet adress is required',

        ];
    }

    public function persist(): Trade
    {
        $details->recipient = $this->recipient;
        $errorMessage = 'Could not create trade, please try again later';
        try {
            // DB::beginTransaction();
            // $trade = new Trade();
            // $trade->setTradeDetailParameters($details);

            // // $payment = PaymentGetter::getPayment($details->coinSend);
            // //$address = $payment->generateAddress();

            // $trade->deposit_address = $address;

            // $trade->save();
            // $tradeModel = TradeModel::createFromDetails($details, $trade);

            // DB::commit();
            return $trade;
        } catch (InvalidRequestException $exception) {
            DB::rollBack();
            Log::error($exception);
            Log::error($exception->getData());
            throw new CouldNotCreateTradeException($errorMessage);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new CouldNotCreateTradeException($errorMessage);
        }


    }
}