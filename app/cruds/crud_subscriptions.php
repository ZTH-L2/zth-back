<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_subscription($conn, $id_user, $id_major, $id_year){

/* fonction pour ajouter / creer un(e) new 'subscription'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `subscriptions`(`id_user`, `id_major`, `id_year`) VALUES('$id_user', '$id_major', '$id_year') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_subscription($conn, $id_user, $id_major, $id_year, $id){

/* fonction pour update / modifier un(e) 'subscription' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `subscriptions` set `id_user`='$id_user', `id_major`='$id_major', `id_year`='$id_year' WHERE`id_subscription`=$id";
return mysqli_query($conn, $sql);
}
    


function update_subscription_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'subscription' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `subscriptions` set `$parameter_name`='$parameter_value' WHERE `id_subscription`=$id";
return mysqli_query($conn, $sql);
}
    


function select_subscription($conn, $id){

/* fonction pour selectionner un(e) 'subscription' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'subscription' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `subscriptions` WHERE `id_subscription`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}

function select_subscription_by_user($conn, $id){

     /* fonction pour selectionner un(e) 'subscription' en fonction de l'id
          *              entree: element de connexion
          *                      id: id de 'subscription' a recuperer
          *              sortie: element
     */
     
     $sql = "SELECT * FROM `subscriptions` WHERE `id_user`=$id";
     $ret=mysqli_fetch_all(mysqli_query($conn, $sql));
     return $ret;
     }

function select_all_subscription($conn){

/* fonction pour selectionner tous les 'subscription' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `subscriptions`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_subscription_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'subscription' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `subscriptions` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_subscription($conn, $id){

/* fonction pour supprimer un(e) 'subscription' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'subscription' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `subscriptions` WHERE `id_subscription`=$id";
return mysqli_query($conn, $sql);
}
?>