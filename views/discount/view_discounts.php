<?php
$title = 'View Discounts';
require(VIEW . 'layout/header_emp.php');
require_once(MODEL . 'database.php');
use Database as DB;

$conn = DB\Connect::db_connect();
$discs = DB\Discount::get_all_discounts($conn);
?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="success"><?php echo $_SESSION['message'];?></div>
<?php endif; ?>

<main>
<center>
    <h2>View Discounts</h2>

    <table class="discounts">
        <tr>
            <th>Discount ID</th>
            <th>Discount</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Room Type</th>
            <th>Delete?</th>
        </tr>

        <?php foreach($discs as $disc){?>
        <tr>
            <td><?php echo $disc['discount_id']?></td>
            <td><?php echo $disc['discount']?>%</td>
            <td><?php echo $disc['start_date']?></td>
            <td><?php echo $disc['end_date']?></td>
            <td>
                <?php 
                    switch($disc['type']){
                        case "S":
                            echo "Standard";
                            break;
                        case "SF":
                            echo "Standard-Family";
                            break;
                        case "D":
                            echo "Deluxe";
                            break;
                        case "DF":
                            echo "Deluxe-Family";
                            break;
                        case "SU":
                            echo "Suite";
                            break;
                        default:
                            echo 'Invalid room type.';
                    }
                ?>
            </td>
            <td>
                <a href="/delete-discount?delete_id=<?php echo $disc['discount_id'];?>"  class="btn-delete">Delete</a>
            </td>
        </tr>

        <?php }?>
    </table>
</center>
</main>

<?php
if (isset($_SESSION['message'])) {
    unset($_SESSION['message']);
}
require(VIEW . 'layout/footer.php');
?>