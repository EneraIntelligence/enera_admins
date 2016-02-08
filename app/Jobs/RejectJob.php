<?php

namespace Admins\Jobs;

use Admins\Administrator;
use Admins\Campaign;
use Admins\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Input;
use Mail;

class RejectJob extends Job implements SelfHandling, ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $campaign;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @param Campaign $campaign
     * @param Administrator $user
     */
    public function __construct(Campaign $campaign, Administrator $user)
    {
        $this->campaign = $campaign;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        Mail::send('emails.reject', ['cam' => $this->campaign, 'user' => $this->user, 'razon' =>    Input::get('razon'), 'mensaje' => Input::get('motivo')], function ($m) use ($user) {
            $m->from('soporte@enera.mx', 'Enera Intelligence');
            $m->to($user->email, $user->name['first'] . ' ' . $user->name['last'])->subject('Campaña Rechazada');
        });
    }
}
