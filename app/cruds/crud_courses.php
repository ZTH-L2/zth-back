<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_course($conn, $name){

/* fonction pour ajouter / creer un(e) new 'course'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `courses`(`name`) VALUES('$name') ";
return mysqli_query($conn, $sql);
}
    
function select_max($conn){
     $sql = "SELECT MAX(`id_course`) FROM `courses`";
     if($ret=mysqli_query($conn, $sql)){
          $ret=mysqli_fetch_assoc($ret);
      }
      return $ret;
      }
        
function update_course($conn, $name, $id){

/* fonction pour update / modifier un(e) 'course' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `courses` set `name`='$name' WHERE`id_course`=$id";
return mysqli_query($conn, $sql);
}
    


function update_course_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'course' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `courses` set `$parameter_name`='$parameter_value' WHERE `id_course`=$id";
return mysqli_query($conn, $sql);
}
    


function select_course($conn, $id){

/* fonction pour selectionner un(e) 'course' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'course' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `courses` WHERE `id_course`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}

function select_coursename($conn, $id){
     $sql = "SELECT `name` FROM `courses` WHERE `id_course`=$id";
     if($ret=mysqli_query($conn, $sql)){
          $ret=mysqli_fetch_assoc($ret);
     }
     return $ret;
}

function select_all_course($conn){

/* fonction pour selectionner tous les 'course' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `courses`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_course_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'course' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `courses` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_course($conn, $id){

/* fonction pour supprimer un(e) 'course' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'course' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `courses` WHERE `id_course`=$id";
return mysqli_query($conn, $sql);
}
?>