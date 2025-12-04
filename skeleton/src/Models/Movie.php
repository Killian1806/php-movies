<?php

namespace Models; // 1. Utilisation du namespace
 
class Movie extends Database // 2. Hériter de la classe Database
{
    private string $tableName = 'movies';

    // 3. Propriétés privées
    private $id;
    private $title;
    private $type;
    private $genre;
    private $rating;
    private  $is_watched;

    
    // 4. Implémenter le getter pour title
    public function getTitle(): ?string
    {
        return $this->title;
    }

    // Implémenter le setter pour title
    public function setTitle(string $title): self
    {
        $title = trim($title);

        // Vérifier que le titre n'est pas vide
        if (empty($title)) {
            throw new \InvalidArgumentException("Le titre ne peut pas être vide.");
        }

        // Vérifier que le titre fait moins de 255 caractères
        if (mb_strlen($title) > 255) {
            throw new \InvalidArgumentException("Le titre ne peut pas dépasser 255 caractères.");
        }

        // Protéger avec htmlspecialchars()
        $this->title = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

        return $this;
    }

    // 5. Implémenter le getter pour type
    public function getType(): ?string
    {
        return $this->type;
    }

    // Implémenter le setter pour type
    public function setType(string $type): self
    {
        $type = strtolower(trim($type));

        // Vérifier que c'est soit un film soit une série
        if ($type !== 'film' && $type !== 'serie') {
            // Lever une exception si la valeur est invalide
            throw new \InvalidArgumentException("Le type doit être 'film' ou 'serie'.");
        }

        $this->type = $type;

        return $this;
    }
    
    // 6. Implémenter le getter pour rating
    public function getRating(): ?int
    {
        return $this->rating;
    }

    // Implémenter le setter pour rating
    public function setRating(?int $rating): self
    {
        // La note peut être null
        if ($rating === null) {
            $this->rating = null;
            return $this;
        }

        // Vérifier que la note est entre 1 et 5
        if ($rating < 1 || $rating > 5) {
            throw new \InvalidArgumentException("La note (rating) doit être comprise entre 1 et 5.");
        }

        $this->rating = $rating;

        return $this;
    }

    // --- 7. Implémenter la méthode getAll() ---

    /**
     * @return array
     */
    public function getAll(): array
    {
        try {
            $sql = "SELECT * FROM {$this->tableName} ORDER BY created_at DESC";
            $stmt = $this->db->prepare($sql);
            
            $stmt->execute();
            
            // Retourne un tableau de résultats
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            error_log("Erreur lors de la récupération des films : " . $e->getMessage());
            return [];
        }
    }
}