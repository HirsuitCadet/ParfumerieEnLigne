<?php
if (!empty($_SESSION['user'])) {
    header('Location: /');
    exit;
}

$errors = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'phone' => '',
    'birthdate' => '',
    'postal' => '',
    'town' => '',
    'address' => '',
    'country' => '',
    'password' => '',
    'confirm' => '',
    'terms' => ''
];

$old = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'phone' => '',
    'birthdate' => '',
    'postal' => '',
    'town' => '',
    'address' => '',
    'country' => '',
    'terms' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['firstname'] = trim($_POST['firstname'] ?? '');
    $old['lastname'] = trim($_POST['lastname'] ?? '');
    $old['email'] = trim($_POST['email'] ?? '');
    $old['phone'] = trim($_POST['phone'] ?? '');
    $old['birthdate'] = trim($_POST['birthdate'] ?? '');
    $old['postal'] = trim($_POST['postal'] ?? '');
    $old['town'] = trim($_POST['town'] ?? '');
    $old['address'] = trim($_POST['address'] ?? '');
    $old['country'] = trim($_POST['country'] ?? '');

    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';
    $terms = $_POST['terms'] ?? '';
    $old['terms'] = $terms;

    if ($old['email'] === '') {
        $errors['email'] = "L'email est requis.";
    } elseif (!filter_var($old['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }

    if ($password === '') {
        $errors['password'] = "Le mot de passe est requis.";
    }

    if ($confirm === '') {
        $errors['confirm'] = "Veuillez confirmer votre mot de passe.";
    } elseif ($password !== '' && $password !== $confirm) {
        $errors['confirm'] = "Les mots de passe ne correspondent pas.";
    }

    if ($terms !== 'on') {
        $errors['terms'] = "Veuillez accepter nos conditions et notre politique de confidentialité.";
    }

    $hasErrors = false;
    foreach ($errors as $message) {
        if ($message !== '') {
            $hasErrors = true;
            break;
        }
    }

    if (!$hasErrors) {
        require __DIR__ . '/../../config/database.php';

        $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $old['email']]);
        if ($stmt->fetch()) {
            $errors['email'] = "Un utilisateur existe déjà avec cet email.";
            $hasErrors = true;
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $insert = $pdo->prepare(
                'INSERT INTO users (firstname, lastname, email, phone, birthdate, postal, town, address, country, password_hash)
                 VALUES (:firstname, :lastname, :email, :phone, :birthdate, :postal, :town, :address, :country, :password_hash)'
            );

            $insert->execute([
                'firstname' => $old['firstname'],
                'lastname' => $old['lastname'],
                'email' => $old['email'],
                'phone' => $old['phone'],
                'birthdate' => $old['birthdate'] !== '' ? $old['birthdate'] : null,
                'postal' => $old['postal'],
                'town' => $old['town'],
                'address' => $old['address'],
                'country' => $old['country'],
                'password_hash' => $hash
            ]);

            $userId = (int)$pdo->lastInsertId();
            $_SESSION['user'] = [
                'id' => $userId,
                'firstname' => $old['firstname'],
                'lastname' => $old['lastname'],
                'email' => $old['email']
            ];
            header('Location: /');
            exit;
        }
    }
}

require __DIR__ . '/../Views/signup.php';
