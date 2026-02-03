<section class="section">
    <div class="container">
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="/users">Users</a></li>
                <li><a href="/users/<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></a></li>
                <li class="is-active"><a href="#" aria-current="page">Edit</a></li>
            </ul>
        </nav>
        
        <div class="columns">
            <div class="column is-6">
                <div class="box">
                    <h1 class="title">Edit: <?= htmlspecialchars($user['name']) ?></h1>
                    
                    <form method="POST" action="/users/<?= $user['id'] ?>">
                        <?= csrf_field() ?>
                        <div class="field">
                            <label class="label">Name</label>
                            <div class="control">
                                <input class="input" type="text" name="name" 
                                       value="<?= htmlspecialchars($user['name']) ?>">
                            </div>
                        </div>
                        
                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control">
                                <input class="input" type="email" name="email" 
                                       value="<?= htmlspecialchars($user['email']) ?>">
                            </div>
                        </div>
                        
                        <div class="field">
                            <label class="label">Role</label>
                            <div class="control">
                                <div class="select">
                                    <select name="role">
                                        <option value="User" <?= $user['role'] === 'User' ? 'selected' : '' ?>>User</option>
                                        <option value="Admin" <?= $user['role'] === 'Admin' ? 'selected' : '' ?>>Admin</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-primary" type="submit">Save Changes</button>
                            </div>
                            <div class="control">
                                <a href="/users/<?= $user['id'] ?>" class="button is-light">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="column is-6">
                <div class="box">
                    <h3 class="title is-5">🔍 Route Info</h3>
                    
                    <p><strong>This page:</strong> <code>GET /users/<?= $user['id'] ?>/edit</code></p>
                    <p><strong>Pattern:</strong> <code>/users/(\d+)/edit</code></p>
                    <br>
                    
                    <p><strong>Form submits to:</strong> <code>POST /users/<?= $user['id'] ?></code></p>
                    <p><strong>That pattern:</strong> <code>/users/(\d+)</code> (POST)</p>
                    <p><strong>Handler:</strong> <code>UserController::update('<?= $user['id'] ?>')</code></p>
                    
                    <div class="notification is-warning is-light mt-4">
                        <strong>Try it!</strong> Submit the form and see the JSON response.
                        The data isn't actually saved (no database), but you can see how
                        the POST request is handled.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
