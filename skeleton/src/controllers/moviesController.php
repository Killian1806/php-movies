<?php

// 1. Récupérer tous les films/séries
use Models\Movie;

$movie = new Movie();
$movies = $movie->getAll(); 

$error = [];
$formData = []; 

// 2. Gérer l'ajout d'un film/série via formulaire POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Récupérer les données POST
    $data = $_POST;
    $newMovie = new Movie();

    // Stocker les données dans $formData pour réaffichage en cas d'erreur
    $formData = $data;

    try {
        // Validation du Titre
        $newMovie->setTitle($data['title'] ?? '');
    } catch (\InvalidArgumentException $e) {
        $error['title'] = $e->getMessage();
    }

    try {
        // Validation du Type 
        $newMovie->setType($data['type'] ?? '');
    } catch (\InvalidArgumentException $e) {
        $error['type'] = $e->getMessage();
    }
    
    // Validation du Rating (optionnel et entre 1 et 5)
    try {
        $ratingValue = !empty($data['rating']) ? (int)$data['rating'] : null;
        $newMovie->setRating($ratingValue);
    } catch (\InvalidArgumentException $e) {
        $error['rating'] = $e->getMessage();
    }
    
    // Genre (VARCHAR, NULL) 
    if (!empty($data['genre'])) {
        $newMovie->setGenre(htmlspecialchars($data['genre'], ENT_QUOTES, 'UTF-8'));
    }

    // is_watched (BOOLEAN, DEFAULT FALSE)
    $isWatched = isset($data['is_watched']) && $data['is_watched'] === 'on';
    $newMovie->setIsWatched($isWatched);


    // Si aucune erreur : sauvegarder et rediriger
    if (empty($error)) {
        
        if ($newMovie->save()) { 
             redirectTo('/movies'); 
        } else {
             $error['global'] = 'Échec de la sauvegarde en base de données.';
        }
    }
}


// 3. Appeler la fonction render()
render('movies', false, [
    'movies' => $movies,
    'error' => $error,
    'formData' => $formData
]);