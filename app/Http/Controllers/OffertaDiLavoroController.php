<?php

namespace App\Http\Controllers;

use App\Http\Requests\api2EsameRequest;
use App\Http\Requests\api3EsameRequest;
use App\Models\OffertaDiLavoro;
use Illuminate\Http\Request;

class OffertaDiLavoroController extends Controller
{

    function api1Esame(Request $request)
    {
        try {
            if ($maxRichieste = $request->input('maxRichieste')) {
                $offerte = OffertaDiLavoro::orderBy('dataInserimento', 'desc')->take($maxRichieste)->get();
            } else {
                $offerte = OffertaDiLavoro::orderBy('dataInserimento', 'desc')->get();
            }
            return response()->json(['status' => 'OK', 'data' => $offerte], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore!', 'error' => $e->getMessage()], 500);
        }
    }


    function api2Esame(api2EsameRequest $request)
    {
        try {
            $newOfferta = new OffertaDiLavoro([
                'titolo' => $request->input('titolo'),
                'descrizioneBreve' => $request->input('descrizioneBreve'),
                'dataInserimento' => $request->input('dataInserimento'),
                'retribuzioneLorda' => $request->input('retribuzioneLorda'),
            ]);
            $newOfferta->save();
            return response()->json(['status' => 'OK', 'data' => $newOfferta], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore!', 'error' => $e->getMessage()], 500);
        }
    }


    function api3esame(api3EsameRequest $request)
    {
        try {

            $offerta = OffertaDiLavoro::where('offertaLavoroID', $request->input('offertaLavoroID'))->first();

            if (!isset($offerta)) {
                return response()->json(['status' => 'KO', 'message' => 'Errore!', 'error' => 'Offerta di lavoro non trovata'], 404);
            }

            $offerta->titolo = $request->input('titolo');
            $offerta->descrizioneBreve = $request->input('descrizioneBreve');
            $offerta->dataInserimento = $request->input('dataInserimento');
            $offerta->retribuzioneLorda = $request->input('retribuzioneLorda');

            $offerta->update();

            return response()->json(['status' => 'OK', 'data' => $offerta], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore!', 'error' => $e->getMessage()], 500);
        }
    }


    function api4esame(OffertaDiLavoro $offertaLavoroID)
    {
        try {
            $offertaLavoroID->delete();
            return response()->json(['status' => 'OK', 'message' => 'Offerta di lavoro eliminata con successo!'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore!', 'error' => $e->getMessage()], 500);
        }
    }

    function api5esame(Request $request)
    {
        try {
            $searchText = $request->input('searchText');
            $limit = $request->input('limit');

            // Inizia la query di base
            $query = OffertaDiLavoro::query();

            if (!empty($searchText)) {
                $query->where(function ($q) use ($searchText) {
                    $q->where('titolo', 'LIKE', '%' . $searchText . '%')
                        ->orWhere('descrizioneBreve', 'LIKE', '%' . $searchText . '%');
                });
            }

            $query->orderBy('dataInserimento', 'desc');

            if (is_numeric($limit) && $limit > 0) {
                $query->take($limit);
            }
            $offerteLavoro = $query->get();

            return response()->json(['status' => 'OK', 'data' => $offerteLavoro], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'KO', 'message' => 'Errore!', 'error' => $e->getMessage()], 500);
        }
    }

}
