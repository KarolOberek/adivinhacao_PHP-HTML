<?php
session_start();
function num_aleatorio($min, $max) {
    return rand($min, $max);
}

if (!isset($_SESSION['aleatorio'])) { 
    $_SESSION['aleatorio'] = num_aleatorio(0, 10);
    $_SESSION['tentativas'] = 3;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $adivinhar = (int)$_POST['numero'];
    $aleatorio = $_SESSION['aleatorio'];
    $tentativas = $_SESSION['tentativas'];

    if ($adivinhar == $aleatorio) {
        $message = "Acertou :) o número era $aleatorio";
        session_destroy();
    } else {
        $_SESSION['tentativas']--;
        $tentativas--;

        if ($tentativas <= 0) {
            $message = "Acabaram suas tentativas! O número era $aleatorio. Outro número aleatório foi gerado! Comece novemente :D";
            $_SESSION['aleatorio'] = num_aleatorio(0, 10);
            $_SESSION['tentativas'] = 3;
        } else {
           
            if ($adivinhar >= $aleatorio + 3 || $adivinhar <= $aleatorio - 3) {
                $message .= "Frio!\n";
                $message = "Tente novamente! Mais $tentativas tentativas. ";
            } else {
                $message .= "Quente!\n";
                $message = "Tente novamente! Mais $tentativas tentativas. ";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jogo de Adivinhação</title>
    <style>
        body {
            font-family: VerVerdana, Geneva, Tahoma, sans-serif ;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #e4e1e1;
        }
        .container {
            text-align: center;
            background: #ffffff;
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        input[type="number"] {
            width: 60px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Adivinhe o número</h1>
    <form action="logic.php" method="post">
        <label for="numero">Digite um número entre 0 e 10:<br><br></label>
        <input type="number" id="numero" name="numero" min="0" max="10" required>
        <button type="submit">Enviar</button>
    </form>
    <?php
    if ($message != "") {
        echo "<p>" . htmlspecialchars($message) . "</p>";
    }
    ?>
    </div>
</body>
</html>
