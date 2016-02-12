<?php

namespace Admins\Http\Controllers;

use Admins\Administrator;
use Admins\Branche;
use Admins\Jobs\ActiveJob;
use Admins\Jobs\RejectJob;
use Carbon\Carbon;
use DateTime;
use Admins\CampaignLog;
use DB;
use Illuminate\Http\Request;
use Auth;
use Admins\Campaign;
use Admins\Libraries\CampaignStyleHelper;
use Input;
use Mail;
use MongoDate;


class CampaignsController extends Controller
{

    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Obteniendo campañas del user loggeado
        //$admin_id = Auth::user()->_id;
        //$campaigns = Campaign::where('status', 'active')->latest()->get();
        //CityBranchesScript::saveCityBranches();
        $grafica = array();
        $campaigns = Campaign::where('status', 'pending')->latest()->get();
        $subcampaigns = Auth::user()->subcampaigns()->latest()->get();

        /****  for each para sacar los datos de cada campaña   ****/
        foreach ($campaigns as $campaign) {
            /****  OBTENER PORCENTAJE DEL TIEMPO TRANSCURRIDO DE LA CAMPAÑA ****/
            $start = new DateTime(date('Y-m-d H:i:s', $campaign->filters['date']['start']->sec));
            $end = new DateTime(date('Y-m-d H:i:s', $campaign->filters['date']['end']->sec));
            $start->setTime(00, 00, 00);
            $end->setTime(00, 00, 00);
            if ($campaign->status == 'active') {
                $today = new DateTime();
                if ($today < $start) {// si a fecha de hoy es menor a la de inicio el porcentaje tambien es 0
                    $dias['porcentaje'] = 0;
                    $total = $start->diff($end);
                    $dias['total'] = $total->format('%a');
                } else {
                    $total = $start->diff($end);  //total de dias que deveria estar activo inicio - fin
                    $diff = $start->diff($today); //total de dias hasta hoy  inicio - hoy
                    $dias['total'] = $total->format('%a') - $diff->format('%a'); //guardo el total de dias
                    $dias['porcentaje'] = round(($diff->format('%a') * 100) / $total->format('%a'), 0, PHP_ROUND_HALF_EVEN);
                }//fin del else que verifica si la fecha de inicio es menor a hoy
            } else {//si la campaña no esta activa el porcentaje es 0
                $dias['porcentaje'] = 0;
                $dias['total'] = 0;
            }
            $campaign->dias = $dias;
            $id = $campaign->_id;
            /**************************   DATOS DE LA GRAFICA    ****************************/
            $rangoFechas = array();
            for ($i = 0; $i < 7; $i++) {
                $a = new DateTime("-$i days");
                $b = new  DateTime("-$i days");
                $rangoFechas[$i]['inicio'] = $a->setTime(0, 0, 0);
                $rangoFechas[$i]['fin'] = $b->setTime(23, 59, 59);
                $graficat['dia' . ($i + 1)]['fecha'] = $a->format('Y-m-d');
            }
//            dd($grafica);
//            dd($rangoFechas);
            $graficat['dia1']['num'] = CampaignLog::where('campaign_id', $id)->where('interaction.loaded', 'exists', 'true')->where('updated_at', '>', $rangoFechas[0]['inicio'])->where('updated_at', '<', $rangoFechas[0]['fin'])->count();
            $graficat['dia2']['num'] = CampaignLog::where('campaign_id', $id)->where('interaction.loaded', 'exists', 'true')->where('updated_at', '>', $rangoFechas[1]['inicio'])->where('updated_at', '<', $rangoFechas[1]['fin'])->count();
            $graficat['dia3']['num'] = CampaignLog::where('campaign_id', $id)->where('interaction.loaded', 'exists', 'true')->where('updated_at', '>', $rangoFechas[2]['inicio'])->where('updated_at', '<', $rangoFechas[2]['fin'])->count();
            $graficat['dia4']['num'] = CampaignLog::where('campaign_id', $id)->where('interaction.loaded', 'exists', 'true')->where('updated_at', '>', $rangoFechas[3]['inicio'])->where('updated_at', '<', $rangoFechas[3]['fin'])->count();
            $graficat['dia5']['num'] = CampaignLog::where('campaign_id', $id)->where('interaction.loaded', 'exists', 'true')->where('updated_at', '>', $rangoFechas[4]['inicio'])->where('updated_at', '<', $rangoFechas[4]['fin'])->count();
            $graficat['dia6']['num'] = CampaignLog::where('campaign_id', $id)->where('interaction.loaded', 'exists', 'true')->where('updated_at', '>', $rangoFechas[5]['inicio'])->where('updated_at', '<', $rangoFechas[5]['fin'])->count();
            $graficat['dia7']['num'] = CampaignLog::where('campaign_id', $id)->where('interaction.loaded', 'exists', 'true')->where('updated_at', '>', $rangoFechas[6]['inicio'])->where('updated_at', '<', $rangoFechas[6]['fin'])->count();
//            $grafica['grafica']=$graficat;
            $campaign->grafica = $graficat;
//            dd($graficat);
        }//FIN DEL FOR
//        dd($campaigns);

