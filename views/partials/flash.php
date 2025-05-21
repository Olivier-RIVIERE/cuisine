<?php
$flash = get_flash();
if ($flash):
    $colors = [
        'success' => 'bg-green-100 text-green-800 border-green-300',
        'error' => 'bg-red-100 text-red-800 border-red-300',
        'info' => 'bg-blue-100 text-blue-800 border-blue-300',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300',
    ];
    $style = $colors[$flash['type']] ?? $colors['info'];
?>

<div data-flash class="p-4 mb-6 rounded border <?= $style ?> relative">
    <?= htmlspecialchars($flash['message']) ?>
    <button onclick="this.parentElement.remove()" class="absolute top-2 right-3 text-lg font-bold text-gray-500 hover:text-black">&times;</button>
</div>

<script>
    setTimeout(() => {
        const flash = document.querySelector('[data-flash]');
        if (flash) flash.remove();
    }, 4000);
</script>

<?php endif; ?>
