<?php 
require_once('../config/link.php');
$dir='pages/';
if(!empty($_POST['title'])&&!empty($_POST['link'])){
    $title=$_POST['title'];
    $link=$_POST['link'];

    $filename=pathinfo($link,PATHINFO_FILENAME);
    $filename=strtolower(str_replace(' ','_',$filename)).'.php';
    $filename=$dir.$filename;
    $filecontent="<?php\nrequire_once('../config/link.php');\nrequire_once('../templace/header.php');\n?>\n<h1>".$title."</h1>\n<?php\nrequire_once('../templace/footer.php');\n?>";
    file_put_contents($filename,$filecontent);

    $stmt = $linkBase->prepare("INSERT INTO menu (title, link, sort_order) SELECT ?, ?, (SELECT COALESCE(MAX(sort_order), 0) + 1 FROM menu)");
    $stmt->bind_param("ss",$title,$filename);
    if($stmt->execute()){
        header("Location: ../templace/admin.php");
        exit;
    } else {
        echo "Ошибка при создании пункта меню: ".$stmt->error;
    }
    $stmt->close();
}

if(isset($_POST['deleteButton'])){
    $deleteIds=array_filter($_POST['checkboxes'],function($value){
        return $value;
    });
    if(!empty($deleteIds)){
        $deleteIdsStr=implode(',',array_keys($deleteIds));
        $query_select="SELECT title FROM `menu` WHERE id IN ($deleteIdsStr)"; 
        $result_select=$linkBase->query($query_select);

        if ($result_select) {
            while($row=$result_select->fetch_assoc()){
                $title=$row['title'];
                $filename=strtolower(str_replace(' ','_',$title)).'.php';
                $filePath = $dir.$filename; 
            
                if(file_exists($filePath)){
                    unlink($filePath);
                } 
            }
            $delete_query="DELETE FROM `menu` WHERE id IN ($deleteIdsStr)"; 
            if(mysqli_query($linkBase,$delete_query)){
                header("Location: ../templace/admin.php");
                exit();
            }
            else{
                echo "Ошибка удаления записей: ".mysqli_error($linkBase);
            }
        } 
    }
}

if (isset($_POST['saveButton'])) {
    $query_update = "SELECT * FROM menu";
    $result_update = $linkBase->query($query_update);

    while ($row = $result_update->fetch_assoc()) {
        $id = $row['id'];
        $title_get = $row['title'];
        $link_get = $row['link'];


        if (isset($_POST['title_get'][$id]) && isset($_POST['link_get'][$id])) {
            $title_ins = $_POST['title_get'][$id];
            $link_ins = $_POST['link_get'][$id];

            if ($title_get != $title_ins || $link_get != $link_ins) {


                $new_link_filename = pathinfo($link_ins, PATHINFO_FILENAME);
                $new_link_filename = strtolower(str_replace(' ', '_', $new_link_filename)) . '.php';


                $old_filename = strtolower(str_replace(' ', '_', $title_get)) . '.php';


                $full_old_filename = $dir . $old_filename;  
                $full_new_link_filename = $dir . $new_link_filename; 


                $filecontent = "<?php\nrequire_once('../config/link.php');\n" .
                    "require_once('../templace/header.php');\n?>\n" .
                    "<h1>" . htmlspecialchars($title_ins) . "</h1>\n" .
                    "<?php\nrequire_once('../templace/footer.php');\n?>";

                file_put_contents($full_new_link_filename, $filecontent);
                    

                    if (file_exists($full_old_filename) && $full_old_filename != $full_new_link_filename) {
                        unlink($full_old_filename);
                    }


                    $stmt = $linkBase->prepare("UPDATE `menu` SET `title` = ?, `link`=? WHERE id=?");
                    $stmt->bind_param("ssi", $title_ins, $full_new_link_filename, $id);

                    if ($stmt->execute()) {
                        header('Location: ../templace/admin.php');
                        exit();
                    } else {
                        echo 'Ошибка при обновлении данных: ' . $stmt->error;
                    }
                    $stmt->close();

                
            }
        }
    }
}

if (isset($_POST['reordered_ids'])) {
    $ids = explode(",", $_POST['reordered_ids']);
    foreach ($ids as $i => $id) {
        $sort_order = $i + 1;
        $stmt = $linkBase->prepare("UPDATE menu SET sort_order = ? WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("ii", $sort_order, $id);
            if ($stmt->execute()) {
                header('Location: ../templace/admin.php');
                
            }
            else{
                echo "Ошибка обновления сортировки для ID $id: " . $stmt->error;
            }
            $stmt->close();
        }
    }
    exit;
}
?>













