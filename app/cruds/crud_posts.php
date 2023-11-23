<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_post($conn, $id_creator, $id_course, $title, $category, $date, $privacy, $published, $grade, $nb_note, $nb_report){

/* fonction pour ajouter / creer un(e) new 'post'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `posts`(`id_creator`, `id_course`, `title`, `category`, `date`, `privacy`, `published`, `grade`, `nb_note`, `nb_report`) VALUES('$id_creator', '$id_course', '$title', '$category', '$date', '$privacy', '$published', '$grade', '$nb_note', '$nb_report') ";
return mysqli_query($conn, $sql);
}
    
        
        
function update_post($conn, $id_creator, $id_course, $title, $category, $date, $privacy, $published, $grade, $nb_note, $nb_report, $id){

/* fonction pour update / modifier un(e) 'post' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `posts` set `id_creator`='$id_creator', `id_course`='$id_course', `title`='$title', `category`='$category', `date`='$date', `privacy`='$privacy', `published`='$published', `grade`='$grade', `nb_note`='$nb_note', `nb_report`='$nb_report' WHERE`id_post`=$id";
return mysqli_query($conn, $sql);
}

function update_post_user($conn, $title, $date, $privacy, $published, $id){

     /* fonction pour update / modifier un(e) 'post' en fonction de l'id
      *              entree: element de connexion
      *                      toutes les variables: valeurs des colonnes
      *              sortie: sql request
      */
     
     $sql = "UPDATE `posts` set `title`='$title', `date`='$date', `privacy`='$privacy', `published`='$published' WHERE`id_post`=$id";
     return mysqli_query($conn, $sql);
     }


function update_post_with_parameter($conn, $parameter_name, $parameter_value, $id){

/* fonction pour update / modifier un(e) 'post' en fonction d'un parametre
 *              entree: element de connexion
 *                      $parameter_name: nom du parametre a modifier
                        $parameter_value: valeur du parametre a modifier
 *              sortie: sql request
 */

$sql = "UPDATE `posts` set `$parameter_name`='$parameter_value' WHERE `id_post`=$id";
return mysqli_query($conn, $sql);
}
    


function select_post($conn, $id){

/* fonction pour selectionner un(e) 'post' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'post' a recuperer
     *              sortie: element
*/

$sql = "SELECT * FROM `posts` WHERE `id_post`=$id";
if($ret=mysqli_query($conn, $sql)){
    $ret=mysqli_fetch_assoc($ret);
}
return $ret;
}
    

function select_all_post($conn){

/* fonction pour selectionner tous les 'post' dans la table
     *              entree: element de connexion
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `posts`";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    

function select_all_post_with_parameter($conn, $parameter_name, $parameter_value){

/* fonction pour selectionner tous les 'post' dans la table en fonction d'un parametre
     *              entree: element de connexion
                            $parameter_name: nom de la colonne a utiliser pour la selection
                            $parameter_value: valeur que dans la colonne pour que la ligne soit selectionnee
     *              sortie: tableau d'elements
*/

$sql = "SELECT * FROM `posts` WHERE `$parameter_name`=$parameter_value";
$ret=mysqli_fetch_all(mysqli_query($conn, $sql));
return $ret ;
}
    


function delete_post($conn, $id){

/* fonction pour supprimer un(e) 'post' en fonction de l'id
     *              entree: element de connexion
     *                      id: id de 'post' a supprimer
     *              sortie: sql request
*/

$sql = "DELETE FROM `posts` WHERE `id_post`=$id";
return mysqli_query($conn, $sql);
}
?>