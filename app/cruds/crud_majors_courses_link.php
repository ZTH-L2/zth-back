<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_major_course_link($conn, $id_major, $id_course){

/* fonction pour ajouter / creer un(e) new 'major_course_link'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `majors_courses_link`(`id_major`, `id_course`) VALUES('$id_major', '$id_course') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_major_course_link($conn, $id_major, $id_course, $id){

/* fonction pour update / modifier un(e) 'major_course_link' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `majors_courses_link` set `id_major`='$id_major', `id_course`='$id_course' WHERE`id_majors_courses_link`=$id";
return mysqli_query($conn, $sql);
}
    


function update_major_course_link_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'major_course_link' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `majors_courses_link` set `$parameter_name`='$parameter_value' WHERE `id_majors_courses_link`=$id";
return mysqli_query($conn, $sql);
}
    


function select_major_course_link($conn, $id){

/* fonction pour selectionner un(e) 'major_course_link' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'major_course_link' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `majors_courses_link` WHERE `id_majors_courses_link`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}
    

function select_all_major_course_link($conn){

/* fonction pour selectionner tous les 'major_course_link' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `majors_courses_link`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}

function select_courses_major($conn, $id){

     /* fonction pour selectionner tous les 'major_course_link' dans la table
          *              entree: element de connexion
          *              sortie: tableau d'elements
     */
     
     $sql = "SELECT * FROM `majors_courses_link` WHERE `id_major` = $id";
     $ret=mysqli_fetch_all(mysqli_query($conn, $sql));
     return $ret ;
     }

function select_all_major_course_link_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'major_course_link' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `majors_courses_link` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_major_course_link($conn, $id){

/* fonction pour supprimer un(e) 'major_course_link' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'major_course_link' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `majors_courses_link` WHERE `id_majors_courses_link`=$id";
return mysqli_query($conn, $sql);
}
?>