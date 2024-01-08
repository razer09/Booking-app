<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Statments;
use Illuminate\Http\Request;
use App\Rules\ExceedBalanceRule;
use App\Rules\IsNotTheAuthUserEmail;
use Illuminate\Support\Facades\Redirect;

class BankActionsController extends Controller
{
    // deposit function
    public function deposit(Request $request)
    {
        // validate the request
        $request->validate([
            'amount' => 'required|numeric|min:0.01|max:100000000000',
        ]);

        // get the user
        $user = auth()->user();
        // update the user's balance
        $user->balance += $request->amount;
        $user->save();

        // add statment
        Statments::create([
            'user_id' => $user->id,
            'type' => 'deposit',
            'amount' => $request->amount,
            'balance' => $user->balance,
        ]);

        return Redirect::back()->with('success', 'Deposit was added successfully.');
    }

    // withdraw function
    public function withdraw(Request $request)
    {
        // validate the request
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:100000000000',
                new ExceedBalanceRule(),
            ]
        ]);

        // update the user's balance
        $user = auth()->user();
        $user->balance -= $request->amount;
        $user->save();

        // add statment
        Statments::create([
            'user_id' => $user->id,
            'type' => 'withdraw',
            'amount' => $request->amount,
            'balance' => $user->balance,
        ]);

        return Redirect::back()->with('success', 'Withdraw with success.');
    }

    // transfer function
    public function transfer(Request $request)
    {
        // validate the request
        $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:0.01',
                'max:100000000000',
                new ExceedBalanceRule(),
            ],
            'email' => [
                'required',
                'email',
                'exists:users,email',
                new IsNotTheAuthUserEmail(),
            ],
        ]);

        // update the user's balance
        $user = auth()->user();
        $user->balance -= $request->amount;
        $user->save();

        // update the recipient's balance
        $recipient = User::where('email', $request->email)->first();
        $recipient->balance += $request->amount;
        $recipient->save();

        // add statment
        Statments::create([
            'user_id' => $user->id,
            'type' => 'transfer',
            'amount' => $request->amount,
            'balance' => $user->balance,
            'recepient_balance' => $recipient->balance,
            'recepiant_id' => $recipient->id,
        ]);

        // return the user
        return Redirect::back()->with('success', 'Transfer with success.');
    }

    // statments function
    public function statments()
    {
        // get the user
        $user = auth()->user();
        return Inertia::render('Statments', [
            'statments' => Statments::with('user:id,email', 'recepiant:id,email')
                ->where('user_id', $user->id)
                ->orWhere('recepiant_id', $user->id)
                ->paginate(10)
                ->through(function ($statment) {
                    return [
                        'id'                        => $statment->id,
                        'type'                      => $statment->type,
                        'amount'                    => $statment->amount,
                        'balance'                   => $statment->balance,
                        'recepient_balance'         => $statment->recepient_balance,
                        'user'                      => $statment->user,
                        'recepiant'                 => $statment->recepiant,
                        'created_at'                => $statment->created_at->format('d-m-Y h:i A'),
                    ];
                }),
        ]);
    }
}
