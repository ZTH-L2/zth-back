
<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_user($conn, $mail, $username, $password, $permission, $restricted, $first_connexion){

/* fonction pour ajouter / creer un(e) new 'user'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/
$sql = "INSERT INTO `users`(`mail`, `username`, `password`, `permission`, `restricted`, `first_connexion`) VALUES('$mail', '$username', '$password', '$permission', '$restricted', '$first_connexion') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_user($conn, $mail, $username, $password, $permission, $restricted, $first_connexion, $id){

/* fonction pour update / modifier un(e) 'user' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `users` set `mail`='$mail', `username`='$username', `password`='$password', `permission`='$permission', `restricted`='$restricted', `first_connexion`='$first_connexion' WHERE`id_user`=$id";
return mysqli_query($conn, $sql);
}
    


function update_user_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'user' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `users` set `$parameter_name`='$parameter_value' WHERE `id_user`=$id";
return mysqli_query($conn, $sql);
}
    


function select_user($conn, $id){

/* fonction pour selectionner un(e) 'user' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'user' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `users` WHERE `id_user`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}
    

function select_all_user($conn){

/* fonction pour selectionner tous les 'user' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `users`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_user_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'user' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `users` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_user($conn, $id){

/* fonction pour supprimer un(e) 'user' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'user' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `users` WHERE `id_user`=$id";
return mysqli_query($conn, $sql);
}
?>