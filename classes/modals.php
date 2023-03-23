<?php

class BootstrapModal
{

    private $id;
    private $icon;
    private $title;
    private $body;
    private $footer;

    public function __construct($id, $title, $body, $footer = null, $icon = null)
    {
        $this->id = $id;
        $this->icon = $icon;
        $this->title = $title;
        $this->body = $body;
        $this->footer = $footer;
    }

    public function render()
    {
?>
        <div class="modal fade" id="<?php echo $this->id; ?>" tabindex="-1" aria-labelledby="<?php echo $this->id; ?>Label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="<?php echo $this->id; ?>Label"><?php echo $this->title; ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row text-center">
                            <?php if ($this->icon !== null) {
                                switch ($this->icon) {
                                    case 'success':
                                        echo '<i class="fa-solid fa-square-check text-success fa-5x"></i>';
                                        break;
                                    case 'error':
                                        echo '<i class="fa-solid fa-circle-exclamation text-danger fa-5x"></i>';
                                        break;
                                }
                            }
                            ?>
                        </div>
                        <div class="row text-center">
                            <?php echo $this->body; ?>
                        </div>
                    </div>
                    <?php if ($this->footer !== null) { ?>
                        <div class="modal-footer">
                            <?php echo $this->footer; ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
<?php
    }
}

?>