<?php if ($flash) : ?>
    <div class="alert" id="alert">
        <?= $flash ?>
    </div>
<?php endif ?>

<script>
    setTimeout(() => {
        const element = document.getElementById("alert");
        element.parentNode.removeChild(element);
    }, 2000)
</script>
