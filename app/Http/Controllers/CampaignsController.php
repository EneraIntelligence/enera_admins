<?php

namespace Admins\Http\Controllers;

use Admins\Branche;
use Admins\Jobs\ActiveJob;
use Admins\Jobs\RejectJob;
use DateTime;
use Admins\CampaignLog;
use Illuminate\Http\Request;
use Auth;
use Admins\Campaign;
use Admins\Libraries\CampaignStyleHelper;
use Input;
use Mail;


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
        $campaigns = Campaign::where('status','pending')->latest()->get();
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
//        $this->genderAge($id);
        $campaign = Campaign::find($id); //busca la campaña

//        dd($campaign->logs()->where('user.id','exists',true)->get());

        if ($campaign) {
//            dd($campaign);
            //este arreglo se usa para poder convertir los numeros de los dias a letras
            //$semana = array(0 => '', 1 => 'lunes', 2 => 'martes', 3 => 'miércoles', 4 => 'jueves', 5 => 'viernes', 6 => 'sabado', 7 => 'domingo');

            //$imagen = $this->filecloud->getImagen('image.png');

            /******     saca el color y el icono que se va a usar regresa un array  ********/
            //$sColor = new StatusColor();
            $color = [];
            $color['icon'] = CampaignStyleHelper::getStatusIcon($campaign->status);
            $color['color'] = CampaignStyleHelper::getStatusColor($campaign->status);
//            dd($color);

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
//                    dd('hoy es menor a incio');
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
//            dd($porcentaje);
            $campaign->porcentaje = $porcentaje;
            /*******         OBTENER LAS INTERACCIONES POR DIAS       ***************/
            $men['1'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 0)->where('user.age', '<=', 17)->distinct('user_id')->count();
            $men['2'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 18)->where('user.age', '<=', 20)->distinct('user_id')->count();
            $men['3'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 21)->where('user.age', '<=', 30)->distinct('user_id')->count();
            $men['4'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 31)->where('user.age', '<=', 40)->distinct('user_id')->count();
            $men['5'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 41)->where('user.age', '<=', 50)->distinct('user_id')->count();
            $men['6'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 51)->where('user.age', '<=', 60)->distinct('user_id')->count();
            $men['7'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 61)->where('user.age', '<=', 70)->distinct('user_id')->count();
            $men['8'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 71)->where('user.age', '<=', 80)->distinct('user_id')->count();
            $men['9'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 81)->where('user.age', '<=', 90)->distinct('user_id')->count();
            $men['10'] = -$campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'male')
                ->where('user.age', '>=', 90)->distinct('user_id')->count();

            $women['1'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 0)->where('user.age', '<=', 17)->distinct('user_id')->count();
            $women['2'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 18)->where('user.age', '<=', 20)->distinct('user_id')->count();
            $women['3'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 21)->where('user.age', '<=', 30)->distinct('user_id')->count();
            $women['4'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 31)->where('user.age', '<=', 40)->distinct('user_id')->count();
            $women['5'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 41)->where('user.age', '<=', 50)->distinct('user_id')->count();
            $women['6'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 51)->where('user.age', '<=', 60)->distinct('user_id')->count();
            $women['7'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 61)->where('user.age', '<=', 70)->distinct('user_id')->count();
            $women['8'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 71)->where('user.age', '<=', 80)->distinct('user_id')->count();
            $women['9'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 81)->where('user.age', '<=', 90)->distinct('user_id')->count();
            $women['10'] = $campaign->logs()->where('interaction.loaded', 'exists', true)->where('user.gender', 'female')
                ->where('user.age', '>=', 90)->distinct('user_id')->count();
            $campaign->men = $men;
            $campaign->women = $women;
            /****         SI EL BRANCH TIENE ALL SE MOSTRARA COMO GLOBAL       ***************/
            $today = new DateTime();
            if ($campaign->branches == 'all') {//SI TIENE ALL CAMBIO EL TEXTO POR GLOBAL
//                echo 'tiene globales';
                $campaign->branches = 'global';
            } else {//SI NO ES GLOBAL SACO EL NOMBRE DE LOS BRANCHES
//                echo 'no tiene globales';
                $branches = $campaign->branches;// saco los branches a otra bariable para que me sea mas facil manejar los datos
                foreach ($branches as $clave => $valor) { // recorro el arreglo para hacer una consulta de todos los id de branches
//                    echo '<br>'.$clave.'  '.$valor;
                    $BRA = Branche::where('_id', $valor)->get(['name']); //guardo el valor de la consulta
                    $lugares[$clave] = $BRA[0]['original']['name'];//saco solo el valor que me interesa para no tener un array dentro de un array
                }
                $campaign->branches = $lugares;
            }//FIN DEL ELSE PARA MANEJAR LOS BRANCHAS

//            dd($campaign);
            return view('campaigns.show', [
                'cam' => $campaign,
                'user' => auth()->user(),
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
        $cam->history()->create(array('administrator_id' => auth()->user()->id,
                                                'status' => 'rejected',
                                                  'date' => date('Y-m-d  h:m:s'),
                                                  'note' => Input::get('razon').', '.Input::get('motivo')));

        $this->dispatch(new RejectJob($cam, $user));

//        Mail::send('emails.reject', ['cam' => $cam, 'user' => $user, 'razon' => Input::get('razon'), 'mensaje' => Input::get('motivo')], function ($m) use ($user) {
//            $m->from('soporte@enera.mx', 'Enera Intelligence');
//            $m->to($user->email , $user->name['first'] . ' ' . $user->name['last'])->subject('Campaña Rechazada');
//        });

        return redirect()->action('CampaignsController@index')->with('data', 'reject');

    }


}
