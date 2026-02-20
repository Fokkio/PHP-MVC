<?php include 'header.php' ?>
<h3>Hello <?= htmlspecialchars($_SESSION['username'] ?? 'Guest') ?></h3>
<a href="/events/create" style="display:inline-block;margin-bottom:15px;">
    ➕ Create Event
</a>

<?php if (empty($events)) : ?>
    <p>No events found.</p>
<?php else : ?>
    <ul>
        <?php foreach ($events as $event) : ?>
            <li style="margin-bottom:10px;">
                <strong>
                    <a href="/events/<?= $event->id ?>">
                        <?= htmlspecialchars($event->name) ?>
                    </a>
                </strong>
                <br>
                <small>
                    <?= htmlspecialchars($event->event_start) ?> 
                    - 
                    <?= htmlspecialchars($event->event_end) ?>
                    <div>
                        Created by: <?= htmlspecialchars($event->creator_name) ?>
                    </div>
                </small>
                
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php include 'footer.php' ?>
