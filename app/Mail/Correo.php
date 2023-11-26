<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Correo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $remitenteCorreo;

    public function __construct($remitenteCorreo)
    {
        $this->remitenteCorreo = $remitenteCorreo;
    }

    public function build()
    {
        return $this->view('correo.enviar_correo')
            ->from($this->remitenteCorreo); // Configura el remitente aquí
    }

}
