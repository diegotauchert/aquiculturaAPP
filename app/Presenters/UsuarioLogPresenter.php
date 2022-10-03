<?php

namespace App\Presenters;

use Laracasts\Presenter\Presenter;
use Jenssegers\Agent\Agent;

class UsuarioLogPresenter extends Presenter
{

    public function iconeSistema()
    {
        $ite = [
            'Mac OS X' => 'apple',
            'OS X' => 'apple',
            'iOS' => 'apple',
            'Macintosh' => 'apple',
            'Windows' => 'windows',
            'Windows NT' => 'windows',
            'Linux' => 'linux',
            'Debian' => 'linux',
            'Ubuntu' => 'ubuntu',
            'AndroidOS' => 'android',
        ];

        if (key_exists($this->agent->platform(), $ite)) {
            return $ite[$this->agent->platform()];
        }
        
        return '';
    }
    
    public function iconeNavegador()
    {
        $ite = [
            'Opera Mini' => 'opera',
            'Opera' => 'opera',
            'Edge' => 'edge',
            'IE' => 'internet-explorer',
            'Chrome' => 'chrome',
            'Firefox' => 'firefox',
            'Mozilla' => 'firefox',
            'Safari' => 'safari',
        ];

        if (key_exists($this->agent->browser(), $ite)) {
            return $ite[$this->agent->browser()];
        }
        
        return '';
    }

    public function agent()
    {
        $agent = new Agent();
        $agent->setUserAgent($this->info);

        return $agent;
    }

    public function atual()
    {
//        if ($this->codigo == session()->get('usu_log_id')) {
//            return ' active';
//        }

        return '';
    }

    public function descricao()
    {
        if ($this->tipo == 1) {
            if ($this->situacao == 1) {
//                if ($this->codigo == session()->get('usu_log_id')) {
//                    return 'Sessão Atual';
//                }

                return 'Acesso realizado';
            }

            if ($this->situacao == 2) {
                return 'Tentativa de Login';
            }
        }

        if ($this->tipo == 2) {
            return 'Nova Senha Enviada';
        }

        return 'Saiu do sistema';
    }

    public function makeTipo()
    {
        $arr = [
            '1' => 'sign-in-alt',
            '2' => 'envelope',
            '3' => 'sign-out-alt',
        ];

        return $arr[$this->tipo];
    }

}
