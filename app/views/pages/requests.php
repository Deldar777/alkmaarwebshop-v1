<?php
require APPROOT . '/views/includes/head.php';
?>

<?php
require APPROOT . '/views/includes/navigation.php';
?>
<div class="small-container cart-page">
    <table>
        <tr>
            <th>Request Number</th>
            <th>Full Name</th>
            <th>Telephone Number</th>
            <th>Email</th>
            <th>Request</th>
            <th>Status</th>
        </tr>

        <?php
        foreach($data['requests'] as $r){
                echo '<tr>';
                echo '<td>'; echo $r->request_id; echo '</td>';
                echo '<td>'; echo $r->fullname; echo '</td>';
                echo '<td>'; echo $r->phone_number; echo '</td>';
                echo '<td>'; echo $r->email; echo '</td>';
                echo '<td>'; echo $r->message; echo '</td>';

                if($r->handled == 0){
                    echo "<td><a onclick=\"return  confirm('do you want to change the status Y/N')\"  name='update' href="; echo URLROOT; echo  "/pages/updateStatus?action=update&id=$r->request_id><span class='invalidfeedback'>Unhandled</span></a></td>";
                    echo '</tr>'; 
                }else{
                    echo "<td class='validfeedback'>Handled</td>";
                    echo '</tr>';
                }
                
            }    
        ?>            
    </table>
</div>