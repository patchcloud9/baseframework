<section class="section">
    <div class="container">
        <div class="level">
            <div class="level-left">
                <h1 class="title">📋 <?= htmlspecialchars($title) ?></h1>
            </div>
            <div class="level-right">
                <div class="buttons">
                    <a href="/logs/test" class="button is-info">Add Test Log</a>
                    <form method="POST" action="/logs/clear" style="display: inline;">
                        <button type="submit" class="button is-danger" 
                                onclick="return confirm('Clear all logs?')">
                            Clear Logs
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <?php if (empty($logs)): ?>
            <div class="notification is-info is-light">
                No log entries yet. <a href="/logs/test">Add a test entry</a> to see how it works.
            </div>
        <?php else: ?>
            <div class="box">
                <table class="table is-fullwidth is-hoverable">
                    <thead>
                        <tr>
                            <th style="width: 60px;">ID</th>
                            <th style="width: 100px;">Level</th>
                            <th>Message</th>
                            <th style="width: 160px;">Timestamp</th>
                            <th style="width: 80px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($logs as $log): ?>
                        <tr>
                            <td><?= $log['id'] ?></td>
                            <td>
                                <?php
                                $levelColors = [
                                    'info'    => 'is-info',
                                    'warning' => 'is-warning',
                                    'error'   => 'is-danger',
                                    'debug'   => 'is-dark',
                                ];
                                $color = $levelColors[$log['level']] ?? 'is-light';
                                ?>
                                <span class="tag <?= $color ?>">
                                    <?= htmlspecialchars($log['level']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($log['message']) ?></td>
                            <td>
                                <small><?= htmlspecialchars($log['timestamp']) ?></small>
                            </td>
                            <td>
                                <a href="/logs/<?= $log['id'] ?>" class="button is-small">
                                    View
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <p class="has-text-grey">
                Showing <?= count($logs) ?> log entries
            </p>
        <?php endif; ?>
    </div>
</section>