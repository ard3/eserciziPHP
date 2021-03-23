<?php

/* 
 * Creare una form in cui è possibile inserire i dati anagrafici di una persona (nome, cognome, data di nascita, luogo di nascita)
 * dove tutti i campi sono obbligatori e visualizzare il risultato in una tabella apposita.
 */
 
 // database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "dati_anag";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

