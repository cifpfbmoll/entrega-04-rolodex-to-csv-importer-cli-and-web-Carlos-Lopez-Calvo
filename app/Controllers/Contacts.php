<?php

namespace App\Controllers;


class Contacts extends BaseController
{
    // 📋 Mostrar todos los contactos
    public function index()
    {
        helper('ContactHelper');
        
        // Búsqueda
        $search = $this->request->getGet('search');
        $contacts = !empty($search) ? searchContacts($search) : readContactsFromCsv();
        
        // Reindexar para mantener índices correctos
        $contacts = array_values($contacts);
        
        return view('contacts/index', [
            'contacts' => $contacts,
            'search' => $search ?? ''
        ]);
    }
    
    // ➕ Formulario para añadir contacto
    public function create()
    {
        return view('contacts/create');
    }
    
    // 💾 Guardar nuevo contacto
    public function store()
    {
        helper('ContactHelper');
        
        // Validar datos simples
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        
        if (empty(trim($name))) {
            return redirect()->back()->with('error', 'El nombre es requerido')->withInput();
        }
        
        // Validar email si se proporciona
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Email inválido')->withInput();
        }
        
        // Añadir al CSV
        if (addContactToCsv($name, $phone, $email)) {
            return redirect()->to('/contacts')->with('success', '¡Contacto añadido correctamente!');
        } else {
            return redirect()->back()->with('error', 'Error al guardar el contacto')->withInput();
        }
    }
    
    // ✏️ Mostrar formulario de edición
    public function edit($index)
    {
        helper('ContactHelper');
        
        $contacts = readContactsFromCsv();
        
        if (!isset($contacts[$index])) {
            return redirect()->to('/contacts')->with('error', 'Contacto no encontrado');
        }
        
        return view('contacts/edit', [
            'contact' => $contacts[$index],
            'index' => $index
        ]);
    }
    
    // 💾 Actualizar contacto
    public function update($index)
    {
        helper('ContactHelper');
        
        // Validar datos
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        
        if (empty(trim($name))) {
            return redirect()->back()->with('error', 'El nombre es requerido')->withInput();
        }
        
        // Validar email si se proporciona
        if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Email inválido')->withInput();
        }
        
        // Actualizar contacto
        if (updateContactInCsv($index, $name, $phone, $email)) {
            return redirect()->to('/contacts')->with('success', '¡Contacto actualizado correctamente!');
        } else {
            return redirect()->back()->with('error', 'Error al actualizar el contacto')->withInput();
        }
    }
    
    // 🗑️ Eliminar contacto
    public function delete($index)
    {
        helper('ContactHelper');
        
        if (deleteContactFromCsv($index)) {
            return redirect()->to('/contacts')->with('success', '¡Contacto eliminado correctamente!');
        } else {
            return redirect()->to('/contacts')->with('error', 'Error al eliminar el contacto');
        }
    }
    
    // 📥 Importar contactos desde CSV
    public function import()
    {
        helper('ContactHelper');
        
        $file = $this->request->getFile('csv_file');
        
        if (!$file || !$file->isValid()) {
            return redirect()->back()->with('error', 'Por favor selecciona un archivo CSV válido');
        }
        
        if ($file->getExtension() !== 'csv') {
            return redirect()->back()->with('error', 'El archivo debe ser un CSV');
        }
        
        $imported = 0;
        $errors = 0;
        
        $handle = fopen($file->getTempName(), 'r');
        if ($handle) {
            // Saltar cabecera
            $header = fgetcsv($handle);
            
            while (($row = fgetcsv($handle)) !== false) {
                $name = $row[0] ?? '';
                $phone = $row[1] ?? '';
                $email = $row[2] ?? '';
                
                if (!empty(trim($name))) {
                    if (addContactToCsv($name, $phone, $email)) {
                        $imported++;
                    } else {
                        $errors++;
                    }
                }
            }
            fclose($handle);
        }
        
        $message = "Importación completada: {$imported} contactos importados";
        if ($errors > 0) {
            $message .= ", {$errors} errores";
        }
        
        return redirect()->to('/contacts')->with('success', $message);
    }
    
    // 📥 Exportar a CSV
    public function export()
    {
        helper('ContactHelper');
        $user = session()->get('user');
        $csvFile = $user ? (WRITEPATH . 'users/' . $user['id'] . '/contacts.csv') : (WRITEPATH . 'contacts.csv');

        if (!file_exists($csvFile)) {
            return redirect()->to('/contacts')->with('error', 'No hay contactos para exportar');
        }
        
        // Descargar el archivo
        return $this->response->download($csvFile, null);
    }
    
    // 📥 Exportar a vCard
    public function exportVcard()
    {
        helper('ContactHelper');
        // Plan gate
        if ((session()->get('plan') ?? 'free') !== 'premium') {
            return redirect()->to('/settings')->with('error', 'Requiere plan Premium');
        }
        
        $contacts = readContactsFromCsv();
        
        if (empty($contacts)) {
            return redirect()->to('/contacts')->with('error', 'No hay contactos para exportar');
        }
        
        $vcard = "";
        
        foreach ($contacts as $contact) {
            $vcard .= "BEGIN:VCARD\n";
            $vcard .= "VERSION:3.0\n";
            $vcard .= "FN:" . str_replace(["\n", "\r"], '', $contact['name']) . "\n";
            if (!empty($contact['phone'])) {
                $vcard .= "TEL:" . str_replace(["\n", "\r", " ", "-", "(", ")"], '', $contact['phone']) . "\n";
            }
            if (!empty($contact['email'])) {
                $vcard .= "EMAIL:" . str_replace(["\n", "\r"], '', $contact['email']) . "\n";
            }
            $vcard .= "END:VCARD\n";
        }
        
        return $this->response
            ->setHeader('Content-Type', 'text/vcard')
            ->setHeader('Content-Disposition', 'attachment; filename="contacts.vcf"')
            ->setBody($vcard);
    }
    
    // 📥 Exportar a PDF (básico)
    public function exportPdf()
    {
        helper('ContactHelper');
        if ((session()->get('plan') ?? 'free') !== 'premium') {
            return redirect()->to('/settings')->with('error', 'Requiere plan Premium');
        }
        
        $contacts = readContactsFromCsv();
        
        if (empty($contacts)) {
            return redirect()->to('/contacts')->with('error', 'No hay contactos para exportar');
        }
        
        // Generar HTML simple para PDF
        $html = "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Contactos</title>";
        $html .= "<style>body{font-family:Arial;margin:20px;}table{border-collapse:collapse;width:100%;}";
        $html .= "th,td{border:1px solid #ddd;padding:8px;text-align:left;}th{background-color:#667eea;color:white;}</style></head><body>";
        $html .= "<h1>Lista de Contactos</h1><table><tr><th>Nombre</th><th>Teléfono</th><th>Email</th></tr>";
        
        foreach ($contacts as $contact) {
            $html .= "<tr>";
            $html .= "<td>" . htmlspecialchars($contact['name']) . "</td>";
            $html .= "<td>" . htmlspecialchars($contact['phone']) . "</td>";
            $html .= "<td>" . htmlspecialchars($contact['email']) . "</td>";
            $html .= "</tr>";
        }
        
        $html .= "</table></body></html>";
        
        // Retornar HTML (el navegador puede convertirlo a PDF)
        return $this->response
            ->setHeader('Content-Type', 'text/html')
            ->setHeader('Content-Disposition', 'attachment; filename="contacts.html"')
            ->setBody($html);
    }
}
