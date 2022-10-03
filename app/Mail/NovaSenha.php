<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NovaSenha extends Mailable
{

    use Queueable,
        SerializesModels;

    public $usuario;
    public $senha;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($usuario, $senha)
    {
        $this->usuario = $usuario;
        $this->senha = $senha;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nova Senha de acesso!')
                        ->view('emails.gestor.senha')
                        ->text('emails.gestor.senha_plain')
                        ->with('senha', $this->senha);
    }

}
