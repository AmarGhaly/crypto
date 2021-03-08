<?php

namespace App\Http\Controllers;

use App\Exchange\ProfitCalculator;
use App\Http\Requests\Admin\UpdateTradeRequest;
use App\Trade;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * @var int
     */
    protected $tradesPerPage = 25;

    /**
     * @var int
     */
    protected $usersPerPage = 25;

    /**
     * @var array
     */
    protected $validParams = [
        'output_address',
        'mid',
        'txid',
        'deposit_address',
        'refund_address'
    ];

    public function index($param = '', $query = '')
    {
        $trades = Trade::with('morphTrade');

        if (!($param == '' || $query == '' || !in_array($param, $this->validParams))) {
            switch ($param) {
                case 'mid':
                case 'txid':

                    $trades->whereHas('morphTrade', function (Builder $q) use ($query, $param) {
                        $q->where($param, $query);
                    });
                    break;
                case 'base_coin':
                case 'other_coin':
                case 'deposit_address':
                case 'refund':
                    $trades->where($param, $query);
                    break;
            }
        }

        $trades = $trades->orderByDesc('created_at')->paginate($this->tradesPerPage);

        return view('admin.trades')->with([
            'trades' => $trades,
            'tradesPerPage' => $this->tradesPerPage,
            'validParams' => $this->validParams,
            'param' => $param,
            'query' => $query,
            'profit' => ProfitCalculator::getCurrentProfit()
        ]);
    }

    public function filter(Request $request)
    {

        return redirect()->route('admin.index', [
            'param' => $request->search_param,
            'query' => $request->search_query,
        ]);
    }

    public function trade(Trade $trade)
    {
        $trade = Trade::where('id', $trade->id)->with('morphTrade')->first();
        return view('admin.trade')->with([
            'trade' => $trade
        ]);
    }

    public function updateTrade(Trade $trade, UpdateTradeRequest $request)
    {

        try {
            DB::beginTransaction();
            $request->persist($trade);
            DB::commit();
            session()->flash('success', 'Trade updated successfully');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
            session()->flash('error', 'Could not update trade');
        } finally {
            return redirect()->back();
        }
    }

    public function users()
    {
        $users = User::orderByDesc('created_at')->paginate($this->usersPerPage);
        return view('admin.users')->with([
            'users' => $users,
            'usersPerPage' => $this->usersPerPage
        ]);
    }
}
