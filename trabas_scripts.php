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
        $("#agregar_traba").click(function () {
            if(this.innerHTML === 'Agregar Traba'){
                document.querySelector('#hidden_form_container').style.display="block";
                this.innerHTML = 'Cancelar';
            }else if(this.innerHTML === 'Cancelar'){
                document.querySelector('#hidden_form_container').style.display="none";
                this.innerHTML = 'Agregar Traba';
            }  
        });

        $(".btn_editar").click(function () {
            var data = {
                id_traba: this.id,
            }; 
            
            $.ajax({
                type: "POST",
                data: data,
                success: function (response) {
                    if(response.status == 200){
                        document.querySelector('#modal_id').value = response.data.traba.id;
                        document.querySelector('#modal_nombre').value = response.data.traba.nombre;
                        document.querySelector('#modal_ciudad').value = response.data.traba.ciudad;
                        document.querySelector('#default_option').value = response.data.pais.id;
                        document.querySelector('#default_option').innerHTML = response.data.pais.nombre;
                        document.querySelector('#modal_trabas').value = 'Actualizar';
                        
                        showModal('modal_background', true);
                    }            
                }
            });
        });

        $(".btn_eliminar").click(function () {
            var data = {
                id_traba: this.id,
            }; 
            document.querySelector('#delete_key').value = data.id_traba;
            showModal('modal_validate', true);
        });
      });

</script>