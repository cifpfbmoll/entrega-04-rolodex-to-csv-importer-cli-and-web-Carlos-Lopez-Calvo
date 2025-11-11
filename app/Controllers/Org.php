<?php

namespace App\Controllers;

class Org extends BaseController
{
    public function index()
    {
        helper(['OrgHelper']);
        $user = session()->get('user');
        if (!$user) return redirect()->to('/login');
        $orgs = get_user_orgs($user['id']);
        $current = session()->get('org');
        return view('org/index', ['orgs' => $orgs, 'current' => $current]);
    }

    public function create()
    {
        helper(['OrgHelper']);
        $user = session()->get('user');
        if (!$user) return redirect()->to('/login');
        if ($this->request->getMethod() === 'post') {
            $name = trim($this->request->getPost('name') ?? '');
            if (strlen($name) < 3) {
                return redirect()->back()->with('error', 'Nombre mínimo 3 caracteres')->withInput();
            }
            $org = create_org($name, $user['id']);
            session()->set('org', $org);
            return redirect()->to('/org')->with('success', 'Organización creada');
        }
        return view('org/create');
    }

    public function select($orgId)
    {
        helper(['OrgHelper']);
        $user = session()->get('user');
        if (!$user) return redirect()->to('/login');
        $orgs = get_user_orgs($user['id']);
        foreach ($orgs as $o) {
            if ($o['id'] === $orgId) {
                session()->set('org', ['id' => $o['id'], 'name' => $o['name']]);
                return redirect()->to('/org')->with('success', 'Organización seleccionada');
            }
        }
        return redirect()->to('/org')->with('error', 'No perteneces a esta organización');
    }

    public function clear()
    {
        session()->remove('org');
        return redirect()->to('/org')->with('success', 'Has salido del contexto de organización');
    }
}


