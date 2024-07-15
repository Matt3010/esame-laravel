<?php

namespace App\Http\Controllers;

use App\Http\Requests\getRichiesteDiFinanziamentoApi6;
use App\Http\Requests\Modifica;
use App\Http\Requests\NuovaRichiestaFinanziamento;
use App\Http\Requests\SommaImportiRichiesteFinanziamento;
use App\Models\Richiesta;
use Illuminate\Http\Request;

class RichiestaController extends Controller
{

    public function getRichiesteDiFinanziamento($maxRichieste = null)
    {
        try {
            if ($maxRichieste) {
                $richieste = Richiesta::orderBy('DataInserimentoRichiesta', 'desc')->take($maxRichieste)->get();
            } else {
                $richieste = Richiesta::orderBy('DataInserimentoRichiesta', 'desc')->get();
            }

            return response()->json(['status' => 'OK', 'data' => $richieste]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante il recupero delle richieste di finanziamento', 'error' => $e->getMessage()], 500);
        }
    }

    public function getRichiesteDiFinanziamentoFilteredByCognomeNomeRichiedente($CognomeNomeRichiedente = null)
    {
        try {
            if ($CognomeNomeRichiedente !== null) {
                $richieste = Richiesta::where('CognomeNomeRichiedente', 'like', '%' . $CognomeNomeRichiedente . '%')->get();
            } else {
                $richieste = Richiesta::all();
            }

            return response()->json(['status' => 'OK', 'data' => $richieste]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante il recupero delle richieste di finanziamento filtrate', 'error' => $e->getMessage()], 500);
        }
    }

    public function postNuovaRichiestaFinanziamento(NuovaRichiestaFinanziamento $request)
    {
        try {
            $newRichiesta = new Richiesta([
                'CognomeNomeRichiedente' => $request->input('CognomeNomeRichiedente'),
                'DataInserimentoRichiesta' => $request->input('DataInserimentoRichiesta'),
                'Importo' => $request->input('Importo'),
                'NumeroRate' => $request->input('NumeroRate'),
            ]);

            if ($newRichiesta->save()) {
                return response()->json(['status' => 'OK', 'data' => $newRichiesta], 200);
            } else {
                return response()->json(['status' => 'KO', 'message' => 'Errore durante il salvataggio della nuova richiesta di finanziamento'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante il salvataggio della nuova richiesta di finanziamento', 'error' => $e->getMessage()], 500);
        }
    }

    public function postModificaRichiestaFinanziamento(Modifica $request, $richiestaID)
    {
        try {
            $richiesta = Richiesta::find($richiestaID);

            if (!$richiesta) {
                return response()->json(['status' => 'KO', 'message' => 'Richiesta non trovata'], 404);
            }

            $richiesta->CognomeNomeRichiedente = $request->input('CognomeNomeRichiedente', $richiesta->CognomeNomeRichiedente);
            $richiesta->DataInserimentoRichiesta = $request->input('DataInserimentoRichiesta', $richiesta->DataInserimentoRichiesta);
            $richiesta->Importo = $request->input('Importo', $richiesta->Importo);
            $richiesta->NumeroRate = $request->input('NumeroRate', $richiesta->NumeroRate);

            if ($richiesta->update()) {
                return response()->json(['status' => 'OK', 'data' => $richiesta]);
            } else {
                return response()->json(['status' => 'KO', 'message' => 'Errore durante l\'aggiornamento della richiesta di finanziamento'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante l\'aggiornamento della richiesta di finanziamento', 'error' => $e->getMessage()], 500);
        }
    }

    public function postDeleteRichiestaFinanziamento(Request $request)
    {
        try {
            $richiesta = Richiesta::find($request->input('richiestaID'));

            if (!$richiesta) {
                return response()->json(['status' => 'KO', 'message' => 'Richiesta non trovata'], 404);
            }

            if ($richiesta->delete()) {
                return response()->json(['status' => 'OK', 'data' => $richiesta]);
            } else {
                return response()->json(['status' => 'KO', 'message' => 'Errore durante la cancellazione della richiesta di finanziamento'], 500);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante la cancellazione della richiesta di finanziamento', 'error' => $e->getMessage()], 500);
        }
    }

    public function getRichiesteDiFinanziamentoDatesRange(getRichiesteDiFinanziamentoApi6 $request)
    {
        try {
            $dataMin = $request->input('DataMin');
            $dataMax = $request->input('DataMax');
            $limit = $request->input('maxRichieste');

            $query = Richiesta::whereBetween('DataInserimentoRichiesta', [$dataMin, $dataMax])
                ->orderBy('DataInserimentoRichiesta', 'desc');

            if ($limit) {
                $query->take($limit);
            }

            $richieste = $query->get();

            return response()->json(['status' => 'OK', 'data' => $richieste]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante il recupero delle richieste di finanziamento nel range di date', 'error' => $e->getMessage()], 500);
        }
    }

    public function sommaImportiRichieste(SommaImportiRichiesteFinanziamento $request)
    {
        try {
            $dataMin = $request->input('DataMin');
            $dataMax = $request->input('DataMax');

            $sommaImporti = Richiesta::whereBetween('DataInserimentoRichiesta', [$dataMin, $dataMax])
                ->sum('Importo');

            return response()->json(['status' => 'OK', 'sommaImporti' => $sommaImporti]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante il calcolo della somma degli importi delle richieste di finanziamento', 'error' => $e->getMessage()], 500);
        }
    }

    public function mediaRateRichieste(SommaImportiRichiesteFinanziamento $request)
    {
        try {
            $dataMin = $request->input('DataMin');
            $dataMax = $request->input('DataMax');

            $mediaRate = Richiesta::whereBetween('DataInserimentoRichiesta', [$dataMin, $dataMax])
                ->avg('NumeroRate');

            return response()->json(['status' => 'OK', 'mediaRate' => (int)$mediaRate]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore durante il calcolo della media delle rate delle richieste di finanziamento', 'error' => $e->getMessage()], 500);
        }
    }

}
