<?php

namespace App\Http\Requests\Trade;

use App\Exceptions\AddressGenerationException;
use App\Exceptions\CouldNotCreateTradeException;
use App\Exceptions\InvalidAddressException;
use App\Exceptions\InvalidMorphRequestException;
use App\Exchange\Payment\PaymentGetter;
use App\MorphTrade;
use App\Trade;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CreateTradeRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $details = Trade\TradeDetails::getFromSession();
        if ($details !== null) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'receiving_address' => 'required',
            'refund_address' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'receiving_address.required' => 'Receiving address is required',
            'refund_address.required' => 'Refund address is required',

        ];
    }

    public function persist(): Trade
    {
        $details = Trade\TradeDetails::getFromSession();
        $details->receivingAddress = $this->receiving_address;
        $details->refundAddress = $this->refund_address;
        $errorMessage = 'Cloud not create trade, please try again later';
        try {
            DB::beginTransaction();
            $trade = new Trade();
            $trade->setTradeDetailParameters($details);

            $payment = PaymentGetter::getPayment($details->baseCoin);
            $address = $payment->generateAddress();

            $trade->deposit_address = $address;

            $trade->save();
            $morphTrade = MorphTrade::createFromDetails($details, $trade);

            DB::commit();
            return $trade;
        } catch (InvalidMorphRequestException $exception) {
            DB::rollBack();
            Log::error($exception);
            Log::error($exception->getData());
            throw new CouldNotCreateTradeException($errorMessage);
        } catch (AddressGenerationException $exception) {
            DB::rollBack();
            $logMessage = 'Unable to generate address for coin ' . $exception->getCoin() . ' ' . $exception->getMessage();
            Log::error($logMessage);
            Log::error($exception);
            throw new CouldNotCreateTradeException($errorMessage);
        } catch (InvalidAddressException $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new InvalidAddressException($exception->getMessage());
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            throw new CouldNotCreateTradeException($errorMessage);
        }


    }
}
