<?php

$myModal = new BootstrapModal('myModal', 'Modal Title', 'Modal Body Text', null, "success");

// Render the modal
$myModal->render();

?>

<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
  Launch demo modal
</button>

