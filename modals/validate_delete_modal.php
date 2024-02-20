<div class="modal_background modal_validate" style="display:none;">
    <div class="modal_body"  style="height:fit-content">
        <div class="modal_title_area">
            <p class="modal_title"><?= $deleteTitle ?></p>
            <p class="btn_cerrar" onclick='showModal("modal_validate",false);'>X</p>
        </div>
        <div class="modal_content_body"  style="height:fit-content">
            <form method="post" enctype="multipart/form-data">
            <div class="modal_form_body"  style="height:fit-content">
                <p><?= $deleteText ?></p>
                <div class="modal_field">
                    <input id="delete_key" name="delete_key" style="pointer-events:none;"/>
                </div>
            </div>
            <div class="modal_footer">
                <input type="submit" class="button" name="delete_button" value="confirmar" />
            </div>
            </form>
        </div>
    </div>
</div>