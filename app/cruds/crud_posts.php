<?php
//Fichier CRUD pour la base de donnees 
// CREATE
// READ
// UPDATE
// DELETE


        
        
function create_post($conn, $id_creator, $id_course, $title, $category, $date, $privacy, $published, $grade, $nb_note, $nb_report, $size, $text){

/* fonction pour ajouter / creer un(e) new 'post'
     *              entree: element de connexion
     *                      toutes les variables: valeurs des colonnes
     *              sortie: sql request
*/

$sql = "INSERT INTO `posts`(`id_creator`, `id_course`, `title`, `category`, `date`, `privacy`, `published`, `grade`, `nb_note`, `nb_report`, `size`, `text`) VALUES('$id_creator', '$id_course', '$title', '$category', '$date', '$privacy', '$published', '$grade', '$nb_note', '$nb_report', '$size', '$text') ";
return mysqli_query($conn, $sql);
}

function nbr_posts($conn){
     $sql = "SELECT MAX(`id_post`) FROM `posts`";
     if($ret=mysqli_query($conn, $sql)){
          $ret=mysqli_fetch_assoc($ret);
      }
      return $ret;
}


function update_post($conn, $id_creator, $id_course, $title, $category, $date, $privacy, $published, $grade, $nb_note, $nb_report, $text, $id){

/* fonction pour update / modifier un(e) 'post' en fonction de l'id
 *              entree: element de connexion
 *                      toutes les variables: valeurs des colonnes
 *              sortie: sql request
 */

$sql = "UPDATE `posts` set `id_creator`='$id_creator', `id_course`='$id_course', `title`='$title', `category`='$category', `date`='$date', `privacy`='$privacy', `published`='$published', `grade`='$grade', `nb_note`='$nb_note', `nb_report`='$nb_report' , `text`='$text'WHERE`id_post`=$id";
return mysqli_query($conn, $sql);
}

function update_post_user($conn, $title, $date, $privacy, $published, $text, $id){

     /* fonction pour update / modifier un(e) 'post' en fonction de l'id
      *              entree: element de connexion
      *                      toutes les variables: valeurs des colonnes
      *              sortie: sql request
      */
     
     $sql = "UPDATE `posts` set `title`='$title', `date`='$date', `privacy`='$privacy', `published`='$published', `text`='$text' WHERE`id_post`=$id";
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

function select_grade_post_a($conn, $id_post){
     $sql = "SELECT `grade`,`nb_note`  FROM `posts` WHERE `id_post`=$id_post";
     if($ret=mysqli_query($conn, $sql)){
         $ret=mysqli_fetch_assoc($ret);
     }
     return $ret;
     }
function add_grade_data($conn, $grade, $id_post){
     $sql = "UPDATE `posts` set `grade` = (`grade`*`nb_note` + '$grade') / (`nb_note` + 1), `nb_note`= `nb_note` + 1 WHERE `id_post`=$id_post";
     return mysqli_query($conn, $sql);
}
function modify_grade_data($conn, $oldgrade, $newgrade, $id_post){
     $sql = "UPDATE `posts` set `grade` = (`grade`*`nb_note` - '$oldgrade' + '$newgrade') / `nb_note` WHERE `id_post`=$id_post";
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

function select_id_creator($conn, $id){

     /* fonction pour selectionner un(e) 'post' en fonction de l'id
          *              entree: element de connexion
          *                      id: id de 'post' a recuperer
          *              sortie: element
     */
     
     $sql = "SELECT `id_creator` FROM `posts` WHERE `id_post`=$id";
     if($ret=mysqli_query($conn, $sql)){
         $ret=mysqli_fetch_assoc($ret);
     }
     return $ret;
     }
    

function select_all_post_page_amount($conn, $amount_per_page, $page){
     $offset = ($page)*$amount_per_page;
     $sql = "SELECT `id_post`, `id_creator`, `id_course`, `title`, `category`, `date`, `privacy`, `published`, `grade`, `nb_note`, `nb_report`, `size`, `text` FROM `posts` ORDER BY `id_post` LIMIT $amount_per_page OFFSET $offset";
     if ($res = mysqli_query($conn, $sql))
     {
          $res = mysqli_fetch_all($res);
     }
     return $res;
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

function select_all_post_user($conn, $id){

     /* fonction pour selectionner tous les 'post' dans la table
          *              entree: element de connexion
          *              sortie: tableau d'elements
     */
     
     $sql = "SELECT `id_post`, `id_creator`, `title`, `date`, `grade`, `nb_note` FROM `posts` WHERE `id_creator` = $id";
     $ret=mysqli_fetch_all(mysqli_query($conn, $sql));
     return $ret ;
}

function select_all_post_course($conn, $id_course, $category){

     /* fonction pour selectionner tous les 'post' dans la table
          *              entree: element de connexion
          *              sortie: tableau d'elements
     */
     
     $sql = "SELECT `id_post`, `id_creator`, `title`, `date`, `grade`, `nb_note` FROM `posts` WHERE `id_course`= $id_course AND `category`= '$category' ORDER BY `grade` DESC";
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