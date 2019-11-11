<?php

namespace App\Http\Controllers;

use App\Models\Dado;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Excel;

class ReativacaoClaroController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $toActive = new Collection();
        $toCancel = new Collection();
        $planos = [
            'BUNDLE-GRATUITO',
            'Hero Bundle Top',
            'Bundle SUPER',
            'HERO Basico PJ',
            'HERO Intermediario PJ',
            'HERO Avancado PJ'
        ];
        $data = Dado::whereNull('parent_id')->get()->groupBy('msisdn');
        $data->filter(static function (Collection $item) {
            return $item->count() > 1;
        });
        $data->each(static function (Collection $msisdn, $key) use ($toActive, $toCancel, $planos) {
            $msisdn->sortByDesc('data_compra');
            $msisdn->each(static function ($dado) use ($toActive, $toCancel, $planos) {
                $added = false;
                if (!$dado->data_cancelamento && (false !== stripos($dado->nome, 'DEGUSTACAO'))) {
                    $toCancel->push($dado);
                    $added = true;
                } elseif ($dado->data_cancelamento && !$added && in_array($dado->nome, $planos, true)) {
                    $toActive->push($dado);
                }
            });
        });

        $toActive->storeExcel('toActive.csv', 'local', Excel::CSV, true);
        $toCancel->storeExcel('toCancel.csv', 'local', Excel::CSV, true);

        return new JsonResponse([], 200);
    }
}
