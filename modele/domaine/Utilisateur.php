<?php
class Utilisateur {
    private $id;
    private $nom;
    private $prenom;
    private $email;
    private $password;
    private $role; // Enum: 'visitor', 'editor', 'admin'

    public function getRole() {
        return $this->role;
    }
  
}
?>
