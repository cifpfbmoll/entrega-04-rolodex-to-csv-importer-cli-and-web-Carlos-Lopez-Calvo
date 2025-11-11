<?php

if (!function_exists('readContactsFromCsv')) {
    /**
     * Lee todos los contactos del archivo CSV
     * @return array Array de contactos con índice
     */
    function readContactsFromCsv(): array
    {
        $user = session()->get('user');
        $org = session()->get('org'); // if user selected an organization, use shared CSV
        if ($user && $org && !empty($org['id'])) {
            $csvFile = WRITEPATH . 'orgs/' . $org['id'] . '/contacts.csv';
        } else {
            $csvFile = $user ? (WRITEPATH . 'users/' . $user['id'] . '/contacts.csv') : (WRITEPATH . 'contacts.csv');
        }
        $contacts = [];
        
        if (file_exists($csvFile)) {
            $handle = fopen($csvFile, 'r');
            if ($handle) {
                // Saltar la cabecera
                fgetcsv($handle);
                
                $index = 0;
                // Leer todos los contactos
                while (($row = fgetcsv($handle)) !== false) {
                    $contacts[] = [
                        'index' => $index++,
                        'name' => $row[0] ?? '',
                        'phone' => $row[1] ?? '',
                        'email' => $row[2] ?? ''
                    ];
                }
                fclose($handle);
            }
        }
        
        return $contacts;
    }
}

if (!function_exists('writeContactsToCsv')) {
    /**
     * Escribe todos los contactos al archivo CSV
     * @param array $contacts Array de contactos
     * @return bool
     */
    function writeContactsToCsv(array $contacts): bool
    {
        $user = session()->get('user');
        $org = session()->get('org');
        if ($user && $org && !empty($org['id'])) {
            $csvFile = WRITEPATH . 'orgs/' . $org['id'] . '/contacts.csv';
        } else {
            $csvFile = $user ? (WRITEPATH . 'users/' . $user['id'] . '/contacts.csv') : (WRITEPATH . 'contacts.csv');
        }
        
        // Crear directorio si no existe
        $directory = dirname($csvFile);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $handle = fopen($csvFile, 'w');
        if ($handle === false) {
            return false;
        }
        
        // Escribir cabecera
        fputcsv($handle, ['Name', 'Phone', 'Email']);
        
        // Escribir contactos
        foreach ($contacts as $contact) {
            fputcsv($handle, [
                $contact['name'] ?? '',
                $contact['phone'] ?? '',
                $contact['email'] ?? ''
            ]);
        }
        
        fclose($handle);
        return true;
    }
}

if (!function_exists('addContactToCsv')) {
    /**
     * Añade un nuevo contacto al CSV
     * @param string $name
     * @param string $phone
     * @param string $email
     * @return bool
     */
    function addContactToCsv(string $name, string $phone, string $email): bool
    {
        $user = session()->get('user');
        $org = session()->get('org');
        if ($user && $org && !empty($org['id'])) {
            $csvFile = WRITEPATH . 'orgs/' . $org['id'] . '/contacts.csv';
        } else {
            $csvFile = $user ? (WRITEPATH . 'users/' . $user['id'] . '/contacts.csv') : (WRITEPATH . 'contacts.csv');
        }
        
        // Crear archivo si no existe
        if (!file_exists($csvFile)) {
            $directory = dirname($csvFile);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            $handle = fopen($csvFile, 'w');
            if ($handle !== false) {
                fputcsv($handle, ['Name', 'Phone', 'Email']);
                fclose($handle);
            }
        }
        
        // Añadir nuevo contacto
        $handle = fopen($csvFile, 'a');
        if ($handle === false) {
            return false;
        }
        
        fputcsv($handle, [trim($name), trim($phone), trim($email)]);
        fclose($handle);
        
        return true;
    }
}

if (!function_exists('deleteContactFromCsv')) {
    /**
     * Elimina un contacto del CSV por índice
     * @param int $index
     * @return bool
     */
    function deleteContactFromCsv(int $index): bool
    {
        $contacts = readContactsFromCsv();
        
        if (!isset($contacts[$index])) {
            return false;
        }
        
        // Eliminar el contacto
        unset($contacts[$index]);
        
        // Reindexar array
        $contacts = array_values($contacts);
        
        return writeContactsToCsv($contacts);
    }
}

if (!function_exists('updateContactInCsv')) {
    /**
     * Actualiza un contacto en el CSV por índice
     * @param int $index
     * @param string $name
     * @param string $phone
     * @param string $email
     * @return bool
     */
    function updateContactInCsv(int $index, string $name, string $phone, string $email): bool
    {
        $contacts = readContactsFromCsv();
        
        if (!isset($contacts[$index])) {
            return false;
        }
        
        // Actualizar el contacto
        $contacts[$index]['name'] = trim($name);
        $contacts[$index]['phone'] = trim($phone);
        $contacts[$index]['email'] = trim($email);
        
        return writeContactsToCsv($contacts);
    }
}

if (!function_exists('searchContacts')) {
    /**
     * Busca contactos por término
     * @param string $searchTerm
     * @return array
     */
    function searchContacts(string $searchTerm): array
    {
        $contacts = readContactsFromCsv();
        $searchTerm = strtolower(trim($searchTerm));
        
        if (empty($searchTerm)) {
            return $contacts;
        }
        
        return array_filter($contacts, function($contact) use ($searchTerm) {
            return strpos(strtolower($contact['name']), $searchTerm) !== false
                || strpos(strtolower($contact['phone']), $searchTerm) !== false
                || strpos(strtolower($contact['email']), $searchTerm) !== false;
        });
    }
}

