<?php
$options = array(
    'location' => 'http://localhost/ProjetMouhamedDiopDic2-master/DIOPARCHI/ProjetArchiLogiciel/Soap/soap_server.php',
    'uri'      => 'http://localhost/ProjetMouhamedDiopDic2-master/DIOPARCHI/ProjetArchiLogiciel/Soap/soap_server.php',
    'trace'    => 1
);

try {
    // Création du client SOAP
    $client = new SoapClient(null, $options);

    // Authentification pour obtenir un token
    $email = 'paul.durand@example.com';
    $password = 'password789';
    $token = $client->authentifierUtilisateur($email, $password);
    echo "Token généré : $token<br>";

    // Liste des utilisateurs (exemple)
    echo "Liste des utilisateurs : <br>";
    $utilisateurs = $client->listerUtilisateurs($token);
    print_r($utilisateurs);
    echo "<br>";

    // Ajout d'un utilisateur (exemple)
    echo "Ajout d'un nouvel utilisateur : <br>";
    $nom = 'Nouveau';
    $prenom = 'Utilisateur';
    $email = 'nouveau@example.com';
    $password = 'nouveau_password';
    $role = 'editor'; // Exemple de rôle
    $result = $client->ajouterUtilisateur($token, $nom, $prenom, $email, $password, $role);
    echo "Résultat : $result<br>";

    // Modification d'un utilisateur (exemple)
    echo "Modification d'un utilisateur : <br>";
    $id = 1; // ID de l'utilisateur à modifier
    $nom = 'Utilisateur';
    $prenom = 'Modifié';
    $email = 'modifie@example.com';
    $password = 'modifie_password';
    $role = 'admin'; // Nouveau rôle
    $result = $client->modifierUtilisateur($token, $id, $nom, $prenom, $email, $password, $role);
    echo "Résultat : $result<br>";

    // Suppression d'un utilisateur (exemple)
    echo "Suppression d'un utilisateur : <br>";
    $idToDelete = 2; // ID de l'utilisateur à supprimer
    $result = $client->supprimerUtilisateur($token, $idToDelete);
    echo "Résultat : $result<br>";

} catch (SoapFault $e) {
    echo "Erreur SOAP : " . $e->getMessage();
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
