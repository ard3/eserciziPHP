#!/usr/bin/php -q
<?php
/**
 * Questo e' uno script di shell per LINUX.
 * Assicurarsi di disporre del DB dei codici catastali
 * altrimenti questo script non funzionera'.
 *
 * Esempio:
 * ./codice.php Mario Rossi 13-02-1972 M Milano MI
 *
 */
error_reporting(E_ALL &~ E_NOTICE);
require_once 'codicefiscale.class.php';

$nome    = @$argv[1];
$cognome = @$argv[2];
$data    = @$argv[3];
$sesso   = @$argv[4];
$comune  = @$argv[5];
$prov    = @$argv[6];

if ($argc < 7) {
    printf("%s <nome> <cognome> <data_nascita> <sesso> <comune> <sigla_provincia>\n", $argv[0]);
    exit(1);
}

$cf = new codicefiscale();
$cf->setDatabase('catastali.db')
   ->setDateSeparator('-');

$codice = $cf->calcola($nome, $cognome, $data, $sesso, $comune, $prov);

if ($cf->hasError()) {
print "ERRORE: " . $cf->getError() . "\n";
exit(1);
}

printf( "=====================================\n".
" Nome:          %s\n" .
" Cognome:       %s\n" .
" Data nascita:  %s\n".
" Sesso:         %s\n".
" Comune:        %s (%s)\n\n".
" %s\n\n".
"=====================================\n",
ucfirst(strtolower($nome)), ucfirst(strtolower($cognome)), $data,
strtoupper($sesso), ucfirst(strtolower($comune)), strtoupper($prov),
$codice);
