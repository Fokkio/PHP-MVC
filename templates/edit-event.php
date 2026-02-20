<h1><?= htmlspecialchars($title) ?></h1>

<form method="POST" action="/events/<?= $event->id ?>">
    <div>
        <label>Event Name:</label><br>
        <input type="text" name="name" 
               value="<?= htmlspecialchars($event->name) ?>" required>
    </div>

    <div>
        <label>Description:</label><br>
        <textarea name="description" required><?= htmlspecialchars($event->description) ?></textarea>
    </div>

    <div>
        <label>Start Date:</label><br>
        <input type="datetime-local" name="event_start"
               value="<?= date('Y-m-d\TH:i', strtotime($event->event_start)) ?>" required>
    </div>

    <div>
        <label>End Date:</label><br>
        <input type="datetime-local" name="event_end"
               value="<?= date('Y-m-d\TH:i', strtotime($event->event_end)) ?>" required>
    </div>

    <br>
    <button type="submit">Update</button>
</form>

<a href="/events/<?= $event->id ?>">Cancel</a>
