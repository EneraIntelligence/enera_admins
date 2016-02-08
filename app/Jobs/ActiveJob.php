<?php

namespace Admins\Jobs;

use Admins\Campaign;
use Admins\Jobs\Job;
use Admins\Administrator;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class ActiveJob extends Job implements SelfHandling, ShouldQueue
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
        Mail::send('emails.active', ['cam' => $this->campaign, 'user' => $user], function ($m) use ($user) {
            $m->from('soporte@enera.mx', 'Enera Intelligence');
            $m->to($user->email , $user->name['first'] . ' ' . $user->name['last'])->subject('Campaña Activada');
        });
    }
}
