<?php

namespace App\Controllers;

class AI extends BaseController
{
    public function duplicates()
    {
        helper(['ContactHelper', 'AIHelper']);
        if ((session()->get('plan') ?? 'free') !== 'premium') {
            return redirect()->to('/settings')->with('error', 'Requiere plan Premium');
        }
        $contacts = readContactsFromCsv();
        $groups = ai_find_duplicates($contacts);
        return view('ai/duplicates', ['contacts' => $contacts, 'groups' => $groups]);
    }

    public function parse()
    {
        helper(['AIHelper']);
        if ((session()->get('plan') ?? 'free') !== 'premium') {
            return redirect()->to('/settings')->with('error', 'Requiere plan Premium');
        }
        $result = null;
        if ($this->request->getMethod() === 'post') {
            $text = (string) ($this->request->getPost('text') ?? '');
            $result = ai_parse_contact_from_text($text);
        }
        return view('ai/parse', ['result' => $result]);
    }
}


