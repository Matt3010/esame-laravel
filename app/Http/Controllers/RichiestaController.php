<?php

namespace App\Http\Controllers;

use App\Http\Requests\getRichiesteDiFinanziamentoApi6;
use App\Http\Requests\ListaRichiesteFinanziamento;
use App\Http\Requests\ListaRichiesteFinanziamentoFilteredByCognomeNomeRichiedente;
use App\Http\Requests\NuovaRichiestaFinanziamento;
use App\Http\Requests\SommaImportiRichiesteFinanziamento;
use App\Models\Richiesta;

class RichiestaController extends Controller
{


    public function getRichiesteDiFinanziamento(ListaRichiesteFinanziamento $request)
    {
        if ($limit = $request->input('maxRichieste')) {
            return response()->json(['status' => 'OK', 'data' => Richiesta::orderBy('DataInserimentoRichiesta', 'desc')->take($limit)->get()]);
        } else {
            return response()->json(['status' => 'OK', 'data' => Richiesta::orderBy('DataInserimentoRichiesta', 'desc')->get()]);
        }
    }


    public function getRichiesteDiFinanziamentoFilteredByCognomeNomeRichiedente(ListaRichiesteFinanziamentoFilteredByCognomeNomeRichiedente $request)
    {
        return response()->json(['status' => 'OK', 'data' => Richiesta::where('CognomeNomeRichiedente', 'like', '%' . $request['CognomeNomeRichiedente'] . '%')->get()]);
    }


    public function postNuovaRichiestaFinanziamento(NuovaRichiestaFinanziamento $request)
    {
        $newRichiesta = new Richiesta([
            'CognomeNomeRichiedente' => $request->input('CognomeNomeRichiedente'),
            'DataInserimentoRichiesta' => $request->input('DataInserimentoRichiesta'),
            'Importo' => $request->input('Importo'),
            'NumeroRate' => $request->input('NumeroRate'),
        ]);

        if ($newRichiesta->save()) {
            return response()->json(['status' => 'OK', 'data' => $newRichiesta]);
        }
    }

    public function postModificaRichiestaFinanziamento(NuovaRichiestaFinanziamento $request, $richiestaID)
    {
        // Trova la richiesta esistente tramite RichiestaID
        $richiesta = Richiesta::find($richiestaID);

        // Verifica se la richiesta esiste
        if (!$richiesta) {
            return response()->json(['status' => 'KO', 'message' => 'Richiesta non trovata'], 404);
        }

        // Aggiorna i campi della richiesta, tranne RichiestaID
        $richiesta->CognomeNomeRichiedente = $request->input('CognomeNomeRichiedente', $richiesta->CognomeNomeRichiedente);
        $richiesta->DataInserimentoRichiesta = $request->input('DataInserimentoRichiesta', $richiesta->DataInserimentoRichiesta);
        $richiesta->Importo = $request->input('Importo', $richiesta->Importo);
        $richiesta->NumeroRate = $request->input('NumeroRate', $richiesta->NumeroRate);

        // Salva le modifiche
        if ($richiesta->save()) {
            return response()->json(['status' => 'OK, updated', 'data' => $richiesta]);
        } else {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante il salvataggio della richiesta'], 500);
        }
    }

    public function postDeleteRichiestaFinanziamento(NuovaRichiestaFinanziamento $request, $richiestaID)
    {
        // Trova la richiesta esistente tramite RichiestaID
        $richiesta = Richiesta::find($richiestaID);

        // Verifica se la richiesta esiste
        if (!$richiesta) {
            return response()->json(['status' => 'KO', 'message' => 'Richiesta non trovata'], 404);
        }

        if ($richiesta->delete()) {
            return response()->json(['status' => 'OK, deleted', 'data' => $richiesta]);
        } else {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante la cancellazione della richiesta'], 500);
        }
    }


    public function getRichiesteDiFinanziamentoDatesRange(getRichiesteDiFinanziamentoApi6 $request)
    {
        $dataMin = $request->input('DataMin');
        $dataMax = $request->input('DataMax');
        $limit = $request->input('maxRichieste');

        $query = Richiesta::whereBetween('DataInserimentoRichiesta', [$dataMin, $dataMax])
            ->orderBy('DataInserimentoRichiesta', 'desc');

        if ($limit) {
            $query->take($limit);
        }

        return response()->json(['status' => 'OK', 'data' => $query->get()]);
    }

    public function sommaImportiRichieste(SommaImportiRichiesteFinanziamento $request)
    {
        $dataMin = $request->input('DataMin');
        $dataMax = $request->input('DataMax');

        $sommaImporti = Richiesta::whereBetween('DataInserimentoRichiesta', [$dataMin, $dataMax])
            ->sum('Importo');

        return response()->json(['status' => 'OK', 'sommaImporti' => $sommaImporti]);
    }

    public function mediaRateRichieste(SommaImportiRichiesteFinanziamento $request)
    {
        $dataMin = $request->input('DataMin');
        $dataMax = $request->input('DataMax');

        $mediaRate = Richiesta::whereBetween('DataInserimentoRichiesta', [$dataMin, $dataMax])
            ->avg('NumeroRate');

        return response()->json(['status' => 'OK', 'mediaRate' => (int)$mediaRate]);
    }


}
