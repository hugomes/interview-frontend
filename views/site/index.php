<?php

use kartik\icons\Icon;

Icon::map($this, Icon::FAS); // Maps the Elusive icon font framework
/** @var yii\web\View $this */

$this->title = 'care.couch Application';
?>
<div class="site-index">

    <h2 class="title">Event</h2>
    <div class="mb-3">
        <form class="row g-3" name="EventForm" action="/site/save" method="POST">
            <div class="col-12">
                <label for="eventNameInput" class="form-label">Device</label>
                <input type="text" class="form-control" id="deviceInput" name="device">

                <label for="eventNameInput" class="form-label">Event Name</label>
                <select class="form-control" name="eventNameId" id="eventNameId">
                    <?php
                    for ($i = 0; $i < count($eventNames); $i++) {
                    ?>
                        <option <?= $eventNames[$i]['id']==4? "selected":"" ?> value="<?= $eventNames[$i]['id'] ?>"><?= $eventNames[$i]['name'] ?></option>
                    <?php
                    }
                    ?>
                </select>

                <label for="eventNameInput" class="form-label">Time</label>
                <input type="text" class="form-control" id="timeInput" name="time">
                <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />
                <input type="hidden" name="id" id="eventIdInput" value="" />
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary" id="saveButton" name="saveButton">Save</button>
            </div>
        </form>
    </div>
    <?php if ($errorMessage != "") {?>
    <div class="alert alert-info" role="alert">
        <?= $errorMessage ?>
    </div>
    <?php } ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h2 class="title">List of Events</h2>
                <table class="table table-striped">
                    <thead>
                        <tr class=" table-active">
                            <th>Device</th>
                            <th>Event</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($events); $i++) {
                        ?>
                            <tr>
                                <td><?= $events[$i]['device'] ?></td>
                                <td><?= $events[$i]['event_name'] ?></td>
                                <td><?= $events[$i]['time'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col">
                <h2 class="title">Events Ordered By Priority</h2>
                <table class="table table-striped">
                    <tbody>
                        <thead>
                            <tr class="table-active">
                                <th>Device</th>
                                <th>Event</th>
                                <th>Tasks</th>
                            </tr>
                        </thead>
                        <?php
                        $eventName = "";
                        for ($i = 0; $i < count($eventsOrdered); $i++) {
                            if ($eventName != $eventsOrdered[$i]['event_name'] and $i > 0) {
                        ?>
                            <tr>
                                <thead>
                                    <tr class="table-active">
                                        <th>Device</th>
                                        <th>Event</th>
                                        <th>Tasks</th>
                                    </tr>
                                </thead>
                            </tr>
                            <?php
                            }
                            $eventName = $eventsOrdered[$i]['event_name']
                            ?>
                            <tr>
                                <td><?= $eventsOrdered[$i]['device'] ?></td>
                                <td><?= $eventsOrdered[$i]['event_name'] ?></td>
                                <td><?= $eventsOrdered[$i]['tasks'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col">
                <h2 class="title">State of Device</h2>
                <table class="table table-striped">
                    <thead>
                        <tr class=" table-active">
                            <th scope="col">Device</th>
                            <th scope="col">Event</th>
                            <th scope="col">Tasks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 0; $i < count($lastEventDevices); $i++) {
                        ?>
                            <tr>
                                <td><?= $lastEventDevices[$i]['device'] ?></td>
                                <td><?= $lastEventDevices[$i]['event_name'] ?></td>
                                <td><?= $lastEventDevices[$i]['tasks'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function EditEventName(id, name) {
        document.getElementById("eventNameInput").value = name
        document.getElementById("eventIdInput").value = id
    }
</script>