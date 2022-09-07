<?php
use kartik\icons\Icon;
Icon::map($this, Icon::FAS); // Maps the Elusive icon font framework
/** @var yii\web\View $this */

$this->title = 'care.couch Application';
?>
<div class="site-index">

<h2 class="title">Event Name</h2>
<div class="mb-3">
    <form class="row g-3" name="EventNameForm" action="save" method="POST">
        <div class="col-12">
            <label for="eventNameInput" class="form-label">Name</label>
            <input type="text" class="form-control" id="eventNameInput" name="eventname">
            <label for="orderInput" class="form-label">Order</label>
            <input type="number" class="form-control" id="orderInput" name="order">
            <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
            <input type="hidden" name="id" id="eventIdInput" value="" />
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary" id="saveButton" name="saveButton">Save</button>
        </div>
    </form>
</div>

<h2 class="title">List of Event's Name</h2>
<table class="table table-striped">
    <thead>
        <tr>
        <th>Name</th>
        <th>Priority Order</th>
        <th>Actions</th>

        </tr>
    </thead>
    <tbody>
        <?php
        for ($i = 0; $i < count($eventNames); $i++) {
        ?>
            <tr>
                <td><?= $eventNames[$i]['name'] ?></td>
                <td><?= $eventNames[$i]['order'] ?></td>
                <td>
                    <a href="#" id="editicon" onclick="EditEventName(<?= $eventNames[$i]['id'] ?>,'<?= $eventNames[$i]['name'] ?>','<?= $eventNames[$i]['order'] ?>'); return false;"><i class="fa fa-fw fa-edit icon-primary"></i></a>
                <a href="delete?id=<?= $eventNames[$i]['id'] ?>" onclick="return confirm('Do you want delete this Event Name?')"><i class="fa fa-fw fa-trash icon-primary"></i></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>

<script>
    function EditEventName(id, name, order){
        document.getElementById("eventNameInput").value = name
        document.getElementById("orderInput").value = order
        document.getElementById("eventIdInput").value = id
    }
</script>