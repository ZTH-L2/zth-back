<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_major($conn, $name){

/* fonction pour ajouter / creer un(e) new 'major'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `majors`(`name`) VALUES('$name') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_major($conn, $name, $id){

/* fonction pour update / modifier un(e) 'major' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `majors` set `name`='$name' WHERE`id_major`=$id";
return mysqli_query($conn, $sql);
}
    


function update_major_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'major' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `majors` set `$parameter_name`='$parameter_value' WHERE `id_major`=$id";
return mysqli_query($conn, $sql);
}
    


function select_major($conn, $id){

/* fonction pour selectionner un(e) 'major' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'major' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `majors` WHERE `id_major`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}
    

function select_all_major($conn){

/* fonction pour selectionner tous les 'major' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `majors`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_major_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'major' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `majors` WHERE `$parameter_name`='$parameter_value'";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_major($conn, $id){

/* fonction pour supprimer un(e) 'major' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'major' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `majors` WHERE `id_major`=$id";
return mysqli_query($conn, $sql);
}
?>