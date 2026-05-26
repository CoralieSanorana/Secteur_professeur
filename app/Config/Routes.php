<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::directeur_dashboard');
    $routes->get('actualites', 'Home::actualites');
    $routes->get('notifications', 'Home::notifications');

$routes->group('directeur', function($routes) {
    $routes->get('dashboard', 'Home::directeur_dashboard');
    $routes->get('ecolages', 'Home::ecolages');
    $routes->get('finance', 'Home::finance');
    $routes->get('professeurs', 'Home::professeurs');
    $routes->get('profil_prof', 'Home::profil_prof');
});

$routes->group('secretariat', function($routes) {
    $routes->get('bilan', 'Home::bilan');
    $routes->get('eleves', 'Home::eleves');
    $routes->get('paiement', 'Home::paiement');
    $routes->get('profil_eleve', 'Home::profil_eleve');
});

$routes->group('professeur', function($routes) {
    $routes->get('bulletin', 'Home::bulletin_prof');
    $routes->get('calendar', 'Home::calendar_prof');
    $routes->get('notes', 'Home::notes_prof');
    $routes->get('profil', 'Home::profil');
    $routes->get('devoirs', 'Home::devoirs_prof');
});

$routes->group('etudiant', function($routes) {
    $routes->get('bulletin', 'Home::bulletin_etudiants');
    $routes->get('calendar', 'Home::calendar_etudiants');
    $routes->get('notes', 'Home::notes_etudiants');
    $routes->get('devoirs', 'Home::devoirs_etudiants');
});