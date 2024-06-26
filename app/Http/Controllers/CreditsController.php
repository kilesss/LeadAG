<?php

namespace App\Http\Controllers;

use App\Http\Requests\MakePayment;
use App\Http\Requests\SubmitCredit;
use App\Models\CreditsModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CreditsController extends Controller
{

    public function submitCredit(SubmitCredit $request)
    {
        $currentCreditAmount = 0;
        $allCreditsAmount = CreditsModel::all('amount', 'interest_amount');
        foreach ($allCreditsAmount as $key => $value) {
            $currentCreditAmount += $value->amount;
            $currentCreditAmount += $value->interest_amount;
        }
        if ($currentCreditAmount >= config('creditConfiguration.max_credits_amount')) {
            $err ['errors']['single_error'] = 'Sorry, you you exceed the maximum amount.';
            return response()->json($err, 422);
        }
        $creditsModel = new CreditsModel();
        $creditId = $creditsModel->generateCreditId();

        $years = round($request->input('customRange') / 12, 2);
        $yearsExploder = explode('.', $years);
        $years = $yearsExploder[0];
        $yearsReminds = $yearsExploder[1];
        $finalAmount = $request->input('amount');
        for ($i = 1; $i <= $years; $i++) {
            $finalAmount += round($finalAmount * (config('creditConfiguration.percent') / 100));

        }
        if ($yearsReminds != 0) {
            $restYearPercent = ($yearsReminds / 100) * config('creditConfiguration.percent');
            $restYearPercent = number_format((float)$restYearPercent, 2,);
            $finalAmount += $finalAmount * ($restYearPercent / 100);
        }
        $finalAmount = round($finalAmount, 2);
        $fee = ceil($finalAmount / $request->input('customRange'));
        $creditsModel = new CreditsModel();
        $creditsModel->name = $request->input('name');
        $creditsModel->amount = $request->input('amount');
        $creditsModel->creditId = $creditId;
        $creditsModel->period = $request->input('customRange');
        $creditsModel->interest_amount = $finalAmount - $request->input('amount');
        $creditsModel->fee = $fee;
        $creditsModel->save();

        return true;
    }


    public function makePayment(MakePayment $request)
    {
        $creditModel = CreditsModel::find($request->input('credit'));
        $currentAmount = $creditModel->amount;
        $userAmount = User::find(Auth::user()->id)->first();
        if ($userAmount->wallet < $request->input('amount')) {
            $err ['errors']['single_error'] = 'You don`t have enough money in your wallet to make payment.';
            return response()->json($err, 422);
        }
        $creditModel->amount = $creditModel->amount - $request->input('amount');
        $user = User::where('id', Auth::user()->id);
        if ($creditModel->amount <= 0) {
            $overPay = $request->input('amount') - $currentAmount;
            $creditModel->delete();
            $err ['overpay'] = 'You overpay ' . $overPay . '. This amount will be returned';
            //in this case charge user the rest of the credit amount
            $user->update(['wallet' => $userAmount->wallet - $creditModel->amount]);
            return response()->json($err, 422);
        } else {
            //in this case charge user full amount
            $user->update(['wallet' => $userAmount->wallet - $request->input('amount')]);
            $creditModel->save();
            return response()->json([], 200);
        }
    }

    public function getCredits()
    {
        $creditsModel = new CreditsModel();
        $credits = $creditsModel->getCredits();
        return json_encode($credits);
    }

}
