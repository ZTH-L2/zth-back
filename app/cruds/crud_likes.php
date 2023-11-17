<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_like($conn, $id_user, $id_comment){

/* fonction pour ajouter / creer un(e) new 'like'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `likes`(`id_user`, `id_comment`) VALUES('$id_user', '$id_comment') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_like($conn, $id_user, $id_comment, $id){

/* fonction pour update / modifier un(e) 'like' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `likes` set `id_user`='$id_user', `id_comment`='$id_comment' WHERE`id_like`=$id";
return mysqli_query($conn, $sql);
}
    


function update_like_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'like' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `likes` set `$parameter_name`='$parameter_value' WHERE `id_like`=$id";
return mysqli_query($conn, $sql);
}
    


function select_like($conn, $id){

/* fonction pour selectionner un(e) 'like' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'like' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `likes` WHERE `id_like`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}
    

function select_all_like($conn){

/* fonction pour selectionner tous les 'like' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `likes`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_like_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'like' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `likes` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_like($conn, $id){

/* fonction pour supprimer un(e) 'like' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'like' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `likes` WHERE `id_like`=$id";
return mysqli_query($conn, $sql);
}
?>