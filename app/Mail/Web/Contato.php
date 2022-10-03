<?php

namespace App\Mail\Web;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contato extends Mailable
{

    use Queueable,
        SerializesModels;

    public $field;
    public $pagina;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request, $pagina)
    {
        $field = [
            'nome' => $request->f_nome,
            'telefone' => $request->f_telefone,
            'email' => $request->f_email,
            'cidade' => '',
            'estado' => '',
            'mensagem' => $request->f_mensagem,
            'evento' => $request->f_evento,
            'data' => $request->f_data
        ];

        if ($request->f_cidade) {
            $cidade = \App\Models\Cidade::find($request->f_cidade);

            if ($cidade) {
                $field['cidade'] = $cidade->nome;
                $field['estado'] = $cidade->estado->nome;
            }
        }

        $this->field = $field;
        $this->pagina = $pagina;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->pagina) {
            if ($this->pagina->email) {
                $this->to($this->pagina->present()->emails);
                $this->to($this->field['email']);
                $this->replyTo($this->field['email'], $this->field['nome']);
            }
        }

        $this->from("vendas@campperrineventos.com.br");

        return $this->subject('Camp Perrin | Fale Conosco')
                        ->view('emails.web.contato')
                        ->text('emails.web.contato_plain')
                        ->with('field', $this->field);
    }

}
