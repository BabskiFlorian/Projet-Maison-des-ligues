<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Collaborateur extends Authenticatable
{
    use HasFactory;

    protected $table = 'collaborateur';
    protected $primaryKey = 'id_collaborateur';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'civilite',
        'categorie',
        'telephone',
        'date_de_naissance',
        'ville',
        'pays',
        'photo',
        'est_admin',
        'mot_de_passe'
    ];

    protected $hidden = [
        'mot_de_passe',
    ];

    protected $casts = [
        'date_de_naissance' => 'date',
        'est_admin' => 'boolean', // C'est cette ligne qui est cruciale
        'mot_de_passe' => 'hashed', // Le mot de passe sera automatiquement hashé à l'assignation
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }

    /**
     * Vérifie si le collaborateur est un administrateur.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->est_admin;
    }
}