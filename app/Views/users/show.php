<section class="section">
    <div class="container">
        <?php require BASE_PATH . '/app/Views/partials/messages.php'; ?>
        
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="/users">Users</a></li>
                <li class="is-active"><a href="#" aria-current="page"><?= e($user['name']) ?></a></li>
            </ul>
        </nav>
        
        <div class="columns">
            <div class="column is-6">
                <div class="box">
                    <h1 class="title"><?= e($user['name']) ?></h1>
                    
                    <table class="table is-fullwidth">
                        <tbody>
                            <tr>
                                <th style="width: 100px;">ID</th>
                                <td><?= $user['id'] ?></td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td><?= e($user['email']) ?></td>
                            </tr>
                            <tr>
                                <th>Role</th>
                                <td>
                                    <span class="tag <?= $user['role'] === 'Admin' ? 'is-danger' : 'is-info' ?>">
                                        <?= e($user['role']) ?>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="buttons">
                        <a href="/users/<?= $user['id'] ?>/edit" class="button is-warning">Edit User</a>
                        <a href="/users" class="button">Back to List</a>
                    </div>
                </div>
            </div>
            
            <div class="column is-6">
                <div class="box">
                    <h3 class="title is-5">🔍 How This Page Was Routed</h3>
                    
                    <table class="table is-fullwidth">
                        <tbody>
                            <tr>
                                <th>URL Requested</th>
                                <td><code>/users/<?= e($requestedId) ?></code></td>
                            </tr>
                            <tr>
                                <th>Route Pattern</th>
                                <td><code>/users/(\d+)</code></td>
                            </tr>
                            <tr>
                                <th>Regex Used</th>
                                <td><code>#^/users/(\d+)$#</code></td>
                            </tr>
                            <tr>
                                <th>Captured Parameter</th>
                                <td><code>$id = '<?= e($requestedId) ?>'</code></td>
                            </tr>
                            <tr>
                                <th>Controller Called</th>
                                <td><code>UserController::show('<?= e($requestedId) ?>')</code></td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <div class="notification is-info is-light">
                        <p><strong>The <code>(\d+)</code> pattern:</strong></p>
                        <ul>
                            <li><code>\d</code> matches any digit (0-9)</li>
                            <li><code>+</code> means "one or more"</li>
                            <li>Parentheses <code>()</code> create a "capture group"</li>
                            <li>The captured value becomes a parameter to your method</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
