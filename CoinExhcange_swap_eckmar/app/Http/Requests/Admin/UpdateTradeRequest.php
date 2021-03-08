<?php

namespace App\Http\Requests\Admin;

use App\Trade;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class UpdateTradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    public function persist(Trade $trade)
    {

        if ($this->deposit_address !== null) {
            $trade->deposit_address = $this->deposit_address;
        }
        if ($this->refund_address !== null) {
            $trade->refund_address = $this->refund_address;
        }
        if ($this->state !== null) {
            if (in_array($this->state, Trade::getAvailableStates())) {
                $trade->state = $this->state;
            }
        }
        $trade->save();
    }
}
