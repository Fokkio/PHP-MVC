<h1><?= htmlspecialchars($title) ?></h1>

<form method="POST" action="/events">
    <div>
        <label>Event Name:</label><br>
        <input type="text" name="name" required>
    </div>

    <div>
        <label>Description:</label><br>
        <textarea name="description" required></textarea>
    </div>

    <div>
        <label>Start Date:</label><br>
        <input type="datetime-local" name="event_start" required>
    </div>

    <div>
        <label>End Date:</label><br>
        <input type="datetime-local" name="event_end" required>
    </div>

    <br>
    <button type="submit">Create</button>
</form>

<a href="/events">Cancel</a>
