<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
    require APPROOT . '/views/includes/navigation.php';
?>
<div class="small-container cart-page">
    <table>
        <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Role</th>
            <th>Delete</th>
        </tr>

        <?php
        foreach($data['users'] as $u){
                echo '<tr>';
                echo '<td>'; echo $u->user_first; echo '</td>';
                echo '<td>'; echo $u->user_last; echo '</td>';
                echo '<td>'; echo $u->user_email; echo '</td>';
                echo '<td>'; echo $u->user_role; echo '</td>';
                echo "<td><a onclick=\"return  confirm('do you want to delete Y/N')\"  name='delete' href="; echo URLROOT; echo  "/users/delete?action=delete&id=$u->user_id>Delete</a></td>";
                echo '</tr>';
            }    
        ?>            
    </table>
    <span class="validfeedback">
            <?php echo $data['deleted']; ?>
    </span>
    <span class="invalidfeedback">
            <?php echo $data['error']; ?>
    </span>
</div>

