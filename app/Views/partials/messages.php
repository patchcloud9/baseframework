<?php
// Get flash message if any
$flash = $_SESSION['flash'] ?? null;
if ($flash) {
    unset($_SESSION['flash']);
    
    // Map our flash types to Bulma notification classes
    $typeClasses = [
        'success' => 'is-success',
        'error'   => 'is-danger',
        'warning' => 'is-warning',
        'info'    => 'is-info',
    ];
    
    $bulmaClass = $typeClasses[$flash['type']] ?? 'is-info';
?>
<div class="container mt-4">
    <div class="notification <?= $bulmaClass ?>">
        <button class="delete" onclick="this.parentElement.remove()"></button>
        <?= htmlspecialchars($flash['message']) ?>
    </div>
</div>
<?php } ?>
