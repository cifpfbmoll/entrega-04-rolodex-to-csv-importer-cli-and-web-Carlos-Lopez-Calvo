<?php

if (!function_exists('ai_normalize_string')) {
    function ai_normalize_string(string $text): string
    {
        $text = strtolower(trim($text));
        $text = preg_replace('/\s+/', ' ', $text);
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        return $text ?? '';
    }
}

if (!function_exists('ai_normalize_phone')) {
    function ai_normalize_phone(string $phone): string
    {
        return preg_replace('/\D+/', '', $phone);
    }
}

if (!function_exists('ai_categorize_contact')) {
    /**
     * Categoriza por reglas simples (dominio, keywords en nombre/email).
     */
    function ai_categorize_contact(array $contact): array
    {
        $tags = [];
        $name = ai_normalize_string($contact['name'] ?? '');
        $email = strtolower($contact['email'] ?? '');
        $domain = '';
        if (strpos($email, '@') !== false) {
            [$local, $domain] = explode('@', $email, 2);
        }
        // Por dominio
        if ($domain) {
            if (preg_match('/(gmail|yahoo|outlook|hotmail)\./', $domain)) {
                $tags[] = 'personal';
            } else {
                $tags[] = 'corporativo';
            }
        }
        // Por industria básica
        $industryRules = [
            'travel' => ['viaje', 'travel', 'turismo', 'agent'],
            'finance' => ['bank', 'financ', 'conta'],
            'health' => ['clinic', 'health', 'salud', 'medic'],
            'tech' => ['tech', 'software', 'dev', 'it', 'cloud'],
            'sales' => ['sales', 'ventas', 'comercial'],
        ];
        foreach ($industryRules as $tag => $keywords) {
            foreach ($keywords as $kw) {
                if (strpos($name, $kw) !== false || strpos($email, $kw) !== false) {
                    $tags[] = $tag;
                    break;
                }
            }
        }
        return array_values(array_unique($tags));
    }
}

if (!function_exists('ai_find_duplicates')) {
    /**
     * Detecta duplicados por heurística de nombre/email/teléfono normalizados.
     */
    function ai_find_duplicates(array $contacts): array
    {
        $buckets = [
            'name' => [],
            'email' => [],
            'phone' => [],
        ];
        foreach ($contacts as $idx => $c) {
            $n = ai_normalize_string($c['name'] ?? '');
            $e = strtolower(trim($c['email'] ?? ''));
            $p = ai_normalize_phone($c['phone'] ?? '');
            if ($n) $buckets['name'][$n][] = $idx;
            if ($e) $buckets['email'][$e][] = $idx;
            if ($p) $buckets['phone'][$p][] = $idx;
        }
        $groups = [];
        foreach ($buckets as $type => $map) {
            foreach ($map as $key => $indexes) {
                if (count($indexes) > 1) {
                    $groups[] = [
                        'type' => $type,
                        'key' => $key,
                        'indexes' => $indexes,
                    ];
                }
            }
        }
        return $groups;
    }
}

if (!function_exists('ai_semantic_search')) {
    /**
     * Búsqueda "semántica" simple con sinónimos y stemming básico.
     */
    function ai_semantic_search(array $contacts, string $query): array
    {
        $q = ai_normalize_string($query);
        if ($q === '') return $contacts;
        $synonyms = [
            'phone' => ['tel', 'telefono', 'móvil', 'movil', 'cell', 'celular'],
            'email' => ['mail', 'correo', 'correo electronico', 'e-mail'],
            'company' => ['empresa', 'compañía', 'compania'],
            'travel' => ['viaje', 'turismo'],
            'sales' => ['ventas', 'comercial'],
        ];
        $expanded = [$q];
        foreach ($synonyms as $root => $alts) {
            if (strpos($q, $root) !== false || array_reduce($alts, fn($c,$a)=>$c||strpos($q,$a)!==false, false)) {
                $expanded = array_merge($expanded, [$root], $alts);
            }
        }
        $expanded = array_values(array_unique($expanded));
        return array_values(array_filter($contacts, function ($c) use ($expanded) {
            $hay = ai_normalize_string(($c['name'] ?? '') . ' ' . ($c['email'] ?? '') . ' ' . ($c['phone'] ?? ''));
            foreach ($expanded as $term) {
                if ($term !== '' && strpos($hay, $term) !== false) {
                    return true;
                }
            }
            return false;
        }));
    }
}

if (!function_exists('ai_parse_contact_from_text')) {
    /**
     * Extrae nombre, email y teléfono de texto libre (p.ej., OCR/copypega).
     */
    function ai_parse_contact_from_text(string $text): array
    {
        $name = '';
        $email = '';
        $phone = '';
        if (preg_match('/[A-ZÁÉÍÓÚÑ][A-Za-zÁÉÍÓÚÑ\\s\\-]{2,}/u', $text, $m)) {
            $name = trim($m[0]);
        }
        if (preg_match('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\\.[A-Z]{2,}/i', $text, $m)) {
            $email = $m[0];
        }
        if (preg_match('/(\\+?\\d[\\d\\s\\-()]{6,}\\d)/', $text, $m)) {
            $phone = preg_replace('/\\s+/', '-', trim($m[0]));
        }
        return ['name' => $name, 'email' => $email, 'phone' => $phone];
    }
}


