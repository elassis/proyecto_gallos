<div class="modal_background" style="display:none;">
    <div class="modal_body" style="height:fit-content">
        <div class="modal_title_area">
            <p class="modal_title">
                <?= $modal_title; ?>
            </p>
            <p class="btn_cerrar" onclick='showModal("modal_background",false)'>X</p>
        </div>
        <div class="modal_content_body">
            <form method="post" enctype="multipart/form-data">
                <div class="modal_form_body" style="min-height:fit-content;padding:20px 0;">
                    <div class="modal_field">
                        <input type="text" id="modal_id" name="cresta_id" hidden/>
                    </div> 
                    <div class="modal_field">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="modal_nombre" name="nombre" placeholder="Nombre" required />
                    </div>    
                </div>
                <div class="modal_footer" style="padding:20px;">
                    <input type="submit" id="modal_crestas" name="modal_crestas" class="button" value="Guardar"/>
                </div>
            </form>
        </div>
    </div>
</div>