<?php
require_once '../modele/dao/UtilisateurDao.php';
require_once '../JWT/JwtManager.php';

// Définition de la classe de service SOAP
class UserService {
    private $utilisateurDao;
    private $jwtManager;

    public function __construct() {
        $this->utilisateurDao = new UtilisateurDao();
        $this->jwtManager = new JwtManager('b8e1f59c6e774a0c91f9d4b8a6d7e4a29cf9d4c4e8e7c6b1a8d9f9d2f8c9e2b4');
    }

    private function validateToken($token) {
        return $this->jwtManager->validateToken($token);
    }

    // Fonction pour lister tous les utilisateurs
    public function listerUtilisateurs($token) {
        if (!$this->validateToken($token)) {
            return "Accès non autorisé. Token invalide.";
        }
        return $this->utilisateurDao->getAllUtilisateurs();
    }

    // Fonction pour ajouter un utilisateur
    public function ajouterUtilisateur($token, $nom, $prenom, $email, $password, $role) {
        if (!$this->validateToken($token)) {
            return "Accès non autorisé. Token invalide.";
        }
        $this->utilisateurDao->ajouterUtilisateur($nom, $prenom, $email, $password, $role);
        return "Utilisateur ajouté avec succès.";
    }

    // Fonction pour modifier un utilisateur
    public function modifierUtilisateur($token, $id, $nom, $prenom, $email, $password, $role) {
        if (!$this->validateToken($token)) {
            return "Accès non autorisé. Token invalide.";
        }
        $this->utilisateurDao->modifierUtilisateur($id, $nom, $prenom, $email, $password, $role);
        return "Utilisateur modifié avec succès.";
    }

    // Fonction pour supprimer un utilisateur
    public function supprimerUtilisateur($token, $id) {
        if (!$this->validateToken($token)) {
            return "Accès non autorisé. Token invalide.";
        }
        $this->utilisateurDao->supprimerUtilisateur($id);
        return "Utilisateur supprimé avec succès.";
    }

    // Fonction pour authentifier un utilisateur (utilisée avant chaque méthode nécessitant un token)
    public function authentifierUtilisateur($email, $password) {
        $user = $this->utilisateurDao->getUtilisateurByEmail($email);
        if ($user && $password === $user['password']) {
            $payload = [
                "id" => $user['id'],
                "email" => $user['email'],
                "role" => $user['role'],
                "exp" => time() + 3600 // Exemple: valide pendant 1 heure
            ];
            return $this->jwtManager->createToken($payload);
        }
        return "Adresse email ou mot de passe incorrect.";
    }
}

// Configuration du service SOAP
$options = array('uri' => 'http://localhost/ProjetMouhamedDiopDic2-master/DIOPARCHI/ProjetArchiLogiciel/Soap/soap_server.php');
$server = new SoapServer(null, $options);
$server->setClass('UserService');
$server->handle();
?>
