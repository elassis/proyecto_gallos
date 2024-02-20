<script>
     function showModal(modalName = null, value = false){
        if(value === true){
            document.querySelector(`.${modalName}`).style.display="flex";
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }else{
            document.querySelector(`.${modalName}`).style.display="none";
        }
    };

    
    $(document).ready(function () {
        $("#agregar_cresta").click(function () {
            if(this.innerHTML === 'Agregar Cresta'){
                document.querySelector('#hidden_form_container').style.display="block";
                this.innerHTML = 'Cancelar';
            }else if(this.innerHTML === 'Cancelar'){
                document.querySelector('#hidden_form_container').style.display="none";
                this.innerHTML = 'Agregar Cresta';
            }  
        });

        $(".btn_editar").click(function () {
            var data = {
                id_cresta: this.id,
            }; 
            
            $.ajax({
                type: "POST",
                data: data,
                success: function (response) {
                    if(response.status == 200){
                        document.querySelector('#modal_id').value = response.data.cresta.id;
                        document.querySelector('#modal_nombre').value = response.data.cresta.nombre;
                        document.querySelector('#modal_crestas').value = 'Actualizar';
                        
                        showModal('modal_background', true);
                    }            
                }
            });
        });

        $(".btn_eliminar").click(function () {
            var data = {
                id_cresta: this.id,
            }; 
            document.querySelector('#delete_key').value = data.id_cresta;
            showModal('modal_validate', true);
        });
      });

</script>