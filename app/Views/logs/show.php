<section class="section">
    <div class="container">
        <?php require BASE_PATH . '/app/Views/partials/messages.php'; ?>
        
        <nav class="breadcrumb" aria-label="breadcrumbs">
            <ul>
                <li><a href="/admin">Admin</a></li>
                <li><a href="/logs">Logs</a></li>
                <li class="is-active"><a href="#" aria-current="page">Log #<?= $log['id'] ?></a></li>
            </ul>
        </nav>
        
        <h1 class="title">📋 <?= e($title) ?></h1>
        
        <div class="box">
            <table class="table is-fullwidth">
                <tbody>
                    <tr>
                        <th style="width: 150px;">ID</th>
                        <td><?= $log['id'] ?></td>
                    </tr>
                    <tr>
                        <th>Level</th>
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
                                <?= e($log['level']) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Message</th>
                        <td><?= e($log['message']) ?></td>
                    </tr>
                    <tr>
                        <th>Timestamp</th>
                        <td><?= e($log['created_at'] ?? $log['timestamp'] ?? '') ?></td>
                    </tr>
                    <tr>
                        <th>Context</th>
                        <td>
                            <?php if (!empty($log['context'])): ?>
                                <pre><?= e(json_encode($log['context'], JSON_PRETTY_PRINT)) ?></pre>
                            <?php else: ?>
                                <span class="has-text-grey">(none)</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <a href="/logs" class="button">← Back to Logs</a>
    </div>
</section>