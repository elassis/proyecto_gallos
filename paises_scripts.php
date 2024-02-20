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
        $(".btn_editar").click(function () {
            var data = {
                id_pais: this.id,
            }; 

            $.ajax({
                type: "POST",
                data: data,
                success: function (response) {
                    if(response.status == 200){
                        document.querySelector('#modal_id').value = response.data.id;
                        document.querySelector('#modal_nombre').value = response.data.nombre;
                        document.querySelector('#modal_paises').value = 'Actualizar';
                        
                        showModal('modal_background', true);
                    }                
                }
            });
        });
        $(".btn_eliminar").click(function () {
            var data = {
                id_pais: this.id,
            }; 
            document.querySelector('#delete_key').value = data.id_pais;
            showModal('modal_validate', true);
        });
        
        $("#agregar_pais").click(function () {
            if(this.innerHTML === 'Agregar Pais'){
                document.querySelector('#hidden_form_container').style.display="block";
                this.innerHTML = 'Cancelar';
            }else if(this.innerHTML === 'Cancelar'){
                document.querySelector('#hidden_form_container').style.display="none";
                this.innerHTML = 'Agregar Pais';
            }            
        });
    });
</script>