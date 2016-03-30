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
        //Obteniendo todas campañas con estado activo y pending
        $campaignsA = Campaign::where('status', 'active')->latest()->get();
        $campaignsP = Campaign::where('status', 'pending')->latest()->get();
        $subcampaigns = Auth::user()->subcampaigns()->latest()->get();
//        dd($campaigns);
        return view('campaigns.index', ['campaignsA' => $campaignsA, 'campaignsP' => $campaignsP, 'subcampaigns' => $subcampaigns]);
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

            /*******         OBTENER LAS EDADES Y CANTIDAD DE USUARIOS UNICOS       ***************/
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

            $male = array_fill(1, 10, 0);
            $female = array_fill(1, 10, 0);

            foreach ($gender_age['result'] as $person) {
                if ($person['_id']['age'] > 0 && $person['_id']['age'] <= 17) {
                    ${$person['_id']['gender']}[1] += $person['count'];
                } else if ($person['_id']['age'] >= 18 && $person['_id']['age'] <= 20) {
                    ${$person['_id']['gender']}[2] += $person['count'];
                } else if ($person['_id']['age'] >= 21 && $person['_id']['age'] <= 30) {
                    ${$person['_id']['gender']}[3] += $person['count'];
                } else if ($person['_id']['age'] >= 31 && $person['_id']['age'] <= 40) {
                    ${$person['_id']['gender']}[4] += $person['count'];
                } else if ($person['_id']['age'] >= 41 && $person['_id']['age'] <= 50) {
                    ${$person['_id']['gender']}[5] += $person['count'];
                } else if ($person['_id']['age'] >= 51 && $person['_id']['age'] <= 60) {
                    ${$person['_id']['gender']}[6] += $person['count'];
                } else if ($person['_id']['age'] >= 61 && $person['_id']['age'] <= 70) {
                    ${$person['_id']['gender']}[7] += $person['count'];
                } else if ($person['_id']['age'] >= 71 && $person['_id']['age'] <= 80) {
                    ${$person['_id']['gender']}[8] += $person['count'];
                } else if ($person['_id']['age'] >= 81 && $person['_id']['age'] <= 90) {
                    ${$person['_id']['gender']}[9] += $person['count'];
                } else if ($person['_id']['age'] >= 91) {
                    ${$person['_id']['gender']}[10] += $person['count'];
                }
            }

            $male = array_map(function ($item) {
                return $item * -1;
            }, $male);

            /*******         OBTENER LAS INTERACCIONES POR hora       ***************/
            $IntLoaded = $collection->aggregate([
                [
                    '$match' => [
                        'campaign_id' => $id,
                        'interaction.loaded' => [
                            '$gte' => new MongoDate(strtotime(Carbon::today()->subDays(30)->format('Y-m-d') . 'T00:00:00-0600')),
                            '$lte' => new MongoDate(strtotime(Carbon::today()->subDays(0)->format('Y-m-d') . 'T00:00:00-0600')),
                        ]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => [
                            '$dateToString' => [
                                'format' => '%H', 'date' => ['$subtract' => ['$created_at', 21600000]]
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
                            '$gte' => new MongoDate(strtotime(Carbon::today()->subDays(30)->format('Y-m-d') . 'T00:00:00-0600')),
                            '$lte' => new MongoDate(strtotime(Carbon::today()->subDays(0)->format('Y-m-d') . 'T00:00:00-0600')),
                        ]
                    ]
                ],
                [
                    '$group' => [
                        '_id' => [
                            '$dateToString' => [
                                'format' => '%H', 'date' => ['$subtract' => ['$created_at', 21600000]]
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

//            $IntHours = array_fill(0, 24, 0);
            $IntHours = array();
            for ($i = 0; $i < 10; $i++) {
                $IntHours[$i]['loaded'] = 0;
                $IntHours[$i]['completed'] = 0;
            }
            for ($i = 10; $i < 24; $i++) {
                $IntHours[$i]['loaded'] = 0;
                $IntHours[$i]['completed'] = 0;
            }

            foreach ($IntLoaded['result'] as $k => $v) {
//                echo $v['_id'].'- <br>';
                $IntHours[intval($v['_id'])]['loaded'] = $v['cnt'];
            }

            foreach ($IntCompleted['result'] as $k => $v) {
                $IntHours[intval($v['_id'])]['completed'] = $v['cnt'];
            }
//            dd($IntHours);
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

//            dd($campaign->branches);
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

    public function search()
    {
        $campaign = Campaign::where('status', '<>', 'filed')->where('name', 'like', '%' . Input::get('search') . '%')->latest()->get();
        return view('campaigns.search', ['campaigns' => $campaign]);
    }


}
