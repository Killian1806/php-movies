<?php ob_start() ?>

<h1>Ma Collection</h1>

<section class="add-movie">
    <h2>Ajouter un nouveau titre</h2>

    <form action="/movies" method="POST" class="add-form">
        
        <?php if (!empty($error['global'])): ?>
            <p class="error-message global-error">
                Echec de l'opération : <?= htmlspecialchars($error['global']) ?>
            </p>
        <?php endif; ?>

        <div class="form-group">
            <label for="title">Titre :</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                value="<?= htmlspecialchars($formData['title'] ?? '') ?>" 
                required
            >
            <?php if (!empty($error['title'])): ?>
                <small class="error-message"><?= htmlspecialchars($error['title']) ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="type">Type :</label>
            <select id="type" name="type" required>
                <option value="">-- Choisir --</option>
                <?php $selectedType = $formData['type'] ?? ''; ?>
                <option value="film" <?= ($selectedType === 'film') ? 'selected' : '' ?>>Film</option>
                <option value="serie" <?= ($selectedType === 'serie') ? 'selected' : '' ?>>Série</option>
            </select>
            <?php if (!empty($error['type'])): ?>
                <small class="error-message"><?= htmlspecialchars($error['type']) ?></small>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="genre">Genre (Optionnel) :</label>
            <input 
                type="text" 
                id="genre" 
                name="genre" 
                value="<?= htmlspecialchars($formData['genre'] ?? '') ?>"
            >
        </div>

        <div class="form-group">
            <label for="rating">Note (1-5, Optionnel) :</label>
            <input 
                type="number" 
                id="rating" 
                name="rating" 
                min="1" 
                max="5" 
                value="<?= htmlspecialchars($formData['rating'] ?? '') ?>"
            >
            <?php if (!empty($error['rating'])): ?>
                <small class="error-message"><?= htmlspecialchars($error['rating']) ?></small>
            <?php endif; ?>
        </div>
        
        <div class="form-group checkbox-group">
            <input 
                type="checkbox" 
                id="is_watched" 
                name="is_watched" 
                <?= isset($formData['is_watched']) ? 'checked' : '' ?>
            >
            <label for="is_watched">Marquer comme vu</label>
        </div>
        
        <button type="submit">Ajouter</button>
    </form>
</section>

<hr>

<section class="movie-list">
    <h2>Liste de ma collection</h2>

    <?php if (empty($movies)): ?>
        <p>Votre collection est vide. Ajoutez un nouveau titre ci-dessus.</p>
    <?php else: ?>
        <ul class="titles-list">
            <?php foreach ($movies as $movie): ?>
                <li class="movie-item">
                    <span class="movie-status <?= $movie['is_watched'] ? 'watched' : 'unwatched' ?>">
                        [<?= $movie['is_watched'] ? 'Vu' : 'A voir' ?>]
                    </span>
                    
                    <strong class="movie-title"><?= htmlspecialchars($movie['title']) ?></strong>
                    
                    <span class="movie-meta">
                        (<?= ucfirst(htmlspecialchars($movie['type'])) ?>
                        <?php if (!empty($movie['genre'])): ?>
                            | Genre : <?= htmlspecialchars($movie['genre']) ?>
                        <?php endif; ?>
                        <?php if (!empty($movie['rating'])): ?>
                            | Note : <?= str_repeat('*', $movie['rating']) ?> (<?= $movie['rating'] ?>/5)
                        <?php endif; ?>)
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>


<?php
render('default', true, [
	'title' => 'Ma Collection',
	'css' => 'movies',
	'content' => ob_get_clean(),
]);
?>