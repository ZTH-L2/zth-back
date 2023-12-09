<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_grade($conn, $id_user, $id_post, $grade){

/* fonction pour ajouter / creer un(e) new 'grade'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `grades`(`id_user`, `id_post`, `grade`) VALUES('$id_user', '$id_post', '$grade') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_grade($conn, $id_user, $id_post, $grade, $id){

/* fonction pour update / modifier un(e) 'grade' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `grades` set `id_user`='$id_user', `id_post`='$id_post', `grade`='$grade' WHERE`id_grade`=$id";
return mysqli_query($conn, $sql);
}
    
function modify_grade($conn, $id_user, $id_post, $grade){

     /* fonction pour update / modifier un(e) 'grade' en fonction de l'id
      *              entree: element de connexion
      *                      toutes les variables: valeurs des colonnes
      *              sortie: sql request
      */
     
     $sql = "UPDATE `grades` set `grade`='$grade' WHERE `id_post`=$id_post and `id_user`=$id_user";
     return mysqli_query($conn, $sql);
     }


function update_grade_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'grade' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `grades` set `$parameter_name`='$parameter_value' WHERE `id_grade`=$id";
return mysqli_query($conn, $sql);
}
    


function select_grade($conn, $id){

/* fonction pour selectionner un(e) 'grade' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'grade' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `grades` WHERE `id_grade`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}

function select_grade_post($conn, $id){

     /* fonction pour selectionner un(e) 'grade' en fonction de l'id
          *              entree: element de connexion
          *                      id: id de 'grade' a recuperer
          *              sortie: element
     */
     
     $sql = "SELECT AVG(`grade`) FROM `grades` WHERE `id_post`=$id";
     $res = mysqli_query($conn, $sql);
     return rs_to_tab($res);
     }
function select_grade_user_post($conn, $id_user, $id_post){

     /* fonction pour selectionner un(e) 'grade' en fonction de l'id
          *              entree: element de connexion
          *                      id: id de 'grade' a recuperer
          *              sortie: element
     */
     
     $sql = "SELECT * FROM `grades` WHERE `id_user`=$id_user and `id_post`=$id_post";
     if($ret=mysqli_query($conn, $sql)){
         $ret=mysqli_fetch_assoc($ret);
     }
     return $ret;
     }
function select_all_grade($conn){

/* fonction pour selectionner tous les 'grade' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `grades`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_grade_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'grade' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `grades` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_grade($conn, $id){

/* fonction pour supprimer un(e) 'grade' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'grade' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `grades` WHERE `id_grade`=$id";
return mysqli_query($conn, $sql);
}
?>