        return view('campaigns.index', ['campaigns' => $campaigns, 'subcampaigns' => $subcampaigns, 'user' => Auth::user()]);
    }

    /**
     * Display the specified resource.
     * Muestra la información de una campaña
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $porcentaje = 0.0;
        $lugares = '';
        /**     ARREGLO PARA GUARDAR LAS HORAS **/
        $IntXDias = [
            '00' => ['hora' => '00', 'cntC' => 0, 'cntL' => 0], '01' => ['hora' => '01', 'cntC' => 0, 'cntL' => 0], '02' => ['hora' => '02', 'cntC' => 0, 'cntL' => 0], '03' => ['hora' => '03', 'cntC' => 0, 'cntL' => 0],
            '04' => ['hora' => '04', 'cntC' => 0, 'cntL' => 0], '05' => ['hora' => '05', 'cntC' => 0, 'cntL' => 0], '06' => ['hora' => '06', 'cntC' => 0, 'cntL' => 0], '07' => ['hora' => '07', 'cntC' => 0, 'cntL' => 0],
            '08' => ['hora' => '08', 'cntC' => 0, 'cntL' => 0], '09' => ['hora' => '09', 'cntC' => 0, 'cntL' => 0], '10' => ['hora' => '10', 'cntC' => 0, 'cntL' => 0], '11' => ['hora' => '11', 'cntC' => 0, 'cntL' => 0],
            '12' => ['hora' => '12', 'cntC' => 0, 'cntL' => 0], '13' => ['hora' => '13', 'cntC' => 0, 'cntL' => 0], '14' => ['hora' => '14', 'cntC' => 0, 'cntL' => 0], '15' => ['hora' => '15', 'cntC' => 0, 'cntL' => 0],
            '16' => ['hora' => '16', 'cntC' => 0, 'cntL' => 0], '17' => ['hora' => '17', 'cntC' => 0, 'cntL' => 0], '18' => ['hora' => '18', 'cntC' => 0, 'cntL' => 0], '19' => ['hora' => '19', 'cntC' => 0, 'cntL' => 0],
            '20' => ['hora' => '20', 'cntC' => 0, 'cntL' => 0], '21' => ['hora' => '21', 'cntC' => 0, 'cntL' => 0], '22' => ['hora' => '22', 'cntC' => 0, 'cntL' => 0], '23' => ['hora' => '23', 'cntC' => 0, 'cntL' => 0],
        ];
        $campaign = Campaign::find($id); //busca la campaña
        if ($campaign) {
            /******     saca el color y el icono que se va a usar regresa un array  ********/
            $color = [];
            $color['icon'] = CampaignStyleHelper::getStatusIcon($campaign->status);
            $color['color'] = CampaignStyleHelper::getStatusColor($campaign->status);

            /****         OBTENER PORCENTAJE DEL TIEMPO TRANSCURRIDO       ***************/
            $start = new DateTime(date('Y-m-d H:i:s', $campaign->filters['date']['start']->sec));
            $end = new DateTime(date('Y-m-d H:i:s', $campaign->filters['date']['end']->sec));

            switch ($campaign->status) {
                case 'pending':
                    $porcentaje = 0.0;
                    break;
                case 'rejected':
                    $porcentaje = 0.0;
                    break;
                case 'ended':
                    $ended = new DateTime($campaign->history->where('status', 'ended')->first()->date);
                    $total = $start->diff($end);
                    $diff = $start->diff($ended);
                    $porcentaje = $diff->format('%a') / $total->format('%a');
                    break;
                case 'active':
                    $today = new DateTime();
                    if ($today < $start) {
                        $porcentaje = 0;
                    } else {
                        $today = new DateTime();
                        $total = $start->diff($end);
                        $diff = $start->diff($today);
                        $porcentaje = $diff->format('%a') / $total->format('%a');
                    }
                    break;
                case 'canceled':
                    $canceled = new DateTime($campaign->history->where('status', 'canceled')->first()->date);
                    $total = $start->diff($end);
                    $diff = $start->diff($canceled);
                    $porcentaje = $diff->format('%a') / $total->format('%a');
                    break;
            }


            /*******         OBTENER LAS INTERACCIONES POR DIAS       ***************/
            $men['1'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 0)->where('user.age', '<=', 17)->distinct('user.id')->count();
            $men['2'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 18)->where('user.age', '<=', 20)->distinct('user.id')->count();
            $men['3'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 21)->where('user.age', '<=', 30)->distinct('user.id')->count();
            $men['4'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 31)->where('user.age', '<=', 40)->distinct('user.id')->count();
            $men['5'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 41)->where('user.age', '<=', 50)->distinct('user.id')->count();
            $men['6'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 51)->where('user.age', '<=', 60)->distinct('user.id')->count();
            $men['7'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 61)->where('user.age', '<=', 70)->distinct('user.id')->count();
            $men['8'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 71)->where('user.age', '<=', 80)->distinct('user.id')->count();
            $men['9'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 81)->where('user.age', '<=', 90)->distinct('user.id')->count();
            $men['10'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 90)->distinct('user_id')->count();

            $women['1'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 0)->where('user.age', '<=', 17)->distinct('user.id')->count();
            $women['2'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 18)->where('user.age', '<=', 20)->distinct('user.id')->count();
            $women['3'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 21)->where('user.age', '<=', 30)->distinct('user.id')->count();
            $women['4'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 31)->where('user.age', '<=', 40)->distinct('user.id')->count();
            $women['5'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 41)->where('user.age', '<=', 50)->distinct('user.id')->count();
            $women['6'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 51)->where('user.age', '<=', 60)->distinct('user.id')->count();
            $women['7'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 61)->where('user.age', '<=', 70)->distinct('user.id')->count();
            $women['8'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 71)->where('user.age', '<=', 80)->distinct('user.id')->count();
            $women['9'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 81)->where('user.age', '<=', 90)->distinct('user.id')->count();
            $women['10'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 90)->distinct('user.id')->count();

            /*******         OBTENER LAS INTERACCIONES POR hora       ***************/
            $collection = DB::getMongoDB()->selectCollection('campaign_logs');
            $results = $collection->aggregate([
                [
                    '$match' => [
                        'campaign_id' => $id,
                        'interaction.loaded' => [
                            '$gte' => new MongoDate(strtotime(Carbon::today()->subDays(30)->format('Y-m-d'))),
                            '$lte' => new MongoDate(strtotime(Carbon::today()->subDays(0)->format('Y-m-d'))),
                        ]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => [
                            '$dateToString' => [
                                'format' => '%H:00:00', 'date' => ['$subtract' => ['$created_at', 18000000]]
                            ]
                        ],
                        'cnt' => [
                            '$sum' => 1
                        ]
                    ],
                ],
                [
                    '$sort' => [
                        '_id' => 1
                    ]
                ]
            ]);
            $results2 = $collection->aggregate([
                [
                    '$match' => [
                        'campaign_id' => $id,
                        'interaction.completed' => [
                            '$gte' => new MongoDate(strtotime(Carbon::today()->subDays(30)->format('Y-m-d'))),
                            '$lte' => new MongoDate(strtotime(Carbon::today()->subDays(0)->format('Y-m-d'))),
                        ]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => [
                            '$dateToString' => [
                                'format' => '%H:00:00', 'date' => ['$subtract' => ['$created_at', 18000000]]
                            ]
                        ],
                        'cnt' => [
                            '$sum' => 1
                        ]
                    ],
                ],
                [
                    '$sort' => [
                        '_id' => 1
                    ]
                ]
            ]);

            foreach ($results['result'] as $result => $valor) {

                $time = explode(":", $valor['_id']);
                if (array_key_exists($time[0], $IntXDias)) {
//                    echo '<br>si esta<br>';
                    $IntXDias[$time[0]]['cntL'] = $valor['cnt'];
                } else {
//                    echo '<br>no esta<br>';
                    $IntXDias[$result][$time[0]] = 0;
                }
            }
            foreach ($results2['result'] as $result => $valor) {
                $time = explode(":", $valor['_id']);
                if (array_key_exists($time[0], $IntXDias)) {
                    $IntXDias[$time[0]]['cntC'] = $valor['cnt'];
                } else {
                    $IntXDias[$result][$time[0]] = 0;
                }
            }

            /****         SI EL BRANCH TIENE ALL SE MOSTRARA COMO GLOBAL       ***************/
            $today = new DateTime();
            if ($campaign->branches == 'all') {//SI TIENE ALL CAMBIO EL TEXTO POR GLOBAL
//                echo 'tiene globales';
                $lugares = 'global';
            } else {//SI NO ES GLOBAL SACO EL NOMBRE DE LOS BRANCHES
//                echo 'no tiene globales';
                $branches = $campaign->branches;// saco los branches a otra bariable para que me sea mas facil manejar los datos
                foreach ($branches as $clave => $valor) { // recorro el arreglo para hacer una consulta de todos los id de branches
//                    echo '<br>'.$clave.'  '.$valor;
                    $BRA = Branche::where('_id', $valor)->get(['name']); //guardo el valor de la consulta
                    $lugares[$clave] = $BRA[0]['original']['name'];//saco solo el valor que me interesa para no tener un array dentro de un array
                }
            }//FIN DEL ELSE PARA MANEJAR LOS BRANCHES

            return view('campaigns.show', [
                'cam' => $campaign,
                'lugares' => $lugares,
                'men' => $men,
                'women' => $women,
                'user' => auth()->user(),
                'porcentaje' => $porcentaje,
                'IntXDias' => $IntXDias
            ]);
        } else {
            return redirect()->route('campaigns::index')->with('data', 'errorCamp');
        }
    }

    public function admin($id)
    {
        $cam = Campaign::find($id);
        if ($cam == null) {
            return redirect()->action('CampaignsController@index')->with('data', 'not_found');
        } else {
            return view('campaigns.admin', ['cam' => $cam]);
        }
    }

    public function active($id)
    {
        $cam = Campaign::find($id);
        $cam->status = 'active';
        $cam->save();
        $user = $cam->administrator;

        $this->dispatch(new ActiveJob($cam, $user));

//        Mail::send('emails.active', ['cam' => $cam, 'user' => $user], function ($m) use ($user) {
//            $m->from('soporte@enera.mx', 'Enera Intelligence');
//            $m->to($user->email , $user->name['first'] . ' ' . $user->name['last'])->subject('Campaña Activada');
//        });

        return redirect()->action('CampaignsController@index')->with('data', 'active');

    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject()
    {
        $cam = Campaign::find(Input::get('campaign_id'));
        $user = $cam->administrator;
        $cam->status = 'rejected';
        $cam->save();
        $user->wallet->increment('current', $cam->balance['current']);

        $admin_movement = auth()->user()->movements()->create([
            'client_id' => $user->client_id,
            'movement' => [
                'type' => 'refund',
                'concept' => 'refund',
                'from' => 'campaign',
                'to' => 'wallet'
            ],
            'reference_id' => $cam->id,
            'reference_type' => 'Campaign',
            'admistrator_id' => $user->id,
            'amount' => $cam->balance['current'],
            'balance' => ($user->wallet->current + $cam->balance['current'])
        ]);


        $cam->history()->create(array('administrator_id' => $user->id,
            'status' => 'rejected',
            'date' => date('Y-m-d  h:m:s'),
            'note' => Input::get('razon') . ', ' . Input::get('motivo') . 'Se regreso el dinero a la cuenta del administrador por la cantidad de ' . $cam->balance['current']));


        $this->dispatch(new RejectJob($cam, $user, Input::get('razon'), Input::get('motivo')));

//        Mail::send('emails.reject', ['cam' => $cam, 'user' => $user, 'razon' => Input::get('razon'), 'mensaje' => Input::get('motivo')], function ($m) use ($user) {
//            $m->from('soporte@enera.mx', 'Enera Intelligence');
//            $m->to($user->email , $user->name['first'] . ' ' . $user->name['last'])->subject('Campaña Rechazada');
//        });

        return redirect()->action('CampaignsController@index')->with('data', 'reject');

    }


}
