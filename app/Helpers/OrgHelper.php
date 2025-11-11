<?php

if (!function_exists('orgs_storage_path')) {
    function orgs_storage_path(): string
    {
        return WRITEPATH . 'orgs.json';
    }
}

if (!function_exists('read_orgs')) {
    function read_orgs(): array
    {
        $file = orgs_storage_path();
        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0755, true);
        }
        if (!is_file($file)) {
            file_put_contents($file, json_encode(['orgs' => [], 'memberships' => []], JSON_PRETTY_PRINT));
        }
        $raw = file_get_contents($file);
        $data = json_decode($raw ?: '{}', true);
        return is_array($data) ? $data : ['orgs' => [], 'memberships' => []];
    }
}

if (!function_exists('write_orgs')) {
    function write_orgs(array $data): void
    {
        file_put_contents(orgs_storage_path(), json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

if (!function_exists('create_org')) {
    function create_org(string $name, string $ownerUserId): array
    {
        $data = read_orgs();
        $id = bin2hex(random_bytes(6));
        $data['orgs'][] = ['id' => $id, 'name' => $name, 'ownerId' => $ownerUserId, 'createdAt' => date('c')];
        $data['memberships'][] = ['orgId' => $id, 'userId' => $ownerUserId, 'role' => 'owner'];
        write_orgs($data);
        // Ensure CSV file
        $orgDir = WRITEPATH . 'orgs/' . $id;
        if (!is_dir($orgDir)) {
            mkdir($orgDir, 0755, true);
        }
        $csv = $orgDir . '/contacts.csv';
        if (!is_file($csv)) {
            $h = fopen($csv, 'w');
            if ($h) {
                fputcsv($h, ['Name', 'Phone', 'Email']);
                fclose($h);
            }
        }
        return ['id' => $id, 'name' => $name];
    }
}

if (!function_exists('join_org')) {
    function join_org(string $orgId, string $userId, string $role = 'member'): bool
    {
        $data = read_orgs();
        foreach ($data['memberships'] as $m) {
            if ($m['orgId'] === $orgId && $m['userId'] === $userId) {
                return true;
            }
        }
        $data['memberships'][] = ['orgId' => $orgId, 'userId' => $userId, 'role' => $role];
        write_orgs($data);
        return true;
    }
}

if (!function_exists('leave_org')) {
    function leave_org(string $orgId, string $userId): bool
    {
        $data = read_orgs();
        $data['memberships'] = array_values(array_filter($data['memberships'], fn($m) => !($m['orgId'] === $orgId && $m['userId'] === $userId)));
        write_orgs($data);
        return true;
    }
}

if (!function_exists('get_user_orgs')) {
    function get_user_orgs(string $userId): array
    {
        $data = read_orgs();
        $orgs = [];
        foreach ($data['memberships'] as $m) {
            if ($m['userId'] === $userId) {
                foreach ($data['orgs'] as $o) {
                    if ($o['id'] === $m['orgId']) {
                        $orgs[] = $o + ['role' => $m['role']];
                    }
                }
            }
        }
        return $orgs;
    }
}


