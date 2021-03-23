<?php
include 'dati_anag_db.php';
?>
<html lang="en">

<head>
    <title>Esercizio</title>
</head>

<body>
    <?php

    require 'vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('B1', 'Nome');
    $sheet->setCellValue('C1', 'Cognome');
    $sheet->setCellValue('D1', 'Data di nascita');
    $sheet->setCellValue('E1', 'Luogo di nascita');
    $sheet->setCellValue('F1', 'Codice fiscale');
    $sheet->setCellValue('G1', 'Email');
    $sheet->setCellValue('H1', 'Tel/Cel');
    $sheet->setCellValue('I1', 'Indirizzo');
    $sheet->setCellValue('J1', 'Civico');
    $sheet->setCellValue('K1', 'Città');
    $sheet->setCellValue('L1', 'CAP');



    $writer = new Xlsx($spreadsheet);
    $writer->save('lista_anag.xlsx');

    //scaricare i dati inseriti
    if($_POST['save']){

    }

    // define variables and set to empty values

    

    //if cycle
   // var_dump($_POST);
   // var_dump($_SERVER["REQUEST_METHOD"]);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //nome
        if (empty($_POST["nome"])) {
            $nome_err = "Nome obligatorio.";
        } else {
            $nome = ($_POST["nome"]);
        }

        //cognome
        if (empty($_POST["cognome"])) {
            $cog_err = "Cognome obligatorio.";
        } else {
            $cognome = ($_POST["cognome"]);
        }

        //data di nascita
        if (empty($_POST["data_di_nascita"])) {
            $data_err = "Data di nascita obligatoria.";
        } else {
            $data_di_nascita = ($_POST["data_di_nascita"]);
        }

        //luogo di nascita
        if (empty($_POST["luogo_di_nascita"])) {
            $luogo_err = "Luogo di nascita obligatorio";
        } else {
            $luogo_di_nascita = ($_POST["luogo_di_nascita"]);
        }
        //codice fiscale
        if (empty($_POST["cf"])) {
            $cf_error = "Codice fiscale obligatorio.";
        } else {
            $cf = ($_POST["cf"]);
        }
        //email
        if (empty($_POST["email"])) {
            $email_err = "Email is required.";
        } else {
            $email = ($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email format";
            }
        }
        //tel/cel
        if (empty($_POST["telcel"])) {
            $telcel_err = "Numero di telefono/cellulare è richiesto.";
        } else {
            $telcel = ($_POST["telcel"]);
        }
        //indirizzo
        if (empty($_POST["indirizzo"])) {
            $ind_err = "indirizzo obligatorio";
        } else {
            $indirizzo = ($_POST["indirizzo"]);
        }
        //civico
        if (empty($_POST["civico"])) {
            $civico_err = "Il numero civico della residenza è richiesto.";
        } else {
            $civico = ($_POST["civico"]);
        }
        //citta
        if (empty($_POST["citta"])) {
            $citta_err = "Città è ogligatorio.";
        } else {
            $citta = ($_POST["citta"]);
        }
        //CAP
        if (empty($_POST["cap"])) {
            $cap_err = "Il cap è ogligatorio.";
        } else {
            $cap = ($_POST["cap"]);
        }
        $dati = [$nome, $cognome, $data_di_nascita, $luogo_di_nascita, $cf, $email, $telcel, $indirizzo, $civico, $citta, $cap];

        //get data from the existing file
        $json_get_data =  file_get_contents('lista.json');

        //converts json into an array
        $json_decode_data = json_decode($json_get_data, true);

        //push input data into array

        $json_decode_data[] = $dati;

        $json_data = json_encode($json_decode_data);
        file_put_contents('lista.json', $json_data);

        //sql insert table
        $dati_anag_table = "INSERT INTO dati_anagrafici (nome, cognome, data_di_nascita, luogo_di_nascita, codice_fiscale, email, telcel, indirizzo, civico, citta, cap)
        VALUES ('$nome', '$cognome', '$data_di_nascita', '$luogo_di_nascita', '$cf', '$email', '$telcel', '$indirizzo', '$civico', '$citta' ,'$cap')";

        if ($conn->query($dati_anag_table) === TRUE) {
            echo "Dati inviati con successo.";
        } else {
            echo "Error: " . $dati_anag_table . "<br>" . $conn->error;
        }

        $conn->close();
    }


    $json_get_data =  file_get_contents('lista.json');

    //converts json into an array
    $json_decode_data = json_decode($json_get_data, true);

    if (!empty($json_decode_data)) {
        foreach ($dati as $dati_xls) {

        }
    }

    ?>

    <div class="dati_anag">
        <form method="post">
            <h2>Inserisci i Dati anagrafici</h2>

            <br class="form_dati">
            <label>
                Nome: <input type="text" name="nome" pattern="[A-Za-z]{3,}" required value="<?php echo $nome; ?>">
            </label>
            <span class="error">* <?php echo $nome_err; ?></span>

            <label>
                Cognome: <input type="text" name="cognome" pattern="[A-Za-z]{3,}" required value="<?php echo $cognome; ?>">
            </label>
            <span class="error">* <?php echo $cog_err; ?></span>
            <br><br>
            <label>
                Data di nascita: <input type="date" name="data_di_nascita" required value="<?php echo $data_di_nascita; ?>">
            </label>
            <span class="error">* <?php echo $data_err; ?></span>
            <br><br>
            <label>
                Luogo di nascita: <input type="text" name="luogo_di_nascita" pattern="[A-Za-z0-9]{3,}" required value="<?php echo $luogo_di_nascita; ?>">
            </label>
            <span class="error">* <?php echo $luogo_err; ?></span>
            <br><br>

            <label>
                Codice fiscale: <input type="text" name="cf" pattern="[A-Za-z0-9]{16}" required value="<?php echo $cf; ?>">
            </label>
            <span class="error">* <?php echo $cf_err; ?></span>
            <br><br>
            Email: <label>
                <input type="email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required value="<?php echo $email ?>">
            </label>
            <span class="error">* <?php echo $email_err ?></span>
            <br><br>
            <label>
                Tel/Cel: <input type="text" name="telcel" pattern="[0-9]{5,}" required value="<?php echo $telcel; ?>">
            </label>
            <span class="error">* <?php echo $telcel_err; ?></span>
            <br><br>
            <label>
                Indirizzo: <input type="text" name="indirizzo" pattern="[A-Za-z0-9]{3,}" required value="<?php echo $indirizzo ?>">
            </label>
            <span class="error">* <?php echo $ind_err ?> </span>
            Civico: <label>
                <input type="text" name="civico" required pattern="[A-Za-z0-9]{1,}" value="<?php echo $civico ?>">
            </label>
            <span class="error">* <?php echo $civico_err ?> </span>
            <br><br>
            <label>
                Città: <input type="text" name="citta" pattern="[A-Za-z0-9]{3,}" required value="<?php echo $citta; ?>">
            </label>
            <span class="error">* <?php echo $citta_err; ?></span>

            <label>
                CAP: <input type="text" name="cap" pattern="[0-9]{5}" required value="<?php echo $cap; ?>">
            </label>
            <span class="error">* <?php echo $cap_err; ?></span>
            <br><br>
            
            <input class="submit" type="submit" name="submit" value="Invia">
            <input id="scarica" class="submit" type="submit" name="save" value="Invia e scarica">

        </form>
    </div>
    <style>
        .dati_anag {
            padding-left: 10px;
            position: center;
            width: 50%;
            border: 3px outset black;
            background-color: lightgray;
            text-align: left;
        }

        .submit {
            background-color: lightblue;
            width: 10em;
            height: 2em;
        }
        #scarica {
          margin-left: 20px;
        }
    </style>

<!--     <h2>Dati anagrafici inseriti</h2>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Cognome</th>
                <th>Data di nascita</th>
                <th>Luogo di nascita</th>
                <th>Codice fiscale</th>
                <th>Email</th>
                <th>Tel/Cel</th>
                <th>Indirizzo</th>
                <th>Civico</th>
                <th>Città</th>
                <th>CAP</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($json_decode_data as $lista_dati) {
                echo " <tr>
            <td>{$lista_dati[0]}</td>
            <td>{$lista_dati[1]}</td>
            <td>" . date('d-m-Y', strtotime($lista_dati[2])) . "</td>
            <td>{$lista_dati[3]}</td>
            <td>{$lista_dati[4]}</td>
            <td>{$lista_dati[5]}</td>
            <td>{$lista_dati[6]}</td>
            <td>{$lista_dati[7]}</td>
            <td>{$lista_dati[8]}</td>
            <td>{$lista_dati[9]}</td>
            <td>{$lista_dati[10]}</td>

        </tr> ";
            } ?>  

        </tbody>
    </table>

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 50%;
        }

        td,
        th {
            border: 2px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style> -->
</body>

</html>