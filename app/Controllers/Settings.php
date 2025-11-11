<?php

namespace App\Controllers;

class Settings extends BaseController
{
    public function index()
    {
        $user = session()->get('user');
        if (!$user) return redirect()->to('/login');
        $lang = session()->get('lang') ?? 'es';
        $plan = session()->get('plan') ?? 'free'; // free | premium
        return view('settings/index', ['lang' => $lang, 'plan' => $plan]);
    }

    public function update()
    {
        $user = session()->get('user');
        if (!$user) return redirect()->to('/login');
        $lang = $this->request->getPost('lang') ?? 'es';
        $plan = $this->request->getPost('plan') ?? 'free';
        session()->set('lang', in_array($lang, ['es','en']) ? $lang : 'es');
        session()->set('plan', in_array($plan, ['free','premium']) ? $plan : 'free');
        return redirect()->to('/settings')->with('success', 'Configuración actualizada');
    }
}


