<?php
/**
 * Created by PhpStorm.
 * User: asdrubal
 * Date: 15/07/16
 * Time: 12:40 PM
 */

namespace Admins\Http\Controllers;

use GuzzleHttp;
//use Mailgun;
use Mailgun\Mailgun;

//use Mailgun\Tests\Mock\Mailgun;

class MailGunController extends Controller
{
//    private $domain = 'enera-intelligence.mx';
    private $domain = 'smtp.mailgun.org';
    private $mg;
    private $client;

    /**
     * MailGunController constructor.
     */
    public function __construct()
    {
        $this->client = new \Http\Adapter\Guzzle6\Client();
        $this->mg = new \Mailgun\Mailgun('key-2eeac48a97fd2992ddb1e4c860d74470', $this->client);

        # First, instantiate the SDK with your API credentials and define your domain.
//        $this->mg = new Mailgun('key-2eeac48a97fd2992ddb1e4c860d74470', null, 'bin.mailgun.net');
//        $this->mg = new Mailgun('key-2eeac48a97fd2992ddb1e4c860d74470',$this->client,'bin.mailgun.net');
//        $this->mg->setApiVersion('bin.mailgun.net/442e07d1');
        $this->mg->setSslEnabled('false');
        $this->domain = 'enera-intelligence.mx';
    }

    /**
     * @throws \Mailgun\Messages\Exceptions\MissingRequiredMIMEParameters
     */
    public function sendMail()
    {
        # Make the call to the client.
        $correo = $this->mg->sendMessage($this->domain, array(
            'from' => 'Excited User <prueba@enera-intelligence.mx>',
            'to' => 'arosas@enera.com',
//            'cc'      => 'baz@example.com',
//            'bcc'     => 'bar@example.com',
            'subject' => 'Hello',
            'text' => 'Testing some Mailgun awesomness!',
            'o:testmode' => true,
            'o:tracking' => true,
            'o:tag' => array('Tag1', 'Tag2'),
//            'html'    => '<html>HTML version of the body</html>'
        )/*, array(
            'attachment' => array('/path/to/file.txt', '/path/to/file.txt')
        )*/
        );

        echo 'se envio';
        dd($correo);
    }

    public function textmode()
    {
        Mailgun::send('emails.welcome', $data, function ($message) {
            $message->tag(array('Tag1', 'Tag2', 'Tag3'));
            $message->testmode(true);
        });
    }

    public function createList()
    {
        # Issue the call to the client.
        $result = $this->mg->post("lists", array(
            'name' => 'prueba',
            'address' => 'LIST2@enera-intelligence.mx',
            'description' => 'Mailgun Dev List2'
        ));

        dd($result);
    }

    public function tracking()
    {
        $queryString = array(
            'begin' => 'Fri, 15 jul 2016 00:00:00 -0000',
            'ascending' => 'yes',
            'limit' => 25,
            'pretty' => 'yes',
            'subject' => 'Notificación de Seguridad'
        );

        # Make the call to the client.
        $result = $this->mg->get("$this->domain/events", $queryString);
        dd($result);
    }

    public function click()
    {
        return 'ok click';
    }

    public function hBounces()
    {
        return 'ok hBounces';
    }

    public function accept()
    {
        return 'ok accept';
    }

}