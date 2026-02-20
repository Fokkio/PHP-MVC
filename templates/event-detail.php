<?php echo TEMPLATES_DIR; ?>

<h1><?= htmlspecialchars($event->name) ?></h1>

<p><?= nl2br(htmlspecialchars($event->description)) ?></p>

<p>
    <strong>Start:</strong> <?= htmlspecialchars($event->event_start) ?><br>
    <strong>End:</strong> <?= htmlspecialchars($event->event_end) ?>
</p>

<hr>
<?php if($_SESSION['user_id'] == $event->creator_id) : ?>
    <a href="/events/<?= $event->creator_id ?>/edit">✏ Edit</a>
<?php endif; ?>
<a href="/events">⬅ Back to Events</a>
