<?php
if (empty($_SESSION['user'])) {
    header('Location: /signin');
    exit;
}

require __DIR__ . '/../../config/database.php';

$userId = (int)$_SESSION['user']['id'];
$profileErrors = [
    'firstname' => '',
    'lastname' => '',
    'email' => ''
];
$passwordErrors = [
    'password' => '',
    'confirm' => ''
];
$profileSuccess = '';
$passwordSuccess = '';

$profile = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'phone' => '',
    'birthdate' => '',
    'postal' => '',
    'town' => '',
    'address' => '',
    'country' => ''
];

$stmt = $pdo->prepare('SELECT firstname, lastname, email, phone, birthdate, postal, town, address, country FROM users WHERE id = :id LIMIT 1');
$stmt->execute(['id' => $userId]);
$row = $stmt->fetch();
if ($row) {
    $profile = [
        'firstname' => $row['firstname'] ?? '',
        'lastname' => $row['lastname'] ?? '',
        'email' => $row['email'] ?? '',
        'phone' => $row['phone'] ?? '',
        'birthdate' => $row['birthdate'] ?? '',
        'postal' => $row['postal'] ?? '',
        'town' => $row['town'] ?? '',
        'address' => $row['address'] ?? '',
        'country' => $row['country'] ?? ''
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'profile') {
        $profile['firstname'] = trim($_POST['firstname'] ?? '');
        $profile['lastname'] = trim($_POST['lastname'] ?? '');
        $profile['email'] = trim($_POST['email'] ?? '');
        $profile['phone'] = trim($_POST['phone'] ?? '');
        $profile['birthdate'] = trim($_POST['birthdate'] ?? '');
        $profile['postal'] = trim($_POST['postal'] ?? '');
        $profile['town'] = trim($_POST['town'] ?? '');
        $profile['address'] = trim($_POST['address'] ?? '');
        $profile['country'] = trim($_POST['country'] ?? '');

        if ($profile['firstname'] === '') {
            $profileErrors['firstname'] = "Le prÃ©nom est requis.";
        }
        if ($profile['lastname'] === '') {
            $profileErrors['lastname'] = "Le nom est requis.";
        }
        if ($profile['email'] === '') {
            $profileErrors['email'] = "L'email est requis.";
        } elseif (!filter_var($profile['email'], FILTER_VALIDATE_EMAIL)) {
            $profileErrors['email'] = "L'email n'est pas valide.";
        }

        $hasErrors = false;
        foreach ($profileErrors as $message) {
            if ($message !== '') {
                $hasErrors = true;
                break;
            }
        }

        if (!$hasErrors && $row && $profile['email'] !== $row['email']) {
            $check = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
            $check->execute(['email' => $profile['email']]);
            $existing = $check->fetch();
            if ($existing) {
                $profileErrors['email'] = "Un utilisateur existe dÃ©jÃ  avec cet email.";
                $hasErrors = true;
            }
        }

        if (!$hasErrors) {
            $update = $pdo->prepare(
                'UPDATE users
                 SET firstname = :firstname, lastname = :lastname, email = :email, phone = :phone,
                     birthdate = :birthdate, postal = :postal, town = :town, address = :address, country = :country
                 WHERE id = :id'
            );
            $update->execute([
                'firstname' => $profile['firstname'],
                'lastname' => $profile['lastname'],
                'email' => $profile['email'],
                'phone' => $profile['phone'],
                'birthdate' => $profile['birthdate'] !== '' ? $profile['birthdate'] : null,
                'postal' => $profile['postal'],
                'town' => $profile['town'],
                'address' => $profile['address'],
                'country' => $profile['country'],
                'id' => $userId
            ]);

            $_SESSION['user']['firstname'] = $profile['firstname'];
            $_SESSION['user']['lastname'] = $profile['lastname'];
            $_SESSION['user']['email'] = $profile['email'];
            $profileSuccess = "Modifications enregistrées.";
        }
    }

    if ($action === 'password') {
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['confirm'] ?? '';

        if ($password === '') {
            $passwordErrors['password'] = "Le mot de passe est requis.";
        }
        if ($confirm === '') {
            $passwordErrors['confirm'] = "Veuillez confirmer votre mot de passe.";
        } elseif ($password !== '' && $password !== $confirm) {
            $passwordErrors['confirm'] = "Les mots de passe ne correspondent pas.";
        }

        $hasErrors = false;
        foreach ($passwordErrors as $message) {
            if ($message !== '') {
                $hasErrors = true;
                break;
            }
        }

        if (!$hasErrors) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $update = $pdo->prepare('UPDATE users SET password_hash = :hash WHERE id = :id');
            $update->execute(['hash' => $hash, 'id' => $userId]);
            $passwordSuccess = "Modifications enregistrées.";
        }
    }
}

require __DIR__ . '/../Views/profile.php';
