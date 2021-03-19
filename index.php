<?php
/* 
 * Creare una form in cui è possibile inserire i dati anagrafici di una persona (nome, cognome, data di nascita, luogo di nascita)
 * dove tutti i campi sono obbligatori e visualizzare il risultato in una tabella apposita.
 */
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
    $writer->save('hello world.xlsx');
    // define variables and set to empty values

    $nome=""; $cognome=""; $data_di_nascita=""; $luogo_di_nascita=""; $cf=""; $email=""; $telcel=""; $indirizzo=""; $civico=""; $citta=""; $cap="";
    $nome_err=""; $cog_err=""; $data_err=""; $luogo_err=""; $cf_err=""; $email_err=""; $telcel_err=""; $ind_err=""; $civico_err=""; $citta_err=""; $cap_err="";

    //if cycle

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        //nome
        if (empty($_POST["nome"])) {
        $nome_err = "Nome obligatorio";
    } else {
        $nome = ($_POST["nome"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)) {
            $nome_Err = "Only letters and white space allowed";
        }
    }
        //cognome
        if (empty($_POST["cognome"])) {
            $cog_err = "Cognome obligatorio";
        } else {
            $cognome = ($_POST["cognome"]);
            if (!preg_match("/^[a-zA-Z-' ]*$/",$cognome)) {
                $cog_err = "Only letters and white space allowed";
            }
        }

        //data di nascita
        if (empty($_POST["data_di_nascita"])) {
            $data_err = "Data di nascita obligatorio";
        } else {
            $data_di_nascita = ($_POST["data_di_nascita"]);
            if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$data_di_nascita)) {
                $data_Err = "Only letters and white space allowed";
            }
        }

        //luogo di nascita
        if (empty($_POST["luogo_di_nascita"])) {
            $luogo_err = "Luogo di nascita obligatorio";
        } else {
            $luogo_di_nascita = ($_POST["luogo_di_nascita"]);
            if (!preg_match("/^[a-zA-Z-0-9' ]*$/",$luogo_di_nascita)) {
                $luogo_err = "Only letters and white space allowed";
            }
        }



        if (empty($_POST["email"])) {
            $email_err = "Email is required";
        } else {
            $email = ($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email format";
            }
        }
        if (empty($_POST["indirizzo"])) {
            $ind_err = "indirizzo obligatorio";
        } else {
            $indirizzo = ($_POST["indirizzo"]);
            if (!preg_match("/^[a-zA-Z-0-9' ]*$/",$indirizzo)) {
                $ind_err= "Only letters and white space allowed";
            }
        }

        $dati = [$nome, $cognome, $data_di_nascita, $luogo_di_nascita, $email, $indirizzo];

        //get data from the existing file
        $json_get_data =  file_get_contents('lista.json');

        //converts json into an array
        $json_decode_data = json_decode($json_get_data, true);

        //push input data into array

        $json_decode_data[]= $dati;

        $json_data = json_encode($json_decode_data);
        file_put_contents('lista.json', $json_data);
    }



?>
    <div class="dati_anag" >
    <h2>Inserisci i Dati anagrafici</h2>

            <br class="form_dati" method="post">
                Nome: <label>
                    <input type="text" name="nome" value="<?php echo $nome;?>">
                </label>
                <span class="error">* <?php echo $nome_err;?></span>

                Cognome: <label>
                    <input type="text" name="cognome" value="<?php echo $cognome;?>">
                </label>
                <span class="error">* <?php echo $cog_err;?></span>
                <br><br>
                Data di nascita: <label>
                    <input type="date" name="data_di_nascita" value="<?php echo $data_di_nascita;?>">
                </label>
                <span class="error">* <?php echo $data_err;?></span>
                <br><br>
                Luogo di nascita: <label>
                    <input type="text" name="luogo_di_nascita" value="<?php echo $luogo_di_nascita;?>">
                </label>
                <span class="error">* <?php echo $luogo_err;?></span>
                <br><br>

                Codice fiscale: <label>
                    <input type="text" name="cf" value="<?php echo $cf;?>">
                </label>
                <span class="error">* <?php echo $cf_err;?></span>
                <br><br>
                Email: <label>
                    <input type="email" name="email" value="<?php echo $email ?>" >
                </label>
                <span class="error">* <?php echo $email_err ?></span>
                <br><br>
                Tel/Cel: <label>
                    <input type="text" name="telcel" value="<?php echo $telcel;?>">
                </label>
                <span class="error">* <?php echo $telcel_err;?></span>
                <br><br>
                Indirizzo: <label>
                        <input type="text" name="indirizzo" value="<?php echo $indirizzo ?>"
                </label>
                <span class="error">* <?php echo $ind_err ?> </span>
                Civico: <label>
                    <input type="text" name="civico" value="<?php echo $civico ?>"
                </label>
                <span class="error">* <?php echo $civico_err ?> </span>
                <br><br>
                Città: <label>
                        <input type="text" name="citta" value="<?php echo $citta;?>">
                </label>
                <span class="error">* <?php echo $citta_err;?></span>

                CAP:   <label>
                <input type="text" name="cap" value="<?php echo $cap;?>">
                </label>
                <span class="error">* <?php echo $cap_err;?></span>
                <br><br>
                <input class="submit" type="submit" name="submit" value="Invia">

            </form>
    </div>
    <style>
        .dati_anag{
            padding-left: 10px;
            position: center;
            width: 50%;
            border: 3px outset black ;
            background-color: lightgray;
            text-align: left ;
        }
        .submit{
            background-color: lightblue;
            width: 10em;  height: 2em;
        }

    </style>
    <!--
    <h2>Dati anagrafici inseriti</h2>
    <table>
        <thead>
        <tr >
            <th>Nome</th>
            <th>Cognome</th>
            <th>Data di nascita</th>
            <th>Luogo di nascita</th>
            <th>Email</th>
            <th>Indirizzo</th>
        </tr>
        </thead>
        <tbody>
        <?php /*foreach ($json_decode_data as $lista_dati) {
            echo " <tr>
            <td>{$lista_dati[0]}</td>
            <td>{$lista_dati[1]}</td>
            <td>". date('d-m-Y', strtotime($lista_dati[2]))."</td>
            <td>{$lista_dati[3]}</td>
            <td>{$lista_dati[4]}</td>
            <td>{$lista_dati[5]}</td>
        </tr> ";
        } */?>

        </tbody>
    </table>
-->
<!--    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 50%;
        }

        td, th {
            border: 2px solid #dddddd;
            text-align: center;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

    </style>
-->    </body>
</html>