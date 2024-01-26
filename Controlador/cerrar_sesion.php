<?php
session_start();
session_destroy();
header("Location: ../index.php");
?>
<script>
// Limpiar el historial (solo se ejecutará si JavaScript está habilitado)
window.history.replaceState({}, document.title, "/" + "<?php echo '../index.php'; ?>");
</script>
<?php
exit();
?>
