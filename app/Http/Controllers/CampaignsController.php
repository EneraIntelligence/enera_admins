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
            $collection = DB::getMongoDB()->selectCollection('campaign_logs');
            $gender_age = $collection->aggregate([

                // Stage 1
                [
                    '$match' => [
                        'campaign_id' => $id,
                        'user.id' => ['$exists' => true],
                    ]
                ],

                // Stage 2
                [
                    '$group' => [
                        '_id' => [
                            'gender' => '$user.gender',
                            'age' => '$user.age'
                        ],
                        'users' => [
                            '$addToSet' => '$user.id'
                        ]
                    ]
                ],

                // Stage 3
                [
                    '$unwind' => '$users'
                ],

                // Stage 4
                [
                    '$group' => [
                        '_id' => '$_id',
                        'count' => [
                            '$sum' => 1
                        ]
                    ]
                ],

                // Stage 5
                [
                    '$sort' => [
                        '_id' => 1
                    ]
                ]

            ]);

            $male = [];
            $female = [];

            foreach ($gender_age['result'] as $person => $valor) {
                if ($valor['_id']['age'] > 0 && $valor['_id']['age'] <= 17) {
                    ${$valor['_id']['gender']}[1] += $valor['count'];
                } else if ($valor['_id']['age'] >= 18 && $valor['_id']['age'] <= 20) {
                    ${$valor['_id']['gender']}[2] += $valor['count'];
                } else if ($valor['_id']['age'] >= 21 && $valor['_id']['age'] <= 30) {
                    ${$valor['_id']['gender']}[3] += $valor['count'];
                } else if ($valor['_id']['age'] >= 31 && $valor['_id']['age'] <= 40) {
                    ${$valor['_id']['gender']}[4] += $valor['count'];
                } else if ($valor['_id']['age'] >= 41 && $valor['_id']['age'] <= 50) {
                    ${$valor['_id']['gender']}[5] += $valor['count'];
                } else if ($valor['_id']['age'] >= 51 && $valor['_id']['age'] <= 60) {
                    ${$valor['_id']['gender']}[6] += $valor['count'];
                } else if ($valor['_id']['age'] >= 61 && $valor['_id']['age'] <= 70) {
                    ${$valor['_id']['gender']}[7] += $valor['count'];
                } else if ($valor['_id']['age'] >= 71 && $valor['_id']['age'] <= 80) {
                    ${$valor['_id']['gender']}[8] += $valor['count'];
                } else if ($valor['_id']['age'] >= 81 && $valor['_id']['age'] <= 90) {
                    ${$valor['_id']['gender']}[9] += $valor['count'];
                } else if ($valor['_id']['age'] >= 91) {
                    ${$valor['_id']['gender']}[10] += $valor['count'];
                }
            }

            /*******         OBTENER LAS INTERACCIONES POR hora       ***************/
            $collection = DB::getMongoDB()->selectCollection('campaign_logs');
            $IntLoaded = $collection->aggregate([
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
                                'format' => '%H', 'date' => ['$subtract' => ['$created_at', 18000000]]
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
            $IntCompleted = $collection->aggregate([
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
                                'format' => '%H', 'date' => ['$subtract' => ['$created_at', 18000000]]
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

            $IntHours = [];
            foreach ($IntLoaded['result'] as $k => $v) {
                $IntHours[$v['_id']]['loaded'] = $v['cnt'];
            }

            foreach ($IntCompleted['result'] as $k => $v) {
                $IntHours[$v['_id']]['completed'] = $v['cnt'];
            }

            $unique_users_query = $collection->aggregate([
                [
                    '$match' => [
                        'campaign_id' => $id,
                    ]
                ],
                [
                    '$group' => [
                        '_id' => '',
                        'users' => [
                            '$addToSet' => '$user.id',
                        ]
                    ],
                ],
                ['$unwind' => '$users'],
                [
                    '$group' => [
                        '_id' => '$_id',
                        'cnt' => ['$sum' => 1]
                    ]
                ]
            ])['result'];
            $unique_users = isset($unique_users_query[0]['cnt']) ? $unique_users_query[0]['cnt'] : 0;

            $lugares = in_array('all', $campaign->branches) ? 'global' : $campaign->branches;

            return view('campaigns.show', [
                'cam' => $campaign,
                'lugares' => $lugares,
                'men' => $male,
                'women' => $female,
                'porcentaje' => $porcentaje,
                'IntHours' => $IntHours,
                'unique_users' => $unique_users,
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
