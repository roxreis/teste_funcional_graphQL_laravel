<?php

namespace graphql;

use Illuminate\Http\Request;
use App\Models\AccountBank;


class AccountBankMutator
{
    public function sacar($conta = 54321, $valorSacar)
    {
        $requisicao = AccountBank::where('conta', $conta)->get();
         
        foreach($requisicao as $sacar): 

            if($sacar->saldo > $valorSacar && $valorSacar > 0):

                $sacar->saldo = $sacar->saldo - $valorSacar;
                $sacar->save();

                else: 

                    return "Não existe saldo suficiente para esta operação";

            endif;
        endforeach;

        return response()->json( [
            "data"=>[
                "sacar"=>[
                    'conta' => $conta,
                    'saldo' => $sacar->saldo
                ]
            ]
        ]);
    }

    public function depositar(Request $request, $conta = 54321)
    {
        $requisicao = AccountBank::where('conta', $conta)->get();

        foreach($requisicao as $depositar): 

            $valorDepositar = $request->input('valor');

            if($valorDepositar > 0):

                $depositar->saldo = $depositar->saldo + $valorDepositar;
                $depositar->save();

                else: 

                    return "Valor incorreto";

            endif;
    
        endforeach;

        return response()->json([
            "data"=>[
                "depositar"=>[
                    'conta' => $conta,
                    'saldo' => $depositar->saldo
                ]
            ]
        ]);
    }

    public function saldo($conta = 54321)
    {
        
        $requisicao = AccountBank::where('conta', $conta)->get();
        
        foreach($requisicao as $saldo): 

            return response()->json([
                
                    'saldo' => $saldo->saldo
                
            ]);

        endforeach;

        
    }

}
