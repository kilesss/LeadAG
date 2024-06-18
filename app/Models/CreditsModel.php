<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreditsModel extends Model
{
    use HasFactory;

    protected $table = 'credits';

    public function getCredits()
    {

        return DB::table($this->table)->select('id','creditId', 'name', 'amount', 'fee', 'period', 'created_at')->get();
    }

    public function generateCreditId()
    {
        $lastId = CreditsModel::select('id')->orderBy('id', 'desc')->first();
        if ($lastId == null) {
            $newId = 1;
        } else {
            $newId = $lastId->id + 1;
        }
        return $this->addZeros($newId);
    }

    private function addZeros($id)
    {
        $newNumber = $id;
        $numberOfZeros = 8 - strlen($id);
        for ($i = 0; $i < $numberOfZeros; $i++) {
            $newNumber = '0' . $newNumber;
        }
        return $newNumber;
    }
}
