
<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_comment($conn, $id_post, $id_user, $id_parent_comment, $nb_like, $nb_report){

/* fonction pour ajouter / creer un(e) new 'comment'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `comments`(`id_post`, `id_user`, `id_parent_comment`, `nb_like`, `nb_report`) VALUES('$id_post', '$id_user', '$id_parent_comment', '$nb_like', '$nb_report') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_comment($conn, $id_post, $id_user, $id_parent_comment, $nb_like, $nb_report, $id){

/* fonction pour update / modifier un(e) 'comment' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `comments` set `id_post`='$id_post', `id_user`='$id_user', `id_parent_comment`='$id_parent_comment', `nb_like`='$nb_like', `nb_report`='$nb_report' WHERE`id_comment`=$id";
return mysqli_query($conn, $sql);
}
    


function update_comment_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'comment' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `comments` set `$parameter_name`='$parameter_value' WHERE `id_comment`=$id";
return mysqli_query($conn, $sql);
}
    


function select_comment($conn, $id){

/* fonction pour selectionner un(e) 'comment' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'comment' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `comments` WHERE `id_comment`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}
    


function select_all_comment($conn){

/* fonction pour selectionner tous les 'comment' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `comments`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}

    

function select_all_comment_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'comment' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `comments` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_comment($conn, $id){

/* fonction pour supprimer un(e) 'comment' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'comment' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `comments` WHERE `id_comment`=$id";
return mysqli_query($conn, $sql);
}
?>