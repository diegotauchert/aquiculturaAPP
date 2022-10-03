<?php

namespace App\Mail\Gestor;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Pessoa extends Mailable
{
    use Queueable, SerializesModels;

    public $field;
    public $pessoa;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request, $pessoa)
    {
        $field = [
            'nome' => $request->f_nome,
            'email' => $request->f_email,
            'veiculo' => $pessoa->servico()->first()->nome,
        ];

        $this->field = $field;
        $this->pessoa = $pessoa;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->pessoa) {
            if ($this->pessoa->email) {
                //$this->to("rifaclass@gmail.com");
                $this->to($this->field['email']);
                $this->replyTo($this->field['email'], $this->field['nome']);
                $this->from(env('CLIENTE_EMAIL'));
            }
        }

        return $this->subject(env('CLIENTE_NOME').' | Informações sobre seu pagamento')
                        ->view('emails.gestor.pessoa')
                        ->text('emails.gestor.pessoa_plain')
                        ->with('field', $this->field);
    }
}
