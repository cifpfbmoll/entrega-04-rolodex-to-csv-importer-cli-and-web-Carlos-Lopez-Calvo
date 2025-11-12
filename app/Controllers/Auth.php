<?php

namespace App\Controllers;

class Auth extends BaseController
{
    private string $usersFile;

    public function __construct()
    {
        $this->usersFile = WRITEPATH . 'users.json';
        if (!is_dir(dirname($this->usersFile))) {
            mkdir(dirname($this->usersFile), 0755, true);
        }
        if (!is_file($this->usersFile)) {
            file_put_contents($this->usersFile, json_encode([]));
        }
    }

    public function login()
    {
        // Verificar si es POST
        $method = $this->request->getMethod();
        
        if (strtolower($method) === 'post') {
            $email = strtolower(trim($this->request->getPost('email') ?? ''));
            $password = (string) ($this->request->getPost('password') ?? '');

            if (empty($email) || empty($password)) {
                return redirect()->back()->with('error', 'Email y contraseña requeridos')->withInput();
            }

            $user = $this->findUserByEmail($email);
            if (!$user || !password_verify($password, $user['password'])) {
                return redirect()->back()->with('error', 'Credenciales inválidas')->withInput();
            }

            // Usuario autenticado correctamente
            session()->set('user', [
                'id' => $user['id'],
                'email' => $user['email'],
                'name' => $user['name'] ?? ''
            ]);
            
            // Guardar flashdata
            session()->setFlashdata('success', 'Bienvenido de nuevo');
            
            // Redirect usando el método de CodeIgniter
            return redirect()->to('/contacts');
        }

        // Si no es POST, mostrar el formulario
        return view('auth/login');
    }

    public function register()
    {
        // Verificar si es POST
        $method = $this->request->getMethod();
        
        if (strtolower($method) === 'post') {
            $name = trim($this->request->getPost('name') ?? '');
            $email = strtolower(trim($this->request->getPost('email') ?? ''));
            $password = (string) ($this->request->getPost('password') ?? '');
            $passwordConfirm = (string) ($this->request->getPost('password_confirm') ?? '');

            if (strlen($name) < 3) {
                return redirect()->back()->with('error', 'Nombre mínimo 3 caracteres')->withInput();
            }
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return redirect()->back()->with('error', 'Email inválido')->withInput();
            }
            if (strlen($password) < 6) {
                return redirect()->back()->with('error', 'Contraseña mínimo 6 caracteres')->withInput();
            }
            if ($password !== $passwordConfirm) {
                return redirect()->back()->with('error', 'Las contraseñas no coinciden')->withInput();
            }
            if ($this->findUserByEmail($email)) {
                return redirect()->back()->with('error', 'El email ya está registrado')->withInput();
            }

            $users = $this->readUsers();
            $id = bin2hex(random_bytes(8));
            $users[] = [
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'createdAt' => date('c'),
            ];
            $this->writeUsers($users);

            // crear carpeta de usuario para CSV
            $userDir = WRITEPATH . 'users/' . $id;
            if (!is_dir($userDir)) {
                mkdir($userDir, 0755, true);
            }
            $csv = $userDir . '/contacts.csv';
            if (!is_file($csv)) {
                $h = fopen($csv, 'w');
                if ($h) {
                    fputcsv($h, ['Name', 'Phone', 'Email']);
                    fclose($h);
                }
            }

            session()->set('user', [
                'id' => $id,
                'email' => $email,
                'name' => $name
            ]);
            
            // Guardar flashdata
            session()->setFlashdata('success', 'Registro completado');
            
            // Redirect usando el método de CodeIgniter
            return redirect()->to('/contacts');
        }

        return view('auth/register');
    }

    public function logout()
    {
        session()->remove('user');
        return redirect()->to('/login')->with('success', 'Sesión cerrada');
    }

    private function readUsers(): array
    {
        $raw = file_get_contents($this->usersFile);
        $data = json_decode($raw ?: '[]', true);
        return is_array($data) ? $data : [];
    }

    private function writeUsers(array $users): void
    {
        file_put_contents($this->usersFile, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    private function findUserByEmail(string $email): ?array
    {
        $users = $this->readUsers();
        foreach ($users as $u) {
            if (($u['email'] ?? '') === $email) {
                return $u;
            }
        }
        return null;
    }
}


