<section class="section">
    <div class="container">
        <h1 class="title"><?= e($title) ?></h1>
        <p class="subtitle">Click a user to see how URL parameters work</p>
        
        <div class="box">
            <table class="table is-fullwidth is-hoverable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= e($user['name']) ?></td>
                        <td><?= e($user['email']) ?></td>
                        <td>
                            <span class="tag <?= $user['role'] === 'Admin' ? 'is-danger' : 'is-info' ?>">
                                <?= e($user['role']) ?>
                            </span>
                        </td>
                        <td>
                            <a href="/users/<?= $user['id'] ?>" class="button is-small is-info">View</a>
                            <a href="/users/<?= $user['id'] ?>/edit" class="button is-small is-warning">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="notification is-light">
            <strong>How it works:</strong><br>
            Route pattern: <code>/users</code><br>
            Handler: <code>UserController::index()</code><br>
            No URL parameters captured.
        </div>
    </div>
</section>
